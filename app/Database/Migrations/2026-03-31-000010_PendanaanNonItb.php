<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PendanaanNonItb extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pendanaan_non_itb' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'uuid_pendanaan_non_itb' => ['type' => 'CHAR', 'constraint' => 36],
            'id_startup' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'sumber_pendanaan' => ['type' => 'VARCHAR', 'constraint' => 255],
            'nominal' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'null' => true],
            'tahun' => ['type' => 'INT', 'constraint' => 4, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_pendanaan_non_itb', true);
        $this->forge->addUniqueKey('uuid_pendanaan_non_itb');
        $this->forge->addForeignKey('id_startup', 'startups', 'id_startup', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pendanaan_non_itb');
    }

    public function down()
    {
        $this->forge->dropTable('pendanaan_non_itb');
    }
}
