<?php

namespace App\Controllers;

use App\Models\M_startup;
use App\Models\M_startup_kelas;
use App\Models\M_startup_program;
use App\Models\M_perpustakaan;

// Controller untuk menampilkan halaman dashboard
class Dashboard_startup extends BaseController
{
    protected $m_startup;
    protected $m_kelas;
    protected $m_program;
    protected $m_perpus;

    public function __construct()
    {
        $this->m_startup = new M_startup();
        $this->m_kelas   = new M_startup_kelas();
        $this->m_program = new M_startup_program();
        $this->m_perpus  = new M_perpustakaan();
    }

    public function index()
    {
        $role = session()->get('user_role');

        // Blokir role yang tidak boleh akses dashboard
        $role_terlarang = ['peserta_program_kelas', 'pemilik_startup'];
        if (in_array($role, $role_terlarang) || session()->get('is_peserta_program')) {
            return redirect()->to(base_url('program'))->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

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

    public function chart_top_video()
    {
        return $this->response->setJSON($this->m_perpus->top_video_ditonton(10));
    }

    public function chart_tren_penonton()
    {
        $tahun = (int)($this->request->getGet('tahun') ?? date('Y'));
        $mode  = $this->request->getGet('mode') ?? 'bulan';

        if ($mode === 'minggu') {
            $data = $this->m_perpus->tren_penonton_per_minggu($tahun);
        } elseif ($mode === 'tahun') {
            $data = $this->m_perpus->tren_penonton_per_tahun();
        } else {
            $data = $this->m_perpus->tren_penonton_per_bulan($tahun);
        }
        return $this->response->setJSON($data);
    }

    public function chart_top_ebook()
    {
        return $this->response->setJSON($this->m_perpus->top_ebook_dibaca(10));
    }

    public function chart_tren_pembaca_ebook()
    {
        $tahun = (int)($this->request->getGet('tahun') ?? date('Y'));
        $mode  = $this->request->getGet('mode') ?? 'bulan';

        if ($mode === 'minggu') {
            $data = $this->m_perpus->tren_pembaca_ebook_per_minggu($tahun);
        } elseif ($mode === 'tahun') {
            $data = $this->m_perpus->tren_pembaca_ebook_per_tahun();
        } else {
            $data = $this->m_perpus->tren_pembaca_ebook_per_bulan($tahun);
        }
        return $this->response->setJSON($data);
    }
}