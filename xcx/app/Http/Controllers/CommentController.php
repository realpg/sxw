<?php

namespace App\Http\Controllers;


use App\Components\CommentManager;
use App\Components\MemberManager;
use App\Components\TestManager;
use App\Models\Member;
use App\Models\Test;
use Illuminate\Http\Request;


class CommentController extends Controller
{
	
	//评论，开发中
	public function comment(Request $request)
	{
		$data = $request->all();
		if (checkParam($data, ['item_mid', 'item_id', 'content'])) {
			$comment = CommentManager::createObject();
			$comment = CommentManager::setComment($comment, $data);
			
			//获得被评论的信息
			if ($data['item_mid'] == 5) {
				//供应
				$item=5;
			} elseif ($data['item_mid'] == 6) {
				//求购
			}
			else{
				return ApiResponse::makeResponse(false, "参数错误", ApiResponse::MISSING_PARAM);
			}
			
			$comment->save();
			return ApiResponse::makeResponse(true, $comment, ApiResponse::SUCCESS_CODE);
		} else {
			return ApiResponse::makeResponse(false, "缺少参数", ApiResponse::MISSING_PARAM);
		}
		
	}
	
	
}
