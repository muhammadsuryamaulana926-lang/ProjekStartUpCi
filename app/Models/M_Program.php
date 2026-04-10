<?php

namespace App\Models;

use CodeIgniter\Model;

// Model untuk mengelola data program inkubasi/akselerasi startup
class M_program extends Model
{
    // Mengambil semua data program diurutkan berdasarkan tahun pelaksanaan terbaru
    public function semua_program()
    {
        $query = "SELECT id_program, nama_program, tahun_pelaksanaan
                  FROM programs
                  ORDER BY tahun_pelaksanaan DESC";
        return $this->db->query($query);
    }

    // Mengambil satu data program berdasarkan id_program
    public function program_by_id($data)
    {
        $query = "SELECT * FROM programs WHERE id_program = '" . $data['id_program'] . "'";
        return $this->db->query($query);
    }

    // Mengambil semua program beserta jumlah startup yang mengikutinya
    public function program_dengan_jumlah_startup()
    {
        $query = "SELECT p.id_program, p.nama_program, p.tahun_pelaksanaan, COUNT(s.id_startup) as jumlah_startup
                  FROM programs p
                  LEFT JOIN startups s ON s.id_program = p.id_program
                  GROUP BY p.id_program
                  ORDER BY p.tahun_pelaksanaan DESC";
        return $this->db->query($query);
    }

    // Menyimpan data program baru dan mengembalikan ID yang baru dibuat
    public function tambah_program($data)
    {
        $db = \Config\Database::connect();
        $db->table('programs')->insert($data);
        return $db->insertID();
    }

    // Mengupdate data program berdasarkan id_program
    public function ubah_program($data)
    {
        return $this->db->table('programs')->where('id_program', $data['id_program'])->update($data);
    }

    // Menghapus data program berdasarkan id_program
    public function hapus_program($data)
    {
        return $this->db->table('programs')->where('id_program', $data['id_program'])->delete();
    }
}
