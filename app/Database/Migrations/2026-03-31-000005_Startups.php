<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Startups extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_startup' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'uuid_startup' => ['type' => 'CHAR', 'constraint' => 36],
            'id_dosen_pembina' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'id_program' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'nama_perusahaan' => ['type' => 'VARCHAR', 'constraint' => 255],
            'deskripsi_bidang_usaha' => ['type' => 'TEXT', 'null' => true],
            'tahun_berdiri' => ['type' => 'INT', 'constraint' => 4, 'null' => true],
            'tahun_daftar' => ['type' => 'INT', 'constraint' => 4, 'null' => true],
            'target_pemasaran' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'fokus_pelanggan' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'alamat' => ['type' => 'TEXT', 'null' => true],
            'nomor_whatsapp' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'email_perusahaan' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'website_perusahaan' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'linkedin_perusahaan' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'instagram_perusahaan' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'logo_perusahaan' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'status_startup' => ['type' => 'ENUM', 'constraint' => ['Aktif', 'Tidak Aktif', 'Lulus'], 'default' => 'Aktif'],
            'status_ajuan' => ['type' => 'ENUM', 'constraint' => ['Verified', 'Pending', 'Rejected'], 'default' => 'Pending'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_startup', true);
        $this->forge->addUniqueKey('uuid_startup');
        $this->forge->addForeignKey('id_dosen_pembina', 'dosen_pembinas', 'id_dosen_pembina', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('id_program', 'programs', 'id_program', 'SET NULL', 'CASCADE');
        $this->forge->createTable('startups');
    }

    public function down()
    {
        $this->forge->dropTable('startups');
    }
}
