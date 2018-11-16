<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Models\Sell_data;

class SellDataManager
{
	/*
	 * 创建新的对象
	 *
	 * by Zhangli
	 *
	 * 2018/07/05
	 */
	public static function createObject(){
		$sellData=new Sell_data();
		//这里可以对新建记录进行一定的默认设置
		
		return $sellData;
	}
	
	
	/*
	 * 获取sellData的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
		$sellDatas = Sell_data::orderby('itemid', 'desc')->get();
		return $sellDatas;
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
		$sellData = Sell_data::where('itemid', '=', $id)->first();
		return $sellData;
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
		$sellDatas = Sell_data::query()->orderby($orderby['0'], $orderby['1']);
		foreach ($ConArr as $key => $value) {
			if (gettype($value) == 'array')
				$sellDatas = $sellDatas->whereIn($key, $value);
			else
				$sellDatas = $sellDatas->where($key, $value);
		}
		return $sellDatas->get();
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setSellData($sellData, $data)
	{
		if (array_key_exists('content', $data)) {
			$sellData->content = array_get($data, 'content');
		}
		if (array_key_exists('desc', $data)) {
			$sellData->content = array_get($data, 'desc');
		}
		return $sellData;
	}
}