<?php

namespace App\Controllers;

use App\Models\M_startup;
use App\Models\M_startup_kelas;
use App\Models\M_startup_program;

// Controller untuk menampilkan halaman dashboard
class Dashboard_startup extends BaseController
{
    protected $m_startup;
    protected $m_kelas;
    protected $m_program;

    public function __construct()
    {
        $this->m_startup = new M_startup();
        $this->m_kelas   = new M_startup_kelas();
        $this->m_program = new M_startup_program();
    }

    public function index()
    {
        $role = session()->get('user_role');

        // Dashboard khusus pemateri: tampilkan jadwal kelas yang dia materikan
        if ($role === 'pemateri') {
            $id_user        = session()->get('user_id');
            $semua_kelas    = $this->m_kelas->kelas_by_pemateri($id_user);
            $m_jawaban      = new \App\Models\M_jawaban_tugas();

            // Kelompokkan kelas per program + hitung jawaban pending
            $per_program = [];
            foreach ($semua_kelas as $k) {
                $id_p = $k['id_program'];
                if (!isset($per_program[$id_p])) {
                    $per_program[$id_p] = ['nama_program' => $k['nama_program'], 'kelas' => []];
                }
                $k['jawaban_pending'] = $m_jawaban->hitung_belum_dikomentari_by_kelas($k['id_kelas']);
                $per_program[$id_p]['kelas'][] = $k;
            }

            $data['per_program'] = $per_program;
            return view('layout/header', ['title' => 'Dashboard Pemateri'])
                . view('layout/topbar')
                . view('startup_kelas/v_dashboard_pemateri', $data)
                . view('layout/footer');
        }

        $db = db_connect();
        $data['total_startup'] = $this->m_startup->hitung_semua_startup();
        $data['total_program']  = $db->table('program_startup')->countAllResults();
        $data['total_buku']     = $db->table('konten_ebook')->countAllResults();
        $data['total_video']    = $db->table('konten_video')->countAllResults();
        return view('layout/header')
            . view('layout/topbar')
            . view('startup/v_dashboard', $data)
            . view('layout/footer');
    }

    public function get_data_startup()
    {
        $data = $this->m_startup->liat_detail_data();
        return $this->response->setJSON($data);
    }

    public function get_data_program()
    {
        $db   = db_connect();
        $data = $db->table('program_startup')
            ->select('nama_program, deskripsi, dibuat_pada')
            ->orderBy('dibuat_pada', 'DESC')
            ->get()->getResultArray();
        return $this->response->setJSON($data);
    }

    public function get_data_buku()
    {
        $db   = db_connect();
        $data = $db->table('konten_ebook')
            ->select('judul_ebook, kategori_ebook, status_ebook, created_at')
            ->orderBy('created_at', 'DESC')
            ->get()->getResultArray();
        return $this->response->setJSON($data);
    }

    public function get_data_video()
    {
        $db   = db_connect();
        $data = $db->table('konten_video')
            ->select('judul_video, kategori_video, status_video, created_at')
            ->orderBy('created_at', 'DESC')
            ->get()->getResultArray();
        return $this->response->setJSON($data);
    }

    public function chart_per_tahun()
    {
        $start = (int)($this->request->getGet('start_year') ?? date('Y') - 2);
        $end   = (int)($this->request->getGet('end_year')   ?? date('Y'));
        return $this->response->setJSON($this->m_startup->startup_per_tahun($start, $end));
    }

    public function chart_per_bulan()
    {
        $tahun = (int)($this->request->getGet('tahun') ?? date('Y'));
        return $this->response->setJSON($this->m_startup->startup_per_bulan($tahun));
    }
}