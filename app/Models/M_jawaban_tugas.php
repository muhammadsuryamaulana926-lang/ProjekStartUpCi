<?php

namespace App\Models;

use CodeIgniter\Model;

// Model untuk mengelola data jawaban tugas peserta
class M_jawaban_tugas extends Model
{
    // Mengambil semua jawaban berdasarkan id_tugas
    public function jawaban_by_tugas($id_tugas)
    {
        return $this->db->table('jawaban_tugas')
            ->where('id_tugas', $id_tugas)
            ->orderBy('dibuat_pada', 'ASC')
            ->get()->getResultArray();
    }

    // Mengambil jawaban milik peserta tertentu
    public function jawaban_by_peserta($id_tugas, $nama_peserta)
    {
        return $this->db->table('jawaban_tugas')
            ->where('id_tugas', $id_tugas)
            ->where('nama_peserta', $nama_peserta)
            ->get()->getRowArray();
    }

    // Mengambil satu jawaban berdasarkan id
    public function jawaban_by_id($id_jawaban)
    {
        return $this->db->table('jawaban_tugas')
            ->where('id_jawaban', $id_jawaban)
            ->get()->getRowArray();
    }

    // Menyimpan jawaban baru
    public function simpan_jawaban($data)
    {
        $data['id_jawaban']  = bin2hex(random_bytes(16));
        $data['dibuat_pada'] = date('Y-m-d H:i:s');
        return $this->db->table('jawaban_tugas')->insert($data);
    }

    // Menyimpan komentar pemateri ke jawaban
    public function simpan_komentar($id_jawaban, $komentar)
    {
        return $this->db->table('jawaban_tugas')
            ->where('id_jawaban', $id_jawaban)
            ->update(['komentar' => $komentar]);
    }

    // Menghitung jawaban belum dikomentari berdasarkan id_kelas
    public function hitung_belum_dikomentari_by_kelas($id_kelas)
    {
        return $this->db->table('jawaban_tugas jt')
            ->join('tugas_kelas tk', 'tk.id_tugas = jt.id_tugas')
            ->where('tk.id_kelas', $id_kelas)
            ->where('jt.komentar IS NULL', null, false)
            ->countAllResults();
    }

    // Menghapus jawaban berdasarkan id
    public function hapus_jawaban($id_jawaban)
    {
        return $this->db->table('jawaban_tugas')->where('id_jawaban', $id_jawaban)->delete();
    }
}
