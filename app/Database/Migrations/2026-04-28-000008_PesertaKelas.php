<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

// Migration: Membuat tabel peserta_kelas untuk peserta yang diassign admin ke kelas
class PesertaKelas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_peserta_kelas' => ['type' => 'VARCHAR', 'constraint' => 36],
            'id_kelas'         => ['type' => 'VARCHAR', 'constraint' => 36],
            'nama_peserta'     => ['type' => 'VARCHAR', 'constraint' => 255],
            'dibuat_pada'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_peserta_kelas', true);
        $this->forge->addUniqueKey(['id_kelas', 'nama_peserta']);
        $this->forge->addForeignKey('id_kelas', 'kelas_startup', 'id_kelas', 'CASCADE', 'CASCADE');
        $this->forge->createTable('peserta_kelas', true);
    }

    public function down()
    {
        $this->forge->dropTable('peserta_kelas', true);
    }
}
