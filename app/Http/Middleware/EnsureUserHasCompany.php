<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasCompany
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si el usuario está autenticado
        if ($request->user()) {
            // Verificar si el usuario tiene una empresa registrada
            $hasCompany = $request->user()->empresa()->exists();

            // Si no tiene empresa y no está en la ruta de registro de empresa
            if (!$hasCompany && !$request->routeIs('empresa.create') && !$request->routeIs('empresa.store')) {
                return redirect()->route('empresa.create')->with('needs_company','Debes registrar una empresa primero');
            }

            // Si tiene empresa y está intentando acceder al registro de empresa
            if ($hasCompany && ($request->routeIs('empresa.create') || $request->routeIs('empresa.store'))) {
                /* return redirect()->refresh(); */
                return redirect()->route('dashboard.index');
            }
        }

        return $next($request);
    }
}
