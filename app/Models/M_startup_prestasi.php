<?php

namespace App\Models;

use CodeIgniter\Model;

// Model untuk mengelola data prestasi/penghargaan yang diraih startup
class M_startup_prestasi extends Model
{
    // Mengambil semua prestasi milik satu startup diurutkan dari tahun terbaru
    public function get_startup_prestasi_by_id_startup($data)
    {
        return $this->db->query("SELECT * FROM prestasi_startups WHERE id_startup = '" . $data['id_startup'] . "' ORDER BY tahun DESC");
    }

    // Mengambil satu data prestasi berdasarkan id_prestasi
    public function get_startup_prestasi_by_id($data)
    {
        return $this->db->query("SELECT * FROM prestasi_startups WHERE id_prestasi = '" . $data['id_startup_prestasi'] . "'");
    }

    // Menyimpan data prestasi baru dengan UUID otomatis, mengembalikan ID yang baru dibuat
    public function tambah_startup_prestasi($data)
    {
        $insert = [
            'id_startup'    => $data['id_startup'],
            'nama_prestasi' => $data['nama_kegiatan'] ?? null,
            'tingkat'       => $data['deskripsi_prestasi'] ?? null,
            'tahun'         => $data['tahun'] ?? null,
            'uuid_prestasi' => bin2hex(random_bytes(16)),
        ];
        $db = \Config\Database::connect();
        $db->table('prestasi_startups')->insert($insert);
        return $db->insertID();
    }

    // Mengupdate data prestasi berdasarkan id_prestasi
    public function ubah_startup_prestasi($data)
    {
        $update = [
            'nama_prestasi' => $data['nama_kegiatan'] ?? null,
            'tingkat'       => $data['deskripsi_prestasi'] ?? null,
            'tahun'         => $data['tahun'] ?? null,
        ];
        return $this->db->table('prestasi_startups')->where('id_prestasi', $data['id_startup_prestasi'])->update($update);
    }

    // Menghapus satu data prestasi berdasarkan id_prestasi
    public function hapus_startup_prestasi($data)
    {
        return $this->db->table('prestasi_startups')->where('id_prestasi', $data['id_startup_prestasi'])->delete();
    }

    // Menghapus semua prestasi milik satu startup (digunakan saat startup dihapus)
    public function hapus_startup_prestasi_by_id_startup($data)
    {
        return $this->db->table('prestasi_startups')->where('id_startup', $data['id_startup'])->delete();
    }
}
