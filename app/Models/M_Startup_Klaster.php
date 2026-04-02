<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Startup_Klaster extends Model
{
    protected $table            = 'startup_klaster';
    protected $primaryKey       = 'id_startup_klaster';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = ['id_startup', 'id_klaster'];

    protected $useTimestamps = false;
}
