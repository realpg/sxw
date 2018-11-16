<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Models\Member_misc;

class Member_miscManager
{
	/*
	 * 创建新的对象
	 *
	 * by Zhangli
	 *
	 * 2018/07/05
	 */
	public static function createObject(){
		$member_misc=new Member_misc();
		//这里可以对新建记录进行一定的默认设置
		$member_misc->banktype=0;
		$member_misc->send=1;
		$member_misc->branch=$member_misc->reply=$member_misc->black='';
		return $member_misc;
	}
	
	
	/*
	 * 获取member_misc的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
		$member_miscs = Member_misc::orderby('userid', 'desc')->get();
		return $member_miscs;
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
		$member_misc = Member_misc::where('userid', '=', $id)->first();
		if($member_misc==null){
			$member_misc=self::createObject();
			$user=MemberManager::getById($id);
			$member_misc=self::setMember_misc($member_misc,$user);
		}
		return $member_misc;
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
		$member_miscs = Member_misc::query()->orderby($orderby['0'], $orderby['1']);
		
		foreach ($ConArr as $key => $value) {
			if (gettype($value) == 'array')
				$member_miscs = $member_miscs->whereIn($key, $value);
			else
				$member_miscs = $member_miscs->where($key, $value);
		}
		if ($paginate) {
			$member_miscs = $member_miscs->paginate(5);
		}
		if (!$paginate)
			$member_miscs = $member_miscs->get();
		return $member_miscs;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setMember_misc($member_misc, $user)
	{
		$member_misc->userid= $user->userid;
		$member_misc->username= $user->username;
		return $member_misc;
	}
}