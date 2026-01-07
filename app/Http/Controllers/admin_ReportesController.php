<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class admin_ReportesController extends Controller
{
    public function index()
    {
        return view('ADMINISTRADOR.PRINCIPAL.reportes.index');
    }
}
