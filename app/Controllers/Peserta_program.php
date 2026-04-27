<?php

namespace App\Controllers;

use App\Models\M_startup_program;
use App\Models\M_peserta_program;
use App\Models\M_notifikasi;
use App\Models\M_manajemen_user;
use App\Models\M_role;

// Controller untuk mengelola data peserta program startup
class Peserta_program extends BaseController
{
    protected $m_program;
    protected $m_peserta;

    public function __construct()
    {
        $this->m_program = new M_startup_program();
        $this->m_peserta = new M_peserta_program();
    }

    // Redirect ke detail program atau daftar program
    public function index($id_program = null)
    {
        if ($id_program) {
            return redirect()->to(base_url('program/detail_program/' . $id_program));
        }
        return redirect()->to(base_url('program'));
    }

    // Menampilkan form tambah peserta manual oleh admin
    public function tambah_peserta_program($id_program)
    {
        $data['program'] = $this->m_program->program_by_id(['id_program' => $id_program]);

        if (empty($data['program'])) {
            return redirect()->to(base_url('program'))->with('error', 'Program tidak ditemukan.');
        }

        $roles           = (new M_role())->semua_role();
        $data['daftar_role'] = array_column($roles, 'label', 'nama_role');

        return view('layout/header', ['title' => 'Tambah Peserta'])
            . view('layout/topbar')
            . view('startup_kelas/v_tambah_peserta_program', $data)
            . view('layout/footer');
    }

    // Menyimpan peserta baru atau user join program
    public function simpan_peserta_program()
    {
        $id_program   = $this->request->getPost('id_program');
        $nama_peserta = $this->request->getPost('nama_peserta');
        $buat_akun    = $this->request->getPost('buat_akun');

        if (empty($nama_peserta)) {
            $nama_peserta = session()->get('user_name') ?? 'Admin';
        }

        if ($this->m_peserta->cek_sudah_join(['id_program' => $id_program, 'nama_peserta' => $nama_peserta])) {
            return redirect()->to(base_url('program/detail_program/' . $id_program))
                             ->with('error', 'Peserta sudah terdaftar di program ini.');
        }

        // Buat akun user jika diminta
        if ($buat_akun) {
            $email    = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $m_user   = new M_manajemen_user();

            if ($m_user->cek_email_duplikat($email)) {
                session()->setFlashdata('error', 'Email sudah digunakan oleh user lain.');
                return redirect()->back()->withInput();
            }

            $m_user->tambah_user([
                'nama_lengkap' => $nama_peserta,
                'email'        => $email,
                'password'     => password_hash($password, PASSWORD_BCRYPT),
                'role'         => $this->request->getPost('role_akun') ?: 'pemilik_startup',
                'is_active'    => 1,
            ]);
        }

        $data = [
            'id_program'   => $id_program,
            'nama_peserta' => $nama_peserta,
        ];

        if ($this->m_peserta->tambah_peserta($data)) {
            session()->setFlashdata('success', 'Berhasil bergabung dengan program / menambah peserta.');
            $program      = $this->m_program->program_by_id(['id_program' => $id_program]);
            $nama_program = $program['nama_program'] ?? 'Program';
            (new M_notifikasi())->tambah_notifikasi([
                'judul' => 'Peserta Baru Mendaftar',
                'pesan' => $nama_peserta . ' mendaftar ke program "' . $nama_program . '"',
                'url'   => base_url('program/detail_program/' . $id_program),
            ]);
        } else {
            session()->setFlashdata('error', 'Gagal bergabung / menambah peserta.');
        }

        return redirect()->to(base_url('program/detail_program/' . $id_program));
    }

    // Menghapus peserta dari program
    public function hapus_peserta_program()
    {
        $id_peserta = $this->request->getPost('id_peserta_program');
        $id_program = $this->request->getPost('id_program');

        if ($this->m_peserta->hapus_peserta(['id_peserta_program' => $id_peserta])) {
            session()->setFlashdata('success', 'Peserta berhasil dihapus.');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus peserta.');
        }

        return redirect()->to(base_url('program/detail_program/' . $id_program));
    }
}
