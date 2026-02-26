<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductoSearchController extends Controller
{
    public function search(Request $request)
    {
        $term = $request->input('q');

        if (!$term) {
            return response()->json([]);
        }

        $productos = \App\Models\Producto::where('estado', 1)
            ->where(function ($query) use ($term) {
                $query->where('name', 'like', '%' . $term . '%')
                      ->orWhere('sku', 'like', '%' . $term . '%');
            })
            ->select('id', 'name', 'sku', 'precio_venta', 'tipo', 'controlar_stock')
            ->limit(20)
            ->get();

        $results = $productos->map(function ($producto) {
            $stockLiteral = 'N/A';
            if ($producto->controlar_stock) {
                $stockActual = $producto->inventario()->sum('cantidad');
                $stockLiteral = $stockActual . ' unids';
                if($stockActual <= 0) {
                     $stockLiteral = '🚫 Agotado';
                }
            }

            return [
                'id' => $producto->id,
                'text' => ($producto->sku ? "[$producto->sku] " : "") . $producto->name . " | Stock: $stockLiteral",
                'precio' => $producto->precio_venta,
                'controla_stock' => $producto->controlar_stock,
                'tipo' => $producto->tipo ?? 'producto'
            ];
        });

        return response()->json([
            'results' => $results
        ]);
    }
}
