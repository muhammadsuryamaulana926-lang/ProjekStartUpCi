<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddLinkFileToTugasKelas extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tugas_kelas', [
            'link_file' => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true, 'after' => 'instruksi'],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tugas_kelas', 'link_file');
    }
}
