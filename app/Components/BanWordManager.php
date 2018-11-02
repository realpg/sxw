<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Models\BanWord;

class BanWordManager
{
	/*
	 * 创建新的对象
	 *
	 * by Zhangli
	 *
	 * 2018/07/05
	 */
	public static function createObject(){
		$banword=new BanWord();
		//这里可以对新建记录进行一定的默认设置
		
		return $banword;
	}
	
	
	/*
	 * 获取banword的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
		$banwords = BanWord::orderby('bid', 'desc')->get();
		return $banwords;
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
		$banword = BanWord::where('bid', '=', $id)->first();
		return $banword;
	}
	
	/*
	 * 根据条件数组获取
	 *
	 * By Zhangli
	 *
	 * 2018-07-18
	 */
	public static function getByCon(array $ConArr, $paginate = false, $orderby = ['bid', 'asc'])
	{
		
		$banwords = BanWord::orderby($orderby['0'], $orderby['1']);
		foreach ($ConArr as $key => $value) {
			$banwords = $banwords->whereIn($key, $value);
		}
		if ($paginate) {
			$banwords = $banwords->paginate(5);
		}
		if (!$paginate)
			$banwords = $banwords->get();
		return $banwords;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setBanWord($banword, $data)
	{
		if (array_key_exists('name', $data)) {
			$banword->name = array_get($data, 'name');
		}
		return $banword;
	}
	
	/*
	 * 过滤输入字符串中的过滤词
	 *
	 */
	public static function setContent($content){
		$pattern ='/1[\d]{10}/'; //一个或多个非数字字符串的正则表达式
		if(preg_match_all($pattern, $content, $matches)){
			foreach ($matches as $match){
				foreach ($match as $m)
				if(strlen($m)>=11)
					$content=str_replace($match,substr_replace($match, '****', 3, 4),$content);
			}
		}
		$banwords=BanWord::where('deny','1')->get();
		foreach ($banwords as $banword){
			$content=str_replace($banword->replacefrom,$banword->replaceto,$content);
		}
		return $content;
	}
}