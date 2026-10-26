<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SubcategoryController extends Controller
{
    /**
     * Listado completo de subcategorías.
     */
    public function index(Request $request): JsonResponse
    {
        $subcategories = Subcategory::orderBy('name', 'asc')->get();

        return response()->json([
            'success' => true,
            'data' => $subcategories,
        ]);
    }

    /**
     * Registrar una nueva subcategoría.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:100',
            'code'        => 'nullable|string|max:30',
            'is_active'   => 'required|boolean',
        ]);

        // Por defecto nace activo si no se indica lo contrario
        $validated['is_active'] = $request->input('is_active', true);

        $subcategory = Subcategory::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Subcategoría agregada exitosamente.',
            'data'    => $subcategory,
        ], 201);
    }

    /**
     * Consultar el detalle de una subcategoría específica.
     */
    public function show(Subcategory $subcategory): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $subcategory,
        ]);
    }

    /**
     * Actualizar los datos de una subcategoría existente.
     */
    public function update(Request $request, Subcategory $subcategory): JsonResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:100',
            'code'        => 'nullable|string|max:30',
            'is_active'   => 'required|boolean',
        ]);

        $subcategory->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Subcategoría actualizada exitosamente.',
            'data'    => $subcategory->fresh(),
        ]);
    }

    /**
     * Activar o desactivar el estado de la subcategoría.
     */
    public function toggleStatus(Subcategory $subcategory): JsonResponse
    {
        $subcategory->is_active = !$subcategory->is_active;
        $subcategory->save();

        $actionWord = $subcategory->is_active ? 'activada' : 'desactivada';

        return response()->json([
            'success' => true,
            'message' => "Subcategoría {$actionWord} exitosamente.",
            'data'    => $subcategory,
        ]);
    }

    /**
     * Eliminar unidad de la base de datos.
     */
    public function destroy(Subcategory $subcategory): JsonResponse
    {
        $subcategory->delete();

        return response()->json([
            'success' => true,
            'message' => 'Subcategoría eliminada exitosamente.',
        ]);
    }
}
