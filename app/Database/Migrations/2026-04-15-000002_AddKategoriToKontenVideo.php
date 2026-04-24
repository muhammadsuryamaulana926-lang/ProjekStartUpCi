<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class AddKategoriToKontenVideo extends Migration
{
    public function up()
    {
        $this->forge->addColumn('konten_video', [
            'kategori_video' => [
                'type'       => 'ENUM',
                'constraint' => [
                    'Bisnis & Startup',
                    'Teknologi',
                    'Marketing',
                    'Keuangan',
                    'Manajemen',
                    'Hukum & Legalitas',
                    'Desain & Produk',
                    'Motivasi',
                    'Podcast',
                ],
                'null'    => true,
                'default' => null,
                'after'   => 'deskripsi_video',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('konten_video', 'kategori_video');
    }
}
