<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        echo $this->getCognitoPayload($request);
        return view('home');  // resources/views/top.blade.php
    }
}
