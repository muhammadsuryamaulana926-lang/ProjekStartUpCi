<?php

namespace App\Models;

use CodeIgniter\Model;

// Model untuk mengelola data mentor startup
class M_mentor extends Model
{
    // Mengambil semua data mentor diurutkan berdasarkan nama
    public function get_mentor_all()
    {
        return $this->db->query("SELECT *, nama_mentor AS nama_lengkap FROM mentors ORDER BY nama_mentor ASC");
    }

    // Mengambil satu data mentor berdasarkan id_mentor
    public function get_mentor_by_id($data)
    {
        return $this->db->query("SELECT *, nama_mentor AS nama_lengkap FROM mentors WHERE id_mentor = '" . $data['id_mentor'] . "'");
    }
}
