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

//分类
Mock.mock(/\/api\/sort.*/,'post',{
    'errno':'@integer(0,0)',
    'msg':'@csentence(5,10)',
    'data|20':[
        {
            'sort_id':'@integer(1,100)',
            'sort_name':'@cword(4)',
        }
    ]
});

//总排行榜数据
Mock.mock(/\/api\/hotlist.*/,'post',{
    'errno':'@integer(0,0)',
    'msg':'@csentence(5,10)',
    'data|10':[
        {
            'id':'@integer(1,100)',
            'name':'@cword(4)',
            'dl_time':'@integer(500,800)',
            'cover':'@dataimage(50x50)',
        }
    ]
});

//首页数据
Mock.mock(/\/api\/main.*/,'post',{
    'errno':'@integer(0,0)',
    'msg':'@csentence(5,10)',
    'data|4':[
        {
            'name':'@cword(4)',
            'recommend_list|20':[
                {
                    'rec_name':'@cword(4)',
                    'rec_cover':'@dataImage(100x100)'
                }
            ],
            'hot_list|10':[
                {
                    'hot_name':'@cword(4)'
                }
            ]
        }
    ]
});
