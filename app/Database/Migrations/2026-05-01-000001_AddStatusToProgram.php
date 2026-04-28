<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusToProgram extends Migration
{
    public function up()
    {
        $this->forge->addColumn('program_startup', [
            'status_program' => [
                'type'       => 'ENUM',
                'constraint' => ['aktif', 'selesai', 'dibatalkan'],
                'default'    => 'aktif',
                'after'      => 'deskripsi',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('program_startup', 'status_program');
    }
}
