<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Klaster extends Model
{
    protected $table            = 'klasters';
    protected $primaryKey       = 'id_klaster';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = ['uuid_klaster', 'nama_klaster'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $beforeInsert  = ['generateUuid'];

    protected function generateUuid(array $data)
    {
        if (empty($data['data']['uuid_klaster'])) {
            $data['data']['uuid_klaster'] = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000,
                mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );
        }
        return $data;
    }

    // Ambil semua klaster
    public function semuaKlaster()
    {
        return $this->db->query("
            SELECT id_klaster, nama_klaster
            FROM klasters
            ORDER BY nama_klaster ASC
        ")->getResultArray();
    }

    // Ambil klaster by ID
    public function klasterById($id)
    {
        return $this->db->query("
            SELECT id_klaster, nama_klaster
            FROM klasters
            WHERE id_klaster = ?
        ", [$id])->getRowArray();
    }

    // Ambil klaster beserta jumlah startup
    public function klasterDenganJumlahStartup()
    {
        return $this->db->query("
            SELECT k.id_klaster,
                   k.nama_klaster,
                   COUNT(sk.id_startup) as jumlah_startup
            FROM klasters k
            LEFT JOIN startup_klaster sk ON sk.id_klaster = k.id_klaster
            GROUP BY k.id_klaster
            ORDER BY jumlah_startup DESC
        ")->getResultArray();
    }
}
