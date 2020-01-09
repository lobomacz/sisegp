<?php

namespace App\Http\Middleware;

use Closure;

class CheckRol
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string $rol
     * @return mixed
     */
    public function handle($request, Closure $next, $rol)
    {
        if(! $request->user()->funcionario->tieneRol($rol)){
            return redirect()->route('error', ['title' => 'Acceso Denegado', 'message' => 'No posee permisos de acceso suficientes para la acción solicitada.']);
        }

        return $next($request);
    }
}
