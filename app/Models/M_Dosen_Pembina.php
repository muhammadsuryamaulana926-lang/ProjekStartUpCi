<?php

namespace App\Models;

use CodeIgniter\Model;

// Model untuk mengelola data dosen pembina startup
class M_dosen_pembina extends Model
{
    // Mengambil semua data dosen pembina diurutkan berdasarkan nama
    public function semua_dosen()
    {
        $query = "SELECT id_dosen_pembina, nama_lengkap, nip, fakultas, kontak
                  FROM dosen_pembinas
                  ORDER BY nama_lengkap ASC";
        return $this->db->query($query);
    }

    // Mengambil satu data dosen pembina berdasarkan id_dosen_pembina
    public function dosen_by_id($data)
    {
        $query = "SELECT * FROM dosen_pembinas WHERE id_dosen_pembina = '" . $data['id_dosen_pembina'] . "'";
        return $this->db->query($query);
    }

    // Mengambil semua dosen beserta jumlah startup yang mereka bina
    public function dosen_dengan_jumlah_startup()
    {
        $query = "SELECT d.id_dosen_pembina, d.nama_lengkap, d.fakultas, COUNT(s.id_startup) as jumlah_startup
                  FROM dosen_pembinas d
                  LEFT JOIN startups s ON s.id_dosen_pembina = d.id_dosen_pembina
                  GROUP BY d.id_dosen_pembina
                  ORDER BY jumlah_startup DESC";
        return $this->db->query($query);
    }

    // Menyimpan data dosen pembina baru dan mengembalikan ID yang baru dibuat
    public function tambah_dosen($data)
    {
        $db = \Config\Database::connect();
        $db->table('dosen_pembinas')->insert($data);
        return $db->insertID();
    }

    // Mengupdate data dosen pembina berdasarkan id_dosen_pembina
    public function ubah_dosen($data)
    {
        return $this->db->table('dosen_pembinas')->where('id_dosen_pembina', $data['id_dosen_pembina'])->update($data);
    }

    // Menghapus data dosen pembina berdasarkan id_dosen_pembina
    public function hapus_dosen($data)
    {
        return $this->db->table('dosen_pembinas')->where('id_dosen_pembina', $data['id_dosen_pembina'])->delete();
    }
}
