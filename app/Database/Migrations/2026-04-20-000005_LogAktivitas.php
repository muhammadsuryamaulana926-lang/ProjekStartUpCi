<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class LogAktivitas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_log'      => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'id_user'     => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'nama_user'   => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'role'        => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'aksi'        => ['type' => 'VARCHAR', 'constraint' => 255],
            'halaman'     => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'ip_address'  => ['type' => 'VARCHAR', 'constraint' => 45, 'null' => true],
            'user_agent'  => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'dibuat_pada' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_log', true);
        $this->forge->createTable('log_aktivitas', true);
    }

    public function down()
    {
        $this->forge->dropTable('log_aktivitas', true);
    }
}
