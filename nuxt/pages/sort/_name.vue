<template>
    <el-main 
        class="sort-main"
        v-loading="loading"
        element-loading-text="拼命加载中"
        element-loading-spinner="el-icon-loading"
        element-loading-background="rgba(0, 0, 0, 0.8)"
    >
        <el-breadcrumb separator="/">
            <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
            <el-breadcrumb-item>分类</el-breadcrumb-item>
            <el-breadcrumb-item>{{this.sort_name}}</el-breadcrumb-item>
        </el-breadcrumb>
        <ul>
            <li class="sort-main-list" v-for="(v,k) in data.list" :key='k'>
                <a :href="'/software/'+v.id">
                    <div class="img">
                        <img :src="v.cover" alt="">
                    </div>
                    <div class="content">
                        <p>{{v.name}}</p>
                        <p>大小：{{ v.size }}&nbsp;&nbsp;&nbsp;&nbsp;更新时间： {{v.updated_at}}</p>
                        <p>{{v.description}}</p>
                    </div>
                    <div class="button">
                        <el-button type="primary">
                            立即下载
                        </el-button>
                    </div>
                </a>      
            </li>
        </ul>
        <el-pagination
            @current-change="page_change"
            :background="true"
            layout="total, prev, pager, next"
            :page-size="10"
            :total="data.total"
            class="page"
        >
        </el-pagination>
    </el-main>
</template>

<script>

import api from '~/plugins/api';

export default {
    data(){
        return {
            sort_name:this.$route.params.name,
            loading:false,
            data:{
                total:100,
                list:[
                    {
                        id:'',
                        name:'',
                        cover:'',
                        size:'',
                        updated_at:'',
                        description:'',
                    }
                ]
            }
                
        }
    },
    created(){
        api.ajax_post('/sort',{
            'name':this.name,
        })
        .then(res=>{
            this.data = res.data.data;
        }).catch(err=>{
            this.$message({
                message: '可能出了点问题，问题请在后台查看',
                type: 'error',
                center: true,
            });
        })
    },
    methods:{
        page_change(page_num){
            this.loading = true;
            api.ajax_post('/sort?page='+page_num,{
                'name':this.name,
            })
            .then(res=>{
                this.loading = false;
                this.data = res.data.data;
            }).catch(err=>{
                this.loading = false;
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
    .sort-main{
        padding: 20px;

        &-list{
            border-bottom: 1px solid #ccc;
            padding: 20px 0;
            a{
                color:#000;
            }

            .img{
                display: inline-block;
                img{
                    width: 100px;
                    height: 100px;
                    border-radius: 25%;
                    border:1px solid #ccc;
                }
            }

            .content{
                margin-left: 20px;
                display: inline-block;
                width: 700px;
                p{
                    height: 30px;
                    line-height: 30px;
                }
                p:nth-child(1){
                    font-weight: 900;
                    font-size: 16px;
                }
                p:nth-child(3){
                    overflow: hidden;
                    text-overflow:ellipsis;
                    display:-webkit-box; 
                    -webkit-box-orient:vertical;
                    -webkit-line-clamp:2; 
                }
            }
            
            .button{
                display: inline-block;
                position: relative;
                top: -50px;
                left: 20px;
            }
        }
        .page{
            padding: 15px 0 15px 200px;
        }
    }
</style>
