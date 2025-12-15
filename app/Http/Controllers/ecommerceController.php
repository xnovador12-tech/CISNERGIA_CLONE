<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ecommerceController extends Controller
{
    public function index()
    {
        return view('ECOMMERCE.index');
    }
}
