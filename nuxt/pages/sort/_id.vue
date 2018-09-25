<template>
    <el-main class="sort-main">
        <el-breadcrumb separator="/">
            <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
            <el-breadcrumb-item>{{this.data.sort_name}}</el-breadcrumb-item>
        </el-breadcrumb>
        <ul>
            <li class="sort-main-list" v-for="(v,k) in data.list" :key='k'>
                <div class="img">
                    <img :src="v.cover" alt="">
                </div>
                <div class="content">
                    <p>{{v.name}}</p>
                    <p>大小：{{ v.size }} 更新时间： {{v.updated_at}}</p>
                    <p>{{v.description}}</p>
                </div>                
            </li>
        </ul>
        <el-pagination
            :background="true"
            layout="total, prev, pager, next"
            :page-size="10"
            :total="100">
        </el-pagination>
    </el-main>
</template>

<script>

import api from '~/plugins/api';

export default {
    data(){
        return {
            sort_id:this.$route.params.id,
            data:{
                page:'',
                sort_name:'什么鬼分类',
                list:[
                    {
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
            'id':this.id,
        })
        .then(res=>{
            this.data = res.data.data;
            console.log(this.data);
        }).catch(err=>{
            this.$message({
                message: '可能出了点问题，问题请在后台查看',
                type: 'error',
                center: true,
            });
        })
    }
}
</script>

<style lang="less">
    .sort-main{
        padding: 20px;

        &-list{
            border-bottom: 1px solid #ccc;
            padding: 20px 0;

            .img{
                display: inline-block;
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
                }
            }
        }
    }
</style>
