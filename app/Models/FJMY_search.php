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

class FJMY_search extends Model
{
//    use SoftDeletes;    //使用软删除
    protected $connection = 'sxwdb';   //慢病管理数据库名
    protected $table = 't_fjmy_search_88';
    public $timestamps = false;
	protected $primaryKey = 'itemid';
//    protected $dates = ['deleted_at'];  //软删除
}