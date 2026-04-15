<?php

namespace App\Models;

use CodeIgniter\Model;

// Model untuk mengelola data startup
class M_startup extends Model
{
    // Mengambil semua data startup beserta nama dosen pembina dan nama program
    public function semua_startup()
    {
        $query = "SELECT s.*, d.nama_lengkap as nama_dosen, p.nama_program
                  FROM startups s
                  LEFT JOIN dosen_pembinas d ON d.id_dosen_pembina = s.id_dosen_pembina
                  LEFT JOIN programs p ON p.id_program = s.id_program
                  ORDER BY s.id_startup DESC";
        return $this->db->query($query);
    }

    // Mengambil satu data startup berdasarkan id_startup
    public function startup_by_id($data)
    {
        $query = "SELECT * FROM startups WHERE id_startup = '" . $data['id_startup'] . "'";
        return $this->db->query($query);
    }

    // Mengambil satu data startup beserta dosen dan program berdasarkan uuid_startup
    public function startup_by_uuid($data)
    {
        $query = "SELECT s.*, d.nama_lengkap as nama_dosen, p.nama_program
                  FROM startups s
                  LEFT JOIN dosen_pembinas d ON d.id_dosen_pembina = s.id_dosen_pembina
                  LEFT JOIN programs p ON p.id_program = s.id_program
                  WHERE s.uuid_startup = '" . $data['uuid_startup'] . "'";
        return $this->db->query($query);
    }

    // Mengambil data startup berdasarkan status_startup (aktif/nonaktif)
    public function startup_by_status($data)
    {
        $query = "SELECT s.*, d.nama_lengkap as nama_dosen
                  FROM startups s
                  LEFT JOIN dosen_pembinas d ON d.id_dosen_pembina = s.id_dosen_pembina
                  WHERE s.status_startup = '" . $data['status_startup'] . "'
                  ORDER BY s.nama_perusahaan ASC";
        return $this->db->query($query);
    }

    // Mencari startup berdasarkan nama perusahaan (case-insensitive)
    public function get_startup_by_nama($data)
    {
        return $this->db->table('startups')->where('lower(nama_perusahaan)', strtolower($data['nama_perusahaan']));
    }

    // Menyimpan data startup baru ke database dan mengembalikan ID yang baru dibuat
    public function tambah_startup($data)
    {
        $db = \Config\Database::connect();
        $db->table('startups')->insert($data);
        return $db->insertID();
    }

    // Mengupdate data startup berdasarkan id_startup
    public function ubah_startup($data)
    {
        $id = $data['id_startup'];
        unset($data['id_startup']);
        return $this->db->table('startups')->where('id_startup', $id)->update($data);
    }

    // Menghapus data startup berdasarkan id_startup
    public function hapus_startup($data)
    {
        return $this->db->table('startups')->where('id_startup', $data['id_startup'])->delete();
    }

    // Menghitung total jumlah startup yang terdaftar
    public function hitung_semua_startup(): int
    {
        return $this->db->table('startups')->countAllResults();
    }

    // Mengambil semua startup dalam bentuk array dengan kolom terbatas
    public function get_all_startup_array(): array
    {
        return $this->db->table('startups')->select('nama_perusahaan, email_perusahaan, nomor_whatsapp, tahun_daftar, status_startup, status_ajuan')->get()->getResultArray();
    }

    // Mengambil data startup untuk keperluan tampilan detail (kolom terbatas)
    public function liat_detail_data(): array
    {
        return $this->db->table('startups')->select('nama_perusahaan, email_perusahaan, nomor_whatsapp, tahun_daftar, status_startup, status_ajuan')->get()->getResultArray();
    }

    // Menghitung jumlah startup per status
    public function startup_per_status(int $start, int $end): array
    {
        return $this->db->query(
            "SELECT status_startup, COUNT(*) as total FROM startups WHERE tahun_daftar BETWEEN ? AND ? GROUP BY status_startup",
            [$start, $end]
        )->getResultArray();
    }

    // Menghitung jumlah startup per status ajuan
    public function startup_per_ajuan(int $start, int $end): array
    {
        return $this->db->query(
            "SELECT status_ajuan, COUNT(*) as total FROM startups WHERE tahun_daftar BETWEEN ? AND ? GROUP BY status_ajuan",
            [$start, $end]
        )->getResultArray();
    }

    // Menghitung jumlah startup per tahun (range tahun)
    public function startup_per_tahun(int $start, int $end): array
    {
        return $this->db->query(
            "SELECT tahun_daftar as tahun, COUNT(*) as total FROM startups WHERE tahun_daftar BETWEEN ? AND ? GROUP BY tahun_daftar ORDER BY tahun_daftar ASC",
            [$start, $end]
        )->getResultArray();
    }

    // Menghitung jumlah startup per bulan dalam 1 tahun
    public function startup_per_bulan(int $tahun): array
    {
        return $this->db->query(
            "SELECT MONTH(created_at) as bulan, COUNT(*) as total FROM startups WHERE YEAR(created_at) = ? GROUP BY MONTH(created_at) ORDER BY bulan ASC",
            [$tahun]
        )->getResultArray();
    }

    // Mengambil data startup berdasarkan id_user pemiliknya
    public function startup_by_id_user($id_user)
    {
        return $this->db->table('startups')->where('id_user', $id_user)->get()->getRow();
    }
}
