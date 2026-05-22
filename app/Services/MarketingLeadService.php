<?php

namespace App\Services;

use App\Models\MarketingLeadSocial;
use App\Models\Prospecto;
use Illuminate\Support\Facades\DB;

class MarketingLeadService
{
    public function convertirAProspecto(array $datos): MarketingLeadSocial
    {
        $plataforma = $datos['plataforma'];
        $socialId = $datos['social_id'];

        return DB::transaction(function () use ($plataforma, $socialId, $datos) {
            $lead = MarketingLeadSocial::firstOrNew([
                'plataforma' => $plataforma,
                'social_id' => $socialId,
            ]);

            if ($lead->exists && $lead->prospecto_id) {
                return $lead->load('prospecto');
            }

            [$nombre, $apellidos] = $this->separarNombre($datos['nombre_social'] ?? 'Usuario social');

            $prospecto = Prospecto::create([
                'nombre' => $nombre,
                'apellidos' => $apellidos,
                'origen' => 'redes_sociales',
                'estado' => 'nuevo',
                'tipo_persona' => 'natural',
                'segmento' => 'residencial',
                'tipo_interes' => 'producto',
                'observaciones' => $this->armarObservaciones($plataforma, $socialId, $datos['comentario_origen'] ?? null),
            ]);

            $lead->fill([
                'nombre_social' => $datos['nombre_social'] ?? null,
                'prospecto_id' => $prospecto->id,
                'puntaje_interes' => $datos['puntaje_interes'] ?? 0,
                'comentario_origen' => $datos['comentario_origen'] ?? null,
                'created_by' => auth()->id(),
            ])->save();

            return $lead->load('prospecto');
        });
    }

    private function separarNombre(string $nombreCompleto): array
    {
        $partes = preg_split('/\s+/', trim($nombreCompleto), 2);
        return [
            $partes[0] ?? 'Usuario',
            $partes[1] ?? null,
        ];
    }

    private function armarObservaciones(string $plataforma, string $socialId, ?string $comentario): string
    {
        $etiqueta = MarketingLeadSocial::PLATAFORMAS[$plataforma] ?? ucfirst($plataforma);
        $base = "Lead capturado desde {$etiqueta} (ID: {$socialId}).";
        return $comentario ? $base . " Comentario original: \"{$comentario}\"" : $base;
    }
}
