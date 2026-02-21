@extends('TEMPLATES.administrador')
@section('title', 'Cotización ' . $cotizacion->codigo)

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

    @if(session('success'))
        <div class="container-fluid mb-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="container-fluid mb-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

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
                                    $estadoColors = [
                                        'borrador' => 'secondary', 'enviada' => 'primary',
                                        'aceptada' => 'success', 'rechazada' => 'danger'
                                    ];
                                @endphp
                                <span class="badge bg-{{ $estadoColors[$cotizacion->estado] ?? 'secondary' }} fs-6 px-3 py-2">
                                    <i class="bi bi-circle-fill me-1"></i>{{ ucfirst(str_replace('_', ' ', $cotizacion->estado)) }}
                                </span>
                                @if($cotizacion->version > 1)
                                    <span class="badge bg-info ms-2">Versión {{ $cotizacion->version }}</span>
                                @endif
                            </div>
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="{{ route('admin.crm.cotizaciones.pdf', $cotizacion) }}" class="btn btn-danger btn-sm">
                                    <i class="bi bi-file-pdf me-1"></i>PDF
                                </a>
                                @if(!in_array($cotizacion->estado, ['aceptada', 'rechazada']))
                                    <a href="{{ route('admin.crm.cotizaciones.edit', $cotizacion) }}" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil me-1"></i>Editar
                                    </a>
                                @endif
                                @if($cotizacion->estado === 'borrador')
                                    <button type="button" class="btn btn-primary btn-sm btn-enviar">
                                        <i class="bi bi-send me-1"></i>Enviar
                                    </button>
                                @endif
                                <button type="button" class="btn btn-outline-secondary btn-sm btn-duplicar">
                                    <i class="bi bi-copy me-1"></i>Duplicar
                                </button>
                                @if(!in_array($cotizacion->estado, ['aceptada']))
                                    <button type="button" class="btn btn-outline-danger btn-sm btn-eliminar">
                                        <i class="bi bi-trash me-1"></i>Eliminar
                                    </button>
                                @endif
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

                @if($cotizacion->motivo_rechazo)
                    <div class="card border-4 border-top border-danger shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                        <div class="card-body">
                            <h6 class="text-danger"><i class="bi bi-x-circle me-2"></i>Motivo de Rechazo</h6>
                            <p class="mb-0">{{ $cotizacion->motivo_rechazo }}</p>
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
                        <table class="table table-sm table-borderless mb-0">
                            <tr>
                                <td>Subtotal:</td>
                                <td class="text-end">S/ {{ number_format($cotizacion->subtotal ?? 0, 2) }}</td>
                            </tr>
                            @if($cotizacion->descuento_monto > 0)
                                <tr class="text-danger">
                                    <td>Descuento ({{ number_format($cotizacion->descuento_porcentaje, 1) }}%):</td>
                                    <td class="text-end">- S/ {{ number_format($cotizacion->descuento_monto, 2) }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td>
                                    IGV (18%)
                                    @if(!$cotizacion->incluye_igv) <small class="text-muted">(no incluido)</small> @endif
                                </td>
                                <td class="text-end">S/ {{ number_format($cotizacion->igv ?? 0, 2) }}</td>
                            </tr>
                            <tr class="border-top">
                                <td><h5 class="mb-0 fw-bold">TOTAL:</h5></td>
                                <td class="text-end"><h5 class="mb-0 text-primary fw-bold">S/ {{ number_format($cotizacion->total ?? 0, 2) }}</h5></td>
                            </tr>
                        </table>

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

                {{-- Acciones de Estado --}}
                @if($cotizacion->estado === 'enviada')
                    <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0"><i class="bi bi-check2-square me-2"></i>Decisión del Cliente</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-success w-100 btn-aprobar">
                                    <i class="bi bi-check-circle me-2"></i>Marcar como Aprobada
                                </button>
                                <button type="button" class="btn btn-outline-danger w-100 btn-rechazar">
                                    <i class="bi bi-x-circle me-2"></i>Marcar como Rechazada
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Auditoría --}}
                <div class="card border-0 shadow-sm" style="border-radius: 10px" data-aos="fade-up">
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
            confirmButtonColor: '#0d6efd',
            cancelButtonColor: '#6c757d',
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
            html: `Se marcará como <strong class="text-success">Aceptada</strong> la cotización <strong>{{ $cotizacion->codigo }}</strong> por un total de <strong class="text-primary">S/ {{ number_format($cotizacion->total, 2) }}</strong>.<br><br>
                   <small class="text-muted">Esto actualizará el monto final de la oportunidad vinculada.</small>`,
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#6c757d',
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
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
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
            confirmButtonColor: '#6c757d',
            cancelButtonColor: '#6c757d',
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
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
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
