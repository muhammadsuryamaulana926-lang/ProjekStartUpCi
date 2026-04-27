<?php

namespace App\Controllers;

use App\Models\M_peserta_kelas;
use App\Models\M_peserta_program;
use App\Models\M_startup_kelas;
use App\Models\M_startup_program;

// Controller untuk mengelola peserta kelas yang diassign oleh admin
class Peserta_kelas extends BaseController
{
    protected $m_peserta_kelas;
    protected $m_peserta_program;
    protected $m_kelas;
    protected $m_program;

    public function __construct()
    {
        $this->m_peserta_kelas   = new M_peserta_kelas();
        $this->m_peserta_program = new M_peserta_program();
        $this->m_kelas           = new M_startup_kelas();
        $this->m_program         = new M_startup_program();
    }

    // Menampilkan halaman kelola peserta kelas
    public function index($id_kelas)
    {
        $data['kelas'] = $this->m_kelas->kelas_by_id(['id_kelas' => $id_kelas]);

        if (empty($data['kelas'])) {
            return redirect()->to(base_url('program'))->with('error', 'Kelas tidak ditemukan.');
        }

        $data['program']         = $this->m_program->program_by_id(['id_program' => $data['kelas']['id_program']]);
        $data['peserta_kelas']   = $this->m_peserta_kelas->peserta_by_kelas($id_kelas);
        $data['peserta_program'] = $this->m_peserta_program->peserta_by_program(['id_program' => $data['kelas']['id_program']]);

        // Tandai peserta program yang sudah terdaftar di kelas ini
        $sudah_terdaftar = array_column($data['peserta_kelas'], 'nama_peserta');
        $data['belum_terdaftar'] = array_filter($data['peserta_program'], function($p) use ($sudah_terdaftar) {
            return !in_array($p['nama_peserta'], $sudah_terdaftar);
        });

        return view('layout/header', ['title' => 'Peserta Kelas'])
            . view('layout/topbar')
            . view('startup_kelas/v_peserta_kelas', $data)
            . view('layout/footer');
    }

    // Menambah peserta ke kelas
    public function tambah_peserta()
    {
        $id_kelas     = $this->request->getPost('id_kelas');
        $nama_peserta = $this->request->getPost('nama_peserta');

        if ($this->m_peserta_kelas->cek_sudah_terdaftar($id_kelas, $nama_peserta)) {
            session()->setFlashdata('error', 'Peserta sudah terdaftar di kelas ini.');
            return redirect()->to(base_url('peserta_kelas/' . $id_kelas));
        }

        if ($this->m_peserta_kelas->tambah_peserta(['id_kelas' => $id_kelas, 'nama_peserta' => $nama_peserta])) {
            session()->setFlashdata('success', 'Peserta berhasil ditambahkan ke kelas.');
        } else {
            session()->setFlashdata('error', 'Gagal menambahkan peserta.');
        }

        return redirect()->to(base_url('peserta_kelas/' . $id_kelas));
    }

    // Menghapus peserta dari kelas
    public function hapus_peserta()
    {
        $id_peserta_kelas = $this->request->getPost('id_peserta_kelas');
        $id_kelas         = $this->request->getPost('id_kelas');

        if ($this->m_peserta_kelas->hapus_peserta($id_peserta_kelas)) {
            session()->setFlashdata('success', 'Peserta berhasil dikeluarkan dari kelas.');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus peserta.');
        }

        return redirect()->to(base_url('peserta_kelas/' . $id_kelas));
    }
}
