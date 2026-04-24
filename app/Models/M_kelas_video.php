<?php

namespace App\Models;

use CodeIgniter\Model;

class M_kelas_video extends Model
{
    // Mengambil semua video berdasarkan id_kelas diurutkan urutan
    public function video_by_kelas($id_kelas)
    {
        return $this->db->table('kelas_video')
            ->where('id_kelas', $id_kelas)
            ->orderBy('urutan', 'ASC')
            ->get()->getResultArray();
    }

    // Menyimpan data video sesi baru
    public function tambah_video_sesi($data)
    {
        $data['dibuat_pada'] = date('Y-m-d H:i:s');
        return $this->db->table('kelas_video')->insert($data);
    }

    // Menghapus semua video berdasarkan id_kelas
    public function hapus_video_by_kelas($id_kelas)
    {
        return $this->db->table('kelas_video')->where('id_kelas', $id_kelas)->delete();
    }
}
