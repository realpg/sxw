<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Models\Tag;

class TagManager
{
	/*
	 * 创建新的对象
	 *
	 * by Zhangli
	 *
	 * 2018/07/05
	 */
	public static function createObject(){
		$tag=new Tag();
		//这里可以对新建记录进行一定的默认设置
		
		return $tag;
	}
	
	
	/*
	 * 获取tag的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
		$tags = Tag::orderby('tagid', 'desc')->get();
		return $tags;
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
		$tag = Tag::where('tagid', '=', $id)->first();
		return $tag;
	}
	
	/*
	 * 根据条件数组获取
	 *
	 * By Zhangli
	 *
	 * 2018-07-18
	 */
	public static function getByCon(array $ConArr, $paginate = false, $orderby = ['tagid', 'asc'])
	{
		
		$tags = Tag::orderby($orderby['0'], $orderby['1']);
		if (!$paginate)
			$tags = $tags->get();
		foreach ($ConArr as $key => $value) {
			$tags = $tags->whereIn($key, $value);
		}
		if ($paginate) {
			$tags = $tags->paginate(5);
		}
		return $tags;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setTag($tag, $data)
	{
		if (array_key_exists('moduleid', $data)) {
			$tag->moduleid = array_get($data, 'moduleid');
		}
		if (array_key_exists('tagname', $data)) {
			$tag->tagname = array_get($data, 'tagname');
		}
		if (array_key_exists('desc', $data)) {
			$tag->desc = array_get($data, 'desc');
		}
		if (array_key_exists('listorder', $data)) {
			$tag->listorder = array_get($data, 'listorder');
		}
		if (array_key_exists('status', $data)) {
			$tag->status = array_get($data, 'status');
		}
		else{
			$tag->status = 0;
		}
		return $tag;
	}
}