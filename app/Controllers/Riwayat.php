<?php

namespace App\Controllers;

use App\Models\M_riwayat;
use App\Models\M_user;

// Controller untuk mengelola riwayat aktivitas user (video & ebook)
class Riwayat extends BaseController
{
    protected $m_riwayat;
    protected $m_user;

    public function __construct()
    {
        $this->m_riwayat = new M_riwayat();
        $this->m_user    = new M_user();
        helper('time');
    }

    // Menampilkan halaman log aktivitas seluruh user (khusus admin)
    public function index()
    {
        $raw_user = $this->request->getGet('id_user');
        $filters = [
            'id_user'     => $raw_user ? base64_decode($raw_user) : null,
            'raw_id_user' => $raw_user ?? '',
            'timeframe'   => $this->request->getGet('timeframe'),
        ];

        return view('layout/v_header')
            . view('layout/v_sidebar')
            . view('layout/v_topbar')
            . view('startup/v_riwayat_aktivitas', [
                'riwayat'         => $this->m_riwayat->semua_riwayat($filters),
                'users'           => $this->m_user->findAll(),
                'current_filters' => $filters,
            ])
            . view('layout/v_footer');
    }

    // Menyimpan atau memperbarui riwayat tonton video via AJAX
    public function simpan_riwayat_video()
    {
        $id_user  = session()->get('user_id');
        $id_video = $this->request->getPost('id_video');
        $durasi   = $this->request->getPost('durasi');

        if ($id_video && $durasi !== null) {
            $this->m_riwayat->simpan_video([
                'id_user' => $id_user,
                'id_item' => $id_video,
                'durasi'  => $durasi,
            ]);
        }

        return $this->response->setJSON(['status' => 'success']);
    }

    // Menyimpan atau memperbarui riwayat baca ebook via AJAX
    public function simpan_riwayat_ebook()
    {
        $id_user  = session()->get('user_id');
        $id_ebook = $this->request->getPost('id_ebook');
        $halaman  = $this->request->getPost('halaman_terakhir');

        if ($id_ebook && $halaman !== null) {
            $this->m_riwayat->simpan_ebook([
                'id_user'          => $id_user,
                'id_item'          => $id_ebook,
                'halaman_terakhir' => $halaman,
            ]);
        }

        return $this->response->setJSON(['status' => 'success']);
    }
}
