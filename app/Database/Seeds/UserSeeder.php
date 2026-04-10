<?php
namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // User admin — hanya insert jika belum ada
        if (!$this->db->table('users')->where('email', 'admin@simik.com')->get()->getRow()) {
            $this->db->table('users')->insert([
                'nama_lengkap' => 'Administrator',
                'email'        => 'admin@simik.com',
                'password'     => password_hash('Admin@1234', PASSWORD_BCRYPT),
                'role'         => 'admin',
                'is_active'    => 1,
                'created_at'   => date('Y-m-d H:i:s'),
            ]);
        }

        // Data pemilik startup sesuai data real di database
        $pemilik = [
            ['nama_lengkap' => 'Pt.Nangka Busuk', 'email' => 'pemilik@nangkabusuk.id',  'id_startup' => 11],
            ['nama_lengkap' => 'Pt. surya',        'email' => 'pemilik@ptsurya.id',       'id_startup' => 18],
            ['nama_lengkap' => 'Sanuram',           'email' => 'pemilik@sanuram.id',       'id_startup' => 19],
            ['nama_lengkap' => 'IPP',               'email' => 'pemilik@ipp.id',           'id_startup' => 20],
        ];

        foreach ($pemilik as $p) {
            // Buat akun user dengan role pemilik_startup
            $this->db->table('users')->insert([
                'nama_lengkap' => $p['nama_lengkap'],
                'email'        => $p['email'],
                'password'     => password_hash('Pemilik@1234', PASSWORD_BCRYPT),
                'role'         => 'pemilik_startup',
                'is_active'    => 1,
                'created_at'   => date('Y-m-d H:i:s'),
            ]);
            $id_user = $this->db->insertID();

            // Hubungkan user ke startup miliknya berdasarkan id_startup
            $this->db->table('startups')
                ->where('id_startup', $p['id_startup'])
                ->update(['id_user' => $id_user]);
        }
    }
}
