<?php

namespace App\Controllers;

class AdmHome extends BaseController
{
    public function index()
    {
        return view('admmain/layout');
    }
}