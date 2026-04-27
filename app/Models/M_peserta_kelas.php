<?php

namespace App\Models;

use CodeIgniter\Model;

// Model untuk mengelola data peserta kelas yang diassign oleh admin
class M_peserta_kelas extends Model
{
    // Mengambil semua peserta berdasarkan id_kelas
    public function peserta_by_kelas($id_kelas)
    {
        return $this->db->table('peserta_kelas')
            ->where('id_kelas', $id_kelas)
            ->orderBy('dibuat_pada', 'ASC')
            ->get()->getResultArray();
    }

    // Mengecek apakah peserta sudah terdaftar di kelas ini
    public function cek_sudah_terdaftar($id_kelas, $nama_peserta)
    {
        return $this->db->table('peserta_kelas')
            ->where('id_kelas', $id_kelas)
            ->where('nama_peserta', $nama_peserta)
            ->countAllResults() > 0;
    }

    // Menambah peserta ke kelas
    public function tambah_peserta($data)
    {
        $data['id_peserta_kelas'] = bin2hex(random_bytes(16));
        $data['dibuat_pada']      = date('Y-m-d H:i:s');
        return $this->db->table('peserta_kelas')->insert($data);
    }

    // Menghapus peserta dari kelas
    public function hapus_peserta($id_peserta_kelas)
    {
        return $this->db->table('peserta_kelas')->where('id_peserta_kelas', $id_peserta_kelas)->delete();
    }
}
