<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Notifikasi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_notifikasi' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'judul'         => ['type' => 'VARCHAR', 'constraint' => 255],
            'pesan'         => ['type' => 'TEXT'],
            'url'           => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'sudah_dibaca'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'dibuat_pada'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_notifikasi', true);
        $this->forge->createTable('notifikasi', true);
    }

    public function down()
    {
        $this->forge->dropTable('notifikasi', true);
    }
}
