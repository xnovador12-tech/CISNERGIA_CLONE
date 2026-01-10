@extends('TEMPLATES.administrador')

@section('title', 'Proveedores')

@section('css')
@endsection

@section('content')
<!-- Encabezado -->
<div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">PROVEEDORES</h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ url('admin-configuraciones') }}">Configuraciones</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ url('admin-proveedores') }}">Proveedores</a></li>
                        <li class="breadcrumb-item" aria-current="page">{{ $admin_proveedore->name }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
<!-- fin encabezado -->

    {{-- Contenido --}}
        <div class="container-fluid">
            <div class="card border-4 borde-top-primary shadow-sm h-100" style="border-radius: 20px; min-height: 500px" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-8 col-lg-9">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Datos del proveedor</p>
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="pb-3">
                                        <div class="card">
                                            <div class="card-header py-1">
                                                <span class="text-uppercase small">Nro de identificación</span>
                                            </div>
                                            <div class="card-body py-2">
                                                <span>{{ $admin_proveedore->nro_identificacion }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-5">
                                    <div class="pb-3">
                                        <div class="card">
                                            <div class="card-header py-1">
                                                <span class="text-uppercase small">Identificación</span>
                                            </div>
                                            <div class="card-body py-2">
                                                @if($admin_proveedore->tipo_documento == 'RUC')
                                                    <span>Registro unico del contribuyente - {{ $admin_proveedore->tipo_documento }}</span>
                                                @elseif($admin_proveedore->tipo_documento == 'DNI')
                                                    <span>Documento Nacional de identidad - {{ $admin_proveedore->tipo_documento }}</span>
                                                @elseif($admin_proveedore->tipo_documento == 'CE')
                                                    <span>Carnet de extranjería - {{ $admin_proveedore->tipo_documento }}</span>
                                                @elseif($admin_proveedore->tipo_documento == 'PP')
                                                    <span>Pasaporte - {{ $admin_proveedore->tipo_documento }}</span>
                                                @else
                                                    <span>Documento tributario no domiciliado sin ruc - {{ $admin_proveedore->tipo_documento }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3">
                                    <div class="pb-3">
                                        <div class="card">
                                            <div class="card-header py-1">
                                                <span class="text-uppercase small">Giro</span>
                                            </div>
                                            <div class="card-body py-2">
                                                <span>{{ $admin_proveedore->proveedor->giro }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="pb-3">
                                        <div class="card">
                                            <div class="card-header py-1">
                                                <span class="text-uppercase small">Nombre o razón social</span>
                                            </div>
                                            <div class="card-body py-2">
                                                <span>{{ $admin_proveedore->proveedor->name_contacto }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="pb-3">
                                        <div class="card">
                                            <div class="card-header py-1">
                                                <span class="text-uppercase small">Correo electrónico</span>
                                            </div>
                                            <div class="card-body py-2">
                                                <span>{{ $admin_proveedore->proveedor->email_contacto }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="pb-3">
                                        <div class="card">
                                            <div class="card-header py-1">
                                                <span class="text-uppercase small">Nro de contacto</span>
                                            </div>
                                            <div class="card-body py-2">
                                                <span>{{ $admin_proveedore->celular }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-8">
                                    <div class="pb-3">
                                        <div class="card">
                                            <div class="card-header py-1">
                                                <span class="text-uppercase small">Dirección</span>
                                            </div>
                                            <div class="card-body py-2">
                                                <span>{{ $admin_proveedore->direccion }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="pb-3">
                                        <div class="card">
                                            <div class="card-header py-1">
                                                <span class="text-uppercase small">Referencia</span>
                                            </div>
                                            <div class="card-body py-2">
                                                <span>{{ $admin_proveedore->referencia }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="pb-3">
                                        <div class="card">
                                            <div class="card-header py-1">
                                                <span class="text-uppercase small">Dirección fiscal</span>
                                            </div>
                                            <div class="card-body py-2">
                                                <span>{{ $admin_proveedore->proveedor->direccion_fiscal }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="pb-3">
                                        <div class="card">
                                            <div class="card-header py-1">
                                                <span class="text-uppercase small">Departamento</span>
                                            </div>
                                            <div class="card-body py-2">
                                                <option>{{ $admin_proveedore->proveedor->departamento->name}}</option>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="pb-3">
                                        <div class="card mb-3">
                                            <div class="card-header py-1">
                                                <p class="small text-uppercase mb-0">Tipos</p>
                                            </div>
                                            @foreach($admin_proveedore->proveedor->tipos as $tipo)
                                                <div class="card-body py-1 me-2">
                                                    <li class="fw-normal mb-0">{{ $tipo->name }}</li>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Datos de persona de contacto</p>

                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="pb-3">
                                        <div class="card">
                                            <div class="card-header py-1">
                                                <span class="text-uppercase small">Nombres y apellidos</span>
                                            </div>
                                            <div class="card-body py-2">
                                                <span>{{ $admin_proveedore->name }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="pb-3">
                                        <div class="card">
                                            <div class="card-header py-1">
                                                <span class="text-uppercase small">Correo electrónico</span>
                                            </div>
                                            <div class="card-body py-2">
                                                <span>{{ $admin_proveedore->email_pnatural }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="pb-3">
                                        <div class="card">
                                            <div class="card-header py-1">
                                                <span class="text-uppercase small">Nro. Contacto</span>
                                            </div>
                                            <div class="card-body py-2">
                                                <span>{{ $admin_proveedore->celular }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>    
                        <div class="col-12 col-md-4 col-lg-3">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Cuenta bancaria</p>
                            <div class="pb-3">
                                <div class="card">
                                    <div class="card-header py-1">
                                        <span class="text-uppercase small">Tipo de cuenta</span>
                                    </div>
                                    <div class="card-body py-2">
                                        <span>{{ $admin_proveedore->proveedor->tipo_cuenta_normal }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="pb-3">
                                <div class="card">
                                    <div class="card-header py-1">
                                        <span class="text-uppercase small">Banco</span>
                                    </div>
                                    <div class="card-body py-2">
                                        <span>{{ $admin_proveedore->proveedor->entidad_bancaria_normal }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="pb-3">
                                <div class="card">
                                    <div class="card-header py-1">
                                        <span class="text-uppercase small">Nro. de cuenta</span>
                                    </div>
                                    <div class="card-body py-2">
                                        <span>{{ $admin_proveedore->proveedor->nro_cuenta_normal }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="pb-3">
                                <div class="card">
                                    <div class="card-header py-1">
                                        <span class="text-uppercase small">Nro. de cuenta CCI</span>
                                    </div>
                                    <div class="card-body py-2">
                                        <span>{{ $admin_proveedore->proveedor->nro_cci_normal }}</span>
                                    </div>
                                </div>
                            </div>

                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Cuenta de detracción</p>

                            <div class="pb-3">
                                <div class="card">
                                    <div class="card-header py-1">
                                        <span class="text-uppercase small">Tipo de cuenta</span>
                                    </div>
                                    <div class="card-body py-2">
                                        <span>{{ $admin_proveedore->proveedor->tipo_cuenta_detraccion }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="pb-3">
                                <div class="card">
                                    <div class="card-header py-1">
                                        <span class="text-uppercase small">Banco</span>
                                    </div>
                                    <div class="card-body py-2">
                                        <span>{{ $admin_proveedore->proveedor->entidad_bancaria_detraccion }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="pb-3">
                                <div class="card">
                                    <div class="card-header py-1">
                                        <span class="text-uppercase small">Nro de cuenta de detracción</span>
                                    </div>
                                    <div class="card-body py-2">
                                        <span>{{ $admin_proveedore->proveedor->nro_cuenta_detraccion }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                                      
                </div>
            </div>
            <div class="pt-3 pb-3 text-end" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
                <a href="{{ url('admin-proveedores') }}" class="btn btn-outline-secondary px-5">Volver</a>
            </div>     
        </div> 
    {{-- Fin contenido --}}

@endsection

@section('js')

@endsection