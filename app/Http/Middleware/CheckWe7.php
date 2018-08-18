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
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;

class CheckWe7
{
	function handle($request, Closure $next, $guard = null)
	{
		$data = $request->all();
		if (checkParam($data, ['seed', '_token', 'we7_uid'])) {
			$time = time();
			if ($data['seed'] - $time > 600 || $time - $data['seed'] > 600) {
				return ApiResponse::makeResponse(false, '超出时间范围', ApiResponse::DATE_NOT_INT_SCOPE);
			}
			$token = md5("479534939cd43ddc198686f3a1bc32be" . $data['seed']);
			if ($data['_token'] != $token) {
				return ApiResponse::makeResponse(false, "token失效", ApiResponse::TOKEN_ERROR);
			}
			//验证微擎uid关联关系,待补全
			
			return $next($request);
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
}