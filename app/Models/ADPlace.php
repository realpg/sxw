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

class ADPlace extends Model
{
//    use SoftDeletes;    //使用软删除
    protected $connection = 'sxwdb';   //数据库名
    protected $table = 't_xcx_ad_place';
    public $timestamps = false;
	protected $primaryKey = 'pid';
//    protected $dates = ['deleted_at'];  //软删除
}