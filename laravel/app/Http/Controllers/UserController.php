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
    function register(Request $request)
    {
        // 校验 字段
        if($errors = User::validator($request->all()))
            return $errors;

        // 2. 创建新用户 保存相关信息
        $user = $this->create($req->all());
        if ($user->save()) {
            
        }
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
