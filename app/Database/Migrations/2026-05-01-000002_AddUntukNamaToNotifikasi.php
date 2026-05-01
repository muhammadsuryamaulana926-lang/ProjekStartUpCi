<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUntukNamaToNotifikasi extends Migration
{
    public function up()
    {
        $this->forge->addColumn('notifikasi', [
            'untuk_nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'default'    => null,
                'after'      => 'untuk_role',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('notifikasi', 'untuk_nama');
    }
}
