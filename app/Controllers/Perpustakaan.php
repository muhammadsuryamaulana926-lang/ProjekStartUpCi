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

    // Menampilkan halaman perpustakaan (khusus ebook)
    public function index()
    {
        $role    = session()->get('user_role');
        $id_user = session()->get('user_id');

        $ebooks = $role === 'admin'
            ? $this->m_perpus->semua_ebook()->getResult()
            : $this->m_perpus->semua_ebook_publik_dan_akses($id_user)->getResult();

        foreach ($ebooks as $e) {
            $e->punya_akses = ($role === 'admin' || strtolower($e->status_ebook) === 'publik')
                ? true
                : $this->m_perpus->cek_akses('ebook', $e->id_konten_ebook, $id_user);
        }

        $semua_user = $role === 'admin' ? $this->m_perpus->semua_user() : [];

                return view('layout/header', ['title' => 'Perpustakaan — Ebook'])

            . view('layout/topbar')
            . view('startup/v_perpustakaan', ['ebooks' => $ebooks, 'semua_user' => $semua_user])
            . view('layout/footer');
    }

    // Menampilkan halaman video (terpisah dari perpustakaan)
    public function video()
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

        $semua_user = $role === 'admin' ? $this->m_perpus->semua_user() : [];

        return view('layout/header', ['title' => 'Perpustakaan — Video Pembelajaran'])
            . view('layout/topbar')
            . view('startup/v_perpustakaan', ['videos' => $videos, 'semua_user' => $semua_user, 'video_only' => true])
            . view('layout/footer');
    }

    // ── VIDEO ACTIONS ─────────────────────────────────────────────

    // Menampilkan halaman tambah video
    public function tambah_video()
    {
        return view('layout/header', ['title' => 'Tambah Video'])
            . view('layout/topbar')
            . view('startup/v_vidio_tambah')
            . view('layout/footer');
    }

    // Menampilkan halaman edit video
    public function edit_video($id)
    {
        $data['id_konten_video'] = $id;
        $video = $this->m_perpus->video_by_id($data)->getRow();
        if (!$video) return redirect()->to(base_url('perpustakaan/video'));
        $video->kode_video = $this->m_perpus->decode_kode_video($video->kode_video);

        return view('layout/header', ['title' => 'Edit Video'])
            . view('layout/topbar')
            . view('startup/v_vidio_tambah', ['video' => $video])
            . view('layout/footer');
    }

    // Menyimpan video baru dari halaman form
    public function simpan_video_page()
    {
        $url   = $this->request->getPost('url_video');
        $yt_id = $this->ekstrak_youtube_id($url);

        if (!$yt_id) {
            session()->setFlashdata('error', 'URL YouTube tidak valid.');
            return redirect()->to(base_url('perpustakaan/tambah_video'));
        }

        $data = [
            'id_user'         => session()->get('user_id'),
            'judul_video'     => $this->request->getPost('judul_video'),
            'deskripsi_video' => $this->request->getPost('deskripsi_video'),
            'kategori_video'  => $this->request->getPost('kategori_video'),
            'kode_video'      => $yt_id,
            'status_video'    => $this->request->getPost('status_video'),
        ];

        $this->m_perpus->tambah_video($data);
        session()->setFlashdata('success', 'Video berhasil ditambahkan.');
        (new \App\Models\M_notifikasi())->tambah([
            'judul'      => 'Video Pembelajaran Baru',
            'pesan'      => 'Admin menambahkan video baru: "' . $data['judul_video'] . '"',
            'url'        => base_url('perpustakaan/video'),
            'untuk_role' => 'pemilik_startup',
        ]);
        return redirect()->to(base_url('perpustakaan/video'));
    }

    // Memperbarui video dari halaman form
    public function ubah_video_page()
    {
        $id    = $this->request->getPost('id_konten_video');
        $url   = $this->request->getPost('url_video');
        $yt_id = $this->ekstrak_youtube_id($url);

        if (!$yt_id) {
            session()->setFlashdata('error', 'URL YouTube tidak valid.');
            return redirect()->to(base_url('perpustakaan/edit_video/' . $id));
        }

        $data = [
            'id_konten_video' => $id,
            'judul_video'     => $this->request->getPost('judul_video'),
            'deskripsi_video' => $this->request->getPost('deskripsi_video'),
            'kategori_video'  => $this->request->getPost('kategori_video'),
            'kode_video'      => $yt_id,
            'status_video'    => $this->request->getPost('status_video'),
        ];

        $this->m_perpus->ubah_video($data);
        session()->setFlashdata('success', 'Video berhasil diperbarui.');
        return redirect()->to(base_url('perpustakaan/video'));
    }

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
            'judul_video'     => $this->request->getPost('judul_video'),
            'deskripsi_video' => $this->request->getPost('deskripsi_video'),
            'kategori_video'  => $this->request->getPost('kategori_video'),
            'kode_video'      => $yt_id,
            'status_video'    => $this->request->getPost('status_video'),
        ];

        $result = $this->m_perpus->tambah_video($data);
        echo json_encode(['status' => $result ? true : false, 'id_konten' => $result]);
    }

    public function ambil_video()
    {
        // Mengambil data satu video untuk keperluan form edit
        $data['id_konten_video'] = $this->request->getPost('id_konten_video');
        $video = $this->m_perpus->video_by_id($data)->getRow();
        if ($video) {
            $video->kode_video = $this->m_perpus->decode_kode_video($video->kode_video);
        }
        echo json_encode($video);
    }

    public function ubah_video()
    {
        // Memperbarui data video yang sudah ada
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
            'kategori_video'  => $this->request->getPost('kategori_video'),
            'kode_video'      => $yt_id,
            'status_video'    => $this->request->getPost('status_video'),
        ];

        $result = $this->m_perpus->ubah_video($data);
        echo json_encode(['status' => $result ? true : false]);
    }

    public function hapus_video()
    {
        // Menghapus data video berdasarkan id
        $data['id_konten_video'] = $this->request->getPost('id_konten_video');
        $result = $this->m_perpus->hapus_video($data);
        echo json_encode(['status' => $result ? true : false]);
    }

    // ── EBOOK ACTIONS ─────────────────────────────────────────────

    // Menampilkan halaman tambah buku
    public function tambah_buku()
    {
        return view('layout/header', ['title' => 'Tambah Buku Digital'])
            . view('layout/topbar')
            . view('startup/v_tambah_buku')
            . view('layout/footer');
    }

    // Menampilkan halaman edit buku
    public function edit_buku($id)
    {
        $data['id_konten_ebook'] = $id;
        $ebook = $this->m_perpus->ebook_by_id($data)->getRow();
        if (!$ebook) return redirect()->to(base_url('v_perpustakaan'));

        return view('layout/header', ['title' => 'Edit Buku Digital'])
            . view('layout/topbar')
            . view('startup/v_tambah_buku', ['ebook' => $ebook])
            . view('layout/footer');
    }

    // Menyimpan ebook baru dari form halamannya langsung
    public function simpan_buku_page()
    {
        $dir_pdf    = FCPATH . 'uploads/ebook/file/';
        $dir_sampul = FCPATH . 'uploads/ebook/sampul/';

        if (!file_exists($dir_pdf))    mkdir($dir_pdf,    0777, true);
        if (!file_exists($dir_sampul)) mkdir($dir_sampul, 0777, true);

        if (empty($_FILES['file_ebook']['name'])) {
            session()->setFlashdata('error', 'File PDF wajib diupload.');
            return redirect()->to(base_url('perpustakaan/tambah_buku'))->withInput();
        }

        $ext_pdf = strtolower(pathinfo($_FILES['file_ebook']['name'], PATHINFO_EXTENSION));
        if ($ext_pdf !== 'pdf') {
            session()->setFlashdata('error', 'File harus berformat PDF.');
            return redirect()->to(base_url('perpustakaan/tambah_buku'))->withInput();
        }

        $nama_pdf = uniqid(date('Y_m_d') . '_', true) . '.pdf';
        move_uploaded_file($_FILES['file_ebook']['tmp_name'], $dir_pdf . $nama_pdf);

        $data = [
            'id_user'         => session()->get('user_id'),
            'judul_ebook'     => $this->request->getPost('judul_ebook'),
            'deskripsi_ebook' => $this->request->getPost('deskripsi_ebook'),
            'penulis_ebook'   => $this->request->getPost('penulis_ebook'),
            'kategori_ebook'  => $this->request->getPost('kategori_ebook'),
            'file_ebook'      => $nama_pdf,
            'status_ebook'    => $this->request->getPost('status_ebook'),
        ];

        if (!empty($_FILES['sampul_ebook']['name'])) {
            $ext_sampul = strtolower(pathinfo($_FILES['sampul_ebook']['name'], PATHINFO_EXTENSION));
            if (in_array($ext_sampul, ['jpg', 'jpeg', 'png'])) {
                $nama_sampul = uniqid(date('Y_m_d') . '_sampul_', true) . '.' . $ext_sampul;
                move_uploaded_file($_FILES['sampul_ebook']['tmp_name'], $dir_sampul . $nama_sampul);
                $data['sampul_ebook'] = $nama_sampul;
            }
        }

        if ($this->m_perpus->tambah_ebook($data)) {
            session()->setFlashdata('success', 'Buku berhasil ditambahkan.');
            (new \App\Models\M_notifikasi())->tambah_notifikasi([
                'judul'      => 'Buku Digital Baru',
                'pesan'      => 'Admin menambahkan buku baru: "' . $data['judul_ebook'] . '"',
                'url'        => base_url('v_perpustakaan'),
                'untuk_role' => 'pemilik_startup',
            ]);
        } else {
            session()->setFlashdata('error', 'Gagal menambahkan buku.');
        }

        return redirect()->to(base_url('v_perpustakaan'));
    }

    // Memperbarui ebook dari form halamannya langsung
    public function ubah_buku_page()
    {
        $id = $this->request->getPost('id_konten_ebook');
        $data = [
            'id_konten_ebook' => $id,
            'judul_ebook'     => $this->request->getPost('judul_ebook'),
            'deskripsi_ebook' => $this->request->getPost('deskripsi_ebook'),
            'penulis_ebook'   => $this->request->getPost('penulis_ebook'),
            'kategori_ebook'  => $this->request->getPost('kategori_ebook'),
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
                if ($lama && !empty($lama->file_ebook) && file_exists($dir_pdf . $lama->file_ebook)) {
                    unlink($dir_pdf . $lama->file_ebook);
                }
                $data['file_ebook'] = $nama_pdf;
            } else {
                session()->setFlashdata('error', 'File harus berformat PDF.');
                return redirect()->to(base_url('perpustakaan/edit_buku/' . $id))->withInput();
            }
        }

        if (!empty($_FILES['sampul_ebook']['name'])) {
            $ext_sampul = strtolower(pathinfo($_FILES['sampul_ebook']['name'], PATHINFO_EXTENSION));
            if (in_array($ext_sampul, ['jpg', 'jpeg', 'png'])) {
                $nama_sampul = uniqid(date('Y_m_d') . '_sampul_', true) . '.' . $ext_sampul;
                move_uploaded_file($_FILES['sampul_ebook']['tmp_name'], $dir_sampul . $nama_sampul);
                $lama = $this->m_perpus->ebook_by_id(['id_konten_ebook' => $data['id_konten_ebook']])->getRow();
                if ($lama && !empty($lama->sampul_ebook) && file_exists($dir_sampul . $lama->sampul_ebook)) {
                    unlink($dir_sampul . $lama->sampul_ebook);
                }
                $data['sampul_ebook'] = $nama_sampul;
            }
        }

        if ($this->m_perpus->ubah_ebook($data)) {
            session()->setFlashdata('success', 'Buku berhasil diperbarui.');
        } else {
            session()->setFlashdata('error', 'Gagal memperbarui buku.');
        }

        return redirect()->to(base_url('v_perpustakaan'));
    }

    public function simpan_ebook()
    {
        // Menyimpan data ebook baru beserta file PDF dan sampul
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
            'judul_ebook'     => $this->request->getPost('judul_ebook'),
            'deskripsi_ebook' => $this->request->getPost('deskripsi_ebook'),
            'penulis_ebook'   => $this->request->getPost('penulis_ebook'),
            'kategori_ebook'  => $this->request->getPost('kategori_ebook'),
            'file_ebook'      => $nama_pdf,
            'status_ebook'    => $this->request->getPost('status_ebook'),
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
        // Mengambil data satu ebook untuk keperluan form edit
        $data['id_konten_ebook'] = $this->request->getPost('id_konten_ebook');
        $ebook = $this->m_perpus->ebook_by_id($data)->getRow();
        echo json_encode($ebook);
    }

    public function ubah_ebook()
    {
        // Memperbarui data ebook yang sudah ada
        $data = [
            'id_konten_ebook' => $this->request->getPost('id_konten_ebook'),
            'judul_ebook'     => $this->request->getPost('judul_ebook'),
            'deskripsi_ebook' => $this->request->getPost('deskripsi_ebook'),
            'penulis_ebook'   => $this->request->getPost('penulis_ebook'),
            'kategori_ebook'  => $this->request->getPost('kategori_ebook'),
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
        // Menghapus data ebook beserta file PDF dan sampulnya
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
        // Mengambil daftar user yang punya akses ke konten privat
        $tipe      = $this->request->getPost('tipe');
        $id_konten = $this->request->getPost('id_konten');
        echo json_encode($this->m_perpus->get_akses($tipe, $id_konten));
    }

    public function tambah_akses()
    {
        // Menambahkan user ke whitelist akses konten privat
        $tipe      = $this->request->getPost('tipe');
        $id_konten = $this->request->getPost('id_konten');
        $id_user   = $this->request->getPost('id_user');
        $result    = $this->m_perpus->tambah_akses($tipe, $id_konten, $id_user);
        echo json_encode(['status' => (bool)$result, 'msg' => $result ? '' : 'User sudah ada di daftar akses']);
    }

    public function hapus_akses()
    {
        // Menghapus user dari whitelist akses konten privat
        $result = $this->m_perpus->hapus_akses($this->request->getPost('id'));
        echo json_encode(['status' => (bool)$result]);
    }

    // Menampilkan halaman baca ebook dengan efek flip buku
    public function baca_ebook($uuid)
    {
        $ebook = $this->m_perpus->ebook_by_uuid(['uuid_konten_ebook' => $uuid])->getRow();
        if (!$ebook) throw new \CodeIgniter\Exceptions\PageNotFoundException();

        if ($ebook->status_ebook === 'Privat' && session()->get('user_role') !== 'admin') {
            if (!$this->m_perpus->cek_akses('ebook', $ebook->id_konten_ebook, session()->get('user_id'))) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException();
            }
        }

        $path = FCPATH . 'uploads/ebook/file/' . $ebook->file_ebook;
        if (!file_exists($path)) throw new \CodeIgniter\Exceptions\PageNotFoundException();

                return view('layout/header', ['title' => 'Baca Ebook'])

            . view('layout/topbar')
            . view('startup/v_baca_ebook', ['ebook' => $ebook])
            . view('layout/footer');
    }

    public function full_vidio($uuid)
    {
        $video = $this->m_perpus->video_by_uuid(['uuid_konten_video' => $uuid])->getRow();
        if (!$video) throw new \CodeIgniter\Exceptions\PageNotFoundException();

        if ($video->status_video === 'Privat' && session()->get('user_role') !== 'admin') {
            if (!$this->m_perpus->cek_akses('video', $video->id_konten_video, session()->get('user_id'))) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException();
            }
        }
        
        $video->youtube_id = $this->m_perpus->decode_kode_video($video->kode_video);
        
        // Ambil semua video untuk sidebar rekomendasi
        $role    = session()->get('user_role');
        $id_user = session()->get('user_id');
        
        $videos = $role === 'admin'
            ? $this->m_perpus->semua_video()->getResult()
            : $this->m_perpus->semua_video_publik_dan_akses($id_user)->getResult();

        $rekomendasi = [];
        foreach ($videos as $v) {
            if ($v->id_konten_video !== $video->id_konten_video) {
                $v->youtube_id  = $this->m_perpus->decode_kode_video($v->kode_video);
                $rekomendasi[] = $v;
            }
        }

                return view('layout/header', ['title' => 'Nonton Video'])

            . view('layout/topbar')
            . view('startup/v_full_video', ['video' => $video, 'rekomendasi' => $rekomendasi])
            . view('layout/footer');
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
        // Mengekstrak YouTube ID dari berbagai format URL YouTube
        $pattern = '/(?:youtube\.com\/(?:watch\?v=|embed\/|v\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';
        preg_match($pattern, $url, $matches);
        return $matches[1] ?? null;
    }
}
