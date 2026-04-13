<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Riwayat extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_riwayat' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_item' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true, // id_konten_video or id_konten_ebook
            ],
            'jenis_item' => [
                'type'       => 'ENUM',
                'constraint' => ['video', 'ebook'],
            ],
            'durasi' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0, // In seconds for video
            ],
            'halaman_terakhir' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0, // Last page accessed for ebook
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
        $this->forge->addKey('id_riwayat', true);
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('riwayat');
    }

    public function down()
    {
        $this->forge->dropTable('riwayat');
    }
}
