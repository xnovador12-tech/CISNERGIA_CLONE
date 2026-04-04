<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Departamento;
use App\Models\Distrito;
use App\Models\Sede;
use App\Models\User;
use Illuminate\Http\Request;

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
            'total'       => $clientes->count(),
            'activos'     => $clientes->where('estado', 'activo')->count(),
            'inactivos'   => $clientes->where('estado', 'inactivo')->count(),
            'suspendidos' => $clientes->where('estado', 'suspendido')->count(),
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
            'cotizaciones',
            'ventas',
            'pedidos',
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
            'tickets_abiertos' => $cliente->tickets->whereNotIn('estado', ['resuelto'])->count(),
        ];

        return view('ADMINISTRADOR.CRM.clientes.show', compact('cliente', 'metricas'));
    }

    /**
     * Formulario de edición
     */
    public function edit(Cliente $cliente)
    {
        $cliente->load(['distrito.provincia.departamento', 'vendedor', 'sede']);

        $departamentos = Departamento::orderBy('nombre')->get();
        $vendedores    = User::whereHas('role', function ($q) {
            $q->whereNotIn('slug', ['logistica', 'almacen', 'tesoreria', 'cliente']);
        })->with('persona')->get();
        $sedes = Sede::where('estado', 'Activo')->orderBy('name')->get();

        return view('ADMINISTRADOR.CRM.clientes.edit', compact('cliente', 'departamentos', 'vendedores', 'sedes'));
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
            'sede_id'      => 'nullable|exists:sedes,id',
            'observaciones' => 'nullable|string|max:2000',
        ]);

        $cliente->update($request->only([
            'nombre', 'apellidos', 'razon_social', 'tipo_persona',
            'ruc', 'dni', 'email', 'telefono', 'celular',
            'direccion', 'distrito_id', 'segmento', 'estado',
            'vendedor_id', 'sede_id', 'observaciones',
        ]));

        return redirect()
            ->route('admin.crm.clientes.show', $cliente)
            ->with('success', 'Cliente actualizado exitosamente.');
    }

    /**
     * Eliminar cliente (soft delete)
     * Bloquea si tiene ventas, pedidos o tickets activos
     */
    public function destroy(Cliente $cliente)
    {
        // Verificar dependencias activas
        $ventasCount  = $cliente->ventas()->count();
        $pedidosCount = $cliente->pedidos()->count();
        $ticketsCount = $cliente->tickets()
            ->whereNotIn('estado', ['resuelto'])
            ->count();

        if ($ventasCount > 0 || $pedidosCount > 0 || $ticketsCount > 0) {
            $detalle = [];
            if ($ventasCount)  $detalle[] = "{$ventasCount} venta(s)";
            if ($pedidosCount) $detalle[] = "{$pedidosCount} pedido(s)";
            if ($ticketsCount) $detalle[] = "{$ticketsCount} ticket(s) abierto(s)";

            return redirect()
                ->route('admin.crm.clientes.show', $cliente)
                ->with('error', "No se puede eliminar el cliente \"{$cliente->nombre_completo}\" porque tiene " . implode(', ', $detalle) . ' asociados.');
        }

        $nombre = $cliente->nombre_completo;
        $cliente->delete();

        return redirect()
            ->route('admin.crm.clientes.index')
            ->with('success', "Cliente \"{$nombre}\" eliminado exitosamente.");
    }

    /**
     * Obtener datos del cliente (AJAX para auto-rellenar en pedidos)
     */
    public function getDatos(Cliente $cliente)
    {
        $cliente->load('distrito');

        return response()->json([
            'id'           => $cliente->id,
            'nombre'       => $cliente->nombre_completo,
            'documento'    => $cliente->documento,
            'tipo_persona' => $cliente->tipo_persona,
            'email'        => $cliente->email,
            'telefono'     => $cliente->telefono ?? $cliente->celular,
            'direccion'    => $cliente->direccion,
            'distrito_id'  => $cliente->distrito_id,
            'distrito'     => $cliente->distrito?->nombre,
        ]);
    }

    /**
     * Almacenar cliente (AJAX desde modal de pedidos)
     * Verifica duplicados y establece fecha_primera_compra
     */
    public function store(Request $request)
    {
        $request->validate([
            'tipo_identificacion' => 'required|in:DNI,RUC,CE,Pasaporte',
            'documento'           => 'required|string|max:20',
            'name'                => 'required|string|max:255',
            'apellidos'           => 'nullable|string|max:255',
            'email'               => 'nullable|email|max:255',
            'celular'             => 'nullable|string|max:20',
            'telefono'            => 'nullable|string|max:20',
            'direccion'           => 'nullable|string|max:255',
            'distrito_id'         => 'nullable|exists:distritos,id',
        ]);

        $tipoPersona = $request->tipo_identificacion === 'RUC' ? 'juridica' : 'natural';
        $campo       = $tipoPersona === 'juridica' ? 'ruc' : 'dni';

        // Verificar duplicado — devolver el existente si ya existe
        $existente = Cliente::where($campo, $request->documento)->first();
        if ($existente) {
            return response()->json([
                'success' => true,
                'message' => 'Cliente ya registrado',
                'cliente' => [
                    'id'        => $existente->id,
                    'name'      => $existente->nombre_completo,
                    'documento' => $existente->documento,
                ],
            ]);
        }

        $cliente = new Cliente();
        $cliente->nombre = $request->name;

        if ($tipoPersona === 'juridica') {
            $cliente->razon_social = $request->name;
            $cliente->ruc          = $request->documento;
        } else {
            $cliente->dni       = $request->documento;
            $cliente->apellidos = $request->apellidos;
        }

        $cliente->email                = $request->email;
        $cliente->celular              = $request->celular;
        $cliente->telefono             = $request->telefono;
        $cliente->direccion            = $request->direccion;
        $cliente->distrito_id          = $request->distrito_id;
        $cliente->tipo_persona         = $tipoPersona;
        $cliente->vendedor_id          = auth()->id();
        $cliente->estado               = 'activo';
        $cliente->origen               = 'directo';
        $cliente->segmento             = $request->get('segmento', 'residencial');
        $cliente->fecha_primera_compra = now()->toDateString();
        $cliente->save();

        return response()->json([
            'success' => true,
            'message' => 'Cliente creado exitosamente',
            'cliente' => [
                'id'        => $cliente->id,
                'name'      => $cliente->nombre_completo,
                'documento' => $cliente->documento,
            ],
        ]);
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

