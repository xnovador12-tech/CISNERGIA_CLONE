<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Distrito;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class admin_CrmClientesController extends Controller
{
    /**
     * Listado de clientes con KPIs y filtros
     */
    public function index()
    {
        $clientes = Cliente::with(['vendedor.persona', 'distrito', 'sede'])
            ->latest()
            ->get();

        // KPIs
        $stats = [
            'total'      => $clientes->count(),
            'activos'    => $clientes->where('estado', 'activo')->count(),
            'inactivos'  => $clientes->where('estado', 'inactivo')->count(),
            'ecommerce'  => $clientes->where('origen', 'ecommerce')->count(),
        ];

        return view('ADMINISTRADOR.CRM.clientes.index', compact('clientes', 'stats'));
    }

    /**
     * Ficha del cliente con historial
     */
    public function show(Cliente $cliente)
    {
        $cliente->load([
            'vendedor.persona',
            'distrito',
            'sede',
            'prospecto',
            'oportunidades.cotizaciones',
            'ventas',
            'actividades.asignadoA.persona',
            'tickets',
            'mantenimientos',
        ]);

        // Calcular métricas del cliente
        $metricas = [
            'total_compras'    => $cliente->ventas->count(),
            'valor_compras'    => $cliente->ventas->sum('total'),
            'ticket_promedio'  => $cliente->ventas->count() > 0
                ? $cliente->ventas->sum('total') / $cliente->ventas->count()
                : 0,
            'oportunidades'    => $cliente->oportunidades->count(),
            'tickets_abiertos' => $cliente->tickets->whereNotIn('estado', ['cerrado', 'resuelto'])->count(),
        ];

        return view('ADMINISTRADOR.CRM.clientes.show', compact('cliente', 'metricas'));
    }

    /**
     * Formulario de edición
     */
    public function edit(Cliente $cliente)
    {
        $cliente->load(['distrito', 'vendedor', 'sede']);

        $distritos = Distrito::orderBy('nombre')->get();
        $vendedores = User::whereHas('roles', function ($q) {
            $q->whereIn('name', ['Cuantica', 'Administrador', 'Vendedor']);
        })->with('persona')->get();

        return view('ADMINISTRADOR.CRM.clientes.edit', compact('cliente', 'distritos', 'vendedores'));
    }

    /**
     * Actualizar datos del cliente
     */
    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nombre'       => 'required|string|max:255',
            'apellidos'    => 'nullable|string|max:255',
            'razon_social' => 'nullable|string|max:255',
            'tipo_persona' => 'required|in:natural,juridica',
            'ruc'          => 'nullable|string|max:11',
            'dni'          => 'nullable|string|max:8',
            'email'        => 'nullable|email|max:255',
            'telefono'     => 'nullable|string|max:20',
            'celular'      => 'nullable|string|max:20',
            'direccion'    => 'nullable|string|max:255',
            'distrito_id'  => 'nullable|exists:distritos,id',
            'segmento'     => 'required|in:residencial,comercial,industrial,agricola',
            'estado'       => 'required|in:activo,inactivo,suspendido',
            'vendedor_id'  => 'nullable|exists:users,id',
            'observaciones' => 'nullable|string|max:2000',
        ]);

        $cliente->update($request->only([
            'nombre', 'apellidos', 'razon_social', 'tipo_persona',
            'ruc', 'dni', 'email', 'telefono', 'celular',
            'direccion', 'distrito_id', 'segmento', 'estado',
            'vendedor_id', 'observaciones',
        ]));

        return redirect()
            ->route('admin.crm.clientes.show', $cliente)
            ->with('success', 'Cliente actualizado exitosamente.');
    }

    /**
     * Eliminar cliente (soft delete)
     */
    public function destroy(Cliente $cliente)
    {
        $nombre = $cliente->nombre_completo;
        $cliente->delete();

        return redirect()
            ->route('admin.crm.clientes.index')
            ->with('success', "Cliente \"{$nombre}\" eliminado exitosamente.");
    }

    /**
     * Cambiar estado del cliente
     */
    public function cambiarEstado(Request $request, Cliente $cliente)
    {
        $request->validate([
            'estado' => 'required|in:activo,inactivo,suspendido',
        ]);

        $cliente->update(['estado' => $request->estado]);

        $estadoLabel = ucfirst($request->estado);
        return back()->with('success', "Estado del cliente cambiado a: {$estadoLabel}");
    }
}
