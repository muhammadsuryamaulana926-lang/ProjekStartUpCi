<?php

namespace App\Controllers;

use App\Models\M_startup;
use App\Models\M_klaster;
use App\Models\M_dosen_pembina;
use App\Models\M_program;
use App\Models\M_tim_startup;
use App\Models\M_startup_klaster;
use App\Models\M_startup_produk;
use App\Models\M_startup_pendanaan_itb;
use App\Models\M_startup_pendanaan_non_itb;
use App\Models\M_startup_prestasi;
use App\Models\M_startup_histori_status;
use App\Models\M_startup_mentor;
use App\Models\M_mentor;

class Startup extends BaseController
{
    protected $m_startup;
    protected $m_klaster;
    protected $m_dosen_pembina;
    protected $m_program;
    protected $m_tim_startup;
    protected $m_startup_klaster;
    protected $m_startup_produk;
    protected $m_startup_pendanaan_itb;
    protected $m_startup_pendanaan_non_itb;
    protected $m_startup_prestasi;
    protected $m_startup_histori_status;
    protected $m_startup_mentor;
    protected $m_mentor;
    protected $session = null;

    public function __construct()
    {
        $this->m_startup                  = new M_startup();
        $this->m_klaster                  = new M_klaster();
        $this->m_dosen_pembina            = new M_dosen_pembina();
        $this->m_program                  = new M_program();
        $this->m_tim_startup              = new M_tim_startup();
        $this->m_startup_klaster          = new M_startup_klaster();
        $this->m_startup_produk           = new M_startup_produk();
        $this->m_startup_pendanaan_itb    = new M_startup_pendanaan_itb();
        $this->m_startup_pendanaan_non_itb = new M_startup_pendanaan_non_itb();
        $this->m_startup_prestasi         = new M_startup_prestasi();
        $this->m_startup_histori_status   = new M_startup_histori_status();
        $this->m_startup_mentor           = new M_startup_mentor();
        $this->m_mentor                   = new M_mentor();
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
        $this->session = \Config\Services::session();
        return view('Partials/v_header')
            . view('Partials/v_sidebar')
            . view('Partials/v_topbar')
            . view('Startup/v_data_startup', [
                'startups' => $this->m_startup->semua_startup()->getResult(),
            ])
            . view('Partials/v_footer');
    }

    public function tambah_startup()
    {
        $this->session = \Config\Services::session();
        return view('Partials/v_header')
            . view('Partials/v_sidebar')
            . view('Partials/v_topbar')
            . view('Startup/v_tambah_startup', $this->data_form())
            . view('Partials/v_footer');
    }

    public function simpan_startup()
    {
        $this->session = \Config\Services::session();
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
        $this->session->setFlashdata('msg', ['error', 'Terjadi kesalahan sistem. Silahkan coba kembali']);

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

            if ($klasters = $this->request->getPost('kluster')) {
                foreach ($klasters as $id_klaster) {
                    $this->m_startup_klaster->simpan_klaster([
                        'id_startup' => $id_startup,
                        'id_klaster' => $id_klaster,
                    ]);
                }
            }

            $data['status'] = false;
            $this->session->setFlashdata('msg', ['error', 'Terjadi kesalahan sistem. Silahkan coba kembali']);
            if ($id_startup) {
                if ($logo['nama']) {
                    move_uploaded_file(
                        $_FILES['logo_perusahaan']['tmp_name'],
                        FCPATH . 'uploads/file_startup/logo_startup/' . $logo['nama']
                    );
                }
                $data['status'] = true;
                $this->session->setFlashdata('msg', ['success', 'Startup berhasil ditambah']);
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
        $this->session = \Config\Services::session();
        if (isset($_POST['id_startup'])) {
            $data_cari['id_startup'] = $this->request->getPost('id_startup');
        } else {
            $data_cari['uuid_startup'] = $uuid;
        }

        $startup = isset($data_cari['id_startup'])
            ? $this->m_startup->startup_by_id($data_cari)->getResult('array')
            : $this->m_startup->startup_by_uuid($data_cari)->getResult('array');

        if (!$startup) {
            return redirect()->to('/startup');
        }

        $id_s = $startup[0]['id_startup'];
        
        // Format klaster as comma string for user's snippet logic
        $klasters_assigned = $this->m_startup_klaster->klaster_by_startup(['id_startup' => $id_s])->getResult('array');
        $startup[0]['klaster'] = implode(',', array_column($klasters_assigned, 'nama_klaster'));
        
        // Alias keys for view compatibility
        $startup[0]['no_whatsapp'] = $startup[0]['nomor_whatsapp'];
        $startup[0]['id_program_kewirausahaan_startup'] = $startup[0]['id_program'];

        // Prepare lists with aliased IDs
        $daftar_anggota = array_map(function($row) {
            $row->id_anggota = $row->id_dosen_pembina;
            return $row;
        }, $this->m_dosen_pembina->semua_dosen()->getResult());

        $daftar_program = array_map(function($row) {
            $row->id_program_kewirausahaan_startup = $row->id_program;
            return $row;
        }, $this->m_program->semua_program()->getResult());

        return view('Partials/v_header')
            . view('Partials/v_sidebar')
            . view('Partials/v_topbar')
            . view('Startup/v_edit_startup', [
                'data'                    => $startup,
                'daftar_klaster'          => $this->m_klaster->semua_klaster()->getResult(),
                'daftar_anggota'          => $daftar_anggota,
                'daftar_program_startup'  => $daftar_program,
            ])
            . view('Partials/v_footer');
    }

    public function proses_ubah_startup()
    {
        $this->session = \Config\Services::session();
        $data['id_startup']             = $this->request->getPost('id_startup');
        $data['nama_perusahaan']        = $this->request->getPost('nama_perusahaan');
        $data['status_nama_perusahaan'] = false;
        $data['status_logo_perusahaan'] = false;

        $startup_lama    = $this->m_startup->startup_by_id($data)->getResult();
        $nama_lama       = '';
        $logo_lama       = '';
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
        $this->session->setFlashdata('msg', ['error', 'Terjadi kesalahan sistem. Silahkan coba kembali']);

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

            $result = $this->m_startup->ubah_startup($data_startup);

            $this->m_startup_klaster->hapus_klaster_by_startup(['id_startup' => $data_startup['id_startup']]);
            if ($klasters = $this->request->getPost('kluster')) {
                foreach ($klasters as $id_klaster) {
                    $this->m_startup_klaster->simpan_klaster([
                        'id_startup' => $data_startup['id_startup'],
                        'id_klaster' => $id_klaster,
                    ]);
                }
            }

            // CI4 ubah_startup() returns false jika tidak ada baris yang berubah (data sama)
            // Kita anggap berhasil selama tidak ada exception
            if ($logo['nama']) {
                move_uploaded_file(
                    $_FILES['logo_perusahaan']['tmp_name'],
                    $logo_dir . $logo['nama']
                );
                if (file_exists($logo_dir . $logo_lama) && $logo_lama != '') {
                    unlink($logo_dir . $logo_lama);
                }
            }

            $data['status'] = true;
            $this->session->setFlashdata('msg', ['success', 'Startup berhasil diubah']);
        }

        echo json_encode([
            'status'                 => $data['status'],
            'status_nama_perusahaan' => $data['status_nama_perusahaan'],
            'msg_nama_perusahaan'    => $data['msg_nama_perusahaan'] ?? '',
            'status_logo_perusahaan' => $data['status_logo_perusahaan'],
            'msg_logo_perusahaan'    => $data['msg_logo_perusahaan'] ?? '',
        ]);
    }

    public function detail($uuid)
    {
        $this->session = \Config\Services::session();
        $data_cari['uuid_startup'] = $uuid;
        $startup = $this->m_startup->startup_by_uuid($data_cari)->getResult('array');

        if (!$startup) {
            return redirect()->to(base_url('v_data_startup'));
        }

        $id_startup = $startup[0]['id_startup'];
        $data_id['id_startup'] = $id_startup;

        $klasters_result                 = $this->m_startup_klaster->klaster_by_startup($data_id)->getResult('array');
        $startup[0]['klasters']          = array_column($klasters_result, 'nama_klaster');
        $selected                        = $this->m_startup_klaster->id_klaster_by_startup($data_id)->getResult('array');
        $startup[0]['selected_klasters'] = array_column($selected, 'id_klaster');

        return view('Partials/v_header')
            . view('Partials/v_sidebar')
            . view('Partials/v_topbar')
            . view('Startup/v_detail_startup', array_merge($this->data_form(), [
                'data'                   => $startup,
                'data_tim'               => $this->m_tim_startup->tim_by_startup($data_id)->getResult(),
                'data_produk'            => $this->m_startup_produk->get_startup_produk_by_id_startup($data_id)->getResult(),
                'data_pendanaan_itb'     => $this->m_startup_pendanaan_itb->get_startup_pendanaan_itb_by_id_startup($data_id)->getResult(),
                'data_pendanaan_non_itb' => $this->m_startup_pendanaan_non_itb->get_startup_pendanaan_non_itb_by_id_startup($data_id)->getResult(),
                'data_prestasi'          => $this->m_startup_prestasi->get_startup_prestasi_by_id_startup($data_id)->getResult(),
                'data_histori'           => $this->m_startup_histori_status->get_startup_histori_status_by_id_startup($data_id)->getResult(),
                'data_mentor'            => $this->m_startup_mentor->get_startup_mentor_by_id_startup($data_id)->getResult(),
                'all_mentor'             => $this->m_mentor->get_mentor_all()->getResult(),
                'id_startup'             => $id_startup,
            ]))
            . view('Partials/v_footer');
    }

    // Menampilkan halaman peta lokasi semua startup (khusus admin)
    public function detail_lokasi_startup()
    {
        return view('Partials/v_header')
            . view('Partials/v_sidebar')
            . view('Partials/v_topbar')
            . view('Startup/v_detail_lokasi_startup', [
                'startups' => $this->m_startup->semua_startup()->getResult(),
            ])
            . view('Partials/v_footer');
    }

    // Menampilkan halaman peta lokasi khusus startup milik pemilik yang sedang login
    public function lokasi_startup_saya()
    {
        $id_user = session()->get('user_id');
        $startup = $this->m_startup->startup_by_id_user($id_user);
        $startups = $startup ? $this->m_startup->startup_by_uuid(['uuid_startup' => $startup->uuid_startup])->getResult() : [];

        return view('Partials/v_header')
            . view('Partials/v_sidebar')
            . view('Partials/v_topbar')
            . view('Startup/v_detail_lokasi_startup', [
                'startups' => $startups,
            ])
            . view('Partials/v_footer');
    }

    // Menampilkan halaman video pembelajaran untuk startup
    public function video()
    {
        return view('Partials/v_header')
            . view('Partials/v_sidebar')
            . view('Partials/v_topbar')
            . view('Startup/v_video')
            . view('Partials/v_footer');
    }

    // Menampilkan halaman referensi buku untuk startup
    public function buku()
    {
        return view('Partials/v_header')
            . view('Partials/v_sidebar')
            . view('Partials/v_topbar')
            . view('Startup/v_buku')
            . view('Partials/v_footer');
    }

    public function hapus_startup()
    {
        $this->session = \Config\Services::session();
        $data['id_startup'] = $this->request->getPost('id_startup');
        $logo_dir           = FCPATH . 'uploads/file_startup/logo_startup/';

        $startup = $this->m_startup->startup_by_id($data)->getResult();
        foreach ($startup as $row) {
            if (file_exists($logo_dir . $row->logo_perusahaan) && $row->logo_perusahaan != '') {
                unlink($logo_dir . $row->logo_perusahaan);
            }
        }

        $this->m_startup_klaster->hapus_klaster_by_startup($data);
        $result = $this->m_startup->hapus_startup($data);

        $data['status'] = false;
        if ($result) {
            $data['status'] = true;
        }

        echo json_encode($data);
    }

    public function simpan_tim()
    {
        $this->session = \Config\Services::session();
        $data_tim['id_startup']           = $this->request->getPost('id_startup');
        $data_tim['nama_lengkap']         = substr(trim($this->request->getPost('nama_lengkap')), 0, 500);
        $data_tim['jabatan']              = $this->request->getPost('jabatan');
        $data_tim['jenis_kelamin']        = $this->request->getPost('jenis_kelamin');
        $data_tim['no_whatsapp']          = $this->request->getPost('no_whatsapp');
        $data_tim['email']                = $this->request->getPost('email');
        $data_tim['linkedin']             = $this->request->getPost('linkedin');
        $data_tim['instagram']            = $this->request->getPost('instagram');
        $data_tim['nama_perguruan_tinggi'] = $this->request->getPost('nama_perguruan_tinggi');
        $result = $this->m_tim_startup->tambah_tim($data_tim);

        $data['status'] = false;
        $this->session->setFlashdata('msg', ['error', 'Terjadi kesalahan sistem. Silahkan coba kembali']);
        if ($result) {
            $data['status'] = true;
            $this->session->setFlashdata('msg', ['success', 'Tim Startup berhasil ditambah']);
        }

        echo json_encode($data);
    }

    public function get_tim()
    {
        $data['id_tim'] = $this->request->getPost('id_tim');
        $data = $this->m_tim_startup->tim_by_id($data)->getResult('array');
        echo json_encode($data);
    }

    public function update_tim()
    {
        $this->session = \Config\Services::session();
        $data_tim['id_tim']               = $this->request->getPost('id_tim');
        $data_tim['id_startup']           = $this->request->getPost('id_startup');
        $data_tim['nama_lengkap']         = substr(trim($this->request->getPost('nama_lengkap')), 0, 500);
        $data_tim['jabatan']              = $this->request->getPost('jabatan');
        $data_tim['jenis_kelamin']        = $this->request->getPost('jenis_kelamin');
        $data_tim['no_whatsapp']          = $this->request->getPost('no_whatsapp');
        $data_tim['email']                = $this->request->getPost('email');
        $data_tim['linkedin']             = $this->request->getPost('linkedin');
        $data_tim['instagram']            = $this->request->getPost('instagram');
        $data_tim['nama_perguruan_tinggi'] = $this->request->getPost('nama_perguruan_tinggi');
        $result = $this->m_tim_startup->ubah_tim($data_tim);

        $data['status'] = false;
        $this->session->setFlashdata('msg', ['error', 'Terjadi kesalahan sistem. Silahkan coba kembali']);
        if ($result) {
            $data['status'] = true;
            $this->session->setFlashdata('msg', ['success', 'Tim Startup berhasil diubah']);
        }

        echo json_encode($data);
    }

    public function hapus_tim()
    {
        $this->session = \Config\Services::session();
        $data['id_tim'] = $this->request->getPost('id_tim');
        $result = $this->m_tim_startup->hapus_tim($data);

        $data['status'] = false;
        $this->session->setFlashdata('msg', ['error', 'Terjadi kesalahan sistem. Silahkan coba kembali']);
        if ($result) {
            $data['status'] = true;
            $this->session->setFlashdata('msg', ['success', 'Tim Startup berhasil dihapus']);
        }

        echo json_encode($data);
    }

    // ── AJAX Methods Added for Detailed View ────────────────────────

    public function proses_verifikasi_startup()
    {
        $this->session = \Config\Services::session();
        $data_startup['id_startup']   = $this->request->getPost('id_startup');
        $data_startup['status_ajuan'] = 'Verified';

        $this->m_startup->ubah_startup($data_startup);

        $data_histori['id_startup']     = $data_startup['id_startup'];
        $data_histori['id_pengguna']    = $this->request->getPost('id_pengguna');
        $data_histori['status_startup'] = 'verifikasi';
        $data_histori['tgl_buat']       = date('Y-m-d H:i:s');
        $this->m_startup_histori_status->tambah_startup_histori_status($data_histori);

        $data['status'] = true;
        echo json_encode($data);
    }

    public function proses_tolak_startup()
    {
        $this->session = \Config\Services::session();
        $data_startup['id_startup']   = $this->request->getPost('id_startup');
        $data_startup['status_ajuan'] = 'Rejected';

        $this->m_startup->ubah_startup($data_startup);

        $data_histori['id_startup']     = $data_startup['id_startup'];
        $data_histori['id_pengguna']    = $this->request->getPost('id_pengguna');
        $data_histori['status_startup'] = 'tolak';
        $data_histori['catatan']        = $this->request->getPost('catatan_tolak');
        $data_histori['tgl_buat']       = date('Y-m-d H:i:s');
        $this->m_startup_histori_status->tambah_startup_histori_status($data_histori);

        $data['status'] = true;
        echo json_encode($data);
    }

    // CRUD Tim Startup (Aliases / New)
    public function get_startup_tim()
    {
        $data['id_tim'] = $this->request->getPost('id_startup_tim');
        $tim = $this->m_tim_startup->tim_by_id($data)->getResult('array');
        echo json_encode($tim);
    }

    public function proses_tambah_informasi_tim()
    {
        $data_tim['id_startup']           = $this->request->getPost('id_startup');
        $data_tim['nama_lengkap']         = substr(trim($this->request->getPost('nama_lengkap')), 0, 500);
        $data_tim['jabatan']              = $this->request->getPost('jabatan_tim');
        $data_tim['jenis_kelamin']        = $this->request->getPost('jenis_kelamin');
        $data_tim['no_whatsapp']          = $this->request->getPost('no_whatsapp');
        $data_tim['email']                = $this->request->getPost('email');
        $data_tim['linkedin']             = $this->request->getPost('linkedin');
        $data_tim['instagram']            = $this->request->getPost('instagram');
        $data_tim['nama_perguruan_tinggi'] = $this->request->getPost('nama_perguruan_tinggi');
        $result = $this->m_tim_startup->tambah_tim($data_tim);

        $data['status'] = $result ? true : false;
        echo json_encode($data);
    }

    public function proses_ubah_informasi_tim()
    {
        $data_tim['id_tim']               = $this->request->getPost('id_startup_tim');
        $data_tim['id_startup']           = $this->request->getPost('id_startup');
        $data_tim['nama_lengkap']         = substr(trim($this->request->getPost('nama_lengkap')), 0, 500);
        $data_tim['jabatan']              = $this->request->getPost('jabatan_tim');
        $data_tim['jenis_kelamin']        = $this->request->getPost('jenis_kelamin');
        $data_tim['no_whatsapp']          = $this->request->getPost('no_whatsapp');
        $data_tim['email']                = $this->request->getPost('email');
        $data_tim['linkedin']             = $this->request->getPost('linkedin');
        $data_tim['instagram']            = $this->request->getPost('instagram');
        $data_tim['nama_perguruan_tinggi'] = $this->request->getPost('nama_perguruan_tinggi');
        $result = $this->m_tim_startup->ubah_tim($data_tim);

        $data['status'] = $result ? true : false;
        echo json_encode($data);
    }

    public function proses_hapus_informasi_tim()
    {
        $data['id_tim'] = $this->request->getPost('id_startup_tim');
        $result = $this->m_tim_startup->hapus_tim($data);
        $data_res['status'] = $result ? true : false;
        echo json_encode($data_res);
    }

    // CRUD Produk Startup
    public function get_startup_produk()
    {
        $data_cari['id_startup_produk'] = $this->request->getPost('id_startup_produk');
        $produk = $this->m_startup_produk->get_startup_produk_by_id($data_cari)->getResult('array');
        echo json_encode($produk);
    }

    public function proses_tambah_informasi_produk()
    {
        $data_produk['id_startup']       = $this->request->getPost('id_startup');
        $data_produk['nama_produk']      = $this->request->getPost('nama_produk');
        $data_produk['deskripsi_produk'] = $this->request->getPost('deskripsi_produk');
        $data_produk['website']          = $this->request->getPost('website');
        $data_produk['instagram']        = $this->request->getPost('instagram');

        if (!empty($_FILES['logo']['name'])) {
            $ext  = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
            $nama = uniqid('produk_', true) . '.' . $ext;
            move_uploaded_file($_FILES['logo']['tmp_name'], 'public/uploads/file_produk_startup/logo_produk_startup/' . $nama);
            $data_produk['logo'] = $nama;
        }

        $result = $this->m_startup_produk->tambah_startup_produk($data_produk);
        $data['status'] = $result ? true : false;
        echo json_encode($data);
    }

    public function proses_ubah_informasi_produk()
    {
        $data_produk['id_startup_produk'] = $this->request->getPost('id_startup_produk');
        $data_produk['id_startup']        = $this->request->getPost('id_startup');
        $data_produk['nama_produk']       = $this->request->getPost('nama_produk');
        $data_produk['deskripsi_produk']  = $this->request->getPost('deskripsi_produk');
        $data_produk['website']           = $this->request->getPost('website');
        $data_produk['instagram']         = $this->request->getPost('instagram');

        if (!empty($_FILES['logo']['name'])) {
            $ext  = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
            $nama = uniqid('produk_', true) . '.' . $ext;
            move_uploaded_file($_FILES['logo']['tmp_name'], 'public/uploads/file_produk_startup/logo_produk_startup/' . $nama);
            $data_produk['logo'] = $nama;
        }

        $result = $this->m_startup_produk->ubah_startup_produk($data_produk);
        $data['status'] = $result ? true : false;
        echo json_encode($data);
    }

    public function proses_hapus_informasi_produk()
    {
        $data_hapus['id_startup_produk'] = $this->request->getPost('id_startup_produk');
        $result = $this->m_startup_produk->hapus_startup_produk($data_hapus);
        $data['status'] = $result ? true : false;
        echo json_encode($data);
    }

    // CRUD Pendanaan ITB
    public function get_startup_pendanaan_itb()
    {
        $data_cari['id_startup_pendanaan_itb'] = $this->request->getPost('id_startup_pendanaan_itb');
        $res = $this->m_startup_pendanaan_itb->get_startup_pendanaan_itb_by_id($data_cari)->getResult('array');
        echo json_encode($res);
    }

    public function proses_tambah_informasi_pendanaan_itb()
    {
        $data_in['id_startup']       = $this->request->getPost('id_startup');
        $data_in['program_kegiatan'] = $this->request->getPost('program_kegiatan_itb');
        $data_in['tahun']            = $this->request->getPost('tahun_itb');
        $data_in['jumlah_pendanaan'] = str_replace(['.', ','], ['', '.'], $this->request->getPost('jumlah_pendanaan_itb'));
        $result = $this->m_startup_pendanaan_itb->tambah_startup_pendanaan_itb($data_in);
        $data['status'] = $result ? true : false;
        echo json_encode($data);
    }

    public function proses_ubah_informasi_pendanaan_itb()
    {
        $data_in['id_startup_pendanaan_itb'] = $this->request->getPost('id_startup_pendanaan_itb');
        $data_in['id_startup']               = $this->request->getPost('id_startup');
        $data_in['program_kegiatan']         = $this->request->getPost('program_kegiatan_itb');
        $data_in['tahun']                    = $this->request->getPost('tahun_itb');
        $data_in['jumlah_pendanaan']         = str_replace(['.', ','], ['', '.'], $this->request->getPost('jumlah_pendanaan_itb'));
        $result = $this->m_startup_pendanaan_itb->ubah_startup_pendanaan_itb($data_in);
        $data['status'] = $result ? true : false;
        echo json_encode($data);
    }

    public function proses_hapus_informasi_pendanaan_itb()
    {
        $data_hapus['id_startup_pendanaan_itb'] = $this->request->getPost('id_startup_pendanaan_itb');
        $result = $this->m_startup_pendanaan_itb->hapus_startup_pendanaan_itb($data_hapus);
        $data['status'] = $result ? true : false;
        echo json_encode($data);
    }

    // CRUD Pendanaan Non ITB
    public function get_startup_pendanaan_non_itb()
    {
        $data_cari['id_startup_pendanaan_non_itb'] = $this->request->getPost('id_startup_pendanaan_non_itb');
        $res = $this->m_startup_pendanaan_non_itb->get_startup_pendanaan_non_itb_by_id($data_cari)->getResult('array');
        echo json_encode($res);
    }

    public function proses_tambah_informasi_pendanaan_non_itb()
    {
        $data_in['id_startup']       = $this->request->getPost('id_startup');
        $data_in['program_kegiatan'] = $this->request->getPost('program_kegiatan_non_itb');
        $data_in['nama_investor']    = $this->request->getPost('nama_investor');
        $data_in['tahun']            = $this->request->getPost('tahun_non_itb');
        $data_in['jumlah_pendanaan'] = str_replace(['.', ','], ['', '.'], $this->request->getPost('jumlah_pendanaan_non_itb'));
        $result = $this->m_startup_pendanaan_non_itb->tambah_startup_pendanaan_non_itb($data_in);
        $data['status'] = $result ? true : false;
        echo json_encode($data);
    }

    public function proses_ubah_informasi_pendanaan_non_itb()
    {
        $data_in['id_startup_pendanaan_non_itb'] = $this->request->getPost('id_startup_pendanaan_non_itb');
        $data_in['id_startup']                   = $this->request->getPost('id_startup');
        $data_in['program_kegiatan']             = $this->request->getPost('program_kegiatan_non_itb');
        $data_in['nama_investor']                = $this->request->getPost('nama_investor');
        $data_in['tahun']                        = $this->request->getPost('tahun_non_itb');
        $data_in['jumlah_pendanaan']             = str_replace(['.', ','], ['', '.'], $this->request->getPost('jumlah_pendanaan_non_itb'));
        $result = $this->m_startup_pendanaan_non_itb->ubah_startup_pendanaan_non_itb($data_in);
        $data['status'] = $result ? true : false;
        echo json_encode($data);
    }

    public function proses_hapus_informasi_pendanaan_non_itb()
    {
        $data_hapus['id_startup_pendanaan_non_itb'] = $this->request->getPost('id_startup_pendanaan_non_itb');
        $result = $this->m_startup_pendanaan_non_itb->hapus_startup_pendanaan_non_itb($data_hapus);
        $data['status'] = $result ? true : false;
        echo json_encode($data);
    }

    // CRUD Prestasi
    public function get_startup_prestasi()
    {
        $data_cari['id_startup_prestasi'] = $this->request->getPost('id_startup_prestasi');
        $res = $this->m_startup_prestasi->get_startup_prestasi_by_id($data_cari)->getResult('array');
        echo json_encode($res);
    }

    public function proses_tambah_informasi_prestasi()
    {
        $data_in['id_startup']        = $this->request->getPost('id_startup');
        $data_in['nama_kegiatan']     = $this->request->getPost('nama_kegiatan');
        $data_in['tahun']             = $this->request->getPost('tahun_prestasi');
        $data_in['deskripsi_prestasi'] = $this->request->getPost('deskripsi_prestasi');

        if (!empty($_FILES['dokumentasi']['name'])) {
            $ext  = pathinfo($_FILES['dokumentasi']['name'], PATHINFO_EXTENSION);
            $nama = uniqid('prestasi_', true) . '.' . $ext;
            move_uploaded_file($_FILES['dokumentasi']['tmp_name'], 'public/uploads/file_prestasi_startup/dokumentasi_prestasi_startup/' . $nama);
            $data_in['dokumentasi'] = $nama;
        }

        $result = $this->m_startup_prestasi->tambah_startup_prestasi($data_in);
        $data['status'] = $result ? true : false;
        echo json_encode($data);
    }

    public function proses_ubah_informasi_prestasi()
    {
        $data_in['id_startup_prestasi'] = $this->request->getPost('id_startup_prestasi');
        $data_in['id_startup']          = $this->request->getPost('id_startup');
        $data_in['nama_kegiatan']       = $this->request->getPost('nama_kegiatan');
        $data_in['tahun']               = $this->request->getPost('tahun_prestasi');
        $data_in['deskripsi_prestasi']  = $this->request->getPost('deskripsi_prestasi');

        if (!empty($_FILES['dokumentasi']['name'])) {
            $ext  = pathinfo($_FILES['dokumentasi']['name'], PATHINFO_EXTENSION);
            $nama = uniqid('prestasi_', true) . '.' . $ext;
            move_uploaded_file($_FILES['dokumentasi']['tmp_name'], 'public/uploads/file_prestasi_startup/dokumentasi_prestasi_startup/' . $nama);
            $data_in['dokumentasi'] = $nama;
        }

        $result = $this->m_startup_prestasi->ubah_startup_prestasi($data_in);
        $data['status'] = $result ? true : false;
        echo json_encode($data);
    }

    public function proses_hapus_informasi_prestasi()
    {
        $data_hapus['id_startup_prestasi'] = $this->request->getPost('id_startup_prestasi');
        $result = $this->m_startup_prestasi->hapus_startup_prestasi($data_hapus);
        $data['status'] = $result ? true : false;
        echo json_encode($data);
    }

    // CRUD Mentor
    public function proses_tambah_informasi_mentor()
    {
        $data_in['id_startup'] = $this->request->getPost('id_startup');
        $data_in['id_mentor']  = $this->request->getPost('id_mentor');
        $result = $this->m_startup_mentor->tambah_startup_mentor($data_in);
        $data['status'] = $result ? true : false;
        echo json_encode($data);
    }

    public function proses_hapus_informasi_mentor()
    {
        $data_hapus['id_startup_mentor'] = $this->request->getPost('id_startup_mentor');
        $result = $this->m_startup_mentor->hapus_startup_mentor($data_hapus);
        $data['status'] = $result ? true : false;
        echo json_encode($data);
    }
}
