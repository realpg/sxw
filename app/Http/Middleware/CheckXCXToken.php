<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2018/7/9
 * Time: 11:45
 */

namespace App\Http\Middleware;

use App\Components\MemberManager;
use App\Http\Controllers\ApiResponse;
use Closure;

class CheckXCXToken
{
	function handle($request, Closure $next, $guard = null)
	{
		$data = $request->all();
		if (checkParam($data, ['userid', '_token'])) {
			$userid = array_get($data, 'userid');
			$token = array_get($data, '_token');
			$jsonstr = base64_decode($token);
			$json = json_decode($jsonstr);
			$request['json'] = $json;
			if ($json != null) {
				$_userid = $json->userid;
				$tokenLifetime = $json->lifetime;
				if ($tokenLifetime != null & time() < $tokenLifetime & $_userid == $userid) {
//					$member = MemberManager::getById($userid);
//					if ($member->groupid != 2)
					return $next($request);
//					else
//						return ApiResponse::makeResponse(false, "未找到用户或用户被封禁", ApiResponse::NO_USER);
				}
				
			}
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
		return ApiResponse::makeResponse(false, "token失效", ApiResponse::TOKEN_ERROR);
	}
	
}