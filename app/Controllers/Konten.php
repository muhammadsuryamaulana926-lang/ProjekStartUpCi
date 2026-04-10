<?php
namespace App\Controllers;

use App\Models\M_konten_video;
use App\Models\M_konten_ebook;

// Controller untuk mengelola halaman video dan ebook
class Konten extends BaseController
{
    protected $m_konten_video;
    protected $m_konten_ebook;

    // Inisialisasi model saat controller dibuat
    public function __construct()
    {
        $this->m_konten_video = new M_konten_video();
        $this->m_konten_ebook = new M_konten_ebook();
    }

    // ── VIDEO ─────────────────────────────────────────────────────

    // Menampilkan halaman daftar video (publik saja untuk pemilik_startup, semua untuk admin)
    public function video()
    {
        $role = session()->get('user_role');
        $videos = $role === 'admin'
            ? $this->m_konten_video->semua_video()->getResult()
            : $this->m_konten_video->semua_video_publik()->getResult();

        // Decode kode_video untuk setiap item agar bisa digunakan di view
        foreach ($videos as $v) {
            $v->youtube_id = $this->m_konten_video->decode_kode_video($v->kode_video);
        }

        return view('Partials/v_header')
            . view('Partials/v_sidebar')
            . view('Partials/v_topbar')
            . view('Startup/v_video', ['videos' => $videos])
            . view('Partials/v_footer');
    }

    // Menyimpan data video baru (hanya admin)
    public function simpan_video()
    {
        $url   = $this->request->getPost('url_video');
        // Ekstrak YouTube ID dari berbagai format URL YouTube
        $yt_id = $this->ekstrak_youtube_id($url);

        if (!$yt_id) {
            echo json_encode(['status' => false, 'msg' => 'URL YouTube tidak valid']);
            return;
        }

        $data = [
            'id_user'        => session()->get('user_id'),
            'judul_video'    => $this->request->getPost('judul_video'),
            'deskripsi_video'=> $this->request->getPost('deskripsi_video'),
            'kode_video'     => $yt_id,
            'status_video'   => $this->request->getPost('status_video'),
        ];

        $result = $this->m_konten_video->tambah_video($data);
        echo json_encode(['status' => $result ? true : false]);
    }

    // Mengambil data satu video berdasarkan id untuk form edit (AJAX)
    public function ambil_video()
    {
        $data['id_konten_video'] = $this->request->getPost('id_konten_video');
        $video = $this->m_konten_video->video_by_id($data)->getRow();
        if ($video) {
            // Decode kode_video sebelum dikirim ke form edit
            $video->kode_video = $this->m_konten_video->decode_kode_video($video->kode_video);
        }
        echo json_encode($video);
    }

    // Mengupdate data video berdasarkan id_konten_video
    public function ubah_video()
    {
        $url   = $this->request->getPost('url_video');
        $yt_id = $this->ekstrak_youtube_id($url);

        if (!$yt_id) {
            echo json_encode(['status' => false, 'msg' => 'URL YouTube tidak valid']);
            return;
        }

        $data = [
            'id_konten_video' => $this->request->getPost('id_konten_video'),
            'judul_video'     => $this->request->getPost('judul_video'),
            'deskripsi_video' => $this->request->getPost('deskripsi_video'),
            'kode_video'      => $yt_id,
            'status_video'    => $this->request->getPost('status_video'),
        ];

        $result = $this->m_konten_video->ubah_video($data);
        echo json_encode(['status' => $result ? true : false]);
    }

    // Menghapus data video berdasarkan id_konten_video
    public function hapus_video()
    {
        $data['id_konten_video'] = $this->request->getPost('id_konten_video');
        $result = $this->m_konten_video->hapus_video($data);
        echo json_encode(['status' => $result ? true : false]);
    }

    // ── EBOOK ─────────────────────────────────────────────────────

    // Menampilkan halaman daftar ebook (publik saja untuk pemilik_startup, semua untuk admin)
    public function buku()
    {
        $role = session()->get('user_role');
        $ebooks = $role === 'admin'
            ? $this->m_konten_ebook->semua_ebook()->getResult()
            : $this->m_konten_ebook->semua_ebook_publik()->getResult();

        return view('Partials/v_header')
            . view('Partials/v_sidebar')
            . view('Partials/v_topbar')
            . view('Startup/v_buku', ['ebooks' => $ebooks])
            . view('Partials/v_footer');
    }

    // Menyimpan data ebook baru beserta upload file PDF dan sampul
    public function simpan_ebook()
    {
        $dir_pdf    = FCPATH . 'uploads/ebook/file/';
        $dir_sampul = FCPATH . 'uploads/ebook/sampul/';

        // Buat folder jika belum ada
        if (!file_exists($dir_pdf))    mkdir($dir_pdf,    0777, true);
        if (!file_exists($dir_sampul)) mkdir($dir_sampul, 0777, true);

        // Validasi dan upload file PDF
        if (empty($_FILES['file_ebook']['name'])) {
            echo json_encode(['status' => false, 'msg' => 'File PDF wajib diupload']);
            return;
        }

        $ext_pdf = strtolower(pathinfo($_FILES['file_ebook']['name'], PATHINFO_EXTENSION));
        if ($ext_pdf !== 'pdf') {
            echo json_encode(['status' => false, 'msg' => 'File harus berformat PDF']);
            return;
        }

        $nama_pdf = uniqid(date('Y_m_d') . '_', true) . '.pdf';
        move_uploaded_file($_FILES['file_ebook']['tmp_name'], $dir_pdf . $nama_pdf);

        $data = [
            'id_user'        => session()->get('user_id'),
            'judul_ebook'    => $this->request->getPost('judul_ebook'),
            'deskripsi_ebook'=> $this->request->getPost('deskripsi_ebook'),
            'penulis_ebook'  => $this->request->getPost('penulis_ebook'),
            'file_ebook'     => $nama_pdf,
            'status_ebook'   => $this->request->getPost('status_ebook'),
        ];

        // Upload sampul jika ada
        if (!empty($_FILES['sampul_ebook']['name'])) {
            $ext_sampul = strtolower(pathinfo($_FILES['sampul_ebook']['name'], PATHINFO_EXTENSION));
            if (in_array($ext_sampul, ['jpg', 'jpeg', 'png'])) {
                $nama_sampul = uniqid(date('Y_m_d') . '_sampul_', true) . '.' . $ext_sampul;
                move_uploaded_file($_FILES['sampul_ebook']['tmp_name'], $dir_sampul . $nama_sampul);
                $data['sampul_ebook'] = $nama_sampul;
            }
        }

        $result = $this->m_konten_ebook->tambah_ebook($data);
        echo json_encode(['status' => $result ? true : false]);
    }

    // Mengambil data satu ebook berdasarkan id untuk form edit (AJAX)
    public function ambil_ebook()
    {
        $data['id_konten_ebook'] = $this->request->getPost('id_konten_ebook');
        $ebook = $this->m_konten_ebook->ebook_by_id($data)->getRow();
        echo json_encode($ebook);
    }

    // Mengupdate data ebook, file PDF hanya diganti jika ada upload baru
    public function ubah_ebook()
    {
        $data = [
            'id_konten_ebook' => $this->request->getPost('id_konten_ebook'),
            'judul_ebook'     => $this->request->getPost('judul_ebook'),
            'deskripsi_ebook' => $this->request->getPost('deskripsi_ebook'),
            'penulis_ebook'   => $this->request->getPost('penulis_ebook'),
            'status_ebook'    => $this->request->getPost('status_ebook'),
        ];

        $dir_pdf    = FCPATH . 'uploads/ebook/file/';
        $dir_sampul = FCPATH . 'uploads/ebook/sampul/';

        // Ganti file PDF jika ada upload baru
        if (!empty($_FILES['file_ebook']['name'])) {
            $ext_pdf = strtolower(pathinfo($_FILES['file_ebook']['name'], PATHINFO_EXTENSION));
            if ($ext_pdf === 'pdf') {
                $nama_pdf = uniqid(date('Y_m_d') . '_', true) . '.pdf';
                move_uploaded_file($_FILES['file_ebook']['tmp_name'], $dir_pdf . $nama_pdf);
                // Hapus file lama
                $lama = $this->m_konten_ebook->ebook_by_id(['id_konten_ebook' => $data['id_konten_ebook']])->getRow();
                if ($lama && file_exists($dir_pdf . $lama->file_ebook)) unlink($dir_pdf . $lama->file_ebook);
                $data['file_ebook'] = $nama_pdf;
            }
        }

        // Ganti sampul jika ada upload baru
        if (!empty($_FILES['sampul_ebook']['name'])) {
            $ext_sampul = strtolower(pathinfo($_FILES['sampul_ebook']['name'], PATHINFO_EXTENSION));
            if (in_array($ext_sampul, ['jpg', 'jpeg', 'png'])) {
                $nama_sampul = uniqid(date('Y_m_d') . '_sampul_', true) . '.' . $ext_sampul;
                move_uploaded_file($_FILES['sampul_ebook']['tmp_name'], $dir_sampul . $nama_sampul);
                $data['sampul_ebook'] = $nama_sampul;
            }
        }

        $result = $this->m_konten_ebook->ubah_ebook($data);
        echo json_encode(['status' => $result ? true : false]);
    }

    // Menghapus data ebook beserta file PDF dan sampulnya dari server
    public function hapus_ebook()
    {
        $data['id_konten_ebook'] = $this->request->getPost('id_konten_ebook');
        $ebook = $this->m_konten_ebook->ebook_by_id($data)->getRow();

        if ($ebook) {
            $dir_pdf    = FCPATH . 'uploads/ebook/file/';
            $dir_sampul = FCPATH . 'uploads/ebook/sampul/';
            if ($ebook->file_ebook   && file_exists($dir_pdf    . $ebook->file_ebook))   unlink($dir_pdf    . $ebook->file_ebook);
            if ($ebook->sampul_ebook && file_exists($dir_sampul . $ebook->sampul_ebook)) unlink($dir_sampul . $ebook->sampul_ebook);
        }

        $result = $this->m_konten_ebook->hapus_ebook($data);
        echo json_encode(['status' => $result ? true : false]);
    }

    // Streaming file PDF ke browser tanpa mengekspos path asli file di server
    public function baca_ebook($uuid)
    {
        $ebook = $this->m_konten_ebook->ebook_by_uuid(['uuid_konten_ebook' => $uuid])->getRow();

        if (!$ebook) return redirect()->to(base_url('v_buku'));

        // Cek status: privat tidak bisa diakses
        if ($ebook->status_ebook === 'Privat' && session()->get('user_role') !== 'admin') {
            return redirect()->to(base_url('v_buku'));
        }

        $path = FCPATH . 'uploads/ebook/file/' . $ebook->file_ebook;
        if (!file_exists($path)) return redirect()->to(base_url('v_buku'));

        // Stream PDF langsung ke browser tanpa ekspos path
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="ebook.pdf"');
        header('Content-Length: ' . filesize($path));
        readfile($path);
        exit;
    }

    // ── HELPER ────────────────────────────────────────────────────

    // Mengekstrak YouTube ID dari berbagai format URL YouTube
    private function ekstrak_youtube_id($url)
    {
        $pattern = '/(?:youtube\.com\/(?:watch\?v=|embed\/|v\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';
        preg_match($pattern, $url, $matches);
        return $matches[1] ?? null;
    }
}
