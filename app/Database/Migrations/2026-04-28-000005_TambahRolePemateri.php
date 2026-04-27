<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

// Migration: Menambah nilai 'pemateri' ke kolom role di tabel users
class TambahRolePemateri extends Migration
{
    public function up()
    {
        $this->db->query("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'superadmin', 'pemateri', 'pemilik_startup') NULL");
    }

    public function down()
    {
        $this->db->query("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'superadmin', 'pemilik_startup') NULL");
    }
}
