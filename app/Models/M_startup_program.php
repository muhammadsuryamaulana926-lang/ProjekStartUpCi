<?php

namespace App\Models;

use CodeIgniter\Model;

// Model untuk mengelola data program kelas startup di tabel program_startup
class M_startup_program extends Model
{
    // Mengambil semua program diurutkan terbaru
    public function semua_program()
    {
        $query = "SELECT * FROM program_startup ORDER BY dibuat_pada DESC";
        return $this->db->query($query)->getResultArray();
    }

    // Mengambil satu program berdasarkan id_program
    public function program_by_id($data)
    {
        $query = "SELECT * FROM program_startup WHERE id_program = '" . $data['id_program'] . "'";
        return $this->db->query($query)->getRowArray();
    }

    // Menyimpan data program baru dan mengembalikan true/false
    public function tambah_program($data)
    {
        $data['id_program']  = bin2hex(random_bytes(16));
        $data['dibuat_pada'] = date('Y-m-d H:i:s');
        return $this->db->table('program_startup')->insert($data);
    }

    // Memperbarui data program berdasarkan id_program
    public function ubah_program($data)
    {
        return $this->db->table('program_startup')->where('id_program', $data['id_program'])->update($data);
    }

    // Menghapus program berdasarkan id_program
    public function hapus_program($data)
    {
        return $this->db->table('program_startup')->where('id_program', $data['id_program'])->delete();
    }

    // Menghitung jumlah kelas dalam program
    public function hitung_kelas_program($data)
    {
        return $this->db->table('kelas_startup')->where('id_program', $data['id_program'])->countAllResults();
    }

    // Menghitung jumlah peserta dalam program
    public function hitung_peserta_program($data)
    {
        return $this->db->table('peserta_program')->where('id_program', $data['id_program'])->countAllResults();
    }
}
