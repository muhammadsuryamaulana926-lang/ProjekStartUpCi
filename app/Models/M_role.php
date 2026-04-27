<?php

namespace App\Models;

use CodeIgniter\Model;

// Model untuk mengelola data role secara dinamis
class M_role extends Model
{
    // Mengambil semua role kecuali superadmin
    public function semua_role()
    {
        return $this->db->table('roles')
            ->where('nama_role !=', 'superadmin')
            ->orderBy('id_role', 'ASC')
            ->get()->getResultArray();
    }

    // Mengecek apakah nama_role sudah ada
    public function cek_duplikat($nama_role)
    {
        return $this->db->table('roles')->where('nama_role', $nama_role)->countAllResults() > 0;
    }

    // Menyimpan role baru
    public function tambah_role($nama_role, $label)
    {
        return $this->db->table('roles')->insert([
            'nama_role'   => strtolower(str_replace(' ', '_', $nama_role)),
            'label'       => $label,
            'dibuat_pada' => date('Y-m-d H:i:s'),
        ]);
    }
}
