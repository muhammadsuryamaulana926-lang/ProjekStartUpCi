<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDeskripsiToKelasVideo extends Migration
{
    public function up()
    {
        $this->forge->addColumn('kelas_video', [
            'deskripsi' => ['type' => 'TEXT', 'null' => true, 'after' => 'judul_sesi'],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('kelas_video', 'deskripsi');
    }
}
