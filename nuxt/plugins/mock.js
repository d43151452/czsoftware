import Mock from 'mockjs';

//邮箱验证码
Mock.mock(/\/api\/valcode.*/,'post',{
    'errno':'@integer(0,1)',
    'msg':'@csentence(5,10)',
});

//注册
Mock.mock(/\/api\/register.*/,'post',{
    'errno':'@integer(0,1)',
    'msg':'@csentence(5,10)',
    'data':{
            'token':'@word(100)',
        }
});

//登录
Mock.mock(/\/api\/login.*/,'post',{
    'errno':'@integer(0,1)',
    'msg':'@csentence(5,10)',
    'data':{
            'token':'@word(100)',
        }
});

//分类
Mock.mock(/\/api\/currency.*/,'post',{
    'errno':'@integer(0,0)',
    'msg':'@csentence(5,10)',
    'data':{
        'sort_list|19':[
            {
                'id':'@integer(1,100)',
                'name':'@cword(4)',
            }
        ],
        'hot_list|10':[
            {
                'id':'@integer(1,100)',
                'name':'@cword(4)',
                'dl_times':'@integer(500,800)',
                'cover':'@dataimage(50x50)',
            }
        ]
    }
});

//总排行榜数据
Mock.mock(/\/api\/hotlist.*/,'post',{
    'errno':'@integer(0,0)',
    'msg':'@csentence(5,10)',
    
});

//首页数据
Mock.mock(/\/api\/main.*/,'post',{
    'errno':'@integer(0,0)',
    'msg':'@csentence(5,10)',
    'data':{
        'sort_list|4':[
            {
                'name':'@cword(4)',
                'recommend_list|20':[
                    {
                        'rec_id':'@integer(1,200)',
                        'rec_name':'@cword(4,10)',
                        'rec_cover':'@dataImage(200x200)'
                    }
                ],
                'hot_list|10':[
                    {
                        'hot_id':'@integer(1,200)',
                        'hot_name':'@cword(4)'
                    }
                ],
            }
        ],
        'slideshow|4':[
            {
                'cover':'@dataImage(1000x300)',
                'url':'@url',
                'desc':'@cword(20)'
            }
        ]
    }
    
});

//分类页数据
Mock.mock(/\/api\/sort.*/,'post',{
    'errno':'@integer(0,0)',
    'msg':'@csentence(5,10)',
    'data':{
        'total':134,
        "list|10": [
            {
                'id':'@integer(0,200)',
                "name": "@cword(20)", 
                "cover": "@dataImage(100x100)", 
                "size": "20KB", 
                "updated_at": "@date('yyyy-MM-dd')", 
                "description": "@cword(200)"
            }
        ], 
    }
});

//详情页数据
Mock.mock(/\/api\/software\/detail.*/,'post',{
    'errno':'@integer(0,0)',
    'msg':'@csentence(5,10)',
    'data':{
        'name':'@cword(4)',
        'cover':'@dataImage(230x230)',
        'manufactor':'@cword(4)',
        'classification':'@cword(4)',
        'comments':"@integer(500,600)",
        'screenshot|5':[
            '@dataImage(488x488)'
        ],
        'description':'@cparagraph(50,150)',
        'update_log':'@cparagraph(50,150)',
        'size':'20KB',
        'platform':'@word(6)',
        'language':'中文',
        'dl_times':'@integer(100,200)',
        'feature':'@csentence(10)',
        'views':'@integer(100,200)',
        'updated_at':"@datetime('yyyy-MM-dd HH:mm:ss')",
        'fun_intro':'@cparagraph(50,150)',
        'installation_steps':'@cparagraph(50,150)',
        'q_a':'@cparagraph(50,150)',
    }
});

//地址获取数据
Mock.mock(/\/api\/software\/url.*/,'post',{
    'errno':'@integer(0,0)',
    'msg':'@csentence(5,10)',
    'data':{
        'url':'@url',
    }
});

//评论数据获取
Mock.mock(/\/api\/software\/comments.*/,'post',{
    'errno':'@integer(0,0)',
    'msg':'@csentence(5,10)',
    "data": {
        "hot_list|3": [
            {
                'id':'',
                "user_name": "@cname", 
                "user_avatar": "@dataImage(100x100)", 
                "created_at": "@datetime('yyyy-MM-dd HH:mm:ss')", 
                "comment_content": "@cparagraph(10)", 
                "zan": "@integer(300,500)", 
                "cai": "@integer(0,20)",
                'disabled':false,
            }
        ], 
        "normal_comments": {
            "total": 135, 
            "list|10": [
                {
                    'id':'',
                    "user_name": "@cname", 
                    "user_avatar": "@dataImage(100x100)", 
                    "created_at": "@datetime('yyyy-MM-dd HH:mm:ss')", 
                    "comment_content": "@cparagraph(10)", 
                    "zan": "@integer(0,50)", 
                    "cai": "@integer(0,20)",
                    'disabled':false,
                }
            ]
        }
    }
});

//地址获取数据
Mock.mock(/\/api\/software\/comment\/z_c.*/,'post',{
    'errno':'@integer(0,1)',
    'msg':'@csentence(5,10)',
});

//非热评评论数据获取
Mock.mock(/\/api\/software\/normal_comments.*/,'post',{
    'errno':'@integer(0,0)',
    'msg':'@csentence(5,10)',
    "data": {
        "total": 135, 
        "list|10": [
            {
                'id':'',
                "user_name": "@cname", 
                "user_avatar": "@dataImage(100x100)", 
                "created_at": "@datetime('yyyy-MM-dd HH:mm:ss')", 
                "comment_content": "@cparagraph(10)", 
                "zan": "@integer(0,50)", 
                "cai": "@integer(0,20)",
                'disabled':false,
            }
        ]
    }
});