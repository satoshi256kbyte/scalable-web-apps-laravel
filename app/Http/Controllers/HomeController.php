<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        echo $this->getCognitoPayload();
        return view('home');  // resources/views/top.blade.php
    }
}
