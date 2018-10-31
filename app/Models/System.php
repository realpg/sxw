<?php

/**
 * Created by PhpStorm.
 * User: HappyQi
 * Date: 2017/9/28
 * Time: 10:19
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class System extends Model
{
//    use SoftDeletes;    //使用软删除
    protected $connection = 'sxwdb';   //数据库名
    protected $table = 'destoon_xcx_system';
    public $timestamps = true;
	protected $primaryKey = 'id';
	public static function deleted($callback)
	{
		return;
	}
//    protected $dates = ['deleted_at'];  //软删除
}