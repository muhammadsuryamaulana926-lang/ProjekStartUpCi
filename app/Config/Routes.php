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
    $routes->get('/v_dashboard',                        'Dashboard_startup::index');
    $routes->post('/v_dashboard/get_data_startup',      'Dashboard_startup::get_data_startup');
    $routes->get('/v_data_startup',                     'Startup::index');
    $routes->get('/v_detail_lokasi_startup',             'Startup::detail_lokasi_startup');
    $routes->get('/v_lokasi_startup_saya',               'Startup::lokasi_startup_saya');
    $routes->get('/v_video',                             'Konten::video');
    $routes->get('/v_buku',                              'Konten::buku');
    $routes->get('/konten/baca_ebook/(:any)',             'Konten::baca_ebook/$1');
    $routes->post('/konten/simpan_video',                'Konten::simpan_video');
    $routes->post('/konten/ambil_video',                 'Konten::ambil_video');
    $routes->post('/konten/ubah_video',                  'Konten::ubah_video');
    $routes->post('/konten/hapus_video',                 'Konten::hapus_video');
    $routes->post('/konten/simpan_ebook',                'Konten::simpan_ebook');
    $routes->post('/konten/ambil_ebook',                 'Konten::ambil_ebook');
    $routes->post('/konten/ubah_ebook',                  'Konten::ubah_ebook');
    $routes->post('/konten/hapus_ebook',                 'Konten::hapus_ebook');
    $routes->get('/v_tambah_startup',                   'Startup::tambah_startup');
    $routes->post('/v_simpan_startup',                  'Startup::simpan_startup');
    $routes->post('/v_hapus_startup',                   'Startup::hapus_startup');
    $routes->get('/v_edit_startup/(:any)',               'Startup::edit_startup/$1');
    $routes->post('/v_edit_startup',                    'Startup::edit_startup');
    $routes->post('/v_update_startup',                  'Startup::proses_ubah_startup');
    $routes->get('/v_detail/(:any)',                    'Startup::detail/$1');

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

    // Alias startup/ prefix untuk AJAX di v_detail_startup
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
