<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Session;
use Closure;

class CekSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ... $roles)
    {
        //$dept = Session::get('dept');
        $level = Session::get('level');
        
        if (Session::get('login')== 1){
            
            foreach($roles as $role) {
               
                if($level == $role){

                    return $next($request);
                }
                
            }
            return redirect()->route('home');
          
        }else {
            
            return redirect()->route('login');
        }
    }
}
