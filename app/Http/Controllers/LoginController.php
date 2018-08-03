<?php

namespace App\Http\Controllers;


use App\Components\Member_miscManager;
use App\Components\MemberManager;
use App\Components\SystemManager;
use App\Components\TestManager;
use App\Models\Member;
use App\Models\Test;
use Illuminate\Http\Request;


class LoginController extends Controller
{
	private $AppId = "wxd80c70c308c99008";
	private $AppSecret = 'f5d639500976d9d0604c36b2cb08a6d5';
	
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
		if ($member == null) {
			$member = MemberManager::createObject();
			$member->wx_openId = $openId;
			$member->save();
		}
		$member = MessageController::checkMessage($member);
		
		if (gettype($data['userInfo']) == 'string') {
			$userInfo = json_decode($data['userInfo']);
//		$member->username = 'xcx' . md5($member->user_id);
			$member->passport = $userInfo->nickName ? $userInfo->nickName : $member->passport;
			$member->gender = $userInfo->gender ? $userInfo->gender : $member->gender;
			$member->avatarUrl = $userInfo->avatarUrl ? $userInfo->avatarUrl : $member->avatarUrl;
			$member->save();
		} else {
//		$member->username = 'xcx' . md5($member->user_id);
			$member->passport = array_key_exists('nickName', $data['userInfo']) ? $data['userInfo']['nickName'] : "新用户";
			$member->gender = array_key_exists('gender', $data['userInfo']) ? $data['userInfo']['gender'] : $member->gender;
			$member->avatarUrl = array_key_exists('avatarUrl', $data['userInfo']) ? $data['userInfo']['avatarUrl'] : $member->avatarUrl;
			$member->save();
		}
		
		$member = MemberManager::getByCon(['wx_openId' => [$openId]], ['userid', 'asc'])->first();
		$member->username = 'xcx' . $member->userid;
		$member->save();
		$member_misc = Member_miscManager::getById($member->userid);
		$member_misc->save();
		
		$userid = $member->userid;
		$jsonstr = json_encode(['userid' => $userid, 'lifetime' => getTokenLifetimeTimestemp()]);
		$_token = base64_encode($jsonstr);
		$ret = $member;
		$ret ['_token'] = $_token;
//		$ret=$member;
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
