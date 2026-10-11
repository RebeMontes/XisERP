<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Listado paginado de usuarios con búsqueda, filtros y ordenamiento.
     */
    public function index(Request $request): JsonResponse
    {
        $query = User::query();

        // Búsqueda por texto (Nombre o Correo)
        if ($search = $request->input('search')) {
            $search = trim($search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filtro por Rol (admin o technician)
        if ($role = $request->input('role')) {
            if (in_array($role, ['admin', 'technician'])) {
                $query->where('role', $role);
            }
        }

        // Filtro por Estado (Activo / Inactivo)
        if ($request->has('status') && $request->input('status') !== null && $request->input('status') !== '') {
            $status = $request->input('status');
            if ($status === 'active' || $status === '1' || $status === true) {
                $query->where('is_active', true);
            } elseif ($status === 'inactive' || $status === '0' || $status === false) {
                $query->where('is_active', false);
            }
        }

        // Ordenamiento (por defecto alfabético por nombre A-Z)
        $sortBy = $request->input('sortBy', 'name');
        // Mapear alias enviados desde las columnas de Quasar
        if ($sortBy === 'user') {
            $sortBy = 'name';
        } elseif ($sortBy === 'status') {
            $sortBy = 'is_active';
        }

        $sortOrder = $request->input('descending') === 'true' || $request->input('sortOrder') === 'desc' ? 'desc' : 'asc';
        $allowedSorts = ['id', 'name', 'email', 'role', 'is_active', 'created_at'];

        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('name', 'asc');
        }

        // Paginación o lista completa (perPage = -1 para dropdowns/selects)
        $perPage = (int) $request->input('perPage', 15);

        if ($perPage === -1) {
            $users = $query->get();
            return response()->json([
                'success' => true,
                'data' => $users,
                'meta' => [
                    'total' => $users->count(),
                    'current_page' => 1,
                    'per_page' => $users->count(),
                    'last_page' => 1,
                ],
            ]);
        }

        $paginator = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $paginator->items(),
            'meta' => [
                'total' => $paginator->total(),
                'current_page' => $paginator->currentPage(),
                'per_page' => $paginator->perPage(),
                'last_page' => $paginator->lastPage(),
            ],
        ]);
    }

    /**
     * Registrar un nuevo usuario con contraseña hasheada.
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => $request->is_active ?? true,
        ];

        $user = User::create($userData);

        return response()->json([
            'success' => true,
            'message' => 'Usuario creado exitosamente.',
            'data' => $user,
        ], 201);
    }

    /**
     * Consultar el detalle de un usuario específico.
     */
    public function show(User $user): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $user,
        ]);
    }

    /**
     * Actualizar los datos de un usuario (la contraseña es opcional).
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'is_active' => $request->is_active ?? $user->is_active,
        ];

        // Solo actualizar contraseña si se proporcionó una nueva
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        return response()->json([
            'success' => true,
            'message' => 'Usuario actualizado exitosamente.',
            'data' => $user->fresh(),
        ]);
    }

    /**
     * Habilitar o deshabilitar una cuenta de usuario.
     */
    public function toggleStatus(User $user): JsonResponse
    {
        $currentUser = auth('api')->user();

        // Evitar que el usuario logueado desactive su propia cuenta
        if ($currentUser && $currentUser->id === $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'No puede desactivar su propia cuenta de usuario mientras tiene la sesión activa.',
            ], 400);
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $actionWord = $user->is_active ? 'activado' : 'desactivado';

        return response()->json([
            'success' => true,
            'message' => "Usuario {$actionWord} exitosamente.",
            'data' => $user,
        ]);
    }

    /**
     * Eliminar un usuario (protegiendo la cuenta en sesión).
     */
    public function destroy(User $user): JsonResponse
    {
        $currentUser = auth('api')->user();

        if ($currentUser && $currentUser->id === $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'No puede eliminar su propia cuenta de usuario.',
            ], 400);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Usuario eliminado exitosamente.',
        ]);
    }
}
