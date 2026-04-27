<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

// Migration: Membuat tabel izin_akses untuk menyimpan permission per role per modul
class IzinAkses extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_izin'     => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'role'        => ['type' => 'VARCHAR', 'constraint' => 50],
            'modul'       => ['type' => 'VARCHAR', 'constraint' => 50],
            'bisa_lihat'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'bisa_tambah' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'bisa_edit'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'bisa_hapus'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
        ]);
        $this->forge->addKey('id_izin', true);
        $this->forge->addUniqueKey(['role', 'modul']);
        $this->forge->createTable('izin_akses', true);
    }

    public function down()
    {
        $this->forge->dropTable('izin_akses', true);
    }
}
