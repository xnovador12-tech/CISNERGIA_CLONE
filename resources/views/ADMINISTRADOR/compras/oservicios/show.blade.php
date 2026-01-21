@extends('TEMPLATES.administrador')

@section('title', 'ÓRDENES DE SERVICIOS')

@section('css')
@endsection

@section('content')
<!-- Encabezado -->
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">ORDEN DE SERVICIOS</h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ url('admin-ordenservicios') }}">Órdenes de servicios</a></li>
                        <li class="breadcrumb-item" aria-current="page">{{ $admin_ordenservicio->codigo }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
<!-- fin encabezado -->
    
    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm h-100" style="border-radius: 20px; min-height: 500px" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
            <div class="card-body text-center">
                <div class="row g-1">
                    <div class="col-12 col-md-2 col-lg-2">
                        <div class="card mb-3">
                            <div class="card-header py-1">
                                <p class="small text-uppercase mb-0">Código</p>
                            </div>
                            <div class="card-body py-1">
                                <p class="fw-normal mb-0">{{ $admin_ordenservicio->codigo }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-5 col-lg-5">
                        <div class="card mb-3">
                            <div class="card-header py-1">
                                <p class="small text-uppercase mb-0">Registrado por</p>
                            </div>
                            <div class="card-body py-1">
                                <p class="fw-normal mb-0">{{ $admin_ordenservicio->registrado_por }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-2 col-lg-2">
                        <div class="card mb-3">
                            <div class="card-header py-1">
                                <p class="small text-uppercase mb-0">Motivo</p>
                            </div>
                            <div class="card-body py-1">
                                <p class="fw-normal mb-0">{{ $admin_ordenservicio->motivo }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-2 col-lg-2">
                        <div class="card mb-3">
                            <div class="card-header py-1">
                                <p class="small text-uppercase mb-0">Fecha</p>
                            </div>
                            <div class="card-body py-1">
                                <p class="fw-normal mb-0">{{ $admin_ordenservicio->fecha }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card mb-3">
                            <div class="card-header py-1">
                                <p class="small text-uppercase mb-0">Codigo de Venta</p>
                            </div>
                            <div class="card-body py-1">
                                <p class="fw-normal mb-0">{{ $admin_ordenservicio->codigo_venta?$admin_ordenservicio->codigo_venta:'Por asignar' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card mb-3">
                            <div class="card-header py-1">
                                <p class="small text-uppercase mb-0">Forma de pago</p>
                            </div>
                            <div class="card-body py-1">
                                <p class="fw-normal mb-0">{{ $admin_ordenservicio->formapago }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card mb-3">
                            <div class="card-header py-1">
                                <p class="small text-uppercase mb-0">Plazo Pago</p>
                            </div>
                            <div class="card-body py-1">
                                @if($admin_ordenservicio->plazo_pago == '0')
                                    <p class="fw-normal mb-0">CONTADO</p>
                                @elseif($admin_ordenservicio->plazo_pago == '15')
                                    <p class="fw-normal mb-0">15 Dias</p>
                                @elseif($admin_ordenservicio->plazo_pago == '30')
                                    <p class="fw-normal mb-0">30 Dias</p>
                                @else
                                    <p class="fw-normal mb-0">60 Dias</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12 mb-3 mb-lg-0">
                        <div class="table-responsive mt-3">
                            <table class="table table-sm table-hover text-center" id="detalles-compras">
                                <thead class="table-light">
                                <tr>
                                    <th class="fw-bold small text-uppercase">N°</th>
                                    <th class="fw-bold small text-uppercase">Tipo</th>
                                    <th class="fw-bold small text-uppercase">Descripcion</th>
                                    <th class="fw-bold small text-uppercase">Precio</th>
                                    <th class="fw-bold small text-uppercase">Tiempo</th>
                                    <th class="fw-bold small text-uppercase">Vigente HASTA</th>
                                </tr>
                                </thead>
                                <tbody >
                                    @php
                                        $contador = 1;
                                    @endphp
                                    @foreach($dtlleservicio as $dtlleservicios)
                                        <tr class="text-center">
                                            <td class="fw-normal align-middle">{{ $contador }}</td>
                                            <td class="fw-normal align-middle">{{ $dtlleservicios->tipo_servicio }}</td>
                                            <td class="fw-normal align-middle">{{ $dtlleservicios->servicio }}</td>
                                            <td class="fw-normal align-middle">{{ $dtlleservicios->precio }}</td>
                                            <td class="fw-normal align-middle">{{ $dtlleservicios->tiempo_meses == 1?$dtlleservicios->tiempo_meses.' Mes':$dtlleservicios->tiempo_meses.' Meses' }}</td>
                                            <td class="fw-normal align-middle">{{ $dtlleservicios->vigencia }}</td>
                                        </tr>
                                    @php
                                        $contador++;
                                    @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-beetween">
                    <div class="col-12 col-md-6">
                        <div class="card h-100">
                            <div class="card-body">
                                <p>{{ $admin_ordenservicio->nota }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-1"></div>
                    <div class="col-12 col-md-5">
                        <table class="w-100">
                            <tr>
                                <td class="border-0 ps-2 py-1 bg-light" style="width: 50%">
                                    Subtotal
                                </td>
                                <td class="border-0 pe-2 py-1 bg-light" style="width: 50%">
                                    <div class="clearfix">
                                        <span class="float-start ps-2">S/ </span>
                                        <span class="float-end" id="subtotal_id">
                                            {{ $admin_ordenservicio->total }}
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="border-0 fw-bold ps-2 py-1 bg-light" style="width: 50%">
                                    TOTAL
                                </td>
                                <td class="border-0 fw-bold pe-2 py-1 bg-light" style="width: 50%">
                                    <div class="clearfix">
                                        <span class="float-start ps-2">S/ </span>
                                        <span class="float-end"id="total_id">
                                            {{ $admin_ordenservicio->total }}
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="p-3 text-end" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
            <a href="{{ url('admin-ordenes-servicios') }}" class="btn btn-outline-secondary px-5">Volver</a>
        </div>     
    </div>
            

@endsection

@section('js')

@endsection