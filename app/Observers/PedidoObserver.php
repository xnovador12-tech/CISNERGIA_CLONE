<?php

namespace App\Observers;

use App\Models\ChecklistItem;
use App\Models\Pedido;
use App\Models\PedidoCalidad;

class PedidoObserver
{
    public function updating(Pedido $pedido): void
    {
        if ($pedido->isDirty('estado_operativo') && $pedido->estado_operativo === 'calidad') {
            // Solo crear si no existe ya un registro de calidad para este pedido
            if (!$pedido->calidad) {
                $calidad = PedidoCalidad::create([
                    'pedido_id' => $pedido->id,
                    'estado_calidad' => 'pendiente',
                ]);

                // Crear verificaciones para cada checklist item activo
                $checklistItems = ChecklistItem::activo()->orderBy('seccion')->orderBy('orden')->get();

                foreach ($checklistItems as $item) {
                    $calidad->verificaciones()->create([
                        'checklist_item_id' => $item->id,
                        'cumple' => false,
                    ]);
                }
            }
        }
    }
}
