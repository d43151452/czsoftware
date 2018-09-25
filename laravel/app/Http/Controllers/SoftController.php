<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classification;
use App\Models\Soft;

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
        //获取分类排行
        //1. 随机取出一半的分类名称
        $sort = Classification::orderBy(\DB::raw('RAND()'))->select("name")->take(6)->get();

        // 取出分类下的热门数据
        foreach ($sort as $key => $value) {
            $hot_list[$key]["hot_list"] = Soft::sort_hot($value["name"]);
            $hot_list[$key]['name'] = $value["name"];
        }

        
        $data = [
            "sort_list"=>$hot_list,
            "recommend_list"=>"1"
        ];
        return  self::rtmsg(0,"获取成功",$data) ;
    }
}
