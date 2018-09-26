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
            return self::where('classification','=',"$name")->orderBy("dl_times",'desc')->select('id','name','cover','size','description','updated_at')->paginate(10);

        return self::where('classification','=',"$name")->orderBy("dl_times",'desc')->select('id','name')->take(10)->get();
    }

    // 按最新撒上架 取出指定分类下的20条数据
    static function new_list($name,$paginate = 0)
    {
        if($paginate)
        {
            // 今日更新
            if($name == "今日更新")
            {
                $time = date("Y-m-d 00:00:00");
                return self::where('updated_at','>=',"$time")->orderBy("updated_at",'desc')->select('id','name','cover','size','description','updated_at')->paginate(20);
            }
            return self::where('classification','=',"$name")->orderBy("updated_at",'desc')->select('id','name','cover','size','description','updated_at')->paginate(20);
        }
        
        return self::where('classification','=',"$name")->orderBy("updated_at",'desc')->select('id','name')->take(20)->get();
    }
    
}
