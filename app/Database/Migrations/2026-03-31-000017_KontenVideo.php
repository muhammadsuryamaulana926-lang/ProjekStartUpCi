<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

// Migration: membuat tabel konten_video untuk menyimpan data video pembelajaran
class KontenVideo extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_konten_video'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'uuid_konten_video' => ['type' => 'CHAR', 'constraint' => 36],
            'id_user'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'judul_video'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'deskripsi_video'   => ['type' => 'TEXT', 'null' => true],
            // kode_video menyimpan YouTube ID yang sudah di-encode base64, bukan URL asli
            'kode_video'        => ['type' => 'VARCHAR', 'constraint' => 500],
            'thumbnail_video'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'status_video'      => ['type' => 'ENUM', 'constraint' => ['Publik', 'Privat'], 'default' => 'Publik'],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
            'updated_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_konten_video', true);
        $this->forge->addUniqueKey('uuid_konten_video');
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('konten_video');
    }

    public function down()
    {
        $this->forge->dropTable('konten_video');
    }
}
