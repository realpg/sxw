<?php

namespace App\Http\Controllers;


use App\Components\CompanyManager;
use App\Components\InviteManager;
use App\Components\Member_miscManager;
use App\Components\Member_updateManager;
use App\Components\MemberManager;
use App\Components\MessageManager;
use App\Components\SystemManager;
use App\Components\TestManager;
use App\Components\UpgradeManager;
use App\Models\Member;
use App\Models\Test;
use Illuminate\Http\Request;


class LoginController extends Controller
{
	private $AppId = "wx8cd83ffdb4609f53";
	private $AppSecret = '1495167ac94dd33a0deeb3c9eee07119';
	
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
		if (!checkParam($data, ['openId'])) {
			return ApiResponse::makeResponse(false, "缺少openid", ApiResponse::UNKNOW_ERROR);
		}
		$openId = $data['openId'];
		$user = MemberManager::getByopenId($openId);
		if ($user == null) {
			$user = MemberManager::createObject();
			$user->wx_openId = $openId;
			$user->save();
			$user->username = 'xcx' . $user->userid;
			$user->save();
		}
		$user = MessageController::checkMessage($user);
		
		if (array_get($data, 'userInfo') && array_get($data, 'userInfo') != [])
			if (gettype($data['userInfo']) == 'string') {
				$userInfo = json_decode($data['userInfo']);
//		$user->username = 'xcx' . md5($user->user_id);
				$user->passport = $userInfo->nickName ? $userInfo->nickName : $user->passport;
				$user->gender = $userInfo->gender ? $userInfo->gender : $user->gender;
				if (!$user->avatarUrl)
					$user->avatarUrl = $userInfo->avatarUrl ? $userInfo->avatarUrl : $user->avatarUrl;
				$user->save();
			} else {
//		$user->username = 'xcx' . md5($user->user_id);
				$user->passport = array_key_exists('nickName', $data['userInfo']) ? $data['userInfo']['nickName'] : "新用户";
				$user->gender = array_key_exists('gender', $data['userInfo']) ? $data['userInfo']['gender'] : $user->gender;
				if (!$user->avatarUrl)
					$user->avatarUrl = array_key_exists('avatarUrl', $data['userInfo']) ? $data['userInfo']['avatarUrl'] : $user->avatarUrl;
				$user->save();
			}
		
		$user = MemberManager::getByopenId($openId);
		$user->message = MessageManager::getNumberByUserid($user->userid);
		$user->save();
		$user_misc = Member_miscManager::getById($user->userid);
		$user_misc->save();
		
		$userid = $user->userid;
		$jsonstr = json_encode(['userid' => $userid, 'lifetime' => getTokenLifetimeTimestemp()]);
		$_token = base64_encode($jsonstr);
		
		if ($user) {
			$user->companyInfo = $company = CompanyManager::getById($user->userid);
			$user->businesscard = BussinessCardController::getByUserid($company->userid, $user);
			$user->updating = (UpgradeManager::getByCon(['userid' => [$user->userid], 'status' => '2'])->count() > 0)
				|| (Member_updateManager::getByCon(['userid' => [$user->userid], 'status' => '2'])->count() > 0);
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
				return ApiResponse::makeResponse(false, "只有注册24小时内的账号可以接受邀请", ApiResponse::UNKNOW_ERROR);
			}
			if (!$inviter) {
				return ApiResponse::makeResponse(false, "获取邀请者失败", ApiResponse::UNKNOW_ERROR);
			}
			$invite_e = InviteManager::getByUserid($user->userid);
			if ($invite_e) {
				return ApiResponse::makeResponse(false, "不能重复接受邀请!", ApiResponse::UNKNOW_ERROR);
			}
			$invite = InviteManager::setInvite(InviteManager::createObject(), $inviter, $user);
			$invite->save();
			if (!$invite || !CreditController::changeCredit(
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
	
	public function getACCESS_TOKEN()
	{
		$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $this->AppId . '&secret=' . $this->AppSecret;
		//yourAppid为开发者appid.appSecret为开发者的appsecret,都可以从微信公众平台获取；
		$info = file_get_contents($url);
		//发送HTTPs请求并获取返回的数据，推荐使用curl
		$json = json_decode($info);//对json数据解码
		return $json;
	}
	
	public function getXCXQR($user)
	{
		$filename = $user->username . '_' . time();
		$access_token = $this->getACCESS_TOKEN()->access_token;
		if (!$access_token)
			return ApiResponse::makeResponse(false, "获取access_token失败", ApiResponse::UNKNOW_ERROR);
		$url = 'https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=' . $access_token;
		$headers = array('Content-type: ' . 'application/json');
		$body = [
//			'access_token'=>$access_token,
			'scene' => 'userid=' . $user->userid,
//			'page' => "pages/index/index",
		];
		// 拼接字符串
		$fields_string = json_encode($body);
		
		$con = curl_init();
		curl_setopt($con, CURLOPT_URL, $url);
//		curl_setopt($con, CURLOPT_SSL_VERIFYHOST, FALSE);
//		curl_setopt($con, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($con, CURLOPT_HEADER, 0);
		curl_setopt($con, CURLOPT_POST, 1);
		curl_setopt($con, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($con, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($con, CURLOPT_POSTFIELDS, $fields_string);
		$info = curl_exec($con);
		//发送HTTPs请求并获取返回的数据，推荐使用curl
//		$json = json_decode($info);//对json数据解码
		$err = curl_error($con);
		curl_close($con);
		
		$filePath = $filename . '.jpg';
		file_put_contents($filePath, $info);
		$url = qiniu_upload($filePath, 'wxqr');  //调用的全局函数
//		unlink($filename.'.jpg');
		return $url;
//		dd($info);
	}
	
	public function getInviteQR(Request $request)
	{
		$data = $request->all();
		//检验参数
		if (true) {
			$user = MemberManager::getById($data['userid']);
			
			$ret = $this->getXCXQR($user);
			
			return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
			
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
	public function myInvited(Request $request)
	{
		$user = MemberManager::getById($request->all()['userid']);
		$invites = InviteManager::getByCon(['inviter_userid' => [$user->userid]], false, ['addtime', 'asc']);
		foreach ($invites as $invite) {
			$invite->user = BussinessCardController::getByUserid($invite->userid);
		}
		$ret = $invites; 
		return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
	}
}
