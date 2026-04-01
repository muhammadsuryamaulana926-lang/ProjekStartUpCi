<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Mentors extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_mentor' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'uuid_mentor' => ['type' => 'CHAR', 'constraint' => 36],
            'nama_mentor' => ['type' => 'VARCHAR', 'constraint' => 255],
            'bidang_keahlian' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'kontak' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_mentor', true);
        $this->forge->addUniqueKey('uuid_mentor');
        $this->forge->createTable('mentors');
    }

    public function down()
    {
        $this->forge->dropTable('mentors');
    }
}
