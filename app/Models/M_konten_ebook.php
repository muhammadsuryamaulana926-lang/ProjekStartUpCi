<?php

namespace App\Models;

use CodeIgniter\Model;

// Model untuk mengelola data konten ebook/referensi
class M_konten_ebook extends Model
{
    // Mengambil semua ebook beserta nama uploader, diurutkan dari yang terbaru
    public function semua_ebook()
    {
        $query = "SELECT ke.*, u.nama_lengkap as nama_uploader
                  FROM konten_ebook ke
                  LEFT JOIN users u ON u.id_user = ke.id_user
                  ORDER BY ke.id_konten_ebook DESC";
        return $this->db->query($query);
    }

    // Mengambil semua ebook dengan status Publik saja
    public function semua_ebook_publik()
    {
        $query = "SELECT ke.*, u.nama_lengkap as nama_uploader
                  FROM konten_ebook ke
                  LEFT JOIN users u ON u.id_user = ke.id_user
                  WHERE ke.status_ebook = 'Publik'
                  ORDER BY ke.id_konten_ebook DESC";
        return $this->db->query($query);
    }

    // Mengambil satu data ebook berdasarkan id_konten_ebook
    public function ebook_by_id($data)
    {
        $query = "SELECT * FROM konten_ebook WHERE id_konten_ebook = '" . $data['id_konten_ebook'] . "'";
        return $this->db->query($query);
    }

    // Mengambil satu data ebook berdasarkan uuid_konten_ebook
    public function ebook_by_uuid($data)
    {
        $query = "SELECT * FROM konten_ebook WHERE uuid_konten_ebook = '" . $data['uuid_konten_ebook'] . "'";
        return $this->db->query($query);
    }

    // Menyimpan data ebook baru dan mengembalikan ID yang baru dibuat
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

    // Mengupdate data ebook berdasarkan id_konten_ebook
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

    // Menghapus data ebook berdasarkan id_konten_ebook
    public function hapus_ebook($data)
    {
        return $this->db->table('konten_ebook')->where('id_konten_ebook', $data['id_konten_ebook'])->delete();
    }
}
