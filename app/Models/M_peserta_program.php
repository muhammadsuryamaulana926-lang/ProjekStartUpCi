<?php

namespace App\Models;

use CodeIgniter\Model;

// Model untuk mengelola data peserta program di tabel peserta_program
class M_peserta_program extends Model
{
    // Mengambil semua peserta berdasarkan id_program
    public function peserta_by_program($data)
    {
        $query = "SELECT * FROM peserta_program
                  WHERE id_program = '" . $data['id_program'] . "'
                  ORDER BY dibuat_pada DESC";
        return $this->db->query($query)->getResultArray();
    }

    // Mengecek apakah peserta sudah terdaftar di program (by id_user atau nama_peserta)
    public function cek_sudah_join($data)
    {
        $builder = $this->db->table('peserta_program')
            ->where('id_program', $data['id_program']);

        if (!empty($data['id_user'])) {
            $builder->where('id_user', $data['id_user']);
        } else {
            $builder->where('nama_peserta', $data['nama_peserta']);
        }

        return $builder->countAllResults() > 0;
    }

    // Mengambil semua program yang diikuti user berdasarkan id_user
    public function program_by_user($id_user)
    {
        return $this->db->table('peserta_program')
            ->where('id_user', $id_user)
            ->get()->getResultArray();
    }

    // Menyimpan peserta baru dan mengembalikan true/false
    public function tambah_peserta($data)
    {
        $data['id_peserta_program'] = bin2hex(random_bytes(16));
        $data['dibuat_pada']        = date('Y-m-d H:i:s');
        return $this->db->table('peserta_program')->insert($data);
    }

    // Menghapus peserta berdasarkan id_peserta_program
    public function hapus_peserta($data)
    {
        return $this->db->table('peserta_program')->where('id_peserta_program', $data['id_peserta_program'])->delete();
    }
}
