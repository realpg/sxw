<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2018/7/27
 * Time: 10:45
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class UploadController extends Controller
{
	public static function upload(Request $request){
		$file = $request->file('file')->store('/public/' . date('Y-m-d') . '/upload');
		//上传的头像字段avatar是文件类型
		$url = URL::asset(Storage::url($file));//就是很简单的一个步骤
//		$resource = Resource::create(['type' => 1, 'resource' => $avatar]);
		if (true) {
			return ApiResponse::makeResponse(true,$url,ApiResponse::SUCCESS_CODE);
		}
		return ApiResponse::makeResponse(false,'upload success',ApiResponse::UNKNOW_ERROR);
		
	}
}
