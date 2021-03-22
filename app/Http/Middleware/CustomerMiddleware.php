<?php

namespace App\Http\Middleware;

use App\Enums\RoleEnums;
use Closure;
use Illuminate\Support\Facades\Auth;

class CustomerMiddleware
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
       
        if ( app()->environment('local') )
        {
               return $next($request);
        }
        if ( Auth::guard('api')->check() && request()->user()->role_id === RoleEnums::CUSTOMER) {
             return $next($request);
        } 
         $message = ["message" => "Permission Denied"];
        return response($message, 401);
    }
}
