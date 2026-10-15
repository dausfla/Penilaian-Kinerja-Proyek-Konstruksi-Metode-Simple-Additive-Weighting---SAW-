<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSpkTables extends Migration
{
    public function up()
    {
        // 1. Table: users
        $this->db->query("
            CREATE TABLE users (
                id BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
                nama VARCHAR(100) NOT NULL,
                username VARCHAR(50) NOT NULL UNIQUE,
                password_hash VARCHAR(255) NOT NULL,
                role VARCHAR(20) NOT NULL DEFAULT 'admin' CHECK (role = 'admin'),
                aktif BOOLEAN NOT NULL DEFAULT TRUE,
                created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
            )
        ");

        // 2. Table: proyek
        $this->db->query("
            CREATE TABLE proyek (
                id BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
                kode VARCHAR(50) NOT NULL UNIQUE,
                nama VARCHAR(150) NOT NULL,
                jenis VARCHAR(50) NOT NULL,
                klien VARCHAR(150) NOT NULL,
                lokasi VARCHAR(255) NOT NULL,
                tanggal_mulai DATE NOT NULL,
                tanggal_selesai_rencana DATE NOT NULL,
                nilai_rab NUMERIC(15, 2) NOT NULL,
                created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
            )
        ");

        // 3. Table: kriteria
        $this->db->query("
            CREATE TABLE kriteria (
                id BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
                kode VARCHAR(10) NOT NULL UNIQUE,
                nama VARCHAR(100) NOT NULL,
                atribut VARCHAR(10) NOT NULL CHECK (atribut IN ('benefit', 'cost')),
                bobot NUMERIC(5, 4) NOT NULL
            )
        ");

        // 4. Table: pengaturan
        $this->db->query("
            CREATE TABLE pengaturan (
                id BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
                kunci VARCHAR(50) NOT NULL UNIQUE,
                nilai TEXT NOT NULL
            )
        ");

        // 5. Table: periode_penilaian
        $this->db->query("
            CREATE TABLE periode_penilaian (
                id BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
                nama VARCHAR(100) NOT NULL,
                tanggal_penilaian DATE NOT NULL,
                status VARCHAR(20) NOT NULL DEFAULT 'draft' CHECK (status IN ('draft', 'terhitung')),
                created_by BIGINT REFERENCES users(id) ON DELETE SET NULL,
                created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
            )
        ");

        // 6. Table: penilaian
        $this->db->query("
            CREATE TABLE penilaian (
                id BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
                periode_id BIGINT NOT NULL REFERENCES periode_penilaian(id) ON DELETE CASCADE,
                proyek_id BIGINT NOT NULL REFERENCES proyek(id) ON DELETE CASCADE,
                progres_rencana NUMERIC(5, 2) NOT NULL DEFAULT 100.00,
                progres_aktual NUMERIC(5, 2) NOT NULL,
                biaya_realisasi NUMERIC(15, 2) NOT NULL,
                skor_foto_progres INT NOT NULL CHECK (skor_foto_progres BETWEEN 1 AND 5),
                skor_bast INT NOT NULL CHECK (skor_bast BETWEEN 1 AND 5),
                tanggal_selesai_aktual DATE NOT NULL,
                created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
                CONSTRAINT uq_periode_proyek UNIQUE (periode_id, proyek_id)
            )
        ");

        // Indexes for penilaian
        $this->db->query("CREATE INDEX idx_penilaian_periode_id ON penilaian(periode_id)");
        $this->db->query("CREATE INDEX idx_penilaian_proyek_id ON penilaian(proyek_id)");

        // 7. Table: hasil_saw
        $this->db->query("
            CREATE TABLE hasil_saw (
                id BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
                periode_id BIGINT NOT NULL REFERENCES periode_penilaian(id) ON DELETE CASCADE,
                proyek_id BIGINT NOT NULL REFERENCES proyek(id) ON DELETE CASCADE,
                c1 NUMERIC(10, 4) NOT NULL,
                c2 NUMERIC(10, 4) NOT NULL,
                c3 NUMERIC(10, 4) NOT NULL,
                c4 NUMERIC(10, 4) NOT NULL,
                c5 NUMERIC(10, 4) NOT NULL,
                vi NUMERIC(8, 4) NOT NULL,
                peringkat INT NOT NULL,
                kategori VARCHAR(50) NOT NULL,
                detail_json TEXT NULL,
                created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
                CONSTRAINT uq_hasil_periode_proyek UNIQUE (periode_id, proyek_id)
            )
        ");

        // Indexes for hasil_saw
        $this->db->query("CREATE INDEX idx_hasil_saw_periode_id ON hasil_saw(periode_id)");
        $this->db->query("CREATE INDEX idx_hasil_saw_proyek_id ON hasil_saw(proyek_id)");
    }

    public function down()
    {
        $this->db->query("DROP TABLE IF EXISTS hasil_saw CASCADE");
        $this->db->query("DROP TABLE IF EXISTS penilaian CASCADE");
        $this->db->query("DROP TABLE IF EXISTS periode_penilaian CASCADE");
        $this->db->query("DROP TABLE IF EXISTS pengaturan CASCADE");
        $this->db->query("DROP TABLE IF EXISTS kriteria CASCADE");
        $this->db->query("DROP TABLE IF EXISTS proyek CASCADE");
        $this->db->query("DROP TABLE IF EXISTS users CASCADE");
    }
}
