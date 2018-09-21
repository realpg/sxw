<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2018/8/29
 * Time: 10:51
 */

// 引入鉴权类
use Qiniu\Auth;
// 引入上传类
use Qiniu\Storage\UploadManager;
use Qiniu\Storage\BucketManager;

function qiniu_upload($filePath, $floder = null)
{


// 需要填写你的 Access Key 和 Secret Key
	$accessKey = "1VVJrwVbM3WdXdfc0385cJKZ3poGO0dqoFzd53mx";
	$secretKey = "3PTbt92XIaRtB4b36t7ubnPKVxzyUS3aW1mC6Ew0";
	$bucket = "chinayarn";

// 构建鉴权对象
	$auth = new Auth($accessKey, $secretKey);

// 生成上传 Token
	$token = $auth->uploadToken($bucket);

// 要上传文件的本地路径
//    $filePath = './php-logo.png';

// 上传到七牛后保存的文件名
	$key = basename($filePath);
	if ($floder !== null) {
		$key = basename($floder . '/' . $filePath);
	}

// 初始化 UploadManager 对象并进行文件的上传。
	$uploadMgr = new UploadManager();

// 调用 UploadManager 的 putFile 方法进行文件的上传。
	$uploadMgr->putFile($token, $key, $filePath);
//删除本地图片
	unlink($filePath);
	
	//初始化BucketManager
	$bucketMgr = new BucketManager($auth);
	
	$domains = $bucketMgr->domains($bucket);
	
	$url = $domains[0] ? 'http://' . $domains[0][0] . '/' . $key : null;
	
	return $url;
}

function getFileUrl($filePath)
{

}
//作者：荆棘路上的猴子
//链接：https://www.jianshu.com/p/c66bb4c68c4f
//來源：简书
//简书著作权归作者所有，任何形式的转载都请联系作者获得授权并注明出处。