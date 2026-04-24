<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KelasVideo extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kelas_video' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'id_kelas'       => ['type' => 'VARCHAR', 'constraint' => 36],
            'judul_sesi'     => ['type' => 'VARCHAR', 'constraint' => 255],
            'link_youtube'   => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'link_zoom'      => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'urutan'         => ['type' => 'INT', 'default' => 1],
            'dibuat_pada'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_kelas_video', true);
        $this->forge->addForeignKey('id_kelas', 'kelas_startup', 'id_kelas', 'CASCADE', 'CASCADE');
        $this->forge->createTable('kelas_video', true);
    }

    public function down()
    {
        $this->forge->dropTable('kelas_video', true);
    }
}
