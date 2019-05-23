<?php

namespace App\Http\Controllers\Swoole;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
class SwooleController extends Controller
{
    //签到 统计数量
    public function text(){
        $uid=Auth::id();
        //echo $uid;
        $time=date('Y-m-d');
        //echo $time;
        $key="setbit:$time";
        $a=Redis::setbit($key,$uid,1); //redis 用setbit(bitmap)统计活跃用户
        if($a>=0){
           $arr=[
               'error'=>1
           ];
         return $arr;
        }
      //  Redis::bitcount($key);  //可以取出用户数量
    }
    //测试
    public function aa(){
      return view('swoole.text');
    }
}
