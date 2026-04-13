<?php
namespace App\Controllers;

use App\Models\M_perpustakaan;

// Controller untuk mengelola fitur Perpustakaan (Video & Ebook)
class Perpustakaan extends BaseController
{
    protected $m_perpus;

    // Inisialisasi model gabungan
    public function __construct()
    {
        $this->m_perpus = new M_perpustakaan();
    }

    // ── HALAMAN UTAMA ─────────────────────────────────────────────

    // Menampilkan halaman perpustakaan gabungan video dan ebook
    public function index()
    {
        $role    = session()->get('user_role');
        $id_user = session()->get('user_id');

        $videos = $role === 'admin'
            ? $this->m_perpus->semua_video()->getResult()
            : $this->m_perpus->semua_video_publik_dan_akses($id_user)->getResult();

        foreach ($videos as $v) {
            $v->youtube_id  = $this->m_perpus->decode_kode_video($v->kode_video);
            $v->punya_akses = ($role === 'admin' || strtolower($v->status_video) === 'publik')
                ? true
                : $this->m_perpus->cek_akses('video', $v->id_konten_video, $id_user);
        }

        $ebooks = $role === 'admin'
            ? $this->m_perpus->semua_ebook()->getResult()
            : $this->m_perpus->semua_ebook_publik_dan_akses($id_user)->getResult();

        foreach ($ebooks as $e) {
            $e->punya_akses = ($role === 'admin' || strtolower($e->status_ebook) === 'publik')
                ? true
                : $this->m_perpus->cek_akses('ebook', $e->id_konten_ebook, $id_user);
        }

        $semua_user = $role === 'admin' ? $this->m_perpus->semua_user() : [];

        return view('Partials/v_header')
            . view('Partials/v_sidebar')
            . view('Partials/v_topbar')
            . view('Startup/v_perpustakaan', ['videos' => $videos, 'ebooks' => $ebooks, 'semua_user' => $semua_user])
            . view('Partials/v_footer');
    }

    // ── VIDEO ACTIONS ─────────────────────────────────────────────

    // Menyimpan data video baru
    public function simpan_video()
    {
        $url   = $this->request->getPost('url_video');
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

        $result = $this->m_perpus->tambah_video($data);
        echo json_encode(['status' => $result ? true : false, 'id_konten' => $result]);
    }

    public function ambil_video()
    {
        $data['id_konten_video'] = $this->request->getPost('id_konten_video');
        $video = $this->m_perpus->video_by_id($data)->getRow();
        if ($video) {
            $video->kode_video = $this->m_perpus->decode_kode_video($video->kode_video);
        }
        echo json_encode($video);
    }

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

        $result = $this->m_perpus->ubah_video($data);
        echo json_encode(['status' => $result ? true : false]);
    }

    public function hapus_video()
    {
        $data['id_konten_video'] = $this->request->getPost('id_konten_video');
        $result = $this->m_perpus->hapus_video($data);
        echo json_encode(['status' => $result ? true : false]);
    }

    // ── EBOOK ACTIONS ─────────────────────────────────────────────

    public function simpan_ebook()
    {
        $dir_pdf    = FCPATH . 'uploads/ebook/file/';
        $dir_sampul = FCPATH . 'uploads/ebook/sampul/';

        if (!file_exists($dir_pdf))    mkdir($dir_pdf,    0777, true);
        if (!file_exists($dir_sampul)) mkdir($dir_sampul, 0777, true);

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

        if (!empty($_FILES['sampul_ebook']['name'])) {
            $ext_sampul = strtolower(pathinfo($_FILES['sampul_ebook']['name'], PATHINFO_EXTENSION));
            if (in_array($ext_sampul, ['jpg', 'jpeg', 'png'])) {
                $nama_sampul = uniqid(date('Y_m_d') . '_sampul_', true) . '.' . $ext_sampul;
                move_uploaded_file($_FILES['sampul_ebook']['tmp_name'], $dir_sampul . $nama_sampul);
                $data['sampul_ebook'] = $nama_sampul;
            }
        }

        $result = $this->m_perpus->tambah_ebook($data);
        echo json_encode(['status' => $result ? true : false, 'id_konten' => $result]);
    }

    public function ambil_ebook()
    {
        $data['id_konten_ebook'] = $this->request->getPost('id_konten_ebook');
        $ebook = $this->m_perpus->ebook_by_id($data)->getRow();
        echo json_encode($ebook);
    }

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

        if (!empty($_FILES['file_ebook']['name'])) {
            $ext_pdf = strtolower(pathinfo($_FILES['file_ebook']['name'], PATHINFO_EXTENSION));
            if ($ext_pdf === 'pdf') {
                $nama_pdf = uniqid(date('Y_m_d') . '_', true) . '.pdf';
                move_uploaded_file($_FILES['file_ebook']['tmp_name'], $dir_pdf . $nama_pdf);
                $lama = $this->m_perpus->ebook_by_id(['id_konten_ebook' => $data['id_konten_ebook']])->getRow();
                if ($lama && file_exists($dir_pdf . $lama->file_ebook)) unlink($dir_pdf . $lama->file_ebook);
                $data['file_ebook'] = $nama_pdf;
            }
        }

        if (!empty($_FILES['sampul_ebook']['name'])) {
            $ext_sampul = strtolower(pathinfo($_FILES['sampul_ebook']['name'], PATHINFO_EXTENSION));
            if (in_array($ext_sampul, ['jpg', 'jpeg', 'png'])) {
                $nama_sampul = uniqid(date('Y_m_d') . '_sampul_', true) . '.' . $ext_sampul;
                move_uploaded_file($_FILES['sampul_ebook']['tmp_name'], $dir_sampul . $nama_sampul);
                $data['sampul_ebook'] = $nama_sampul;
            }
        }

        $result = $this->m_perpus->ubah_ebook($data);
        echo json_encode(['status' => $result ? true : false]);
    }

    public function hapus_ebook()
    {
        $data['id_konten_ebook'] = $this->request->getPost('id_konten_ebook');
        $ebook = $this->m_perpus->ebook_by_id($data)->getRow();

        if ($ebook) {
            $dir_pdf    = FCPATH . 'uploads/ebook/file/';
            $dir_sampul = FCPATH . 'uploads/ebook/sampul/';
            if ($ebook->file_ebook   && file_exists($dir_pdf    . $ebook->file_ebook))   unlink($dir_pdf    . $ebook->file_ebook);
            if ($ebook->sampul_ebook && file_exists($dir_sampul . $ebook->sampul_ebook)) unlink($dir_sampul . $ebook->sampul_ebook);
        }

        $result = $this->m_perpus->hapus_ebook($data);
        echo json_encode(['status' => $result ? true : false]);
    }

    // ── AKSES WHITELIST ──────────────────────────────────────────

    public function get_akses()
    {
        $tipe      = $this->request->getPost('tipe');
        $id_konten = $this->request->getPost('id_konten');
        echo json_encode($this->m_perpus->get_akses($tipe, $id_konten));
    }

    public function tambah_akses()
    {
        $tipe      = $this->request->getPost('tipe');
        $id_konten = $this->request->getPost('id_konten');
        $id_user   = $this->request->getPost('id_user');
        $result    = $this->m_perpus->tambah_akses($tipe, $id_konten, $id_user);
        echo json_encode(['status' => (bool)$result, 'msg' => $result ? '' : 'User sudah ada di daftar akses']);
    }

    public function hapus_akses()
    {
        $result = $this->m_perpus->hapus_akses($this->request->getPost('id'));
        echo json_encode(['status' => (bool)$result]);
    }

    // Menampilkan halaman baca ebook dengan efek flip buku
    public function baca_ebook($uuid)
    {
        $ebook = $this->m_perpus->ebook_by_uuid(['uuid_konten_ebook' => $uuid])->getRow();
        if (!$ebook) return redirect()->to(base_url('v_perpustakaan'));

        if ($ebook->status_ebook === 'Privat' && session()->get('user_role') !== 'admin') {
            if (!$this->m_perpus->cek_akses('ebook', $ebook->id_konten_ebook, session()->get('user_id'))) {
                return redirect()->to(base_url('perpustakaan'));
            }
        }

        $path = FCPATH . 'uploads/ebook/file/' . $ebook->file_ebook;
        if (!file_exists($path)) return redirect()->to(base_url('v_perpustakaan'));

        return view('Partials/v_header')
            . view('Partials/v_sidebar')
            . view('Partials/v_topbar')
            . view('Startup/v_baca_ebook', ['ebook' => $ebook])
            . view('Partials/v_footer');
    }

    // Stream file PDF mentah ke browser (digunakan oleh PDF.js di halaman reader)
    public function stream_ebook($uuid)
    {
        $ebook = $this->m_perpus->ebook_by_uuid(['uuid_konten_ebook' => $uuid])->getRow();
        if (!$ebook) { http_response_code(404); exit; }

        if ($ebook->status_ebook === 'Privat' && session()->get('user_role') !== 'admin') {
            if (!$this->m_perpus->cek_akses('ebook', $ebook->id_konten_ebook, session()->get('user_id'))) {
                http_response_code(403); exit;
            }
        }

        $path = FCPATH . 'uploads/ebook/file/' . $ebook->file_ebook;
        if (!file_exists($path)) { http_response_code(404); exit; }

        header('Content-Type: application/pdf');
        header('Content-Length: ' . filesize($path));
        header('Accept-Ranges: bytes');
        readfile($path);
        exit;
    }

    // ── HELPER ────────────────────────────────────────────────────

    private function ekstrak_youtube_id($url)
    {
        $pattern = '/(?:youtube\.com\/(?:watch\?v=|embed\/|v\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';
        preg_match($pattern, $url, $matches);
        return $matches[1] ?? null;
    }
}
