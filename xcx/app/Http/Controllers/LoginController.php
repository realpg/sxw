<?php

namespace App\Http\Controllers;


use App\Components\MemberManager;
use App\Components\TestManager;
use App\Models\Member;
use App\Models\Test;
use Illuminate\Http\Request;


class LoginController extends Controller
{

    //登录页面
    public function getOpenid()
    {
        return view('demo/home');
    }
    

}
