<?php

namespace App\Models;

use CodeIgniter\Model;

class M_riwayat extends Model
{
    // Memperbarui atau menyimpan riwayat video
    public function update_riwayat_video($data)
    {
        $id_user  = $data['id_user'];
        $id_video = $data['id_item'];
        $durasi   = $data['durasi'];

        $query = "SELECT * FROM riwayat WHERE id_user = ? AND id_item = ? AND jenis_item = 'video'";
        $existing = $this->db->query($query, [$id_user, $id_video])->getRowArray();

        if ($existing) {
            if ($durasi > $existing['durasi']) {
                $update = ['durasi' => $durasi, 'updated_at' => date('Y-m-d H:i:s')];
                return $this->db->table('riwayat')->where('id_riwayat', $existing['id_riwayat'])->update($update);
            } else {
                return $this->db->table('riwayat')->where('id_riwayat', $existing['id_riwayat'])->update(['updated_at' => date('Y-m-d H:i:s')]);
            }
        } else {
            $insert = [
                'id_user'    => $id_user,
                'id_item'    => $id_video,
                'jenis_item' => 'video',
                'durasi'     => $durasi,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            return $this->db->table('riwayat')->insert($insert);
        }
    }

    // Memperbarui atau menyimpan riwayat baca buku
    public function update_riwayat_ebook($data)
    {
        $id_user  = $data['id_user'];
        $id_ebook = $data['id_item'];
        $halaman  = $data['halaman_terakhir'];

        $query = "SELECT * FROM riwayat WHERE id_user = ? AND id_item = ? AND jenis_item = 'ebook'";
        $existing = $this->db->query($query, [$id_user, $id_ebook])->getRowArray();

        if ($existing) {
            $update = ['halaman_terakhir' => $halaman, 'updated_at' => date('Y-m-d H:i:s')];
            return $this->db->table('riwayat')->where('id_riwayat', $existing['id_riwayat'])->update($update);
        } else {
            $insert = [
                'id_user'          => $id_user,
                'id_item'          => $id_ebook,
                'jenis_item'       => 'ebook',
                'halaman_terakhir' => $halaman,
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s')
            ];
            return $this->db->table('riwayat')->insert($insert);
        }
    }

    // Ambil riwayat komplit (join ke table video/ebook)
    public function get_riwayat_user($data)
    {
        $id_user = $data['id_user'];
        $query = "SELECT 
                    r.*,
                    kv.judul_video,
                    kv.uuid_konten_video,
                    kv.kode_video,
                    ke.judul_ebook,
                    ke.uuid_konten_ebook,
                    ke.sampul_ebook
                  FROM riwayat r
                  LEFT JOIN konten_video kv ON r.id_item = kv.id_konten_video AND r.jenis_item = 'video'
                  LEFT JOIN konten_ebook ke ON r.id_item = ke.id_konten_ebook AND r.jenis_item = 'ebook'
                  WHERE r.id_user = ?
                  ORDER BY r.updated_at DESC";

        return $this->db->query($query, [$id_user])->getResultArray();
    }

    // Ambil riwayat seluruh user (untuk admin)
    public function get_semua_riwayat()
    {
        $query = "SELECT 
                    r.*,
                    u.nama_lengkap, u.role,
                    kv.judul_video,
                    kv.uuid_konten_video,
                    kv.kode_video,
                    ke.judul_ebook,
                    ke.uuid_konten_ebook,
                    ke.sampul_ebook
                  FROM riwayat r
                  JOIN users u ON r.id_user = u.id_user
                  LEFT JOIN konten_video kv ON r.id_item = kv.id_konten_video AND r.jenis_item = 'video'
                  LEFT JOIN konten_ebook ke ON r.id_item = ke.id_konten_ebook AND r.jenis_item = 'ebook'
                  ORDER BY r.updated_at DESC";

        return $this->db->query($query)->getResultArray();
    }
}

