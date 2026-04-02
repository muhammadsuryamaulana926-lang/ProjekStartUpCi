<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Startup extends Model
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

    // Ambil semua startup dengan join dosen dan program
    public function semuaStartup()
    {
        return $this->db->query("
            SELECT s.*,
                   SUBSTRING(s.nama_perusahaan, 1, 50) as nama_perusahaan,
                   d.nama_lengkap as nama_dosen,
                   p.nama_program
            FROM startups s
            LEFT JOIN dosen_pembinas d ON d.id_dosen_pembina = s.id_dosen_pembina
            LEFT JOIN programs p ON p.id_program = s.id_program
            ORDER BY s.created_at DESC
        ")->getResultArray();
    }

    // Ambil startup by UUID
    public function startupByUuid($uuid)
    {
        return $this->db->query("
            SELECT s.*,
                   d.nama_lengkap as nama_dosen,
                   p.nama_program
            FROM startups s
            LEFT JOIN dosen_pembinas d ON d.id_dosen_pembina = s.id_dosen_pembina
            LEFT JOIN programs p ON p.id_program = s.id_program
            WHERE s.uuid_startup = ?
        ", [$uuid])->getRowArray();
    }

    // Ambil startup by status
    public function startupByStatus($status)
    {
        return $this->db->query("
            SELECT s.*, d.nama_lengkap as nama_dosen
            FROM startups s
            LEFT JOIN dosen_pembinas d ON d.id_dosen_pembina = s.id_dosen_pembina
            WHERE s.status_startup = ?
            ORDER BY s.nama_perusahaan ASC
        ", [$status])->getResultArray();
    }

    // Hapus startup by UUID
    public function hapusStartup($uuid)
    {
        return $this->db->query("
            DELETE FROM startups WHERE uuid_startup = ?
        ", [$uuid]);
    }
}
