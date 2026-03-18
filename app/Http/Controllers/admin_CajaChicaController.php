<?php

namespace App\Http\Controllers;

use App\Models\AperturaCierreCaja;
use App\Models\MovimientoCaja;
use App\Models\Cuentabanco;
use App\Models\Moneda;
use Illuminate\Http\Request;

class admin_CajaChicaController extends Controller
{
    public function index()
    {
        $cajas = AperturaCierreCaja::with(['user', 'moneda'])
            ->orderBy('created_at', 'desc')
            ->get();

        $cajaAbierta = $cajas->where('estado', 'Abierto')->first();

        return view('ADMINISTRADOR.FINANZAS.caja-chica.index', compact('cajas', 'cajaAbierta'));
    }

    public function create()
    {
        $cajaAbierta = AperturaCierreCaja::where('estado', 'Abierto')->first();
        if ($cajaAbierta) {
            return redirect()->route('admin-caja-chica.show', $cajaAbierta)
                ->with('info', 'Ya existe una caja abierta. Debe cerrarla antes de abrir una nueva.');
        }

        $cuentasBancarias = Cuentabanco::with(['banco', 'moneda', 'tipocuenta'])->get();
        $monedas = Moneda::all();

        return view('ADMINISTRADOR.FINANZAS.caja-chica.create', compact('cuentasBancarias', 'monedas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'saldo_inicial' => 'required|numeric|min:0',
        ]);

        $cajaAbierta = AperturaCierreCaja::where('estado', 'Abierto')->first();
        if ($cajaAbierta) {
            return back()->with('error', 'Ya existe una caja abierta.');
        }

        $ultimaCaja = AperturaCierreCaja::latest('id')->first();
        $numero = $ultimaCaja ? $ultimaCaja->id + 1 : 1;
        $codigo = 'CAJA-' . date('Y') . '-' . str_pad($numero, 5, '0', STR_PAD_LEFT);

        AperturaCierreCaja::create([
            'codigo' => $codigo,
            'cuenta_bancaria_id' => null,
            'user_id' => auth()->id(),
            'moneda_id' => null,
            'fecha_apertura' => now()->format('Y-m-d'),
            'hora_apertura' => now()->format('H:i:s'),
            'saldo_inicial' => $validated['saldo_inicial'],
            'efectivo_inicial' => $validated['saldo_inicial'],
            'total_ingresos' => 0,
            'total_egresos' => 0,
            'efectivo_final' => 0,
            'saldo_cierre' => 0,
            'estado' => 'Abierto',
        ]);

        return redirect()->route('admin-caja-chica.index')
            ->with('success', 'Caja abierta exitosamente: ' . $codigo);
    }

    public function show(AperturaCierreCaja $admin_caja_chica)
    {
        $caja = $admin_caja_chica;

        $movimientosTodos = MovimientoCaja::with(['metodoPago', 'venta', 'ordenCompra', 'cliente', 'proveedor.persona', 'cuentaBancaria.banco'])
            ->where('apertura_caja_id', $caja->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $ingresos = $movimientosTodos->where('tipo', 'ingreso');
        $egresos = $movimientosTodos->where('tipo', 'egreso');

        $totalIngresos = $ingresos->sum('monto');
        $totalEgresos = $egresos->sum('monto');
        $saldoActual = $caja->saldo_inicial + $totalIngresos - $totalEgresos;

        $movimientos = $movimientosTodos->map(function ($mov) {
            return [
                'fecha' => $mov->fecha_movimiento,
                'hora' => $mov->hora_movimiento,
                'tipo' => $mov->tipo === 'ingreso' ? 'Ingreso' : 'Egreso',
                'descripcion' => $mov->descripcion,
                'metodo_pago' => $mov->metodoPago->name ?? 'N/A',
                'referencia' => $mov->venta ? $mov->venta->codigo : ($mov->ordenCompra ? $mov->ordenCompra->codigo : ''),
                'tercero' => $mov->cliente ? ($mov->cliente->nombre_completo ?? 'N/A') : ($mov->proveedor ? ($mov->proveedor->persona->name ?? 'N/A') : 'N/A'),
                'monto' => $mov->monto,
                'created_at' => $mov->created_at,
            ];
        })->values();

        return view('ADMINISTRADOR.FINANZAS.caja-chica.show', compact('caja', 'ingresos', 'egresos', 'totalIngresos', 'totalEgresos', 'saldoActual', 'movimientos'));
    }

    public function cerrar(AperturaCierreCaja $admin_caja_chica)
    {
        $caja = $admin_caja_chica;

        if ($caja->estado !== 'Abierto') {
            return back()->with('error', 'Esta caja ya está cerrada.');
        }

        $totalIngresos = MovimientoCaja::where('apertura_caja_id', $caja->id)->where('tipo', 'ingreso')->sum('monto');
        $totalEgresos = MovimientoCaja::where('apertura_caja_id', $caja->id)->where('tipo', 'egreso')->sum('monto');
        $saldoCierre = $caja->saldo_inicial + $totalIngresos - $totalEgresos;

        $caja->update([
            'total_ingresos' => $totalIngresos,
            'total_egresos' => $totalEgresos,
            'efectivo_final' => $saldoCierre,
            'saldo_cierre' => $saldoCierre,
            'fecha_cierre' => now()->format('Y-m-d'),
            'hora_cierre' => now()->format('H:i:s'),
            'estado' => 'Cerrado',
        ]);

        return redirect()->route('admin-caja-chica.index')
            ->with('success', 'Caja cerrada exitosamente. Saldo de cierre: S/ ' . number_format($saldoCierre, 2));
    }
}
