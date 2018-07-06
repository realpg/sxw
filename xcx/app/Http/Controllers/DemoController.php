<?php

namespace App\Http\Controllers;


use App\Components\MemberManager;
use App\Components\TestManager;
use App\Models\Member;
use App\Models\Test;
use Illuminate\Http\Request;


class DemoController extends Controller
{

    //登录页面
    public function home()
    {
        return view('demo/home');
    }
    
    public function test(){
    	$testdata=randomSalt();
    	return $testdata;
    }
	
	public function create(){
		$user=new Test();
		$user->save();
		return ApiResponse::makeResponse(true,$user,ApiResponse::SUCCESS_CODE);
	}
	
	public function getAllMembers(){
		$testdata=MemberManager::getList();
		return $testdata;
	}
	
	public function newMember(){
		$member=MemberManager::createObject();
		$member->save();
		return ApiResponse::makeResponse(true,$member,ApiResponse::SUCCESS_CODE);
	}

}
