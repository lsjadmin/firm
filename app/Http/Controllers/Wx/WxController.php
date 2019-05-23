<?php

namespace App\Http\Controllers\Wx;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
class WxController extends Controller
{
    //获得token
    public function token(){
        $key="wx_access_token";
        $token=Redis::get($key);
        if($token){

        }else{
            $appid=env('APPID');
            $secret=env('appsecret');
           // echo $appid;
            $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$secret";
            //echo $url;
            $respose=json_decode(file_get_contents($url),true);
            //echo "</pre>";print_r($respose);echo "</pre>";
            $token=$respose['access_token'];
            Redis::set($key,$token);
            Redis::expire($key,3600);
        }
        return $token;
      
    }
    //群发
    public function mass(){
        $array=[
            '时间是一切财富中最宝贵的财富',
            '世界上一成不变的东西，只有“任何事物都是在不断变化的”这条真理',
            '过放荡不羁的生活，容易得像顺水推舟，但是要结识良朋益友，却难如登天。',
            '生活有度，人生添寿'
        ];
        $a=array_rand($array);
        $b=$array[$a];
        //dd($a);
        $token=$this->token();
        //echo $token;die;
        $url="https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=$token";
        $rand=Str::random(10);
            $data=[
                
                    "touser"=>[
                    "oCeEX1sDfbqkaguYkL1D2Qj4qz30",
                    "oCeEX1p4LyuDYV16wOIKTyICKyW4"
                    ],
                    "msgtype"=>"text",
                    "text"=> [ 
                        "content"=>$rand
                        ]
                
                ];
                $a=json_encode($data,JSON_UNESCAPED_UNICODE);
                $ch=curl_init();
                //通过 curl_setopt() 设置需要的全部选项
                curl_setopt($ch, CURLOPT_URL,$url);
                //禁止浏览器输出 ，使用变量接收
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST,1);
                //把数据传输过去
                curl_setopt($ch,CURLOPT_POSTFIELDS,$a);
                //执行会话
                $res=curl_exec($ch);
                //结束一个会话
                curl_close($ch);
                dd($res);
    }
}
