<?php

namespace App\Controllers;

use App\Models\M_startup_program;
use App\Models\M_startup_kelas;
use App\Models\M_peserta_program;
use App\Models\M_peserta_kelas;

// Controller untuk mengelola data program inkubasi/akselerasi startup
class Program_startup extends BaseController
{
    protected $m_program;
    protected $m_kelas;
    protected $m_peserta;

    public function __construct()
    {
        $this->m_program = new M_startup_program();
        $this->m_kelas   = new M_startup_kelas();
        $this->m_peserta = new M_peserta_program();
    }

    // Menampilkan daftar semua program
    public function index()
    {
        $id_user      = session()->get('user_id');
        $role         = session()->get('user_role');
        $nama_peserta = session()->get('user_name') ?? 'Admin';
        $is_peserta   = session()->get('is_peserta_program');

        $data['program'] = $this->m_program->semua_program();

        foreach ($data['program'] as &$p) {
            $cek = $id_user
                ? ['id_program' => $p['id_program'], 'id_user' => $id_user]
                : ['id_program' => $p['id_program'], 'nama_peserta' => $nama_peserta];
            $p['sudah_join']     = in_array($role, ['admin', 'superadmin', 'pemateri']) ? true : $this->m_peserta->cek_sudah_join($cek);
            $p['jumlah_kelas']   = $this->m_program->hitung_kelas_program(['id_program' => $p['id_program']]);
            $p['jumlah_peserta'] = $this->m_program->hitung_peserta_program(['id_program' => $p['id_program']]);

            // Untuk peserta: langsung load kelas agar tidak perlu klik detail dulu
            if (($is_peserta || $role === 'pemilik_startup') && $p['sudah_join']) {
                $p['kelas'] = $this->m_kelas->kelas_by_program(['id_program' => $p['id_program']]);
                $m_presensi = new \App\Models\M_presensi_kelas();
                foreach ($p['kelas'] as &$k) {
                    $k['sudah_presensi'] = $m_presensi->cek_sudah_presensi($k['id_kelas'], $nama_peserta);
                }
            }
        }

        return view('layout/header', ['title' => 'Daftar Program'])
            . view('layout/topbar')
            . view('startup_kelas/v_program', $data)
            . view('layout/footer');
    }

    // Menampilkan form tambah program
    public function tambah_program()
    {
        return view('layout/header', ['title' => 'Tambah Program'])
            . view('layout/topbar')
            . view('startup_kelas/v_tambah_program')
            . view('layout/footer');
    }

    // Menyimpan data program baru
    public function simpan_program()
    {
        $data = [
            'nama_program'   => $this->request->getPost('nama_program'),
            'deskripsi'      => $this->request->getPost('deskripsi'),
            'status_program' => $this->request->getPost('status_program') ?: 'aktif',
        ];

        if ($this->m_program->tambah_program($data)) {
            session()->setFlashdata('success', 'Program berhasil ditambahkan.');
        } else {
            session()->setFlashdata('error', 'Gagal menambahkan program.');
        }

        return redirect()->to(base_url('program'));
    }

    // Menampilkan form edit program
    public function edit_program($id)
    {
        $data['program'] = $this->m_program->program_by_id(['id_program' => $id]);

        if (empty($data['program'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        return view('layout/header', ['title' => 'Edit Program'])
            . view('layout/topbar')
            . view('startup_kelas/v_edit_program', $data)
            . view('layout/footer');
    }

    // Memperbarui data program
    public function ubah_program()
    {
        $id   = $this->request->getPost('id_program');
        $data = [
            'id_program'     => $id,
            'nama_program'   => $this->request->getPost('nama_program'),
            'deskripsi'      => $this->request->getPost('deskripsi'),
            'status_program' => $this->request->getPost('status_program') ?: 'aktif',
        ];

        if ($this->m_program->ubah_program($data)) {
            session()->setFlashdata('success', 'Program berhasil diperbarui.');
        } else {
            session()->setFlashdata('error', 'Gagal memperbarui program.');
        }

        return redirect()->to(base_url('program'));
    }

    // Menghapus program berdasarkan id
    public function hapus_program($id)
    {
        if ($this->m_program->hapus_program(['id_program' => $id])) {
            session()->setFlashdata('success', 'Program berhasil dihapus.');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus program.');
        }

        return redirect()->to(base_url('program'));
    }

    // Menampilkan detail program beserta daftar kelas dan peserta
    public function detail_program($id)
    {
        $data['program'] = $this->m_program->program_by_id(['id_program' => $id]);

        if (empty($data['program'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $id_user            = session()->get('user_id');
        $role               = session()->get('user_role');
        $nama_peserta       = session()->get('user_name') ?? 'Admin';
        $data['kelas']      = $this->m_kelas->kelas_by_program(['id_program' => $id]);

        // Load peserta per kelas
        $m_peserta_kelas = new M_peserta_kelas();
        foreach ($data['kelas'] as &$k) {
            $k['peserta_kelas'] = $m_peserta_kelas->peserta_by_kelas($k['id_kelas']);
        }

        // Pemateri dan admin selalu dianggap sudah join
        if (in_array($role, ['admin', 'superadmin', 'pemateri'])) {
            $data['sudah_join'] = true;
        } else {
            $cek = $id_user
                ? ['id_program' => $id, 'id_user' => $id_user]
                : ['id_program' => $id, 'nama_peserta' => $nama_peserta];
            $data['sudah_join'] = $this->m_peserta->cek_sudah_join($cek);
        }

        $data['peserta'] = $this->m_peserta->peserta_by_program(['id_program' => $id]);

        return view('layout/header', ['title' => 'Detail Program'])
            . view('layout/topbar')
            . view('startup_kelas/v_detail_program', $data)
            . view('layout/footer');
    }
}
