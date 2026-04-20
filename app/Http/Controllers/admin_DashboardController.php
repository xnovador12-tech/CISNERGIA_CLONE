<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Detailsale;
use App\Models\Oportunidad;
use App\Models\Prospecto;
use App\Models\Ticket;
use App\Models\CotizacionCrm;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class admin_DashboardController extends Controller
{
    /**
     * Dashboard principal con métricas de Ventas Digitales y CRM.
     *
     * Acceso: solo usuarios con permiso 'dashboard.index' (típicamente
     * Gerencia y Administrador). El middleware de la ruta ya filtra.
     */
    public function index()
    {
        $hoy = Carbon::now();

        // ═══════════════════════════════════════════════════════════════
        // SECCIÓN 1: VENTAS DIGITALES (métricas que dejó el compañero)
        // ═══════════════════════════════════════════════════════════════

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

        // ═══════════════════════════════════════════════════════════════
        // SECCIÓN 2: MÉTRICAS CRM (nueva sección)
        // ═══════════════════════════════════════════════════════════════

        // KPI 1: Prospectos nuevos este mes
        $prospectosNuevosMes = Prospecto::whereMonth('created_at', $hoy->month)
            ->whereYear('created_at', $hoy->year)
            ->count();

        // KPI 2: Oportunidades activas (en pipeline, no ganadas/perdidas)
        $oportunidadesActivas = Oportunidad::whereNotIn('etapa', ['ganada', 'perdida'])
            ->count();

        // KPI 3: Valor total del pipeline (suma de monto_estimado de oportunidades activas)
        $valorPipeline = Oportunidad::whereNotIn('etapa', ['ganada', 'perdida'])
            ->sum('monto_estimado');

        // KPI 4: Tickets abiertos (cualquier estado que no sea resuelto)
        $ticketsAbiertos = Ticket::where('estado', '!=', 'resuelto')->count();

        // GRÁFICO 1: Pipeline por Etapa (Bar Chart)
        // Cuenta oportunidades por etapa, respetando el orden del pipeline.
        $etapasOrdenadas = ['calificacion', 'evaluacion', 'cotizacion', 'negociacion', 'ganada', 'perdida'];
        $etapasLabels    = ['Calificación', 'Evaluación', 'Cotización', 'Negociación', 'Ganada', 'Perdida'];
        $etapasColores   = ['#0d6efd', '#0dcaf0', '#ffc107', '#6c757d', '#198754', '#dc3545'];

        $conteoEtapasRaw = Oportunidad::select('etapa', DB::raw('COUNT(*) as total'))
            ->groupBy('etapa')
            ->pluck('total', 'etapa')
            ->toArray();

        // Mapear cada etapa en orden (si no hay registros, queda en 0)
        $conteoEtapas = [];
        foreach ($etapasOrdenadas as $etapa) {
            $conteoEtapas[] = $conteoEtapasRaw[$etapa] ?? 0;
        }

        // GRÁFICO 2: Prospectos por Origen (Doughnut Chart)
        $prospectosPorOrigenRaw = Prospecto::select('origen', DB::raw('COUNT(*) as total'))
            ->groupBy('origen')
            ->pluck('total', 'origen')
            ->toArray();

        // Diccionario origen → etiqueta legible + color
        $origenesMap = [
            'ecommerce'       => ['label' => 'E-commerce',      'color' => '#0d6efd'],
            'sitio_web'       => ['label' => 'Sitio Web',       'color' => '#0dcaf0'],
            'redes_sociales'  => ['label' => 'Redes Sociales',  'color' => '#6f42c1'],
            'llamada'         => ['label' => 'Llamada',         'color' => '#198754'],
            'referido'        => ['label' => 'Referido',        'color' => '#ffc107'],
            'directo'         => ['label' => 'Directo',         'color' => '#fd7e14'],
            'otro'            => ['label' => 'Otro',            'color' => '#6c757d'],
        ];

        $origenLabels = [];
        $origenData   = [];
        $origenColors = [];
        foreach ($prospectosPorOrigenRaw as $origen => $total) {
            $info = $origenesMap[$origen] ?? ['label' => ucfirst($origen), 'color' => '#adb5bd'];
            $origenLabels[] = $info['label'];
            $origenData[]   = $total;
            $origenColors[] = $info['color'];
        }

        // TABLA: Top 5 Vendedores del mes (por cantidad de oportunidades ganadas)
        $topVendedores = User::select(
                'users.id',
                'users.email',
                'personas.name',
                'personas.surnames',
                DB::raw('COUNT(oportunidades.id) as total_ganadas'),
                DB::raw('COALESCE(SUM(oportunidades.monto_estimado), 0) as valor_cerrado')
            )
            ->leftJoin('personas', 'users.persona_id', '=', 'personas.id')
            ->leftJoin('oportunidades', function ($join) use ($hoy) {
                $join->on('oportunidades.user_id', '=', 'users.id')
                     ->where('oportunidades.etapa', '=', 'ganada')
                     ->whereMonth('oportunidades.updated_at', $hoy->month)
                     ->whereYear('oportunidades.updated_at', $hoy->year);
            })
            ->whereHas('roles', fn($q) => $q->where('name', '!=', 'Cliente'))
            ->groupBy('users.id', 'users.email', 'personas.name', 'personas.surnames')
            ->having('total_ganadas', '>', 0)
            ->orderByDesc('total_ganadas')
            ->orderByDesc('valor_cerrado')
            ->take(5)
            ->get();

        // GRÁFICO 3: Evolución de oportunidades ganadas por mes (últimos 6 meses, Line Chart)
        $mesesLabels = [];
        $mesesGanadas = [];
        $mesesValorCerrado = [];

        for ($i = 5; $i >= 0; $i--) {
            $mes = $hoy->copy()->subMonths($i);

            $ganadasDelMes = Oportunidad::where('etapa', 'ganada')
                ->whereMonth('updated_at', $mes->month)
                ->whereYear('updated_at', $mes->year)
                ->get();

            $mesesLabels[]       = $mes->locale('es')->isoFormat('MMM YY');
            $mesesGanadas[]      = $ganadasDelMes->count();
            $mesesValorCerrado[] = round($ganadasDelMes->sum('monto_estimado'), 2);
        }

        return view('ADMINISTRADOR.PRINCIPAL.dashboard.index', compact(
            // Ventas digitales (intactas)
            'facturacionDiaria',
            'facturacionMensual',
            'ticketPromedio',
            'tasaConversion',
            'productosMasVendidos',

            // CRM - KPIs
            'prospectosNuevosMes',
            'oportunidadesActivas',
            'valorPipeline',
            'ticketsAbiertos',

            // CRM - Gráfico Pipeline
            'etapasLabels',
            'conteoEtapas',
            'etapasColores',

            // CRM - Gráfico Origen
            'origenLabels',
            'origenData',
            'origenColors',

            // CRM - Tabla Top Vendedores
            'topVendedores',

            // CRM - Gráfico Evolución
            'mesesLabels',
            'mesesGanadas',
            'mesesValorCerrado'
        ));
    }
}
