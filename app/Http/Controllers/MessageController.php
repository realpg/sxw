<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2018/7/31
 * Time: 9:28
 */

namespace App\Http\Controllers;

use App\Components\MemberManager;
use App\Components\MessageManager;
use App\Components\VertifyManager;
use Symfony\Component\HttpFoundation\Request;

class MessageController extends Controller
{
	//审核通知模版id
	public static $shenhe_template_id='qrqiieLYn-VQaVUgJvVKXu_pSUynN2ZhaMFg323f8Ak';
	//评论通知模版id
	public static $comment_template_id='H3qiA1kRam-2q0OrQtChQA2sBMcUKzOmFYc6Z5hZLWw';
	
	public static function sendSystemMessage($data)
	{
		if (checkParam($data, ['title', 'content'])) {
			if ((!array_key_exists('touser', $data)) && (!array_key_exists('groupids', $data)))
				return false;
			if (array_key_exists('touser', $data)) {
				$user = MemberManager::getByCon(['username' => [$data['touser']]])->first();
				if (!$user)
					return false;
				$user->message++;
				$user->save();
			}
			$message = MessageManager::createObject();
			$message = MessageManager::setMessage($message, $data);
			$message->save();
			
			return true;
		} else {
			return false;
		}
	}
	
	//发送微信模版消息
	public static function sendWXTemplateMessage($openid, $templateid, $page, $formid, $data_arr,$emphasis_keyword=null)
	{
		// 根据你的模板对应的关键字建立数组
		// color 属性是可选项目，用来改变对应字段的颜色
//		$data_arr = array(
//			'keyword1' => array("value" => $value, "color" => $color)
//		);
		
		$post_data = array(
			// 用户的 openID，可用过 wx.getUserInfo 获取
			"touser" => $openid,
			// 小程序后台申请到的模板编号
			"template_id" => $templateid,
			// 点击模板消息后跳转到的页面，可以传递参数
			"page" => $page,
			// 第一步里获取到的 formID
			"form_id" => $formid,
			// 数据
			"data" => $data_arr,
			// 需要强调的关键字，会加大居中显示
			"emphasis_keyword" =>$emphasis_keyword
		
		);
		
		// 这里替换为你的 appID 和 appSecret
		$url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token="
			. LoginController::getACCESS_TOKEN()->access_token;
// 将数组编码为 JSON
		$data = json_encode($post_data, true);
		// 这里的返回值是一个 JSON，可通过 json_decode() 解码成数组
		$return = send_post($url, $data);
		return json_encode($return);
		
	}
	
	public static function getMessage(Request $request)
	{
		$data = $request->all();
		//检验参数
		if (checkParam($data, [])) {
			$ret = MessageManager::getByUserid($data['userid']);
			
			return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
			
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
	public static function getById(Request $request)
	{
		$data = $request->all();
		//检验参数
		if (checkParam($data, ['itemid'])) {
			$ret = $message = MessageManager::getById($data['itemid']);
			$message->isread = 1;
			$message->save();
			
			return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
			
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
	public static function checkMessage($user)
	{
		$messages = MessageManager::getByCon(['username' => $user->username, 'isread' => '0']);
		$user->message = $messages->count();
		return $user;
	}
	
	public static function sendVertifyCode(Request $request)
	{
		$data = $request->all();
		//检验参数
		if (checkParam($data, ['phonenum'])) {
			$send_ret = VertifyManager::doVertify($data['phonenum']);
			if ($send_ret)
				return ApiResponse::makeResponse(true, "发送成功", ApiResponse::SUCCESS_CODE);
			else
				return ApiResponse::makeResponse(false, "发送失败", ApiResponse::UNKNOW_ERROR);
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
}