<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function top()
    {
        echo $this->getCognitoPayload();
        return view('guest');  // resources/views/guest/top.blade.php
    }
}
