<?php

namespace App\Http\Controllers;

use App\Models\Provincia;
use App\Models\Distrito;
use Illuminate\Http\Request;

class admin_UbigeoController extends Controller
{
    /**
     * Retorna las provincias de un departamento (AJAX)
     */
    public function provincias(Request $request)
    {
        $provincias = Provincia::where('departamento_id', $request->departamento_id)
            ->orderBy('nombre')
            ->get(['id', 'nombre']);

        return response()->json($provincias);
    }

    /**
     * Retorna los distritos de una provincia (AJAX)
     */
    public function distritos(Request $request)
    {
        $distritos = Distrito::where('provincia_id', $request->provincia_id)
            ->orderBy('nombre')
            ->get(['id', 'nombre']);

        return response()->json($distritos);
    }
}
