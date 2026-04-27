<?php

namespace App\Models;

use CodeIgniter\Model;

// Model untuk mengelola data tugas kelas
class M_tugas_kelas extends Model
{
    // Mengambil semua tugas berdasarkan id_kelas
    public function tugas_by_kelas($id_kelas)
    {
        return $this->db->table('tugas_kelas')
            ->where('id_kelas', $id_kelas)
            ->orderBy('dibuat_pada', 'DESC')
            ->get()->getResultArray();
    }

    // Mengambil satu tugas berdasarkan id_tugas
    public function tugas_by_id($id_tugas)
    {
        return $this->db->table('tugas_kelas')
            ->where('id_tugas', $id_tugas)
            ->get()->getRowArray();
    }

    // Menyimpan tugas baru
    public function tambah_tugas($data)
    {
        $data['id_tugas']    = bin2hex(random_bytes(16));
        $data['dibuat_pada'] = date('Y-m-d H:i:s');
        return $this->db->table('tugas_kelas')->insert($data);
    }

    // Menghapus tugas berdasarkan id
    public function hapus_tugas($id_tugas)
    {
        return $this->db->table('tugas_kelas')->where('id_tugas', $id_tugas)->delete();
    }
}
