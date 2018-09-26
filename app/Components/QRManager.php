<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2018/9/25
 * Time: 16:56
 */

namespace App\Components;


use App\Http\Controllers\LoginController;
use App\Models\QR;

class QRManager
{
	public static function getInviteQRByUserid($userid){
		$qr=QR::where('userid',$userid)->where('type','0')->first();
		if(!$qr){
			$qr = new QR();
			$qr->userid=$userid;
			$qr->type=0;
			$qr->qr_url=LoginController::getXCXQR(MemberManager::getById($userid));
			$qr->save();
		}
		return $qr;
	}
	
	public static function getCardQRByUserid($userid){
		$qr=QR::where('userid',$userid)->where('type','1')->first();
		if(!$qr){
			$qr = new QR();
			$qr->userid=$userid;
			$qr->type=1;
			$qr->qr_url=self::getCardQR(MemberManager::getById($userid));
			$qr->save();
		}
		return $qr;
	}
	
	public static function getCardQR($user)
	{
		$avatarUrl = $user->avatarUrl;
		
		//获得二维码
		$QR = LoginController::getXCXQR($user, 'pages/store_particulars/store_particulars');
//		$file_code_name = "21" . time() . ".png";
//		file_put_contents($file_code_name, $QR);//保存到本地
		$file_code_name=downloadImage($QR);
		
		if(!$avatarUrl){
			//没有头像使用默认二维码
			return $QR;
		}
		//保存原始头像
		$img_file = file_get_contents($avatarUrl);
		$img_content = base64_encode($img_file);
		$ext = pathinfo($img_file);
		$file_tou_name = time() . ".".$ext['extension'];
		$headurl = $file_tou_name;
		file_put_contents($file_tou_name, base64_decode($img_content));
		
		//编辑已保存的原头像，保存成圆形（其实不是圆形，改变它的边角为透明）。
		$imgg = self::yuan_img($headurl);     //yuan_img() 方法在文末会列出
		$file_name = "22" . time() . ".png";
		imagepng($imgg, $file_name);
		imagedestroy($imgg);
		
		//缩小头像（原图为1080，430的小程序码logo为192）
		$target_im = imagecreatetruecolor(192, 192);
		//创建一个新的画布（缩放后的），从左上角开始填充透明背景
		imagesavealpha($target_im, true);
		$trans_colour = imagecolorallocatealpha($target_im, 0, 0, 0, 127);
		imagefill($target_im, 0, 0, $trans_colour);
		$o_image = imagecreatefrompng($file_name);
		//获取上文已保存的修改之后头像的内容
		$o_w=getimagesize($file_name)[0];
		$o_h=getimagesize($file_name)[1];
		imagecopyresampled($target_im, $o_image, 0, 0, 0, 0, 192, 192, $o_w, $o_h);
		$file_head_name = "23" . time() . ".png";
		$comp_path = $file_head_name;
		imagepng($target_im, $comp_path);
		imagedestroy($target_im);
		
		//所有准备条件都好了。进行拼接。
		//传入保存后的二维码地址
//		return [$file_code_name, $comp_path];
		$url = self::create_pic_watermark($file_code_name, $comp_path, "center");  //方法文末列出
		return $url;
//		$arr = array('ret' => 1, 'msg' => 'success', 'data' => array('url' => $url),
//			//处理完的新小程序码 保存在服务器，传回地址给小程序端即可
//		);echo json_encode($arr);
	}
	
	/** * [yuan_img 编辑图片为圆形]  剪切头像为圆形 * @param  [string] $imgpath [头像保存之后的图片名] */
	static function yuan_img($imgpath)
	{
		$ext = pathinfo($imgpath);
		$src_img = null;
		switch ($ext['extension']) {
			case 'jpg':
				$src_img = imagecreatefromjpeg($imgpath);
				break;
			case 'png':
				$src_img = imagecreatefrompng($imgpath);
				break;
		}
		$wh = getimagesize($imgpath);
		$w = $wh[0];
		$h = $wh[1];
		$w = min($w, $h);
		$h = $w;
		$img = imagecreatetruecolor($w, $h);
		//这一句一定要有
		imagesavealpha($img, true);
		//拾取一个完全透明的颜色,最后一个参数127为全透明
		$bg = imagecolorallocatealpha($img, 255, 255, 255, 127);
		imagefill($img, 0, 0, $bg);
		$r = $w / 2;
		//圆半径
		$y_x = $r; //圆心X坐标
		$y_y = $r; //圆心Y坐标
		for ($x = 0; $x < $w; $x++) {
			for ($y = 0; $y < $h; $y++) {
				$rgbColor = imagecolorat($src_img, $x, $y);
				if (((($x - $r) * ($x - $r) + ($y - $r) * ($y - $r)) < ($r * $r))) {
					imagesetpixel($img, $x, $y, $rgbColor);
				}
			}
		}
		return $img;
	}
	
	/**
	 * [create_pic_watermark 添加图片水印]  头像贴在二维码中间
	 * @param  [string] $dest_image [需要添加图片水印的图片名]
	 * @param  [string] $watermark  [水印图片名]
	 * @param  [string] $locate     [水印位置，center,left_buttom,right_buttom三选一]
	 * @return [type]             [description]
	 */
	static function create_pic_watermark($dest_image, $watermark, $locate)
	{
		list($dwidth, $dheight, $dtype) = getimagesize($dest_image);
		list($wwidth, $wheight, $wtype) = getimagesize($watermark);
		$types = array(1 => "GIF", 2 => "JPEG", 3 => "PNG",
			4 => "SWF", 5 => "PSD", 6 => "BMP",
			7 => "TIFF", 8 => "TIFF", 9 => "JPC",
			10 => "JP2", 11 => "JPX", 12 => "JB2",
			13 => "SWC", 14 => "IFF", 15 => "WBMP", 16 => "XBM");
		$dtype = strtolower($types[$dtype]);//原图类型
		$wtype = strtolower($types[$wtype]);//水印图片类型
		$created = "imagecreatefrom" . $dtype;
		$createw = "imagecreatefrom" . $wtype;
		$imgd = $created($dest_image);
		$imgw = $createw($watermark);
		switch ($locate) {
			case 'center':
				$x = ($dwidth - $wwidth) / 2;
				$y = ($dheight - $wheight) / 2;
				break;
			case 'left_buttom':
				$x = 1;
				$y = ($dheight - $wheight - 2);
				break;
			case 'right_buttom':
				$x = ($dwidth - $wwidth - 1);
				$y = ($dheight - $wheight - 2);
				break;
			default:
				die("未指定水印位置!");
				break;
		}
		imagecopy($imgd, $imgw, $x, $y, 0, 0, $wwidth, $wheight);
		$save = "image" . $dtype;
		//保存到服务器
		$f_file_name = "24" . time() . ".png";
		imagepng($imgd, $f_file_name); //保存
		imagedestroy($imgw);
		imagedestroy($imgd);
		//传回处理好的图片
		$url = qiniu_upload($f_file_name, 'cardqr');  //调用的全局函数
//		$url = 'https://www.qubaobei.com/'.str_replace('/opt/ci123/www/html/markets/app2/baby/','',$f_file_name);
		return $url;
	}
	
}