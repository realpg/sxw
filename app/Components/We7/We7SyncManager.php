<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components\We7;

use App\Components\CompanyManager;
use App\Http\Controllers\CreditController;
use App\Models\FinanceCredit;
use App\Models\We7\We7Sync;

class We7SyncManager
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
		$sync = new We7Sync();
		//这里可以对新建记录进行一定的默认设置
		
		return $sync;
	}
	
	
	/*
	 * 获取sync的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
		$syncs = We7Sync::orderby('id', 'desc')->get();
		return $syncs;
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
		$sync = We7Sync::where('id', '=', $id)->first();
		return $sync;
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
		
		$syncs = We7Sync::orderby($orderby['0'], $orderby['1']);
		if (!$paginate)
			$syncs = $syncs->get();
		foreach ($ConArr as $key => $value) {
			$syncs = $syncs->whereIn($key, $value);
		}
		if ($paginate) {
			$syncs = $syncs->paginate(5);
		}
		return $syncs;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setWe7Sync($sync, $data)
	{
		if (array_key_exists('name', $data)) {
			$sync->name = array_get($data, 'name');
		}
		return $sync;
	}
	
	public static function syncFromWe7($sync, $we7record)
	{
		$dtUser = We7UserManager::getDTUserByWe7uid($we7record->uid);
		if (!$dtUser) {
			return false;
		}
		$financeCredit = CreditController::changeCredit([
			'userid' => $dtUser->userid,
			'amount' => (int)$we7record->num,
			'reason' => $we7record->remark,
			'note' => '来自微擎同步,同步时间' . date("Y/m/d h:i:sa")]);
		if (!$financeCredit) {
			return false;
		}
		
//		$financeCredit = FinanceCredit::where('userid',$financeCredit->userid)
//			->where('note',$financeCredit->note)
//			->first();
		$sync->we7_itemid = $we7record->id;
		$sync->dt_itemid = $financeCredit->itemid;
		$sync->stream = 2;
		$sync->time = time();
		return $sync;
	}
	
	public static function lastSyncTime()
	{
		$time = We7Sync::where('stream', 2)->max('time')or 0;
		if (!$time)
			$time = 0;
		return $time;
	}
}