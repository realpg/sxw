<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Models\Upgrade;

class UpgradeManager
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
		$upgrade = new Upgrade();
		//这里可以对新建记录进行一定的默认设置
		$upgrade->reason = '';
		$upgrade->note = '';
		$upgrade->message=1;
		$upgrade->status=2;
		$upgrade->ip='0.0.0.0';
		return $upgrade;
	}
	
	
	/*
	 * 获取upgrade的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
		$upgrades = Upgrade::orderby('itemid', 'desc')->get();
		return $upgrades;
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
		$upgrade = Upgrade::where('itemid', '=', $id)->first();
		return $upgrade;
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
		
		$upgrades = Upgrade::orderby($orderby['0'], $orderby['1']);
		
		foreach ($ConArr as $key => $value) {
			$upgrades = $upgrades->whereIn($key, $value);
		}
		if ($paginate) {
			$upgrades = $upgrades->paginate(5);
		}
		if (!$paginate)
			$upgrades = $upgrades->get();
		return $upgrades;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setUpgrade($upgrade, $member)
	{
		$upgrade->userid = $member->userid;
		$upgrade->username = $member->username;
		$upgrade->gid = $member->groupid;
		$upgrade->company = $member->company;
		$upgrade->addtime = time();
		return $upgrade;
	}
}