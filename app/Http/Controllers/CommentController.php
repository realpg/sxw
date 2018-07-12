<?php

namespace App\Http\Controllers;


use App\Components\BuyManager;
use App\Components\CommentManager;
use App\Components\MemberManager;
use App\Components\TestManager;
use App\Models\Member;
use App\Models\Test;
use Illuminate\Http\Request;


class CommentController extends Controller
{
	
	//评论，开发中
	/*
	 *
	 * mid=6已完成，等待补完mid=5
	 *
	 * 暂不支持回复、引用
	 *
	 * 2018/7/12
	 */
	public function comment(Request $request)
	{
		$data = $request->all();
		$user = MemberManager::getById($data['userid']);
		if (checkParam($data, ['item_mid', 'item_id', 'content'])) {
			$comment = CommentManager::createObject();
			$comment = CommentManager::setComment($comment, $data);
			$comment = CommentManager::setUserInfo($comment, $user);
			
			$item = null;
			//获得被评论的信息
			if ($data['item_mid'] == 5) {
				//供应
//				$item=5;
			} elseif ($data['item_mid'] == 6) {
				//求购
				$item = BuyManager::getById($data['item_id']);
			}
			if ($item) {
				$comment = CommentManager::setItemInfo($comment, $item);
			} else {
				return ApiResponse::makeResponse(false, "参数错误", ApiResponse::MISSING_PARAM);
			}
			
			$comment->save();
			return ApiResponse::makeResponse(true, $comment, ApiResponse::SUCCESS_CODE);
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
		
	}
	
	
	/*
	 * 点赞功能
	 *
	 * mid=6已完成，等待补完mid=5
	 *
	 * 2018/7/12
	 */
	public static function agree(Request $request)
	{
		$data = $request->all();
		//检验参数
		if (checkParam($data, ['item_mid', 'item_id'])) {
			$ret="请求成功";
			$item = null;
			//获得被评论的信息
			if ($data['item_mid'] == 5) {
				//供应
//				$item=5;
			} elseif ($data['item_mid'] == 6) {
				//求购
				$item = BuyManager::getById($data['item_id']);
			}
			if ($item) {
				$item->agree++;
				$item->save();
			} else {
				return ApiResponse::makeResponse(false, "参数错误", ApiResponse::MISSING_PARAM);
			}
			return ApiResponse::makeResponse(true, $item, ApiResponse::SUCCESS_CODE);
			
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
}
