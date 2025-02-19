<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        echo $this->getCognitoPayload($request);
        return view('member');  // resources/views/member/top.blade.php
    }
}
