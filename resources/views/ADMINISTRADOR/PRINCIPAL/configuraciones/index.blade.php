@extends('TEMPLATES.administrador')

@section('title', 'CONFIGURACIONES')

@section('css')
@endsection
 
@section('content')
    <!-- Encabezado -->
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0"> CONFIGURACIONES</h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ url('admin-configuraciones') }}">Configuraciones</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin encabezado-->

    {{-- Contenido --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                <div class="card border-4 borde-top-secondary box-shadow h-100" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
                    <div class="card-header bg-transparent">
                        <span class="text-uppercase text-secondary fw-bold">General</span>
                    </div>
                    <div class="card-body pb-0">
                        <p class="fw-normal" align="justify">Gestiona la información general del sistema, roles, usuarios y tu perfil personal.</p>
                        <ul class="list-unstyled">
                            <li class="text-primary menu_item">
                                <i class="bi bi-building me-2"></i>
                                <a href="{{ route('admin-informacion.index') }}" class="link-primary text-decoration-none">Información</a>
                            </li>
                            <li class="text-primary menu_item">
                                <i class="bi bi-award me-2"></i>
                                <a href="{{ route('admin-roles.index') }}" class="link-primary text-decoration-none">Roles</a>
                            </li>
                            <li class="text-primary menu_item">
                                <i class="bi bi-people me-2"></i>
                                <a href="{{ route('admin-usuarios.index') }}" class="link-primary text-decoration-none">Usuarios</a>
                            </li>
                            <li class="text-primary menu_item">
                                <i class="bi bi-person-badge me-2"></i>
                                <a href="{{ route('admin-perfil.index') }}" class="link-primary text-decoration-none">Mi perfil</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                <div class="card border-4 borde-top-secondary box-shadow h-100" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
                    <div class="card-header bg-transparent">
                        <span class="text-uppercase text-secondary fw-bold">Almacén</span>
                    </div>
                    <div class="card-body pb-0">
                        <p class="fw-normal" align="justify">Configura la información del inventario para poder registrar productos.</p>
                        <ul class="list-unstyled">
                            <li class="text-primary menu_item">
                                <i class="bi bi-diagram-3 me-2"></i>
                                <a href="{{ route('admin-tipos.index') }}" class="link-primary text-decoration-none">Tipos</a>
                            </li>
                            <li class="text-primary menu_item">
                                <i class="bi bi-grid me-2"></i>
                                <a href="{{ route('admin-categorias.index') }}" class="link-primary text-decoration-none">Categorías</a>
                            </li>
                            
                            <li class="text-primary menu_item">
                                <i class="bi bi-tags me-2"></i>
                                <a href="{{ route('admin-marcas.index') }}" class="link-primary text-decoration-none">Marcas</a>
                            </li>
                            <li class="text-primary menu_item">
                                <i class="bi bi-bookmarks me-2"></i>
                                <a href="{{ route('admin-etiquetas.index') }}" class="link-primary text-decoration-none">Etiquetas</a>
                            </li>
                
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                <div class="card border-4 borde-top-secondary box-shadow h-100" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
                    <div class="card-header bg-transparent">
                        <span class="text-uppercase text-secondary fw-bold">Compras</span>
                    </div>
                    <div class="card-body pb-0">
                        <p class="fw-normal" align="justify">Registra proveedores y mercadería necesarios para las operaciones del negocio.</p>
                        <ul class="list-unstyled">
                            <li class="text-primary menu_item">
                                <i class="bi bi-person-square me-2"></i>
                                <a href="{{ route('admin-proveedores.index') }}" class="link-primary text-decoration-none">Proveedores</a>
                            </li>
                    
                            <li class="text-primary menu_item">
                                <i class="bi bi-boxes me-2"></i>
                                <a href="{{ route('admin-productos.index') }}" class="link-primary text-decoration-none">Productos</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                <div class="card border-4 borde-top-secondary box-shadow h-100" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
                    <div class="card-header bg-transparent">
                        <span class="text-uppercase text-secondary fw-bold">E-commerce</span>
                    </div>
                    <div class="card-body pb-0">
                        <p class="fw-normal" align="justify">Administra la información de clientes, coberturas, servicios y descuento para la tienda.</p>
                        <ul class="list-unstyled">
                            <li class="text-primary menu_item">
                                <i class="bi bi-person-check me-2"></i>
                                <a href="{{ route('admin-clientes.index') }}" class="link-primary text-decoration-none">Clientes</a>
                            </li>
                            <li class="text-primary menu_item">
                                <i class="bi bi-map me-2"></i>
                                <a href="{{ route('admin-coberturas.index') }}" class="link-primary text-decoration-none">Cobertura</a>
                            </li>
                            <li class="text-primary menu_item">
                                <i class="bi bi-percent me-2"></i>
                                <a href="{{ route('admin-descuentos.index') }}" class="link-primary text-decoration-none">Descuento</a>
                            </li>
                            <li class="text-primary menu_item">
                                <i class="bi bi-receipt me-2"></i>
                                <a href="{{ route('admin-cupones.index') }}" class="link-primary text-decoration-none">Cupones</a>
                            </li>
                            <li class="text-primary menu_item">
                                <i class="bi bi-receipt me-2"></i>
                                <a href="{{ route('admin-servicios.index') }}" class="link-primary text-decoration-none">Servicios</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Fin contenido --}}
@endsection
@section('js')
@endsection