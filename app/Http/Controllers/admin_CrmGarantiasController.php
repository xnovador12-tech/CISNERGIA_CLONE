<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Garantia;
use App\Models\GarantiaUso;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class admin_CrmGarantiasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Garantia::with(['cliente']);

        // Filtros
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('codigo', 'like', "%{$buscar}%")
                  ->orWhere('numero_serie', 'like', "%{$buscar}%")
                  ->orWhere('producto', 'like', "%{$buscar}%")
                  ->orWhereHas('cliente', fn($q2) => 
                      $q2->where('nombre', 'like', "%{$buscar}%")
                         ->orWhere('razon_social', 'like', "%{$buscar}%")
                  );
            });
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('marca')) {
            $query->where('marca', $request->marca);
        }

        if ($request->filled('cliente_id')) {
            $query->where('cliente_id', $request->cliente_id);
        }

        // Filtro por vencimiento
        if ($request->filled('vencimiento')) {
            $hoy = now();
            switch ($request->vencimiento) {
                case 'vencidas':
                    $query->where('fecha_fin', '<', $hoy);
                    break;
                case 'por_vencer_30':
                    $query->whereBetween('fecha_fin', [$hoy, $hoy->copy()->addDays(30)]);
                    break;
                case 'por_vencer_90':
                    $query->whereBetween('fecha_fin', [$hoy, $hoy->copy()->addDays(90)]);
                    break;
                case 'vigentes':
                    $query->where('fecha_fin', '>=', $hoy);
                    break;
            }
        }

        $orderBy = $request->get('order_by', 'fecha_fin');
        $orderDir = $request->get('order_dir', 'asc');
        $query->orderBy($orderBy, $orderDir);

        // Usar get() para DataTables del lado del cliente
        $garantias = $query->get();

        // EstadÃ­sticas
        $hoy = now();
        $stats = [
            'total' => Garantia::count(),
            'vigentes' => Garantia::vigentes()->count(),
            'por_vencer' => Garantia::porVencer(30)->count(),
        ];

        // Por tipo de producto
        $porTipo = Garantia::selectRaw('tipo, COUNT(*) as total')
            ->groupBy('tipo')
            ->pluck('total', 'tipo');

        // Marcas disponibles para filtro
        $marcas = Garantia::distinct()->pluck('marca')->filter();
        $clientes = Cliente::orderBy('nombre')->get();

        return view('ADMINISTRADOR.PRINCIPAL.crm.garantias.index', compact(
            'garantias',
            'stats',
            'porTipo',
            'marcas',
            'clientes'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $clientes = Cliente::orderBy('nombre')->get();
        $clienteId = $request->get('cliente_id');

        return view('ADMINISTRADOR.PRINCIPAL.crm.garantias.create', compact('clientes', 'clienteId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'tipo' => 'required|in:paneles,inversor,baterias,estructura,instalacion,sistema_completo',
            'marca' => 'nullable|string|max:100',
            'modelo' => 'nullable|string|max:100',
            'numero_serie' => 'nullable|string|max:100',
            'cantidad' => 'nullable|integer|min:1',
            'fecha_compra' => 'required|date|before_or_equal:today',
            'fecha_instalacion' => 'nullable|date|after_or_equal:fecha_compra',
            'anos_garantia' => 'required|integer|min:1|max:30',
            'condiciones' => 'nullable|string',
            'exclusiones' => 'nullable|string',
            'cubre_mano_obra' => 'boolean',
            'cubre_repuestos' => 'boolean',
            'cubre_transporte' => 'boolean',
            'certificado_garantia' => 'nullable|file|mimes:pdf|max:5120',
            'observaciones' => 'nullable|string',
        ]);

        // Calcular fecha inicio y fin de garantÃ­a
        $fechaBase = $validated['fecha_instalacion'] ?? $validated['fecha_compra'];
        $validated['fecha_inicio'] = $fechaBase;
        $validated['fecha_fin'] = \Carbon\Carbon::parse($fechaBase)->addYears((int)$validated['anos_garantia']);
        $validated['estado'] = 'vigente';

        // Procesar documento
        if ($request->hasFile('certificado_garantia')) {
            $validated['certificado_garantia'] = $request->file('certificado_garantia')
                ->store('garantias/certificados', 'public');
        }

        $garantia = Garantia::create($validated);

        return redirect()
            ->route('ADMINISTRADOR.PRINCIPAL.crm.garantias.show', $garantia)
            ->with('success', 'GarantÃƒÂ­a registrada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Garantia $garantia)
    {
        $garantia->load([
            'cliente',
            'usos' => fn($q) => $q->with('usuario')->orderByDesc('created_at'),
        ]);

        // Calcular dÃ­as restantes (redondeado a entero)
        $diasRestantes = round(now()->diffInDays($garantia->fecha_fin, false));
        
        // Calcular porcentaje usado de forma segura
        $diasTotales = $garantia->fecha_inicio && $garantia->fecha_fin
            ? $garantia->fecha_inicio->diffInDays($garantia->fecha_fin)
            : 0;
        $diasTranscurridos = $garantia->fecha_inicio
            ? now()->diffInDays($garantia->fecha_inicio)
            : 0;
        $porcentajeUsado = $diasTotales > 0
            ? round(($diasTranscurridos / $diasTotales) * 100, 1)
            : 0;

        return view('ADMINISTRADOR.PRINCIPAL.crm.garantias.show', compact(
            'garantia',
            'diasRestantes',
            'porcentajeUsado'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Garantia $garantia)
    {
        $clientes = Cliente::orderBy('nombre')->get();

        return view('ADMINISTRADOR.PRINCIPAL.crm.garantias.edit', compact('garantia', 'clientes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Garantia $garantia)
    {
        $validated = $request->validate([
            'tipo' => 'required|in:paneles,inversor,baterias,estructura,instalacion,sistema_completo',
            'marca' => 'nullable|string|max:100',
            'modelo' => 'nullable|string|max:100',
            'numero_serie' => 'nullable|string|max:100',
            'cantidad' => 'nullable|integer|min:1',
            'anos_garantia' => 'required|integer|min:1|max:30',
            'condiciones' => 'nullable|string',
            'exclusiones' => 'nullable|string',
            'cubre_mano_obra' => 'boolean',
            'cubre_repuestos' => 'boolean',
            'cubre_transporte' => 'boolean',
            'estado' => 'required|in:vigente,vencida,anulada,aplicada',
            'certificado_garantia' => 'nullable|file|mimes:pdf|max:5120',
            'observaciones' => 'nullable|string',
        ]);

        // Asegurar que los booleanos tengan valor
        $validated['cubre_mano_obra'] = $request->has('cubre_mano_obra');
        $validated['cubre_repuestos'] = $request->has('cubre_repuestos');
        $validated['cubre_transporte'] = $request->has('cubre_transporte');

        // Recalcular fecha fin si cambiaron los aÃ±os
        if ((int)$validated['anos_garantia'] !== $garantia->anos_garantia) {
            $validated['fecha_fin'] = Carbon::parse($garantia->fecha_inicio)->addYears((int)$validated['anos_garantia']);
        }

        // Procesar nuevo certificado
        if ($request->hasFile('certificado_garantia')) {
            $validated['certificado_garantia'] = $request->file('certificado_garantia')
                ->store('garantias/certificados', 'public');
        }

        $garantia->update($validated);

        return redirect()
            ->route('ADMINISTRADOR.PRINCIPAL.crm.garantias.show', $garantia)
            ->with('success', 'GarantÃ­a actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Garantia $garantia)
    {
        $garantia->delete();

        return redirect()
            ->route('ADMINISTRADOR.PRINCIPAL.crm.garantias.index')
            ->with('success', 'GarantÃƒÂ­a eliminada exitosamente.');
    }

    /**
     * Registrar uso de garantÃ­a
     */
    public function registrarUso(Request $request, Garantia $garantia)
    {
        // Verificar que estÃ¡ vigente
        if ($garantia->estado !== 'vigente') {
            return back()->with('error', 'Esta garantÃ­a no estÃ¡ vigente.');
        }

        $validated = $request->validate([
            'fecha_uso' => 'required|date|before_or_equal:today',
            'motivo' => 'required|string|max:255',
            'descripcion_problema' => 'required|string',
            'solucion_aplicada' => 'nullable|string',
            'tecnico_responsable' => 'nullable|string|max:255',
            'costo_cubierto' => 'nullable|numeric|min:0',
            'observaciones' => 'nullable|string',
            'ticket_id' => 'nullable|exists:tickets,id',
        ]);

        $validated['garantia_id'] = $garantia->id;
        $validated['user_id'] = auth()->id();
        $validated['costo_cubierto'] = $validated['costo_cubierto'] ?? 0;

        GarantiaUso::create($validated);

        // Incrementar contador de usos
        $garantia->increment('veces_utilizada');

        return back()->with('success', 'Uso de garantÃ­a registrado exitosamente.');
    }

    /**
     * Extender garantÃƒÂ­a
     */
    public function extender(Request $request, Garantia $garantia)
    {
        $validated = $request->validate([
            'anos_extension' => 'required|integer|min:1|max:10',
            'motivo_extension' => 'required|string|max:500',
            'costo_extension' => 'nullable|numeric|min:0',
        ]);

        $nuevaFechaFin = $garantia->fecha_fin->addYears((int)$validated['anos_extension']);
        $nuevosAnosGarantia = $garantia->anos_garantia + (int)$validated['anos_extension'];
        
        // Agregar a observaciones el registro de la extensiÃ³n
        $observacionesActuales = $garantia->observaciones ?? '';
        $nuevaObservacion = "\n\n[ExtensiÃ³n " . now()->format('d/m/Y') . "] " . 
                           $validated['anos_extension'] . " aÃ±o(s) - " . $validated['motivo_extension'];
        if ($validated['costo_extension'] > 0) {
            $nuevaObservacion .= " - Costo: S/ " . number_format($validated['costo_extension'], 2);
        }
        
        $garantia->update([
            'fecha_fin' => $nuevaFechaFin,
            'anos_garantia' => $nuevosAnosGarantia,
            'observaciones' => trim($observacionesActuales . $nuevaObservacion),
        ]);

        return back()->with('success', "GarantÃ­a extendida {$validated['anos_extension']} aÃ±o(s) hasta {$nuevaFechaFin->format('d/m/Y')}.");
    }

    /**
     * Verificar garantÃƒÂ­a (pÃƒÂºblico o AJAX)
     */
    public function verificar(Request $request)
    {
        $validated = $request->validate([
            'numero_serie' => 'required|string',
        ]);

        $garantia = Garantia::where('numero_serie', $validated['numero_serie'])->first();

        if (!$garantia) {
            return response()->json([
                'encontrada' => false,
                'mensaje' => 'No se encontrÃƒÂ³ ninguna garantÃƒÂ­a con ese nÃƒÂºmero de serie.',
            ]);
        }

        return response()->json([
            'encontrada' => true,
            'vigente' => $garantia->estaVigente(),
            'garantia' => [
                'codigo' => $garantia->codigo,
                'producto' => $garantia->producto,
                'marca' => $garantia->marca,
                'estado' => $garantia->estado,
                'fecha_fin' => $garantia->fecha_fin->format('d/m/Y'),
                'dias_restantes' => $garantia->diasRestantes(),
                'tipo_cobertura' => $garantia->tipo_cobertura,
                'cliente' => $garantia->cliente->nombre_completo ?? null,
            ],
        ]);
    }

    /**
     * Alertas de garantÃƒÂ­as por vencer
     */
    public function alertas()
    {
        $porVencer30 = Garantia::porVencer(30)
            ->with('cliente')
            ->orderBy('fecha_fin')
            ->get();

        $porVencer90 = Garantia::porVencer(90)
            ->whereNotIn('id', $porVencer30->pluck('id'))
            ->with('cliente')
            ->orderBy('fecha_fin')
            ->get();

        $vencidas = Garantia::where('fecha_fin', '<', now())
            ->where('estado', 'activa')
            ->with('cliente')
            ->orderByDesc('fecha_fin')
            ->take(50)
            ->get();

        return view('ADMINISTRADOR.PRINCIPAL.crm.garantias.alertas', compact(
            'porVencer30',
            'porVencer90',
            'vencidas'
        ));
    }

    /**
     * Reporte de garantÃƒÂ­as
     */
    public function reporte(Request $request)
    {
        $fechaInicio = $request->get('fecha_inicio', now()->startOfYear());
        $fechaFin = $request->get('fecha_fin', now());

        // GarantÃƒÂ­as registradas en el perÃƒÂ­odo
        $registradas = Garantia::whereBetween('created_at', [$fechaInicio, $fechaFin])
            ->count();

        // Usos de garantÃƒÂ­a en el perÃƒÂ­odo
        $usos = GarantiaUso::whereBetween('fecha_reclamo', [$fechaInicio, $fechaFin])
            ->with(['garantia.cliente'])
            ->get();

        // MÃƒÂ©tricas
        $metricas = [
            'total_reclamos' => $usos->count(),
            'reclamos_aprobados' => $usos->where('accion_realizada', '!=', 'rechazado')->count(),
            'reclamos_rechazados' => $usos->where('accion_realizada', 'rechazado')->count(),
            'costo_total' => $usos->where('cubierto_por_garantia', true)->sum('costo_cubierto'),
            'reemplazos' => $usos->where('accion_realizada', 'reemplazo')->count(),
            'reparaciones' => $usos->where('accion_realizada', 'reparacion')->count(),
        ];

        // Por tipo de producto
        $porTipoProducto = $usos->groupBy(fn($u) => $u->garantia->tipo)
            ->map(fn($grupo) => [
                'cantidad' => $grupo->count(),
                'costo' => $grupo->sum('costo_cubierto'),
            ]);

        // Por marca
        $porMarca = $usos->groupBy(fn($u) => $u->garantia->marca)
            ->map(fn($grupo) => $grupo->count())
            ->sortDesc()
            ->take(10);

        // Por tipo de reclamo
        $porTipoReclamo = $usos->groupBy('tipo_reclamo')
            ->map(fn($grupo) => $grupo->count());

        return view('ADMINISTRADOR.PRINCIPAL.crm.garantias.reporte', compact(
            'metricas',
            'porTipoProducto',
            'porMarca',
            'porTipoReclamo',
            'fechaInicio',
            'fechaFin',
            'usos'
        ));
    }

    /**
     * Exportar garantÃƒÂ­as
     */
    public function exportar(Request $request)
    {
        $query = Garantia::with(['cliente']);

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        $garantias = $query->orderBy('fecha_fin')->get();

        $filename = 'garantias_' . date('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($garantias) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, [
                'CÃƒÂ³digo', 'Cliente', 'Tipo Producto', 'Producto', 'Marca', 
                'Modelo', 'NÃ‚Â° Serie', 'Fecha Compra', 'Fecha Fin GarantÃƒÂ­a',
                'DÃƒÂ­as Restantes', 'Estado', 'Usos'
            ]);

            foreach ($garantias as $g) {
                fputcsv($file, [
                    $g->codigo,
                    $g->cliente?->nombre_completo,
                    $g->tipo,
                    $g->producto,
                    $g->marca,
                    $g->modelo,
                    $g->numero_serie,
                    $g->fecha_compra?->format('d/m/Y'),
                    $g->fecha_fin?->format('d/m/Y'),
                    $g->diasRestantes(),
                    $g->estado,
                    $g->usos()->count(),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

