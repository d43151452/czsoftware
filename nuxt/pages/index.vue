<template>
    <section class="container main">
        <el-carousel indicator-position="outside">
            <el-carousel-item v-for="(v,k) in data.slideshow" :key="k">
                <img :src="v.url" alt="">
                <!-- <h3>{{k}}</h3> -->
            </el-carousel-item>
        </el-carousel>
        <div v-for="(v,k) in data.sort_list" :key="k" class="module">
            <div class="module-title">
                <span>{{v.name}}最近更新</span>
            </div>
            <el-container class="module-container">
                <el-main class="module-main">
                    <ul>
                        <li v-for="(vi,ki) in v.recommend_list" :key="ki">
                            <a :href="'/software/'+vi.rec_id">
                                <img :src="vi.rec_cover" alt="">
                                <p>{{vi.rec_name}}</p>
                            </a>
                        </li>
                    </ul>
                </el-main>
                <el-aside width="200px" class="module-aside">
                    <div class="aside-title">
                        <el-badge value="hot" class="item">
                            {{v.name}}热门排行
                        </el-badge>
                        
                    </div>
                    <ul class="aside-rank">
                        <li v-for="(vi,ki) in v.hot_list" :key="ki">
                            <a :href="'/software/'+vi.hot_id">
                                <b>{{ki+1}}</b>
                                {{vi.hot_name}}
                            </a>
                        </li>
                    </ul>
                </el-aside>
            </el-container>
        </div>
    </section>
</template>

<script>
import api from '~/plugins/api';

export default {
    data(){
        return {
            data:{
                sort_list: {
                    name:'',
                    recommend_list:[
                        {
                            rec_name:'',
                            cover:''
                        }
                    ],
                    hot_list:[
                        {
                            hot_name:''
                        }
                    ],
                },
                slideshow:[
                    {
                        url:'',
                    }
                ],
            }
        }
    },
    mounted(){
        api.ajax_post('/main')
        .then(res=>{
            this.data = res.data.data;
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
    .main{
        padding: 20px;
    }
    .module{
        padding: 20px 0;

        .module-title{
            font-size: 18px;
            border-bottom: 3px solid #409eff;
            span{
                display: inline-block;
                padding: 10px 20px;
                margin-left: 10px;
                background-color: #409eff;
                color: #fff;
                font-weight: 900;
            }
        }
        .module-container{
            .module-main{
                li{
                    width: 18%;
                    margin-right: 2%; 
                    float: left;
                    img{
                        width: 100%;
                    }
                    p{
                        font-size: 14px;
                        color:#000;
                    }
                }
            }
            .module-aside{
                .aside-title{
                    font-size: 16px;
                    padding-left: 20px;
                    font-weight: 900;
                    margin-top: 20px;
                    background-color: #409eff;
                    height: 30px;
                    color:#fff;
                    line-height: 30px;  
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
        }
    }
</style>

