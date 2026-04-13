<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class KontenAkses extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'tipe'       => ['type' => 'ENUM', 'constraint' => ['ebook', 'video']],
            'id_konten'  => ['type' => 'INT', 'unsigned' => true],
            'id_user'    => ['type' => 'INT', 'unsigned' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('konten_akses');
    }

    public function down()
    {
        $this->forge->dropTable('konten_akses');
    }
}
