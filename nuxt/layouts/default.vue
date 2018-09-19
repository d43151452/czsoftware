<template>
    <el-container class="main">
        <el-header class="main-header">
            <p class='title'>
                欢迎使用ASWTeamwork,
                <span>{{user_name}}</span>
            </p> 
            <ul class="header-opration">
                <li>
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
                                <i class="el-icon-star-off"></i>
                                项目管理
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
            </ul>
        </el-header>
        <nuxt />
    </el-container>
</template>

<script>
    export default {
        data(){
            return {
                user_name:'',
            }
        },
        mounted(){
            let auth = localStorage.getItem('auth');
            if(!auth){
                location.href = '/login';
            }else{
                this.user_name = localStorage.getItem('user_name');
            }
        }
    }
</script>

<style lang="less">
    .main{
        height: 100vh;
        .main-header{
            background-color:#409EFF;

            .title{
                color: #fff;
                display: inline-block;
                vertical-align: middle;
                padding: 0 10px;
                margin: 0 10px;
                line-height: 60px;
                font-size: 16px;
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
</style>
