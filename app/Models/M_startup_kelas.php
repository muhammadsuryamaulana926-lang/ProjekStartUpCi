<?php

namespace App\Models;

use CodeIgniter\Model;

// Model untuk mengelola data kelas di tabel kelas_startup
class M_startup_kelas extends Model
{
    // Mengambil semua kelas berdasarkan id_program diurutkan tanggal dan jam
    public function kelas_by_program($data)
    {
        $query = "SELECT * FROM kelas_startup
                  WHERE id_program = '" . $data['id_program'] . "'
                  ORDER BY tanggal ASC, jam_mulai ASC";
        return $this->db->query($query)->getResultArray();
    }

    // Mengambil satu kelas berdasarkan id_kelas
    public function kelas_by_id($data)
    {
        $query = "SELECT * FROM kelas_startup WHERE id_kelas = '" . $data['id_kelas'] . "'";
        return $this->db->query($query)->getRowArray();
    }

    // Menyimpan data kelas baru dan mengembalikan true/false
    public function tambah_kelas($data)
    {
        $data['id_kelas']    = bin2hex(random_bytes(16));
        $data['dibuat_pada'] = date('Y-m-d H:i:s');
        return $this->db->table('kelas_startup')->insert($data);
    }

    // Memperbarui data kelas berdasarkan id_kelas
    public function ubah_kelas($data)
    {
        return $this->db->table('kelas_startup')->where('id_kelas', $data['id_kelas'])->update($data);
    }

    // Menghapus kelas berdasarkan id_kelas
    public function hapus_kelas($data)
    {
        return $this->db->table('kelas_startup')->where('id_kelas', $data['id_kelas'])->delete();
    }
}
