<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Maneja la verificación de roles autorizados para la petición.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  Uno o más roles permitidos (ej. 'admin', 'technician')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = auth('api')->user();

        // Verificar si el usuario está autenticado y si su rol está en los permitidos
        if (!$user || !in_array($user->role, $roles, true)) {
            return response()->json([
                'success' => false,
                'message' => 'Acceso denegado. No tiene los permisos necesarios para realizar esta acción.',
            ], 403);
        }

        return $next($request);
    }
}
