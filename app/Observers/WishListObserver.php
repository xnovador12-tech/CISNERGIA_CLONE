<?php

namespace App\Observers;

use App\Models\WishList;
use App\Models\Oportunidad;
use App\Models\Prospecto;
use Illuminate\Support\Str;

class WishListObserver
{
    /**
     * Cuando se agrega un producto a favoritos:
     * 1. Buscar prospecto vinculado al usuario
     * 2. Crear o actualizar oportunidad de tipo 'ecommerce'
     */
    public function created(WishList $wishList): void
    {
        $this->sincronizarOportunidad($wishList->user_id);
    }

    /**
     * Cuando se elimina un favorito, recalcular monto de la oportunidad
     */
    public function deleted(WishList $wishList): void
    {
        $this->sincronizarOportunidad($wishList->user_id);
    }

    /**
     * Sincronizar oportunidad con los favoritos del usuario
     */
    private function sincronizarOportunidad(int $userId): void
    {
        // 1. Buscar prospecto vinculado a este usuario
        $prospecto = Prospecto::where('registered_user_id', $userId)->first();

        if (!$prospecto) {
            return; // No hay prospecto vinculado, no hacer nada
        }

        // 2. Contar favoritos activos
        $favoritosCount = WishList::where('user_id', $userId)
                                   ->where('deseo', true)
                                   ->count();

        // 3. Si no tiene favoritos, no crear/mantener oportunidad
        if ($favoritosCount === 0) {
            return;
        }

        // 4. Calcular monto estimado (suma de precios de favoritos)
        $montoEstimado = WishList::totalEstimado($userId);

        // 5. Buscar oportunidad existente de este prospecto con origen ecommerce
        $oportunidad = Oportunidad::where('prospecto_id', $prospecto->id)
                                   ->where('origen', 'ecommerce')
                                   ->whereNotIn('etapa', ['ganada', 'perdida'])
                                   ->first();

        if ($oportunidad) {
            // Actualizar monto estimado y valor ponderado
            $oportunidad->update([
                'monto_estimado'  => $montoEstimado,
                'valor_ponderado' => ($montoEstimado * $oportunidad->probabilidad) / 100,
            ]);
        } else {
            // Crear nueva oportunidad
            $codigo = Oportunidad::generarCodigo();

            Oportunidad::create([
                'codigo'             => $codigo,
                'slug'               => Str::slug("oportunidad-{$codigo}"),
                'nombre'             => "Productos de interés - {$prospecto->nombre} {$prospecto->apellidos}",
                'prospecto_id'       => $prospecto->id,
                'etapa'              => 'calificacion',
                'monto_estimado'     => $montoEstimado,
                'probabilidad'       => 10,
                'valor_ponderado'    => ($montoEstimado * 10) / 100,
                'tipo_proyecto'      => $prospecto->segmento ?? 'residencial',
                'tipo_oportunidad'   => 'producto',
                'origen'             => 'ecommerce',
                'fecha_creacion'     => now(),
                'fecha_cierre_estimada' => now()->addDays(30),
            ]);

            // Actualizar estado del prospecto si está en 'nuevo'
            if ($prospecto->estado === 'nuevo') {
                $prospecto->update([
                    'estado'              => 'contactado',
                    'nivel_interes'       => 'medio',
                    'fecha_ultimo_contacto' => now(),
                ]);
            }
        }
    }
}
