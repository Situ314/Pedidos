<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\VarDumper\Dumper\DataDumperInterface;

class CheckAutorizador
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
        if($request->user()->rol_id == 3 || $request->user()->rol_id == 5 || $request->user()->rol_id == 1 || $request->user()->rol_id == 2 || $request->user()->rol_id == 8 || $request->user()->rol_id == 10){
            return $next($request);
        }
        return redirect()->back()
            ->withErrors(array('error'=>'No cuenta con los suficientes privilegios para ingresar'));
    }
}
