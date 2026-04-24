<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

// Migration: Membuat tabel program_startup, kelas_startup, dan peserta_program
// Semua tabel menggunakan UUID (varchar 36) sebagai primary key
class CreateProgramKelasPesertaTables extends Migration
{
    public function up()
    {
        // ─── Tabel sk_program ───
        $this->forge->addField([
            'id_program' => [
                'type'       => 'VARCHAR',
                'constraint' => 36,
            ],
            'nama_program' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'dibuat_pada' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_program', true);
        $this->forge->createTable('program_startup', true);

        // ─── Tabel sk_kelas ───
        $this->forge->addField([
            'id_kelas' => [
                'type'       => 'VARCHAR',
                'constraint' => 36,
            ],
            'id_program' => [
                'type'       => 'VARCHAR',
                'constraint' => 36,
            ],
            'nama_kelas' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status_kelas' => [
                'type'       => 'ENUM',
                'constraint' => ['aktif', 'selesai', 'dibatalkan'],
                'default'    => 'aktif',
            ],
            'tanggal' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'jam_mulai' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => true,
            ],
            'jam_selesai' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => true,
            ],
            'link_youtube' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'null'       => true,
            ],
            'link_zoom' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'null'       => true,
            ],
            'nama_dosen' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'dibuat_pada' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_kelas', true);
        $this->forge->addForeignKey('id_program', 'program_startup', 'id_program', 'CASCADE', 'CASCADE');
        $this->forge->createTable('kelas_startup', true);

        // ─── Tabel sk_peserta_program ───
        $this->forge->addField([
            'id_peserta_program' => [
                'type'       => 'VARCHAR',
                'constraint' => 36,
            ],
            'id_program' => [
                'type'       => 'VARCHAR',
                'constraint' => 36,
            ],
            'nama_peserta' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'dibuat_pada' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_peserta_program', true);
        $this->forge->addForeignKey('id_program', 'program_startup', 'id_program', 'CASCADE', 'CASCADE');
        $this->forge->createTable('peserta_program', true);
    }

    public function down()
    {
        // Hapus tabel dalam urutan yang benar (child dulu)
        $this->forge->dropTable('peserta_program', true);
        $this->forge->dropTable('kelas_startup', true);
        $this->forge->dropTable('program_startup', true);
    }
}
