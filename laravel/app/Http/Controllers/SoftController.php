<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classification;
use App\Models\Soft;
use App\Models\Carousel;

class SoftController extends Controller
{
    

    // 获取软件分类&总排行
    
    function currency()
    {
        return self::rtmsg(0,"获取成功",['sort_list'=>Classification::sortlist(),"hot_list"=>Soft::hotlist()]);
    }

    // 获取首页数据
    function main()
    {
        //随机取出一半的分类名称
        $sort = Classification::orderBy(\DB::raw('RAND()'))->select("name")->take(6)->get();

        $sort_list = [];
        foreach ($sort as $key => $value) {
            $sort_list[$key]['name'] = $value["name"];
            // 按下载次数 取出指定分类下的20条数据
            $sort_list[$key]["hot_list"] = Soft::sort_hot($value["name"]);
            // 按最新撒上架 取出指定分类下的20条数据
            $sort_list[$key]["recommend_list"] = Soft::new_list($value["name"]);
        }

        // 返回数据
        return  self::rtmsg(0,"获取成功",["sort_list"=>$sort_list,"slideshow"=>Carousel::get()]) ;
    }

    // 获取指定分类下的软件信息
    function sort(Request $request)
    {   
        $data = Soft::new_list($request->name,1);
        return $data;
    }

}
