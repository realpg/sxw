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
use App\Models\Comment;
//use App\Models\FJMY;
use App\Models\Sell;
use Illuminate\Http\Request;

class CommentManager
{
	/*
	 * 创建新的对象
	 *
	 * by Zhangli
	 *
	 * 2018/07/05
	 */
	public static function createObject(){
		$comment=new Comment();
		//这里可以对新建记录进行一定的默认设置
		$comment->quotation='';
		$comment->reply='';
		$comment->status=3;//默认通过审核
		return $comment;
	}
	
	
	/*
	 * 获取comment的list
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function getList()
	{
		$comments = Comment::orderby('itemid', 'desc')->get();
		return $comments;
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
		$comment = Comment::where('itemid', '=', $id)->first();
		return $comment;
	}
	
	/*
	 * 根据条件数组获取
	 *
	 * By Zhangli
	 *
	 * 2018-04-19
	 */
	public static function getByCon($ConArr, $orderby = ['itemid', 'desc'])
	{
		$comments = Comment::orderby($orderby['0'], $orderby['1'])->get();
		foreach ($ConArr as $key => $value) {
			$comments = $comments->whereIn($key, $value);
		}
		return $comments;
	}
	
	/*
	 * 设置信息，用于编辑
	 *
	 * By Zhangli
	 *
	 * 2018-04-02
	 */
	public static function setComment($comment, $data)
	{
		if (array_key_exists('item_mid', $data)) {
			$comment->item_mid = array_get($data, 'item_mid');
		}
		if (array_key_exists('item_id', $data)) {
			$comment->item_id = array_get($data, 'item_id');
		}
		if (array_key_exists('content', $data)) {
			$comment->content = array_get($data, 'content');
		}
		if (array_key_exists('star', $data)) {
			$comment->star = array_get($data, 'star');
		}
		else{
			$comment->star = 3;
		}
//		if (array_key_exists('qid', $data)) {
//			$comment->qid = array_get($data, 'qid');
//		}
		$comment->addtime=time();
		return $comment;
	}
	
	public static function setUserInfo($comment,$user){
		$comment->username=$user->username;
		$comment->passport=$user->passport;
		return $comment;
	}
	
	public static function setItemInfo($comment,$item){
		$comment->item_title=$item->title;
		$comment->item_username=$item->username;
		return $comment;
	}
	
	public static function getByReceiver($user){
		$sell_itemids=Sell::where('username','=',$user->username)->pluck('itemid');
		$buy_itemids=Buy::where('username','=',$user->username)->pluck('itemid');
//		$fjmy_itemids=FJMY::where('username','=',$user->username)->pluck('itemid');
		$comments=Comment::where(function ($query)use($sell_itemids){
			$query->where('item_mid','=','5')->whereIn('item_id',$sell_itemids);
		})->orWhere(function ($query)use($buy_itemids){
			$query->where('item_mid','=','6')->whereIn('item_id',$buy_itemids);
//		})->orWhere(function ($query)use($fjmy_itemids){
//			$query->where('item_mid','=','88')->whereIn('item_id',$fjmy_itemids);
		})->orderby('itemid', 'desc')->paginate(5);
		return $comments;
	}
	
	public static function getBySender($user){
		$comments=Comment::where('username',$user->username)->orderby('itemid', 'desc')->paginate(5);
		return $comments;
	}
}