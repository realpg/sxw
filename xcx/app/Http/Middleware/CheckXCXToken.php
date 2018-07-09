<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2018/7/9
 * Time: 11:45
 */

namespace App\Http\Middleware;

use App\Http\Controllers\ApiResponse;
use Closure;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;

class CheckXCXToken
{
	function handle($request, Closure $next, $guard = null)
	{
		$data = $request->all();
		if (array_key_exists('userid', $data) && array_key_exists('_token', $data)) {
			
			$userid = array_get($data, 'userid');
			$token = array_get($data, '_token');
			$jsonstr = base64_decode($token);
			$json = json_decode($jsonstr);
			$request['json'] = $json;
			if ($json != null) {
				$tokenLifetime = $json->lifetime;
				if ($tokenLifetime!=null&time() < $tokenLifetime)
					return $next($request);
			}
		} else {
			return ApiResponse::makeResponse(false, $data, ApiResponse::MISSING_PARAM);
		}
		return ApiResponse::makeResponse(false, $data, ApiResponse::TOKEN_ERROR);
	}
	
}