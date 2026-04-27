<?php

namespace App\Controllers;

use App\Models\M_startup_kelas;
use App\Models\M_startup_program;

// Controller untuk menampilkan kalender dan jadwal kelas
class Jadwal_kelas extends BaseController
{
    protected $m_kelas;
    protected $m_program;

    public function __construct()
    {
        $this->m_kelas   = new M_startup_kelas();
        $this->m_program = new M_startup_program();
    }

    // Menampilkan halaman kalender semua jadwal kelas
    public function index()
    {
        $data['semua_kelas']   = $this->m_kelas->semua_kelas_kalender();
        $data['kelas_mendatang'] = $this->m_kelas->kelas_mendatang();
        $data['semua_program'] = $this->m_program->semua_program();

        return view('layout/header', ['title' => 'Kalender Jadwal Kelas'])
            . view('layout/topbar')
            . view('startup_kelas/v_jadwal_kelas', $data)
            . view('layout/footer');
    }

    // Mengembalikan data kelas dalam format JSON untuk FullCalendar
    public function get_events()
    {
        $kelas  = $this->m_kelas->semua_kelas_kalender();
        $events = [];

        foreach ($kelas as $k) {
            $warna = match($k['status_kelas']) {
                'aktif'      => '#3b82f6',
                'selesai'    => '#22c55e',
                'dibatalkan' => '#ef4444',
                default      => '#94a3b8',
            };

            $events[] = [
                'id'    => $k['id_kelas'],
                'title' => $k['nama_kelas'],
                'start' => $k['tanggal'] . 'T' . ($k['jam_mulai'] ?? '00:00'),
                'end'   => $k['tanggal'] . 'T' . ($k['jam_selesai'] ?? '00:00'),
                'color' => $warna,
                'extendedProps' => [
                    'nama_program' => $k['nama_program'],
                    'nama_dosen'   => $k['nama_dosen'],
                    'status'       => $k['status_kelas'],
                    'id_kelas'     => $k['id_kelas'],
                    'id_program'   => $k['id_program'],
                ],
            ];
        }

        return $this->response->setJSON($events);
    }
}
