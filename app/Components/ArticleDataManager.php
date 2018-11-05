<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Models\Article_data;

class ArticleDataManager
{
	/*
	 * 创建新的对象
	 *
	 * by Zhangli
	 *
	 * 2018/07/05
	 */
	public static function createObject(){
		$articleData=new Article_data();
		//这里可以对新建记录进行一定的默认设置
		
		return $articleData;
	}
	
	
	/*
	 * 获取articleData的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
		$articleDatas = Article_data::orderby('itemid', 'desc')->get();
		return $articleDatas;
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
		$articleData = Article_data::where('itemid', '=', $id)->first();
		return $articleData;
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
		$articleDatas = Article_data::query()->orderBy($orderby['0'], $orderby['1'])->get();
		foreach ($ConArr as $key => $value) {
			$articleDatas = $articleDatas->whereIn($key, $value);
		}
		return $articleDatas;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setArticleData($articleData, $data)
	{
		if (array_key_exists('content', $data)) {
			$articleData->content = array_get($data, 'content');
		}
		return $articleData;
	}
}