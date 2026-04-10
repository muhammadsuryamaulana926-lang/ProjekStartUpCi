<?php

namespace App\Models;

use CodeIgniter\Model;

// Model untuk mengelola data produk yang dimiliki oleh startup
class M_startup_produk extends Model
{
    // Mengambil semua produk milik satu startup diurutkan dari yang terbaru
    public function get_startup_produk_by_id_startup($data)
    {
        return $this->db->query("SELECT * FROM produk_startups WHERE id_startup = '" . $data['id_startup'] . "' ORDER BY id_produk DESC");
    }

    // Mengambil satu data produk berdasarkan id_produk
    public function get_startup_produk_by_id($data)
    {
        return $this->db->query("SELECT * FROM produk_startups WHERE id_produk = '" . $data['id_startup_produk'] . "'");
    }

    // Menyimpan data produk baru dengan UUID otomatis, mengembalikan ID yang baru dibuat
    public function tambah_startup_produk($data)
    {
        $insert = [
            'id_startup'       => $data['id_startup'],
            'nama_produk'      => $data['nama_produk'] ?? null,
            'deskripsi_produk' => $data['deskripsi_produk'] ?? null,
            'foto_produk'      => $data['logo'] ?? null,
            'uuid_produk'      => bin2hex(random_bytes(16)),
        ];
        $db = \Config\Database::connect();
        $db->table('produk_startups')->insert($insert);
        return $db->insertID();
    }

    // Mengupdate data produk berdasarkan id_produk, foto hanya diupdate jika ada file baru
    public function ubah_startup_produk($data)
    {
        $update = [
            'nama_produk'      => $data['nama_produk'] ?? null,
            'deskripsi_produk' => $data['deskripsi_produk'] ?? null,
        ];
        if (!empty($data['logo'])) $update['foto_produk'] = $data['logo'];
        return $this->db->table('produk_startups')->where('id_produk', $data['id_startup_produk'])->update($update);
    }

    // Menghapus satu data produk berdasarkan id_produk
    public function hapus_startup_produk($data)
    {
        return $this->db->table('produk_startups')->where('id_produk', $data['id_startup_produk'])->delete();
    }

    // Menghapus semua produk milik satu startup (digunakan saat startup dihapus)
    public function hapus_startup_produk_by_id_startup($data)
    {
        return $this->db->table('produk_startups')->where('id_startup', $data['id_startup'])->delete();
    }
}
