<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;

use App\Models\User;

class EmailController extends Controller
{
    //Send email
    // 1. name：username
    // 2. email：email address
    public function send(Request $request)
    {       

        // 调试发送邮件时,开启此项
        // Cache::flush();

        // frequency limitation : 30 minutes 
        if(Cache::has("email:$request->email"))
        {   
            $time =  1800 - (strtotime(now()) - strtotime(Cache::get("email:$request->email")["time"]));
            return self::rtmsg(1,"邮件已经发送过了,请{$time}秒后再试");
        }

        // verify
        if($errors = User::validator($request->all()))
            return self::rtmsg(1,$errors);

        $data = ["val_code"=>rand(100000,999999),"data"=>$request->all(),"time"=>now()];

        // send email
        $flag = Mail::send('email.send',$data,function($message) use ($data)
        {
            $message -> to($data["data"]["email"]) -> subject('欢迎注册传智软件平台账号');
        });
        
        // 校验 发送状态
        if(!Mail::failures())
        {
             // 发送成功：存缓存
            Cache::put("email:$request->email", $data,30);
            return self::rtmsg(0,"邮件发送成功,请打开邮箱查看验证码");
        }
        // 发送失败：返回错误信息
        return self::rtmsg(1,'邮件发送失败');
    }
}
