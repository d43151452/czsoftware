<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Validator;


class User extends  Authenticatable implements JWTSubject
{
    protected $table = "user";
    protected $fillable = ['name','email','password'];
    protected $hidden = ['password'];
    
    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [];
    }

    public static function validator($data)
    {
        // 1. 校验 用户用户名 用户邮箱 用户密码 字段
        $rules = [
            'name' => 'required|unique:user|max:20|min:2',
            'email' => 'required|email|unique:user',
            "password"=>'required|max:32|min:6'
        ];

        $mes = [
            'name.required'    => '用户名不能为空',
            'name.unique'    => '用户名已被占用',
            'name.max'    => '用户名最多20位',
            'name.min'    => '用户名最少2位',
            'email.required'    => '邮箱地址不能为空',
            'email.email'    => '邮箱地址格式不正确',
            'email.unique'    => '邮箱地址已被占用',
            'password.required'    => '密码不能为空',
            'password.max'    => '密码最多32位',
            'password.min'    => '密码最少6位',
        ];
        $validator = Validator::make($data, $rules, $mes);
        if($errors = $validator->errors()->first())
            return $errors;
    }
}
