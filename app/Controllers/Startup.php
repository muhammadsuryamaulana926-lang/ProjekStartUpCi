<?php

namespace App\Controllers;

use App\Models\M_Startup;
use App\Models\M_Klaster;
use App\Models\M_Dosen_Pembina;
use App\Models\M_Program;
use App\Models\M_Tim_Startup;
use App\Models\M_Startup_Klaster;

class Startup extends BaseController
{
    public function index()
    {
        return view('StartUp/v_dashboard');
    }

    public function data_startup()
    {
        $data['startups'] = (new M_Startup())->semuaStartup();
        return view('StartUp/v_data_startup', $data);
    }

    public function tambah_startup()
    {
        $data['klasters'] = (new M_Klaster())->semuaKlaster();
        $data['dosens']   = (new M_Dosen_Pembina())->semuaDosen();
        $data['programs'] = (new M_Program())->semuaProgram();
        return view('StartUp/v_tambah_startup', $data);
    }

    public function save_startup()
    {
        $model = new M_Startup();

        $data = [
            'id_dosen_pembina'       => $this->request->getPost('id_dosen_pembina') ?: null,
            'id_program'             => $this->request->getPost('id_program') ?: null,
            'nama_perusahaan'        => $this->request->getPost('nama_perusahaan'),
            'deskripsi_bidang_usaha' => $this->request->getPost('deskripsi_bidang_usaha'),
            'tahun_berdiri'          => $this->request->getPost('tahun_berdiri') ?: null,
            'tahun_daftar'           => $this->request->getPost('tahun_daftar'),
            'target_pemasaran'       => $this->request->getPost('target_pemasaran'),
            'fokus_pelanggan'        => $this->request->getPost('fokus_pelanggan'),
            'alamat'                 => $this->request->getPost('alamat'),
            'nomor_whatsapp'         => $this->request->getPost('nomor_whatsapp'),
            'email_perusahaan'       => $this->request->getPost('email_perusahaan'),
            'website_perusahaan'     => $this->request->getPost('website_perusahaan'),
            'linkedin_perusahaan'    => $this->request->getPost('linkedin_perusahaan'),
            'instagram_perusahaan'   => $this->request->getPost('instagram_perusahaan'),
            'status_startup'         => $this->request->getPost('status_startup'),
            'status_ajuan'           => 'Pending',
        ];

        $file = $this->request->getFile('logo_perusahaan');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/logos', $newName);
            $data['logo_perusahaan'] = $newName;
        }

        $model->save($data);
        $id_startup = $model->getInsertID();

        $klasters = $this->request->getPost('kluster');
        if ($klasters) {
            (new M_Startup_Klaster())->simpanKlaster($id_startup, $klasters);
        }

        return redirect()->to(base_url('data-startup'))->with('success', 'Data Startup Berhasil Ditambahkan!');
    }

    public function updateTim()
    {
        $model  = new M_Tim_Startup();
        $id_tim = $this->request->getPost('id_tim');

        $model->update($id_tim, [
            'nama_lengkap'          => $this->request->getPost('nama_lengkap'),
            'jabatan'               => $this->request->getPost('jabatan'),
            'jenis_kelamin'         => $this->request->getPost('jenis_kelamin'),
            'no_whatsapp'           => $this->request->getPost('no_whatsapp'),
            'email'                 => $this->request->getPost('email'),
            'linkedin'              => $this->request->getPost('linkedin'),
            'instagram'             => $this->request->getPost('instagram'),
            'nama_perguruan_tinggi' => $this->request->getPost('nama_perguruan_tinggi'),
        ]);

        $tim     = $model->timById($id_tim);
        $startup = (new M_Startup())->find($tim['id_startup']);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Data Anggota Berhasil Diperbarui!']);
        }

        return redirect()->to(base_url('detail/' . $startup['uuid_startup']))->with('success', 'Data Anggota Berhasil Diperbarui!');
    }

    public function tambahTim()
    {
        $model = new M_Tim_Startup();
        $model->save([
            'id_startup'            => $this->request->getPost('id_startup'),
            'nama_lengkap'          => $this->request->getPost('nama_lengkap'),
            'jabatan'               => $this->request->getPost('jabatan'),
            'jenis_kelamin'         => $this->request->getPost('jenis_kelamin'),
            'no_whatsapp'           => $this->request->getPost('no_whatsapp'),
            'email'                 => $this->request->getPost('email'),
            'linkedin'              => $this->request->getPost('linkedin'),
            'instagram'             => $this->request->getPost('instagram'),
            'nama_perguruan_tinggi' => $this->request->getPost('nama_perguruan_tinggi'),
        ]);

        $startup = (new M_Startup())->find($this->request->getPost('id_startup'));

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Anggota Tim Berhasil Ditambahkan!']);
        }

        return redirect()->to(base_url('detail/' . $startup['uuid_startup']))->with('success', 'Anggota Tim Berhasil Ditambahkan!');
    }

    public function delete_startup($uuid)
    {
        (new M_Startup())->hapusStartup($uuid);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Satu berkas data telah berhasil dihapus!']);
        }

        return redirect()->to(base_url('data-startup'))->with('success', 'Satu berkas data telah berhasil dihapus!');
    }

    public function edit_startup($uuid = null)
    {
        $model      = new M_Startup();
        $id_startup = $this->request->getPost('id_startup') ?: null;

        $data['klasters'] = (new M_Klaster())->semuaKlaster();
        $data['dosens']   = (new M_Dosen_Pembina())->semuaDosen();
        $data['programs'] = (new M_Program())->semuaProgram();

        $startup = $id_startup ? $model->find($id_startup) : $model->where('uuid_startup', $uuid)->first();

        if (!$startup) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $startup['selected_klasters'] = (new M_Startup_Klaster())->idKlasterByStartup($startup['id_startup']);
        $data['startup'] = $startup;

        return view('StartUp/v_edit_startup', $data);
    }

    public function update_startup()
    {
        $model      = new M_Startup();
        $id_startup = $this->request->getPost('id_startup');

        $data = [
            'id_dosen_pembina'       => $this->request->getPost('id_dosen_pembina') ?: null,
            'id_program'             => $this->request->getPost('id_program') ?: null,
            'nama_perusahaan'        => $this->request->getPost('nama_perusahaan'),
            'deskripsi_bidang_usaha' => $this->request->getPost('deskripsi_bidang_usaha'),
            'tahun_berdiri'          => $this->request->getPost('tahun_berdiri') ?: null,
            'tahun_daftar'           => $this->request->getPost('tahun_daftar'),
            'target_pemasaran'       => $this->request->getPost('target_pemasaran'),
            'fokus_pelanggan'        => $this->request->getPost('fokus_pelanggan'),
            'alamat'                 => $this->request->getPost('alamat'),
            'nomor_whatsapp'         => $this->request->getPost('nomor_whatsapp'),
            'email_perusahaan'       => $this->request->getPost('email_perusahaan'),
            'website_perusahaan'     => $this->request->getPost('website_perusahaan'),
            'linkedin_perusahaan'    => $this->request->getPost('linkedin_perusahaan'),
            'instagram_perusahaan'   => $this->request->getPost('instagram_perusahaan'),
            'status_startup'         => $this->request->getPost('status_startup'),
        ];

        $file = $this->request->getFile('logo_perusahaan');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/logos', $newName);
            $data['logo_perusahaan'] = $newName;
        }

        $model->update($id_startup, $data);

        $klasterModel = new M_Startup_Klaster();
        $klasterModel->hapusKlasterByStartup($id_startup);

        $klasters = $this->request->getPost('kluster');
        if ($klasters) {
            $klasterModel->simpanKlaster($id_startup, $klasters);
        }

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Data Startup Berhasil Diperbaharui!']);
        }

        return redirect()->to(base_url('data-startup'))->with('success', 'Data Startup Berhasil Diperbaharui!');
    }

    public function detail($uuid)
    {
        $startup = (new M_Startup())->startupByUuid($uuid);

        if (!$startup) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $id                           = $startup['id_startup'];
        $klasterModel                 = new M_Startup_Klaster();
        $startup['klasters']          = array_column($klasterModel->klasterByStartup($id), 'nama_klaster');
        $startup['selected_klasters'] = $klasterModel->idKlasterByStartup($id);

        $data['dosens']   = (new M_Dosen_Pembina())->semuaDosen();
        $data['programs'] = (new M_Program())->semuaProgram();
        $data['klasters'] = (new M_Klaster())->semuaKlaster();
        $data['tim']      = (new M_Tim_Startup())->timByStartup($id);
        $data['startup']  = $startup;

        return view('StartUp/v_detail_startup', $data);
    }

    public function delete_tim($id_tim)
    {
        $timModel = new M_Tim_Startup();
        $tim      = $timModel->timById($id_tim);

        if ($tim) {
            $startup = (new M_Startup())->find($tim['id_startup']);
            $timModel->hapusTim($id_tim);

            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Data anggota tim berhasil dihapus!']);
            }

            return redirect()->to(base_url('detail/' . $startup['uuid_startup']))->with('success', 'Data anggota tim berhasil dihapus!');
        }

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak ditemukan!']);
        }

        return redirect()->back()->with('error', 'Data tidak ditemukan!');
    }
}
