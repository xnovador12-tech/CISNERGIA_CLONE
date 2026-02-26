@extends('TEMPLATES.administrador')
@section('title', 'Ficha de Cliente')

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">FICHA DE CLIENTE</h1>
                <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin.crm.clientes.index') }}">Clientes</a></li>
                        <li class="breadcrumb-item link" aria-current="page">{{ Str::limit($cliente->nombre_completo, 40) }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="container-fluid mb-3">
            <div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        </div>
    @endif

    @if(session('error'))
        <div class="container-fluid mb-3">
            <div class="alert alert-danger alert-dismissible fade show"><i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        </div>
    @endif

    @php
        $estadoColors = ['activo' => 'success', 'inactivo' => 'secondary', 'suspendido' => 'danger'];
        $origenColors = ['ecommerce' => 'info', 'directo' => 'primary'];
        $segmentoColors = ['residencial' => 'primary', 'comercial' => 'success', 'industrial' => 'warning', 'agricola' => 'info'];
    @endphp

    <div class="container-fluid">
        <div class="row g-4">
            <!-- ==================== COLUMNA PRINCIPAL ==================== -->
            <div class="col-lg-8">

                <!-- Datos del Cliente -->
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-secondary fs-6 me-2">{{ $cliente->codigo }}</span>
                            <span class="badge bg-{{ $origenColors[$cliente->origen] ?? 'secondary' }}">
                                <i class="bi bi-{{ $cliente->origen === 'ecommerce' ? 'cart3' : 'person-check' }} me-1"></i>
                                {{ $cliente->origen === 'ecommerce' ? 'E-commerce' : 'Directo' }}
                            </span>
                            <span class="badge bg-{{ $estadoColors[$cliente->estado] ?? 'secondary' }}">
                                {{ ucfirst($cliente->estado) }}
                            </span>
                        </div>
                        <a href="{{ route('admin.crm.clientes.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i>Volver
                        </a>
                    </div>
                    <div class="card-body">
                        <h4 class="fw-bold mb-1">{{ $cliente->nombre_completo }}</h4>
                        @if($cliente->tipo_persona === 'juridica' && $cliente->razon_social)
                            <p class="text-muted mb-3">{{ $cliente->razon_social }}</p>
                        @endif

                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-person-vcard text-primary me-2"></i>
                                    <div>
                                        <small class="text-muted">Documento</small>
                                        <p class="mb-0 fw-bold">
                                            @if($cliente->tipo_persona === 'juridica')
                                                RUC: {{ $cliente->ruc ?? '-' }}
                                            @else
                                                DNI: {{ $cliente->dni ?? '-' }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-envelope text-info me-2"></i>
                                    <div>
                                        <small class="text-muted">Email</small>
                                        <p class="mb-0 fw-bold">
                                            @if($cliente->email)
                                                <a href="mailto:{{ $cliente->email }}" class="text-decoration-none">{{ $cliente->email }}</a>
                                            @else
                                                -
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-phone text-success me-2"></i>
                                    <div>
                                        <small class="text-muted">Celular</small>
                                        <p class="mb-0 fw-bold">
                                            @if($cliente->celular)
                                                <a href="tel:{{ $cliente->celular }}" class="text-decoration-none">{{ $cliente->celular }}</a>
                                                <a href="https://wa.me/51{{ preg_replace('/\D/', '', $cliente->celular) }}" target="_blank" class="btn btn-sm btn-success ms-1" style="padding: 0 4px;" title="WhatsApp">
                                                    <i class="bi bi-whatsapp" style="font-size: 0.7rem;"></i>
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @if($cliente->telefono)
                            <div class="col-md-4">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-telephone text-primary me-2"></i>
                                    <div>
                                        <small class="text-muted">Teléfono</small>
                                        <p class="mb-0 fw-bold">{{ $cliente->telefono }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="col-md-4">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-geo-alt text-danger me-2"></i>
                                    <div>
                                        <small class="text-muted">Dirección</small>
                                        <p class="mb-0 fw-bold">{{ $cliente->direccion ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-map text-warning me-2"></i>
                                    <div>
                                        <small class="text-muted">Distrito</small>
                                        <p class="mb-0 fw-bold">{{ $cliente->distrito?->nombre ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($cliente->observaciones)
                            <hr>
                            <div>
                                <small class="text-muted">Observaciones</small>
                                <p class="mb-0">{!! nl2br(e($cliente->observaciones)) !!}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- ==================== HISTORIAL CON PESTAÑAS ==================== -->
                <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent">
                        <ul class="nav nav-tabs card-header-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#tab-ventas" role="tab">
                                    <i class="bi bi-bag-check me-1"></i>Ventas
                                    <span class="badge bg-primary ms-1">{{ $cliente->ventas->count() }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#tab-oportunidades" role="tab">
                                    <i class="bi bi-funnel me-1"></i>Oportunidades
                                    <span class="badge bg-info ms-1">{{ $cliente->oportunidades->count() }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#tab-soporte" role="tab">
                                    <i class="bi bi-life-preserver me-1"></i>Soporte
                                    <span class="badge bg-warning ms-1">{{ $cliente->tickets->count() + $cliente->mantenimientos->count() }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">

                            <!-- Tab: Ventas -->
                            <div class="tab-pane fade show active" id="tab-ventas" role="tabpanel">
                                @if($cliente->ventas->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Código</th>
                                                    <th>Fecha</th>
                                                    <th class="text-end">Total</th>
                                                    <th class="text-center">Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($cliente->ventas->sortByDesc('created_at') as $venta)
                                                    <tr>
                                                        <td><strong>{{ $venta->codigo ?? $venta->id }}</strong></td>
                                                        <td>{{ $venta->created_at->format('d/m/Y') }}</td>
                                                        <td class="text-end fw-bold text-primary">S/ {{ number_format($venta->total ?? 0, 2) }}</td>
                                                        <td class="text-center">
                                                            <span class="badge bg-{{ ($venta->estado ?? '') === 'completada' ? 'success' : 'secondary' }}">
                                                                {{ ucfirst($venta->estado ?? 'N/A') }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr class="table-light">
                                                    <td colspan="2" class="fw-bold">Total</td>
                                                    <td class="text-end fw-bold text-success">S/ {{ number_format($cliente->ventas->sum('total'), 2) }}</td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-4 text-muted">
                                        <i class="bi bi-bag-x fs-1 d-block mb-2"></i>
                                        No hay ventas registradas para este cliente.
                                    </div>
                                @endif
                            </div>

                            <!-- Tab: Oportunidades & Cotizaciones -->
                            <div class="tab-pane fade" id="tab-oportunidades" role="tabpanel">
                                @if($cliente->oportunidades->count() > 0)
                                    @foreach($cliente->oportunidades->sortByDesc('created_at') as $oportunidad)
                                        <div class="card border mb-3">
                                            <div class="card-body py-2">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <strong>{{ $oportunidad->codigo }}</strong> — {{ $oportunidad->nombre }}
                                                        <br>
                                                        <small class="text-muted">
                                                            Etapa:
                                                            <span class="badge bg-{{ $oportunidad->etapa === 'ganada' ? 'success' : ($oportunidad->etapa === 'perdida' ? 'danger' : 'primary') }}">
                                                                {{ ucfirst($oportunidad->etapa) }}
                                                            </span>
                                                            — Monto: <strong class="text-primary">S/ {{ number_format($oportunidad->monto_estimado, 2) }}</strong>
                                                        </small>
                                                    </div>
                                                    <a href="{{ route('admin.crm.oportunidades.show', $oportunidad) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                </div>

                                                {{-- Cotizaciones de esta oportunidad --}}
                                                @if($oportunidad->cotizaciones && $oportunidad->cotizaciones->count() > 0)
                                                    <div class="mt-2 ps-3 border-start border-2 border-info">
                                                        @foreach($oportunidad->cotizaciones as $cotizacion)
                                                            <div class="d-flex justify-content-between align-items-center py-1">
                                                                <small>
                                                                    <i class="bi bi-file-text text-info me-1"></i>
                                                                    {{ $cotizacion->codigo }}
                                                                    — <strong>S/ {{ number_format($cotizacion->total ?? 0, 2) }}</strong>
                                                                    <span class="badge bg-{{ ['borrador' => 'secondary', 'enviada' => 'primary', 'aceptada' => 'success', 'rechazada' => 'danger'][$cotizacion->estado] ?? 'secondary' }}">
                                                                        {{ ucfirst($cotizacion->estado) }}
                                                                    </span>
                                                                </small>
                                                                <a href="{{ route('admin.crm.cotizaciones.show', $cotizacion) }}" class="btn btn-sm btn-outline-info" style="padding: 0 6px;">
                                                                    <i class="bi bi-eye" style="font-size: 0.7rem;"></i>
                                                                </a>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center py-4 text-muted">
                                        <i class="bi bi-funnel fs-1 d-block mb-2"></i>
                                        No hay oportunidades asociadas a este cliente.
                                    </div>
                                @endif
                            </div>

                            <!-- Tab: Soporte (Tickets + Mantenimientos) -->
                            <div class="tab-pane fade" id="tab-soporte" role="tabpanel">
                                {{-- Tickets --}}
                                <h6 class="fw-bold mb-3"><i class="bi bi-ticket-perforated me-1"></i>Tickets</h6>
                                @if($cliente->tickets->count() > 0)
                                    <div class="table-responsive mb-4">
                                        <table class="table table-sm table-hover">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Código</th>
                                                    <th>Asunto</th>
                                                    <th class="text-center">Prioridad</th>
                                                    <th class="text-center">Estado</th>
                                                    <th>Fecha</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($cliente->tickets->sortByDesc('created_at') as $ticket)
                                                    <tr>
                                                        <td><strong>{{ $ticket->codigo ?? $ticket->id }}</strong></td>
                                                        <td>{{ Str::limit($ticket->asunto ?? $ticket->titulo ?? '-', 40) }}</td>
                                                        <td class="text-center">
                                                            @php $prioridadColors = ['alta' => 'danger', 'media' => 'warning', 'baja' => 'success']; @endphp
                                                            <span class="badge bg-{{ $prioridadColors[$ticket->prioridad ?? ''] ?? 'secondary' }}">
                                                                {{ ucfirst($ticket->prioridad ?? '-') }}
                                                            </span>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $ticket->estado ?? '-')) }}</span>
                                                        </td>
                                                        <td>{{ $ticket->created_at?->format('d/m/Y') }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-3 text-muted mb-4">
                                        <i class="bi bi-ticket-perforated fs-3 d-block mb-1"></i>
                                        <small>Sin tickets registrados.</small>
                                    </div>
                                @endif

                                {{-- Mantenimientos --}}
                                <h6 class="fw-bold mb-3"><i class="bi bi-tools me-1"></i>Mantenimientos</h6>
                                @if($cliente->mantenimientos->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Código</th>
                                                    <th>Tipo</th>
                                                    <th class="text-center">Estado</th>
                                                    <th>Fecha Programada</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($cliente->mantenimientos->sortByDesc('created_at') as $mantenimiento)
                                                    <tr>
                                                        <td><strong>{{ $mantenimiento->codigo ?? $mantenimiento->id }}</strong></td>
                                                        <td>{{ ucfirst($mantenimiento->tipo ?? '-') }}</td>
                                                        <td class="text-center">
                                                            <span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $mantenimiento->estado ?? '-')) }}</span>
                                                        </td>
                                                        <td>{{ $mantenimiento->fecha_programada ? \Carbon\Carbon::parse($mantenimiento->fecha_programada)->format('d/m/Y') : '-' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-3 text-muted">
                                        <i class="bi bi-tools fs-3 d-block mb-1"></i>
                                        <small>Sin mantenimientos registrados.</small>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- ==================== COLUMNA LATERAL ==================== -->
            <div class="col-lg-4">

                <!-- Métricas del Cliente -->
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent">
                        <h6 class="mb-0"><i class="bi bi-graph-up me-2"></i>Métricas</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="text-center p-2 bg-light rounded">
                                    <p class="text-muted mb-0 small">Compras</p>
                                    <h4 class="fw-bold mb-0 text-primary">{{ $metricas['total_compras'] }}</h4>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center p-2 bg-light rounded">
                                    <p class="text-muted mb-0 small">Valor Total</p>
                                    <h4 class="fw-bold mb-0 text-success" style="font-size: 1.1rem;">S/ {{ number_format($metricas['valor_compras'], 0) }}</h4>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center p-2 bg-light rounded">
                                    <p class="text-muted mb-0 small">Ticket Promedio</p>
                                    <h4 class="fw-bold mb-0 text-info" style="font-size: 1.1rem;">S/ {{ number_format($metricas['ticket_promedio'], 0) }}</h4>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center p-2 bg-light rounded">
                                    <p class="text-muted mb-0 small">Tickets Abiertos</p>
                                    <h4 class="fw-bold mb-0 {{ $metricas['tickets_abiertos'] > 0 ? 'text-danger' : 'text-success' }}">{{ $metricas['tickets_abiertos'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cambiar Estado -->
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent">
                        <h6 class="mb-0"><i class="bi bi-arrow-repeat me-2"></i>Cambiar Estado</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-center gap-2 mb-3 py-2 bg-light rounded">
                            <span class="badge bg-{{ $estadoColors[$cliente->estado] ?? 'secondary' }} fs-6">
                                {{ ucfirst($cliente->estado) }}
                            </span>
                        </div>
                        <div class="d-grid gap-2">
                            @if($cliente->estado !== 'activo')
                                <form action="{{ route('admin.crm.clientes.cambiar-estado', $cliente) }}" method="POST" class="form-cambiar-estado">
                                    @csrf
                                    <input type="hidden" name="estado" value="activo">
                                    <button type="submit" class="btn btn-outline-success btn-sm w-100">
                                        <i class="bi bi-check-circle me-2"></i>Activar
                                    </button>
                                </form>
                            @endif
                            @if($cliente->estado !== 'inactivo')
                                <form action="{{ route('admin.crm.clientes.cambiar-estado', $cliente) }}" method="POST" class="form-cambiar-estado">
                                    @csrf
                                    <input type="hidden" name="estado" value="inactivo">
                                    <button type="submit" class="btn btn-outline-secondary btn-sm w-100">
                                        <i class="bi bi-pause-circle me-2"></i>Desactivar
                                    </button>
                                </form>
                            @endif
                            @if($cliente->estado !== 'suspendido')
                                <form action="{{ route('admin.crm.clientes.cambiar-estado', $cliente) }}" method="POST" class="form-cambiar-estado">
                                    @csrf
                                    <input type="hidden" name="estado" value="suspendido">
                                    <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                        <i class="bi bi-exclamation-triangle me-2"></i>Suspender
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Información -->
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent">
                        <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Información</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted">Tipo de Persona</small>
                            <p class="mb-0 fw-bold">{{ $cliente->tipo_persona === 'juridica' ? 'Jurídica' : 'Natural' }}</p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Segmento</small>
                            <p class="mb-0">
                                <span class="badge bg-{{ $segmentoColors[$cliente->segmento] ?? 'secondary' }}">{{ ucfirst($cliente->segmento) }}</span>
                            </p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Vendedor Asignado</small>
                            <p class="mb-0 fw-bold">{{ $cliente->vendedor?->persona?->name ?? 'Sin asignar' }}</p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Sede</small>
                            <p class="mb-0 fw-bold">{{ $cliente->sede?->nombre ?? '-' }}</p>
                        </div>
                        @if($cliente->prospecto)
                        <div class="mb-3">
                            <small class="text-muted">Prospecto Origen</small>
                            <p class="mb-0">
                                <a href="{{ route('admin.crm.prospectos.show', $cliente->prospecto) }}" class="text-decoration-none">
                                    {{ $cliente->prospecto->nombre_completo }}
                                </a>
                            </p>
                        </div>
                        @endif
                        @if($cliente->fecha_primera_compra)
                        <div class="mb-3">
                            <small class="text-muted">Primera Compra</small>
                            <p class="mb-0 fw-bold">{{ $cliente->fecha_primera_compra->format('d/m/Y') }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Acciones Rápidas -->
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent">
                        <h6 class="mb-0"><i class="bi bi-lightning me-2"></i>Acciones Rápidas</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.crm.clientes.edit', $cliente) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-pencil me-2"></i>Editar Cliente
                            </a>
                            <form action="{{ route('admin.crm.clientes.destroy', $cliente) }}" method="POST" id="form-eliminar">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-outline-danger btn-sm w-100 btn-eliminar">
                                    <i class="bi bi-trash me-2"></i>Eliminar Cliente
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Fechas -->
                <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent">
                        <h6 class="mb-0"><i class="bi bi-calendar me-2"></i>Fechas</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <small class="text-muted">Creado</small>
                            <p class="mb-0">{{ $cliente->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Última actualización</small>
                            <p class="mb-0">{{ $cliente->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    // SweetAlert: Cambiar Estado
    $('.form-cambiar-estado').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        var estado = $(form).find('input[name="estado"]').val();
        var label = estado.charAt(0).toUpperCase() + estado.slice(1);

        Swal.fire({
            title: '¿Cambiar estado?',
            html: 'El cliente pasará a estado <strong>' + label + '</strong>.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1C3146',
            cancelButtonColor: '#FF9C00',
            confirmButtonText: 'Sí, cambiar',
            cancelButtonText: 'Cancelar'
        }).then(function(result) {
            if (result.isConfirmed) { form.submit(); }
        });
    });

    // SweetAlert: Eliminar
    $('.btn-eliminar').on('click', function() {
        Swal.fire({
            title: '¿Eliminar cliente?',
            html: 'Se eliminará el cliente <strong>{{ Str::limit($cliente->nombre_completo, 40) }}</strong>.<br><br><strong class="text-danger">Esta acción no se puede deshacer.</strong>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1C3146',
            cancelButtonColor: '#FF9C00',
            confirmButtonText: '<i class="bi bi-trash me-1"></i> Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then(function(result) {
            if (result.isConfirmed) { $('#form-eliminar').submit(); }
        });
    });
});
</script>
@endsection
