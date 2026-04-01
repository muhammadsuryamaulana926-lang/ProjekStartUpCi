<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class StartupsSeeder extends Seeder
{
    public function run()
    {
        $startups = [
            [
                'nama_perusahaan'        => 'TechVision ID',
                'deskripsi_bidang_usaha' => 'Platform manajemen smart city berbasis IoT',
                'tahun_berdiri'          => 2021,
                'tahun_daftar'           => 2023,
                'target_pemasaran'       => 'B2G',
                'fokus_pelanggan'        => 'Pemerintah Daerah',
                'alamat'                 => 'Jl. Teknologi No. 1, Bandung',
                'nomor_whatsapp'         => '081100001111',
                'email_perusahaan'       => 'hello@techvision.id',
                'status_startup'         => 'Aktif',
                'status_ajuan'           => 'Verified',
                'id_dosen_pembina'       => 1,
                'id_program'             => 1,
                'klasters'               => [2, 3], // Smart City, Teknologi Informasi
            ],
            [
                'nama_perusahaan'        => 'GreenHarvest',
                'deskripsi_bidang_usaha' => 'Solusi pertanian cerdas berbasis sensor dan AI',
                'tahun_berdiri'          => 2022,
                'tahun_daftar'           => 2023,
                'target_pemasaran'       => 'B2B',
                'fokus_pelanggan'        => 'Petani & Koperasi',
                'alamat'                 => 'Jl. Agro No. 5, Bogor',
                'nomor_whatsapp'         => '082200002222',
                'email_perusahaan'       => 'info@greenharvest.co.id',
                'status_startup'         => 'Aktif',
                'status_ajuan'           => 'Verified',
                'id_dosen_pembina'       => 2,
                'id_program'             => 2,
                'klasters'               => [4, 5], // Pangan & Kesehatan, Energi Terbarukan
            ],
            [
                'nama_perusahaan'        => 'CreativeHub Studio',
                'deskripsi_bidang_usaha' => 'Platform kolaborasi desainer dan konten kreator lokal',
                'tahun_berdiri'          => 2023,
                'tahun_daftar'           => 2024,
                'target_pemasaran'       => 'B2C',
                'fokus_pelanggan'        => 'Freelancer & UMKM',
                'alamat'                 => 'Jl. Kreatif No. 10, Yogyakarta',
                'nomor_whatsapp'         => '083300003333',
                'email_perusahaan'       => 'studio@creativehub.id',
                'status_startup'         => 'Aktif',
                'status_ajuan'           => 'Pending',
                'id_dosen_pembina'       => 3,
                'id_program'             => 3,
                'klasters'               => [1], // Industri Kreatif
            ],
            [
                'nama_perusahaan'        => 'RoboTech Nusantara',
                'deskripsi_bidang_usaha' => 'Pengembangan robot industri dan otomasi pabrik',
                'tahun_berdiri'          => 2020,
                'tahun_daftar'           => 2024,
                'target_pemasaran'       => 'B2B',
                'fokus_pelanggan'        => 'Industri Manufaktur',
                'alamat'                 => 'Jl. Industri No. 88, Surabaya',
                'nomor_whatsapp'         => '084400004444',
                'email_perusahaan'       => 'contact@robotech.id',
                'status_startup'         => 'Aktif',
                'status_ajuan'           => 'Verified',
                'id_dosen_pembina'       => 4,
                'id_program'             => 4,
                'klasters'               => [6, 3], // Hardware & Robotik, Teknologi Informasi
            ],
            [
                'nama_perusahaan'        => 'MediCare Digital',
                'deskripsi_bidang_usaha' => 'Aplikasi konsultasi kesehatan dan telemedicine',
                'tahun_berdiri'          => 2022,
                'tahun_daftar'           => 2025,
                'target_pemasaran'       => 'B2C',
                'fokus_pelanggan'        => 'Masyarakat Umum',
                'alamat'                 => 'Jl. Sehat No. 3, Jakarta',
                'nomor_whatsapp'         => '085500005555',
                'email_perusahaan'       => 'care@medicare.id',
                'status_startup'         => 'Aktif',
                'status_ajuan'           => 'Pending',
                'id_dosen_pembina'       => 5,
                'id_program'             => 5,
                'klasters'               => [4], // Pangan & Kesehatan
            ],
        ];

        foreach ($startups as $startup) {
            $klasters = $startup['klasters'];
            unset($startup['klasters']);

            $startup['uuid_startup'] = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000,
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );
            $startup['created_at'] = date('Y-m-d H:i:s');
            $startup['updated_at'] = date('Y-m-d H:i:s');

            $this->db->table('startups')->insert($startup);
            $id_startup = $this->db->insertID();

            // Insert relasi ke startup_klaster
            foreach ($klasters as $id_klaster) {
                $this->db->table('startup_klaster')->insert([
                    'id_startup' => $id_startup,
                    'id_klaster' => $id_klaster,
                ]);
            }
        }
    }
}
