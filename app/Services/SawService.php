<?php

namespace App\Services;

use DateTime;
use InvalidArgumentException;

/**
 * SawService
 * 
 * Isolated Service for Simple Additive Weighting (SAW) method calculation
 * and project performance criteria evaluation.
 * Does not depend directly on database connections to allow pure unit testing.
 */
class SawService
{
    /**
     * Calculate individual raw criterion values (Xij) from raw project inputs.
     *
     * @param array $rawItem
     * @return array [C1, C2, C3, C4, C5]
     */
    public function calculateCriteriaValues(array $rawItem): array
    {
        // C1: Mutu & Kualitas Hasil Fisik (Benefit) = Skor 1 s.d. 5
        $c1 = (float)($rawItem['progres_aktual'] ?? 5);

        // C2: Biaya terhadap RAB (Cost) = (biaya_realisasi / nilai_rab) * 100
        $nilaiRab       = (float)($rawItem['nilai_rab'] ?? 1);
        $biayaRealisasi = (float)($rawItem['biaya_realisasi'] ?? 0);
        $c2 = ($nilaiRab > 0) ? ($biayaRealisasi / $nilaiRab) * 100 : 0.0;

        // C3: Dokumentasi Foto Progres Lapangan (Benefit) = Skor 1 s.d. 5
        $c3 = (float)($rawItem['skor_foto_progres'] ?? 1);

        // C4: Ketepatan Serah Terima (Benefit) = Skor BAST 1 s.d. 5 dari rubrik
        $c4 = (float)($rawItem['skor_bast'] ?? 1);

        // C5: Waktu / Durasi Penyelesaian Proyek (Cost) = durasi hari dari tanggal mulai sampai selesai
        if (!empty($rawItem['tanggal_mulai']) && !empty($rawItem['tanggal_selesai_aktual'])) {
            $c5 = (float)$this->calculateC5Duration(
                $rawItem['tanggal_mulai'],
                $rawItem['tanggal_selesai_aktual']
            );
        } else {
            $c5 = (float)$this->calculateC5Delay(
                $rawItem['tanggal_selesai_rencana'] ?? '',
                $rawItem['tanggal_selesai_aktual'] ?? ''
            );
        }

        // C6: Tingkat Kepuasan Klien (Benefit) = Skor 1 s.d. 5
        $c6 = (float)($rawItem['skor_kepuasan_klien'] ?? 5);

        // C7: Penerapan K3 & Keselamatan Kerja (Benefit) = Skor 1 s.d. 5
        $c7 = (float)($rawItem['skor_k3'] ?? 5);

        return [
            'C1' => round($c1, 4),
            'C2' => round($c2, 4),
            'C3' => round($c3, 4),
            'C4' => round($c4, 4),
            'C5' => round($c5, 4),
            'C6' => round($c6, 4),
            'C7' => round($c7, 4),
        ];
    }

    /**
     * Aturan skor C3 (Kelengkapan Dokumen Kontrak Konstruksi: SPK/SP dan Kontrak/PKS):
     * Lengkap = 2, Sebagian = 1, Tidak ada = 0
     * Total poin: 0 - 4
     * Skor = 1 + Total Poin (Skala 1 s.d. 5)
     */
    public function calculateC3Score(string $sp, string $pks, ?string $ppjb = null): int
    {
        $points = [
            'Lengkap'   => 2,
            'Sebagian'  => 1,
            'Tidak ada' => 0,
        ];

        $pSp  = $points[$sp] ?? 0;
        $pPks = $points[$pks] ?? 0;

        $total = $pSp + $pPks;
        return (int)(1 + $total);
    }

    /**
     * Hitung durasi penyelesaian proyek (hari) dari tanggal mulai ke tanggal selesai.
     */
    public function calculateC5Duration(string $tglMulai, string $tglSelesai): int
    {
        if (empty($tglMulai) || empty($tglSelesai)) {
            return 1;
        }

        try {
            $dtMulai   = new DateTime($tglMulai);
            $dtSelesai = new DateTime($tglSelesai);

            if ($dtSelesai < $dtMulai) {
                return 1;
            }

            $diff = $dtMulai->diff($dtSelesai);
            return max(1, (int)$diff->days);
        } catch (\Throwable $e) {
            return 1;
        }
    }

    /**
     * Aturan C5: Keterlambatan
     * max(0, aktual - rencana) dalam hari
     */
    public function calculateC5Delay(string $tglRencana, string $tglAktual): int
    {
        if (empty($tglRencana) || empty($tglAktual)) {
            return 0;
        }

        try {
            $dtRencana = new DateTime($tglRencana);
            $dtAktual  = new DateTime($tglAktual);

            if ($dtAktual <= $dtRencana) {
                return 0;
            }

            $diff = $dtRencana->diff($dtAktual);
            return (int)$diff->days;
        } catch (\Throwable $e) {
            return 0;
        }
    }

    /**
     * Calculate SAW Rankings & Matrices
     *
     * @param array $alternatives List of alternatives, each having at least:
     *                            ['id' => ..., 'nama' => ..., 'criteria' => ['C1' => ..., 'C2' => ..., ...]]
     * @param array $criteria List of criteria, keyed by code or list:
     *                        ['C1' => ['atribut' => 'benefit', 'bobot' => 0.30], ...]
     * @param array $thresholds ['batas_baik' => 0.80, 'batas_perhatian' => 0.60]
     * @return array
     */
    public function calculateSaw(array $alternatives, array $criteria, array $thresholds = []): array
    {
        if (empty($alternatives)) {
            return [
                'alternatives' => [],
                'matrix_x'     => [],
                'matrix_r'     => [],
                'matrix_w'     => [],
                'summary'      => [],
            ];
        }

        $batasBaik      = (float)($thresholds['batas_baik'] ?? 0.80);
        $batasPerhatian = (float)($thresholds['batas_perhatian'] ?? 0.60);

        // Normalize criteria array to be keyed by criterion code
        $normCriteria = [];
        $totalWeight  = 0.0;
        foreach ($criteria as $key => $crit) {
            $code = $crit['kode'] ?? (is_string($key) ? $key : '');
            $atribut = strtolower($crit['atribut'] ?? 'benefit');
            $bobot   = (float)($crit['bobot'] ?? 0);
            $totalWeight += $bobot;

            $normCriteria[$code] = [
                'kode'    => $code,
                'nama'    => $crit['nama'] ?? $code,
                'atribut' => $atribut,
                'bobot'   => $bobot,
            ];
        }

        // Validate total weight == 1.00 (tolerance 0.0001)
        if (abs($totalWeight - 1.00) > 0.0001) {
            throw new InvalidArgumentException(
                sprintf('Total bobot kriteria harus bernilai 1.00 (total saat ini: %.4f). Perhitungan ditolak.', $totalWeight)
            );
        }

        $codes = array_keys($normCriteria);

        // Build Decision Matrix X
        $matrixX = [];
        foreach ($alternatives as $alt) {
            $altId = $alt['id'];
            $matrixX[$altId] = [];
            foreach ($codes as $code) {
                $val = (float)($alt['criteria'][$code] ?? 0);
                $matrixX[$altId][$code] = $val;
            }
        }

        // Edge Case: Only 1 alternative
        $isSingle = (count($alternatives) === 1);

        // Find min and max for each criterion, and check Cost 0 condition
        $colExtremes = [];
        $costShiftApplied = [];

        foreach ($codes as $code) {
            $colValues = [];
            foreach ($matrixX as $altId => $row) {
                $colValues[] = $row[$code];
            }

            $minVal = min($colValues);
            $maxVal = max($colValues);
            $isCost = ($normCriteria[$code]['atribut'] === 'cost');

            // Edge Case: if Cost criterion has 0, add 1 to all values in this column
            // to avoid division by zero:
            // "Jika ada nilai 0 pada kriteria Cost (misalnya keterlambatan 0 hari),
            // tambahkan 1 ke seluruh nilai kolom itu sebelum normalisasi agar tidak terjadi pembagian dengan nol."
            $shift = 0;
            if ($isCost && $minVal <= 0.0) {
                $shift = 1;
                $costShiftApplied[$code] = true;
                // recompute min with shift
                $colValuesShifted = array_map(function($v) { return $v + 1; }, $colValues);
                $minVal = min($colValuesShifted);
            } else {
                $costShiftApplied[$code] = false;
            }

            $colExtremes[$code] = [
                'min'   => $minVal,
                'max'   => $maxVal,
                'shift' => $shift,
            ];
        }

        // Build Normalized Matrix R and Weighted Matrix W
        $matrixR = [];
        $matrixW = [];
        $results = [];

        foreach ($alternatives as $alt) {
            $altId = $alt['id'];
            $matrixR[$altId] = [];
            $matrixW[$altId] = [];
            $vi = 0.0;

            foreach ($codes as $code) {
                $crit = $normCriteria[$code];
                $rawVal = $matrixX[$altId][$code];

                if ($isSingle) {
                    $rVal = 1.0;
                } else {
                    if ($crit['atribut'] === 'benefit') {
                        $max = $colExtremes[$code]['max'];
                        $rVal = ($max > 0) ? ($rawVal / $max) : 0.0;
                    } else {
                        // Cost
                        $min = $colExtremes[$code]['min'];
                        $shift = $colExtremes[$code]['shift'];
                        $effectiveVal = $rawVal + $shift;
                        $rVal = ($effectiveVal > 0) ? ($min / $effectiveVal) : 0.0;
                    }
                }

                $wVal = $rVal * $crit['bobot'];
                $vi  += $wVal;

                $matrixR[$altId][$code] = round($rVal, 4);
                $matrixW[$altId][$code] = round($wVal, 4);
            }

            $viRounded = round($vi, 4);

            // Determine Category based on Vi
            if ($viRounded >= $batasBaik) {
                $kategori = 'Baik';
            } elseif ($viRounded >= $batasPerhatian) {
                $kategori = 'Perlu Perhatian';
            } else {
                $kategori = 'Berisiko/Terlambat';
            }

            $results[$altId] = [
                'id'       => $altId,
                'proyek'   => $alt,
                'c1'       => $matrixX[$altId]['C1'] ?? 0,
                'c2'       => $matrixX[$altId]['C2'] ?? 0,
                'c3'       => $matrixX[$altId]['C3'] ?? 0,
                'c4'       => $matrixX[$altId]['C4'] ?? 0,
                'c5'       => $matrixX[$altId]['C5'] ?? 0,
                'c6'       => $matrixX[$altId]['C6'] ?? 0,
                'c7'       => $matrixX[$altId]['C7'] ?? 0,
                'matrix_r' => $matrixR[$altId],
                'matrix_w' => $matrixW[$altId],
                'vi'       => $viRounded,
                'kategori' => $kategori,
                'peringkat'=> 0,
            ];
        }

        // Rank alternatives by Vi descending
        // Stable sort
        uasort($results, function ($a, $b) {
            if ($a['vi'] == $b['vi']) {
                return 0;
            }
            return ($a['vi'] > $b['vi']) ? -1 : 1;
        });

        $rank = 1;
        foreach ($results as $altId => &$item) {
            $item['peringkat'] = $rank++;
        }
        unset($item);

        return [
            'results'            => $results,
            'matrix_x'           => $matrixX,
            'matrix_r'           => $matrixR,
            'matrix_w'           => $matrixW,
            'criteria'           => $normCriteria,
            'col_extremes'       => $colExtremes,
            'cost_shift_applied' => $costShiftApplied,
            'thresholds'         => [
                'batas_baik'      => $batasBaik,
                'batas_perhatian' => $batasPerhatian,
            ],
        ];
    }
}
