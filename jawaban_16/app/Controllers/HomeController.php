<?php

namespace App\Controllers;

use Core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return $this->view('home', ['message' => 'HELLO MY NAME DARY MAHDI!']);
    }
}