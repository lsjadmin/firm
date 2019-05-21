<?php

namespace App\Http\Controllers\Firm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\FirmModel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;
class FirmController extends Controller
{
   
         //注册
        public function reg(){
            //echo "aa";
            $where=[
                'u_id'=>Auth::id()
            ];
            $data=FirmModel::where($where)->first();
           if($data){
               $appid=$data->app_id;
               $key=$data->key;
               return view('firm.status',['appid'=>$appid,'key'=>$key]);
           }else{
               return view('firm.firm');
           }
        }
        //注册执行
        public function rega(Request $request){
                $data=request()->input();
                $data['firm_business']=$this->upload($request,'firm_business');
                $data['time']=time();
                $data['u_id']=Auth::id();
                //dd($data);
                $res=FirmModel::insert($data);
                if($res){
                    echo "注册成功，请等待审核";
                }else{
                    echo "no";
                }
        }
        //文件上传
        public function upload(Request $request,$fieldname){
            //判断是否上传 是否错误
            if ($request->hasFile($fieldname) && $request->file($fieldname)->isValid()) {
                $photo = $request->file($fieldname);
            // $extension = $photo->extension();
                //$store_result = $photo->store('photo');
                $store_result = $photo->store('uploads/'.date('Ymd'));
                //返回一个路径
                return $store_result;
                }
        }
        //生成token
        public function token(Request $request){
            $appid=$request->input('appid');
            $key=$request->input('key');
            if(empty($appid)||empty($key)){
                die('请求参数缺失');
            }
            $redisnum="redis_num";
            $num=Redis::get($redisnum);
            if($num>200){
                die('请求次数超过限制');
            }
            Redis::incr($redisnum);
            Redis::expire($redisnum,86400);
            //判断appid是否能跟数据库匹配
            $res=FirmModel::where(['app_id'=>$appid])->first();
            if($res->app_id==$appid){
                 $token=substr(md5($appid.$key),5,10);
                 $redis="s_token";
                $key="firm_token.appid:$appid";
                //储存个集合（进行token比较）
                Redis::Sadd($redis,$token);
                Redis::set($key,$token);
                Redis::expire($key,3600);
                echo $token;
            }else{
                echo "数据不匹配";
            }
        }
        //获取到token
        public function acess_token(){
            $appid=env('APP_ID');
            $key=env('KEY');
            // echo $key;
            $urla=env('URLA');
            $url="http://$urla/firm/token?appid=$appid&key=$key";
            $ch=curl_init($url);
            //通过 curl_setopt() 设置需要的全部选项
            curl_setopt($ch, CURLOPT_HEADER,0);
            //禁止浏览器输出 ，使用变量接收
             curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            //执行会话
            $token=curl_exec($ch); //token 获取到的token
            //结束一个会话
            curl_close($ch);
            $key="firm_token.appid:$appid";
            Redis::set($key,$token);
            Redis::expire($key,3600);
            //echo $token;
            return $token;
        }
        //客户端IP
        public function client(){
            
            $ip=$_SERVER['SERVER_ADDR']??'';
            //dd($ip);
            if($ip){
                $arr=[
                    'errno'=>200,
                    'msg'=>'客户端ip'.$ip
                ];
             return json_encode($arr,JSON_UNESCAPED_UNICODE);
            }else{
                $arr=[
                    'errno'=>40001,
                    'msg'=>'获的客户端ip失败'
                ];
                return json_encode($arr,JSON_UNESCAPED_UNICODE);
        
            }
        }
        //显示客户端IP(请求端)
        public function clienta(){
            $token=$this->acess_token();
            //echo $url;
            $urla=env('URLA');
            $url="http://$urla/firm/client?token=$token";
           // echo $url;die;
            $ch=curl_init($url);
            //通过 curl_setopt() 设置需要的全部选项
            curl_setopt($ch, CURLOPT_HEADER,0);
            //禁止浏览器输出 ，使用变量接收
             curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            //执行会话
            $ip=curl_exec($ch); //token 获取到的token
            //结束一个会话
            curl_close($ch);
            echo $ip;

        }
        //客户端ua
        public function clientu(){
            $clientu=$_SERVER['HTTP_USER_AGENT']??''; //获的客户端ua
              //echo $clientu;die;
           if($clientu){
                    $arr=[
                        'errno'=>200,
                        'msg'=>'客户端UA:'.$clientu
                    ];
                return json_encode($arr,JSON_UNESCAPED_UNICODE);
           }else{
                    $arr=[
                        'errno'=>40001,
                        'msg'=>'获的客户端UA失败'
                    ];
                return json_encode($arr,JSON_UNESCAPED_UNICODE);
           }
        }
        //显示客户端UA
        public function clientua(){
            //获的token
            $token=$this->acess_token();
            //echo $url;
            $url="http://1809a.firm.com/firm/clientu?token=$token";
            //echo $url;die;
            $ca=curl_init();
            //通过 curl_setopt() 设置需要的全部选项
            curl_setopt($ca,CURLOPT_URL,$url);
            curl_setopt($ca, CURLOPT_HEADER,0);
            //禁止浏览器输出 ，使用变量接收
             //curl_setopt($ca, CURLOPT_RETURNTRANSFER, 1);
            //执行会话
            curl_exec($ca); //token 获取到的ua
            //结束一个会话
            // $a=curl_errno($ca);
            // echo $a;
            curl_close($ca);
        }
        //显示用户注册信息
        public function listreg(){
          $where=[
              'u_id'=>Auth::id()
          ];
            $data=FirmModel::where($where)->first();
            if($data){
                $arr=[
                    'errno'=>200,
                    'msg'=>[
                        'data'=>$data
                    ]
                ];
             return json_encode($arr,JSON_UNESCAPED_UNICODE);
            }else{
                $arr=[
                    'errno'=>200,
                    'msg'=>'获得用户信息失败'
                ];
             return json_encode($arr,JSON_UNESCAPED_UNICODE);
            }
            //return $data;
        }
        //获得注册用户信息
        public function attrreg(){
                $token=$this->acess_token();
                $appid=env('APP_ID');
                $urla=env('URLA');
                $url="http://$urla/firm/listreg?token=$token&appid=$appid";
                // echo $url;die;
                 $ch=curl_init($url);
                 //通过 curl_setopt() 设置需要的全部选项
                 curl_setopt($ch, CURLOPT_HEADER,0);
                 //禁止浏览器输出 ，使用变量接收
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                 //执行会话
                 $ip=curl_exec($ch); //token 获取到的token
                 //结束一个会话
                 curl_close($ch);
                 dd($ip);
            }

        
        




}
