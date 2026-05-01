<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EbookViews extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'auto_increment' => true],
            'id_konten_ebook' => ['type' => 'INT', 'null' => false],
            'id_user'         => ['type' => 'INT', 'null' => false],
            'viewed_at'       => ['type' => 'DATETIME', 'null' => false, 'default' => ''],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey(['id_konten_ebook', 'id_user']);
        $this->forge->createTable('ebook_views');
    }

    public function down()
    {
        $this->forge->dropTable('ebook_views');
    }
}
