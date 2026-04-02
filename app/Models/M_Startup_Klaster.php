<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Startup_Klaster extends Model
{
    protected $table            = 'startup_klaster';
    protected $primaryKey       = 'id_startup_klaster';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = ['id_startup', 'id_klaster'];

    protected $useTimestamps = false;

    // Ambil klaster by id_startup
    public function klasterByStartup($id_startup)
    {
        return $this->db->query("
            SELECT k.id_klaster, k.nama_klaster
            FROM startup_klaster sk
            JOIN klasters k ON k.id_klaster = sk.id_klaster
            WHERE sk.id_startup = ?
        ", [$id_startup])->getResultArray();
    }

    // Ambil id_klaster saja by id_startup
    public function idKlasterByStartup($id_startup)
    {
        return array_column($this->db->query("
            SELECT id_klaster FROM startup_klaster WHERE id_startup = ?
        ", [$id_startup])->getResultArray(), 'id_klaster');
    }

    // Simpan relasi kluster
    public function simpanKlaster($id_startup, array $id_klasters)
    {
        foreach ($id_klasters as $id_klaster) {
            $this->db->query("
                INSERT INTO startup_klaster (id_startup, id_klaster) VALUES (?, ?)
            ", [$id_startup, $id_klaster]);
        }
    }

    // Hapus semua klaster by id_startup
    public function hapusKlasterByStartup($id_startup)
    {
        return $this->db->query("
            DELETE FROM startup_klaster WHERE id_startup = ?
        ", [$id_startup]);
    }
}
