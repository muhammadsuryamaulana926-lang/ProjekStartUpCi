<?php

namespace App\Controllers;

use App\Models\M_user;
use App\Models\M_login;
use App\Models\M_log_aktivitas;
use App\Models\M_peserta_program;

// Controller untuk menangani autentikasi pengguna (login, logout, dan session)
class Login extends BaseController
{
    // Menampilkan halaman login, redirect ke dashboard jika sudah login
    public function index()
    {
        if (session()->get('user_logged_in')) {
            return redirect()->to(base_url('v_dashboard'));
        }
        return view('auth/v_login');
    }

    // Memproses form login: validasi lockout, cek kredensial, dan set session
    public function authenticate()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $ip       = $this->request->getIPAddress();

        $attemptModel = new M_login();

        // Cek apakah akun sedang terkunci karena terlalu banyak percobaan gagal
        if ($attemptModel->cek_terkunci($email, $ip)) {
            $menit = $attemptModel->sisa_menit_kunci($email, $ip);
            return redirect()->back()->with('error', "Akun terkunci. Coba lagi dalam {$menit} menit.");
        }

        $user = (new M_user())->cari_by_email($email);

        // Validasi email dan password, catat percobaan gagal jika tidak cocok
        if (!$user || !password_verify($password, $user['password'])) {
            $attemptModel->catat_gagal($email, $ip);
            return redirect()->back()->with('error', 'Email atau password salah.');
        }

        // Tolak login jika akun tidak aktif
        if (!$user['is_active']) {
            return redirect()->back()->with('error', 'Akun Anda tidak aktif. Hubungi administrator.');
        }

        // Login berhasil: hapus record percobaan, regenerate session, dan simpan data user
        $attemptModel->hapus_record($email, $ip);
        session()->regenerate(true);
        session()->set([
            'user_logged_in' => true,
            'user_id'        => $user['id_user'],
            'user_name'      => $user['nama_lengkap'],
            'user_email'     => $user['email'],
            'user_role'      => $user['role'],
            'last_activity'  => time(),
        ]);
        session()->setFlashdata('first_login', true);

        // Catat log aktivitas login
        (new M_log_aktivitas())->catat([
            'id_user'    => $user['id_user'],
            'nama_user'  => $user['nama_lengkap'],
            'role'       => $user['role'],
            'aksi'       => 'Login',
            'halaman'    => 'Halaman Login',
            'ip_address' => $ip,
            'user_agent' => $this->request->getUserAgent()->getAgentString(),
        ]);

        // Cek apakah user adalah peserta program, simpan ke session
        $peserta_program = (new M_peserta_program())->program_by_user($user['id_user']);
        session()->set('is_peserta_program', !empty($peserta_program));

        // Jika pemilik startup, simpan uuid startup miliknya ke session lalu redirect
        if ($user['role'] === 'pemilik_startup') {
            $startup = (new \App\Models\M_startup())->startup_by_id_user($user['id_user']);
            session()->set('user_startup_uuid', $startup ? $startup->uuid_startup : null);

            if (!empty($peserta_program)) {
                return redirect()->to(base_url('program'));
            }
            return redirect()->to(base_url('v_detail/' . ($startup ? $startup->uuid_startup : '')));
        }

        // Jika role peserta program kelas, redirect ke program
        if (!empty($peserta_program)) {
            return redirect()->to(base_url('program'));
        }

        // Pemateri redirect ke dashboard mereka
        if ($user['role'] === 'pemateri') {
            return redirect()->to(base_url('v_dashboard'));
        }

        return redirect()->to(base_url('v_dashboard'));
    }

    // Menghancurkan session dan redirect ke halaman utama (logout)
    public function logout()
    {
        if (session()->get('user_logged_in')) {
            (new M_log_aktivitas())->catat([
                'id_user'    => session()->get('user_id'),
                'nama_user'  => session()->get('user_name'),
                'role'       => session()->get('user_role'),
                'aksi'       => 'Logout',
                'halaman'    => session()->get('halaman_terakhir') ?? '-',
                'ip_address' => $this->request->getIPAddress(),
                'user_agent' => $this->request->getUserAgent()->getAgentString(),
            ]);
        }
        session()->destroy();
        return redirect()->to(base_url('/'));
    }

    // Memperbarui waktu aktivitas terakhir session (dipanggil via AJAX untuk mencegah timeout)
    public function keepAlive()
    {
        session()->set('last_activity', time());
        return $this->response->setJSON(['status' => 'ok']);
    }
}
