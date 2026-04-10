<?php

namespace App\Models;

use CodeIgniter\Model;

// Model untuk mengelola data pendanaan startup yang bersumber dari luar ITB (investor, hibah, dll)
class M_startup_pendanaan_non_itb extends Model
{
    // Mengambil semua pendanaan non-ITB milik satu startup diurutkan dari tahun terbaru
    public function get_startup_pendanaan_non_itb_by_id_startup($data)
    {
        return $this->db->query("SELECT * FROM pendanaan_non_itb WHERE id_startup = '" . $data['id_startup'] . "' ORDER BY tahun DESC");
    }

    // Mengambil satu data pendanaan non-ITB berdasarkan id_pendanaan_non_itb
    public function get_startup_pendanaan_non_itb_by_id($data)
    {
        return $this->db->query("SELECT * FROM pendanaan_non_itb WHERE id_pendanaan_non_itb = '" . $data['id_startup_pendanaan_non_itb'] . "'");
    }

    // Menyimpan data pendanaan non-ITB baru dengan UUID otomatis, mengembalikan ID yang baru dibuat
    public function tambah_startup_pendanaan_non_itb($data)
    {
        $insert = [
            'id_startup'             => $data['id_startup'],
            'sumber_pendanaan'       => $data['nama_investor'] ?? ($data['program_kegiatan'] ?? null),
            'nominal'                => $data['jumlah_pendanaan'] ?? null,
            'tahun'                  => $data['tahun'] ?? null,
            'uuid_pendanaan_non_itb' => bin2hex(random_bytes(16)),
        ];
        $db = \Config\Database::connect();
        $db->table('pendanaan_non_itb')->insert($insert);
        return $db->insertID();
    }

    // Mengupdate data pendanaan non-ITB berdasarkan id_pendanaan_non_itb
    public function ubah_startup_pendanaan_non_itb($data)
    {
        $update = [
            'sumber_pendanaan' => $data['nama_investor'] ?? ($data['program_kegiatan'] ?? null),
            'nominal'          => $data['jumlah_pendanaan'] ?? null,
            'tahun'            => $data['tahun'] ?? null,
        ];
        return $this->db->table('pendanaan_non_itb')->where('id_pendanaan_non_itb', $data['id_startup_pendanaan_non_itb'])->update($update);
    }

    // Menghapus satu data pendanaan non-ITB berdasarkan id_pendanaan_non_itb
    public function hapus_startup_pendanaan_non_itb($data)
    {
        return $this->db->table('pendanaan_non_itb')->where('id_pendanaan_non_itb', $data['id_startup_pendanaan_non_itb'])->delete();
    }

    // Menghapus semua pendanaan non-ITB milik satu startup (digunakan saat startup dihapus)
    public function hapus_startup_pendanaan_non_itb_by_id_startup($data)
    {
        return $this->db->table('pendanaan_non_itb')->where('id_startup', $data['id_startup'])->delete();
    }
}
