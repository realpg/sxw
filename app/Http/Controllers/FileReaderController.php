<?php

namespace App\Http\Controllers;

use App\Components\BuyDataManager;
use App\Components\BuyManager;
use App\Components\CategoryManager;
use App\Components\FJMYDataManager;
use App\Components\FJMYManager;
use App\Components\MemberManager;
use App\Components\SellDataManager;
use App\Components\SellManager;
use App\Components\TagManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;

class FileReaderController extends Controller
{
	public static function ReadExcel($file_path)
	{
		$excel_data = Excel::load($file_path)->get()->toArray();
		
		// 直接打印内容即可看到效果
		return $excel_data;
	}
	
	public static function UploadExcel(Request $request)
	{
		$row = $request->all();
//		$mid = 5;
//		$mid=$row['mid'];
		$file = $request->file('file');
		$ext = $file->extension();
		$saveName =time().rand().".".$ext;
//		$path = $file->store('/public/' . date('Y-m-d') . '/upload');
		$path = $request->file('file')->storeAs('/public/' . date('Y-m-d') . '/upload',$saveName);
//		$file_path = $file->getpath();
//		$file_path = Storage::url($file);//就是很简单的一个步骤
		$file_path='/storage/app/public/'. date('Y-m-d') . '/upload/'.$saveName;
//		$file_path = str_replace("\\", "/", $path);
		
		$excel_data = self::ReadExcel($file_path);
		$length = count($excel_data);
		$excel_data = array_slice($excel_data, 0, 100);
		
		return ApiResponse::makeResponse(true, ['file_path' => $file_path, 'data' => $excel_data, 'data_length' => $length], ApiResponse::SUCCESS_CODE);
	}
	
	public static function readData(Request $request)
	{
		$data = $request->all();
//		$mid = 5;
		$mid = $data['mid'];
		$file_path = $data['file_path'];;//就是很简单的一个步骤
		$excel_data = self::ReadExcel($file_path);
		
//		$page = $data['page'];
//		$excel_data = array_slice($excel_data, $page * 100, $page * 100 + 100, true);
//
		$checks = ["userid", "catid", "address", "desc", "tag_ids", "thumb"];
		
		$arr = [];
		foreach ($excel_data as $row) {
			
			foreach ($checks as $check) {
				if (!array_get($row, $check)) {
					$row['result'] = "失败,缺少" . $check;
					array_push($arr, $row);
					continue 2;
				}
			}
			$user = MemberManager::getById((int)array_get($row, 'userid'));
			if (!$user) {
				$row['result'] = "失败,用户未找到";
				array_push($arr, $row);
				continue;
			} elseif ($user->groupid != 6) {
				$row['result'] = "失败,用户没有发送权限";
				array_push($arr, $row);
				continue;
			} else {
				$row['telephone'] = $user->mobile;
			}
			$cat = CategoryManager::getById((int)array_get($row, 'catid'));
			if (!$cat) {
				$row['result'] = "失败,分类id错误";
				array_push($arr, $row);
				continue;
			} elseif ($cat->moduleid != $mid) {
				$row['result'] = "失败,分类id不对应";
				array_push($arr, $row);
				continue;
			}
			$tags = TagManager::getByCon(['tagid' => explode(',', $row['tag_ids'])]);
			$real_tag_ids = '';
			foreach ($tags as $tag) {
				if ($tag->moduleid == $mid) {
					$real_tag_ids = $real_tag_ids . $tag->tagid . ',';
				}
			}
			$row['real_tag_ids'] = trim($real_tag_ids, ',');
			if(!$row['real_tag_ids']){
				$row['result'] = "失败,无对应标签";
				array_push($arr, $row);
				continue;
			}
//			$row['tags'] = $tags;
			
			$item = null;
			switch ($mid) {
				case '5':
					$sell = SellManager::createObject();
					$sell_data = SellDataManager::createObject();
					$sell = SellManager::setUserInfo($sell, $row['userid']);
					$sell = SellManager::setSell($sell, $row);
					$sell->username = $user->username;
					$sell->status = '3';//默认生效
					$sell->save();
					
					$sell_data = SellDataManager::setSellData($sell_data, $row);
					$sell_data->itemid = $sell->itemid;
					$sell_data->save();
					
					$searchInfo = SellManager::createSearchInfo($sell);
					if (array_key_exists('keywords', $row)) {
						$searchInfo->content .= $row['keywords'];
					}
					$searchInfo->save();
					
					$item = $sell;
					break;
				case '6':
					$buy = BuyManager::createObject();
					$buy_data = BuyDataManager::createObject();
					
					$buy = BuyManager::setUserInfo($buy, $row['userid']);
					$buy = BuyManager::setBuy($buy, $row);
					$buy->username = $user->username;
					$buy->status = '3';//默认生效
					$buy->save();
					
					$buy_data = BuyDataManager::setBuyData($buy_data, $row);
					$buy_data->itemid = $buy->itemid;
					$buy_data->save();
					
					$searchInfo = BuyManager::createSearchInfo($buy);
					if (array_key_exists('keywords', $row)) {
						$searchInfo->content .= $row['keywords'];
					}
					$searchInfo->save();
					
					$item = $buy;
					break;
				case '88':
					$fjmy = FJMYManager::createObject();
					$fjmy_data = FJMYDataManager::createObject();
					
					$fjmy = FJMYManager::setUserInfo($fjmy, $row['userid']);
					$fjmy = FJMYManager::setFJMY($fjmy, $row);
					$fjmy->username = $user->username;
					$fjmy->status = '3';//默认生效
					$fjmy->save();
					
					$fjmy_data = FJMYDataManager::setFJMYData($fjmy_data, $row);
					$fjmy_data->itemid = $fjmy->itemid;
					$fjmy_data->save();
					
					$searchInfo = FJMYManager::createSearchInfo($fjmy);
					if (array_key_exists('keywords', $row)) {
						$searchInfo->content .= $row['keywords'];
					}
					$searchInfo->save();
					
					$item = $fjmy;
					break;
			}
			
			if (!$item) {
				$row['result'] = "失败,mid错误";
				array_push($arr, $row);
				continue;
			} elseif (array_get($row, 'addtime')) {
				$date = date_create(array_get($row, 'addtime'), new \DateTimeZone('Asia/Shanghai'));
				$item->addtime = $date->getTimestamp();
				$item->save();
			}
			
			$row['result'] = "成功";
			array_push($arr, $row);
		}
//		dd($arr);
//		Excel::load($file_path, function ($file)use($arr) {
//			$sheet=$file;
//			return json_encode($file);
//		});
		$date=date('Ymdhis');
		$name = iconv('UTF-8', 'GBK', 'result'.$date);
		Excel::create($name, function ($excel) use ($arr) {
			
			$excel->sheet('result', function ($sheet) use ($arr) {
				
				$sheet->rows($arr);
				
			});
			
		})->store('xls');
		
		$result_file_path= '/result'.$date.'.xls';
		
		
//		->export('xls');
//		Excel::load($file_path, function ($file)use($arr) {
////			$file->each(function($sheet)use($arr) {
//			$file->sheet('result', function($sheet)use($arr){
//				$sheet->fromArray($arr);
//			});
//
////			});
//		})->export('.xlsx');
		
		return ApiResponse::makeResponse(true, $result_file_path, ApiResponse::SUCCESS_CODE);
	}
	
	public static function downloadResult(Request $request){
		$data=$request->all();
		$result_file_path=$data['result_file_path'];
		if($result_file_path){
			return response()->download(storage_path('exports').$result_file_path);
		}
	}
}
