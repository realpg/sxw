<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Models\AD;

class ADManager
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
		$ad = new AD();
		//这里可以对新建记录进行一定的默认设置
		
		return $ad;
	}
	
	
	/*
	 * 获取ad的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
		$ads = AD::orderby('itemid', 'desc')->get();
		return $ads;
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
		$ad = AD::where('itemid', '=', $id)->first();
		return $ad;
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
		
		$ads = AD::orderby($orderby['0'], $orderby['1']);
		if (!$paginate)
			$ads = $ads->get();
		foreach ($ConArr as $key => $value) {
			$ads = $ads->whereIn($key, $value);
		}
		if ($paginate) {
			$ads = $ads->paginate();
		}
		return $ads;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setAD($ad, $data)
	{
		if (array_key_exists('desc', $data)) {
			$ad->desc = array_get($data, 'desc');
		}
		if (array_key_exists('xcx_pid', $data)) {
			$ad->xcx_pid = array_get($data, 'xcx_pid');
		}
		if (array_key_exists('amount0', $data)) {
			$ad->amount0 = array_get($data, 'amount0');
		}
		if (array_key_exists('amount1', $data)) {
			$ad->amount1 = array_get($data, 'amount1');
		}
		if (array_key_exists('amount2', $data)) {
			$ad->amount2 = array_get($data, 'amount2');
		}
		if (array_key_exists('druation0', $data)) {
			$ad->druation0 = array_get($data, 'druation0')*86400;
		}
		if (array_key_exists('druation1', $data)) {
			$ad->druation1 = array_get($data, 'druation1')*86400;
		}
		if (array_key_exists('druation2', $data)) {
			$ad->druation2 = array_get($data, 'druation2')*86400 ;
		}
		if (array_key_exists('type', $data)) {
			$ad->type = array_get($data, 'type');
		}
		if (array_key_exists('linktype', $data)) {
			$ad->linktype = array_get($data, 'linktype');
		}
		if (array_key_exists('img', $data)) {
			$ad->img = array_get($data, 'img');
		}
		if (array_key_exists('userid', $data)) {
			$ad->userid = array_get($data, 'userid');
		}
		if (array_key_exists('item_mid', $data)) {
			$ad->item_mid = array_get($data, 'item_mid');
		}
		if (array_key_exists('item_id', $data)) {
			$ad->item_id = array_get($data, 'item_id');
		}
		if (array_key_exists('url', $data)) {
			$ad->url = array_get($data, 'url');
		}
		if (array_key_exists('fromtime', $data)) {
			$ad->fromtime = strtotime(array_get($data, 'fromtime'));
		}
		if (array_key_exists('totime', $data)) {
			$ad->totime = strtotime(array_get($data, 'totime'));
		}
		
		$ad->stat = array_get($data, 'stat') ? array_get($data, 'stat') : '0';
		
		if (array_key_exists('listorder', $data)) {
			$ad->listorder = array_get($data, 'listorder');
		}
		$ad->status = array_get($data, 'status') ? array_get($data, 'status') : '0';
		$ad->onsell = array_get($data, 'onsell') ? array_get($data, 'onsell') : '0';
		return $ad;
	}
}