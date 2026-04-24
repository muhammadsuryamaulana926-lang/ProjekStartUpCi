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

        return view('layout/header')
            . view('layout/topbar')
            . view('startup/v_dashboard', $data)
            . view('layout/footer');
    }

    // Mengembalikan data startup dalam format JSON untuk keperluan chart/tabel di dashboard (AJAX)
    public function get_data_startup()
    {
        $data = $this->m_startup->liat_detail_data();
        return $this->response->setJSON($data);
    }

    // Data chart startup per tahun
    public function chart_per_tahun()
    {
        $start = (int)($this->request->getGet('start_year') ?? date('Y') - 2);
        $end   = (int)($this->request->getGet('end_year')   ?? date('Y'));
        return $this->response->setJSON($this->m_startup->startup_per_tahun($start, $end));
    }

    // Data chart startup per bulan
    public function chart_per_bulan()
    {
        $tahun = (int)($this->request->getGet('tahun') ?? date('Y'));
        return $this->response->setJSON($this->m_startup->startup_per_bulan($tahun));
    }
}
