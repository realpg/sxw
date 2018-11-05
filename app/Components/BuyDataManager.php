<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Models\Buy_data;

class BuyDataManager
{
	/*
	 * 创建新的对象
	 *
	 * by Zhangli
	 *
	 * 2018/07/05
	 */
	public static function createObject(){
		$buyData=new Buy_data();
		//这里可以对新建记录进行一定的默认设置
		
		return $buyData;
	}
	
	
	/*
	 * 获取buyData的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
		$buyDatas = Buy_data::orderby('itemid', 'desc')->get();
		return $buyDatas;
	}
	
	/*
	 * 根据id获取
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getById($id)
	{
		$buyData = Buy_data::where('itemid', '=', $id)->first();
		return $buyData;
	}
	
	/*
	 * 根据条件数组获取
	 *
	 * By Zhangli
	 *
	 * 2018-04-19
	 */
	public static function getByCon($ConArr, $orderby = ['itemid', 'asc'])
	{
		$buyDatas = Buy_data::query()->orderBy($orderby['0'], $orderby['1'])->get();
		foreach ($ConArr as $key => $value) {
			$buyDatas = $buyDatas->whereIn($key, $value);
		}
		return $buyDatas;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setBuyData($buyData, $data)
	{
		if (array_key_exists('content', $data)) {
			$buyData->content = array_get($data, 'content');
		}
		if (array_key_exists('desc', $data)) {
			$buyData->content = array_get($data, 'desc');
		}
		return $buyData;
	}
}