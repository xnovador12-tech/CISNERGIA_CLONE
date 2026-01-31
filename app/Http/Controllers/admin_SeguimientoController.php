<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Pedido;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class admin_SeguimientoController extends Controller
{
    public function index()
    {
        // KPIs del mes actual
        $mesActual = date('Y-m');
        
        // Total de pedidos del mes
        $totalPedidos = Pedido::whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->count();
        
        // Total de ventas del mes
        $totalVentas = Sale::whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->where('estado', 'completada')
            ->count();
        
        // Facturación del mes
        $facturacionMes = Sale::whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->where('estado', 'completada')
            ->sum('total');
        
        // Ticket promedio
        $ticketPromedio = $totalVentas > 0 ? $facturacionMes / $totalVentas : 0;
        
        // Tasa de conversión (pedidos a ventas)
        $tasaConversion = $totalPedidos > 0 ? ($totalVentas / $totalPedidos) * 100 : 0;
        
        // Pedidos por estado
        $pedidosPorEstado = Pedido::select('estado', DB::raw('count(*) as total'))
            ->groupBy('estado')
            ->get();
        
        // Ventas del mes (últimos 30 días)
        $ventasDiarias = Sale::select(
                DB::raw('DATE(created_at) as fecha'),
                DB::raw('SUM(total) as total'),
                DB::raw('COUNT(*) as cantidad')
            )
            ->where('created_at', '>=', now()->subDays(30))
            ->where('estado', 'completada')
            ->groupBy('fecha')
            ->orderBy('fecha', 'asc')
            ->get();
        
        // Top 5 productos más vendidos
        $topProductos = DB::table('detail_sales')
            ->join('productos', 'detail_sales.producto_id', '=', 'productos.id')
            ->select('productos.name', DB::raw('SUM(detail_sales.cantidad) as total_vendido'))
            ->groupBy('productos.id', 'productos.name')
            ->orderBy('total_vendido', 'desc')
            ->limit(5)
            ->get();
        
        // Pedidos recientes
        $pedidosRecientes = Pedido::with(['cliente', 'usuario'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Ventas recientes
        $ventasRecientes = Sale::with(['cliente', 'tipocomprobante'])
            ->where('estado', 'completada')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        return view('ADMINISTRADOR.PRINCIPAL.ventas.seguimiento.index', compact(
            'totalPedidos',
            'totalVentas',
            'facturacionMes',
            'ticketPromedio',
            'tasaConversion',
            'pedidosPorEstado',
            'ventasDiarias',
            'topProductos',
            'pedidosRecientes',
            'ventasRecientes'
        ));
    }
}
