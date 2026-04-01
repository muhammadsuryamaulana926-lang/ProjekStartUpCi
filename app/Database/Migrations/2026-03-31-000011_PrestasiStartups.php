<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PrestasiStartups extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_prestasi' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'uuid_prestasi' => ['type' => 'CHAR', 'constraint' => 36],
            'id_startup' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'nama_prestasi' => ['type' => 'VARCHAR', 'constraint' => 255],
            'tingkat' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'penyelenggara' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'tahun' => ['type' => 'INT', 'constraint' => 4, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_prestasi', true);
        $this->forge->addUniqueKey('uuid_prestasi');
        $this->forge->addForeignKey('id_startup', 'startups', 'id_startup', 'CASCADE', 'CASCADE');
        $this->forge->createTable('prestasi_startups');
    }

    public function down()
    {
        $this->forge->dropTable('prestasi_startups');
    }
}
