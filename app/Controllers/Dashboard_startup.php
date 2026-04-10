<?php

namespace App\Controllers;

use App\Models\M_startup;

// Controller untuk menampilkan halaman dashboard ringkasan data startup
class Dashboard_startup extends BaseController
{
    protected $m_startup;

    // Inisialisasi model startup saat controller dibuat
    public function __construct()
    {
        $this->m_startup = new M_startup();
    }

    // Menampilkan halaman dashboard dengan total jumlah startup terdaftar
    public function index()
    {
        $data['total_startup'] = $this->m_startup->hitung_semua_startup();

        return view('Partials/v_header')
            . view('Partials/v_sidebar')
            . view('Partials/v_topbar')
            . view('Startup/v_dashboard_startup', $data)
            . view('Partials/v_footer');
    }

    // Mengembalikan data startup dalam format JSON untuk keperluan chart/tabel di dashboard (AJAX)
    public function get_data_startup()
    {
        $data = $this->m_startup->liat_detail_data();
        return $this->response->setJSON($data);
    }
}
