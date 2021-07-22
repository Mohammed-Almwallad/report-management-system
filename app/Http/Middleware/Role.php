<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ... $roles)
    {
        $user = Auth()->user();

        if($user->isAdmin()){
            return $next($request);
        }

        foreach ($roles as $key => $role) {
            if($user->hasRole($role)){
                return $next($request);
            }
        }


        return back()->with('error','Unauthorized page.');
    }
}
