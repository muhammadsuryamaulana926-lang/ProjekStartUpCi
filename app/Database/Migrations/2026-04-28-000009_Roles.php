<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

// Migration: Membuat tabel roles untuk menyimpan daftar role secara dinamis
class Roles extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_role'    => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'nama_role'  => ['type' => 'VARCHAR', 'constraint' => 50, 'unique' => true],
            'label'      => ['type' => 'VARCHAR', 'constraint' => 100],
            'dibuat_pada'=> ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_role', true);
        $this->forge->createTable('roles', true);
    }

    public function down()
    {
        $this->forge->dropTable('roles', true);
    }
}
