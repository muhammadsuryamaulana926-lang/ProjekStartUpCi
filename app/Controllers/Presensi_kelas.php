<?php

namespace App\Controllers;

use App\Models\M_presensi_kelas;
use App\Models\M_startup_kelas;
use App\Models\M_startup_program;
use App\Models\M_peserta_program;
use App\Models\M_peserta_kelas;

// Controller untuk mengelola presensi/check-in peserta sebelum masuk kelas
class Presensi_kelas extends BaseController
{
    protected $m_presensi;
    protected $m_kelas;
    protected $m_program;

    public function __construct()
    {
        $this->m_presensi = new M_presensi_kelas();
        $this->m_kelas    = new M_startup_kelas();
        $this->m_program  = new M_startup_program();
    }

    // Menampilkan halaman detail kelas beserta daftar presensi dan form check-in
    public function detail_kelas($id_kelas)
    {
        $data['kelas'] = $this->m_kelas->kelas_by_id(['id_kelas' => $id_kelas]);

        if (empty($data['kelas'])) {
            return redirect()->to(base_url('program'))->with('error', 'Kelas tidak ditemukan.');
        }

        $data['program']   = $this->m_program->program_by_id(['id_program' => $data['kelas']['id_program']]);
        $data['presensi']  = $this->m_presensi->presensi_by_kelas($id_kelas);

        $nama_peserta             = session()->get('user_name') ?? '';
        $data['sudah_presensi']   = $this->m_presensi->cek_sudah_presensi($id_kelas, $nama_peserta);
        $data['nama_peserta']     = $nama_peserta;
        $data['bisa_kelola']      = in_array(session()->get('user_role'), ['admin', 'superadmin', 'pemateri']);

        // Cek apakah sudah join program — pakai id_user atau nama_peserta
        if ($data['bisa_kelola']) {
            $data['sudah_join'] = true;
        } else {
            $id_user = session()->get('user_id');
            $cek = $id_user
                ? ['id_program' => $data['kelas']['id_program'], 'id_user' => $id_user]
                : ['id_program' => $data['kelas']['id_program'], 'nama_peserta' => $nama_peserta];
            $data['sudah_join'] = (new M_peserta_program())->cek_sudah_join($cek);
        }

        // Hitung apakah kelas bisa diakses (30 menit sebelum jam mulai)
        $data['bisa_akses'] = $this->cek_bisa_akses($data['kelas']);

        return view('layout/header', ['title' => 'Detail Kelas'])
            . view('layout/topbar')
            . view('startup_kelas/v_detail_kelas', $data)
            . view('layout/footer');
    }

    // Menyimpan presensi peserta (check-in)
    public function simpan_presensi()
    {
        $id_kelas     = $this->request->getPost('id_kelas');
        $id_program   = $this->request->getPost('id_program');
        $nama_peserta = session()->get('user_name') ?? '';
        $catatan      = $this->request->getPost('catatan');

        $kelas = $this->m_kelas->kelas_by_id(['id_kelas' => $id_kelas]);

        // Validasi: hanya bisa presensi 30 menit sebelum kelas
        if (!$this->cek_bisa_akses($kelas)) {
            session()->setFlashdata('error', 'Presensi hanya bisa dilakukan 30 menit sebelum kelas dimulai.');
            return redirect()->to(base_url('presensi_kelas/detail_kelas/' . $id_kelas));
        }

        if ($this->m_presensi->cek_sudah_presensi($id_kelas, $nama_peserta)) {
            session()->setFlashdata('error', 'Anda sudah melakukan presensi untuk kelas ini.');
            return redirect()->to(base_url('presensi_kelas/detail_kelas/' . $id_kelas));
        }

        $data = [
            'id_kelas'      => $id_kelas,
            'id_program'    => $id_program,
            'nama_peserta'  => $nama_peserta,
            'kondisi_hadir' => $this->request->getPost('kondisi_hadir'),
            'catatan'       => $this->request->getPost('catatan'),
        ];

        if ($this->m_presensi->simpan_presensi($data)) {
            session()->setFlashdata('success', 'Presensi berhasil. Silakan akses kelas.');
        } else {
            session()->setFlashdata('error', 'Gagal menyimpan presensi.');
        }

        return redirect()->to(base_url('presensi_kelas/detail_kelas/' . $id_kelas));
    }

    // Menghapus presensi oleh admin
    public function hapus_presensi()
    {
        $id_presensi = $this->request->getPost('id_presensi');
        $id_kelas    = $this->request->getPost('id_kelas');

        if ($this->m_presensi->hapus_presensi($id_presensi)) {
            session()->setFlashdata('success', 'Presensi berhasil dihapus.');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus presensi.');
        }

        return redirect()->to(base_url('presensi_kelas/detail_kelas/' . $id_kelas));
    }

    // Helper: cek apakah kelas bisa diakses (30 menit sebelum jam mulai s/d selesai)
    private function cek_bisa_akses($kelas)
    {
        if (empty($kelas['tanggal']) || empty($kelas['jam_mulai'])) return false;

        $sekarang   = time();
        $jam_mulai  = strtotime($kelas['tanggal'] . ' ' . $kelas['jam_mulai']);
        $jam_selesai = !empty($kelas['jam_selesai'])
            ? strtotime($kelas['tanggal'] . ' ' . $kelas['jam_selesai'])
            : $jam_mulai + 7200;

        // Bisa akses mulai 30 menit sebelum jam mulai hingga kelas selesai
        return $sekarang >= ($jam_mulai - 1800) && $sekarang <= $jam_selesai;
    }
}
