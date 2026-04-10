<?php

namespace App\Models;

use CodeIgniter\Model;

// Model untuk mengelola data klaster/kategori startup
class M_klaster extends Model
{
    // Mengambil semua data klaster diurutkan berdasarkan nama
    public function semua_klaster()
    {
        $query = "SELECT id_klaster, nama_klaster FROM klasters ORDER BY nama_klaster ASC";
        return $this->db->query($query);
    }

    // Mengambil satu data klaster berdasarkan id_klaster
    public function klaster_by_id($data)
    {
        $query = "SELECT * FROM klasters WHERE id_klaster = '" . $data['id_klaster'] . "'";
        return $this->db->query($query);
    }

    // Mengambil semua klaster beserta jumlah startup yang tergabung di dalamnya
    public function klaster_dengan_jumlah_startup()
    {
        $query = "SELECT k.id_klaster, k.nama_klaster, COUNT(sk.id_startup) as jumlah_startup
                  FROM klasters k
                  LEFT JOIN startup_klaster sk ON sk.id_klaster = k.id_klaster
                  GROUP BY k.id_klaster
                  ORDER BY jumlah_startup DESC";
        return $this->db->query($query);
    }

    // Menyimpan data klaster baru dan mengembalikan ID yang baru dibuat
    public function tambah_klaster($data)
    {
        $db = \Config\Database::connect();
        $db->table('klasters')->insert($data);
        return $db->insertID();
    }

    // Mengupdate data klaster berdasarkan id_klaster
    public function ubah_klaster($data)
    {
        return $this->db->table('klasters')->where('id_klaster', $data['id_klaster'])->update($data);
    }

    // Menghapus data klaster berdasarkan id_klaster
    public function hapus_klaster($data)
    {
        return $this->db->table('klasters')->where('id_klaster', $data['id_klaster'])->delete();
    }
}
