<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

// Seeder: Mengisi data default izin akses per role per modul
// superadmin = akses penuh semua modul (tidak bisa diubah via UI)
// admin      = akses penuh semua modul (bisa diubah)
// pemilik_startup = akses terbatas (hanya lihat)
class IzinAksesSeeder extends Seeder
{
    public function run()
    {
        $modul_list = [
            'dashboard',
            'data_startup',
            'program',
            'kelas',
            'perpustakaan',
            'riwayat',
            'peta_lokasi',
            'log_aktivitas',
            'manajemen_user',
            'izin_akses',
        ];

        $data = [];

        foreach ($modul_list as $modul) {
            // superadmin: akses penuh semua modul
            $data[] = [
                'role'        => 'superadmin',
                'modul'       => $modul,
                'bisa_lihat'  => 1,
                'bisa_tambah' => 1,
                'bisa_edit'   => 1,
                'bisa_hapus'  => 1,
            ];

            // admin: akses penuh semua modul kecuali izin_akses dan manajemen_user
            $data[] = [
                'role'        => 'admin',
                'modul'       => $modul,
                'bisa_lihat'  => 1,
                'bisa_tambah' => in_array($modul, ['izin_akses', 'manajemen_user']) ? 0 : 1,
                'bisa_edit'   => in_array($modul, ['izin_akses', 'manajemen_user']) ? 0 : 1,
                'bisa_hapus'  => in_array($modul, ['izin_akses', 'manajemen_user']) ? 0 : 1,
            ];

            // pemilik_startup: hanya bisa lihat modul tertentu
            $boleh_lihat = in_array($modul, ['data_startup', 'program', 'kelas', 'perpustakaan', 'peta_lokasi']);
            $data[] = [
                'role'        => 'pemilik_startup',
                'modul'       => $modul,
                'bisa_lihat'  => $boleh_lihat ? 1 : 0,
                'bisa_tambah' => 0,
                'bisa_edit'   => in_array($modul, ['data_startup']) ? 1 : 0,
                'bisa_hapus'  => 0,
            ];
        }

        $this->db->table('izin_akses')->insertBatch($data);
    }
}
