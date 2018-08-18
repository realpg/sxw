<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Models\Message;

class MessageManager
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
		$message = new Message();
		//这里可以对新建记录进行一定的默认设置
		$message->typeid=4;
		$message->addtime=time();
		$message->status=3;
		return $message;
	}
	
	
	/*
	 * 获取message的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
		$messages = Message::orderby('itemid', 'desc')->get();
		return $messages;
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
		$message = Message::where('itemid', '=', $id)->first();
		return $message;
	}
	
	/*
	 * 根据条件数组获取
	 *
	 * By Zhangli
	 *
	 * 2018-07-18
	 */
	public static function getByCon(array $ConArr, $paginate = false, $orderby = ['itemid', 'asc'])
	{
		
		$messages = Message::orderby($orderby['0'], $orderby['1']);
		if (!$paginate)
			$messages = $messages->get();
		foreach ($ConArr as $key => $value) {
			$messages = $messages->whereIn($key, $value);
		}
		if ($paginate) {
			$messages = $messages->paginate(5);
		}
		return $messages;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setMessage($message, $data)
	{
		if (array_key_exists('title', $data)) {
			$message->title = array_get($data, 'title');
		}
		if (array_key_exists('content', $data)) {
			$message->content = array_get($data, 'content');
		}
		if (array_key_exists('touser', $data)) {
			$message->touser = array_get($data, 'touser');
		}
		if (array_key_exists('groupids', $data)) {
			$message->groupids = array_get($data, 'groupids');
		}
		return $message;
	}
	
	public static function getByUserid($userid)
	{
		$user = MemberManager::getById($userid);
		$messages = Message::where('touser', '=', $user->username)
			->orWhere('groupids', 'like', '%,' . $user->groupid . "%")
			->orWhere('groupids', 'like', '%' . $user->groupid . ',')
			->orWhere('groupids', '=', '%' . $user->groupid . "%")
			->get();
		return $messages;
	}
}