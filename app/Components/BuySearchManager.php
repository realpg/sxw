<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Models\Buy_search;

class BuySearchManager
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
		$buy_search = new Buy_search();
		//这里可以对新建记录进行一定的默认设置
		$buy_search->areaid=0;
		return $buy_search;
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
		$buy_searchs = Buy_search::orderby('itemid', 'desc')->get();
		return $buy_searchs;
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
		$buy_search = Buy_search::where('itemid', '=', $id)->first();
		return $buy_search;
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
		$buy_search = Buy_search::where('itemid', '=', $id)->first();
		if (!$buy_search) {
			$buy_search = new Buy_search();
		}
		$buy_search->itemid=$id;
		return $buy_search;
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
		$buy_searchs = Buy_search::orderby($orderby['0'], $orderby['1'])->get();
		foreach ($ConArr as $key => $value) {
			$buy_searchs = $buy_searchs->whereIn($key, $value);
		}
		return $buy_searchs;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setBuySearch($buy_search, $data)
	{
		if (array_key_exists('name', $data)) {
			$buy_search->name = array_get($data, 'name');
		}
		return $buy_search;
	}
	/*
	 * 搜索
	 *
	 * 2018/7/13
	 */
	public static function search($keyword)
	{
		$results=Buy_search::where('content','like','%'.$keyword."%");
		
		$thesauru = ThesauruManager::getByKeyword($keyword);
		if ($thesauru)
		{
			$words=explode('=',$thesauru->content);
			foreach ($words as $word){
				$results = $results->orWhere('content', 'like', '%' . $word . "%");
			}
		}
		$results = $results->paginate();
		return $results;
	}
}