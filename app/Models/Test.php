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

class Test extends Model
{
    use SoftDeletes;    //使用软删除
    protected $connection = 'testdb';   //慢病管理数据库名
    protected $table = 'user';
    public $timestamps = true;
    protected $dates = ['deleted_at'];  //软删除
}