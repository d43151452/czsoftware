<template>
    <el-container class="main">
        <div class="mengban" id='mengban' v-if="mengban && token == ''" @click="mbclose()"></div>
        <div class="login" v-if="mengban && token == ''">
            <el-tabs :stretch="true" v-model="activeName">
                <el-tab-pane label="登录" name="login">
                    <el-form class="mid-form" :label-position="'top'" ref='loginFormVal' :model="loginForm" :rules="loginRules" label-width="80px">
                        <el-form-item style="margin-top:7px;margin-bottom:20px" label="用户名/邮箱" prop="name">
                            <el-input v-model="loginForm.name" placeholder="请输入用户名或邮箱"></el-input>
                        </el-form-item>
                        <el-form-item style="margin-bottom:30px"  label="密码" prop="password">
                            <el-input type="password" v-model="loginForm.password" placeholder="请输入密码"></el-input>
                        </el-form-item>
                        <el-form-item class="mid-button">
                            <el-button
                                v-loading.fullscreen.lock="loginLoading"
                                element-loading-text="正在登陆中"
                                element-loading-spinner="el-icon-loading"
                                element-loading-background="rgba(0, 0, 0, 0.8)"
                                type="primary"
                                @click="login('loginFormVal')"
                            >
                                登录
                            </el-button>
                        </el-form-item>
                    </el-form>
                </el-tab-pane>
                <el-tab-pane label="注册" name="register">
                    <el-form label-position="left" class="mid-form" ref='regFormVal' :model="regForm" :rules="regRules" label-width="80px">
                        <el-form-item :inline="true" label="邮箱" prop="email">
                            <el-input v-model="regForm.email"  placeholder="请输入邮箱"></el-input>
                        </el-form-item>
                        <el-form-item label="密码" prop="password">
                            <el-input type="password" v-model="regForm.password" placeholder="请输入密码"></el-input>
                        </el-form-item>
                        <el-form-item label="昵称" prop="name">
                            <el-input type="text" v-model="regForm.name" placeholder="请输入昵称"></el-input>
                        </el-form-item>
                        <el-form-item label="验证码" prop="val_code">
                            <el-input type="text" v-model="regForm.val_code" placeholder="请输入6位验证码"></el-input>
                            <el-button
                                v-loading.fullscreen.lock="sending"
                                element-loading-text="正在发送中"
                                element-loading-spinner="el-icon-loading"
                                element-loading-background="rgba(0, 0, 0, 0.8)"
                                id="valCode" 
                                class="mid-form-button" 
                                type="primary" 
                                plain @click="mail()"
                            >
                                发送验证码
                            </el-button>
                        </el-form-item>
                        <el-form-item class="mid-button">
                            <el-button
                                v-loading.fullscreen.lock="regLoading"
                                element-loading-text="正在注册中"
                                element-loading-spinner="el-icon-loading"
                                element-loading-background="rgba(0, 0, 0, 0.8)"
                                type="primary"
                                @click="register('regFormVal')"
                            >
                                注册
                            </el-button>
                        </el-form-item>
                    </el-form>
                </el-tab-pane>
            </el-tabs>
        </div>
        <el-header class="main-header">
            <div class="container">
                <p class='title'>
                    <a href="/" style="color:#fff">
                        欢迎使用CZXYSoft系统
                    </a>
                </p> 
                <ul class="header-opration">
                    <li v-if="token!=''">
                        <el-dropdown>
                            <span style='color:white'>
                                个人中心<i class="el-icon-arrow-down el-icon--right"></i>
                            </span>
                            <el-dropdown-menu slot="dropdown">
                                <el-dropdown-item>
                                    <i class="el-icon-info"></i>
                                    个人设置
                                </el-dropdown-item>
                                <el-dropdown-item>
                                    <i class="el-icon-setting"></i>
                                    系统管理
                                </el-dropdown-item>
                                <el-dropdown-item>
                                    <i class="el-icon-question"></i>
                                    帮助文档
                                </el-dropdown-item>
                                <el-dropdown-item divided>
                                    <i class="el-icon-error"></i>
                                    退出
                                </el-dropdown-item>
                            </el-dropdown-menu>
                        </el-dropdown>
                    </li>
                    <li v-else>
                        <el-button type="primary" @click="mbOpen('login')">登录</el-button>
                        <el-button type="primary" @click="mbOpen('register')">注册</el-button>
                    </li>
                </ul>
            </div>
        </el-header>
        <el-container class="container container2">
            <el-aside class="main-aside" width="200px">
                <h1 class="aside-title">软件分类</h1>
                <ul class="aside-sort">
                    <li v-for="(v,k) in sortList" :key="k">
                        <a :href="'/sort/'+ v.sort_id">{{v.sort_name}}</a>
                    </li>
                </ul>
                <h1 class="aside-title">热门软件下载榜</h1>
                <ul class="aside-rank">
                    <li v-for="(v,k) in hotList" :key="k">
                        <a :href="'/software/'+v.id">
                            <b>{{k+1}}</b>
                            <img :src="v.cover" alt="">
                            {{v.name}}
                        </a>
                    </li>
                </ul>
            </el-aside>
            <nuxt :test="test"/>
        </el-container>
    </el-container>
</template>

<script>
    import api from '~/plugins/api';
    import mock from '~/plugins/mock';
    import axios from 'axios';

    export default {
        data(){
            return {
                sortList:[
                    {
                        sort_id:'123',
                        sort_name:'123',
                    }
                ],
                hotList:[
                    {
                        id:'',
                        name:'',
                        dl_time:0,
                        cover:'',
                    }
                ],
                loginForm:{
                    name:'',
                    password:'',
                },
                loginRules:{
                    name:[
                        { required: true, message: '请输入用户名或邮箱', trigger: 'blur' },
                    ],
                    password:[
                        { required: true, message: '请输入密码', trigger: 'blur' },
                    ]
                },
                regForm:{
                    email:'',
                    password:'',
                    val_code:'',
                    name:''
                },
                regRules:{
                    email:[
                        { required: true, message: '请输入邮箱地址', trigger: 'blur' },
                        { type: 'email', message: '请输入正确的邮箱地址', trigger:'blur' }
                    ],
                    password:[
                        { required: true, message: '请输入密码', trigger: 'blur' },
                    ],
                    name:[
                        { required: true, message: '请输入昵称', trigger: 'blur' },
                        { max: 12, message: '昵称太长啦！', trigger: 'blur' },
                    ],
                    val_code:[
                        { required: true, message: '请输入验证码', trigger: 'blur' },
                        { min: 6, max: 6, message: '验证码为六位', trigger: 'blur' },
                    ],
                },
                loginLoading:false,
                regLoading:false,
                activeName: 'login',
                mengban:false,
                sending:false,
                Countdown:60,
                timer:null,
                token:'',
                test:'123'
            }
        },
        created(){

            axios.interceptors.response.use(
                response => {
                    return response;
                },
                error => {
                    console.log(error);

                    if (error.response) {
                        switch (error.response.status) {
                            case 401:
                                localStorage.removeItem('auth');
                                localStorage.removeItem('user_name');
                                this.mengban = true;
                                this.activeName = 'login';
                                this.$message({
                                    message: '请先登录，谢谢合作',
                                    type: 'error',
                                    center: true,
                                });
                                break;
                        }
                    }
                    return Promise.reject(error.response.data)
                }
            );
        },
        mounted(){
            let auth = localStorage.getItem('token');
            if(auth){
                this.token = auth;
            }
            api.ajax_post('/sort',{})
            .then(res=>{
                console.log(res);
                if(res.data.errno == 0){
                    this.sortList = res.data.data;
                }else{
                    this.$message({
                        message: res.data.msg,
                        type: 'error',
                        center: true,
                    });
                }
            }).catch(error=>{
                this.sending = false;
                this.$message({
                    message: '可能出了点问题，请在后台查看，（╯-_-）╯╧╧',
                    type: 'error',
                    center: true,
                });
            });
            api.ajax_post('/hotlist',{})
            .then(res=>{
                console.log(res);
                if(res.data.errno == 0){
                    this.hotList = res.data.data;
                }else{
                    this.$message({
                        message: res.data.msg,
                        type: 'error',
                        center: true,
                    });
                }
            }).catch(error=>{
                this.sending = false;
                this.$message({
                    message: '可能出了点问题，请在后台查看，（╯-_-）╯╧╧',
                    type: 'error',
                    center: true,
                });
            });
        },
        methods:{
            //登录注册框开启与关闭
            mbclose(){
                this.mengban = false;
            },
            mbOpen(name){
                this.mengban = true;
                this.activeName = name;
            },
            //邮件发送
            mail(){
                let email = this.regForm.email;
                let patt = /^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.[a-zA-Z0-9]{2,6}$/;
                let n = patt.test(email);
                let name = this.regForm.name;
                if(!name){
                    this.$message({
                        message: '填一下用户名呗',
                        type: 'warning',
                        center: true,
                    });
                }else if(n){
                    this.sending = true;
                    api.ajax_post('/email/send', {
                        'email': email,
                        'name': name
                    }).then(res=>{
                        console.log(res);
                        this.sending = false;
                        this.buttonStyle();
                        if(res.data.errno == 0){
                            this.$message({
                                message: res.data.msg,
                                type: 'success',
                                center: true,
                            });
                        }else{
                            this.$message({
                                message: res.data.msg,
                                type: 'error',
                                center: true,
                            })
                        }
                    }).catch(error=>{
                        this.sending = false;
                        this.$message({
                            message: '可能出了点问题，请在后台查看，（╯-_-）╯╧╧',
                            type: 'error',
                            center: true,
                        });
                    });
                }else{
                    this.$message({
                        message: '似乎邮箱不对，检查一下？',
                        type: 'warning',
                        center: true,
                    });
                    return;
                }
            },
            buttonStyle(){
                //设置按钮样式
                let el = document.querySelector('#valCode');
                el.classList.remove('el-button--primary');
                el.classList.add('is-disabled','el-button--infro');
                el = document.querySelector('#valCode span');
                el.innerHTML = `重新发送 ${this.Countdown}s`;
                this.timer = setInterval(()=>{
                    let el = document.querySelector('#valCode span');
                    if(this.Countdown>0){
                        this.Countdown--;
                        el.innerHTML = `重新发送 ${this.Countdown}s`;
                    }else{
                        el.innerHTML = '重新发送';
                        el = document.querySelector('#valCode');
                        el.classList.remove('el-button--infro','is-disabled');
                        el.classList.add('el-button--primary');
                        clearInterval(this.timer);
                        this.Countdown = 60;
                    }
                },1000);
            },
            //注册提交
            register(form_name){
                this.$refs[form_name].validate((valid) => {
                    if (valid) {
                        this.regLoading = true;
                        api.ajax_post('/register', this.regForm).then(res=>{
                            this.regLoading = false;
                            if(res.data.errno == 0){
                                this.$message({
                                    message: res.data.msg,
                                    type: 'success',
                                    center: true,
                                });
                                localStorage.setItem('token',res.data.data.token);
                            }else{
                                this.$message({
                                    message:res.data.msg,
                                    type: 'error',
                                    center: true,
                                })
                            }
                        }).catch(error=>{
                            this.regLoading = false;
                            this.$message({
                                message: '可能出了点问题，请在后台查看，（╯-_-）╯╧╧ ',
                                type: 'error',
                                center: true,
                            });
                        });
                    } else {
                        return false;
                    }
                });  
            },
            //登录提交
            login(form_name){
                this.$refs[form_name].validate((valid) => {
                    if (valid) {
                        this.loginLoading = true;
                        api.ajax_post('/login', this.loginForm).then(res=>{
                            this.loginLoading = false;
                            if(res.data.status_code == 0){
                                this.$message({
                                    message: res.data.msg,
                                    type: 'success',
                                    center: true,
                                });
                                localStorage.setItem('token',res.data.data.token);
                            }else{
                                this.$message({
                                    message: res.data.msg,
                                    type: 'error',
                                    center: true,
                                })
                            }
                            console.log(res);
                        }).catch(error=>{
                            this.loginLoading = false;
                            this.$message({
                                message: '可能出了点问题，问题请在后台查看',
                                type: 'error',
                                center: true,
                            });
                        });
                    } else {
                        return false;
                    }
                });
                
            },
        }
    }
</script>

<style lang="less">
    body{
        background-color: #efefef;
    }
    .container{
        width: 1200px;
        margin: 0 auto;
    }

    .container2{
        background-color: #fff;
    }

    .mengban{
        position: absolute;
        margin: auto;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: rgba(0,0,0,0.4);
    }
    .login{
        position: absolute;
        margin: auto;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        width: 400px;
        height: 400px;
        background-color: #fff;
        padding: 20px 40px;
        border-radius: 20px;
    }

    .mid-form{
        &-button{
            margin-top: 20px;
            position: absolute;
            right: 0;
            bottom: 0;
        }
    } 

    .main{
        height: 100vh;
        .main-header{
            background-color:#409EFF;
            border-bottom: 1px solid #efefef;

            .title{
                color: #fff;
                display: inline-block;
                vertical-align: middle;
                padding: 0 10px;
                margin: 0 10px;
                line-height: 60px;
                font-size: 20px;
                cursor: pointer;

                span{
                    font-weight: 600;
                    color:#fff;
                }
            }
            .header-opration{
                display: inline-block;
                float: right;
                padding-right: 30px;

                li{
                    color: #fff;
                    display: inline-block;
                    vertical-align: middle;
                    padding: 0 10px;
                    margin: 0 10px;
                    line-height: 60px;
                    cursor: pointer;

                    a{
                        color: #606266 !important; 
                    }
                }
            }
        }
    }
    .main-aside{
        border-right: 1px solid #ccc;
        &::-webkit-scrollbar {display:none}
        .aside-title{
            background-color: #409eff;
            padding: 20px;
            color: #fff;
            font-size: 22px;
        }
        .aside-sort{
            padding: 10px 20px;
            overflow: hidden;
            li{
                height: 50px;
                line-height: 30px;
                text-align: center;
                font-size: 16px;
                float: left;
                width: 50%;

                a{
                    color: #333;
                }
            }
        }
        .aside-rank{
            padding: 10px 20px;
            li{
                height: 50px;
                line-height: 30px;
                text-align: left;
                font-size: 14px;
                b{
                    display: inline-block;
                    width: 20px;
                    height: 20px;
                    background-color: #b3b3b3;
                    color: #fff;
                    line-height: 20px;
                    text-align: center;
                    font-size: 16px;
                }
                &:nth-child(1) b{
                    background-color: #ea4b2e;
                }
                &:nth-child(2) b{
                    background-color: #f19601;
                }
                &:nth-child(3) b{
                    background-color: #f3d400;
                }
                &:nth-child(4) b{
                    background-color: #6eb35a;
                }
                &:nth-child(5) b{
                    background-color: #008ee2;
                }

                img{
                    vertical-align: middle;
                    width: 40px;
                    height: 40px;
                    border-radius: 50%;
                    margin-left: 5px;
                }

                a{
                    color: #333;
                }
            }
        }
    }
</style>
