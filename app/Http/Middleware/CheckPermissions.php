<?php

namespace App\Http\Middleware;

use Closure;

class CheckPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string $permiso
     * @return mixed
     */
    public function handle($request, Closure $next, $permiso)
    {
        if(! $request->user()->funcionario()->tienePermiso($permiso)){
            return redirect()->route('error', ['title' => 'Acceso Denegado', 'message' => 'No posee permisos de acceso suficientes para la acción solicitada.']);
        }
        
        return $next($request);
    }
}
