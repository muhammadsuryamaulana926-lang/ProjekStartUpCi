<?php

namespace App\Models;

use CodeIgniter\Model;

class M_kelas_video_chapter extends Model
{
    // Mengambil semua chapter berdasarkan id_kelas_video
    public function chapter_by_video($id_kelas_video)
    {
        return $this->db->table('kelas_video_chapter')
            ->where('id_kelas_video', $id_kelas_video)
            ->orderBy('urutan', 'ASC')
            ->get()->getResultArray();
    }

    // Mengambil semua chapter berdasarkan banyak id_kelas_video sekaligus
    public function chapter_by_banyak_video(array $ids)
    {
        if (empty($ids)) return [];
        return $this->db->table('kelas_video_chapter')
            ->whereIn('id_kelas_video', $ids)
            ->orderBy('id_kelas_video')->orderBy('urutan')
            ->get()->getResultArray();
    }

    // Menyimpan data chapter baru
    public function tambah_chapter($data)
    {
        return $this->db->table('kelas_video_chapter')->insert($data);
    }

    // Menghapus semua chapter berdasarkan id_kelas_video
    public function hapus_chapter_by_video($id_kelas_video)
    {
        return $this->db->table('kelas_video_chapter')
            ->where('id_kelas_video', $id_kelas_video)->delete();
    }

    // Menghapus semua chapter berdasarkan banyak id_kelas_video sekaligus
    public function hapus_chapter_by_banyak_video(array $ids)
    {
        if (empty($ids)) return;
        $this->db->table('kelas_video_chapter')->whereIn('id_kelas_video', $ids)->delete();
    }
}
