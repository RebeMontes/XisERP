<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * Listado paginado de productos con búsqueda, filtros y ordenamiento.
     */
    public function index(Request $request): JsonResponse
    {
        // Cargamos las relaciones para que category, brand y unit lleguen al frontend
        $query = Product::with(['categories', 'subcategories', 'brands', 'units']);

        // Búsqueda por texto en tiempo real
        if ($search = $request->input('search')) {
            $search = trim($search);
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                  ->orWhere('product_type', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('category_id', 'like', "%{$search}%")
                  ->orWhere('subcategory_id', 'like', "%{$search}%")
                  ->orWhere('brand_id', 'like', "%{$search}%")
                  ->orWhere('unit_id', 'like', "%{$search}%");
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
        $sortBy = $request->input('sortBy', 'description');
        
        // Mapear alias enviados desde las columnas de Quasar
        if ($sortBy === 'status') {
            $sortBy = 'is_active';
        }

        $sortOrder = $request->input('descending') === 'true' || $request->input('sortOrder') === 'desc' ? 'desc' : 'asc';
        
        $allowedSorts = [
            'id', 'code', 'product_type', 'description', 'category_id', 'subcategory_id', 'brand_id', 'unit_id',
            'taxid', 'is_active', 'created_at', 'updated_at'
        ];

        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('description', 'asc');
        }

        // Paginación o colección completa (perPage = -1 para dropdowns/selects)
        $perPage = (int) $request->input('perPage', 10);

        if ($perPage === -1) {
            $products = $query->get();
            return response()->json([
                'success' => true,
                'data' => $products,
                'meta' => [
                    'total' => $products->count(),
                    'current_page' => 1,
                    'per_page' => $products->count(),
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
     * Registrar un nuevo producto.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'code'                  => 'required|string|max:50|unique:products,code',
            'sat_product_code'      => 'nullable|string|max:8',
            'product_type'          => 'required|string|max:50',
            'category_id'           => 'nullable|exists:categories,id',
            'subcategory_id'        => 'nullable|exists:subcategories,id',
            'brand_id'              => 'nullable|exists:brands,id',
            'unit_id'               => 'required|exists:units,id',
            'description'           => 'required|string|max:255',
            'cost'                  => 'required|numeric|min:0',
            'retail_price'          => 'required|numeric|min:0',
            'wholesale_price'       => 'nullable|numeric|min:0',
            'tax_object_code'       => 'nullable|string|max:10',
            'track_inventory'       => 'required|boolean',
            'stock_quantity'        => 'required|numeric|min:0',
            'minimum_stock'         => 'required|numeric|min:0',
            'storage_location'      => 'nullable|string|max:100',
            'image_path'            => 'nullable|string|max:500',
            'is_active'             => 'required|boolean',
        ]);

        // Por defecto nace activo si no se indica lo contrario
        $validated['is_active'] = $request->input('is_active', true);
        $validated['user_id'] = auth()->id(); // Asigna el usuario autenticado actual

        $product = Product::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Producto creado exitosamente.',
            'data' => $product->load(['categories', 'subcategories', 'brands', 'units']),
        ], 201);
    }

    /**
     * Consultar el detalle de un producto específico.
     */
    public function show(Product $product): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $product->load(['categories', 'subcategories', 'brands', 'units']),
        ]);
    }

    /**
     * Actualizar los datos de un producto existente.
     */
    public function update(Request $request, Product $product): JsonResponse
    {
        $validated = $request->validate([
            'code'                  => 'required|string|max:50|unique:products,code,' . $product->id,
            'sat_product_code'      => 'nullable|string|max:8',
            'product_type'          => 'required|string|max:50',
            'category_id'           => 'nullable|exists:categories,id',
            'subcategory_id'        => 'nullable|exists:subcategories,id',
            'brand_id'              => 'nullable|exists:brands,id',
            'unit_id'               => 'required|exists:units,id',
            'description'           => 'required|string|max:255',
            'cost'                  => 'required|numeric|min:0',
            'retail_price'          => 'required|numeric|min:0',
            'wholesale_price'       => 'nullable|numeric|min:0',
            'tax_object_code'       => 'nullable|string|max:10',
            'track_inventory'       => 'required|boolean',
            'stock_quantity'        => 'required|numeric|min:0',
            'minimum_stock'         => 'required|numeric|min:0',
            'storage_location'      => 'nullable|string|max:100',
            'image_path'            => 'nullable|string|max:500',
            'is_active'             => 'required|boolean',
        ]);

        $product->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Producto actualizado exitosamente.',
            'data' => $product->fresh()->load(['categories', 'subcategories', 'brands', 'units']),
        ]);
    }

    /**
     * Activar o desactivar el estado del producto.
     */
    public function toggleStatus(Product $product): JsonResponse
    {
        $product->is_active = !$product->is_active;
        $product->save();

        $actionWord = $product->is_active ? 'activado' : 'desactivado';

        return response()->json([
            'success' => true,
            'message' => "Producto {$actionWord} exitosamente.",
            'data' => $product->load(['categories', 'subcategories', 'brands', 'units']),
        ]);
    }

    /**
     * Eliminar producto de la base de datos.
     */
    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado exitosamente.',
        ]);
    }
}