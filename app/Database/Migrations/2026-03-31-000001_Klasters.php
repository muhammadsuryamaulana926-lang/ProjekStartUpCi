<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Klasters extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_klaster' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'uuid_klaster' => [
                'type'       => 'CHAR',
                'constraint' => 36,
            ],
            'nama_klaster' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_klaster', true);
        $this->forge->addUniqueKey('uuid_klaster');
        $this->forge->createTable('klasters');
    }

    public function down()
    {
        $this->forge->dropTable('klasters');
    }
}
