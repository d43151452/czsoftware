<template>
    <el-main>
        <el-breadcrumb separator="/">
            <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
            <el-breadcrumb-item>软件详情页</el-breadcrumb-item>
            <el-breadcrumb-item>{{data.name}}</el-breadcrumb-item>
        </el-breadcrumb>
        <div class="sw-hr"></div>
        <div class="module1">
            <div class="module1-tips">
                tips：登录之后，即可免费获取下载地址。 
            </div>
            <div class="module1-software">
                <img :src="data.cover" alt="">
                <div class="module1-software-name">
                    <p class="title">
                        {{data.name}}
                    </p>
                    <p class="feature">
                        {{data.feature}}
                    </p>
                    <p class="manufactor">
                        来自：<b style="color:#409eff">{{data.manufactor}}</b>       
                    </p>
                    <p class="desc">
                        <a :href="'/sort/'+data.classification">{{data.classification}}</a> 分类
                    </p>
                    <p class="desc">
                        <b style="color:#409eff">{{data.comments}}</b> 个评论
                    </p>
                    <p class="desc">
                        软件大小：<b style="color:#409eff">{{data.size}}</b> 
                        &nbsp;&nbsp; 
                        应用平台：<b style="color:#409eff">{{data.platform}}</b>
                    </p>
                    <p class="desc">
                        软件语言：<b style="color:#409eff">{{data.language}}</b> 
                        &nbsp;&nbsp; 
                        更新时间：<b style="color:#409eff">{{data.updated_at}}</b>
                    </p>
                    <p class="desc">
                        下载次数：<b style="color:#409eff">{{data.dl_times}}</b>次 
                        &nbsp;&nbsp; 
                        浏览量：<b style="color:#409eff">{{data.views}}</b>次
                    </p>
                    <el-popover
                        placement="bottom-start"
                        title="下载地址:"
                        trigger="hover"
                    >
                        <a v-if="url!=''" target="_blank" :href="url">{{url}}</a>
                        <span v-else>点击上面按钮你就看到了</span>
                        <el-button
                            type="primary"
                            v-loading="loading" 
                            @click="download_url"
                            slot="reference"
                        >
                            下载地址
                        </el-button>
                    </el-popover>
                </div>
            </div>
        </div>
        <div class="sw-hr"></div>
        <div class="module2">
            <div class="module-title">
                软件截图
            </div>
            <div class="module2-screenshot">
                <img v-for="(v,k) in data.screenshot" :key="k" :src="v" alt="">
            </div>
        </div>
        <el-tabs type="card" v-model="activeName">
            <el-tab-pane label="软件信息" name="first" style="padding:20px;">
                <div class="module3">
                    <div class="module-title">
                        软件简介
                    </div>
                    <div class="module3-neirong">
                        {{data.description}}
                    </div>
                </div>
                <div class="sw-hr"></div>
                <div class="module3">
                    <div class="module-title">
                        更新日志
                    </div>
                    <div class="module3-neirong">
                        {{data.update_log}}
                    </div>
                </div>
                <div class="sw-hr"></div>
                <div class="module3">
                    <div class="module-title">
                        功能介绍
                    </div>
                    <div class="module3-neirong">
                        {{data.fun_intro}}
                    </div>
                </div>
                <div class="sw-hr"></div>
                <div class="module3">
                    <div class="module-title">
                        安装步骤
                    </div>
                    <div class="module3-neirong">
                        {{data.update_log}}
                    </div>
                </div>
                <div class="sw-hr"></div>
                <div class="module3">
                    <div class="module-title">
                        常见问答
                    </div>
                    <div class="module3-neirong">
                        {{data.q_a}}
                    </div>
                </div>
            </el-tab-pane>
            <el-tab-pane label="评论信息" name="second" style="padding:20px;">
                
            </el-tab-pane>
        </el-tabs>
        
    </el-main>
</template>

<script>
import api from "~/plugins/api";

export default {
    data(){
        return {
            activeName:'first',
            loading:'',
            url:'',
            data:{
                name:'',
                cover:'',
                manufactor:'',
                classification:'',
                comments:'',
                screenshot:[
                    '',
                ],
                description:'',
                update_log:'',
                size:'',
                platform:'',
                language:'',
                dl_times:0,
                feature:'',
                views:0,
                updated_at:'',
                fun_intro:'',
                installation_steps:'',
                q_a:'',
            }
        }
    },
    created(){
        api.ajax_post('/software/detail',{
            'id':this.$route.params.id,
        })
        .then(res=>{
            if(res.data.errno==0){
                this.data = res.data.data;
            }else{
                this.$message({
                    message: res.data.msg,
                    type: 'error',
                    center: true,
                });
            }
        }).catch(err=>{
            this.$message({
                message: '可能出了点问题，问题请在后台查看',
                type: 'error',
                center: true,
            });
        })
    },
    methods:{
        download_url(){
            this.loading=true;
            let token = localStorage.getItem('token');
            if(token==null){
                this.loading = false;
                this.$message({
                    message: '登录一下呗~',
                    type: 'error',
                    center: true,
                });
                return;
            }

            api.ajax_post('/software/url',{
                'id':this.$route.params.id,
            })
            .then(res=>{
                this.loading=false;
                if(res.data.errno==0){
                    this.url = res.data.data.url;
                }else{
                    this.$message({
                        message: res.data.msg,
                        type: 'error',
                        center: true,
                    });
                }
            }).catch(err=>{
                this.loading=false;
                this.$message({
                    message: '可能出了点问题，问题请在后台查看',
                    type: 'error',
                    center: true,
                });
            })
        }
    }
}
</script>

<style lang="less">
    .sw-hr{
        margin: 20px 0;
        border-bottom: 1px solid #d6d6d6;
        height: 1px;
        width: 100%;
    }
    .module{
        &-title{
            font-size: 20px;
            font-weight: 600;
            height: 30px;
            line-height: 10px;
        }
    }

    .module1{
        &-tips{
            background-color: #f2f8fc;
            text-align: center;
            padding: 8px 16px;
            font-size: 13px;
            margin: 10px 0;
        }
        &-software{
            display: flex;
            img{
                border-radius: 25%;
                width: 230px;
                height: 230px;
                border: 2px solid #ccc;
            }
            .module1-software-name{
                flex: 1;
                padding-left: 20px;
                .title{
                    padding-bottom: 10px;
                    font-size: 24px;
                    font-weight: 600;
                }
            }
            .feature{
                font-size: 18px;
                line-height: 1.2223;
                font-weight: 400;
                letter-spacing: .02em;
                color: #8e8e93;
            }
            .manufactor{
                font-size: 18px;
                line-height: 1.2223;
                font-weight: 400;
                color:#8e8e93;
                margin:5px 0;
            }
            .desc{
                font-size: 12px;
                color:#8e8e93;
                height: 20px;
                line-height: 20px;
                a{
                    font-weight: 600;
                    color:#409eff;
                    text-decoration: underline;
                }
            }
        }
        
    }

    .module2{
        margin-bottom: 30px;
        &-screenshot{
            width: 100%;
            white-space:nowrap;
            overflow-x:scroll;
            overflow-y:hidden;
            img{
                width: 488px;
                margin-right: 15px;
                border-radius: 5px;
            }
        }
    }
</style>
