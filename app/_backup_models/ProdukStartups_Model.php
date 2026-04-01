<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukStartups_Model extends Model
{
    protected $table            = 'produk_startups';
    protected $primaryKey       = 'id_produk';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = ['uuid_produk', 'id_startup', 'nama_produk', 'deskripsi_produk', 'foto_produk'];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $beforeInsert  = ['generateUuid'];

    protected function generateUuid(array $data)
    {
        if (empty($data['data']['uuid_produk'])) {
            $data['data']['uuid_produk'] = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000,
                mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );
        }
        return $data;
    }
}
