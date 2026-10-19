<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
    /**
     * Listado paginado de clientes con búsqueda, filtros y ordenamiento.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Customer::query();

        // Búsqueda por texto en tiempo real
        if ($search = $request->input('search')) {
            $search = trim($search);
            $query->where(function ($q) use ($search) {
                $q->where('legal_name', 'like', "%{$search}%")
                  ->orWhere('trade_name', 'like', "%{$search}%")
                  ->orWhere('customer_number', 'like', "%{$search}%")
                  ->orWhere('taxid', 'like', "%{$search}%")
                  ->orWhere('contact_name', 'like', "%{$search}%")
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
            $sortBy = 'taxid';
        } elseif ($sortBy === 'status') {
            $sortBy = 'is_active';
        }

        $sortOrder = $request->input('descending') === 'true' || $request->input('sortOrder') === 'desc' ? 'desc' : 'asc';
        
        $allowedSorts = [
            'id', 'customer_number', 'legal_name', 'trade_name', 
            'taxid', 'is_active', 'created_at', 'updated_at'
        ];

        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('legal_name', 'asc');
        }

        // Paginación o colección completa (perPage = -1 para dropdowns/selects)
        $perPage = (int) $request->input('perPage', 10);

        if ($perPage === -1) {
            $customers = $query->get();
            return response()->json([
                'success' => true,
                'data' => $customers,
                'meta' => [
                    'total' => $customers->count(),
                    'current_page' => 1,
                    'per_page' => $customers->count(),
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
     * Registrar un nuevo cliente.
     */
    public function store(Request $request): JsonResponse
    {
        $validated['user_id'] = auth()->id(); // Asigna el usuario autenticado actual
        $validated = $request->validate([
            'customer_number'    => 'required|string|max:30|unique:customers,customer_number',
            'taxid'             => 'nullable|string|max:13',
            'tax_regime'         => 'nullable|string|max:10',
            'legal_name'         => 'required|string|max:200',
            'trade_name'         => 'nullable|string|max:150',
            'payment_method'     => 'nullable|string|max:30',
            'account_num'     => 'nullable|string|max:50',
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
            'contact_name'       => 'nullable|string|max:150',
            'notes'              => 'nullable|string',
            'is_active'          => 'required|boolean',
        ]);

        // Por defecto nace activo si no se indica lo contrario
        $validated['is_active'] = $request->input('is_active', true);

        $validated['user_id'] = auth()->id(); // Asigna el usuario autenticado actual

        $customer = Customer::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Cliente creado exitosamente.',
            'data' => $customer,
        ], 201);
    }

    /**
     * Consultar el detalle de un cliente específico.
     */
    public function show(Customer $customer): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $customer,
        ]);
    }

    /**
     * Actualizar los datos de un cliente existente.
     */
    public function update(Request $request, Customer $customer): JsonResponse
    {
        $validated = $request->validate([
            'customer_number' => 'required|string|max:50|unique:customers,customer_number,' . $customer->id,
            'taxid'             => 'nullable|string|max:13',
            'tax_regime'         => 'nullable|string|max:10',
            'legal_name'         => 'required|string|max:200',
            'trade_name'         => 'nullable|string|max:150',
            'payment_method'     => 'nullable|string|max:30',
            'account_number'     => 'nullable|string|max:50',
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
            'contact_name'       => 'nullable|string|max:150',
            'notes'              => 'nullable|string',
            'is_active'          => 'required|boolean',
        ]);

        $customer->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Cliente actualizado exitosamente.',
            'data' => $customer->fresh(),
        ]);
    }

    /**
     * Activar o desactivar el estado del cliente.
     */
    public function toggleStatus(Customer $customer): JsonResponse
    {
        $customer->is_active = !$customer->is_active;
        $customer->save();

        $actionWord = $customer->is_active ? 'activado' : 'desactivado';

        return response()->json([
            'success' => true,
            'message' => "Cliente {$actionWord} exitosamente.",
            'data' => $customer,
        ]);
    }

    /**
     * Eliminar cliente de la base de datos.
     */
    public function destroy(Customer $customer): JsonResponse
    {
        $customer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cliente eliminado exitosamente.',
        ]);
    }
}