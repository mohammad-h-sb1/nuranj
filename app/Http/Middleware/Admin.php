<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->type === 'admin'){
            return $next($request);
        }
        else {
            return  response()->json([
                'status'=>'error',
                'manager'=>'شما دسترسی ندارید'
            ],403);
        }
    }
}
