<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Models\Category;

class CategoryManager
{
	/*
	 * 创建新的对象
	 *
	 * by Zhangli
	 *
	 * 2018/07/05
	 */
	public static function createObject(){
		$category=new Category();
		//这里可以对新建记录进行一定的默认设置
		
		return $category;
	}
	
	
	/*
	 * 获取category的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
		$categorys = Category::orderby('catid', 'desc')->get();
		return $categorys;
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
		$category = Category::where('catid', '=', $id)->first();
		return $category;
	}
	
	/*
	 * 根据条件数组获取
	 *
	 * By Zhangli
	 *
	 * 2018-04-19
	 */
	public static function getByCon($ConArr, $orderby = ['catid', 'asc'])
	{
		$categorys = Category::orderby($orderby['0'], $orderby['1'])->get();
		foreach ($ConArr as $key => $value) {
			$categorys = $categorys->whereIn($key, $value);
		}
		return $categorys;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setCategory($category, $data)
	{
		if (array_key_exists('name', $data)) {
			$category->name = array_get($data, 'name');
		}
		return $category;
	}
}