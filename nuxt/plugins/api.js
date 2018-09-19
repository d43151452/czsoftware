import axios from 'axios';

if (typeof localStorage != "undefined") {
    // http response 服务器响应拦截器，这里拦截401错误，并重新跳入登页重新获取token
    axios.interceptors.response.use(
        response => {
            return response;
        },
        error => {
            if (error.response) {
                switch (error.response.status) {
                    case 401:
                        localStorage.removeItem('auth');
                        localStorage.removeItem('user_name');
                        location.href='/login';
                }
            }
            return Promise.reject(error.response.data) 
        }
    );
    
}


function ajax_get(url,obj){
    return axios.get('http://localhost:8000/api'+url,obj);
}

function ajax_post(url,obj){
    if (typeof localStorage != "undefined") {
        let token = localStorage.getItem('auth');
        if(token){
            return axios.post('http://localhost:8000/api'+url, obj, {
                headers: {'Authorization': 'Bearer '+token},
            });
        }
    }
    return axios.post('http://localhost:8000/api'+url,obj);
}

export default{
    ajax_get,
    ajax_post
}