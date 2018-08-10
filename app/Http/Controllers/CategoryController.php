<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2018/8/10
 * Time: 15:54
 */

namespace App\Http\Controllers;

use App\Components\CategoryManager;
use Illuminate\Http\Request;

class CategoryController
{
	public static function getByMid(Request $request)
	{
		$data = $request->all();
		//检验参数
		if (checkParam($data, [ 'mid'])) {
			$cates=CategoryManager::getByCon(['moduleid'=>$data[ 'mid']]);
			$ret=array_arrange($cates);
			
			return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
			
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
}