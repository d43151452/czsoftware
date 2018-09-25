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
        'sort_list|20':[
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
                        'rec_name':'@cword(4)',
                        'rec_cover':'@dataImage(100x100)'
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
                'url':'@dataImage(1000x300)'
            }
        ]
    }
    
});

//分类页数据
Mock.mock(/\/api\/sort.*/,'post',{
    'errno':'@integer(0,0)',
    'msg':'@csentence(5,10)',
    'data':{
        'sort_name':'@cword(4)',
        "list|10": [
            {
                "name": "@cword(20)", 
                "cover": "@dataImage(100x100)", 
                "size": "20KB", 
                "updated_at": "@date('yyyy-MM-dd')", 
                "description": "@cword(200)"
            }
        ], 
    }
});