<?php

namespace App\Models;

use CodeIgniter\Model;

class M_klaster extends Model
{
    public function semua_klaster()
    {
        return $this->db->query("SELECT id_klaster, nama_klaster FROM klasters ORDER BY nama_klaster ASC");
    }

    public function klaster_by_id($id)
    {
        return $this->db->query("SELECT * FROM klasters WHERE id_klaster = " . (int)$id)->getRowArray();
    }
}
