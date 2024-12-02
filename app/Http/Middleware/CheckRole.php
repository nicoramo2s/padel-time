<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Roles;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Verificar si el usuario está autenticado
        if (!auth()->check()) {
            return JsonResponse(message:'No estas autenticado', errors: 'Unauthorized', status: 401);
        }

        // Verificar si el usuario tiene el rol requerido
        if (auth()->user()->role !== $role) {
            return JsonResponse(message:'Tu rol de usuario no tiene permiso para esta accion', errors: 'Forbidden', status: 403);
        }

        // Continuar con la solicitud si el rol coincide
        return $next($request);
    }
}
