<?php

namespace App\Controllers;

use App\Models\M_materi_kelas;
use App\Models\M_startup_kelas;
use App\Models\M_startup_program;
use App\Models\M_peserta_program;

// Controller untuk mengelola materi kelas (upload, berbagi, hapus)
class Materi_kelas extends BaseController
{
    protected $m_materi;
    protected $m_kelas;
    protected $m_program;

    public function __construct()
    {
        $this->m_materi  = new M_materi_kelas();
        $this->m_kelas   = new M_startup_kelas();
        $this->m_program = new M_startup_program();
    }

    // Menampilkan daftar materi berdasarkan kelas
    public function index($id_kelas)
    {
        $data['kelas']   = $this->m_kelas->kelas_by_id(['id_kelas' => $id_kelas]);

        if (empty($data['kelas'])) {
            return redirect()->to(base_url('program'))->with('error', 'Kelas tidak ditemukan.');
        }

        $data['program'] = $this->m_program->program_by_id(['id_program' => $data['kelas']['id_program']]);
        $data['materi']  = $this->m_materi->materi_by_kelas($id_kelas);

        // Cek apakah user sudah join program (untuk peserta)
        $role = session()->get('user_role');
        $data['bisa_kelola'] = in_array($role, ['admin', 'superadmin']);
        $data['sudah_join']  = false;

        if (!$data['bisa_kelola']) {
            $nama = session()->get('user_name') ?? '';
            $data['sudah_join'] = (new M_peserta_program())
                ->cek_sudah_join(['id_program' => $data['kelas']['id_program'], 'nama_peserta' => $nama]);
        }

        return view('layout/header', ['title' => 'Materi Kelas'])
            . view('layout/topbar')
            . view('startup_kelas/v_materi_kelas', $data)
            . view('layout/footer');
    }

    // Menyimpan materi baru (upload file atau link berbagi)
    public function simpan_materi()
    {
        $id_kelas = $this->request->getPost('id_kelas');
        $nama_file = null;
        $tipe_file = null;

        // Proses upload file jika ada
        $file = $this->request->getFile('file_materi');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $nama_acak = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/materi', $nama_acak);
            $nama_file = $nama_acak;
            $tipe_file = $file->getClientExtension();
        }

        $data = [
            'id_kelas'      => $id_kelas,
            'judul'         => $this->request->getPost('judul'),
            'deskripsi'     => $this->request->getPost('deskripsi'),
            'nama_file'     => $nama_file,
            'tipe_file'     => $tipe_file,
            'link_berbagi'  => $this->request->getPost('link_berbagi'),
            'diunggah_oleh' => session()->get('user_name') ?? 'Admin',
        ];

        if ($this->m_materi->tambah_materi($data)) {
            session()->setFlashdata('success', 'Materi berhasil diunggah.');
        } else {
            session()->setFlashdata('error', 'Gagal mengunggah materi.');
        }

        return redirect()->to(base_url('materi_kelas/' . $id_kelas));
    }

    // Menghapus materi dan file-nya
    public function hapus_materi()
    {
        $id_materi = $this->request->getPost('id_materi');
        $id_kelas  = $this->request->getPost('id_kelas');

        $materi = $this->m_materi->materi_by_id($id_materi);

        // Hapus file fisik jika ada
        if (!empty($materi['nama_file'])) {
            $path = ROOTPATH . 'public/uploads/materi/' . $materi['nama_file'];
            if (file_exists($path)) {
                unlink($path);
            }
        }

        if ($this->m_materi->hapus_materi($id_materi)) {
            session()->setFlashdata('success', 'Materi berhasil dihapus.');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus materi.');
        }

        return redirect()->to(base_url('materi_kelas/' . $id_kelas));
    }

    // Download file materi
    public function download_materi($id_materi)
    {
        $materi = $this->m_materi->materi_by_id($id_materi);

        if (empty($materi) || empty($materi['nama_file'])) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        $path = ROOTPATH . 'public/uploads/materi/' . $materi['nama_file'];

        if (!file_exists($path)) {
            return redirect()->back()->with('error', 'File tidak ditemukan di server.');
        }

        return $this->response->download($path, null)->setFileName($materi['judul'] . '.' . $materi['tipe_file']);
    }
}
