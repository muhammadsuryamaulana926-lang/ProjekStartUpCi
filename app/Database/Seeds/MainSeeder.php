<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        $this->call('KlastersSeeder');
        $this->call('DosenPembinaSeeder');
        $this->call('ProgramsSeeder');
        $this->call('StartupsSeeder');
    }
}
