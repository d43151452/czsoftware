<?php

use Illuminate\Http\Request;

//接管路由
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

    // 登录
    $api->post('login', 'App\Http\Controllers\UserController@login');

    // 注册
    $api->post('register', 'App\Http\Controllers\UserController@register');

    // 发送注册邮件
    $api->post("email/send",'App\Http\Controllers\EmailController@send');

    // 获取软件分类&软件排行
    $api->post("currency",'App\Http\Controllers\SoftController@currency') ;

    // 获取首页数据
    $api->post("main",'App\Http\Controllers\SoftController@main') ;

    // 获取指定分类下的软件信息
    $api->post("sort",'App\Http\Controllers\SoftController@sort') ;

    $api->group(['middleware' => 'api.auth'], function ($api) {
        // 需要登录才能进行操作的API写在这里
    });
});