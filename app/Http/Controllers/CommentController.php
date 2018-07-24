<?php

namespace App\Http\Controllers;


use App\Components\AgreeManager;
use App\Components\BuyManager;
use App\Components\CommentManager;
use App\Components\FavoriteManager;
use App\Components\MemberManager;
use App\Components\SellManager;
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
				$item = SellManager::getById($data['item_id']);
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
		$user = MemberManager::getById($data['userid']);
		//检验参数
		if (checkParam($data, ['item_mid', 'item_id'])) {
			$ret = "请求成功";
			$item = null;
			//获得被评论的信息
			if ($data['item_mid'] == 5) {
				//供应
				$item = SellManager::getById($data['item_id']);
//				$item=5;
			} elseif ($data['item_mid'] == 6) {
				//求购
				$item = BuyManager::getById($data['item_id']);
			}
			if ($item) {
				$agree = AgreeManager::createObject();
				$agree = AgreeManager::setAgree($agree, $data, $item);
				$agree = AgreeManager::setUserInfo($agree, $user);
				$agree->addtime = time();
				$item->agree++;
				$agree->save();
				$item->save();
				
			} else {
				return ApiResponse::makeResponse(false, "参数错误", ApiResponse::MISSING_PARAM);
			}
			return ApiResponse::makeResponse(true, $item, ApiResponse::SUCCESS_CODE);
			
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
	public static function favorite(Request $request)
	{
		$data = $request->all();
		$user = MemberManager::getById($data['userid']);
		
		//检验参数
		if (checkParam($data, ['mid', 'tid'])) {
			$ret = "关注成功";
			$item = null;
			//获得被评论的信息
			if ($data['mid'] == 5) {
				//供应
				$item = SellManager::getById($data['tid']);
//				$item=5;
			} elseif ($data['mid'] == 6) {
				//求购
				$item = BuyManager::getById($data['tid']);
			}
			
			if ($item) {
				$favorite = FavoriteManager::getByCon(['mid' => $data['mid'], 'tid' => $data['tid'], 'userid' => $data['userid']])->first();
				if (array_key_exists('cancle', $data)) {
					if ($favorite) {
						$favorite->delete();
						return ApiResponse::makeResponse(true, "取消成功", ApiResponse::SUCCESS_CODE);
					} else {
						return ApiResponse::makeResponse(false, "没有关注记录", ApiResponse::UNKNOW_ERROR);
					}
				}
				$favorite = $favorite ? $favorite : FavoriteManager::createObject();
				$favorite = FavoriteManager::setFavorite($favorite, $data);
				$item->favorite++;
				$favorite->save();
				$item->save();
			} else {
				return ApiResponse::makeResponse(false, "参数错误", ApiResponse::MISSING_PARAM);
			}
			
			return ApiResponse::makeResponse(true, $ret, ApiResponse::SUCCESS_CODE);
			
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
	}
	
	public static function myFavorite(Request $request)
	{
		$data = $request->all();
		$myFavorites = FavoriteManager::getByCon(['userid' => [$data['userid']]], true);
		foreach ($myFavorites as $favorite) {
			switch ($favorite->mid) {
				case '5':
					$favorite->item = SellManager::getById($favorite->tid);
					break;
				case '6':
					$favorite->item = BuyManager::getById($favorite->tid);
					break;
				default:
					break;
			}
		}
		return ApiResponse::makeResponse(true, $myFavorites, ApiResponse::SUCCESS_CODE);
	}
	
}
