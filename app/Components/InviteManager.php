<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Models\Invite;

class InviteManager
{
	/*
	 * 创建新的对象
	 *
	 * by Zhangli
	 *
	 * 2018/07/05
	 */
	public static function createObject(){
		$invite=new Invite();
		//这里可以对新建记录进行一定的默认设置
		
		return $invite;
	}
	
	
	/*
	 * 获取invite的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
		$invites = Invite::orderby('id', 'desc')->get();
		return $invites;
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
		$invite = Invite::where('id', '=', $id)->first();
		return $invite;
	}
	public static function getByUserid($id)
	{
		$invite = Invite::where('userid', '=', $id)->first();
		return $invite;
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
		
		$invites = Invite::orderby($orderby['0'], $orderby['1']);
		if (!$paginate)
			$invites = $invites->get();
		foreach ($ConArr as $key => $value) {
			$invites = $invites->whereIn($key, $value);
		}
		if ($paginate) {
			$invites = $invites->paginate(5);
		}
		return $invites;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setInvite($invite, $inviter,$user)
	{
		$invite->inviter_userid=$inviter->userid;
		$invite->userid=$user->userid;
		$invite->credit=SystemManager::getById('11')->value;
		return $invite;
	}
}