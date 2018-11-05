<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Models\Favorite;

class FavoriteManager
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
		$favorite = new Favorite();
		//这里可以对新建记录进行一定的默认设置
		$favorite->style = '';
		$favorite->thumb = '';
		$favorite->url = '';
		$favorite->note = '';
		$favorite->addtime = time();
		return $favorite;
	}
	
	
	/*
	 * 获取favorite的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
		$favorites = Favorite::orderby('itemid', 'desc')->get();
		return $favorites;
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
		$favorite = Favorite::where('itemid', '=', $id)->first();
		return $favorite;
	}
	
	
	/*
	 * 根据条件数组获取
	 *
	 * By Zhangli
	 *
	 * 2018-04-19
	 */
	public static function getByCon(array $ConArr, $paginate = false, $orderby = ['itemid', 'asc'])
	{
		
		$favorites = Favorite::query()->orderBy($orderby['0'], $orderby['1']);
		
		foreach ($ConArr as $key => $value) {
			$favorites = $favorites->whereIn($key, $value);
		}
		if ($paginate) {
			$favorites = $favorites->paginate(5);
		}
		if (!$paginate)
			$favorites = $favorites->get();
		return $favorites;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setFavorite($favorite, $data)
	{
		if (array_key_exists('mid', $data)) {
			$favorite->mid = array_get($data, 'mid');
		}
		if (array_key_exists('tid', $data)) {
			$favorite->tid = array_get($data, 'tid');
		}
		if (array_key_exists('userid', $data)) {
			$favorite->userid = array_get($data, 'userid');
		}
		return $favorite;
	}
	
	public static function getFavoriteNumber($user){
		$favorites=0;
		$sell_ids=SellManager::getByCon(['userid'=>$user->userid])->pluck('itemid');
		$buy_ids=BuyManager::getByCon(['userid'=>$user->userid])->pluck('itemid');
//		$fjmy_ids=FJMYManager::getByCon(['userid'=>$user->userid])->pluck('itemid');
		$favorites+=FavoriteManager::getByCon(['mid'=>'5','tid'=>$sell_ids])->count();
		$favorites+=FavoriteManager::getByCon(['mid'=>'6','tid'=>$buy_ids])->count();
//		$favorites+=FavoriteManager::getByCon(['mid'=>'88','tid'=>$fjmy_ids])->count();
		return $favorites;
	}
}