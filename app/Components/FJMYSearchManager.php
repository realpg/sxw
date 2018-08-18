<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Models\FJMY_search;

class FJMYSearchManager
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
		$fjmy_search = new FJMY_search();
		//这里可以对新建记录进行一定的默认设置
		$fjmy_search->areaid=0;
		$fjmy_search->status=0;
		$fjmy_search->sorttime=0;
		return $fjmy_search;
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
		$fjmy_searchs = FJMY_search::orderby('itemid', 'desc')->get();
		return $fjmy_searchs;
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
		$fjmy_search = FJMY_search::where('itemid', '=', $id)->first();
		return $fjmy_search;
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
		$fjmy_search = FJMY_search::where('itemid', '=', $id)->first();
		if (!$fjmy_search) {
			$fjmy_search = new FJMY_search();
		}
		$fjmy_search->itemid = $id;
		return $fjmy_search;
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
		$fjmy_searchs = FJMY_search::orderby($orderby['0'], $orderby['1'])->get();
		foreach ($ConArr as $key => $value) {
			$fjmy_searchs = $fjmy_searchs->whereIn($key, $value);
		}
		return $fjmy_searchs;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setFJMYSearch($fjmy_search, $data)
	{
		if (array_key_exists('name', $data)) {
			$fjmy_search->name = array_get($data, 'name');
		}
		return $fjmy_search;
	}
	
	/*
	 * 搜索
	 *
	 * 2018/7/25
	 */
	public static function search($keyword)
	{
		$results = FJMY_search::where('content', 'like', '%' . $keyword . "%");
		
		$thesauru = ThesauruManager::getByKeyword($keyword);
		if ($thesauru)
		{
			$words=explode('=',$thesauru->content);
			foreach ($words as $word){
				$results = $results->orWhere('content', 'like', '%' . $word . "%");
			}
		}
			$results = $results->paginate(5);
		return $results;
	}
}