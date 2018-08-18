<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Models\Template;

class TemplateManager
{
	/*
	 * 创建新的对象
	 *
	 * by Zhangli
	 *
	 * 2018/07/05
	 */
	public static function createObject(){
		$template=new Template();
		//这里可以对新建记录进行一定的默认设置
		
		return $template;
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
		$templates = Template::orderby('id', 'desc')->get();
		return $templates;
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
		$template = Template::where('id', '=', $id)->first();
		return $template;
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
		
		$templates = Template::orderby($orderby['0'], $orderby['1']);
		if (!$paginate)
			$templates = $templates->get();
		foreach ($ConArr as $key => $value) {
			$templates = $templates->whereIn($key, $value);
		}
		if ($paginate) {
			$templates = $templates->paginate(5);
		}
		return $templates;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setTemplate($template, $data)
	{
		if (array_key_exists('name', $data)) {
			$template->name = array_get($data, 'name');
		}
		return $template;
	}
}