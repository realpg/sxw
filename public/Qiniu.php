<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2018/3/19
 * Time: 9:41
 */
require_once __DIR__ . '/../vendor/qiniu/php-sdk/autoload.php';

//qiniu上传的sdk文件夹放在vendor文件夹下
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use Qiniu\Storage\BucketManager;

// AK和SK，和上传空间要在该页面设置，AK和SK和bucket名字要上七牛才能看见

$accessKey = '1VVJrwVbM3WdXdfc0385cJKZ3poGO0dqoFzd53mx';
$secretKey = '3PTbt92XIaRtB4b36t7ubnPKVxzyUS3aW1mC6Ew0';
$bucket = 'twst';
$prePath = 'lib/uploads/images/';//上传目录名

global $accessKey;
global $secretKey;
global $bucket;
global $prePath;

// 上传至七牛
function uptoQiniu($pic = null)
{
	//参数：文件名
	
	
	global $accessKey;
	global $secretKey;
	// 构建鉴权对象
	$auth = new Auth($accessKey, $secretKey);
	
	global $bucket;
	// 生成上传 Token
	$token = $auth->uploadToken($bucket);
	// echo $token;exit();
	// 要上传文件的本地路径$filePath
	global $prePath;
	$filePath = $prePath . $pic;
	// 上传到七牛后保存的文件名$key
	$key = $pic;
	
	// 初始化 UploadManager 对象并进行文件的上传
	$uploadMgr = new UploadManager();
	
	// 调用 UploadManager 的 putFile 方法进行文件的上传
	list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
	// echo "\n====> putFile result: \n";
	// if ($err !== null) {
	//     var_dump($err);
	// } else {
	//     var_dump($ret);
	// }
	
}

// 从七牛删除
function deleteFromQiniu($key = null)
{
	// 参数$key为要删除的文件名
	global $accessKey;
	global $secretKey;
	
	//初始化Auth状态
	$auth = new Auth($accessKey, $secretKey);
	
	//初始化BucketManager
	$bucketMgr = new BucketManager($auth);
	
	//你要测试的空间， 并且这个key在你空间中存在
	global $bucket;
	
	//删除$bucket 中的文件 $key
	$err = $bucketMgr->delete($bucket, $key);
	echo "\n====> delete $key : \n";
	if ($err !== null) {
		var_dump($err);
	} else {
		echo "Success!";
	}
}
//双参数版
function uptoQiniuDouble($picFrom, $pic)
{
	//参数1：文件地址，参数2：文件名
	
	
	global $accessKey;
	global $secretKey;
	// 构建鉴权对象
	$auth = new Auth($accessKey, $secretKey);
	
	
	global $bucket;
	// 生成上传 Token
	$token = $auth->uploadToken($bucket);
	// echo $token;exit();
	// 要上传文件的本地路径$filePath
	
	$filePath = $picFrom;
	// 上传到七牛后保存的文件名$key
	$key = $pic;
	
	
	// 初始化 UploadManager 对象并进行文件的上传
	$uploadMgr = new UploadManager();
	
	
	// 调用 UploadManager 的 putFile 方法进行文件的上传
	list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
	// echo "\n====> putFile result: \n";
	// if ($err !== null) {
	//   var_dump($err);
	// } else {
	//   var_dump($ret);
	// }
	
	
}

