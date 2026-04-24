<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KelasVideoChapter extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_chapter'     => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'id_kelas_video' => ['type' => 'INT', 'unsigned' => true],
            'judul_chapter'  => ['type' => 'VARCHAR', 'constraint' => 255],
            'mulai_detik'    => ['type' => 'INT', 'default' => 0],
            'selesai_detik'  => ['type' => 'INT', 'default' => 0],
            'urutan'         => ['type' => 'INT', 'default' => 1],
        ]);
        $this->forge->addKey('id_chapter', true);
        $this->forge->addForeignKey('id_kelas_video', 'kelas_video', 'id_kelas_video', 'CASCADE', 'CASCADE');
        $this->forge->createTable('kelas_video_chapter', true);
    }

    public function down()
    {
        $this->forge->dropTable('kelas_video_chapter', true);
    }
}
