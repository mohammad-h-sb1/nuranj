<?php

namespace App\Http\Middleware;

use App\Models\V2\Shop;
use Closure;
use Illuminate\Http\Request;

class ShopExpired_at
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
        $shop=Shop::query()->where('id',$request->id);
        $time=$shop->Expired_at()->exists();
        if ($time){
            return $next($request);
        }
        else{
            return response()->json([
                'status'=>'error',
                'massage'=>'غیر فعال'
            ],403);
        }
    }
}
