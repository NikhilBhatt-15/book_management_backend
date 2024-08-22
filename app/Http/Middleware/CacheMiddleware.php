<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Redis;

use Closure;

class CacheMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    const BASE = "lumen_database_";
    public function handle($request, Closure $next ,$key,$action=null)
    {
        // dd($action);
        if($action){
            Redis::del($key);
        }
        else if(Redis::exists($key)){
            $items = Redis::get($key);
            return response()->json(json_decode($items));
        }

             return $next($request);
    }
}
