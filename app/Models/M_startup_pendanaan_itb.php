<?php

namespace App\Models;

use CodeIgniter\Model;

// Model untuk mengelola data pendanaan startup yang bersumber dari ITB
class M_startup_pendanaan_itb extends Model
{
    // Mengambil semua pendanaan ITB milik satu startup diurutkan dari tahun terbaru
    public function get_startup_pendanaan_itb_by_id_startup($data)
    {
        return $this->db->query("SELECT * FROM pendanaan_itb WHERE id_startup = '" . $data['id_startup'] . "' ORDER BY tahun DESC");
    }

    // Mengambil satu data pendanaan ITB berdasarkan id_pendanaan_itb
    public function get_startup_pendanaan_itb_by_id($data)
    {
        return $this->db->query("SELECT * FROM pendanaan_itb WHERE id_pendanaan_itb = '" . $data['id_startup_pendanaan_itb'] . "'");
    }

    // Menyimpan data pendanaan ITB baru dengan UUID otomatis, mengembalikan ID yang baru dibuat
    public function tambah_startup_pendanaan_itb($data)
    {
        $insert = [
            'id_startup'        => $data['id_startup'],
            'skema_pendanaan'   => $data['program_kegiatan'] ?? null,
            'nominal'           => $data['jumlah_pendanaan'] ?? null,
            'tahun'             => $data['tahun'] ?? null,
            'uuid_pendanaan_itb' => bin2hex(random_bytes(16)),
        ];
        $db = \Config\Database::connect();
        $db->table('pendanaan_itb')->insert($insert);
        return $db->insertID();
    }

    // Mengupdate data pendanaan ITB berdasarkan id_pendanaan_itb
    public function ubah_startup_pendanaan_itb($data)
    {
        $update = [
            'skema_pendanaan' => $data['program_kegiatan'] ?? null,
            'nominal'         => $data['jumlah_pendanaan'] ?? null,
            'tahun'           => $data['tahun'] ?? null,
        ];
        return $this->db->table('pendanaan_itb')->where('id_pendanaan_itb', $data['id_startup_pendanaan_itb'])->update($update);
    }

    // Menghapus satu data pendanaan ITB berdasarkan id_pendanaan_itb
    public function hapus_startup_pendanaan_itb($data)
    {
        return $this->db->table('pendanaan_itb')->where('id_pendanaan_itb', $data['id_startup_pendanaan_itb'])->delete();
    }

    // Menghapus semua pendanaan ITB milik satu startup (digunakan saat startup dihapus)
    public function hapus_startup_pendanaan_itb_by_id_startup($data)
    {
        return $this->db->table('pendanaan_itb')->where('id_startup', $data['id_startup'])->delete();
    }
}
