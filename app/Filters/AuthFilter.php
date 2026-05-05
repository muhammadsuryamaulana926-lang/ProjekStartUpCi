<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\M_izin_akses;
use App\Models\M_peserta_program;

class AuthFilter implements FilterInterface
{
    // Peta segment URI ke nama modul di tabel izin_akses
    protected $peta_modul = [
        'v_dashboard'          => 'dashboard',
        'v_data_startup'       => 'data_startup',
        'v_tambah_startup'     => 'data_startup',
        'v_edit_startup'       => 'data_startup',
        'v_detail_startup'     => 'data_startup',
        'v_detail'             => 'data_startup',
        'v_hapus_startup'      => 'data_startup',
        'program'              => 'program',
        'peserta_program'      => 'program',
        'kelas'                => 'kelas',
        'v_perpustakaan'       => 'perpustakaan',
        'perpustakaan'         => 'perpustakaan',
        'v_riwayat_aktivitas'  => 'riwayat',
        'riwayat'              => 'riwayat',
        'v_lokasi_startup'     => 'peta_lokasi',
        'v_lokasi_startup_saya'=> 'peta_lokasi',
        'v_globe'              => 'peta_lokasi',
        'jadwal_kelas'          => 'kalender',
        'log_aktivitas'        => 'log_aktivitas',
        'manajemen_user'       => 'manajemen_user',
        'izin_akses'           => 'izin_akses',
    ];

    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Cek apakah sudah login
        if (!$session->get('user_logged_in')) {
            return redirect()->to(base_url('login'));
        }

        // Session timeout: 30 menit tidak aktif
        $last_activity = $session->get('last_activity');
        if ($last_activity && (time() - $last_activity) > 1800) {
            $session->destroy();
            return redirect()->to(base_url('login'))->with('error', 'Sesi Anda telah berakhir. Silakan login kembali.');
        }

        $session->set('last_activity', time());

        $role     = $session->get('user_role');
        $uri      = service('uri');
        $segment1 = $uri->getSegment(1);

        // Superadmin: akses penuh tanpa cek
        if ($role === 'superadmin') {
            return;
        }

        // Cek apakah segment URI termasuk modul yang dikontrol
        if (!isset($this->peta_modul[$segment1])) {
            return;
        }

        $nama_modul = $this->peta_modul[$segment1];
        $izin       = (new M_izin_akses())->izin_by_role_modul($role, $nama_modul);

        // Jika tidak ada data izin atau tidak boleh lihat
        if (!$izin || !$izin['bisa_lihat']) {
            $id_user = $session->get('user_id');

            // Modul konten yang boleh diakses oleh peserta/pemilik startup
            $modul_konten = ['perpustakaan', 'kelas', 'program', 'riwayat'];

            if ($role === 'peserta_program_kelas' && in_array($nama_modul, $modul_konten)) {
                return;
            }

            if ($role === 'pemilik_startup' && in_array($nama_modul, $modul_konten)) {
                return;
            }

            // Role lain yang terdaftar sebagai peserta program boleh akses modul konten
            if (!in_array($role, ['pemilik_startup', 'peserta_program_kelas']) && in_array($nama_modul, $modul_konten)) {
                $peserta = $id_user ? (new M_peserta_program())->program_by_user($id_user) : [];
                if (!empty($peserta)) {
                    return;
                }
            }

            // Redirect ke halaman yang sesuai per role (hindari infinite loop)
            return $this->redirect_by_role($session, $role);
        }
    }

    // Redirect ke halaman home yang sesuai per role (tidak pernah infinite loop)
    private function redirect_by_role($session, $role)
    {
        $pesan = 'Anda tidak memiliki akses ke halaman tersebut.';
        switch ($role) {
            case 'pemilik_startup':
                return redirect()->to(base_url('v_detail/' . $session->get('user_startup_uuid')))->with('error', $pesan);
            case 'peserta_program_kelas':
                return redirect()->to(base_url('program'))->with('error', $pesan);
            case 'pemateri':
                return redirect()->to(base_url('v_dashboard'))->with('error', $pesan);
            default:
                // Role lain yang is_peserta_program → program, selainnya → dashboard
                if ($session->get('is_peserta_program')) {
                    return redirect()->to(base_url('program'))->with('error', $pesan);
                }
                // Cek apakah role ini punya izin dashboard sebelum redirect ke sana
                $izin_dashboard = (new M_izin_akses())->izin_by_role_modul($role, 'dashboard');
                if ($izin_dashboard && $izin_dashboard['bisa_lihat']) {
                    return redirect()->to(base_url('v_dashboard'))->with('error', $pesan);
                }
                // Tidak punya akses dashboard sama sekali → logout paksa
                $session->destroy();
                return redirect()->to(base_url('login'))->with('error', $pesan);
        }
    }

    private function db_table_peserta_by_nama($nama_peserta)
    {
        return db_connect()->table('peserta_program')
            ->where('nama_peserta', $nama_peserta)
            ->get()->getResultArray();
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Catat hanya request GET (bukan AJAX/POST) dan hanya jika sudah login
        if (strtolower($request->getMethod()) !== 'get') return;
        if (!session()->get('user_logged_in')) return;

        $uri      = (string) $request->getUri();
        $segment1 = service('uri')->getSegment(1);

        // Abaikan halaman yang tidak perlu dicatat
        $abaikan = ['keep-alive', 'log_aktivitas', 'notifikasi', 'riwayat'];
        if (in_array($segment1, $abaikan)) return;

        session()->set('halaman_terakhir', $uri);
    }
}
