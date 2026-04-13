<?php

namespace App\Controllers;

use App\Models\M_riwayat;
use App\Models\M_perpustakaan;

class Riwayat extends BaseController
{
    protected $m_riwayat;

    public function __construct()
    {
        $this->m_riwayat = new M_riwayat();
    }

    public function index()
    {
        // Pastikan user login dan adalah admin
        if (!session()->get('user_logged_in')) {
            return redirect()->to('/login');
        }

        if (session()->get('user_role') !== 'admin') {
            return redirect()->to(base_url('v_dashboard'))->with('error', 'Akses ditolak.');
        }

        helper('time');

        $data['title'] = 'Riwayat Aktivitas User';
        $data['riwayat'] = $this->m_riwayat->get_semua_riwayat();

        return view('v_history', $data);
    }

    // Mendapat request AJAX untuk update video
    public function update_video()
    {
        if (!session()->get('user_logged_in')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $id_user = session()->get('user_id');
        $id_video = $this->request->getPost('id_video');
        $durasi = $this->request->getPost('durasi');

        if ($id_video && $durasi !== null) {
            $this->m_riwayat->update_riwayat_video([
                'id_user' => $id_user,
                'id_item' => $id_video,
                'durasi' => $durasi
            ]);
            return $this->response->setJSON(['status' => 'success']);
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid data']);
    }

    // Mendapat request AJAX untuk update ebook
    public function update_ebook()
    {
        if (!session()->get('user_logged_in')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $id_user = session()->get('user_id');
        $id_ebook = $this->request->getPost('id_ebook');
        $halaman = $this->request->getPost('halaman_terakhir');

        if ($id_ebook && $halaman !== null) {
            $this->m_riwayat->update_riwayat_ebook([
                'id_user' => $id_user,
                'id_item' => $id_ebook,
                'halaman_terakhir' => $halaman
            ]);
            return $this->response->setJSON(['status' => 'success']);
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid data']);
    }
}
