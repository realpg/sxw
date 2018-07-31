<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2018/7/31
 * Time: 9:28
 */

namespace App\Http\Controllers;

use App\Components\MessageManager;
use Symfony\Component\HttpFoundation\Request;

class MessageController extends Controller
{
	public static function sendSystemMessage($data)
	{
		if (checkParam($data, ['title', 'content', 'touser'])) {
			if ((!array_key_exists('touser', $data)) && (!array_key_exists('groupids', $data)))
				return false;
			$message = MessageManager::createObject();
			$message = MessageManager::setMessage($message, $data);
			$message->save();
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
}