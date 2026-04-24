<?php

namespace App\Controllers;

use App\Models\M_startup_program;
use App\Models\M_startup_kelas;
use App\Models\M_kelas_video;
use App\Models\M_kelas_video_chapter;

// Controller untuk mengelola data kelas dalam program startup
class Kelas_startup extends BaseController
{
    protected $m_program;
    protected $m_kelas;
    protected $m_kelas_video;
    protected $m_chapter;

    public function __construct()
    {
        $this->m_program     = new M_startup_program();
        $this->m_kelas       = new M_startup_kelas();
        $this->m_kelas_video = new M_kelas_video();
        $this->m_chapter     = new M_kelas_video_chapter();
    }

    // Redirect ke detail program jika ada id_program, atau ke daftar program
    public function index($id_program = null)
    {
        if ($id_program) {
            return redirect()->to(base_url('program/detail_program/' . $id_program));
        }
        return redirect()->to(base_url('program'));
    }

    // Menampilkan form tambah kelas
    public function tambah_kelas($id_program)
    {
        $data['program'] = $this->m_program->program_by_id(['id_program' => $id_program]);

        if (empty($data['program'])) {
            return redirect()->to(base_url('program'))->with('error', 'Program tidak ditemukan.');
        }

        return view('layout/header', ['title' => 'Tambah Kelas'])
            . view('layout/topbar')
            . view('startup_kelas/v_tambah_kelas', $data)
            . view('layout/footer');
    }

    // Menyimpan data kelas baru
    public function simpan_kelas()
    {
        $id_program = $this->request->getPost('id_program');

        $data = [
            'id_program'   => $id_program,
            'nama_kelas'   => $this->request->getPost('nama_kelas'),
            'deskripsi'    => $this->request->getPost('deskripsi'),
            'status_kelas' => $this->request->getPost('status_kelas'),
            'tanggal'      => $this->request->getPost('tanggal'),
            'jam_mulai'    => $this->request->getPost('jam_mulai'),
            'jam_selesai'  => $this->request->getPost('jam_selesai'),
            'link_youtube' => $this->request->getPost('link_youtube'),
            'link_zoom'    => $this->request->getPost('link_zoom'),
            'nama_dosen'   => $this->request->getPost('nama_dosen'),
        ];

        if ($this->m_kelas->tambah_kelas($data)) {
            session()->setFlashdata('success', 'Kelas berhasil ditambahkan.');
        } else {
            session()->setFlashdata('error', 'Gagal menambahkan kelas.');
        }

        return redirect()->to(base_url('program/detail_program/' . $id_program));
    }

    // Menampilkan form edit kelas
    public function edit_kelas($id_kelas)
    {
        $data['kelas'] = $this->m_kelas->kelas_by_id(['id_kelas' => $id_kelas]);

        if (empty($data['kelas'])) {
            return redirect()->to(base_url('program'))->with('error', 'Kelas tidak ditemukan.');
        }

        $data['program']      = $this->m_program->program_by_id(['id_program' => $data['kelas']['id_program']]);
        $data['kelas_videos'] = $this->m_kelas_video->video_by_kelas($id_kelas);

        // Kelompokkan chapter berdasarkan id_kelas_video
        $video_ids    = array_column($data['kelas_videos'], 'id_kelas_video');
        $semua_chapter = $this->m_chapter->chapter_by_banyak_video($video_ids);
        $chapters_map  = [];
        foreach ($semua_chapter as $ch) {
            $chapters_map[$ch['id_kelas_video']][] = $ch;
        }
        $data['chapters_map'] = $chapters_map;

        return view('layout/header', ['title' => 'Edit Kelas'])
            . view('layout/topbar')
            . view('startup_kelas/v_edit_kelas', $data)
            . view('layout/footer');
    }

    // Memperbarui data kelas beserta video sesi dan chapter
    public function ubah_kelas()
    {
        $id_program = $this->request->getPost('id_program');
        $id_kelas   = $this->request->getPost('id_kelas');

        $data_kelas = [
            'id_kelas'     => $id_kelas,
            'nama_kelas'   => $this->request->getPost('nama_kelas'),
            'deskripsi'    => $this->request->getPost('deskripsi'),
            'status_kelas' => $this->request->getPost('status_kelas'),
            'tanggal'      => $this->request->getPost('tanggal'),
            'jam_mulai'    => $this->request->getPost('jam_mulai'),
            'jam_selesai'  => $this->request->getPost('jam_selesai'),
            'link_zoom'    => $this->request->getPost('link_zoom'),
            'nama_dosen'   => $this->request->getPost('nama_dosen'),
        ];

        $judul_sesi    = $this->request->getPost('judul_sesi')      ?? [];
        $link_yt       = $this->request->getPost('link_youtube')    ?? [];
        $link_zm       = $this->request->getPost('link_zoom_sesi')  ?? [];
        $judul_chapter = $this->request->getPost('judul_chapter')   ?? [];
        $mulai_menit   = $this->request->getPost('mulai_menit')     ?? [];
        $mulai_detik   = $this->request->getPost('mulai_detik_ch')  ?? [];
        $selesai_menit = $this->request->getPost('selesai_menit')   ?? [];
        $selesai_detik = $this->request->getPost('selesai_detik_ch') ?? [];

        // Simpan link_youtube pertama ke kolom lama (backward compat)
        $data_kelas['link_youtube'] = $link_yt[0] ?? null;
        $this->m_kelas->ubah_kelas($data_kelas);

        // Hapus video dan chapter lama lalu insert ulang
        $video_lama = $this->m_kelas_video->video_by_kelas($id_kelas);
        $id_video_lama = array_column($video_lama, 'id_kelas_video');
        $this->m_chapter->hapus_chapter_by_banyak_video($id_video_lama);
        $this->m_kelas_video->hapus_video_by_kelas($id_kelas);

        foreach ($judul_sesi as $i => $judul) {
            if (empty($judul)) continue;

            $this->m_kelas_video->tambah_video_sesi([
                'id_kelas'     => $id_kelas,
                'judul_sesi'   => $judul,
                'link_youtube' => $link_yt[$i] ?? null,
                'link_zoom'    => $link_zm[$i] ?? null,
                'urutan'       => $i + 1,
            ]);

            $id_video_baru = $this->m_kelas_video->db->insertID();

            // Simpan chapter untuk sesi ini
            $ch_juduls = $judul_chapter[$i]  ?? [];
            $ch_mm     = $mulai_menit[$i]    ?? [];
            $ch_ms     = $mulai_detik[$i]    ?? [];
            $ch_sm     = $selesai_menit[$i]  ?? [];
            $ch_ss     = $selesai_detik[$i]  ?? [];

            foreach ($ch_juduls as $j => $ch_judul) {
                if (empty($ch_judul)) continue;
                $this->m_chapter->tambah_chapter([
                    'id_kelas_video' => $id_video_baru,
                    'judul_chapter'  => $ch_judul,
                    'mulai_detik'    => ((int)($ch_mm[$j] ?? 0) * 60) + (int)($ch_ms[$j] ?? 0),
                    'selesai_detik'  => ((int)($ch_sm[$j] ?? 0) * 60) + (int)($ch_ss[$j] ?? 0),
                    'urutan'         => $j + 1,
                ]);
            }
        }

        session()->setFlashdata('success', 'Kelas berhasil diperbarui.');
        return redirect()->to(base_url('program/detail_program/' . $id_program));
    }

    // Menghapus kelas berdasarkan id_kelas
    public function hapus_kelas($id_kelas)
    {
        $kelas = $this->m_kelas->kelas_by_id(['id_kelas' => $id_kelas]);

        if (empty($kelas)) {
            return redirect()->to(base_url('program'))->with('error', 'Kelas tidak ditemukan.');
        }

        $id_program = $kelas['id_program'];

        if ($this->m_kelas->hapus_kelas(['id_kelas' => $id_kelas])) {
            session()->setFlashdata('success', 'Kelas berhasil dihapus.');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus kelas.');
        }

        return redirect()->to(base_url('program/detail_program/' . $id_program));
    }

    // Menonton rekaman kelas dengan sidebar playlist dan chapter
    public function nonton_kelas($id_kelas)
    {
        $data['kelas_aktif'] = $this->m_kelas->kelas_by_id(['id_kelas' => $id_kelas]);

        if (empty($data['kelas_aktif'])) {
            return redirect()->to(base_url('program'))->with('error', 'Rekaman kelas tidak ditemukan.');
        }

        $id_program = $data['kelas_aktif']['id_program'];
        $data['program']      = $this->m_program->program_by_id(['id_program' => $id_program]);
        $data['semua_kelas']  = $this->m_kelas->kelas_by_program(['id_program' => $id_program]);
        $data['kelas_videos'] = $this->m_kelas_video->video_by_kelas($id_kelas);

        // Fallback: jika belum ada di tabel kelas_video, pakai link_youtube lama
        if (empty($data['kelas_videos']) && !empty($data['kelas_aktif']['link_youtube'])) {
            $data['kelas_videos'] = [[
                'id_kelas_video' => 0,
                'judul_sesi'     => 'Sesi 1',
                'link_youtube'   => $data['kelas_aktif']['link_youtube'],
                'link_zoom'      => $data['kelas_aktif']['link_zoom'],
                'urutan'         => 1,
            ]];
        }

        if (empty($data['kelas_videos'])) {
            return redirect()->to(base_url('program/detail_program/' . $id_program))
                ->with('error', 'Rekaman kelas belum tersedia.');
        }

        // Kelompokkan chapter berdasarkan id_kelas_video
        $id_video_list = array_filter(array_column($data['kelas_videos'], 'id_kelas_video'));
        $semua_chapter = $this->m_chapter->chapter_by_banyak_video($id_video_list);
        $chapters_map  = [];
        foreach ($semua_chapter as $ch) {
            $chapters_map[$ch['id_kelas_video']][] = $ch;
        }
        $data['chapters_map'] = $chapters_map;

        if (!in_array(session()->get('user_role'), ['admin', 'superadmin'])) {
            $nama_peserta = session()->get('user_name') ?? '';
            $m_peserta    = new \App\Models\M_peserta_program();
            if (!$m_peserta->cek_sudah_join(['id_program' => $id_program, 'nama_peserta' => $nama_peserta])) {
                return redirect()->to(base_url('program/detail_program/' . $id_program))
                    ->with('error', 'Anda harus bergabung ke program ini terlebih dahulu.');
            }
        }

        return view('layout/header', ['title' => 'Rekaman Kelas ' . $data['kelas_aktif']['nama_kelas']])
            . view('layout/topbar')
            . view('startup_kelas/v_detail_vidio_kelas', $data)
            . view('layout/footer');
    }
}
