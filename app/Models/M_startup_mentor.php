<?php

namespace App\Models;

use CodeIgniter\Model;

// Model untuk mengelola relasi antara startup dan mentor yang membimbing
class M_startup_mentor extends Model
{
    // Mengambil semua mentor yang terkait dengan satu startup beserta detail mentor
    public function get_startup_mentor_by_id_startup($data)
    {
        return $this->db->query("
            SELECT sm.*, m.nama_mentor AS nama_lengkap, m.bidang_keahlian, m.kontak
            FROM startup_mentor sm
            JOIN mentors m ON m.id_mentor = sm.id_mentor
            WHERE sm.id_startup = '" . $data['id_startup'] . "'
        ");
    }

    // Menyimpan relasi baru antara startup dan mentor, mengembalikan ID yang baru dibuat
    public function tambah_startup_mentor($data)
    {
        $db = \Config\Database::connect();
        $db->table('startup_mentor')->insert($data);
        return $db->insertID();
    }

    // Menghapus satu relasi startup-mentor berdasarkan id_startup_mentor
    public function hapus_startup_mentor($data)
    {
        return $this->db->table('startup_mentor')->where('id_startup_mentor', $data['id_startup_mentor'])->delete();
    }
}
