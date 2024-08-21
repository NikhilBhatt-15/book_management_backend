<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Redis;

use Closure;

class RatelimitingMiddleware
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
        $key = $request->ip();
        if(Redis::exists($key)){
            $amt = Redis::get($key);
            if($amt > 60){
                return response()->json(['message' => 'Rate limit exceeded'], 429);
            }
            Redis::incr($key);
        }
        else{
            Redis::incr($key);
            Redis::expire($key,60);
        }
        return $next($request);
    }
}
