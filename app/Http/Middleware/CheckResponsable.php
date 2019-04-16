<?php

namespace App\Http\Middleware;

use Closure;

class CheckResponsable
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
        if($request->user()->rol_id == 4 || $request->user()->rol_id == 1 || $request->user()->rol_id == 2 || $request->user()->rol_id == 7 || $request->user()->rol_id == 8){
            return $next($request);
        }
        return redirect()->back()
            ->withErrors(array('error'=>'No cuenta con los suficientes privilegios para ingresar'));
    }
}
