<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

// Migration: Membuat tabel tugas_kelas dan jawaban_tugas
class TugasKelas extends Migration
{
    public function up()
    {
        // ─── Tabel tugas_kelas ───
        $this->forge->addField([
            'id_tugas'     => ['type' => 'VARCHAR', 'constraint' => 36],
            'id_kelas'     => ['type' => 'VARCHAR', 'constraint' => 36],
            'judul'        => ['type' => 'VARCHAR', 'constraint' => 255],
            'instruksi'    => ['type' => 'TEXT', 'null' => true],
            'nama_file'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'tipe_file'    => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'dibuat_oleh'  => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'dibuat_pada'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_tugas', true);
        $this->forge->addForeignKey('id_kelas', 'kelas_startup', 'id_kelas', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tugas_kelas', true);

        // ─── Tabel jawaban_tugas ───
        $this->forge->addField([
            'id_jawaban'   => ['type' => 'VARCHAR', 'constraint' => 36],
            'id_tugas'     => ['type' => 'VARCHAR', 'constraint' => 36],
            'nama_peserta' => ['type' => 'VARCHAR', 'constraint' => 255],
            'jawaban_teks' => ['type' => 'TEXT', 'null' => true],
            'nama_file'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'tipe_file'    => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'komentar'     => ['type' => 'TEXT', 'null' => true],
            'dibuat_pada'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_jawaban', true);
        $this->forge->addForeignKey('id_tugas', 'tugas_kelas', 'id_tugas', 'CASCADE', 'CASCADE');
        $this->forge->createTable('jawaban_tugas', true);
    }

    public function down()
    {
        $this->forge->dropTable('jawaban_tugas', true);
        $this->forge->dropTable('tugas_kelas', true);
    }
}
