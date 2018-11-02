<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Models\Thesauru;

class ThesauruManager
{
	/*
	 * 创建新的对象
	 *
	 * by Zhangli
	 *
	 * 2018/07/05
	 */
	public static function createObject(){
		$thesauru=new Thesauru();
		//这里可以对新建记录进行一定的默认设置
		
		return $thesauru;
	}
	
	
	/*
	 * 获取thesauru的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
		$thesaurus = Thesauru::orderby('id', 'desc')->get();
		return $thesaurus;
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
		$thesauru = Thesauru::where('id', '=', $id)->first();
		return $thesauru;
	}
	
	/*
	 * 根据条件数组获取
	 *
	 * By Zhangli
	 *
	 * 2018-07-18
	 */
	public static function getByCon(array $ConArr, $paginate = false, $orderby = ['id', 'asc'])
	{
		
		$thesaurus = Thesauru::orderby($orderby['0'], $orderby['1']);
		
		foreach ($ConArr as $key => $value) {
			$thesaurus = $thesaurus->whereIn($key, $value);
		}
		if ($paginate) {
			$thesaurus = $thesaurus->paginate(5);
		}
		if (!$paginate)
			$thesaurus = $thesaurus->get();
		return $thesaurus;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setThesauru($thesauru, $data)
	{
		if (array_key_exists('content', $data)) {
			$thesauru->content = array_get($data, 'content');
		}
		return $thesauru;
	}
	
	public static function getByKeyword($keyword){
		$thesauru=Thesauru::where('content','like','%'.$keyword.'%')->first();
		return $thesauru;
	}
}