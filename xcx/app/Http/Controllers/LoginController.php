<?php

namespace App\Http\Controllers;


use App\Components\MemberManager;
use App\Components\TestManager;
use App\Models\Member;
use App\Models\Test;
use Illuminate\Http\Request;


class LoginController extends Controller
{
	private $AppId = "wx3cd6d8d4b71e14d3";
	private $AppSecret = '5b774d269553b8c787d1c2fd06ab7ded';
	
	//登录页面
	public function getOpenid(Request $request)
	{
		$data = $request->all();
		$code = $data['code'];//小程序传来的code值
		$url = 'https://api.weixin.qq.com/sns/jscode2session?appid=' . $this->AppId . '&secret=' . $this->AppSecret . '&js_code=' . $code . '&grant_type=authorization_code';
		//yourAppid为开发者appid.appSecret为开发者的appsecret,都可以从微信公众平台获取；
		$info = file_get_contents($url);
		//发送HTTPs请求并获取返回的数据，推荐使用curl
		$json = json_decode($info);//对json数据解码
		return ApiResponse::makeResponse(true, $json, ApiResponse::SUCCESS_CODE);
	}
	
	//登陆接口
	public function login(Request $request)
	{
		$data = $request->all();
//		return $data;
		$openId = $data['openId'];
		$member = MemberManager::getByCon(['wx_openId' => [$openId]], ['userid', 'asc'])->first();
		if ($member==null) {
			$member = MemberManager::createObject();
			$member->wx_openId = $openId;
			$member->save();
		}
//		$member->username = 'xcx' . md5($member->user_id);
		$member->passport = $data['userInfo']['nickName'];
		$member->gender = $data['userInfo']['gender'];
		$member->save();
		
		$userid = $member->userid;
		$jsonstr=json_encode(['userid'=>$userid,'lifetime'=>getTokenLifetimeTimestemp()]);
		$_token = base64_encode($jsonstr);
		$ret=['userid'=>$userid,'_token'=>$_token];
		return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
	}
	
}
