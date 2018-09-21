<?php

use Illuminate\Http\Request;

//接管路由
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

    // 登录
    $api->post('login', 'App\Http\Controllers\UserController@login');

    // 注册
    $api->post('register', 'App\Http\Controllers\UserController@register');

    $api->group(['middleware' => 'api.auth'], function ($api) {
        // 需要登录才能进行操作的API写在这里
    });
});