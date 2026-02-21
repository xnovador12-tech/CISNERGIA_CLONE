<?php

namespace App\Services;

use App\Models\CotizacionCrm;
use App\Models\Cliente;
use App\Models\Oportunidad;
use App\Models\Prospecto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CotizacionApprovalService
{
    /**
     * Aprobar cotización: convertir prospecto a cliente + marcar oportunidad como ganada.
     * La venta se crea manualmente después por el admin.
     *
     * @return array ['success' => bool, 'message' => string, 'cliente' => Cliente|null]
     */
    public function aprobar(CotizacionCrm $cotizacion): array
    {
        // Validar que la cotización pueda ser aprobada
        if (!in_array($cotizacion->estado, ['borrador', 'enviada'])) {
            return [
                'success' => false,
                'message' => 'Esta cotización no puede ser aprobada en su estado actual.',
                'cliente' => null,
            ];
        }

        return DB::transaction(function () use ($cotizacion) {

            // 1. Marcar cotización como aceptada
            $cotizacion->update([
                'estado'          => 'aceptada',
                'fecha_respuesta' => now(),
            ]);

            // 2. Obtener oportunidad y prospecto
            $oportunidad = $cotizacion->oportunidad;
            $prospecto = $oportunidad->prospecto ?? $cotizacion->prospecto;
            $cliente = null;

            // 3. Convertir prospecto a cliente (si aún no lo es)
            if ($prospecto && $prospecto->estado !== 'convertido') {
                $cliente = $this->convertirACliente($prospecto);

                // Vincular cliente a la oportunidad y cotización
                $oportunidad->update(['cliente_id' => $cliente->id]);
                $cotizacion->update(['cliente_id' => $cliente->id]);
            } else {
                // Si ya es cliente, obtener el cliente existente
                $cliente = $oportunidad->cliente
                    ?? Cliente::where('prospecto_id', $prospecto?->id)->first();
            }

            // 4. Marcar oportunidad como ganada
            if ($oportunidad && $oportunidad->etapa !== 'ganada') {
                $oportunidad->update([
                    'etapa'            => 'ganada',
                    'probabilidad'     => 100,
                    'monto_final'      => $cotizacion->total,
                    'valor_ponderado'  => $cotizacion->total,
                    'fecha_cierre_real' => now(),
                ]);
            }

            return [
                'success' => true,
                'message' => $prospecto && $prospecto->wasChanged('estado')
                    ? "Cotización aprobada. {$prospecto->nombre} ha sido convertido a cliente. Recuerde registrar la venta."
                    : 'Cotización aprobada. Oportunidad marcada como ganada. Recuerde registrar la venta.',
                'cliente' => $cliente,
            ];
        });
    }

    /**
     * Convertir un prospecto en cliente
     */
    private function convertirACliente(Prospecto $prospecto): Cliente
    {
        $cliente = Cliente::create([
            'nombre'        => $prospecto->nombre,
            'apellidos'     => $prospecto->apellidos,
            'razon_social'  => $prospecto->razon_social,
            'ruc'           => $prospecto->ruc,
            'dni'           => $prospecto->dni,
            'email'         => $prospecto->email,
            'telefono'      => $prospecto->telefono,
            'celular'       => $prospecto->celular,
            'direccion'     => $prospecto->direccion,
            'tipo_persona'  => $prospecto->tipo_persona,
            'prospecto_id'  => $prospecto->id,
            'segmento'      => $prospecto->segmento,
            'scoring'       => $prospecto->scoring,
            'distrito_id'   => $prospecto->distrito_id,
            'vendedor_id'   => $prospecto->user_id,
            'sede_id'       => $prospecto->sede_id,
            'fecha_primera_compra' => now(),
        ]);

        // Marcar prospecto como convertido
        $prospecto->update([
            'estado' => 'convertido',
        ]);

        return $cliente;
    }

    /**
     * Rechazar cotización
     */
    public function rechazar(CotizacionCrm $cotizacion, string $motivo): array
    {
        $cotizacion->update([
            'estado'          => 'rechazada',
            'motivo_rechazo'  => $motivo,
            'fecha_respuesta' => now(),
        ]);

        return [
            'success' => true,
            'message' => 'Cotización marcada como rechazada.',
        ];
    }
}
