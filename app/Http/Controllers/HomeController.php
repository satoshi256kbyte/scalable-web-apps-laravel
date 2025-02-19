<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function top()
    {
        echo $this->getCognitoPayload();
        return view('top');  // resources/views/top.blade.php
    }
}
