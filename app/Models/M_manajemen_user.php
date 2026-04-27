<?php

namespace App\Models;

use CodeIgniter\Model;

// Model untuk mengelola data user oleh admin (manajemen user)
class M_manajemen_user extends Model
{
    protected $table         = 'users';
    protected $primaryKey    = 'id_user';
    protected $allowedFields = ['nama_lengkap', 'email', 'password', 'role', 'is_active'];
    protected $useTimestamps = true;

    // Mengambil semua user kecuali superadmin
    public function semua_user()
    {
        return $this->db->table('users')
            ->where('role !=', 'superadmin')
            ->orderBy('created_at', 'DESC')
            ->get()->getResultArray();
    }

    // Mengambil data user berdasarkan id
    public function user_by_id($id_user)
    {
        return $this->db->table('users')
            ->where('id_user', $id_user)
            ->get()->getRowArray();
    }

    // Mengecek apakah email sudah digunakan user lain
    public function cek_email_duplikat($email, $kecuali_id = null)
    {
        $builder = $this->db->table('users')->where('email', $email);
        if ($kecuali_id) {
            $builder->where('id_user !=', $kecuali_id);
        }
        return $builder->countAllResults() > 0;
    }

    // Menyimpan user baru
    public function tambah_user($data)
    {
        return $this->db->table('users')->insert($data);
    }

    // Memperbarui data user berdasarkan id
    public function ubah_user($id_user, $data)
    {
        return $this->db->table('users')->where('id_user', $id_user)->update($data);
    }

    // Mengubah status aktif/nonaktif user
    public function toggle_aktif($id_user, $status)
    {
        return $this->db->table('users')->where('id_user', $id_user)->update(['is_active' => $status]);
    }

    // Menghapus user berdasarkan id
    public function hapus_user($id_user)
    {
        return $this->db->table('users')->where('id_user', $id_user)->delete();
    }
}
