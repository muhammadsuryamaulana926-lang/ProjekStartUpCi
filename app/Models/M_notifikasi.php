<?php

namespace App\Models;

use CodeIgniter\Model;

class M_notifikasi extends Model
{
    // Mengambil semua notifikasi yang belum dibaca berdasarkan role
    public function semua_belum_dibaca($role = 'admin')
    {
        $nama = session()->get('user_name');
        return $this->db->table('notifikasi')
            ->where('sudah_dibaca', 0)
            ->groupStart()
                ->where('untuk_role', $role)
                ->orWhere('untuk_nama', $nama)
            ->groupEnd()
            ->orderBy('dibuat_pada', 'DESC')
            ->limit(20)
            ->get()->getResultArray();
    }

    // Menghitung jumlah notifikasi belum dibaca berdasarkan role
    public function hitung_belum_dibaca($role = 'admin')
    {
        return $this->db->table('notifikasi')
            ->where('sudah_dibaca', 0)
            ->where('untuk_role', $role)
            ->countAllResults();
    }

    // Menyimpan notifikasi baru
    public function tambah_notifikasi($data)
    {
        $data['dibuat_pada'] = date('Y-m-d H:i:s');
        return $this->db->table('notifikasi')->insert($data);
    }

    // Menandai satu notifikasi sebagai sudah dibaca
    public function tandai_dibaca($id)
    {
        return $this->db->table('notifikasi')
            ->where('id_notifikasi', $id)
            ->update(['sudah_dibaca' => 1]);
    }

    // Menandai semua notifikasi sebagai sudah dibaca berdasarkan role
    public function tandai_semua_dibaca($role = 'admin')
    {
        $nama = session()->get('user_name');
        return $this->db->table('notifikasi')
            ->where('sudah_dibaca', 0)
            ->groupStart()
                ->where('untuk_role', $role)
                ->orWhere('untuk_nama', $nama)
            ->groupEnd()
            ->update(['sudah_dibaca' => 1]);
    }
}
