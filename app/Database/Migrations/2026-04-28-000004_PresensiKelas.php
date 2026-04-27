<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

// Migration: Membuat tabel presensi_kelas untuk menyimpan data check-in peserta sebelum masuk kelas
class PresensiKelas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_presensi'  => ['type' => 'VARCHAR', 'constraint' => 36],
            'id_kelas'     => ['type' => 'VARCHAR', 'constraint' => 36],
            'id_program'   => ['type' => 'VARCHAR', 'constraint' => 36],
            'nama_peserta' => ['type' => 'VARCHAR', 'constraint' => 255],
            'catatan'      => ['type' => 'TEXT', 'null' => true],
            'dibuat_pada'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_presensi', true);
        $this->forge->addUniqueKey(['id_kelas', 'nama_peserta']);
        $this->forge->addForeignKey('id_kelas', 'kelas_startup', 'id_kelas', 'CASCADE', 'CASCADE');
        $this->forge->createTable('presensi_kelas', true);
    }

    public function down()
    {
        $this->forge->dropTable('presensi_kelas', true);
    }
}
