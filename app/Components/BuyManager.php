<?php

/**
 * Created by PhpStorm.
 * User: Zhangli
 * Date: 2018-04-02
 * Time: 10:30
 * 模版Manager
 */

namespace App\Components;

use App\Models\Buy;
use App\Models\Buy_data;

class BuyManager
{
	/*
	 * 创建新的对象
	 *
	 * by Zhangli
	 *
	 * 2018/07/05
	 */
	public static function createObject(){
		$buy=new Buy();
		//这里可以对新建记录进行一定的默认设置
		$buy->catid=2;//默认值
		$buy->typeid=1;//默认值
		$buy->n1=$buy->n2=$buy->n3='';
		$buy->v1=$buy->v2=$buy->v3='';
		$buy->thumbs='';
		$buy->vip=0;
		$buy->validated=0;
		$buy->editdate=$buy->adddate=date("Y-m-d");
		$buy->addtime=time();
		$buy->template='';
		$buy->status=3;
		
		return $buy;
	}
	
	public static function setUserInfo($buy,$user_id){
		$member=MemberManager::getById($user_id);
		$buy->username=$member->username;
		$buy->groupid=$member->groupid;
		$buy->company=$member->company;
		$buy->truename=$member->truename;
		$buy->telephone=$member->telephone;
		$buy->mobile=$member->mobile;
		$buy->address=$member->address?$member->address:"未知";
		$buy->email=$member->email;
		$buy->qq=$member->qq;
		$buy->wx=$member->wx;
		$buy->ali=$member->ali;
		$buy->skype=$member->skype;
		return $buy;
	}
	
	/*
	 * 获取buy的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
		$buys = Buy::orderby('id', 'desc')->get();
		return $buys;
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
		$buy = Buy::where('id', '=', $id)->first();
		return $buy;
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
		$buys = Buy::orderby($orderby['0'], $orderby['1'])->get();
		foreach ($ConArr as $key => $value) {
			$buys = $buys->whereIn($key, $value);
		}
		return $buys;
	}
	
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setBuy($buy, $data)
	{
		if (array_key_exists('title', $data)) {
			$buy->title = array_get($data, 'title');
		}
		if (array_key_exists('introduce', $data)) {
			$buy->introduce = array_get($data, 'introduce');
		}
		if (array_key_exists('amount', $data)) {
			$buy->amount = array_get($data, 'amount');
		}
		if (array_key_exists('price', $data)) {
			$buy->price = array_get($data, 'price');
		}
		if (array_key_exists('pack', $data)) {
			$buy->pack = array_get($data, 'pack');
		}
		if (array_key_exists('thumb', $data)) {
			$buy->thumb = array_get($data, 'thumb');
		}
		if (array_key_exists('telephone', $data)) {
			$buy->telephone = array_get($data, 'telephone');
		}
		$buy->keyword=$buy->title.','.'求购'.'求购分类';//*****需要改动*****
		$buy->editor=MemberManager::getById($data['userid'])->username;
		$buy->editdate=date("Y-m-d");
		$buy->edittime=time();
		
		return $buy;
	}
}