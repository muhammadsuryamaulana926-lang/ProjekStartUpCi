<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProgramsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama_program' => 'Inkubasi Startup Tahap 1',       'tahun_pelaksanaan' => 2023],
            ['nama_program' => 'Akselerasi Bisnis Digital',       'tahun_pelaksanaan' => 2023],
            ['nama_program' => 'Program Pendanaan Awal',          'tahun_pelaksanaan' => 2024],
            ['nama_program' => 'Inkubasi Startup Tahap 2',        'tahun_pelaksanaan' => 2024],
            ['nama_program' => 'Program Scale-Up Nasional',       'tahun_pelaksanaan' => 2025],
        ];

        foreach ($data as $row) {
            $this->db->table('programs')->insert([
                'uuid_program'      => sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                    mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                    mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000,
                    mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
                ),
                'nama_program'      => $row['nama_program'],
                'tahun_pelaksanaan' => $row['tahun_pelaksanaan'],
                'created_at'        => date('Y-m-d H:i:s'),
                'updated_at'        => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
