<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLevel extends Model
{
    protected $table            = 'level';
    protected $primaryKey       = 'levelid';
    protected $allowedFields    = ['levelnama'];

    // Dates
    protected $useTimestamps = true;
}