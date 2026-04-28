<?php

namespace App\Models;

use CodeIgniter\Model;

// Model untuk mengelola data user oleh admin (manajemen user)
class M_manajemen_user extends Model
{
    protected $table         = 'users';
    protected $primaryKey    = 'id_user';
    protected $allowedFields = ['uuid_user', 'nama_lengkap', 'email', 'password', 'role', 'is_active'];
    protected $useTimestamps = true;

    // Mengambil semua user kecuali superadmin
    public function semua_user()
    {
        return $this->db->table('users')
            ->where('role !=', 'superadmin')
            ->orderBy('created_at', 'DESC')
            ->get()->getResultArray();
    }

    // Mengambil data user berdasarkan uuid
    public function user_by_uuid($uuid)
    {
        return $this->db->table('users')
            ->where('uuid_user', $uuid)
            ->get()->getRowArray();
    }

    // Mengecek apakah email sudah digunakan user lain
    public function cek_email_duplikat($email, $kecuali_uuid = null)
    {
        $builder = $this->db->table('users')->where('email', $email);
        if ($kecuali_uuid) {
            $builder->where('uuid_user !=', $kecuali_uuid);
        }
        return $builder->countAllResults() > 0;
    }

    // Menyimpan user baru dan mengembalikan id yang baru dibuat
    public function tambah_user($data)
    {
        $data['uuid_user'] = bin2hex(random_bytes(16));
        $this->db->table('users')->insert($data);
        return $this->db->insertID();
    }

    // Memperbarui data user berdasarkan uuid
    public function ubah_user($uuid, $data)
    {
        return $this->db->table('users')->where('uuid_user', $uuid)->update($data);
    }

    // Mengubah status aktif/nonaktif user
    public function toggle_aktif($uuid, $status)
    {
        return $this->db->table('users')->where('uuid_user', $uuid)->update(['is_active' => $status]);
    }

    // Menghapus user berdasarkan uuid
    public function hapus_user($uuid)
    {
        return $this->db->table('users')->where('uuid_user', $uuid)->delete();
    }
}
