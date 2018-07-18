<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2018/7/18
 * Time: 9:21
 */

namespace App\Http\Controllers;

use App\Components\SystemManager;

class SystemController extends Controller
{
	public static function systemKeyValues_get(){
		$keyValues=SystemManager::getList();
		return view('systemKeyValue',['values'=>$keyValues]);
	}
	
	public static function systemKeyValues_post(){
	
	}
	
}