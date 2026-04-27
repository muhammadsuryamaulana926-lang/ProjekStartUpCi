<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

// Migration: Menambah kolom tipe_kelas, platform_online, link_meeting, dan lokasi_offline ke tabel kelas_startup
class TambahTipeKelas extends Migration
{
    public function up()
    {
        $this->forge->addColumn('kelas_startup', [
            'tipe_kelas' => [
                'type'       => 'ENUM',
                'constraint' => ['online', 'offline'],
                'null'       => true,
                'after'      => 'status_kelas',
            ],
            'platform_online' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'tipe_kelas',
            ],
            'link_meeting' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'null'       => true,
                'after'      => 'platform_online',
            ],
            'lokasi_offline' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'link_meeting',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('kelas_startup', ['tipe_kelas', 'platform_online', 'link_meeting', 'lokasi_offline']);
    }
}
