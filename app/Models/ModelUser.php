<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelUser extends Model
{
    protected $table            = 'user';
    protected $primaryKey       = 'userid';
    protected $allowedFields    = [
        'userid', 'usernama', 'userktp', 'userpassword', 'userlevel', 'userverify'
    ];

    // Dates
    protected $useTimestamps = true;


    // Cari Nomor KTP
    public function cariUser($userktp)
    {
        return $this->table('user')->getWhere('userktp', $userktp);
    }
}