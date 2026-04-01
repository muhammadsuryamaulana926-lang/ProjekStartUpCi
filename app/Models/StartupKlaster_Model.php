<?php

namespace App\Models;

use CodeIgniter\Model;

class StartupKlaster_Model extends Model
{
    protected $table            = 'startup_klaster';
    protected $primaryKey       = 'id_startup_klaster';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = ['id_startup', 'id_klaster'];

    // Pivot tables in our schema do not have timestamps or uuids.
    protected $useTimestamps = false;
}
