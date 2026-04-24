<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUntukRoleToNotifikasi extends Migration
{
    public function up()
    {
        $this->forge->addColumn('notifikasi', [
            'untuk_role' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'default'    => 'admin',
                'after'      => 'pesan',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('notifikasi', 'untuk_role');
    }
}
