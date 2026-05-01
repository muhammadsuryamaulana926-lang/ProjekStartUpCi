<?php

namespace App\Controllers;

use App\Models\M_startup;
use App\Models\M_klaster;
use App\Models\M_startup_klaster;
use App\Models\M_dosen_pembina;
use App\Models\M_program;
use App\Models\M_startup_tim;
use App\Models\M_notifikasi;
use App\Models\M_log_aktivitas;
use App\Models\M_login_history;

class Startup extends BaseController
{
    protected $m_startup;
    protected $m_klaster;
    protected $m_startup_klaster;
    protected $m_dosen_pembina;
    protected $m_program;
    protected $m_tim_startup;

    public function __construct()
    {
        $this->m_startup          = new M_startup();
        $this->m_klaster          = new M_klaster();
        $this->m_startup_klaster  = new M_startup_klaster();
        $this->m_dosen_pembina    = new M_dosen_pembina();
        $this->m_program          = new M_program();
        $this->m_tim_startup      = new M_startup_tim();
    }

    // ── Private Helpers ───────────────────────────────────────────
    private function data_form(): array
    {
        return [
            'klasters' => $this->m_klaster->semua_klaster()->getResult(),
            'dosens'   => $this->m_dosen_pembina->semua_dosen()->getResult(),
            'programs' => $this->m_program->semua_program()->getResult(),
        ];
    }

    private function proses_logo(): array
    {
        $result = ['nama' => null, 'error' => false, 'msg' => ''];

        if ($_FILES['logo_perusahaan']['name'] == '') {
            return $result;
        }

        if (!file_exists(FCPATH . 'uploads/file_startup/logo_startup/')) {
            mkdir(FCPATH . 'uploads/file_startup/logo_startup/', 0777, true);
        }

        $name      = $_FILES['logo_perusahaan']['name'];
        $extension = strtolower(substr($name, (strrpos($name, '.') + 1)));

        if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
            $result['error'] = true;
            $result['msg']   = 'Format logo perusahaan tidak sesuai';
            return $result;
        }

        $result['nama'] = uniqid(date('Y_m_d') . '_', true) . '.' . $extension;
        return $result;
    }

    // ── Public Methods ────────────────────────────────────────────
    public function index()
    {
        return view('layout/header')
            . view('layout/topbar')
            . view('startup/v_data_startup', [
                'startups' => $this->m_startup->semua_startup()->getResult(),
            ])
            . view('layout/footer');
    }

    public function tambah_startup()
    {
        return view('layout/header')
            . view('layout/topbar')
            . view('startup/v_tambah_startup', $this->data_form())
            . view('layout/footer');
    }

    public function simpan_startup()
    {
        $data['nama_perusahaan']        = $this->request->getPost('nama_perusahaan');
        $data['status_nama_perusahaan'] = false;
        $data['status_logo_perusahaan'] = false;

        $cek = $this->m_startup->get_startup_by_nama($data)->countAllResults();
        if ($cek > 0) {
            $data['status_nama_perusahaan'] = true;
            $data['msg_nama_perusahaan']    = 'Nama startup sudah tersedia';
        }

        $logo = $this->proses_logo();
        if ($logo['error']) {
            $data['status_logo_perusahaan'] = true;
            $data['msg_logo_perusahaan']    = $logo['msg'];
        }

        $data['status'] = false;
        session()->setFlashdata('msg', ['error', 'Terjadi kesalahan sistem. Silahkan coba kembali']);

        if ($data['status_nama_perusahaan'] == false && $data['status_logo_perusahaan'] == false) {
            $data_startup['nama_perusahaan']        = substr(trim($this->request->getPost('nama_perusahaan')), 0, 500);
            $data_startup['deskripsi_bidang_usaha'] = $this->request->getPost('deskripsi_bidang_usaha');
            $data_startup['tahun_berdiri']          = $this->request->getPost('tahun_berdiri') ?: null;
            $data_startup['tahun_daftar']           = $this->request->getPost('tahun_daftar');
            $data_startup['target_pemasaran']       = $this->request->getPost('target_pemasaran');
            $data_startup['fokus_pelanggan']        = $this->request->getPost('fokus_pelanggan');
            $data_startup['alamat']                 = $this->request->getPost('alamat');
            $data_startup['nomor_whatsapp']         = $this->request->getPost('nomor_whatsapp');
            $data_startup['email_perusahaan']       = $this->request->getPost('email_perusahaan');
            $data_startup['website_perusahaan']     = $this->request->getPost('website_perusahaan');
            $data_startup['linkedin_perusahaan']    = $this->request->getPost('linkedin_perusahaan');
            $data_startup['instagram_perusahaan']   = $this->request->getPost('instagram_perusahaan');
            $data_startup['status_startup']         = $this->request->getPost('status_startup');
            $data_startup['id_dosen_pembina']       = $this->request->getPost('id_dosen_pembina') ?: null;
            $data_startup['id_program']             = $this->request->getPost('id_program') ?: null;
            $data_startup['uuid_startup']           = bin2hex(random_bytes(16));
            $data_startup['status_ajuan']           = 'Pending';
            $data_startup['latitude']               = $this->request->getPost('latitude') ?: null;
            $data_startup['longitude']              = $this->request->getPost('longitude') ?: null;

            if ($logo['nama']) {
                $data_startup['logo_perusahaan'] = $logo['nama'];
            }

            $id_startup = $this->m_startup->tambah_startup($data_startup);

            if ($id_startup && $klasters = $this->request->getPost('id_klaster')) {
                foreach ($klasters as $id_klaster) {
                    $this->m_startup_klaster->simpan_klaster($id_startup, $id_klaster);
                }
            }

            $data['status'] = false;
            session()->setFlashdata('msg', ['error', 'Terjadi kesalahan sistem. Silahkan coba kembali']);
            if ($id_startup) {
                if ($logo['nama']) {
                    move_uploaded_file(
                        $_FILES['logo_perusahaan']['tmp_name'],
                        FCPATH . 'uploads/file_startup/logo_startup/' . $logo['nama']
                    );
                }
                $data['status'] = true;
                session()->setFlashdata('msg', ['success', 'Startup berhasil ditambah']);
            }
        }

        echo json_encode([
            'status'                 => $data['status'],
            'status_nama_perusahaan' => $data['status_nama_perusahaan'],
            'msg_nama_perusahaan'    => $data['msg_nama_perusahaan'] ?? '',
            'status_logo_perusahaan' => $data['status_logo_perusahaan'],
            'msg_logo_perusahaan'    => $data['msg_logo_perusahaan'] ?? '',
        ]);
    }

    public function edit_startup($uuid = null)
    {
        if (isset($_POST['id_startup'])) {
            $data_cari['id_startup'] = $this->request->getPost('id_startup');
        } else {
            $data_cari['uuid_startup'] = $uuid;
        }

        $startup = isset($data_cari['id_startup'])
            ? $this->m_startup->startup_by_id($data_cari)->getResult('array')
            : $this->m_startup->startup_by_uuid($data_cari)->getResult('array');

        if (!$startup) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $startup[0]['no_whatsapp'] = $startup[0]['nomor_whatsapp'];
        $startup[0]['id_program_kewirausahaan_startup'] = $startup[0]['id_program'];

        $selected_klasters = array_column(
            $this->m_startup_klaster->klaster_by_startup($startup[0]['id_startup']),
            'id_klaster'
        );

        $daftar_anggota = array_map(function($row) {
            $row->id_anggota = $row->id_dosen_pembina;
            return $row;
        }, $this->m_dosen_pembina->semua_dosen()->getResult());

        $daftar_program = array_map(function($row) {
            $row->id_program_kewirausahaan_startup = $row->id_program;
            return $row;
        }, $this->m_program->semua_program()->getResult());

        return view('layout/header')
            . view('layout/topbar')
            . view('startup/v_edit_startup', [
                'data'                   => $startup,
                'daftar_klaster'         => $this->m_klaster->semua_klaster()->getResult(),
                'selected_klasters'      => $selected_klasters,
                'daftar_anggota'         => $daftar_anggota,
                'daftar_program_startup' => $daftar_program,
            ])
            . view('layout/footer');
    }

    public function proses_ubah_startup()
    {
        $data['id_startup']             = $this->request->getPost('id_startup');
        $data['nama_perusahaan']        = $this->request->getPost('nama_perusahaan');
        $data['status_nama_perusahaan'] = false;
        $data['status_logo_perusahaan'] = false;

        $startup_lama = $this->m_startup->startup_by_id($data)->getResult();
        $nama_lama    = '';
        $logo_lama    = '';
        foreach ($startup_lama as $row) {
            $nama_lama = $row->nama_perusahaan;
            $logo_lama = $row->logo_perusahaan;
        }

        if (strtolower($data['nama_perusahaan']) != strtolower($nama_lama)) {
            $cek = $this->m_startup->get_startup_by_nama($data)->countAllResults();
            if ($cek > 0) {
                $data['status_nama_perusahaan'] = true;
                $data['msg_nama_perusahaan']    = 'Nama startup sudah tersedia';
            }
        }

        $logo     = $this->proses_logo();
        $logo_dir = FCPATH . 'uploads/file_startup/logo_startup/';
        if ($logo['error']) {
            $data['status_logo_perusahaan'] = true;
            $data['msg_logo_perusahaan']    = $logo['msg'];
        }

        $data['status'] = false;
        session()->setFlashdata('msg', ['error', 'Terjadi kesalahan sistem. Silahkan coba kembali']);

        if ($data['status_nama_perusahaan'] == false && $data['status_logo_perusahaan'] == false) {
            $data_startup['id_startup']             = $this->request->getPost('id_startup');
            $data_startup['nama_perusahaan']        = substr(trim($this->request->getPost('nama_perusahaan')), 0, 500);
            $data_startup['deskripsi_bidang_usaha'] = $this->request->getPost('deskripsi_bidang_usaha');
            $data_startup['tahun_berdiri']          = $this->request->getPost('tahun_berdiri') ?: null;
            $data_startup['tahun_daftar']           = $this->request->getPost('tahun_daftar');
            $data_startup['target_pemasaran']       = $this->request->getPost('target_pemasaran');
            $data_startup['fokus_pelanggan']        = $this->request->getPost('fokus_pelanggan');
            $data_startup['alamat']                 = $this->request->getPost('alamat');
            $data_startup['nomor_whatsapp']         = $this->request->getPost('no_whatsapp');
            $data_startup['email_perusahaan']       = $this->request->getPost('email_perusahaan');
            $data_startup['website_perusahaan']     = $this->request->getPost('website_perusahaan');
            $data_startup['linkedin_perusahaan']    = $this->request->getPost('linkedin_perusahaan');
            $data_startup['instagram_perusahaan']   = $this->request->getPost('instagram_perusahaan');
            $data_startup['status_startup']         = $this->request->getPost('status_startup');
            $data_startup['id_dosen_pembina']       = $this->request->getPost('id_dosen_pembina') ?: null;
            $data_startup['id_program']             = $this->request->getPost('id_program_kewirausahaan_startup') ?: null;
            $data_startup['latitude']               = $this->request->getPost('latitude') ?: null;
            $data_startup['longitude']              = $this->request->getPost('longitude') ?: null;

            if ($logo['nama']) {
                $data_startup['logo_perusahaan'] = $logo['nama'];
            }

            $this->m_startup->ubah_startup($data_startup);

            $this->m_startup_klaster->hapus_by_startup($data_startup['id_startup']);
            if ($klasters = $this->request->getPost('id_klaster')) {
                foreach ($klasters as $id_klaster) {
                    $this->m_startup_klaster->simpan_klaster($data_startup['id_startup'], $id_klaster);
                }
            }

            if ($logo['nama']) {
                if (move_uploaded_file($_FILES['logo_perusahaan']['tmp_name'], $logo_dir . $logo['nama'])) {
                    if ($logo_lama && file_exists($logo_dir . $logo_lama)) {
                        unlink($logo_dir . $logo_lama);
                    }
                }
            }

            $data['status'] = true;
            session()->setFlashdata('msg', ['success', 'Perubahan startup berhasil disimpan']);
        }

        return $this->response->setJSON([
            'status'                 => $data['status'],
            'status_nama_perusahaan' => $data['status_nama_perusahaan'],
            'msg_nama_perusahaan'    => $data['msg_nama_perusahaan'] ?? '',
            'status_logo_perusahaan' => $data['status_logo_perusahaan'],
            'msg_logo_perusahaan'    => $data['msg_logo_perusahaan'] ?? '',
        ]);
    }

    public function detail($uuid)
    {
        $data_cari['uuid_startup'] = $uuid;
        $startup = $this->m_startup->startup_by_uuid($data_cari)->getResult('array');

        if (!$startup) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Startup dengan UUID ' . $uuid . ' tidak ditemukan');
        }

        $id_startup            = $startup[0]['id_startup'];
        $data_id['id_startup'] = $id_startup;
        $klasters_startup      = $this->m_startup_klaster->klaster_by_startup($id_startup);
        $selected_klasters     = array_column($klasters_startup, 'id_klaster');
        $startup[0]['nama_klaster'] = implode(', ', array_column($klasters_startup, 'nama_klaster'));

        return view('layout/header')
            . view('layout/topbar')
            . view('startup/v_detail_startup', array_merge($this->data_form(), [
                'data'              => $startup,
                'data_tim'          => $this->m_tim_startup->tim_by_startup($data_id)->getResult(),
                'id_startup'        => $id_startup,
            ]))
            . view('layout/footer');
    }

    public function detail_lokasi_startup()
    {
        return view('layout/header')
            . view('layout/topbar')
            . view('startup/v_lokasi_startup', [
                'startups' => $this->m_startup->semua_startup()->getResult(),
            ])
            . view('layout/footer');
    }

    public function lokasi_startup_saya()
    {
        $id_user = session()->get('user_id');
        $startup = $this->m_startup->startup_by_id_user($id_user);
        $startups = $startup ? $this->m_startup->startup_by_uuid(['uuid_startup' => $startup->uuid_startup])->getResult() : [];

        return view('layout/header')
            . view('layout/topbar')
            . view('startup/v_lokasi_startup', [
                'startups' => $startups,
            ])
            . view('layout/footer');
    }

    public function hapus_startup()
    {
        $data['id_startup'] = $this->request->getPost('id_startup');
        $logo_dir           = FCPATH . 'uploads/file_startup/logo_startup/';

        $startup = $this->m_startup->startup_by_id($data)->getResult();
        foreach ($startup as $row) {
            if (file_exists($logo_dir . $row->logo_perusahaan) && $row->logo_perusahaan != '') {
                unlink($logo_dir . $row->logo_perusahaan);
            }
        }

        $result         = $this->m_startup->hapus_startup($data);
        $data['status'] = $result ? true : false;
        echo json_encode($data);
    }

    // ── Tim Startup ───────────────────────────────────────────────
    public function get_startup_tim()
    {
        $data['id_tim'] = $this->request->getPost('id_startup_tim');
        $tim = $this->m_tim_startup->tim_by_id($data)->getResult('array');
        echo json_encode($tim);
    }

    public function proses_tambah_informasi_tim()
    {
        $data_tim['id_startup']            = $this->request->getPost('id_startup');
        $data_tim['nama_lengkap']          = substr(trim($this->request->getPost('nama_lengkap')), 0, 500);
        $data_tim['jabatan']               = $this->request->getPost('jabatan_tim');
        $data_tim['jenis_kelamin']         = $this->request->getPost('jenis_kelamin');
        $data_tim['no_whatsapp']           = $this->request->getPost('no_whatsapp');
        $data_tim['email']                 = $this->request->getPost('email');
        $data_tim['linkedin']              = $this->request->getPost('linkedin');
        $data_tim['instagram']             = $this->request->getPost('instagram');
        $data_tim['nama_perguruan_tinggi'] = $this->request->getPost('nama_perguruan_tinggi');
        $data_tim['uuid_tim']              = bin2hex(random_bytes(16));
        $result = $this->m_tim_startup->tambah_tim($data_tim);
        echo json_encode(['status' => $result ? true : false]);
    }

    public function proses_ubah_informasi_tim()
    {
        $data_tim['id_tim']                = $this->request->getPost('id_startup_tim');
        $data_tim['id_startup']            = $this->request->getPost('id_startup');
        $data_tim['nama_lengkap']          = substr(trim($this->request->getPost('nama_lengkap')), 0, 500);
        $data_tim['jabatan']               = $this->request->getPost('jabatan_tim');
        $data_tim['jenis_kelamin']         = $this->request->getPost('jenis_kelamin');
        $data_tim['no_whatsapp']           = $this->request->getPost('no_whatsapp');
        $data_tim['email']                 = $this->request->getPost('email');
        $data_tim['linkedin']              = $this->request->getPost('linkedin');
        $data_tim['instagram']             = $this->request->getPost('instagram');
        $data_tim['nama_perguruan_tinggi'] = $this->request->getPost('nama_perguruan_tinggi');
        $result = $this->m_tim_startup->ubah_tim($data_tim);
        echo json_encode(['status' => $result ? true : false]);
    }

    public function proses_hapus_informasi_tim()
    {
        $data['id_tim'] = $this->request->getPost('id_startup_tim');
        $result = $this->m_tim_startup->hapus_tim($data);
        echo json_encode(['status' => $result ? true : false]);
    }

    // ── Verifikasi ────────────────────────────────────────────────
    public function proses_verifikasi_startup()
    {
        $data_startup['id_startup']   = $this->request->getPost('id_startup');
        $data_startup['status_ajuan'] = 'Verified';
        $this->m_startup->ubah_startup($data_startup);
        echo json_encode(['status' => true]);
    }

    public function proses_tolak_startup()
    {
        $data_startup['id_startup']   = $this->request->getPost('id_startup');
        $data_startup['status_ajuan'] = 'Rejected';
        $this->m_startup->ubah_startup($data_startup);
        echo json_encode(['status' => true]);
    }

    // ── Notifikasi ────────────────────────────────────────────────
    public function notif_tandai_dibaca()
    {
        $id = $this->request->getPost('id_notifikasi');
        (new M_notifikasi())->tandai_dibaca($id);
        echo json_encode(['status' => true]);
    }

    public function notif_tandai_semua()
    {
        $role = session()->get('user_role');
        (new M_notifikasi())->tandai_semua_dibaca($role);
        echo json_encode(['status' => true]);
    }

    // ── Globe ─────────────────────────────────────────────────────
    public function globe()
    {
        $role    = session()->get('user_role');
        $id_user = session()->get('user_id');

        if ($role === 'pemilik_startup') {
            $startup  = $this->m_startup->startup_by_id_user($id_user);
            $startups = $startup ? [$startup] : [];
        } else {
            $startups = $this->m_startup->semua_startup()->getResult();
        }

        return view('layout/header', ['title' => 'Globe Interaktif'])
            . view('layout/topbar')
            . view('startup/v_globe', ['startups' => $startups])
            . view('layout/footer');
    }

    // ── Log & History ─────────────────────────────────────────────
    public function log_aktivitas()
    {
        $logs = (new M_log_aktivitas())->semua_log(200);
        return view('layout/header', ['title' => 'Log Aktivitas'])
            . view('layout/topbar')
            . view('pengaturan/v_log_aktivitas', ['logs' => $logs])
            . view('layout/footer');
    }

    public function aktivitas_login()
    {
        return view('layout/header', ['title' => 'Aktivitas Login'])
            . view('layout/topbar')
            . view('pengaturan/v_aktivitas_login', [
                'history' => (new M_login_history())->semua_history(),
                'users'   => (new \App\Models\M_user())->findAll(),
            ])
            . view('layout/footer');
    }
}
