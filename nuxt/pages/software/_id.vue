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
                            :loading="loading"
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
        <el-tabs type="card" v-model="activeName" @tab-click="handleClick">
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
            <el-tab-pane
                label="评论信息" 
                class="sw-comments" 
                name="second" 
                style="padding:20px;"
                v-loading="comments_loading"
                element-loading-text="拼命加载中"
                element-loading-spinner="el-icon-loading"
                element-loading-background="rgba(0, 0, 0, 0.8)"
            >
                <div class="module3">
                    <div class="module-title">
                        来，留下你的神评论~
                    </div>
                    <div class="module3-neirong">
                        <el-input
                            class="sw-comments-text"
                            type="textarea"
                            placeholder="请输入内容"
                            v-model="comment"
                            rows="5"
                        >
                        </el-input>
                        <el-button :loading="comment_loading" class="sw-comments-submit" @click="comment_submit" type="primary">
                            提交
                        </el-button>
                    </div>
                </div>
                <div class="sw-hr"></div>
                <div class="module3">
                    <div class="module-title">
                        热门评论
                    </div>
                    <div v-for="(v,k) in comments.hot_list" :key="k" class="sw-comments-content">
                        <img :src="v.user_avatar" alt="">
                        <div class="sw-comments-content-detail">
                            <p>
                                <b style="color:#409eff">{{v.user_name}}</b>
                                :
                                {{v.comment_content}}
                            </p>
                            <p>
                                <span class="left">
                                    {{v.created_at}}
                                </span>
                                <span class="right">
                                    <el-button size="mini" @click="z_c(v,1)" :disabled="v.disabled" type="primary" icon="el-icon-caret-top">
                                        赞：{{v.zan}}
                                    </el-button>
                                    <el-button size="mini" @click="z_c(v,0)" :disabled="v.disabled" type="primary" icon="el-icon-caret-bottom">
                                        踩：{{v.cai}}
                                    </el-button>
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="sw-hr"></div>
                <div 
                    class="module3"
                    v-loading="normal_comments_loading"
                    element-loading-text="拼命加载中"
                    element-loading-spinner="el-icon-loading"
                    element-loading-background="rgba(0, 0, 0, 0.8)"
                >
                    <div class="module-title" id="scrollPos">
                        最新评论
                    </div>
                    <div v-for="(v,k) in comments.normal_comments.list" :key="k" class="sw-comments-content">
                        <img :src="v.user_avatar" alt="">
                        <div class="sw-comments-content-detail">
                            <p>
                                <b style="color:#409eff">{{v.user_name}}</b>
                                :
                                {{v.comment_content}}
                            </p>
                            <p>
                                <span class="left">
                                    {{v.created_at}}
                                </span>
                                <span class="right">
                                    <el-button size="mini" @click="z_c(v,1)" :disabled="v.disabled" type="primary" icon="el-icon-caret-top">
                                        赞：{{v.zan}}
                                    </el-button>
                                    <el-button size="mini" @click="z_c(v,0)" :disabled="v.disabled" type="primary" icon="el-icon-caret-bottom">
                                        踩：{{v.cai}}
                                    </el-button>
                                </span>
                            </p>
                        </div>
                    </div>
                    <el-pagination
                        @current-change="page_change"
                        :background="true"
                        layout="total, prev, pager, next"
                        :page-size="10"
                        :total="comments.normal_comments.total"
                        class="page"
                    >
                    </el-pagination>
                </div>
            </el-tab-pane>
        </el-tabs>
        
    </el-main>
</template>

<script>
import api from "~/plugins/api";

export default {
    data(){
        return {
            comment:'',
            activeName:'first',
            loading:false,
            comment_loading:false,
            comments_loading:false,
            normal_comments_loading:false,
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
            },
            comments_status:false,
            comments:{
                hot_list: [
                    {
                        id:'',
                        user_name:'', 
                        user_avatar:'', 
                        created_at: '', 
                        comment_content:'', 
                        zan: 0, 
                        cai: 0,
                        disabled:true,
                    }
                ], 
                normal_comments: {
                    total: 0, 
                    list: [
                        {
                            id:'',
                            user_name:'', 
                            user_avatar:'', 
                            created_at: '', 
                            comment_content:'', 
                            zan: 0, 
                            cai: 0,
                            disabled:true,
                        }
                    ]
                }
            }
        }
    },
    created(){
        //软件详情
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
        });
    },
    methods:{
        checkLogin(){
            let token = localStorage.getItem('token');
            if(token==null){
                this.$message({
                    message: '登录一下呗~',
                    type: 'warning',
                    center: true,
                });
                return false;
            }
            return true;
        },
        download_url(){
            if(!this.checkLogin()){
                return;
            }
            this.loading=true;
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
        },
        handleClick(tab, event){
            if(tab.name=='second' && !this.comments_status){
                this.comments_loading = true;
                //评论获取
                api.ajax_post('/software/comments',{
                    'id':this.$route.params.id,
                })
                .then(res=>{
                    this.comments_loading = false;
                    if(res.data.errno==0){
                        this.comments = res.data.data;
                    }else{
                        this.$message({
                            message: res.data.msg,
                            type: 'error',
                            center: true,
                        });
                    }
                }).catch(err=>{
                    this.comments_loading = false;
                    this.$message({
                        message: '可能出了点问题，问题请在后台查看',
                        type: 'error',
                        center: true,
                    });
                });
            }
        },
        comment_submit(){
            if(!this.checkLogin()){
                return;
            }
            let comment = this.comment;
            if(comment==''){
                this.$message({
                    message: '评论不可为空',
                    type: 'error',
                    center: true,
                });
            }else if(comment.length>200){
                this.$message({
                    message: '评论长度限制为200字符',
                    type: 'error',
                    center: true,
                });
            }else{
                this.comment_loading = true;
                api.ajax_post('/software/comment/create',{
                    'id':this.$route.params.id,
                    'comment':this.comment,
                })
                .then(res=>{
                    this.comment_loading=false;
                    if(res.data.errno==0){
                        this.$message({
                            message: res.data.msg,
                            type: 'success',
                            center: true,
                        });
                        this.comment='';
                    }else{
                        this.$message({
                            message: res.data.msg,
                            type: 'error',
                            center: true,
                        });
                    }
                }).catch(err=>{
                    this.comment_loading=false;
                    this.$message({
                        message: '可能出了点问题，问题请在后台查看',
                        type: 'error',
                        center: true,
                    });
                })
            }
        },
        z_c(obj,type){
            if(!this.checkLogin()){
                return;
            }
            obj.disabled = true;
            api.ajax_post('/software/comment/z_c',{
                id:obj.id,
                type:type,
            })
            .then(res=>{
                if(res.data.errno==0){
                    this.$message({
                        message: res.data.msg,
                        type: 'success',
                        center: true,
                    });
                    if(type){
                        obj.zan++;
                    }else{
                        obj.cai++;
                    }
                }else{
                    this.$message({
                        message: res.data.msg,
                        type: 'error',
                        center: true,
                    });
                }
            }).catch(err=>{
                obj.disabled = false;
                this.$message({
                    message: '可能出了点问题，问题请在后台查看',
                    type: 'error',
                    center: true,
                });
            });
        },
        page_change(page_num){
            this.normal_comments_loading = true;
            api.ajax_post('/software/normal_comments?page='+page_num,{
                'id':this.$route.params.id,
            })
            .then(res=>{
                this.normal_comments_loading = false;
                this.comments.normal_comments = res.data.data;
                document.querySelector("#scrollPos").scrollIntoView(true);
            }).catch(err=>{
                this.normal_comments_loading = false;
                this.$message({
                    message: '可能出了点问题，问题请在后台查看',
                    type: 'error',
                    center: true,
                });
            });
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

    .sw-comments{
        &-submit{
            margin-top: 20px;
            margin-left: 830px;
        }
        &-content{
            display: flex;
            padding: 20px 0;
            img{
                width: 100px;
                height: 100px;
                border-radius: 5px;
            }
            &-detail{
                flex: 1;
                padding-left: 20px;
                p:first-child{
                    font-size: 15px;
                }
                p:nth-child(2){
                    height: 50px;
                    line-height: 50px;
                    .left{
                        float: left;
                        color:#333;
                    }
                    .right{
                        float:right;
                    }

                }
            }
        }
    }
</style>
