<?php

namespace App\Http\Middleware;

use Closure;

class CheckResponsableEntrega
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
        if($request->user()->rol_id != 7){
            return redirect()->back()
                ->withErrors(array('error'=>'No cuenta con los suficientes privilegios para ingresar'));
        }

        return $next($request);
    }
}
