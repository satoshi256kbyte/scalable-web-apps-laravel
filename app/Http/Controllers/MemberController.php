<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function top()
    {
        echo $this->getCognitoPayload();
        return view('member');  // resources/views/member/top.blade.php
    }
}
