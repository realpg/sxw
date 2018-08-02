<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Models\FinanceCredit;

class FinanceCreditManager
{
	/*
	 * 创建新的对象
	 *
	 * by Zhangli
	 *
	 * 2018/07/05
	 */
	public static function createObject(){
		$financeCredit=new FinanceCredit();
		//这里可以对新建记录进行一定的默认设置
		$financeCredit->editor='xcx_system';
		return $financeCredit;
	}
	
	
	/*
	 * 获取financeCredit的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
		$financeCredits = FinanceCredit::orderby('itemid', 'desc')->get();
		return $financeCredits;
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
		$financeCredit = FinanceCredit::where('itemid', '=', $id)->first();
		return $financeCredit;
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
		
		$financeCredits = FinanceCredit::orderby($orderby['0'], $orderby['1']);
		if (!$paginate)
			$financeCredits = $financeCredits->get();
		foreach ($ConArr as $key => $value) {
			if ($key == 'start_time') {
				$financeCredits = $financeCredits->where('addtime', '>', $value);
			} else
			$financeCredits = $financeCredits->whereIn($key, $value);
		}
		if ($paginate) {
			$financeCredits = $financeCredits->paginate();
		}
		return $financeCredits;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setFinanceCredit($financeCredit, $data)
	{
		$user = MemberManager::getById(array_get($data, 'userid'));
		$financeCredit->username = $user->username;
		
		if (array_key_exists('amount', $data)) {
			$financeCredit->amount = array_get($data, 'amount');
		}
		if (array_key_exists('balance', $data)) {
			$financeCredit->balance = array_get($data, 'balance');
		}
			$financeCredit->addtime = time();
		if (array_key_exists('reason', $data)) {
			$financeCredit->reason = array_get($data, 'reason');
		}
		if (array_key_exists('note', $data)) {
			$financeCredit->note = array_get($data, 'note');
		}
		if (array_key_exists('ranking', $data)) {
			$financeCredit->ranking = array_get($data, 'ranking');
		}
		
		return $financeCredit;
	}
}