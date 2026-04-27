<?php

namespace App\Controllers;

use App\Models\M_izin_akses;

// Controller untuk mengelola izin akses per role per modul
class Izin_akses extends BaseController
{
    protected $m_izin;

    // Daftar semua modul yang bisa dikontrol izin aksesnya
    protected $daftar_modul = [
        'dashboard'      => 'Dashboard',
        'data_startup'   => 'Data Startup',
        'program'        => 'Program',
        'kelas'          => 'Kelas',
        'kalender'       => 'Kalender',
        'perpustakaan'   => 'Perpustakaan',
        'riwayat'        => 'Riwayat',
        'peta_lokasi'    => 'Peta Lokasi',
        'log_aktivitas'  => 'Log Aktivitas',
        'manajemen_user' => 'Manajemen User',
        'izin_akses'     => 'Izin Akses',
    ];

    // Daftar role yang bisa dikelola (superadmin tidak bisa diubah)
    protected $daftar_role = [
        'admin'           => 'Admin',
        'pemateri'        => 'Pemateri',
        'pemilik_startup' => 'Pemilik Startup',
    ];

    public function __construct()
    {
        $this->m_izin = new M_izin_akses();
    }

    // Menampilkan halaman matrix izin akses per role
    public function index()
    {
        $role_aktif = $this->request->getGet('role') ?? 'admin';

        $izin_list = $this->m_izin->izin_by_role($role_aktif);

        // Susun izin ke dalam array berindeks modul untuk kemudahan akses di view
        $izin_per_modul = [];
        foreach ($izin_list as $izin) {
            $izin_per_modul[$izin['modul']] = $izin;
        }

        $data = [
            'role_aktif'     => $role_aktif,
            'daftar_role'    => $this->daftar_role,
            'daftar_modul'   => $this->daftar_modul,
            'izin_per_modul' => $izin_per_modul,
        ];

        return view('layout/header', ['title' => 'Izin Akses'])
            . view('layout/topbar')
            . view('manajemen/v_izin_akses', $data)
            . view('layout/footer');
    }

    // Menyimpan perubahan izin akses dari form matrix
    public function simpan_izin()
    {
        $role        = $this->request->getPost('role');
        $permissions = $this->request->getPost('izin') ?? [];

        // Superadmin tidak boleh diubah
        if ($role === 'superadmin') {
            session()->setFlashdata('error', 'Izin akses superadmin tidak dapat diubah.');
            return redirect()->to(base_url('izin_akses?role=' . $role));
        }

        // Bangun array permission lengkap (modul yang tidak dicentang = 0)
        $data_izin = [];
        foreach ($this->daftar_modul as $modul => $label) {
            $data_izin[$modul] = [
                'bisa_lihat'  => isset($permissions[$modul]['bisa_lihat'])  ? 1 : 0,
                'bisa_tambah' => isset($permissions[$modul]['bisa_tambah']) ? 1 : 0,
                'bisa_edit'   => isset($permissions[$modul]['bisa_edit'])   ? 1 : 0,
                'bisa_hapus'  => isset($permissions[$modul]['bisa_hapus'])  ? 1 : 0,
            ];
        }

        if ($this->m_izin->update_izin_role($role, $data_izin)) {
            session()->setFlashdata('success', 'Izin akses berhasil disimpan.');
        } else {
            session()->setFlashdata('error', 'Gagal menyimpan izin akses.');
        }

        return redirect()->to(base_url('izin_akses?role=' . $role));
    }
}
