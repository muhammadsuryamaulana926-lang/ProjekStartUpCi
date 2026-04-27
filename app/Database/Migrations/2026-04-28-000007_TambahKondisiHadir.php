<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

// Migration: Menambah kolom kondisi_hadir ke tabel presensi_kelas
class TambahKondisiHadir extends Migration
{
    public function up()
    {
        $this->forge->addColumn('presensi_kelas', [
            'kondisi_hadir' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'nama_peserta',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('presensi_kelas', 'kondisi_hadir');
    }
}
