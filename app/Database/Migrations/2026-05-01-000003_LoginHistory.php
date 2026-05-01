<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class LoginHistory extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_login_history' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'id_user'          => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'nama_pengguna'    => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'email'            => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'ip_address'       => ['type' => 'VARCHAR', 'constraint' => 45, 'null' => true],
            'nama_perangkat'   => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'web_browser'      => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'status'           => ['type' => 'ENUM', 'constraint' => ['aktif', 'tidak_aktif'], 'default' => 'aktif'],
            'tanggal_login'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_login_history', true);
        $this->forge->createTable('login_history', true);
    }

    public function down()
    {
        $this->forge->dropTable('login_history', true);
    }
}
