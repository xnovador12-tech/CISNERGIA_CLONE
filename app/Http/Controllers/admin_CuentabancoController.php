<?php

namespace App\Http\Controllers;

use App\Models\Cuentabanco;
use App\Models\Sede;
use App\Models\Banco;
use App\Models\Tipocuenta;
use App\Models\Moneda;
use Illuminate\Http\Request;

class admin_CuentabancoController extends Controller
{
    public function index()
    {
        $cuentas = Cuentabanco::with(['banco', 'tipocuenta', 'moneda', 'sede'])->get();
        return view('ADMINISTRADOR.FINANZAS.cuentasbancarias.index', compact('cuentas'));
    }

    public function create()
    {
        $bancos = Banco::all();
        $tipos = Tipocuenta::all();
        $monedas = Moneda::all();
        $sedes = Sede::all();
        return view('ADMINISTRADOR.FINANZAS.cuentasbancarias.create', compact('bancos', 'tipos', 'monedas', 'sedes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'banco_id' => 'required|exists:bancos,id',
            'numero_cuenta' => 'required|string|max:255',
            'moneda_id' => 'required|exists:monedas,id',
            'sede_id' => 'required|exists:sedes,id',
            'titular' => 'required|string|max:255',
            'saldo_inicial' => 'required|numeric|min:0',
            'cci' => 'nullable|string|max:255',
        ]);

        $validated['saldo_actual'] = $validated['saldo_inicial'];
        $validated['estado'] = true;
        $validated['cuenta_principal'] = false;
        $validated['fecha_apertura'] = now()->format('Y-m-d');

        Cuentabanco::create($validated);

        return redirect()->route('admin-cuentasbancarias.index')
            ->with('success', '✅ Cuenta bancaria creada exitosamente para la sucursal seleccionada.');
    }
}
