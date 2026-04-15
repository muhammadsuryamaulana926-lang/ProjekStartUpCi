<?php

namespace App\Models;

use CodeIgniter\Model;

// Model untuk mengelola data riwayat aktivitas user (video & ebook)
class M_riwayat extends Model
{
    // Menyimpan atau memperbarui riwayat tonton video
    public function simpan_video($data)
    {
        $id_user  = $data['id_user'];
        $id_video = $data['id_item'];
        $durasi   = $data['durasi'];

        $existing = $this->db->query(
            "SELECT * FROM riwayat WHERE id_user = ? AND id_item = ? AND jenis_item = 'video'",
            [$id_user, $id_video]
        )->getRowArray();

        if ($existing) {
            $update = ['updated_at' => date('Y-m-d H:i:s')];
            if ($durasi > $existing['durasi']) $update['durasi'] = $durasi;
            return $this->db->table('riwayat')->where('id_riwayat', $existing['id_riwayat'])->update($update);
        }

        return $this->db->table('riwayat')->insert([
            'id_user'    => $id_user,
            'id_item'    => $id_video,
            'jenis_item' => 'video',
            'durasi'     => $durasi,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    // Menyimpan atau memperbarui riwayat baca ebook
    public function simpan_ebook($data)
    {
        $id_user  = $data['id_user'];
        $id_ebook = $data['id_item'];
        $halaman  = $data['halaman_terakhir'];

        $existing = $this->db->query(
            "SELECT * FROM riwayat WHERE id_user = ? AND id_item = ? AND jenis_item = 'ebook'",
            [$id_user, $id_ebook]
        )->getRowArray();

        if ($existing) {
            return $this->db->table('riwayat')->where('id_riwayat', $existing['id_riwayat'])
                ->update(['halaman_terakhir' => $halaman, 'updated_at' => date('Y-m-d H:i:s')]);
        }

        return $this->db->table('riwayat')->insert([
            'id_user'          => $id_user,
            'id_item'          => $id_ebook,
            'jenis_item'       => 'ebook',
            'halaman_terakhir' => $halaman,
            'created_at'       => date('Y-m-d H:i:s'),
            'updated_at'       => date('Y-m-d H:i:s'),
        ]);
    }

    // Mengambil riwayat seluruh user dengan filter (untuk admin)
    public function semua_riwayat($filters = [])
    {
        $where  = 'WHERE 1=1';
        $params = [];

        if (!empty($filters['id_user'])) {
            $where   .= ' AND r.id_user = ?';
            $params[] = $filters['id_user'];
        }

        if (!empty($filters['timeframe'])) {
            if ($filters['timeframe'] === 'day') {
                $where .= ' AND DATE(r.updated_at) = ?';
                $params[] = date('Y-m-d');
            } elseif ($filters['timeframe'] === 'month') {
                $where .= ' AND MONTH(r.updated_at) = ? AND YEAR(r.updated_at) = ?';
                $params[] = date('m');
                $params[] = date('Y');
            } elseif ($filters['timeframe'] === 'year') {
                $where .= ' AND YEAR(r.updated_at) = ?';
                $params[] = date('Y');
            }
        }

        $query = "SELECT r.*, u.nama_lengkap, u.role,
                    kv.judul_video, kv.kode_video,
                    ke.judul_ebook, ke.sampul_ebook
                  FROM riwayat r
                  JOIN users u ON r.id_user = u.id_user
                  LEFT JOIN konten_video kv ON r.id_item = kv.id_konten_video AND r.jenis_item = 'video'
                  LEFT JOIN konten_ebook ke ON r.id_item = ke.id_konten_ebook AND r.jenis_item = 'ebook'
                  $where
                  ORDER BY r.updated_at DESC";

        return $this->db->query($query, $params)->getResultArray();
    }
}
