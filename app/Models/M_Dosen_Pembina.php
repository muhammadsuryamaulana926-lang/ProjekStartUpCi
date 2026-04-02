<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Dosen_Pembina extends Model
{
    protected $table            = 'dosen_pembinas';
    protected $primaryKey       = 'id_dosen_pembina';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = ['uuid_dosen_pembina', 'nama_lengkap', 'nip', 'fakultas', 'kontak'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $beforeInsert  = ['generateUuid'];

    protected function generateUuid(array $data)
    {
        if (empty($data['data']['uuid_dosen_pembina'])) {
            $data['data']['uuid_dosen_pembina'] = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000,
                mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );
        }
        return $data;
    }
}
