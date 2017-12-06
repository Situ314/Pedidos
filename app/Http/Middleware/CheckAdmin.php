<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
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
        if($request->user()->rol_id > 2){
            return redirect()->back()
                ->withErrors(array('error'=>'No cuenta con los suficientes privilegios para ingresar'));
        }
        return $next($request);
    }
}
