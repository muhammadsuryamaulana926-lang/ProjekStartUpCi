<?php

namespace App\Models;

use CodeIgniter\Model;

// Model untuk mengelola data pengguna (user) aplikasi
class M_user extends Model
{
    protected $table         = 'users';
    protected $primaryKey    = 'id_user';
    protected $allowedFields = ['nama_lengkap', 'email', 'password', 'role', 'is_active'];
    protected $useTimestamps = true;

    // Mencari data user berdasarkan alamat email
    public function cari_by_email(string $email)
    {
        return $this->where('email', $email)->first();
    }

    // Mengambil semua user dengan role pemateri yang aktif
    public function pemateri_aktif()
    {
        return $this->where('role', 'pemateri')->where('is_active', 1)->findAll();
    }
}
