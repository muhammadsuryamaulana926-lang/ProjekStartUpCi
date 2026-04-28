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

        // Jika tidak ada data izin atau tidak boleh lihat, cek apakah user adalah peserta program
        if (!$izin || !$izin['bisa_lihat']) {
            $id_user = $session->get('user_id');
            // Peserta program boleh akses modul program, kelas, perpustakaan
            if ($id_user && in_array($nama_modul, ['program', 'kelas', 'perpustakaan'])) {
                $peserta = (new M_peserta_program())->program_by_user($id_user);
                if (!empty($peserta)) {
                    return;
                }
            }

            if ($role === 'pemilik_startup') {
                return redirect()->to(base_url('v_detail/' . $session->get('user_startup_uuid')));
            }
            return redirect()->to(base_url('v_dashboard'))->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }
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
