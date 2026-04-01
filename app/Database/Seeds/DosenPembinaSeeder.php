<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DosenPembinaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama_lengkap' => 'Dr. Budi Santoso, M.T.',     'nip' => '197001012000031001', 'fakultas' => 'Teknik Informatika',  'kontak' => '081234567890'],
            ['nama_lengkap' => 'Prof. Siti Rahayu, Ph.D.',   'nip' => '196805152001122001', 'fakultas' => 'Ekonomi Bisnis',      'kontak' => '082345678901'],
            ['nama_lengkap' => 'Dr. Ahmad Fauzi, M.Kom.',    'nip' => '197803202005011002', 'fakultas' => 'Ilmu Komputer',       'kontak' => '083456789012'],
            ['nama_lengkap' => 'Ir. Dewi Kusuma, M.T.',      'nip' => '198001102006042003', 'fakultas' => 'Teknik Elektro',      'kontak' => '084567890123'],
            ['nama_lengkap' => 'Dr. Reza Pratama, M.B.A.',   'nip' => '197512252003121004', 'fakultas' => 'Manajemen Inovasi',   'kontak' => '085678901234'],
        ];

        foreach ($data as $row) {
            $this->db->table('dosen_pembinas')->insert([
                'uuid_dosen_pembina' => sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                    mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                    mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000,
                    mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
                ),
                'nama_lengkap' => $row['nama_lengkap'],
                'nip'          => $row['nip'],
                'fakultas'     => $row['fakultas'],
                'kontak'       => $row['kontak'],
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
