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
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $data['program']         = $this->m_program->program_by_id(['id_program' => $data['kelas']['id_program']]);
        $data['peserta_kelas']   = $this->m_peserta_kelas->peserta_by_kelas($id_kelas);
        $data['peserta_program'] = $this->m_peserta_program->peserta_by_program(['id_program' => $data['kelas']['id_program']]);

        // Gabungkan data presensi ke peserta_kelas untuk tampil waktu hadir
        $presensi_list = (new \App\Models\M_presensi_kelas())->presensi_by_kelas($id_kelas);
        $presensi_map  = array_column($presensi_list, null, 'nama_peserta');
        $sudah_terdaftar = [];
        foreach ($data['peserta_kelas'] as &$pk) {
            $pk['waktu_presensi'] = $presensi_map[$pk['nama_peserta']]['dibuat_pada'] ?? null;
            $pk['kondisi_hadir']  = $presensi_map[$pk['nama_peserta']]['kondisi_hadir'] ?? null;
            $sudah_terdaftar[]    = $pk['nama_peserta'];
        }
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
        $id_kelas      = $this->request->getPost('id_kelas');
        $nama_list     = $this->request->getPost('nama_peserta');

        if (empty($nama_list)) {
            session()->setFlashdata('error', 'Pilih minimal satu peserta.');
            return redirect()->back();
        }

        $nama_list = is_array($nama_list) ? $nama_list : [$nama_list];
        $kelas     = $this->m_kelas->kelas_by_id(['id_kelas' => $id_kelas]);
        $id_program = $kelas['id_program'] ?? null;
        $gagal = 0;
        foreach ($nama_list as $nama_peserta) {
            if (!$this->m_peserta_kelas->cek_sudah_terdaftar($id_kelas, $nama_peserta)) {
                $this->m_peserta_kelas->tambah_peserta(['id_kelas' => $id_kelas, 'nama_peserta' => $nama_peserta]);
            } else {
                $gagal++;
            }
            // Otomatis daftarkan ke peserta_program jika belum
            if ($id_program && !$this->m_peserta_program->cek_sudah_join(['id_program' => $id_program, 'nama_peserta' => $nama_peserta])) {
                $this->m_peserta_program->tambah_peserta(['id_program' => $id_program, 'nama_peserta' => $nama_peserta]);
            }
        }

        session()->setFlashdata('success', 'Peserta berhasil ditambahkan ke kelas.' . ($gagal ? " ($gagal sudah terdaftar, dilewati)" : ''));
        return redirect()->back();
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
