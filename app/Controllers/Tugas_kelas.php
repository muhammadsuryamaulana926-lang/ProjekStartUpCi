<?php

namespace App\Controllers;

use App\Models\M_tugas_kelas;
use App\Models\M_jawaban_tugas;
use App\Models\M_startup_kelas;
use App\Models\M_startup_program;

// Controller untuk mengelola tugas kelas, jawaban peserta, dan komentar pemateri
class Tugas_kelas extends BaseController
{
    protected $m_tugas;
    protected $m_jawaban;
    protected $m_kelas;
    protected $m_program;

    public function __construct()
    {
        $this->m_tugas   = new M_tugas_kelas();
        $this->m_jawaban = new M_jawaban_tugas();
        $this->m_kelas   = new M_startup_kelas();
        $this->m_program = new M_startup_program();
    }

    // Menampilkan daftar tugas dan form submit jawaban per kelas
    public function index($id_kelas)
    {
        $data['kelas'] = $this->m_kelas->kelas_by_id(['id_kelas' => $id_kelas]);

        if (empty($data['kelas'])) {
            return redirect()->to(base_url('program'))->with('error', 'Kelas tidak ditemukan.');
        }

        $data['program']      = $this->m_program->program_by_id(['id_program' => $data['kelas']['id_program']]);
        $data['tugas_list']   = $this->m_tugas->tugas_by_kelas($id_kelas);
        $data['nama_peserta'] = session()->get('user_name') ?? '';
        $data['role']         = session()->get('user_role');
        $data['bisa_kelola']  = in_array($data['role'], ['admin', 'superadmin', 'pemateri']);

        // Untuk setiap tugas, ambil jawaban peserta yang login dan semua jawaban (untuk pemateri/admin)
        $data['jawaban_saya'] = [];
        $data['semua_jawaban'] = [];
        foreach ($data['tugas_list'] as $t) {
            $data['jawaban_saya'][$t['id_tugas']]   = $this->m_jawaban->jawaban_by_peserta($t['id_tugas'], $data['nama_peserta']);
            $data['semua_jawaban'][$t['id_tugas']]  = $this->m_jawaban->jawaban_by_tugas($t['id_tugas']);
        }

        return view('layout/header', ['title' => 'Tugas Kelas'])
            . view('layout/topbar')
            . view('startup_kelas/v_tugas_kelas', $data)
            . view('layout/footer');
    }

    // Menyimpan tugas baru oleh pemateri/admin
    public function simpan_tugas()
    {
        $id_kelas  = $this->request->getPost('id_kelas');
        $nama_file = null;
        $tipe_file = null;

        $file = $this->request->getFile('file_soal');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $nama_acak = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/tugas', $nama_acak);
            $nama_file = $nama_acak;
            $tipe_file = $file->getClientExtension();
        }

        $data = [
            'id_kelas'    => $id_kelas,
            'judul'       => $this->request->getPost('judul'),
            'instruksi'   => $this->request->getPost('instruksi'),
            'nama_file'   => $nama_file,
            'tipe_file'   => $tipe_file,
            'dibuat_oleh' => session()->get('user_name') ?? 'Admin',
        ];

        if ($this->m_tugas->tambah_tugas($data)) {
            session()->setFlashdata('success', 'Tugas berhasil ditambahkan.');
        } else {
            session()->setFlashdata('error', 'Gagal menambahkan tugas.');
        }

        return redirect()->to(base_url('tugas_kelas/' . $id_kelas));
    }

    // Menghapus tugas oleh pemateri/admin
    public function hapus_tugas()
    {
        $id_tugas = $this->request->getPost('id_tugas');
        $id_kelas = $this->request->getPost('id_kelas');

        $tugas = $this->m_tugas->tugas_by_id($id_tugas);
        if (!empty($tugas['nama_file'])) {
            $path = ROOTPATH . 'public/uploads/tugas/' . $tugas['nama_file'];
            if (file_exists($path)) unlink($path);
        }

        if ($this->m_tugas->hapus_tugas($id_tugas)) {
            session()->setFlashdata('success', 'Tugas berhasil dihapus.');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus tugas.');
        }

        return redirect()->to(base_url('tugas_kelas/' . $id_kelas));
    }

    // Menyimpan jawaban peserta
    public function simpan_jawaban()
    {
        $id_tugas     = $this->request->getPost('id_tugas');
        $id_kelas     = $this->request->getPost('id_kelas');
        $nama_peserta = session()->get('user_name') ?? '';

        if ($this->m_jawaban->jawaban_by_peserta($id_tugas, $nama_peserta)) {
            session()->setFlashdata('error', 'Anda sudah mengumpulkan jawaban untuk tugas ini.');
            return redirect()->to(base_url('tugas_kelas/' . $id_kelas));
        }

        $nama_file = null;
        $tipe_file = null;
        $file = $this->request->getFile('file_jawaban');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $nama_acak = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/tugas', $nama_acak);
            $nama_file = $nama_acak;
            $tipe_file = $file->getClientExtension();
        }

        $data = [
            'id_tugas'     => $id_tugas,
            'nama_peserta' => $nama_peserta,
            'jawaban_teks' => $this->request->getPost('jawaban_teks'),
            'nama_file'    => $nama_file,
            'tipe_file'    => $tipe_file,
        ];

        if ($this->m_jawaban->simpan_jawaban($data)) {
            session()->setFlashdata('success', 'Jawaban berhasil dikumpulkan.');

            // Kirim notifikasi ke pemateri kelas ini
            $kelas = $this->m_kelas->kelas_by_id(['id_kelas' => $id_kelas]);
            $tugas = $this->m_tugas->tugas_by_id($id_tugas);
            if (!empty($kelas['id_pemateri'])) {
                (new \App\Models\M_notifikasi())->tambah_notifikasi([
                    'judul'      => 'Jawaban Tugas Masuk',
                    'pesan'      => $nama_peserta . ' mengumpulkan jawaban tugas "' . ($tugas['judul'] ?? '') . '"',
                    'untuk_role' => 'pemateri',
                    'url'        => base_url('tugas_kelas/' . $id_kelas),
                ]);
            }
        } else {
            session()->setFlashdata('error', 'Gagal mengumpulkan jawaban.');
        }

        return redirect()->to(base_url('tugas_kelas/' . $id_kelas));
    }

    // Menyimpan komentar pemateri ke jawaban peserta
    public function simpan_komentar()
    {
        $id_jawaban = $this->request->getPost('id_jawaban');
        $id_kelas   = $this->request->getPost('id_kelas');
        $komentar   = $this->request->getPost('komentar');

        if ($this->m_jawaban->simpan_komentar($id_jawaban, $komentar)) {
            session()->setFlashdata('success', 'Komentar berhasil disimpan.');
        } else {
            session()->setFlashdata('error', 'Gagal menyimpan komentar.');
        }

        return redirect()->to(base_url('tugas_kelas/' . $id_kelas));
    }

    // Preview file tugas atau jawaban (stream ke browser)
    public function preview($tipe, $id)
    {
        if ($tipe === 'tugas') {
            $data = $this->m_tugas->tugas_by_id($id);
        } else {
            $data = $this->m_jawaban->jawaban_by_id($id);
        }

        if (empty($data['nama_file'])) {
            return $this->response->setStatusCode(404)->setBody('File tidak ditemukan.');
        }

        $path = ROOTPATH . 'public/uploads/tugas/' . $data['nama_file'];

        if (!file_exists($path)) {
            return $this->response->setStatusCode(404)->setBody('File tidak ditemukan di server.');
        }

        $mime_map = [
            'pdf'  => 'application/pdf',
            'png'  => 'image/png',
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif'  => 'image/gif',
        ];
        $tipe_file = strtolower($data['tipe_file'] ?? '');
        $mime      = $mime_map[$tipe_file] ?? null;

        if ($mime) {
            return $this->response
                ->setHeader('Content-Type', $mime)
                ->setHeader('Content-Disposition', 'inline; filename="' . $data['nama_file'] . '"')
                ->setBody(file_get_contents($path));
        }

        // Office files — Google Docs Viewer
        $url_file = base_url('uploads/tugas/' . $data['nama_file']);
        return redirect()->to('https://docs.google.com/viewer?url=' . urlencode($url_file) . '&embedded=true');
    }

    // Download file tugas atau jawaban
    public function download($tipe, $id)
    {
        if ($tipe === 'tugas') {
            $data = $this->m_tugas->tugas_by_id($id);
            $nama = $data['judul'] ?? 'tugas';
        } else {
            $data = $this->m_jawaban->jawaban_by_id($id);
            $nama = 'jawaban_' . ($data['nama_peserta'] ?? 'peserta');
        }

        if (empty($data['nama_file'])) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        $path = ROOTPATH . 'public/uploads/tugas/' . $data['nama_file'];
        if (!file_exists($path)) {
            return redirect()->back()->with('error', 'File tidak ditemukan di server.');
        }

        return $this->response->download($path, null)->setFileName($nama . '.' . $data['tipe_file']);
    }
}
