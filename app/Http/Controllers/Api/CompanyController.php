<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Listado paginado de empresas con búsqueda, filtros y ordenamiento.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Company::query();

        // Búsqueda por texto en tiempo real
        if ($search = $request->input('search')) {
            $search = trim($search);
            $query->where(function ($q) use ($search) {
                $q->where('legal_name', 'like', "%{$search}%")
                  ->orWhere('trade_name', 'like', "%{$search}%")
                  ->orWhere('tax_id', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
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

        // Ordenamiento
        $sortBy = $request->input('sortBy', 'legal_name');
        
        // Mapear alias enviados desde las columnas de Quasar
        if ($sortBy === 'tax_info') {
            $sortBy = 'tax_id';
        } elseif ($sortBy === 'status') {
            $sortBy = 'is_active';
        }

        $sortOrder = $request->input('descending') === 'true' || $request->input('sortOrder') === 'desc' ? 'desc' : 'asc';
        
        $allowedSorts = [
            'id', 'legal_name', 'trade_name', 
            'tax_id', 'is_active', 'created_at', 'updated_at'
        ];

        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('legal_name', 'asc');
        }

        // Paginación o colección completa (perPage = -1 para dropdowns/selects)
        $perPage = (int) $request->input('perPage', 10);

        if ($perPage === -1) {
            $companies = $query->get();
            return response()->json([
                'success' => true,
                'data' => $companies,
                'meta' => [
                    'total' => $companies->count(),
                    'current_page' => 1,
                    'per_page' => $companies->count(),
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
     * Registrar una nueva empresa.
     */
    public function store(Request $request): JsonResponse
    {
        $validated['user_id'] = auth()->id(); // Asigna el usuario autenticado actual
        $validated = $request->validate([
            'tax_id'             => 'nullable|string|max:13',
            'tax_regime'         => 'nullable|string|max:10',
            'legal_name'         => 'required|string|max:200',
            'trade_name'         => 'nullable|string|max:150',
            'personal_id'        => 'nullable|string|max:18',
            'street'             => 'nullable|string|max:150',
            'exterior_num'    => 'nullable|string|max:20',
            'interior_num'    => 'nullable|string|max:20',
            'neighborhood'       => 'nullable|string|max:120',
            'city'               => 'nullable|string|max:100',
            'municipality'       => 'nullable|string|max:100',
            'state'              => 'nullable|string|max:100',
            'country'            => 'required|string|max:100',
            'postal_code'        => 'nullable|string|max:10',
            'address_references' => 'nullable|string',
            'phone'              => 'nullable|string|max:20',
            'phone_type'         => 'nullable|string|max:20',
            'whatsapp'           => 'nullable|string|max:20',
            'email'              => 'nullable|email|max:254',
            'notes'              => 'nullable|string',
            'is_active'          => 'required|boolean',
        ]);

        // Por defecto nace activo si no se indica lo contrario
        $validated['is_active'] = $request->input('is_active', true);

        $validated['user_id'] = auth()->id(); // Asigna el usuario autenticado actual

        $company = Company::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Empresa agregada exitosamente.',
            'data' => $company,
        ], 201);
    }

    /**
     * Consultar el detalle de una empresa específica.
     */
    public function show(Company $company): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $company,
        ]);
    }

    /**
     * Actualizar los datos de una empresa existente.
     */
    public function update(Request $request, Company $company): JsonResponse
    {
        $validated = $request->validate([
            'tax_id'             => 'nullable|string|max:13', 
            'tax_regime'         => 'nullable|string|max:10',
            'legal_name'         => 'required|string|max:200',
            'trade_name'         => 'nullable|string|max:150',
            'personal_id'        => 'nullable|string|max:18',
            'street'             => 'nullable|string|max:150',
            'exterior_number'    => 'nullable|string|max:20',
            'interior_number'    => 'nullable|string|max:20',
            'neighborhood'       => 'nullable|string|max:120',
            'city'               => 'nullable|string|max:100',
            'municipality'       => 'nullable|string|max:100',
            'state'              => 'nullable|string|max:100',
            'country'            => 'required|string|max:100',
            'postal_code'        => 'nullable|string|max:10',
            'address_references' => 'nullable|string',
            'phone'              => 'nullable|string|max:20',
            'phone_type'         => 'nullable|string|max:20',
            'whatsapp'           => 'nullable|string|max:20',
            'email'              => 'nullable|email|max:254',
            'notes'              => 'nullable|string',
            'is_active'          => 'required|boolean',
        ]);

        $company->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Empresa actualizada exitosamente.',
            'data' => $company->fresh(),
        ]);
    }

    /**
     * Activar o desactivar el estado de la empresa.
     */
    public function toggleStatus(Company $company): JsonResponse
    {
        $company->is_active = !$company->is_active;
        $company->save();

        $actionWord = $company->is_active ? 'activado' : 'desactivado';

        return response()->json([
            'success' => true,
            'message' => "Empresa {$actionWord} exitosamente.",
            'data' => $company,
        ]);
    }

    /**
     * Eliminar empresa de la base de datos.
     */
    public function destroy(Company $company): JsonResponse
    {
        $company->delete();

        return response()->json([
            'success' => true,
            'message' => 'Empresa eliminada exitosamente.',
        ]);
    }
}
