<?php
namespace App\Filters;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Cek apakah sudah login
        if (!$session->get('user_logged_in')) {
            return redirect()->to(base_url('login'));
        }

        // Session timeout: 30 menit tidak aktif
        $lastActivity = $session->get('last_activity');
        if ($lastActivity && (time() - $lastActivity) > 1800) {
            $session->destroy();
            return redirect()->to(base_url('login'))->with('error', 'Sesi Anda telah berakhir. Silakan login kembali.');
        }

        $session->set('last_activity', time());

        // Batasi akses pemilik_startup hanya ke halaman startup miliknya
        if ($session->get('user_role') === 'pemilik_startup') {
            $uri      = service('uri');
            $segment1 = $uri->getSegment(1);

            // Daftar URI yang boleh diakses oleh pemilik_startup
            $allowed = [
                'v_detail', 'v_edit_startup', 'v_update_startup', 'keep-alive',
                'v_lokasi_startup_saya', 'v_video', 'v_buku', 'konten',
                'startup', 'get_startup_tim', 'proses_tambah_informasi_tim',
                'proses_ubah_informasi_tim', 'proses_hapus_informasi_tim',
                'get_startup_produk', 'proses_tambah_informasi_produk',
                'proses_ubah_informasi_produk', 'proses_hapus_informasi_produk',
                'get_startup_pendanaan_itb', 'proses_tambah_informasi_pendanaan_itb',
                'proses_ubah_informasi_pendanaan_itb', 'proses_hapus_informasi_pendanaan_itb',
                'get_startup_pendanaan_non_itb', 'proses_tambah_informasi_pendanaan_non_itb',
                'proses_ubah_informasi_pendanaan_non_itb', 'proses_hapus_informasi_pendanaan_non_itb',
                'get_startup_prestasi', 'proses_tambah_informasi_prestasi',
                'proses_ubah_informasi_prestasi', 'proses_hapus_informasi_prestasi',
                'proses_tambah_informasi_mentor', 'proses_hapus_informasi_mentor',
            ];

            if (!in_array($segment1, $allowed)) {
                // Redirect ke halaman detail startup miliknya
                return redirect()->to(base_url('v_detail/' . $session->get('user_startup_uuid')));
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
