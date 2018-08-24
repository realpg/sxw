<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2018/8/24
 * Time: 13:58
 */

namespace App\Http\Middleware;

use App\Components\MemberManager;
use App\Http\Controllers\ApiResponse;
use Closure;

class CheckAdmin
{
	function handle($request, Closure $next, $guard = null)
	{
		if ($request->session()->get('_userid')) {
			$userid = $request->session()->get('_userid');
			$user = MemberManager::getById($userid);
		} else {
			$userid = array_get($request->all(), '_userid');
			$seed = array_get($request->all(), 'seed');
			if (!$userid || !$seed) {
				abort(404);
			}
			
			$user = MemberManager::getById($userid);
			if ($seed != md5($userid . ":" . $user->username)) {
				abort(404);
			};
		}
		
		if($user->admin==0){
			abort(404);
		}
		else{
			$request->session()->put('_userid',$userid);
		}
		return $next($request);
	}
}