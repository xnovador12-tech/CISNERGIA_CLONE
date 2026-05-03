<?php

namespace App\Http\Controllers;

use App\Models\ReclamoLibro;
use Illuminate\Http\Request;

class admin_LibroReclamacionesController extends Controller
{
    /**
     * Display a listing of the complaints submitted from the elearning book.
     */
    public function index()
    {
        $admin_reclamos = ReclamoLibro::orderByDesc('fecha_reclamo')
            ->get();

        return view('ADMINISTRADOR.OTROS.libro_reclamaciones.index', compact('admin_reclamos'));
    }

    /**
     * Display the specified complaint.
     */
    public function show($id)
    {
        $reclamo = ReclamoLibro::with('empresa')->findOrFail($id);

        return view('ADMINISTRADOR.OTROS.libro_reclamaciones.show', compact('reclamo'));
    }

    /**
     * Update the complaint status to atendido.
     */
    public function updateEstado(ReclamoLibro $reclamo)
    {
        if ($reclamo->estado !== 'Pendiente') {
            return redirect()->back()->with('info', 'Este reclamo ya no está en estado pendiente.');
        }

        $reclamo->estado = 'Resuelto';
        $reclamo->fecha_respuesta = now();
        $reclamo->respuesta_empresa = 'El reclamo ha sido atendido por el equipo de soporte. Nos comunicaremos para brindarle una solución.';
        $reclamo->save();

        return redirect()->route('admin-libro-reclamaciones.index')
            ->with('success', 'El reclamo ha sido marcado como atendido.');
    }
}
