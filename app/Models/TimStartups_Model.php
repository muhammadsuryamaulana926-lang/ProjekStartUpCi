<?php

namespace App\Models;

use CodeIgniter\Model;

class TimStartups_Model extends Model
{
    protected $table            = 'tim_startups';
    protected $primaryKey       = 'id_tim';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'uuid_tim', 'id_startup', 'nama_lengkap', 'jabatan', 'jenis_kelamin', 
        'no_whatsapp', 'email', 'linkedin', 'instagram', 'nama_perguruan_tinggi'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $beforeInsert  = ['generateUuid'];

    protected function generateUuid(array $data)
    {
        if (empty($data['data']['uuid_tim'])) {
            $data['data']['uuid_tim'] = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000,
                mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );
        }
        return $data;
    }
}
