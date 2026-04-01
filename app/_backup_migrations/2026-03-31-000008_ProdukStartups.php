<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProdukStartups extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_produk' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'uuid_produk' => ['type' => 'CHAR', 'constraint' => 36],
            'id_startup' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'nama_produk' => ['type' => 'VARCHAR', 'constraint' => 255],
            'deskripsi_produk' => ['type' => 'TEXT', 'null' => true],
            'foto_produk' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_produk', true);
        $this->forge->addUniqueKey('uuid_produk');
        $this->forge->addForeignKey('id_startup', 'startups', 'id_startup', 'CASCADE', 'CASCADE');
        $this->forge->createTable('produk_startups');
    }

    public function down()
    {
        $this->forge->dropTable('produk_startups');
    }
}
