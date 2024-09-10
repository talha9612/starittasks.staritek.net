<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class Admin
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
        if(!Auth::check()){
            return redirect()->route('login');
        }
        // For Role 1
        if(Auth::user()->role == 1){
            return $next($request);    
        }
        // For Role 2
        if(Auth::user()->role == 2){
            return redirect()->route('manager');    
        }
        // For Role 3
        if(Auth::user()->role == 3){
            return redirect()->route('user');    
        }
        // For Role 4
        if(Auth::user()->role == 4){
            return redirect()->route('ceo');    
        }
        // For Role 4
        if(Auth::user()->role == 5){
           return redirect()->route('developer');    
       }
    }
}
