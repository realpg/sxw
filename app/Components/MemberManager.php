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
		$member->regtime=time();
		$member->username='xcx'.time().randomSalt();
		$member->passport='xcx'.time().randomSalt();
		$member->passport="新用户";
		$member->passsalt=randomSalt();
		$member->paysalt=randomSalt();
		$member->groupid="5";//普通会员
		$member->note="小程序用户";
		$member->gender=1;
		$member->email=$member->truename='';
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
	
	public static function getXCXMembers()
	{
		$members = Member::query()->whereNotNull('wx_openId')
			->where('wx_openId','<>','')
//			->where('wx_openId', '<>', '')
		->get();
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
	
	public static function getByUsername($username)
	{
		$member = Member::where('username', '=', $username)->first();
		return $member;
	}
	
	public static function getByopenId($id)
	{
		$member = Member::where('wx_openId', '=', $id)->first();
		return $member;
	}
	/*
	 * 根据条件数组获取
	 *
	 * By Zhangli
	 *
	 * 2018-04-19
	 */
	public static function getByCon($ConArr, $paginate = false, $orderby = ['userid', 'asc'])
	{
		$members = Member::orderby($orderby['0'], $orderby['1']);
		if (!$paginate)
			$members = $members->get();
		foreach ($ConArr as $key => $value) {
			$members = $members->whereIn($key, $value);
		}
		if ($paginate) {
			$members = $members->paginate(5);
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
		if (array_key_exists('truename', $data)) {
			$member->truename = array_get($data, 'truename');
			$member->company = array_get($data, 'company');
		}
		if (array_key_exists('company', $data)) {
		
		}
		if (array_key_exists('career', $data)) {
			$member->career = array_get($data, 'career');
		}
		if (array_key_exists('wxqr', $data)) {
			$member->wxqr = array_get($data, 'wxqr');
		}
		return $member;
	}
}