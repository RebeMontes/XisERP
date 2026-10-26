<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    /**
     * Listado completo de categorías (ideal para cargas rápidas o edición en línea).
     */
    public function index(Request $request): JsonResponse
    {
        $categories = Category::orderBy('name', 'asc')->get();

        return response()->json([
            'success' => true,
            'data' => $categories,
        ]);
    }

    /**
     * Registrar una nueva categoría.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100|unique:categories,name',
            'code'        => 'nullable|string|max:30|unique:categories,code',
            'description' => 'nullable|string|max:255',
            'is_active'   => 'required|boolean',
        ]);

        // Por defecto nace activo si no se indica lo contrario
        $validated['is_active'] = $request->input('is_active', true);

        $category = Category::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Categoría agregada exitosamente.',
            'data'    => $category,
        ], 201);
    }

    /**
     * Consultar el detalle de una categoría específica.
     */
    public function show(Category $category): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $category,
        ]);
    }

    /**
     * Actualizar los datos de una categoría existente.
     */
    public function update(Request $request, Category $category): JsonResponse
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100|unique:categories,name,' . $category->id,
            'code'        => 'nullable|string|max:30|unique:categories,code,' . $category->id,
            'description' => 'nullable|string|max:255',
            'is_active'   => 'required|boolean',
        ]);

        $category->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Categoría actualizada exitosamente.',
            'data'    => $category->fresh(),
        ]);
    }

    /**
     * Activar o desactivar el estado de la categoría.
     */
    public function toggleStatus(Category $category): JsonResponse
    {
        $category->is_active = !$category->is_active;
        $category->save();

        $actionWord = $category->is_active ? 'activada' : 'desactivada';

        return response()->json([
            'success' => true,
            'message' => "Categoría {$actionWord} exitosamente.",
            'data'    => $category,
        ]);
    }

    /**
     * Eliminar unidad de la base de datos.
     */
    public function destroy(Category $category): JsonResponse
    {
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Categoría eliminada exitosamente.',
        ]);
    }
}
