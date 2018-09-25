<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classification extends Model
{
    protected $table = "classification";
    
    // 返回软件分类
    static function sortlist()
    {   
        return $sort_list = self::get();
    }
}   
