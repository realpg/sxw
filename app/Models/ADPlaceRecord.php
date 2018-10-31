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

class ADPlaceRecord extends Model
{
    protected $connection = 'sxwdb';   //数据库名
    protected $table = 'destoon_xcx_adplace_record';
    public $timestamps = false;
	protected $primaryKey = 'id';
}