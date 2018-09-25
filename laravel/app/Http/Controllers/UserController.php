<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

use App\Models\User;
use App\Models\Operation;


class UserController extends Controller
{   
    // 注册
    // 1 name：用户名
    // 2 email: 邮箱地址
    // 3 password: 密码
    function register(Request $request)
    {
        // 校验 字段
        if($errors = User::validator($request->all()))
            return self::rtmsg(1,$errors);

        // 验证码 邮箱  用户名 校验

        if(!$cache = Cache::has("email:$request->email"))
            return self::rtmsg(1,"请先获取验证码");

        if($request->val_code != $cache["val_code"])
            return self::rtmsg(1,"验证码错误");

        if($request->name != $cache['data']["name"] || $request->email != $cache['data']["email"])
            return self::rtmsg(1,"邮箱或用户名不符");

        // 2. 创建新用户 保存相关信息
        $user = new User();
        $user->create(["name"=>$request->name,"email"=>$request->email,"password"=>$request->password]);
        $token = JWTAuth::fromUser($user); 
        // 删掉缓存
        Cache::forget("email:$request->email");
        // 返回注册成功消息
        return self::rtmsg(0,"注册成功",["token"=>$token]);
    }

    // 登录
    // 1 name：用户名/邮箱地址
    // 2 password: 密码
    function login(Request $request)
    {   
        // 校验 用户是否存在
        if(!$user = User::where('email', strtolower($request->name))->orWhere('name', $request->name)->first())
            return self::rtmsg(1,"用户名或邮箱不存在");

        // 校验 密码
        if (!($user && Hash::check($request->password, $user->password)))
            return self::rtmsg(1,"密码错误");

        // 存入登录记录
        Operation::saveOperation($user->id,$user->name,"登录");

        // 登陆成功 返回 消息和token
        $token = JWTAuth::fromUser($user);
        return self::rtmsg(0,"登录成功",["token"=>$token]);

    }
}
