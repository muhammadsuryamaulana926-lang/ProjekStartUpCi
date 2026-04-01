<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TimStartups extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_tim' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'uuid_tim' => ['type' => 'CHAR', 'constraint' => 36],
            'id_startup' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'nama_lengkap' => ['type' => 'VARCHAR', 'constraint' => 255],
            'jabatan' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'jenis_kelamin' => ['type' => 'ENUM', 'constraint' => ['L', 'P'], 'null' => true],
            'no_whatsapp' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'email' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'linkedin' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'instagram' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'nama_perguruan_tinggi' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_tim', true);
        $this->forge->addUniqueKey('uuid_tim');
        $this->forge->addForeignKey('id_startup', 'startups', 'id_startup', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tim_startups');
    }

    public function down()
    {
        $this->forge->dropTable('tim_startups');
    }
}
