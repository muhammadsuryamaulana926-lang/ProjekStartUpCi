<?php

namespace App\Models;

use CodeIgniter\Model;

// Model untuk mengelola data anggota tim dari setiap startup
class M_startup_tim extends Model
{
    // Mengambil semua anggota tim dari satu startup diurutkan berdasarkan nama
    public function tim_by_startup($data)
    {
        $query = "SELECT id_tim AS id_startup_tim, nama_lengkap, jabatan AS jabatan_tim, jenis_kelamin,
                         no_whatsapp, email, linkedin, instagram, nama_perguruan_tinggi
                  FROM tim_startups
                  WHERE id_startup = '" . $data['id_startup'] . "'
                  ORDER BY nama_lengkap ASC";
        return $this->db->query($query);
    }

    // Mengambil satu data anggota tim berdasarkan id_tim
    public function tim_by_id($data)
    {
        $query = "SELECT id_tim AS id_startup_tim, nama_lengkap, jabatan AS jabatan_tim, jenis_kelamin,
                         no_whatsapp, email, linkedin, instagram, nama_perguruan_tinggi
                  FROM tim_startups WHERE id_tim = '" . $data['id_tim'] . "'";
        return $this->db->query($query);
    }

    // Menyimpan data anggota tim baru dan mengembalikan ID yang baru dibuat
    public function tambah_tim($data)
    {
        $db = \Config\Database::connect();
        $db->table('tim_startups')->insert($data);
        return $db->insertID();
    }

    // Mengupdate data anggota tim berdasarkan id_tim
    public function ubah_tim($data)
    {
        return $this->db->table('tim_startups')->where('id_tim', $data['id_tim'])->update($data);
    }

    // Menghapus satu anggota tim berdasarkan id_tim
    public function hapus_tim($data)
    {
        return $this->db->table('tim_startups')->where('id_tim', $data['id_tim'])->delete();
    }

    // Menghapus semua anggota tim dari satu startup (digunakan saat startup dihapus)
    public function hapus_tim_by_id_startup($data)
    {
        return $this->db->table('tim_startups')->where('id_startup', $data['id_startup'])->delete();
    }
}
