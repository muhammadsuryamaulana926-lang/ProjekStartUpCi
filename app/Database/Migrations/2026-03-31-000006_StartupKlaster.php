<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class StartupKlaster extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_startup_klaster' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_startup' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'id_klaster' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
        ]);
        $this->forge->addKey('id_startup_klaster', true);
        $this->forge->addForeignKey('id_startup', 'startups', 'id_startup', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_klaster', 'klasters', 'id_klaster', 'CASCADE', 'CASCADE');
        $this->forge->createTable('startup_klaster');
    }

    public function down()
    {
        $this->forge->dropTable('startup_klaster');
    }
}
