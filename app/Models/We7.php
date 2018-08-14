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

class We7 extends Model
{
//    use SoftDeletes;    //使用软删除
    protected $connection = 'sxwdb';   //数据库名
    protected $table = 't_we7';
    public $timestamps = false;
	protected $primaryKey = 'we7_uid';
//    protected $dates = ['deleted_at'];  //软删除
}