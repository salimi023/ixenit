<?php

namespace App\Controllers;

class Home extends BaseController
{
    // Homepage
    public function index(): string
    {
        return view('home');
    }
}
