<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    /**
     * Iniciar sesión: valida credenciales y retorna el token JWT junto con el usuario.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        try {
            // Intentar autenticar contra el guard de la API
            if (!$token = auth('api')->attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Credenciales inválidas. Verifique su correo o contraseña.',
                ], 401);
            }

            /** @var \App\Models\User $user */
            $user = auth('api')->user();

            // Bloquear acceso si la cuenta fue desactivada por un administrador
            if (!$user->is_active) {
                auth('api')->logout();

                return response()->json([
                    'success' => false,
                    'message' => 'Su cuenta se encuentra inactiva o suspendida. Comuníquese con el administrador del sistema.',
                ], 403);
            }

            return $this->respondWithToken($token, 'Inicio de sesión exitoso.');
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo generar el token de autenticación.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Obtener los datos del usuario autenticado actualmente.
     */
    public function me(): JsonResponse
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no autenticado.',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'is_active' => (bool) $user->is_active,
                ],
            ],
        ]);
    }

    /**
     * Renovar el token JWT antes de que expire.
     */
    public function refresh(): JsonResponse
    {
        try {
            // Genera un nuevo token e invalida el anterior en la lista negra
            $newToken = auth('api')->refresh();

            return $this->respondWithToken($newToken, 'Token renovado con éxito.');
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo renovar el token. Inicie sesión nuevamente.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 401);
        }
    }

    /**
     * Cerrar sesión: invalida el token JWT en el backend.
     */
    public function logout(): JsonResponse
    {
        try {
            auth('api')->logout();

            return response()->json([
                'success' => true,
                'message' => 'Sesión cerrada exitosamente.',
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cerrar sesión.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Estructura estándar de respuesta para tokens JWT y datos del usuario.
     */
    protected function respondWithToken(string $token, string $message = ''): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = auth('api')->user();

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'is_active' => (bool) $user->is_active,
                ],
            ],
        ]);
    }
}
