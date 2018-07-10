<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2018/7/10
 * Time: 9:31
 */

namespace App\Http\Controllers;

use App\Components\BuyDataManager;
use App\Components\BuyManager;
use Illuminate\Http\Request;

class BuyController
{
	public function edit(Request $request)
	{
		$data = $request->all();
		//检验参数
		if (checkParam($data, ['title', 'introduce', 'amount', 'price', 'pack', 'content', 'thumb'])) {
			
			if(array_key_exists('itemid',$data)){
				$buy=BuyManager::getById($data['itemid']);
				$buy_data=BuyDataManager::getById($data['itemid']);
			}else{
				$buy = BuyManager::createObject();
				$buy_data = BuyDataManager::createObject();
			}
			
			
			$buy = BuyManager::setUserInfo($buy, 1);
			$buy = BuyManager::setBuy($buy, $data);
			$buy->save();
			
			$buy_data = BuyDataManager::setBuyData($buy_data, $data);
			$buy_data->itemid = $buy->itemid;
			$buy_data->save();
			
			return ApiResponse::makeResponse(true, $buy, ApiResponse::SUCCESS_CODE);
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
		
	}
}