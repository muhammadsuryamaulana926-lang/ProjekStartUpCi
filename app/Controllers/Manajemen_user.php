<?php

namespace App\Controllers;

use App\Models\M_manajemen_user;

// Controller untuk mengelola data user oleh admin/superadmin
class Manajemen_user extends BaseController
{
    protected $m_user;

    protected $daftar_role = [
        'admin'           => 'Admin',
        'pemateri'        => 'Pemateri',
        'pemilik_startup' => 'Pemilik Startup',
    ];

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

    public function __construct()
    {
        $this->m_user = new M_manajemen_user();
    }

    // Menampilkan daftar semua user
    public function index()
    {
        $data['users'] = $this->m_user->semua_user();

        return view('layout/header', ['title' => 'Manajemen User'])
            . view('layout/topbar')
            . view('manajemen/v_manajemen_user', $data)
            . view('layout/footer');
    }

    // Menampilkan form tambah user baru
    public function tambah_user()
    {
        $data['daftar_role']  = $this->daftar_role;
        $data['daftar_modul'] = $this->daftar_modul;
        $data['izin_per_modul'] = [];

        return view('layout/header', ['title' => 'Tambah User'])
            . view('layout/topbar')
            . view('manajemen/v_tambah_user', $data)
            . view('layout/footer');
    }

    // Menyimpan user baru beserta izin aksesnya
    public function simpan_user()
    {
        $email = $this->request->getPost('email');

        if ($this->m_user->cek_email_duplikat($email)) {
            session()->setFlashdata('error', 'Email sudah digunakan.');
            return redirect()->back()->withInput();
        }

        $role = $this->request->getPost('role');
        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'email'        => $email,
            'password'     => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'role'         => $role,
            'is_active'    => 1,
        ];

        if ($this->m_user->tambah_user($data)) {
            // Simpan izin akses khusus user ini berdasarkan role
            $this->simpan_izin_dari_form($role);
            session()->setFlashdata('success', 'User berhasil ditambahkan.');
        } else {
            session()->setFlashdata('error', 'Gagal menambahkan user.');
        }

        return redirect()->to(base_url('manajemen_user'));
    }

    // Menampilkan form edit user beserta izin aksesnya
    public function edit_user($id_user)
    {
        $data['user']        = $this->m_user->user_by_id($id_user);
        $data['daftar_role'] = $this->daftar_role;
        $data['daftar_modul'] = $this->daftar_modul;

        if (empty($data['user'])) {
            return redirect()->to(base_url('manajemen_user'))->with('error', 'User tidak ditemukan.');
        }

        // Load izin akses berdasarkan role user
        $izin_list = (new \App\Models\M_izin_akses())->izin_by_role($data['user']['role']);
        $izin_per_modul = [];
        foreach ($izin_list as $izin) {
            $izin_per_modul[$izin['modul']] = $izin;
        }
        $data['izin_per_modul'] = $izin_per_modul;

        return view('layout/header', ['title' => 'Edit User'])
            . view('layout/topbar')
            . view('manajemen/v_edit_user', $data)
            . view('layout/footer');
    }

    // Memperbarui data user beserta izin aksesnya
    public function ubah_user()
    {
        $id_user = $this->request->getPost('id_user');
        $email   = $this->request->getPost('email');

        if ($this->m_user->cek_email_duplikat($email, $id_user)) {
            session()->setFlashdata('error', 'Email sudah digunakan user lain.');
            return redirect()->back()->withInput();
        }

        $role = $this->request->getPost('role');
        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'email'        => $email,
            'role'         => $role,
        ];

        $password_baru = $this->request->getPost('password');
        if (!empty($password_baru)) {
            $data['password'] = password_hash($password_baru, PASSWORD_BCRYPT);
        }

        if ($this->m_user->ubah_user($id_user, $data)) {
            $this->simpan_izin_dari_form($role);
            session()->setFlashdata('success', 'Data user berhasil diperbarui.');
        } else {
            session()->setFlashdata('error', 'Gagal memperbarui data user.');
        }

        return redirect()->to(base_url('manajemen_user'));
    }

    // Helper: menyimpan izin akses dari form tambah/edit user
    private function simpan_izin_dari_form($role)
    {
        $permissions = $this->request->getPost('izin') ?? [];
        $m_izin      = new \App\Models\M_izin_akses();
        $data_izin   = [];

        foreach ($this->daftar_modul as $modul => $label) {
            $data_izin[$modul] = [
                'bisa_lihat'  => isset($permissions[$modul]['bisa_lihat'])  ? 1 : 0,
                'bisa_tambah' => isset($permissions[$modul]['bisa_tambah']) ? 1 : 0,
                'bisa_edit'   => isset($permissions[$modul]['bisa_edit'])   ? 1 : 0,
                'bisa_hapus'  => isset($permissions[$modul]['bisa_hapus'])  ? 1 : 0,
            ];
        }

        $m_izin->update_izin_role($role, $data_izin);
    }

    // Mengembalikan data izin akses berdasarkan role (untuk AJAX)
    public function get_izin_by_role()
    {
        $role = $this->request->getGet('role');
        $izin = (new \App\Models\M_izin_akses())->izin_by_role($role);
        return $this->response->setJSON($izin);
    }

    // Mengubah status aktif/nonaktif user
    public function toggle_aktif()
    {
        $id_user = $this->request->getPost('id_user');
        $status  = $this->request->getPost('is_active');

        if ($this->m_user->toggle_aktif($id_user, $status)) {
            session()->setFlashdata('success', 'Status user berhasil diubah.');
        } else {
            session()->setFlashdata('error', 'Gagal mengubah status user.');
        }

        return redirect()->to(base_url('manajemen_user'));
    }

    // Menghapus user berdasarkan id
    public function hapus_user()
    {
        $id_user = $this->request->getPost('id_user');

        if ($this->m_user->hapus_user($id_user)) {
            session()->setFlashdata('success', 'User berhasil dihapus.');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus user.');
        }

        return redirect()->to(base_url('manajemen_user'));
    }
}
