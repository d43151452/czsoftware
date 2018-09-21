<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    protected $table = "operation_hst";
    public $timestamps = false;
    protected $fillable = ['uid','uname','operation','time','ip','address','sw_name'];

    public static function saveOperation($uid,$uname,$operation,$sw_name=null)
    {
        $newself = new self;
        $newself->create(['uid'=>$uid,"uname"=>$uname,'operation'=>$operation,'time'=>date("Y-m-d H:i:s"),'ip'=>$newself->getIP(),'address'=>$newself->getAddr(),'sw_name'=>$sw_name,]);
    }

    public function getIP()
    { 
        $arr_ip_header = array('HTTP_CDN_SRC_IP','HTTP_PROXY_CLIENT_IP','HTTP_WL_PROXY_CLIENT_IP','HTTP_CLIENT_IP','HTTP_X_FORWARDED_FOR','REMOTE_ADDR',);
        $client_ip = 'unknown';
        foreach ($arr_ip_header as $key)
        {
            if (!empty($_SERVER[$key]) && strtolower($_SERVER[$key]) != 'unknown')
            {
                $client_ip = $_SERVER[$key];break;
            }
        }

        return $client_ip;
    }

    public function getAddr()
    { 

        $addr = file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip=".self::getIP());

        if(json_decode($addr,true)["code"] == 1 )
        {
            return "未知";
        }

        return json_decode($addr,true)['data']['city'];
    }
}
