<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KlastersSeeder extends Seeder
{
    public function run()
    {
        $klasters = [
            'Industri Kreatif',
            'Smart City',
            'Teknologi Informasi',
            'Pangan & Kesehatan',
            'Energi Terbarukan',
            'Hardware & Robotik',
        ];

        foreach ($klasters as $nama) {
            $this->db->table('klasters')->insert([
                'uuid_klaster' => sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                    mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                    mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000,
                    mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
                ),
                'nama_klaster' => $nama,
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
