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
            $data['data']['uuid_dosen_pembina'] = sprintf(
                '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0x0fff) | 0x4000,
                mt_rand(0, 0x3fff) | 0x8000,
                mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0xffff)
            );
        }
        return $data;
    }

    // Ambil semua dosen urut nama
    public function semuaDosen()
    {
        return $this->db->query("
            SELECT id_dosen_pembina, nama_lengkap, nip, fakultas, kontak
            FROM dosen_pembinas
            ORDER BY nama_lengkap ASC
        ")->getResultArray();
    }

    // Ambil dosen by ID
    public function dosenById($id)
    {
        return $this->db->query("
            SELECT id_dosen_pembina, nama_lengkap, nip, fakultas, kontak
            FROM dosen_pembinas
            WHERE id_dosen_pembina = ?
        ", [$id])->getRowArray();
    }

    // Ambil dosen beserta jumlah startup yang dibimbing
    public function dosenDenganJumlahStartup()
    {
        return $this->db->query("
            SELECT d.id_dosen_pembina,
            SUBSTRING(d.nama_lengkap, 1, 30) as nama_lengkap,
            d.fakultas,
            COUNT(s.id_startup) as jumlah_startup
            FROM dosen_pembinas d
            LEFT JOIN startups s ON s.id_dosen_pembina = d.id_dosen_pembina
            GROUP BY d.id_dosen_pembina
            ORDER BY jumlah_startup DESC
        ")->getResultArray();
    }

    // Update dosen
    public function ubahDosen($id, $data)
    {
        return $this->db->query("
            UPDATE dosen_pembinas
            SET nama_lengkap = ?, nip = ?, fakultas = ?, kontak = ?, updated_at = NOW()
            WHERE id_dosen_pembina = ?
        ", [$data['nama_lengkap'], $data['nip'], $data['fakultas'], $data['kontak'], $id]);
    }

    // Hapus dosen
    public function hapusDosen($id)
    {
        return $this->db->query("
            DELETE FROM dosen_pembinas WHERE id_dosen_pembina = ?
        ", [$id]);
    }
}
