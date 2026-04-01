<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Programs extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_program' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'uuid_program' => ['type' => 'CHAR', 'constraint' => 36],
            'nama_program' => ['type' => 'VARCHAR', 'constraint' => 255],
            'tahun_pelaksanaan' => ['type' => 'INT', 'constraint' => 4, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_program', true);
        $this->forge->addUniqueKey('uuid_program');
        $this->forge->createTable('programs');
    }

    public function down()
    {
        $this->forge->dropTable('programs');
    }
}
