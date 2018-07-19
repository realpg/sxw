<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2018/7/18
 * Time: 9:21
 */

namespace App\Http\Controllers;

use App\Components\LLJLManager;
use App\Components\Member_updateManager;
use App\Components\SystemManager;
use Illuminate\Http\Request;

class SystemController extends Controller
{
	public static function systemKeyValues_get()
	{
		$keyValues = SystemManager::getList(['id', 'asc']);
		return view('systemKeyValue', ['values' => $keyValues]);
	}
	
	public static function systemKeyValues_post(Request $request)
	{
		$data = $request->all();
		//检验参数
		if (checkParam($data, ['id', 'value'])) {
			$ret = $data;
			$keyvalue = SystemManager::getById($data['id']);
			$keyvalue = SystemManager::setSystem($keyvalue, $data);
			$keyvalue->save();
			
			return ApiResponse::makeResponse(true, $keyvalue, ApiResponse::SUCCESS_CODE);
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
	public static function xcx_lljl(Request $request)
	{
		$data = $request->all();
		$con = [];
		if (array_key_exists('moduleid', $data)) if ($data['moduleid'] != 0)
			$con['moduleid'] = [$data['moduleid']];
		if (array_key_exists('timefrom', $data) ) if ( $data['timefrom'] != null) {
			$con['timefrom'] = strtotime($data['timefrom']) - 28800;
		}
		if (array_key_exists('timeto', $data)) if ( $data['timeto'] != null) {
			$con['timeto'] = strtotime($data['timeto']) + 57600;
		}
		$lljls = LLJLManager::getByCon($con);
		return view('lljl', ['lljls' => $lljls, 'datas' => $con]);
	}
	
	public static function memberUpdate(Request $request)
	{
		$data = $request->all();
		$con = [];
		if (array_key_exists('status', $data)) if ( $data['status'] != 0)
			$con['status'] = [$data['status']];
		$updates = Member_updateManager::getByCon($con);
		return view('member_update', ['datas' => $updates]);
	}
}