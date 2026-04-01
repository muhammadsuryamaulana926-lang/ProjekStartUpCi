<?php

namespace App\Models;

use CodeIgniter\Model;

class PendanaanNonItb_Model extends Model
{
    protected $table            = 'pendanaan_non_itb';
    protected $primaryKey       = 'id_pendanaan_non_itb';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = ['uuid_pendanaan_non_itb', 'id_startup', 'sumber_pendanaan', 'nominal', 'tahun'];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $beforeInsert  = ['generateUuid'];

    protected function generateUuid(array $data)
    {
        if (empty($data['data']['uuid_pendanaan_non_itb'])) {
            $data['data']['uuid_pendanaan_non_itb'] = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000,
                mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );
        }
        return $data;
    }
}
