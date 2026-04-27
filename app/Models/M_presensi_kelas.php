<?php

namespace App\Models;

use CodeIgniter\Model;

// Model untuk mengelola data presensi/check-in peserta kelas
class M_presensi_kelas extends Model
{
    // Mengambil semua presensi berdasarkan id_kelas
    public function presensi_by_kelas($id_kelas)
    {
        return $this->db->table('presensi_kelas')
            ->where('id_kelas', $id_kelas)
            ->orderBy('dibuat_pada', 'ASC')
            ->get()->getResultArray();
    }

    // Mengecek apakah peserta sudah presensi di kelas ini
    public function cek_sudah_presensi($id_kelas, $nama_peserta)
    {
        return $this->db->table('presensi_kelas')
            ->where('id_kelas', $id_kelas)
            ->where('nama_peserta', $nama_peserta)
            ->countAllResults() > 0;
    }

    // Menyimpan data presensi baru
    public function simpan_presensi($data)
    {
        $data['id_presensi'] = bin2hex(random_bytes(16));
        $data['dibuat_pada'] = date('Y-m-d H:i:s');
        return $this->db->table('presensi_kelas')->insert($data);
    }

    // Menghapus presensi berdasarkan id
    public function hapus_presensi($id_presensi)
    {
        return $this->db->table('presensi_kelas')->where('id_presensi', $id_presensi)->delete();
    }
}
