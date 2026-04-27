<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

// Migration: Membuat tabel materi_kelas untuk menyimpan materi yang diunggah pemateri
class MateriKelas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_materi'   => ['type' => 'VARCHAR', 'constraint' => 36],
            'id_kelas'    => ['type' => 'VARCHAR', 'constraint' => 36],
            'judul'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'deskripsi'   => ['type' => 'TEXT', 'null' => true],
            'nama_file'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'tipe_file'   => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'link_berbagi'=> ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'diunggah_oleh' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'dibuat_pada' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_materi', true);
        $this->forge->addForeignKey('id_kelas', 'kelas_startup', 'id_kelas', 'CASCADE', 'CASCADE');
        $this->forge->createTable('materi_kelas', true);
    }

    public function down()
    {
        $this->forge->dropTable('materi_kelas', true);
    }
}
