<?php

namespace App\Models;

use CodeIgniter\Model;

class Startups_Model extends Model
{
    protected $table            = 'startups';
    protected $primaryKey       = 'id_startup';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'uuid_startup', 'id_dosen_pembina', 'id_program', 'nama_perusahaan', 'deskripsi_bidang_usaha', 
        'tahun_berdiri', 'tahun_daftar', 'target_pemasaran', 'fokus_pelanggan', 'alamat', 
        'nomor_whatsapp', 'email_perusahaan', 'website_perusahaan', 'linkedin_perusahaan', 
        'instagram_perusahaan', 'logo_perusahaan', 'status_startup', 'status_ajuan'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $beforeInsert  = ['generateUuid'];

    protected function generateUuid(array $data)
    {
        if (empty($data['data']['uuid_startup'])) {
            $data['data']['uuid_startup'] = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000,
                mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );
        }
        return $data;
    }
}
