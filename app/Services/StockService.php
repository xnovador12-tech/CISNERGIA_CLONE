<?php

namespace App\Services;

use App\Models\Inventario;
use App\Models\Producto;
use App\Models\DetallePedido;
use Illuminate\Support\Facades\DB;

class StockService
{
    /**
     * Deduct stock for a list of items (DetallePedido|CartItem etc).
     * Criteria: FIFO (Oldest created_at first)
     * 
     * @param iterable $items
     * @param int|null $almacenId
     * @return bool
     * @throws \Exception
     */
    public function deductStock($items, $almacenId = null): bool
    {
        return DB::transaction(function () use ($items, $almacenId) {
            foreach ($items as $item) {
                // If it's a model or array, normalize product_id and cantidad
                $productId = $item->producto_id ?? ($item['producto_id'] ?? null);
                $cantidad = $item->cantidad ?? ($item['cantidad'] ?? 0);

                if (!$productId || $cantidad <= 0) continue;

                $this->processDeduction($productId, $cantidad, $almacenId);
            }
            return true;
        });
    }

    /**
     * Core logic to deduct from specific product.
     */
    private function processDeduction($productId, $cantidadNecesaria, $almacenId = null)
    {
        $query = Inventario::where('id_producto', $productId)
                ->where('cantidad', '>', 0)
                ->orderBy('created_at', 'asc');

        if ($almacenId) {
            $query->where('almacen_id', $almacenId);
        }

        $inventarios = $query->get();
        $disponible = $inventarios->sum('cantidad');

        if ($disponible < $cantidadNecesaria) {
            $nombreProducto = Producto::find($productId)?->nombre ?? 'Producto';
            throw new \Exception("Stock insuficiente para \"$nombreProducto\". Requerido: $cantidadNecesaria, Disponible: $disponible");
        }

        foreach ($inventarios as $inventario) {
            if ($cantidadNecesaria <= 0) break;

            if ($inventario->cantidad >= $cantidadNecesaria) {
                $inventario->cantidad -= $cantidadNecesaria;
                $inventario->save();
                $cantidadNecesaria = 0;
            } else {
                $cantidadNecesaria -= $inventario->cantidad;
                $inventario->cantidad = 0;
                $inventario->save();
            }
        }
    }

    /**
     * Restore stock when order is canceled or edited.
     */
    public function restoreStock($items, $almacenId = null): void
    {
        foreach ($items as $item) {
            $productId = $item->producto_id ?? ($item['producto_id'] ?? null);
            $cantidad = $item->cantidad ?? ($item['cantidad'] ?? 0);

            if (!$productId || $cantidad <= 0) continue;

            // Simple restore to the assigned warehouse or first available
            $inventario = Inventario::where('id_producto', $productId)
                ->when($almacenId, fn($q) => $q->where('almacen_id', $almacenId))
                ->first();

            if ($inventario) {
                $inventario->cantidad += $cantidad;
                $inventario->save();
            } else {
                // Should not happen naturally, but fallback to creating an entry if needed
                // For now, we prefer to log it or skip if it doesn't exist.
            }
        }
    }

    /**
     * Check if enough stock exists.
     */
    public function hasStock($items, $almacenId = null): bool
    {
        foreach ($items as $item) {
            $productId = $item->producto_id ?? ($item['producto_id'] ?? null);
            $cantidad = $item->cantidad ?? ($item['cantidad'] ?? 0);

            if (!$productId || $cantidad <= 0) continue;

            $disponible = Inventario::where('id_producto', $productId)
                ->when($almacenId, fn($q) => $q->where('almacen_id', $almacenId))
                ->sum('cantidad');

            if ($disponible < $cantidad) return false;
        }
        return true;
    }
}
