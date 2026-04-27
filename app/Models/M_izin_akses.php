<?php

namespace App\Models;

use CodeIgniter\Model;

// Model untuk mengelola data izin akses per role per modul
class M_izin_akses extends Model
{
    protected $table         = 'izin_akses';
    protected $primaryKey    = 'id_izin';
    protected $allowedFields = ['role', 'modul', 'bisa_lihat', 'bisa_tambah', 'bisa_edit', 'bisa_hapus'];
    protected $useTimestamps = false;

    // Mengambil semua izin akses berdasarkan role
    public function izin_by_role($role)
    {
        return $this->where('role', $role)->findAll();
    }

    // Mengambil izin akses spesifik berdasarkan role dan modul
    public function izin_by_role_modul($role, $modul)
    {
        return $this->where('role', $role)->where('modul', $modul)->first();
    }

    // Mengambil semua role yang terdaftar di tabel izin_akses
    public function semua_role()
    {
        return $this->db->table('izin_akses')->select('role')->distinct()->get()->getResultArray();
    }

    // Menyimpan atau memperbarui izin akses (upsert berdasarkan role + modul)
    public function simpan_izin($data)
    {
        $existing = $this->izin_by_role_modul($data['role'], $data['modul']);
        if ($existing) {
            return $this->where('id_izin', $existing['id_izin'])->set($data)->update();
        }
        return $this->insert($data);
    }

    // Memperbarui izin akses berdasarkan role (batch update dari form matrix)
    public function update_izin_role($role, array $permissions)
    {
        foreach ($permissions as $modul => $izin) {
            $this->simpan_izin([
                'role'        => $role,
                'modul'       => $modul,
                'bisa_lihat'  => $izin['bisa_lihat']  ?? 0,
                'bisa_tambah' => $izin['bisa_tambah'] ?? 0,
                'bisa_edit'   => $izin['bisa_edit']   ?? 0,
                'bisa_hapus'  => $izin['bisa_hapus']  ?? 0,
            ]);
        }
        return true;
    }
}
