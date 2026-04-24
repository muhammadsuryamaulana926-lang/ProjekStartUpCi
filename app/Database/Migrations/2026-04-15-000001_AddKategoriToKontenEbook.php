<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class AddKategoriToKontenEbook extends Migration
{
    public function up()
    {
        $this->forge->addColumn('konten_ebook', [
            'kategori_ebook' => [
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
                ],
                'null'    => true,
                'default' => null,
                'after'   => 'penulis_ebook',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('konten_ebook', 'kategori_ebook');
    }
}
