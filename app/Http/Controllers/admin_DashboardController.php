<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Detailsale;
use App\Models\Oportunidad;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class admin_DashboardController extends Controller
{
    public function index()
    {
        $hoy = Carbon::now();

        // 1. Facturación Diaria y Mensual
        $facturacionDiaria = Sale::whereDate('created_at', $hoy->toDateString())->sum('total');
        $facturacionMensual = Sale::whereMonth('created_at', $hoy->month)
                                  ->whereYear('created_at', $hoy->year)
                                  ->sum('total');

        // 2. Ticket Promedio
        $cantidadVentas = Sale::count();
        $ticketPromedio = $cantidadVentas > 0 ? Sale::sum('total') / $cantidadVentas : 0;

        // 3. Tasa de Conversión (Basada en Oportunidades CRM)
        $totalOportunidades = Oportunidad::count();
        $oportunidadesGanadas = Oportunidad::where('etapa', 'ganada')->count();
        $tasaConversion = $totalOportunidades > 0 ? ($oportunidadesGanadas / $totalOportunidades) * 100 : 0;

        // 4. Productos más vendidos
        $productosMasVendidos = Detailsale::with('producto')
            ->select('producto_id', DB::raw('SUM(cantidad) as total_vendido'))
            ->whereNotNull('producto_id')
            ->groupBy('producto_id')
            ->orderByDesc('total_vendido')
            ->take(5)
            ->get();

        return view('ADMINISTRADOR.PRINCIPAL.dashboard.index', compact(
            'facturacionDiaria',
            'facturacionMensual',
            'ticketPromedio',
            'tasaConversion',
            'productosMasVendidos'
        ));
    }
}
