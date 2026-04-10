<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

// Migration: tambah kolom id_user ke tabel startups sebagai relasi ke pemilik startup
class AddIdUserToStartups extends Migration
{
    public function up()
    {
        // Tambah kolom id_user (nullable karena startup lama belum punya user)
        $this->forge->addColumn('startups', [
            'id_user' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'id_startup',
            ],
        ]);
        $this->db->query('ALTER TABLE startups ADD CONSTRAINT fk_startups_user FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE SET NULL ON UPDATE CASCADE');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE startups DROP FOREIGN KEY fk_startups_user');
        $this->forge->dropColumn('startups', 'id_user');
    }
}
