<?php

namespace App\Controllers;

use App\Models\M_user;
use App\Models\M_login;

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

        // Jika pemilik startup, simpan uuid startup miliknya ke session lalu redirect ke detail startup
        if ($user['role'] === 'pemilik_startup') {
            $startup = (new \App\Models\M_startup())->startup_by_id_user($user['id_user']);
            session()->set('user_startup_uuid', $startup ? $startup->uuid_startup : null);
            return redirect()->to(base_url('v_detail/' . ($startup ? $startup->uuid_startup : '')));
        }

        return redirect()->to(base_url('v_dashboard'));
    }

    // Menghancurkan session dan redirect ke halaman utama (logout)
    public function logout()
    {
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
