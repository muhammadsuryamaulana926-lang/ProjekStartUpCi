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

    // Ambil video Publik + Privat yang user punya akses
    public function semua_video_publik_dan_akses($id_user)
    {
        $query = "SELECT kv.*, u.nama_lengkap as nama_uploader
                  FROM konten_video kv
                  LEFT JOIN users u ON u.id_user = kv.id_user
                  WHERE kv.status_video = 'Publik'
                     OR (kv.status_video = 'Privat' AND EXISTS (
                         SELECT 1 FROM konten_akses ka
                         WHERE ka.tipe = 'video' AND ka.id_konten = kv.id_konten_video AND ka.id_user = " . (int)$id_user . "
                     ))
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

    // Ambil ebook Publik + Privat yang user punya akses
    public function semua_ebook_publik_dan_akses($id_user)
    {
        $query = "SELECT ke.*, u.nama_lengkap as nama_uploader
                  FROM konten_ebook ke
                  LEFT JOIN users u ON u.id_user = ke.id_user
                  WHERE ke.status_ebook = 'Publik'
                     OR (ke.status_ebook = 'Privat' AND EXISTS (
                         SELECT 1 FROM konten_akses ka
                         WHERE ka.tipe = 'ebook' AND ka.id_konten = ke.id_konten_ebook AND ka.id_user = " . (int)$id_user . "
                     ))
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

    // ── AKSES WHITELIST ───────────────────────────────────────────

    public function cek_akses($tipe, $id_konten, $id_user)
    {
        return $this->db->table('konten_akses')
            ->where(['tipe' => $tipe, 'id_konten' => $id_konten, 'id_user' => $id_user])
            ->countAllResults() > 0;
    }

    public function get_akses($tipe, $id_konten)
    {
        return $this->db->table('konten_akses ka')
            ->select('ka.id, ka.id_user, u.nama_lengkap, u.email')
            ->join('users u', 'u.id_user = ka.id_user')
            ->where(['ka.tipe' => $tipe, 'ka.id_konten' => $id_konten])
            ->get()->getResult();
    }

    public function tambah_akses($tipe, $id_konten, $id_user)
    {
        if ($this->cek_akses($tipe, $id_konten, $id_user)) return false;
        return $this->db->table('konten_akses')->insert([
            'tipe'      => $tipe,
            'id_konten' => $id_konten,
            'id_user'   => $id_user,
        ]);
    }

    public function hapus_akses($id)
    {
        return $this->db->table('konten_akses')->where('id', $id)->delete();
    }

    public function semua_user()
    {
        return $this->db->table('users')->select('id_user, nama_lengkap, email')->whereNotIn('role', ['admin'])->where('is_active', 1)->get()->getResult();
    }
}
