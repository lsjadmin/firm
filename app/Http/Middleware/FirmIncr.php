<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;
class FirmIncr
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
           // echo "aa";
        $url_hash=substr(md5($_SERVER['REQUEST_URI']),0,10);//获得访问路径 域名以外的东西
        $key='firm_filter:url'.$url_hash;
        Redis::incr($key);
        Redis::expire($key,60);
        $num=Redis::get($key);
        echo "num:";echo $num;
        if($num>20){
            //超过限制一天以后才能再次请求
            Redis::expire($key,68400);
            die("请求超过限制");
        }
        return $next($request);
    }
}
