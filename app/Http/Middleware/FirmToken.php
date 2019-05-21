<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;
class FirmToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //echo "aa";
       $token=$request->input('token');
        if(empty($token)){
            die('没有参数');
        };
        $key="s_token";
        $res=Redis::Sismember($key,$token); //判断成员元素是否是集合的成员
       // dd($res);
        if($res=='true'){

        }else{
            die('toekn不匹配');
        }
        return $next($request);
    }
}
