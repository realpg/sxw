<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2018/8/24
 * Time: 13:58
 */

namespace App\Http\Middleware;

use App\Http\Controllers\ApiResponse;
use Closure;

class CheckAdmin
{
	function handle($request, Closure $next, $guard = null)
	{
		
		$userid = $request->session()->get('userid');
		$MG = $request->session()->get('MG');
//		return $next($request);
		return ApiResponse::makeResponse(true, ['userid' => $userid, 'MG' => $MG], 200);
	}
}