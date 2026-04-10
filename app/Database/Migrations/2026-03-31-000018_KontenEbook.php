<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

// Migration: membuat tabel konten_ebook untuk menyimpan data ebook/referensi
class KontenEbook extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_konten_ebook'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'uuid_konten_ebook' => ['type' => 'CHAR', 'constraint' => 36],
            'id_user'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'judul_ebook'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'deskripsi_ebook'   => ['type' => 'TEXT', 'null' => true],
            'penulis_ebook'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            // file_ebook menyimpan nama file PDF di server, tidak diekspos langsung ke user
            'file_ebook'        => ['type' => 'VARCHAR', 'constraint' => 255],
            'sampul_ebook'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'status_ebook'      => ['type' => 'ENUM', 'constraint' => ['Publik', 'Privat'], 'default' => 'Publik'],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
            'updated_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_konten_ebook', true);
        $this->forge->addUniqueKey('uuid_konten_ebook');
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('konten_ebook');
    }

    public function down()
    {
        $this->forge->dropTable('konten_ebook');
    }
}
