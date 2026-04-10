<?php

namespace App\Models;

use CodeIgniter\Model;

// Model untuk mengelola riwayat perubahan status startup
class M_startup_histori_status extends Model
{
    // Mengambil semua riwayat perubahan status berdasarkan id_startup, beserta nama pengguna yang mengubah
    public function get_startup_histori_status_by_id_startup($data)
    {
        return $this->db->query("
            SELECT sh.*, u.nama_lengkap
            FROM startup_histori_status sh
            LEFT JOIN users u ON u.id_user = sh.id_pengguna
            WHERE sh.id_startup = '" . $data['id_startup'] . "'
            ORDER BY sh.tgl_buat DESC
        ");
    }

    // Menyimpan riwayat perubahan status startup baru dan mengembalikan ID yang baru dibuat
    public function tambah_startup_histori_status($data)
    {
        $db = \Config\Database::connect();
        $db->table('startup_histori_status')->insert($data);
        return $db->insertID();
    }
}
