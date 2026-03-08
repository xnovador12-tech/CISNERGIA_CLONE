@extends('TEMPLATES.administrador')
@section('title', 'Cotización ' . $cotizacion->codigo)

@section('css')
<style>
    .resumen-valor { font-size: 0.95rem; }
</style>
@endsection

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">{{ $cotizacion->codigo }}</h1>
                <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin.crm.cotizaciones.index') }}">Cotizaciones</a></li>
                        <li class="breadcrumb-item link" aria-current="page">{{ $cotizacion->codigo }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row g-4">
            {{-- ==================== COLUMNA PRINCIPAL ==================== --}}
            <div class="col-lg-8">

                {{-- Estado y Acciones --}}
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                            <div>
                                @php
                                    $estadoConfig = [
                                        'borrador' => ['color' => 'secondary', 'icono' => 'bi-pencil-square'],
                                        'enviada' => ['color' => 'primary', 'icono' => 'bi-send'],
                                        'aceptada' => ['color' => 'success', 'icono' => 'bi-check-circle'],
                                        'rechazada' => ['color' => 'danger', 'icono' => 'bi-x-circle']
                                    ];
                                    $ec = $estadoConfig[$cotizacion->estado] ?? ['color' => 'secondary', 'icono' => 'bi-circle'];
                                @endphp
                                <span class="badge bg-{{ $ec['color'] }} fs-6 px-3 py-2">
                                    <i class="bi {{ $ec['icono'] }} me-1"></i>{{ ucfirst(str_replace('_', ' ', $cotizacion->estado)) }}
                                </span>
                                @if($cotizacion->version > 1)
                                    <span class="badge bg-info ms-2">Versión {{ $cotizacion->version }}</span>
                                @endif
                            </div>
                            <div class="d-flex gap-2">
                                @if($cotizacion->oportunidad)
                                    <a href="{{ route('admin.crm.oportunidades.show', $cotizacion->oportunidad->slug) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-briefcase me-1"></i>Ver Oportunidad
                                    </a>
                                @endif
                                <a href="{{ route('admin.crm.cotizaciones.index') }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-1"></i>Volver
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Información del Cliente --}}
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0"><i class="bi bi-person me-2"></i>Información del Cliente</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <p class="mb-1 small text-muted">Oportunidad</p>
                                @if($cotizacion->oportunidad)
                                    <a href="{{ route('admin.crm.oportunidades.show', $cotizacion->oportunidad->slug) }}" class="text-decoration-none fw-bold">
                                        {{ $cotizacion->oportunidad->codigo }} - {{ $cotizacion->oportunidad->nombre }}
                                    </a>
                                    <br><small class="text-muted">{{ ucfirst($cotizacion->oportunidad->tipo_oportunidad) }} — {{ ucfirst(str_replace('_', ' ', $cotizacion->oportunidad->etapa)) }}</small>
                                @else
                                    <span class="text-muted">No asignada</span>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1 small text-muted">Prospecto / Cliente</p>
                                @if($cotizacion->oportunidad?->prospecto)
                                    <span class="fw-bold">{{ $cotizacion->oportunidad->prospecto->nombre_completo }}</span>
                                    <br><small class="text-muted">{{ $cotizacion->oportunidad->prospecto->email }} — {{ $cotizacion->oportunidad->prospecto->telefono }}</small>
                                @else
                                    <span class="text-muted">No disponible</span>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <p class="mb-1 small text-muted">Proyecto</p>
                                <span class="fw-bold">{{ $cotizacion->nombre_proyecto }}</span>
                            </div>
                            <div class="col-md-4">
                                <p class="mb-1 small text-muted">Tiempo de Ejecución</p>
                                <span>{{ $cotizacion->tiempo_ejecucion_dias ?? '-' }} días</span>
                            </div>
                            <div class="col-md-4">
                                <p class="mb-1 small text-muted">Garantía de Servicio</p>
                                <span>{{ $cotizacion->garantia_servicio ?? 'No especificada' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Detalle de Ítems --}}
                @if($cotizacion->detalles->count() > 0)
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0"><i class="bi bi-list-check me-2"></i>Detalle de la Cotización</h5>
                    </div>
                    <div class="card-body p-0">
                        @foreach($detallesPorCategoria as $categoria => $items)
                            @php
                                $catInfo = \App\Models\DetalleCotizacionCrm::CATEGORIAS[$categoria] ?? ['nombre' => ucfirst($categoria), 'color' => 'secondary', 'icono' => 'bi-box'];
                            @endphp
                            <div class="border-bottom">
                                <div class="px-3 py-2 bg-{{ $catInfo['color'] }} bg-opacity-10">
                                    <h6 class="mb-0 text-{{ $catInfo['color'] }}">
                                        <i class="bi {{ $catInfo['icono'] }} me-2"></i>{{ $catInfo['nombre'] }}
                                        <span class="badge bg-{{ $catInfo['color'] }} ms-2">{{ $items->count() }}</span>
                                    </h6>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="small">Descripción</th>
                                                <th class="small text-center">Cant.</th>
                                                <th class="small text-end">P.Unit</th>
                                                @if($items->where('descuento_porcentaje', '>', 0)->count() > 0)
                                                    <th class="small text-center">Dto.</th>
                                                @endif
                                                <th class="small text-end">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($items as $item)
                                                <tr>
                                                    <td class="small">
                                                        {{ $item->descripcion }}
                                                        @if($item->especificaciones)
                                                            <br><small class="text-muted">{{ Str::limit($item->especificaciones, 60) }}</small>
                                                        @endif
                                                        @if($item->producto)
                                                            <br><small class="text-primary"><i class="bi bi-link-45deg"></i> {{ $item->producto->codigo }}</small>
                                                        @endif
                                                        @if($item->servicio)
                                                            <br><small class="text-info"><i class="bi bi-link-45deg"></i> {{ $item->servicio->name }}</small>
                                                        @endif
                                                    </td>
                                                    <td class="small text-center">{{ number_format($item->cantidad, $item->cantidad == intval($item->cantidad) ? 0 : 2) }} {{ $item->unidad }}</td>
                                                    <td class="small text-end">S/ {{ number_format($item->precio_unitario, 2) }}</td>
                                                    @if($items->where('descuento_porcentaje', '>', 0)->count() > 0)
                                                        <td class="small text-center">
                                                            @if($item->descuento_porcentaje > 0)
                                                                <span class="text-danger">{{ $item->descuento_porcentaje }}%</span>
                                                            @else
                                                                —
                                                            @endif
                                                        </td>
                                                    @endif
                                                    <td class="small text-end fw-bold">S/ {{ number_format($item->subtotal, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="table-light">
                                            <tr>
                                                <th colspan="{{ $items->where('descuento_porcentaje', '>', 0)->count() > 0 ? 4 : 3 }}" class="small text-end">Subtotal {{ $catInfo['nombre'] }}:</th>
                                                <th class="small text-end">S/ {{ number_format($items->sum('subtotal'), 2) }}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Notas y Condiciones --}}
                @if($cotizacion->condiciones_comerciales || $cotizacion->observaciones || $cotizacion->notas_internas)
                    <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0"><i class="bi bi-card-text me-2"></i>Notas y Condiciones</h5>
                        </div>
                        <div class="card-body">
                            @if($cotizacion->condiciones_comerciales)
                                <h6 class="small text-muted text-uppercase">Condiciones Comerciales</h6>
                                <p class="mb-3" style="white-space: pre-line;">{{ $cotizacion->condiciones_comerciales }}</p>
                            @endif
                            @if($cotizacion->observaciones)
                                <h6 class="small text-muted text-uppercase">Observaciones</h6>
                                <p class="mb-3">{{ $cotizacion->observaciones }}</p>
                            @endif
                            @if($cotizacion->notas_internas)
                                <div class="p-2 bg-warning bg-opacity-10 rounded">
                                    <h6 class="small text-muted text-uppercase"><i class="bi bi-lock me-1"></i>Notas Internas</h6>
                                    <p class="mb-0 small">{{ $cotizacion->notas_internas }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

            </div>

            {{-- ==================== COLUMNA LATERAL ==================== --}}
            <div class="col-lg-4">

                {{-- Resumen de Inversión --}}
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0"><i class="bi bi-receipt me-2"></i>Resumen de Inversión</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal:</span>
                            <span class="resumen-valor">S/ {{ number_format($cotizacion->subtotal ?? 0, 2) }}</span>
                        </div>
                        @if($cotizacion->descuento_monto > 0)
                            <div class="d-flex justify-content-between mb-2 text-danger">
                                <span>Descuento ({{ number_format($cotizacion->descuento_porcentaje, 1) }}%):</span>
                                <span class="resumen-valor">- S/ {{ number_format($cotizacion->descuento_monto, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Base Imponible:</span>
                                <span class="resumen-valor">S/ {{ number_format(($cotizacion->subtotal ?? 0) - ($cotizacion->descuento_monto ?? 0), 2) }}</span>
                            </div>
                        @endif
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">
                                IGV (18%)
                                @if(!$cotizacion->incluye_igv) <small>(no incluido)</small> @endif
                            </span>
                            <span class="resumen-valor">S/ {{ number_format($cotizacion->igv ?? 0, 2) }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span class="h6 mb-0 fw-bold">TOTAL:</span>
                            <span class="h5 mb-0 text-primary fw-bold">S/ {{ number_format($cotizacion->total ?? 0, 2) }}</span>
                        </div>

                        {{-- Desglose por categoría --}}
                        @if($cotizacion->detalles->count() > 0)
                            <hr>
                            <p class="small text-muted fw-bold mb-2">Desglose por categoría:</p>
                            @foreach($detallesPorCategoria as $cat => $items)
                                @php $catInfo = \App\Models\DetalleCotizacionCrm::CATEGORIAS[$cat] ?? ['nombre' => $cat, 'color' => 'secondary']; @endphp
                                <div class="d-flex justify-content-between mb-1 small">
                                    <span><i class="bi bi-circle-fill text-{{ $catInfo['color'] }} me-1" style="font-size:0.5rem;"></i>{{ $catInfo['nombre'] }}:</span>
                                    <span class="fw-bold">S/ {{ number_format($items->sum('subtotal'), 2) }}</span>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                {{-- Fechas y Vigencia --}}
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0"><i class="bi bi-calendar3 me-2"></i>Fechas</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Emisión:</span>
                            <span>{{ $cotizacion->fecha_emision?->format('d/m/Y') ?? '-' }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Válida hasta:</span>
                            <span class="{{ $cotizacion->fecha_vigencia?->isPast() ? 'text-danger fw-bold' : '' }}">
                                {{ $cotizacion->fecha_vigencia?->format('d/m/Y') ?? '-' }}
                                @if($cotizacion->fecha_vigencia && !$cotizacion->fecha_vigencia->isPast())
                                    <small class="text-muted">({{ $cotizacion->dias_para_vencer }} días)</small>
                                @endif
                            </span>
                        </div>
                        @if($cotizacion->fecha_envio)
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Enviada:</span>
                                <span>{{ $cotizacion->fecha_envio->format('d/m/Y H:i') }}</span>
                            </div>
                        @endif
                        @if($cotizacion->fecha_respuesta)
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Respuesta:</span>
                                <span>{{ $cotizacion->fecha_respuesta->format('d/m/Y H:i') }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Cambiar Estado --}}
                @php
                    $estadosFlow = [
                        'borrador' => ['nombre' => 'Borrador', 'color' => 'secondary', 'icono' => 'bi-pencil-square'],
                        'enviada' => ['nombre' => 'Enviada', 'color' => 'primary', 'icono' => 'bi-send'],
                        'aceptada' => ['nombre' => 'Aceptada', 'color' => 'success', 'icono' => 'bi-check-circle'],
                    ];
                    $estadoActualInfo = $estadosFlow[$cotizacion->estado] ?? ['nombre' => ucfirst($cotizacion->estado), 'color' => 'secondary', 'icono' => 'bi-circle'];
                    $siguienteEstado = match($cotizacion->estado) {
                        'borrador' => $estadosFlow['enviada'],
                        'enviada' => $estadosFlow['aceptada'],
                        default => null,
                    };
                @endphp

                @if(!in_array($cotizacion->estado, ['aceptada', 'rechazada']))
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent"><h6 class="mb-0"><i class="bi bi-arrow-repeat me-2"></i>Cambiar Estado</h6></div>
                    <div class="card-body">
                        {{-- Indicador visual --}}
                        @if($siguienteEstado)
                            <div class="d-flex align-items-center justify-content-center gap-2 mb-3 py-2 bg-light rounded">
                                <span class="badge bg-{{ $estadoActualInfo['color'] }}"><i class="bi {{ $estadoActualInfo['icono'] }} me-1"></i>{{ $estadoActualInfo['nombre'] }}</span>
                                <i class="bi bi-arrow-right text-muted"></i>
                                <span class="badge bg-{{ $siguienteEstado['color'] }}"><i class="bi {{ $siguienteEstado['icono'] }} me-1"></i>{{ $siguienteEstado['nombre'] }}</span>
                            </div>
                        @endif

                        <div class="d-grid gap-2">
                            @if($cotizacion->estado === 'borrador')
                                <button type="button" class="btn btn-outline-primary btn-sm w-100 btn-enviar">
                                    <i class="bi bi-send me-2"></i>Enviar Cotización
                                </button>
                            @endif
                            @if($cotizacion->estado === 'enviada')
                                <button type="button" class="btn btn-outline-success btn-sm w-100 btn-aprobar">
                                    <i class="bi bi-check-circle me-2"></i>Marcar Aprobada
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm w-100 btn-rechazar">
                                    <i class="bi bi-x-circle me-2"></i>Marcar Rechazada
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                @elseif($cotizacion->estado === 'aceptada')
                {{-- ====== CARD COTIZACIÓN APROBADA + PEDIDO GENERADO ====== --}}
                <div class="card border-4 shadow-sm mb-4" style="border-radius: 20px; border-top: 4px solid #198754 !important;" data-aos="fade-up">
                    <div class="card-header bg-success text-white" style="border-radius: 16px 16px 0 0;">
                        <h6 class="mb-0"><i class="bi bi-check-circle me-2"></i>Cotización Aprobada</h6>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-2">
                            <i class="bi bi-calendar-check me-1"></i>
                            Aprobada el {{ $cotizacion->fecha_respuesta?->format('d/m/Y H:i') ?? '-' }}
                        </p>

                        @if(isset($pedidoGenerado) && $pedidoGenerado)
                            <hr class="my-2">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge bg-primary"><i class="bi bi-box-seam me-1"></i>Pedido Generado</span>
                                <span class="badge bg-{{ $pedidoGenerado->estado === 'pendiente' ? 'warning text-dark' : ($pedidoGenerado->estado === 'entregado' ? 'success' : 'info') }}">
                                    {{ ucfirst($pedidoGenerado->estado) }}
                                </span>
                            </div>
                            <div class="small mb-2">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted">Código:</span>
                                    <span class="fw-bold">{{ $pedidoGenerado->codigo }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted">Total:</span>
                                    <span class="fw-bold">S/ {{ number_format($pedidoGenerado->total, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted">Finanzas:</span>
                                    <span>{!! $pedidoGenerado->aprobacion_finanzas ? '<i class="bi bi-check-circle-fill text-success"></i> Aprobado' : '<i class="bi bi-clock text-warning"></i> Pendiente' !!}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Stock:</span>
                                    <span>{!! $pedidoGenerado->aprobacion_stock ? '<i class="bi bi-check-circle-fill text-success"></i> Reservado' : '<i class="bi bi-clock text-warning"></i> Pendiente' !!}</span>
                                </div>
                            </div>
                            <a href="{{ route('admin-pedidos.show', $pedidoGenerado) }}" class="btn btn-sm btn-outline-primary w-100">
                                <i class="bi bi-box-arrow-up-right me-1"></i>Ver Pedido
                            </a>
                        @else
                            <p class="text-muted small mb-0">
                                <i class="bi bi-info-circle me-1"></i>No se encontró un pedido vinculado a esta cotización.
                            </p>
                        @endif
                    </div>
                </div>

                @elseif($cotizacion->estado === 'rechazada')
                <div class="card border-4 shadow-sm mb-4" style="border-radius: 20px; border-top: 4px solid #dc3545 !important;" data-aos="fade-up">
                    <div class="card-header bg-danger text-white" style="border-radius: 16px 16px 0 0;"><h6 class="mb-0"><i class="bi bi-x-circle me-2"></i>Cotización Rechazada</h6></div>
                    <div class="card-body">
                        @if($cotizacion->motivo_rechazo)
                            <p class="mb-0"><strong>Motivo:</strong> {{ $cotizacion->motivo_rechazo }}</p>
                        @else
                            <p class="text-muted mb-0">Sin motivo registrado.</p>
                        @endif
                    </div>
                </div>
                @endif

                {{-- Acciones Rápidas --}}
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent"><h6 class="mb-0"><i class="bi bi-lightning me-2"></i>Acciones Rápidas</h6></div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.crm.cotizaciones.pdf', $cotizacion) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-file-earmark-arrow-down me-2"></i>Descargar PDF
                            </a>
                            <a href="{{ route('admin.crm.cotizaciones.preview', $cotizacion) }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-eye me-2"></i>Vista Previa PDF
                            </a>
                            @if(!in_array($cotizacion->estado, ['aceptada', 'rechazada']))
                            <a href="{{ route('admin.crm.cotizaciones.edit', $cotizacion) }}" class="btn btn-outline-warning btn-sm">
                                <i class="bi bi-pencil me-2"></i>Editar Cotización
                            </a>
                            @endif
                            <button type="button" class="btn btn-outline-secondary btn-sm btn-duplicar">
                                <i class="bi bi-copy me-2"></i>Duplicar
                            </button>
                            @if(!in_array($cotizacion->estado, ['aceptada']))
                            <button type="button" class="btn btn-outline-danger btn-sm btn-eliminar">
                                <i class="bi bi-trash me-2"></i>Eliminar
                            </button>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Auditoría --}}
                <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent"><h6 class="mb-0"><i class="bi bi-clock-history me-2"></i>Auditoría</h6></div>
                    <div class="card-body small text-muted">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Vendedor:</span>
                            <span>{{ $cotizacion->usuario?->persona?->name ?? $cotizacion->usuario?->email ?? '-' }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Creado:</span>
                            <span>{{ $cotizacion->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Actualizado:</span>
                            <span>{{ $cotizacion->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Forms ocultos para las acciones --}}
    <form id="form-enviar" action="{{ route('admin.crm.cotizaciones.enviar', $cotizacion) }}" method="POST" class="d-none">@csrf</form>
    <form id="form-aprobar" action="{{ route('admin.crm.cotizaciones.aprobar', $cotizacion) }}" method="POST" class="d-none">@csrf</form>
    <form id="form-rechazar" action="{{ route('admin.crm.cotizaciones.rechazar', $cotizacion) }}" method="POST" class="d-none">
        @csrf
        <input type="hidden" name="motivo_rechazo" id="input-motivo-rechazo">
    </form>
    <form id="form-duplicar" action="{{ route('admin.crm.cotizaciones.duplicar', $cotizacion) }}" method="POST" class="d-none">@csrf</form>
    <form id="form-eliminar" action="{{ route('admin.crm.cotizaciones.destroy', $cotizacion) }}" method="POST" class="d-none">@csrf @method('DELETE')</form>
@endsection

@section('js')
<script>
$(document).ready(function() {

    // ==================== ENVIAR COTIZACIÓN ====================
    $('.btn-enviar').on('click', function() {
        Swal.fire({
            title: '¿Enviar cotización?',
            html: `Se marcará como <strong>Enviada</strong> la cotización <strong>{{ $cotizacion->codigo }}</strong>.<br><br>
                   <small class="text-muted">Esta acción cambiará el estado y registrará la fecha de envío.</small>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1C3146',
            cancelButtonColor: '#FF9C00',
            confirmButtonText: '<i class="bi bi-send me-1"></i> Sí, enviar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form-enviar').submit();
            }
        });
    });

    // ==================== APROBAR COTIZACIÓN ====================
    $('.btn-aprobar').on('click', function() {
        Swal.fire({
            title: '¿Aprobar cotización?',
            html: `Se aprobará la cotización <strong>{{ $cotizacion->codigo }}</strong> por un total de <strong class="text-primary">S/ {{ number_format($cotizacion->total, 2) }}</strong>.<br><br>
                   <div class="text-start small">
                       <p class="mb-1"><i class="bi bi-check2 text-success me-1"></i> Cotización → <strong>Aceptada</strong></p>
                       <p class="mb-1"><i class="bi bi-check2 text-success me-1"></i> Prospecto → <strong>Convertido a Cliente</strong></p>
                       <p class="mb-1"><i class="bi bi-check2 text-success me-1"></i> Oportunidad → <strong>Ganada</strong></p>
                       <p class="mb-0"><i class="bi bi-check2 text-success me-1"></i> Pedido → <strong>Creado automáticamente</strong></p>
                   </div>`,
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#1C3146',
            cancelButtonColor: '#FF9C00',
            confirmButtonText: '<i class="bi bi-check-circle me-1"></i> Sí, aprobar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form-aprobar').submit();
            }
        });
    });

    // ==================== RECHAZAR COTIZACIÓN ====================
    $('.btn-rechazar').on('click', function() {
        Swal.fire({
            title: '¿Rechazar cotización?',
            html: `Se marcará como <strong class="text-danger">Rechazada</strong> la cotización <strong>{{ $cotizacion->codigo }}</strong>.`,
            icon: 'warning',
            input: 'textarea',
            inputLabel: 'Motivo del rechazo',
            inputPlaceholder: 'Ej: El cliente consiguió mejor precio con la competencia...',
            inputAttributes: {
                'aria-label': 'Motivo del rechazo',
                'maxlength': 500
            },
            inputValidator: (value) => {
                if (!value || value.trim().length < 5) {
                    return 'Debe ingresar un motivo (mínimo 5 caracteres)';
                }
            },
            showCancelButton: true,
            confirmButtonColor: '#1C3146',
            cancelButtonColor: '#FF9C00',
            confirmButtonText: '<i class="bi bi-x-circle me-1"></i> Sí, rechazar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#input-motivo-rechazo').val(result.value);
                $('#form-rechazar').submit();
            }
        });
    });

    // ==================== DUPLICAR COTIZACIÓN ====================
    $('.btn-duplicar').on('click', function() {
        Swal.fire({
            title: '¿Duplicar cotización?',
            html: `Se creará una nueva versión basada en <strong>{{ $cotizacion->codigo }}</strong> con todos sus ítems.<br><br>
                   <small class="text-muted">La nueva cotización se abrirá en modo edición.</small>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1C3146',
            cancelButtonColor: '#FF9C00',
            confirmButtonText: '<i class="bi bi-copy me-1"></i> Sí, duplicar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form-duplicar').submit();
            }
        });
    });

    // ==================== ELIMINAR COTIZACIÓN ====================
    $('.btn-eliminar').on('click', function() {
        Swal.fire({
            title: '¿Eliminar cotización?',
            html: `Se eliminará permanentemente la cotización <strong>{{ $cotizacion->codigo }}</strong> y todos sus ítems.<br><br>
                   <strong class="text-danger">Esta acción no se puede deshacer.</strong>`,
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#1C3146',
            cancelButtonColor: '#FF9C00',
            confirmButtonText: '<i class="bi bi-trash me-1"></i> Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form-eliminar').submit();
            }
        });
    });
});
</script>
@endsection
