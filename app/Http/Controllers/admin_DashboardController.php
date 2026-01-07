<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class admin_DashboardController extends Controller
{
    public function index()
    {
        return view('ADMINISTRADOR.PRINCIPAL.dashboard.index');
    }
}
