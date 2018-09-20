<?php

use Illuminate\Http\Request;

//接管路由
$api = app('Dingo\Api\Routing\Router');

// v1 是版本号
$api->version('v1', function ($api) {
    // 示例
    //$ api->get('article', 'App\Http\Controllers\LoginController@login');
    // $api->post('register', 'App\Http\Controllers\RegisterController@register');
    // 登录中间件  jwtauth 自动判断用户token
    $api->group(['middleware' => 'api.auth'], function ($api) {
        // 需要登录才能进行操作的API写在这里
    });
});
