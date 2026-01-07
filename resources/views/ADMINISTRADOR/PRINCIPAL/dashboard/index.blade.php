@extends('TEMPLATES.administrador')

@section('title', 'DASHBOARD')

@section('css')
@endsection
 
@section('content')
    <!-- Encabezado -->
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0"> DASHBOARD</h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ url('admin-dashboard') }}">Dashboard</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin encabezado-->

    {{-- Contenido --}}
    <div class="container-fluid">
        
    </div>
@endsection

@section('js')

@endsection
