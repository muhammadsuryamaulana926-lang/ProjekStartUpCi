<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AktifitasStartups extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_aktifitas' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'uuid_aktifitas' => ['type' => 'CHAR', 'constraint' => 36],
            'id_startup' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'nama_aktifitas' => ['type' => 'VARCHAR', 'constraint' => 255],
            'tanggal' => ['type' => 'DATE', 'null' => true],
            'deskripsi' => ['type' => 'TEXT', 'null' => true],
            'dokumentasi' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_aktifitas', true);
        $this->forge->addUniqueKey('uuid_aktifitas');
        $this->forge->addForeignKey('id_startup', 'startups', 'id_startup', 'CASCADE', 'CASCADE');
        $this->forge->createTable('aktifitas_startups');
    }

    public function down()
    {
        $this->forge->dropTable('aktifitas_startups');
    }
}
