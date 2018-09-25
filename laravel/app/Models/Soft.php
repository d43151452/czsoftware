<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Soft extends Model
{
    protected $table = "software";

    // 总排行
    static function hotlist()
    {
        return self::orderBy("dl_times",'desc')->take(10)->get();
    }
    
    // 按下载次数 取出指定分类下的20条数据
    static function sort_hot($name,$paginate = 0)
    {
        if($paginate)
            return self::where('classification','=',"$name")->orderBy("dl_times",'desc')->select('id','name')->paginate(10);

        return self::where('classification','=',"$name")->orderBy("dl_times",'desc')->select('id','name')->take(10)->get();
    }

    // 按最新撒上架 取出指定分类下的20条数据
    
}
