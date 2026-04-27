<?php

namespace App\Models;

use CodeIgniter\Model;

// Model untuk mengelola data materi kelas di tabel materi_kelas
class M_materi_kelas extends Model
{
    // Mengambil semua materi berdasarkan id_kelas
    public function materi_by_kelas($id_kelas)
    {
        return $this->db->table('materi_kelas')
            ->where('id_kelas', $id_kelas)
            ->orderBy('dibuat_pada', 'DESC')
            ->get()->getResultArray();
    }

    // Mengambil satu materi berdasarkan id_materi
    public function materi_by_id($id_materi)
    {
        return $this->db->table('materi_kelas')
            ->where('id_materi', $id_materi)
            ->get()->getRowArray();
    }

    // Mengambil semua materi dari semua kelas dalam satu program
    public function materi_by_program($id_program)
    {
        return $this->db->table('materi_kelas mk')
            ->select('mk.*, ks.nama_kelas, ks.tanggal, ks.id_program')
            ->join('kelas_startup ks', 'ks.id_kelas = mk.id_kelas')
            ->where('ks.id_program', $id_program)
            ->orderBy('mk.dibuat_pada', 'DESC')
            ->get()->getResultArray();
    }

    // Menyimpan materi baru
    public function tambah_materi($data)
    {
        $data['id_materi']   = bin2hex(random_bytes(16));
        $data['dibuat_pada'] = date('Y-m-d H:i:s');
        return $this->db->table('materi_kelas')->insert($data);
    }

    // Menghapus materi berdasarkan id_materi dan mengembalikan nama file
    public function hapus_materi($id_materi)
    {
        return $this->db->table('materi_kelas')->where('id_materi', $id_materi)->delete();
    }
}
