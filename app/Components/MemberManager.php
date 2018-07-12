<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Models\Member;

class MemberManager
{
	/*
	 * 创建新的对象
	 *
	 * by Zhangli
	 *
	 * 2018/07/05
	 */
	public static function createObject(){
		$member=new Member();
		$member->username='xcx'.time().randomSalt();
		$member->passport='xcx'.time().randomSalt();
		$member->passsalt=randomSalt();
		$member->paysalt=randomSalt();
		$member->groupid="5";//普通会员
		$member->note="小程序用户";
		return $member;
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
		$members = Member::get();
		return $members;
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
		$member = Member::where('userid', '=', $id)->first();
		return $member;
	}
	
	/*
	 * 根据条件数组获取
	 *
	 * By Zhangli
	 *
	 * 2018-04-19
	 */
	public static function getByCon($ConArr, $orderby = ['id', 'asc'])
	{
		$members = Member::orderby($orderby['0'], $orderby['1'])->get();
		foreach ($ConArr as $key => $value) {
			$members = $members->whereIn($key, $value);
		}
		return $members;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setMember($member, $data)
	{
		if (array_key_exists('name', $data)) {
			$member->name = array_get($data, 'name');
		}
		return $member;
	}
}