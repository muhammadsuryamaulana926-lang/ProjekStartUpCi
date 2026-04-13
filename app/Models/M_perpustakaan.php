<?php

namespace App\Models;

use CodeIgniter\Model;

// Model gabungan untuk mengelola data perpustakaan (Ebook & Video)
class M_perpustakaan extends Model
{
    // ── VIDEO METHODS ─────────────────────────────────────────────

    // Mengambil semua video beserta nama uploader
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

    public function video_by_id($data)
    {
        $query = "SELECT * FROM konten_video WHERE id_konten_video = '" . $data['id_konten_video'] . "'";
        return $this->db->query($query);
    }

    public function video_by_uuid($data)
    {
        $query = "SELECT * FROM konten_video WHERE uuid_konten_video = '" . $data['uuid_konten_video'] . "'";
        return $this->db->query($query);
    }

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

    public function hapus_video($data)
    {
        return $this->db->table('konten_video')->where('id_konten_video', $data['id_konten_video'])->delete();
    }

    public function decode_kode_video($kode)
    {
        return base64_decode($kode);
    }

    // ── EBOOK METHODS ─────────────────────────────────────────────

    public function semua_ebook()
    {
        $query = "SELECT ke.*, u.nama_lengkap as nama_uploader
                  FROM konten_ebook ke
                  LEFT JOIN users u ON u.id_user = ke.id_user
                  ORDER BY ke.id_konten_ebook DESC";
        return $this->db->query($query);
    }

    public function semua_ebook_publik()
    {
        $query = "SELECT ke.*, u.nama_lengkap as nama_uploader
                  FROM konten_ebook ke
                  LEFT JOIN users u ON u.id_user = ke.id_user
                  WHERE ke.status_ebook = 'Publik'
                  ORDER BY ke.id_konten_ebook DESC";
        return $this->db->query($query);
    }

    public function ebook_by_id($data)
    {
        $query = "SELECT * FROM konten_ebook WHERE id_konten_ebook = '" . $data['id_konten_ebook'] . "'";
        return $this->db->query($query);
    }

    public function ebook_by_uuid($data)
    {
        $query = "SELECT * FROM konten_ebook WHERE uuid_konten_ebook = '" . $data['uuid_konten_ebook'] . "'";
        return $this->db->query($query);
    }

    public function tambah_ebook($data)
    {
        $insert = [
            'id_user'           => $data['id_user'],
            'judul_ebook'       => $data['judul_ebook'],
            'deskripsi_ebook'   => $data['deskripsi_ebook'] ?? null,
            'penulis_ebook'     => $data['penulis_ebook'] ?? null,
            'file_ebook'        => $data['file_ebook'],
            'sampul_ebook'      => $data['sampul_ebook'] ?? null,
            'status_ebook'      => $data['status_ebook'] ?? 'Publik',
            'uuid_konten_ebook' => bin2hex(random_bytes(16)),
        ];
        $db = \Config\Database::connect();
        $db->table('konten_ebook')->insert($insert);
        return $db->insertID();
    }

    public function ubah_ebook($data)
    {
        $update = [
            'judul_ebook'    => $data['judul_ebook'],
            'deskripsi_ebook'=> $data['deskripsi_ebook'] ?? null,
            'penulis_ebook'  => $data['penulis_ebook'] ?? null,
            'status_ebook'   => $data['status_ebook'],
        ];
        if (!empty($data['file_ebook']))   $update['file_ebook']   = $data['file_ebook'];
        if (!empty($data['sampul_ebook'])) $update['sampul_ebook'] = $data['sampul_ebook'];
        return $this->db->table('konten_ebook')->where('id_konten_ebook', $data['id_konten_ebook'])->update($update);
    }

    public function hapus_ebook($data)
    {
        return $this->db->table('konten_ebook')->where('id_konten_ebook', $data['id_konten_ebook'])->delete();
    }
}
