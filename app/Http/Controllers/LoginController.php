<?php

namespace App\Http\Controllers;


use App\Components\CompanyManager;
use App\Components\Member_miscManager;
use App\Components\MemberManager;
use App\Components\SystemManager;
use App\Components\TestManager;
use App\Models\Member;
use App\Models\Test;
use Illuminate\Http\Request;


class LoginController extends Controller
{
	private $AppId = "wx3c1f8dfde816c48f";
	private $AppSecret = '95006aa78e8f4f7c146d0654a2bf0e55';
	
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
		$user = MemberManager::getByCon(['wx_openId' => [$openId]], ['userid', 'asc'])->first();
		if ($user == null) {
			$user = MemberManager::createObject();
			$user->wx_openId = $openId;
			$user->save();
		}
		$user = MessageController::checkMessage($user);
		
		if (array_get($data, 'userInfo') && array_get($data, 'userInfo') != [])
			if (gettype($data['userInfo']) == 'string') {
				$userInfo = json_decode($data['userInfo']);
//		$user->username = 'xcx' . md5($user->user_id);
				$user->passport = $userInfo->nickName ? $userInfo->nickName : $user->passport;
				$user->gender = $userInfo->gender ? $userInfo->gender : $user->gender;
				$user->avatarUrl = $userInfo->avatarUrl ? $userInfo->avatarUrl : $user->avatarUrl;
				$user->save();
			} else {
//		$user->username = 'xcx' . md5($user->user_id);
				$user->passport = array_key_exists('nickName', $data['userInfo']) ? $data['userInfo']['nickName'] : "新用户";
				$user->gender = array_key_exists('gender', $data['userInfo']) ? $data['userInfo']['gender'] : $user->gender;
				$user->avatarUrl = array_key_exists('avatarUrl', $data['userInfo']) ? $data['userInfo']['avatarUrl'] : $user->avatarUrl;
				$user->save();
			}
		
		$user = MemberManager::getByCon(['wx_openId' => [$openId]], ['userid', 'asc'])->first();
		$user->username = 'xcx' . $user->userid;
		$user->save();
		$user_misc = Member_miscManager::getById($user->userid);
		$user_misc->save();
		
		$userid = $user->userid;
		$jsonstr = json_encode(['userid' => $userid, 'lifetime' => getTokenLifetimeTimestemp()]);
		$_token = base64_encode($jsonstr);
		
		if ($user) {
			$user->companyInfo = $company = CompanyManager::getById($user->userid);
			$user->businesscard = BussinessCardController::getByUserid($company->userid);
		}
		$ret = $user;
		$ret->_token = $_token;
//		$ret=$user;
		return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
	}
	
	public static function invited(Request $request)
	{
		$data = $request->all();
		//检验参数
		if (checkParam($data, ['inviter_userid'])) {
			$ret = "请求成功";
			$user = MemberManager::getById($data['userid']);
			$inviter = MemberManager::getById($data['inviter_userid']);
			if ((time() - $user->regtime) > 86400) {
				return ApiResponse::makeResponse(false, "只有注册24小时内的账号可以接受邀请" . (time() - $user->regtime), ApiResponse::UNKNOW_ERROR);
			}
			if (!$inviter) {
				return ApiResponse::makeResponse(false, "获取邀请者失败", ApiResponse::UNKNOW_ERROR);
			}
			if (!CreditController::changeCredit(
				['userid' => $inviter->userid,
					'amount' => SystemManager::getById('11')->value,
					'reason' => '邀请得积分',
					'note' => 'id:' . $user->userid . "【" . $user->username . "】"])) {
				return ApiResponse::makeResponse(false, "积分变更失败", ApiResponse::UNKNOW_ERROR);
			} else {
				MessageController::sendSystemMessage([
					'title' => "邀请成功",
					'content' => "用户【" . $user->username . "(userid=" . $user->userid .
						")】刚刚接受了您的邀请并成功注册，您已获得奖励，请注意查收",
					'touser' => $inviter->username
				]);
				return ApiResponse::makeResponse(true, "接受成功", ApiResponse::SUCCESS_CODE);
			}
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
}
