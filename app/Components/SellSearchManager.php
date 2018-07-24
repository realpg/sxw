<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Models\Sell_search;

class SellSearchManager
{
	/*
	 * 创建新的对象
	 *
	 * by Zhangli
	 *
	 * 2018/07/05
	 */
	public static function createObject()
	{
		$sell_search = new Sell_search();
		//这里可以对新建记录进行一定的默认设置
		
		return $sell_search;
	}
	
	
	/*
	 * 获取template的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
		$sell_searchs = Sell_search::orderby('itemid', 'desc')->get();
		return $sell_searchs;
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
		$sell_search = Sell_search::where('itemid', '=', $id)->first();
		return $sell_search;
	}
	
	/*
	* 根据itemid获取，没有则创建
	*
	* By Zhangli
	*
	* 2018-7-12
	*/
	public static function getByItemId($id)
	{
		$sell_search = Sell_search::where('itemid', '=', $id)->first();
		if (!$sell_search) {
			$sell_search = new Sell_search();
		}
		$sell_search->itemid=$id;
		return $sell_search;
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
		$sell_searchs = Sell_search::orderby($orderby['0'], $orderby['1'])->get();
		foreach ($ConArr as $key => $value) {
			$sell_searchs = $sell_searchs->whereIn($key, $value);
		}
		return $sell_searchs;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setSellSearch($sell_search, $data)
	{
		if (array_key_exists('name', $data)) {
			$sell_search->name = array_get($data, 'name');
		}
		return $sell_search;
	}
	/*
	 * 搜索
	 *
	 * 2018/7/13
	 */
	public static function search($keyword)
	{
		$results=Sell_search::where('content','like','%'.$keyword."%")->paginate();
		return $results;
	}
}