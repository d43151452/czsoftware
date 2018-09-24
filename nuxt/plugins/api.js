import axios from 'axios';

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