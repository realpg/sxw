<?php

/**
 * Created by PhpStorm.
 * User: HappyQi
 * Date: 2017/9/28
 * Time: 10:19
 */
namespace App\Models\We7;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class We7Member extends Model
{
//    use SoftDeletes;    //使用软删除
    protected $connection = 'we7db';   //数据库名
    protected $table = 'ims_mc_members';
    public $timestamps = false;
	protected $primaryKey = 'uid';
//    protected $dates = ['deleted_at'];  //软删除
}