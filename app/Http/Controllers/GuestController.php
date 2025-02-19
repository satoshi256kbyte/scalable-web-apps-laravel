<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index(Request $request)
    {
        echo $this->getCognitoPayload($request);
        return view('guest');  // resources/views/guest/top.blade.php
    }
}
