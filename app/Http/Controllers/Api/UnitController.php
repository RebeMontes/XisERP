<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UnitController extends Controller
{
    /**
     * Listado completo de unidades (ideal para cargas rápidas o edición en línea).
     */
    public function index(Request $request): JsonResponse
    {
        $units = Unit::orderBy('name', 'asc')->get();

        return response()->json([
            'success' => true,
            'data' => $units,
        ]);
    }

    /**
     * Registrar una nueva unidad.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:80',
            'symbol'        => 'nullable|string|max:15',
            'sat_unit_code' => 'nullable|string|max:3',
            'is_active'   => 'required|boolean',
        ]);

        // Por defecto nace activo si no se indica lo contrario
        $validated['is_active'] = $request->input('is_active', true);

        $unit = Unit::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Unidad agregada exitosamente.',
            'data'    => $unit,
        ], 201);
    }

    /**
     * Consultar el detalle de una unidad específica.
     */
    public function show(Unit $unit): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $unit,
        ]);
    }

    /**
     * Actualizar los datos de una unidad existente.
     */
    public function update(Request $request, Unit $unit): JsonResponse
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:80',
            'symbol'        => 'nullable|string|max:15',
            'sat_unit_code' => 'nullable|string|max:3',
            'is_active'   => 'required|boolean',
        ]);

        $unit->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Unidad actualizada exitosamente.',
            'data'    => $unit->fresh(),
        ]);
    }

    /**
     * Activar o desactivar el estado de la unidad.
     */
    public function toggleStatus(Unit $unit): JsonResponse
    {
        $unit->is_active = !$unit->is_active;
        $unit->save();

        $actionWord = $unit->is_active ? 'activada' : 'desactivada';

        return response()->json([
            'success' => true,
            'message' => "Unidad {$actionWord} exitosamente.",
            'data'    => $unit,
        ]);
    }

    /**
     * Eliminar unidad de la base de datos.
     */
    public function destroy(Unit $unit): JsonResponse
    {
        $unit->delete();

        return response()->json([
            'success' => true,
            'message' => 'Unidad eliminada exitosamente.',
        ]);
    }
}

