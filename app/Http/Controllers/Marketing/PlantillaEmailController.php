<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\EtiquetaPlantilla;
use App\Models\PlantillaEmail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PlantillaEmailController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $busqueda = trim((string) $request->input('busqueda'));
        $etiquetaId = $request->input('etiqueta_id');

        $query = PlantillaEmail::with('etiquetas');

        if ($busqueda !== '') {
            $query->where('nombre', 'like', "%{$busqueda}%");
        }

        if ($etiquetaId) {
            $query->whereHas('etiquetas', fn($q) => $q->where('etiquetas_plantilla.id', $etiquetaId));
        }

        return response()->json([
            'success' => true,
            'plantillas' => $query->orderByDesc('updated_at')->get()->map(fn($p) => $this->serializar($p)),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:120',
            'asunto' => 'nullable|string|max:255',
            'contenido_html' => 'required|string',
            'logo_path' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string|max:500',
            'es_global' => 'nullable|boolean',
            'etiquetas' => 'nullable|array',
            'etiquetas.*' => 'integer|exists:etiquetas_plantilla,id',
        ]);

        $plantilla = PlantillaEmail::create([
            'nombre' => $datos['nombre'],
            'asunto' => $datos['asunto'] ?? null,
            'contenido_html' => $datos['contenido_html'],
            'logo_path' => $datos['logo_path'] ?? null,
            'descripcion' => $datos['descripcion'] ?? null,
            'es_global' => $datos['es_global'] ?? true,
            'user_id' => Auth::id(),
        ]);

        if (!empty($datos['etiquetas'])) {
            $plantilla->etiquetas()->sync($datos['etiquetas']);
        }

        return response()->json([
            'success' => true,
            'plantilla' => $this->serializar($plantilla->load('etiquetas')),
        ]);
    }

    public function update(Request $request, PlantillaEmail $plantilla): JsonResponse
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:120',
            'asunto' => 'nullable|string|max:255',
            'contenido_html' => 'required|string',
            'logo_path' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string|max:500',
            'es_global' => 'nullable|boolean',
            'etiquetas' => 'nullable|array',
            'etiquetas.*' => 'integer|exists:etiquetas_plantilla,id',
        ]);

        $plantilla->update([
            'nombre' => $datos['nombre'],
            'asunto' => $datos['asunto'] ?? null,
            'contenido_html' => $datos['contenido_html'],
            'logo_path' => $datos['logo_path'] ?? null,
            'descripcion' => $datos['descripcion'] ?? null,
            'es_global' => $datos['es_global'] ?? $plantilla->es_global,
        ]);

        $plantilla->etiquetas()->sync($datos['etiquetas'] ?? []);

        return response()->json([
            'success' => true,
            'plantilla' => $this->serializar($plantilla->load('etiquetas')),
        ]);
    }

    public function destroy(PlantillaEmail $plantilla): JsonResponse
    {
        $plantilla->delete();
        return response()->json(['success' => true]);
    }

    public function listarEtiquetas(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'etiquetas' => EtiquetaPlantilla::orderBy('nombre')->get(),
        ]);
    }

    public function crearEtiqueta(Request $request): JsonResponse
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:60|unique:etiquetas_plantilla,nombre',
            'color' => 'nullable|string|max:7',
        ]);

        $etiqueta = EtiquetaPlantilla::create([
            'nombre' => $datos['nombre'],
            'color' => $datos['color'] ?? '#20c997',
            'created_by' => Auth::id(),
        ]);

        return response()->json(['success' => true, 'etiqueta' => $etiqueta]);
    }

    public function eliminarEtiqueta(EtiquetaPlantilla $etiqueta): JsonResponse
    {
        $etiqueta->delete();
        return response()->json(['success' => true]);
    }

    public function subirImagen(Request $request): JsonResponse
    {
        $request->validate(['imagen' => 'required|image|mimes:jpeg,png,jpg,webp,gif|max:5120']);

        try {
            $path = $request->file('imagen')->store('plantillas_email/imagenes', 'public');
            return response()->json([
                'success' => true,
                'url' => asset('storage/' . $path),
                'path' => $path,
            ]);
        } catch (\Exception $e) {
            Log::error('Error subiendo imagen de plantilla: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'No se pudo subir la imagen.'], 500);
        }
    }

    private function serializar(PlantillaEmail $plantilla): array
    {
        return [
            'id' => $plantilla->id,
            'nombre' => $plantilla->nombre,
            'asunto' => $plantilla->asunto,
            'contenido_html' => $plantilla->contenido_html,
            'logo_path' => $plantilla->logo_path,
            'descripcion' => $plantilla->descripcion,
            'es_global' => $plantilla->es_global,
            'etiquetas' => $plantilla->etiquetas->map(fn($e) => [
                'id' => $e->id,
                'nombre' => $e->nombre,
                'color' => $e->color,
            ])->values(),
            'actualizado' => $plantilla->updated_at?->diffForHumans(),
        ];
    }
}
