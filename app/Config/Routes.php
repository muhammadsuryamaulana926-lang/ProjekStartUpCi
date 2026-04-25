<?php
use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Auth routes (tidak perlu login)
$routes->get('/',               'Login::index');
$routes->get('/login',          'Login::index');
$routes->post('/authenticate',  'Login::authenticate');
$routes->get('/logout',         'Login::logout');

// Protected routes (wajib login)
$routes->group('', ['filter' => 'auth'], function($routes) {

    // --- Rute Startup Kelas ---
    // Program
    $routes->get('/program',                              'Program_startup::index');
    $routes->get('/program/tambah_program',               'Program_startup::tambah_program');
    $routes->post('/program/simpan_program',              'Program_startup::simpan_program');
    $routes->get('/program/edit_program/(:any)',          'Program_startup::edit_program/$1');
    $routes->post('/program/ubah_program',                'Program_startup::ubah_program');
    $routes->get('/program/hapus_program/(:any)',         'Program_startup::hapus_program/$1');
    $routes->get('/program/detail_program/(:any)',        'Program_startup::detail_program/$1');

    // Kelas
    $routes->get('/program/tambah_kelas/(:any)',          'Kelas_startup::tambah_kelas/$1');
    $routes->post('/kelas/simpan_kelas',                  'Kelas_startup::simpan_kelas');
    $routes->get('/program/edit_kelas/(:any)',            'Kelas_startup::edit_kelas/$1');
    $routes->post('/kelas/ubah_kelas',                    'Kelas_startup::ubah_kelas');
    $routes->get('/program/hapus_kelas/(:any)',           'Kelas_startup::hapus_kelas/$1');
    $routes->get('/program/nonton_kelas/(:any)',          'Kelas_startup::nonton_kelas/$1');

    // Peserta Program
    $routes->get('/program/tambah_peserta_program/(:any)', 'Peserta_program::tambah_peserta_program/$1');
    $routes->post('/peserta_program/simpan_peserta_program','Peserta_program::simpan_peserta_program');
    $routes->post('/peserta_program/hapus_peserta_program', 'Peserta_program::hapus_peserta_program');
    // --------------------------


    // Dashboard
    $routes->get('/v_dashboard',                        'Dashboard_startup::index');
    $routes->post('/v_dashboard/get_data_startup',      'Dashboard_startup::get_data_startup');
    $routes->get('/v_dashboard/chart_per_tahun',        'Dashboard_startup::chart_per_tahun');
    $routes->get('/v_dashboard/chart_per_bulan',        'Dashboard_startup::chart_per_bulan');

    // Data Startup
    $routes->get('/v_data_startup',                     'Startup::index');
    $routes->get('/v_tambah_startup',                   'Startup::tambah_startup');
    $routes->post('/v_simpan_startup',                  'Startup::simpan_startup');
    $routes->post('/v_hapus_startup',                   'Startup::hapus_startup');
    $routes->get('/v_edit_startup/(:any)',               'Startup::edit_startup/$1');
    $routes->post('/v_edit_startup',                    'Startup::edit_startup');
    $routes->post('/v_update_startup',                  'Startup::proses_ubah_startup');
    $routes->get('/v_detail_startup/(:any)',             'Startup::detail/$1');
    $routes->get('/v_detail/(:any)',                    'Startup::detail/$1');

    // Lokasi Startup
    $routes->get('/v_lokasi_startup',                   'Startup::detail_lokasi_startup');
    $routes->get('/v_detail_lokasi_startup',            'Startup::detail_lokasi_startup');
    $routes->get('/v_lokasi_startup_saya',              'Startup::lokasi_startup_saya');
    $routes->get('/v_globe',                            'Startup::globe');

    // Perpustakaan
    $routes->get('/v_perpustakaan',                     'Perpustakaan::index');
    $routes->get('/perpustakaan',                       'Perpustakaan::index');
    $routes->get('/perpustakaan/video',                 'Perpustakaan::video');
    $routes->get('/perpustakaan/tambah_buku',            'Perpustakaan::tambah_buku');
    $routes->get('/perpustakaan/edit_buku/(:num)',          'Perpustakaan::edit_buku/$1');
    $routes->post('/perpustakaan/simpan_buku_page',         'Perpustakaan::simpan_buku_page');
    $routes->post('/perpustakaan/ubah_buku_page',           'Perpustakaan::ubah_buku_page');
    $routes->get('/perpustakaan/baca_ebook/(:any)',      'Perpustakaan::baca_ebook/$1');
    $routes->get('/perpustakaan/stream_ebook/(:any)',    'Perpustakaan::stream_ebook/$1');
    $routes->get('/perpustakaan/full_vidio/(:any)',      'Perpustakaan::full_vidio/$1');
    $routes->get('/perpustakaan/tambah_video',           'Perpustakaan::tambah_video');
    $routes->get('/perpustakaan/edit_video/(:any)',      'Perpustakaan::edit_video/$1');
    $routes->post('/perpustakaan/simpan_video_page',     'Perpustakaan::simpan_video_page');
    $routes->post('/perpustakaan/ubah_video_page',       'Perpustakaan::ubah_video_page');
    $routes->post('/perpustakaan/simpan_video',          'Perpustakaan::simpan_video');
    $routes->post('/perpustakaan/ambil_video',           'Perpustakaan::ambil_video');
    $routes->post('/perpustakaan/ubah_video',            'Perpustakaan::ubah_video');
    $routes->post('/perpustakaan/hapus_video',           'Perpustakaan::hapus_video');
    $routes->post('/perpustakaan/simpan_ebook',          'Perpustakaan::simpan_ebook');
    $routes->post('/perpustakaan/ambil_ebook',           'Perpustakaan::ambil_ebook');
    $routes->post('/perpustakaan/ubah_ebook',            'Perpustakaan::ubah_ebook');
    $routes->post('/perpustakaan/hapus_ebook',           'Perpustakaan::hapus_ebook');
    $routes->post('/perpustakaan/get_akses',             'Perpustakaan::get_akses');
    $routes->post('/perpustakaan/tambah_akses',          'Perpustakaan::tambah_akses');
    $routes->post('/perpustakaan/hapus_akses',           'Perpustakaan::hapus_akses');

    // Riwayat Aktivitas
    $routes->get('/v_riwayat_aktivitas',                'Riwayat::index');
    $routes->post('/riwayat/update_video',              'Riwayat::simpan_riwayat_video');
    $routes->post('/riwayat/update_ebook',              'Riwayat::simpan_riwayat_ebook');

    // Tim
    $routes->post('/v_simpan_tim',                      'Startup::simpan_tim');
    $routes->post('/v_get_tim',                         'Startup::get_tim');
    $routes->post('/v_update_tim',                      'Startup::update_tim');
    $routes->post('/v_hapus_tim',                       'Startup::hapus_tim');
    $routes->post('/get_startup_tim',                   'Startup::get_startup_tim');
    $routes->post('/proses_tambah_informasi_tim',       'Startup::proses_tambah_informasi_tim');
    $routes->post('/proses_ubah_informasi_tim',         'Startup::proses_ubah_informasi_tim');
    $routes->post('/proses_hapus_informasi_tim',        'Startup::proses_hapus_informasi_tim');

    // Produk
    $routes->post('/get_startup_produk',                'Startup::get_startup_produk');
    $routes->post('/proses_tambah_informasi_produk',    'Startup::proses_tambah_informasi_produk');
    $routes->post('/proses_ubah_informasi_produk',      'Startup::proses_ubah_informasi_produk');
    $routes->post('/proses_hapus_informasi_produk',     'Startup::proses_hapus_informasi_produk');

    // Pendanaan ITB
    $routes->post('/get_startup_pendanaan_itb',                 'Startup::get_startup_pendanaan_itb');
    $routes->post('/proses_tambah_informasi_pendanaan_itb',     'Startup::proses_tambah_informasi_pendanaan_itb');
    $routes->post('/proses_ubah_informasi_pendanaan_itb',       'Startup::proses_ubah_informasi_pendanaan_itb');
    $routes->post('/proses_hapus_informasi_pendanaan_itb',      'Startup::proses_hapus_informasi_pendanaan_itb');

    // Pendanaan Non ITB
    $routes->post('/get_startup_pendanaan_non_itb',             'Startup::get_startup_pendanaan_non_itb');
    $routes->post('/proses_tambah_informasi_pendanaan_non_itb', 'Startup::proses_tambah_informasi_pendanaan_non_itb');
    $routes->post('/proses_ubah_informasi_pendanaan_non_itb',   'Startup::proses_ubah_informasi_pendanaan_non_itb');
    $routes->post('/proses_hapus_informasi_pendanaan_non_itb',  'Startup::proses_hapus_informasi_pendanaan_non_itb');

    // Prestasi
    $routes->post('/get_startup_prestasi',                      'Startup::get_startup_prestasi');
    $routes->post('/proses_tambah_informasi_prestasi',          'Startup::proses_tambah_informasi_prestasi');
    $routes->post('/proses_ubah_informasi_prestasi',            'Startup::proses_ubah_informasi_prestasi');
    $routes->post('/proses_hapus_informasi_prestasi',           'Startup::proses_hapus_informasi_prestasi');

    // Mentor
    $routes->post('/proses_tambah_informasi_mentor',            'Startup::proses_tambah_informasi_mentor');
    $routes->post('/proses_hapus_informasi_mentor',             'Startup::proses_hapus_informasi_mentor');

    // Verifikasi
    $routes->post('/proses_verifikasi_startup',                 'Startup::proses_verifikasi_startup');
    $routes->post('/proses_tolak_startup',                      'Startup::proses_tolak_startup');

    $routes->post('/keep-alive',                                'Login::keepAlive');
    $routes->post('/notifikasi/tandai_dibaca',               'Startup::notif_tandai_dibaca');
    $routes->post('/notifikasi/tandai_semua',                'Startup::notif_tandai_semua');
    $routes->get('/log_aktivitas',                           'Startup::log_aktivitas');

    // Alias prefix startup/ untuk AJAX di detail startup
    $routes->post('/startup/get_startup_tim',                           'Startup::get_startup_tim');
    $routes->post('/startup/proses_tambah_informasi_tim',               'Startup::proses_tambah_informasi_tim');
    $routes->post('/startup/proses_ubah_informasi_tim',                 'Startup::proses_ubah_informasi_tim');
    $routes->post('/startup/proses_hapus_informasi_tim',                'Startup::proses_hapus_informasi_tim');
    $routes->post('/startup/get_startup_produk',                        'Startup::get_startup_produk');
    $routes->post('/startup/proses_tambah_informasi_produk',            'Startup::proses_tambah_informasi_produk');
    $routes->post('/startup/proses_ubah_informasi_produk',              'Startup::proses_ubah_informasi_produk');
    $routes->post('/startup/proses_hapus_informasi_produk',             'Startup::proses_hapus_informasi_produk');
    $routes->post('/startup/get_startup_pendanaan_itb',                 'Startup::get_startup_pendanaan_itb');
    $routes->post('/startup/proses_tambah_informasi_pendanaan_itb',     'Startup::proses_tambah_informasi_pendanaan_itb');
    $routes->post('/startup/proses_ubah_informasi_pendanaan_itb',       'Startup::proses_ubah_informasi_pendanaan_itb');
    $routes->post('/startup/proses_hapus_informasi_pendanaan_itb',      'Startup::proses_hapus_informasi_pendanaan_itb');
    $routes->post('/startup/get_startup_pendanaan_non_itb',             'Startup::get_startup_pendanaan_non_itb');
    $routes->post('/startup/proses_tambah_informasi_pendanaan_non_itb', 'Startup::proses_tambah_informasi_pendanaan_non_itb');
    $routes->post('/startup/proses_ubah_informasi_pendanaan_non_itb',   'Startup::proses_ubah_informasi_pendanaan_non_itb');
    $routes->post('/startup/proses_hapus_informasi_pendanaan_non_itb',  'Startup::proses_hapus_informasi_pendanaan_non_itb');
    $routes->post('/startup/get_startup_prestasi',                      'Startup::get_startup_prestasi');
    $routes->post('/startup/proses_tambah_informasi_prestasi',          'Startup::proses_tambah_informasi_prestasi');
    $routes->post('/startup/proses_ubah_informasi_prestasi',            'Startup::proses_ubah_informasi_prestasi');
    $routes->post('/startup/proses_hapus_informasi_prestasi',           'Startup::proses_hapus_informasi_prestasi');
    $routes->post('/startup/proses_tambah_informasi_mentor',            'Startup::proses_tambah_informasi_mentor');
    $routes->post('/startup/proses_hapus_informasi_mentor',             'Startup::proses_hapus_informasi_mentor');
    $routes->post('/startup/proses_verifikasi_startup',                 'Startup::proses_verifikasi_startup');
    $routes->post('/startup/proses_tolak_startup',                      'Startup::proses_tolak_startup');
});
