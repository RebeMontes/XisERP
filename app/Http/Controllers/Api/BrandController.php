<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Http\JsonResponse;

class BrandController extends Controller
{
     /**
     * Listado completo de unidades (ideal para cargas rápidas o edición en línea).
     */
    public function index(Request $request): JsonResponse
    {
        $brands = Brand::orderBy('name', 'asc')->get();

        return response()->json([
            'success' => true,
            'data' => $brands,
        ]);
    }

    /**
     * Registrar una nueva unidad.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100|unique:brands,name',
            'is_active'   => 'required|boolean',
        ]);

        // Por defecto nace activo si no se indica lo contrario
        $validated['is_active'] = $request->input('is_active', true);

        $brand = Brand::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Marca agregada exitosamente.',
            'data'    => $brand,
        ], 201);
    }

    /**
     * Consultar el detalle de una marca específica.
     */
    public function show(Brand $brand): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $brand,
        ]);
    }

    /**
     * Actualizar los datos de una marca existente.
     */
    public function update(Request $request, Brand $brand): JsonResponse
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100|unique:brands,name,' . $brand->id,
            'is_active'   => 'required|boolean',
        ]);

        $brand->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Marca actualizada exitosamente.',
            'data'    => $brand->fresh(),
        ]);
    }

    /**
     * Activar o desactivar el estado de la marca.
     */
    public function toggleStatus(Brand $brand): JsonResponse
    {
        $brand->is_active = !$brand->is_active;
        $brand->save();

        $actionWord = $brand->is_active ? 'activada' : 'desactivada';

        return response()->json([
            'success' => true,
            'message' => "Marca {$actionWord} exitosamente.",
            'data'    => $brand,
        ]);
    }

    /**
     * Eliminar una marca de la base de datos.
     */
    public function destroy(Brand $brand): JsonResponse
    {
        $brand->delete();

        return response()->json([
            'success' => true,
            'message' => 'Marca eliminada exitosamente.',
        ]);
    }
}
