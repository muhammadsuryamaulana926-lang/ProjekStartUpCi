<?php

namespace App\Models;

use CodeIgniter\Model;

// Model untuk mengelola relasi many-to-many antara startup dan klaster
class M_startup_klaster extends Model
{
    // Mengambil semua klaster yang dimiliki oleh satu startup berdasarkan id_startup
    public function klaster_by_startup($data)
    {
        $query = "SELECT k.id_klaster, k.nama_klaster
                  FROM startup_klaster sk
                  JOIN klasters k ON k.id_klaster = sk.id_klaster
                  WHERE sk.id_startup = '" . $data['id_startup'] . "'";
        return $this->db->query($query);
    }

    // Mengambil hanya id_klaster dari startup tertentu (digunakan untuk pre-select form edit)
    public function id_klaster_by_startup($data)
    {
        $query = "SELECT id_klaster FROM startup_klaster WHERE id_startup = '" . $data['id_startup'] . "'";
        return $this->db->query($query);
    }

    // Menyimpan relasi baru antara startup dan klaster
    public function simpan_klaster($data)
    {
        return $this->db->table('startup_klaster')->insert($data);
    }

    // Menghapus semua relasi klaster milik satu startup (digunakan sebelum menyimpan ulang klaster)
    public function hapus_klaster_by_startup($data)
    {
        return $this->db->table('startup_klaster')->where('id_startup', $data['id_startup'])->delete();
    }
}
