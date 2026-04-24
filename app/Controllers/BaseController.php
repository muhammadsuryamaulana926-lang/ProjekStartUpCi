<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;  

/**
 * BaseController adalah controller induk yang diwarisi oleh semua controller lain.
 * Digunakan untuk inisialisasi komponen global seperti helper, session, dan library
 * yang dibutuhkan di seluruh aplikasi.
 */
abstract class BaseController extends Controller
{
    // Inisialisasi controller, dipanggil otomatis oleh framework sebelum method apapun dijalankan
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Tambahkan helper global di sini sebelum parent::initController()
        // $this->helpers = ['form', 'url'];

        // Wajib dipanggil — jangan dihapus
        parent::initController($request, $response, $logger);

        // Inisialisasi model, library, atau session bisa ditambahkan di sini
        // $this->session = service('session');
    }
}
