<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DosenPembinas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_dosen_pembina' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'uuid_dosen_pembina' => ['type' => 'CHAR', 'constraint' => 36],
            'nama_lengkap' => ['type' => 'VARCHAR', 'constraint' => 255],
            'nip' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'fakultas' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'kontak' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_dosen_pembina', true);
        $this->forge->addUniqueKey('uuid_dosen_pembina');
        $this->forge->createTable('dosen_pembinas');
    }

    public function down()
    {
        $this->forge->dropTable('dosen_pembinas');
    }
}
