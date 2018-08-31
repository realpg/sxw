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
use Qiniu\Storage\BucketManager;

class UploadController extends Controller
{
	public static function upload(Request $request){
		$file = $request->file('file')->store('/public/' . date('Y-m-d') . '/upload');
		//上传的头像字段avatar是文件类型
		$url = URL::asset(Storage::url($file));//就是很简单的一个步骤
//		$resource = Resource::create(['type' => 1, 'resource' => $avatar]);
		if ($url) {
			return ApiResponse::makeResponse(true,$url,ApiResponse::SUCCESS_CODE);
		}
		return ApiResponse::makeResponse(false,'upload fail',ApiResponse::UNKNOW_ERROR);
	}
	
	public function store(Request $request) {
		if($request->hasFile('file')
			&& $request->file->isValid()
		) {
			$allow_types = ['image/png', 'image/jpeg', 'image/gif', 'image/jpg'];
			if(!in_array($request->file->getMiMeType(), $allow_types)) {
				return ApiResponse::makeResponse(false,'图片类型不正确',ApiResponse::UNKNOW_ERROR);
			}
			if($request->file->getClientSize() > 1024 * 1024 * 3) {
				return ApiResponse::makeResponse(false,'图片大小不能超过 3M',ApiResponse::UNKNOW_ERROR);
			}
			$path = $request->file->store('public/images');
//            //上传到本地
//            return ['status'=> 1, 'msg'=>'/storage'.str_replace('public', '', $path)];
			
			//storage_path返回根目录下的storage的绝对路径 里面放的直接丢在后面
			$filePath = storage_path('app/'.$path);
			
			//上传到七牛
			$url= qiniu_upload($filePath);  //调用的全局函数
			
			//返回
			
			if ($url) {
				return ApiResponse::makeResponse(true,$url,ApiResponse::SUCCESS_CODE);
			}
			return ApiResponse::makeResponse(false,'upload fail',ApiResponse::UNKNOW_ERROR);
			
		}
	}
	
}
