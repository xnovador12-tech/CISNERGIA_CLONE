@extends('TEMPLATES.administrador')

@section('title', 'Libro de Reclamaciones')

@section('css')

@endsection

@section('content')
<!-- Encabezado -->
<div class="header_section">
    <div class="bg-transparent mb-3" style="height: 80px"></div>
    <div class="container-fluid">
        <div class="" data-aos="fade-right">
            <h1 class="titulo h2 text-uppercase fw-bold mb-0">Libro de Reclamaciones</h1>
            <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-decoration-none link" href="">OTROS</a></li>
                    <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ url('admin-libro-reclamaciones') }}">Libro de Reclamaciones</a></li>
                    <li class="breadcrumb-item link" aria-current="page">Listado</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- fin encabezado -->

<div class="container-fluid">
    <div class="card border-4 borde-top-primary shadow-sm h-100" style="border-radius: 20px; min-height: 500px" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
        <div class="card-body">
            <div class="mb-4 d-flex justify-content-between align-items-center flex-column flex-md-row gap-3">
                <div>
                    <span class="text-uppercase text-muted small">
                        <i class="bi bi-journal-text me-2"></i>
                        Total: <span class="fw-bold text-dark">{{ $admin_reclamos->count() }}</span> reclamos recibidos
                    </span>
                </div>
            </div>

            <div class="table-responsive">
                <table id="display" class="table table-hover table-sm" cellspacing="0" style="width:100%">
                    <thead class="bg-dark text-white border-0">
                        <tr>
                            <th class="h6 small text-center text-uppercase fw-bold">#</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Registro</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Fecha registro</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Consumidor</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Documento</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Email</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Tipo</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Estado</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $contador = 1; @endphp
                        @foreach ($admin_reclamos as $reclamo)
                            <tr>
                                <td class="fw-normal text-center align-middle">{{ $contador }}</td>
                                <td class="fw-normal text-center align-middle">{{ $reclamo->numero_registro }}</td>
                                <td class="fw-normal text-center align-middle">{{ optional($reclamo->fecha_reclamo)->format('d/m/Y H:i') }}</td>
                                <td class="fw-normal text-center align-middle">{{ $reclamo->nombre_completo }}</td>
                                <td class="fw-normal text-center align-middle">{{ $reclamo->tipo_documento }} {{ $reclamo->numero_documento }}</td>
                                <td class="fw-normal text-center align-middle">{{ $reclamo->correo }}</td>
                                <td class="fw-normal text-center align-middle text-uppercase">{{ $reclamo->tipo_reclamo }}</td>
                                <td class="fw-normal text-center align-middle small">
                                    <span class="text-uppercase badge @if($reclamo->estado == 'resuelto') bg-success @elseif($reclamo->estado == 'pendiente') bg-warning text-dark @else bg-secondary @endif small border-0">{{ $reclamo->estado }}</span>
                                </td>
                                <td class="text-center align-middle">
                                    <div class="dropstart">
                                        <button class="btn btn-sm btn-light rounded-pill" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow">
                                            <li class="dropdown-item">
                                                <button class="bg-transparent border-0 p-0 w-100 text-start" type="button" data-bs-toggle="modal" data-bs-target="#showReclamo{{ $reclamo->id }}">
                                                    <i class="bi bi-eye-fill me-2"></i> Ver
                                                </button>
                                            </li>
                                            @if($reclamo->estado === 'pendiente')
                                                <li><hr class="dropdown-divider"></li>
                                                <li class="dropdown-item">
                                                    <form method="POST" action="{{ route('admin-libro-reclamaciones.estado', $reclamo) }}" class="m-0">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="bg-transparent border-0 p-0 w-100 text-start text-success">
                                                            <i class="bi bi-check2-circle me-2"></i> Marcar como atendido
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @php $contador++; @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @foreach ($admin_reclamos as $reclamo)
        @php
            $producto_nombre = \App\Models\Producto::where('id',$reclamo->producto_id)->first();
        @endphp
        <div class="modal fade" id="showReclamo{{ $reclamo->id }}" tabindex="-1" aria-labelledby="showReclamoLabel{{ $reclamo->id }}" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header bg-dark text-white">
                        <h5 class="modal-title" id="showReclamoLabel{{ $reclamo->id }}">Reclamo {{ $reclamo->numero_registro }}</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-4">
                            <div class="col-12 col-lg-6">
                                <div class="card border-0 shadow-sm rounded-4 p-3">
                                    <h6 class="fw-bold">Datos del consumidor</h6>
                                    <p class="mb-1"><strong>Nombre:</strong> {{ $reclamo->nombre_completo }}</p>
                                    <p class="mb-1"><strong>Documento:</strong> {{ $reclamo->tipo_documento }} - {{ $reclamo->numero_documento }}</p>
                                    <p class="mb-1"><strong>Teléfono:</strong> {{ $reclamo->telefono }}</p>
                                    <p class="mb-1"><strong>Email:</strong> {{ $reclamo->correo }}</p>
                                    <p class="mb-1"><strong>Domicilio:</strong> {{ $reclamo->direccion }}</p>
                                    <p class="mb-1"><strong>Tipo de requerimiento:</strong> {{ ucfirst($reclamo->tipo_reclamo) }}</p>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="card border-0 shadow-sm rounded-4 p-3">
                                    <h6 class="fw-bold">Información del reclamo</h6>
                                    <p class="mb-1"><strong>Fecha del reclamo:</strong> {{ optional($reclamo->fecha_reclamo)->format('d/m/Y') }}</p>
                                    <p class="mb-1"><strong>Producto/Servicio:</strong> {{ optional($producto_nombre)->name ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>Monto reclamado:</strong> S/ {{ $reclamo->monto_pagado ?? '0.00' }}</p>
                                    <p class="mb-1"><strong>Motivo del reclamo:</strong> {{ $reclamo->descripcion_reclamo }}</p>
                                    <p class="mb-1"><strong>Solución esperada:</strong> {{ $reclamo->solucion_esperada }}</p>
                                </div>
                            </div>
                        </div>
                        @php
                            $datos_empresas = \App\Models\Sede::find(1);
                        @endphp
                        <div class="row g-4 mt-3">
                            <div class="col-12 col-lg-6">
                                <div class="card border-0 shadow-sm rounded-4 p-3">
                                    <h6 class="fw-bold">Datos de la empresa</h6>
                                    <p class="mb-1"><strong>Empresa:</strong> {{ optional($datos_empresas)->name ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>RUC:</strong> {{ optional($datos_empresas)->ruc ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>Teléfono:</strong> {{ optional($datos_empresas)->nro_contacto ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>Email:</strong> {{ optional($datos_empresas)->email ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="card border-0 shadow-sm rounded-4 p-3">
                                    <h6 class="fw-bold">Seguimiento</h6>
                                    <p class="mb-1"><strong>Estado:</strong> <span class="badge @if($reclamo->estado == 'Resuelto') bg-success @elseif($reclamo->estado == 'Pendiente') bg-warning text-dark @else bg-secondary @endif">{{ ucfirst($reclamo->estado) }}</span></p>
                                    <p class="mb-1"><strong>Fecha de registro:</strong> {{ optional($reclamo->fecha_reclamo)->format('d/m/Y H:i') }}</p>
                                    <p class="mb-1"><strong>Fecha de respuesta:</strong> {{ optional($reclamo->fecha_respuesta)->format('d/m/Y H:i') ?? '-' }}</p>
                                    <p class="mb-1"><strong>Respuesta empresa:</strong> {{ $reclamo->respuesta_empresa ?? 'No registrada' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        @if($reclamo->estado === 'Pendiente')
                            <form method="POST" action="{{ route('admin-libro-reclamaciones.estado', $reclamo) }}" class="me-auto">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success rounded-pill">
                                    <i class="bi bi-check-circle-fill me-1"></i>
                                    Marcar como atendido
                                </button>
                            </form>
                        @endif
                        <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection

@section('js')
@endsection
