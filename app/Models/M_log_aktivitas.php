<?php

namespace App\Models;

use CodeIgniter\Model;

class M_log_aktivitas extends Model
{
    // Menyimpan log aktivitas — update jika aksi+user sama, insert jika belum ada
    public function catat($data)
    {
        $data['dibuat_pada'] = date('Y-m-d H:i:s');

        $existing = $this->db->table('log_aktivitas')
            ->where('id_user', $data['id_user'])
            ->where('aksi', $data['aksi'])
            ->orderBy('dibuat_pada', 'DESC')
            ->limit(1)
            ->get()->getRowArray();

        if ($existing) {
            return $this->db->table('log_aktivitas')
                ->where('id_log', $existing['id_log'])
                ->update([
                    'halaman'     => $data['halaman'],
                    'ip_address'  => $data['ip_address'],
                    'user_agent'  => $data['user_agent'],
                    'dibuat_pada' => $data['dibuat_pada'],
                ]);
        }

        return $this->db->table('log_aktivitas')->insert($data);
    }

    // Mengambil semua log terbaru dengan limit
    public function semua_log($limit = 100)
    {
        return $this->db->table('log_aktivitas')
            ->orderBy('dibuat_pada', 'DESC')
            ->limit($limit)
            ->get()->getResultArray();
    }
}
