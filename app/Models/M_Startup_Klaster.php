<?php

namespace App\Models;

use CodeIgniter\Model;

class M_startup_klaster extends Model
{
    public function klaster_by_startup($id_startup)
    {
        return $this->db->query("
            SELECT k.id_klaster, k.nama_klaster
            FROM startup_klaster sk
            JOIN klasters k ON k.id_klaster = sk.id_klaster
            WHERE sk.id_startup = " . (int)$id_startup
        )->getResultArray();
    }

    public function simpan_klaster($id_startup, $id_klaster)
    {
        return $this->db->table('startup_klaster')->insert([
            'id_startup' => $id_startup,
            'id_klaster' => $id_klaster,
        ]);
    }

    public function hapus_by_startup($id_startup)
    {
        return $this->db->table('startup_klaster')->where('id_startup', $id_startup)->delete();
    }
}
