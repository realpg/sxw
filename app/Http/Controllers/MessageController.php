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
use Symfony\Component\HttpFoundation\Request;

class MessageController extends Controller
{
	public static function sendSystemMessage($data)
	{
		if (checkParam($data, ['title', 'content'])) {
			if ((!array_key_exists('touser', $data)) && (!array_key_exists('groupids', $data)))
				return false;
			if (array_key_exists('touser', $data)) {
				$user = MemberManager::getByCon(['username' => [$data['touser']]])->first();
				if(!$user)
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
		$messages = MessageManager::getByCon(['username' => [$user->username], 'isread' => ['0']]);
		$user->message = $messages->count();
		return $user;
	}
}