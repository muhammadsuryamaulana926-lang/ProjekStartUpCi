<?php

namespace App\Controllers;

class Inkubasi_bisnis extends BaseController
{
    public function program_kewirausahaan()
    {
        return view('layout/header', ['title' => 'Program Kewirausahaan & Inkubasi Bisnis'])
            . view('layout/topbar')
            . view('inkubasi/v_program_kewirausahaan')
            . view('layout/footer');
    }

    public function tambah_program()
    {
        return view('layout/header', ['title' => 'Tambah Program'])
            . view('layout/topbar')
            . view('inkubasi/v_tambah_program')
            . view('layout/footer');
    }

    public function edit_program($id = null)
    {
        return view('layout/header', ['title' => 'Edit Program'])
            . view('layout/topbar')
            . view('inkubasi/v_edit_program')
            . view('layout/footer');
    }
}
