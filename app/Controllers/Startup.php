<?php

namespace App\Controllers;

use App\Models\M_Startup;
use App\Models\M_Klaster;
use App\Models\M_Dosen_Pembina;
use App\Models\M_Program;

class Startup extends BaseController
{
    public function index()
    {
        return view('StartUp/v_dashboard');
    }

    public function data_startup()
    {
        $model = new M_Startup();
        $data['startups'] = $model->findAll();
        return view('StartUp/v_data_startup', $data);
    }

    public function tambah_startup()
    {
        $data['klasters'] = (new M_Klaster())->findAll();
        $data['dosens']   = (new M_Dosen_Pembina())->findAll();
        $data['programs'] = (new M_Program())->findAll();
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

        // Simpan relasi kluster ke tabel startup_klaster
        $klasters = $this->request->getPost('kluster');
        if ($klasters) {
            $db = \Config\Database::connect();
            foreach ($klasters as $id_klaster) {
                $db->table('startup_klaster')->insert([
                    'id_startup' => $id_startup,
                    'id_klaster' => $id_klaster,
                ]);
            }
        }

        return redirect()->to(base_url('data-startup'))->with('success', 'Data Startup Berhasil Ditambahkan!');
    }

    public function updateTim()
    {
        $model  = new \App\Models\TimStartups_Model();
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

        $tim     = $model->find($id_tim);
        $startup = (new M_Startup())->find($tim['id_startup']);
        
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Data Anggota Berhasil Diperbarui!'
            ]);
        }

        return redirect()->to(base_url('detail/' . $startup['uuid_startup']))->with('success', 'Data Anggota Berhasil Diperbarui!');
    }

    public function tambahTim()
    {
        $model = new \App\Models\TimStartups_Model();
        $model->save([
            'id_startup'           => $this->request->getPost('id_startup'),
            'nama_lengkap'         => $this->request->getPost('nama_lengkap'),
            'jabatan'              => $this->request->getPost('jabatan'),
            'jenis_kelamin'        => $this->request->getPost('jenis_kelamin'),
            'no_whatsapp'          => $this->request->getPost('no_whatsapp'),
            'email'                => $this->request->getPost('email'),
            'linkedin'             => $this->request->getPost('linkedin'),
            'instagram'            => $this->request->getPost('instagram'),
            'nama_perguruan_tinggi' => $this->request->getPost('nama_perguruan_tinggi'),
        ]);

        $startup = (new M_Startup())->find($this->request->getPost('id_startup'));
        
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Anggota Tim Berhasil Ditambahkan!'
            ]);
        }

        return redirect()->to(base_url('detail/' . $startup['uuid_startup']))->with('success', 'Anggota Tim Berhasil Ditambahkan!');
    }

    public function delete_startup($uuid)
    {
        $model = new M_Startup();
        $model->where('uuid_startup', $uuid)->delete();
        
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Satu berkas data telah berhasil dihapus!'
            ]);
        }
        
        return redirect()->to(base_url('data-startup'))->with('success', 'Satu berkas data telah berhasil dihapus!');
    }

    public function edit_startup($uuid = null)
    {
        $model = new M_Startup();
        $id_startup = $this->request->getPost('id_startup') ?: null;

        $data['klasters'] = (new \App\Models\Klasters_Model())->findAll();
        $data['dosens']   = (new \App\Models\DosenPembinas_Model())->findAll();
        $data['programs'] = (new \App\Models\Programs_Model())->findAll();
        
        if ($id_startup) {
            $startup = $model->find($id_startup);
        } else {
            $startup = $model->where('uuid_startup', $uuid)->first();
        }

        if (!$startup) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Ambil ID klaster yang sudah terpilih sebelumnya
        $db = \Config\Database::connect();
        $selected_klasters = $db->table('startup_klaster')
            ->select('id_klaster')
            ->where('id_startup', $startup['id_startup'])
            ->get()->getResultArray();
        
        $startup['selected_klasters'] = array_column($selected_klasters, 'id_klaster');
        $data['startup'] = $startup;

        return view('StartUp/v_edit_startup', $data);
    }

    public function update_startup()
    {
        $model = new M_Startup();
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

        // Handle Logo Update
        $file = $this->request->getFile('logo_perusahaan');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/logos', $newName);
            $data['logo_perusahaan'] = $newName;
        }

        $model->update($id_startup, $data);

        // Update relasi kluster
        $klasters = $this->request->getPost('kluster');
        $db = \Config\Database::connect();
        $db->table('startup_klaster')->where('id_startup', $id_startup)->delete();

        if ($klasters) {
            foreach ($klasters as $id_klaster) {
                $db->table('startup_klaster')->insert([
                    'id_startup' => $id_startup,
                    'id_klaster' => $id_klaster,
                ]);
            }
        }

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Data Startup Berhasil Diperbaharui!'
            ]);
        }

        return redirect()->to(base_url('data-startup'))->with('success', 'Data Startup Berhasil Diperbaharui!');
    }

    public function detail($uuid)
    {
        $model = new M_Startup();
        $timModel = new \App\Models\TimStartups_Model();
        
        // Ambil data startup berdasarkan UUID dengan join
        $startup = $model->select('startups.*, dosen_pembinas.nama_lengkap as nama_dosen, programs.nama_program')
            ->join('dosen_pembinas', 'dosen_pembinas.id_dosen_pembina = startups.id_dosen_pembina', 'left')
            ->join('programs', 'programs.id_program = startups.id_program', 'left')
            ->where('uuid_startup', $uuid)
            ->first();

        if (!$startup) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $id = $startup['id_startup'];

        // Ambil data klaster (many-to-many)
        $db = \Config\Database::connect();
        $klasters = $db->table('startup_klaster')
            ->select('klasters.nama_klaster')
            ->join('klasters', 'klasters.id_klaster = startup_klaster.id_klaster')
            ->where('id_startup', $id)
            ->get()->getResultArray();

        $startup['klasters'] = array_column($klasters, 'nama_klaster');
        $startup['selected_klasters'] = array_column(
            $db->table('startup_klaster')->select('id_klaster')->where('id_startup', $id)->get()->getResultArray(),
            'id_klaster'
        );

        $data['dosens']   = (new M_Dosen_Pembina())->findAll();
        $data['programs'] = (new M_Program())->findAll();
        $data['klasters'] = (new M_Klaster())->findAll();
        $data['tim']      = $timModel->where('id_startup', $id)->findAll();
        $data['startup']  = $startup;

        return view('StartUp/v_detail_startup', $data);
    }
    public function delete_tim($id_tim)
    {
        $model = new \App\Models\TimStartups_Model();
        $tim = $model->find($id_tim);
        
        if ($tim) {
            $id_startup = $tim['id_startup'];
            $startup = (new M_Startup())->find($id_startup);
            $model->delete($id_tim);
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status'  => 'success',
                    'message' => 'Data anggota tim berhasil dihapus!'
                ]);
            }
            
            return redirect()->to(base_url('detail/' . $startup['uuid_startup']))->with('success', 'Data anggota tim berhasil dihapus!');
        }
        
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Data tidak ditemukan!'
            ]);
        }

        return redirect()->back()->with('error', 'Data tidak ditemukan!');
    }
}
