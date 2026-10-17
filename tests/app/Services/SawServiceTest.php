<?php

namespace Tests\App\Services;

use App\Services\SawService;
use CodeIgniter\Test\CIUnitTestCase;
use InvalidArgumentException;

/**
 * @internal
 */
final class SawServiceTest extends CIUnitTestCase
{
    private SawService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new SawService();
    }

    public function testC3ScoreCalculation(): void
    {
        // Lengkap / Lengkap = 2 + 2 = 4 pts -> 1 + 4 = 5
        $this->assertSame(5, $this->service->calculateC3Score('Lengkap', 'Lengkap'));

        // Lengkap / Sebagian = 2 + 1 = 3 pts -> 1 + 3 = 4
        $this->assertSame(4, $this->service->calculateC3Score('Lengkap', 'Sebagian'));

        // Lengkap / Tidak ada = 2 + 0 = 2 pts -> 1 + 2 = 3
        $this->assertSame(3, $this->service->calculateC3Score('Lengkap', 'Tidak ada'));

        // Sebagian / Tidak ada = 1 + 0 = 1 pt -> 1 + 1 = 2
        $this->assertSame(2, $this->service->calculateC3Score('Sebagian', 'Tidak ada'));

        // Tidak ada / Tidak ada = 0 pts -> 1 + 0 = 1
        $this->assertSame(1, $this->service->calculateC3Score('Tidak ada', 'Tidak ada'));
    }

    public function testCriteriaValuesCalculationFromRawData(): void
    {
        $rawDataA = [
            'progres_rencana'        => 100,
            'progres_aktual'         => 95,
            'nilai_rab'              => 500000000,
            'biaya_realisasi'        => 490000000,
            'skor_foto_progres'      => 5,
            'skor_bast'              => 4,
            'skor_kepuasan_klien'    => 5,
            'skor_k3'                => 4,
            'tanggal_selesai_rencana'=> '2026-06-30',
            'tanggal_selesai_aktual' => '2026-07-05',
        ];

        $criteriaValues = $this->service->calculateCriteriaValues($rawDataA);

        $this->assertEquals(95.0, $criteriaValues['C1']);
        $this->assertEquals(98.0, $criteriaValues['C2']);
        $this->assertEquals(5.0, $criteriaValues['C3']);
        $this->assertEquals(4.0, $criteriaValues['C4']);
        $this->assertEquals(5.0, $criteriaValues['C5']);
        $this->assertEquals(5.0, $criteriaValues['C6']);
        $this->assertEquals(4.0, $criteriaValues['C7']);
    }

    public function testPrdSection9TestDataExactMatch(): void
    {
        // Criteria definition per Section 5 of PRD
        $criteria = [
            'C1' => ['kode' => 'C1', 'nama' => 'Capaian progres', 'atribut' => 'benefit', 'bobot' => 0.30],
            'C2' => ['kode' => 'C2', 'nama' => 'Biaya terhadap RAB', 'atribut' => 'cost', 'bobot' => 0.25],
            'C3' => ['kode' => 'C3', 'nama' => 'Kelengkapan dokumen kontrak', 'atribut' => 'benefit', 'bobot' => 0.20],
            'C4' => ['kode' => 'C4', 'nama' => 'Ketepatan serah terima', 'atribut' => 'benefit', 'bobot' => 0.15],
            'C5' => ['kode' => 'C5', 'nama' => 'Keterlambatan', 'atribut' => 'cost', 'bobot' => 0.10],
        ];

        // 4 Projects from Section 9
        $alternatives = [
            [
                'id'       => 1,
                'kode'     => 'PRJ-A',
                'nama'     => 'A. Rumah',
                'criteria' => ['C1' => 95.0, 'C2' => 98.0, 'C3' => 5.0, 'C4' => 4.0, 'C5' => 5.0],
            ],
            [
                'id'       => 2,
                'kode'     => 'PRJ-B',
                'nama'     => 'B. Kost',
                'criteria' => ['C1' => 80.0, 'C2' => 110.0, 'C3' => 3.0, 'C4' => 3.0, 'C5' => 20.0],
            ],
            [
                'id'       => 3,
                'kode'     => 'PRJ-C',
                'nama'     => 'C. Kantor',
                'criteria' => ['C1' => 90.0, 'C2' => 100.0, 'C3' => 4.0, 'C4' => 5.0, 'C5' => 10.0],
            ],
            [
                'id'       => 4,
                'kode'     => 'PRJ-D',
                'nama'     => 'D. Renovasi',
                'criteria' => ['C1' => 70.0, 'C2' => 105.0, 'C3' => 1.0, 'C4' => 2.0, 'C5' => 30.0],
            ],
        ];

        $output = $this->service->calculateSaw($alternatives, $criteria);
        $results = $output['results'];

        // Expected outcome from PRD:
        // Rank 1: A. Rumah, Vi = 0.97, Baik
        // Rank 2: C. Kantor, Vi = 0.89, Baik
        // Rank 3: B. Kost, Vi = 0.71, Perlu Perhatian
        // Rank 4: D. Renovasi, Vi = 0.57, Berisiko/Terlambat

        $resA = $results[1];
        $resB = $results[2];
        $resC = $results[3];
        $resD = $results[4];

        // Check Ranks
        $this->assertSame(1, $resA['peringkat']);
        $this->assertSame(2, $resC['peringkat']);
        $this->assertSame(3, $resB['peringkat']);
        $this->assertSame(4, $resD['peringkat']);

        // Check Vi values with 0.01 tolerance
        $this->assertEqualsWithDelta(0.97, $resA['vi'], 0.01, 'Proyek A Vi should be 0.97');
        $this->assertEqualsWithDelta(0.89, $resC['vi'], 0.01, 'Proyek C Vi should be 0.89');
        $this->assertEqualsWithDelta(0.71, $resB['vi'], 0.01, 'Proyek B Vi should be 0.71');
        $this->assertEqualsWithDelta(0.57, $resD['vi'], 0.01, 'Proyek D Vi should be 0.57');

        // Check Categories
        $this->assertSame('Baik', $resA['kategori']);
        $this->assertSame('Baik', $resC['kategori']);
        $this->assertSame('Perlu Perhatian', $resB['kategori']);
        $this->assertSame('Berisiko/Terlambat', $resD['kategori']);
    }

    public function testEdgeCaseCostCriterionWithZeroValue(): void
    {
        // When delay is 0 days on cost criterion C5, column should shift by +1
        $criteria = [
            'C1' => ['kode' => 'C1', 'nama' => 'Progres', 'atribut' => 'benefit', 'bobot' => 0.50],
            'C5' => ['kode' => 'C5', 'nama' => 'Keterlambatan', 'atribut' => 'cost', 'bobot' => 0.50],
        ];

        $alternatives = [
            [
                'id'       => 1,
                'nama'     => 'Proyek Tepat Waktu',
                'criteria' => ['C1' => 100, 'C5' => 0], // delay 0
            ],
            [
                'id'       => 2,
                'nama'     => 'Proyek Terlambat',
                'criteria' => ['C1' => 80, 'C5' => 10], // delay 10
            ],
        ];

        // Should not throw DivisionByZeroError
        $output = $this->service->calculateSaw($alternatives, $criteria);
        $this->assertNotEmpty($output['results']);
        $this->assertTrue($output['cost_shift_applied']['C5']);
        $this->assertSame(1, $output['results'][1]['peringkat']);
    }

    public function testEdgeCaseSingleProject(): void
    {
        $criteria = [
            'C1' => ['kode' => 'C1', 'nama' => 'Progres', 'atribut' => 'benefit', 'bobot' => 0.60],
            'C2' => ['kode' => 'C2', 'nama' => 'Biaya', 'atribut' => 'cost', 'bobot' => 0.40],
        ];

        $alternatives = [
            [
                'id'       => 1,
                'nama'     => 'Proyek Tunggal',
                'criteria' => ['C1' => 90, 'C2' => 100],
            ],
        ];

        $output = $this->service->calculateSaw($alternatives, $criteria);
        $res = $output['results'][1];

        $this->assertSame(1, $res['peringkat']);
        $this->assertEquals(1.0, $res['vi']);
        $this->assertSame('Baik', $res['kategori']);
        $this->assertEquals(1.0, $output['matrix_r'][1]['C1']);
        $this->assertEquals(1.0, $output['matrix_r'][1]['C2']);
    }

    public function testRejectsInvalidTotalWeight(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Total bobot kriteria harus bernilai 1.00');

        $criteria = [
            'C1' => ['kode' => 'C1', 'nama' => 'Progres', 'atribut' => 'benefit', 'bobot' => 0.40],
            'C2' => ['kode' => 'C2', 'nama' => 'Biaya', 'atribut' => 'cost', 'bobot' => 0.40], // total 0.80 != 1.00
        ];

        $alternatives = [
            [
                'id'       => 1,
                'nama'     => 'Proyek 1',
                'criteria' => ['C1' => 90, 'C2' => 100],
            ],
        ];

        $this->service->calculateSaw($alternatives, $criteria);
    }

    public function testSevenCriteriaSawCalculation(): void
    {
        $criteria = [
            'C1' => ['kode' => 'C1', 'nama' => 'Progres Kurva S', 'atribut' => 'benefit', 'bobot' => 0.20],
            'C2' => ['kode' => 'C2', 'nama' => 'Realisasi Biaya vs RAB', 'atribut' => 'cost', 'bobot' => 0.20],
            'C3' => ['kode' => 'C3', 'nama' => 'Foto Dokumentasi Lapangan', 'atribut' => 'benefit', 'bobot' => 0.15],
            'C4' => ['kode' => 'C4', 'nama' => 'Ketepatan BAST', 'atribut' => 'benefit', 'bobot' => 0.15],
            'C5' => ['kode' => 'C5', 'nama' => 'Keterlambatan Hari', 'atribut' => 'cost', 'bobot' => 0.10],
            'C6' => ['kode' => 'C6', 'nama' => 'Tingkat Kepuasan Klien', 'atribut' => 'benefit', 'bobot' => 0.10],
            'C7' => ['kode' => 'C7', 'nama' => 'Penerapan K3', 'atribut' => 'benefit', 'bobot' => 0.10],
        ];

        $alternatives = [
            [
                'id'       => 1,
                'kode'     => 'PRJ-1',
                'nama'     => 'Villa Modern',
                'criteria' => ['C1' => 100.0, 'C2' => 95.0, 'C3' => 5.0, 'C4' => 5.0, 'C5' => 0.0, 'C6' => 5.0, 'C7' => 5.0],
            ],
            [
                'id'       => 2,
                'kode'     => 'PRJ-2',
                'nama'     => 'Rumah Kost',
                'criteria' => ['C1' => 75.0, 'C2' => 110.0, 'C3' => 3.0, 'C4' => 3.0, 'C5' => 15.0, 'C6' => 3.0, 'C7' => 3.0],
            ],
        ];

        $output = $this->service->calculateSaw($alternatives, $criteria);
        $results = $output['results'];

        $this->assertCount(2, $results);
        $this->assertSame(1, $results[1]['peringkat']);
        $this->assertSame('Baik', $results[1]['kategori']);
        $this->assertSame(2, $results[2]['peringkat']);
        $this->assertArrayHasKey('c6', $results[1]);
        $this->assertArrayHasKey('c7', $results[1]);
        $this->assertEquals(5.0, $results[1]['c6']);
        $this->assertEquals(5.0, $results[1]['c7']);
    }
}
