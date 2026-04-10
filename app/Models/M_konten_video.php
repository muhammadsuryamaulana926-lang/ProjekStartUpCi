<?php

namespace App\Models;

use CodeIgniter\Model;

// Model untuk mengelola data konten video pembelajaran
class M_konten_video extends Model
{
    // Mengambil semua video beserta nama uploader, diurutkan dari yang terbaru
    public function semua_video()
    {
        $query = "SELECT kv.*, u.nama_lengkap as nama_uploader
                  FROM konten_video kv
                  LEFT JOIN users u ON u.id_user = kv.id_user
                  ORDER BY kv.id_konten_video DESC";
        return $this->db->query($query);
    }

    // Mengambil semua video dengan status Publik saja
    public function semua_video_publik()
    {
        $query = "SELECT kv.*, u.nama_lengkap as nama_uploader
                  FROM konten_video kv
                  LEFT JOIN users u ON u.id_user = kv.id_user
                  WHERE kv.status_video = 'Publik'
                  ORDER BY kv.id_konten_video DESC";
        return $this->db->query($query);
    }

    // Mengambil satu data video berdasarkan id_konten_video
    public function video_by_id($data)
    {
        $query = "SELECT * FROM konten_video WHERE id_konten_video = '" . $data['id_konten_video'] . "'";
        return $this->db->query($query);
    }

    // Mengambil satu data video berdasarkan uuid_konten_video
    public function video_by_uuid($data)
    {
        $query = "SELECT * FROM konten_video WHERE uuid_konten_video = '" . $data['uuid_konten_video'] . "'";
        return $this->db->query($query);
    }

    // Menyimpan data video baru, YouTube ID di-encode base64 sebelum disimpan
    public function tambah_video($data)
    {
        $insert = [
            'id_user'           => $data['id_user'],
            'judul_video'       => $data['judul_video'],
            'deskripsi_video'   => $data['deskripsi_video'] ?? null,
            'kode_video'        => base64_encode($data['kode_video']),
            'status_video'      => $data['status_video'] ?? 'Publik',
            'uuid_konten_video' => bin2hex(random_bytes(16)),
        ];
        $db = \Config\Database::connect();
        $db->table('konten_video')->insert($insert);
        return $db->insertID();
    }

    // Mengupdate data video berdasarkan id_konten_video
    public function ubah_video($data)
    {
        $update = [
            'judul_video'     => $data['judul_video'],
            'deskripsi_video' => $data['deskripsi_video'] ?? null,
            'kode_video'      => base64_encode($data['kode_video']),
            'status_video'    => $data['status_video'],
        ];
        return $this->db->table('konten_video')->where('id_konten_video', $data['id_konten_video'])->update($update);
    }

    // Menghapus data video berdasarkan id_konten_video
    public function hapus_video($data)
    {
        return $this->db->table('konten_video')->where('id_konten_video', $data['id_konten_video'])->delete();
    }

    // Decode kode_video dari base64 menjadi YouTube ID asli (digunakan di view)
    public function decode_kode_video($kode)
    {
        return base64_decode($kode);
    }
}
