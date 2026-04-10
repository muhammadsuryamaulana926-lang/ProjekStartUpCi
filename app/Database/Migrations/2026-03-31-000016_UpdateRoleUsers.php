<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

// Migration: update ENUM role di tabel users, tambah nilai pemilik_startup
class UpdateRoleUsers extends Migration
{
    public function up()
    {
        $this->db->query("ALTER TABLE users MODIFY COLUMN role ENUM('admin','user','pemilik_startup') NOT NULL DEFAULT 'user'");
    }

    public function down()
    {
        $this->db->query("ALTER TABLE users MODIFY COLUMN role ENUM('admin','user') NOT NULL DEFAULT 'admin'");
    }
}
