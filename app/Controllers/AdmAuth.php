<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class AdmAuth extends BaseController
{
    public function index()
    {
        return view('admauth/login');
    }

    public function daftar()
    {
        return view('admauth/daftar');
    }

    public function reset()
    {
        return view('admauth/reset');
    }
}