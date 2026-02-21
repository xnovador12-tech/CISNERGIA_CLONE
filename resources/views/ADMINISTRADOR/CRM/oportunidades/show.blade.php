@extends('TEMPLATES.administrador')
@section('title', 'Detalle Oportunidad')

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">DETALLE OPORTUNIDAD</h1>
                <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin.crm.oportunidades.index') }}">Oportunidades</a></li>
                        <li class="breadcrumb-item link" aria-current="page">{{ $oportunidad->codigo }}</li>
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
    @if(session('info'))
        <div class="container-fluid mb-3">
            <div class="alert alert-info alert-dismissible fade show"><i class="bi bi-info-circle me-2"></i>{{ session('info') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        </div>
    @endif

    @php
        $etapaColors = [
            'calificacion' => 'primary', 'evaluacion' => 'info',
            'propuesta_tecnica' => 'warning', 'negociacion' => 'secondary',
            'ganada' => 'success', 'perdida' => 'danger'
        ];
    @endphp

    <div class="container-fluid">
        <div class="row g-4">
            <div class="col-lg-8">
                {{-- Info Principal --}}
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-secondary fs-6 me-2">{{ $oportunidad->codigo }}</span>
                            <span class="badge bg-{{ $etapaColors[$oportunidad->etapa] ?? 'secondary' }}">
                                {{ \App\Models\Oportunidad::ETAPAS[$oportunidad->etapa]['nombre'] ?? ucfirst($oportunidad->etapa) }}
                            </span>
                        </div>
                        <a href="{{ route('admin.crm.oportunidades.edit', ['oportunidad' => $oportunidad, 'redirect_to' => 'show']) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil me-1"></i>Editar</a>
                    </div>
                    <div class="card-body">
                        <h4 class="fw-bold mb-3">{{ $oportunidad->nombre }}</h4>
                        
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <p class="text-muted mb-1">Cliente/Prospecto</p>
                                <p class="fw-bold mb-0">
                                    @if($oportunidad->cliente)
                                        <span class="badge bg-success me-1">Cliente</span>{{ $oportunidad->cliente->nombre }}
                                    @elseif($oportunidad->prospecto)
                                        <span class="badge bg-warning text-dark me-1">Prospecto</span>{{ $oportunidad->prospecto->nombre_completo }}
                                    @else
                                        <span class="text-muted">No asignado</span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p class="text-muted mb-1">Tipo</p>
                                <p class="mb-0">
                                    <span class="badge bg-{{ ['producto' => 'success', 'servicio' => 'warning', 'mixto' => 'info'][$oportunidad->tipo_oportunidad] ?? 'secondary' }}">
                                        {{ ucfirst($oportunidad->tipo_oportunidad) }}
                                    </span>
                                    <span class="badge bg-light text-dark ms-1">{{ ucfirst($oportunidad->tipo_proyecto) }}</span>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p class="text-muted mb-1">Asignado a</p>
                                <p class="fw-bold mb-0">{{ $oportunidad->vendedor->persona->name ?? 'Sin asignar' }} {{ $oportunidad->vendedor->persona->surnames ?? '' }}</p>
                            </div>
                        </div>

                        @if($oportunidad->descripcion)
                            <div class="bg-light p-3 rounded mb-3">
                                <small class="text-muted d-block mb-1">Descripción del negocio:</small>
                                <p class="mb-0">{{ $oportunidad->descripcion }}</p>
                            </div>
                        @endif

                        @if($oportunidad->observaciones)
                            <div class="bg-light p-3 rounded">
                                <small class="text-muted d-block mb-1">Observaciones:</small>
                                <p class="mb-0">{{ $oportunidad->observaciones }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Datos Técnicos / Servicio --}}
                @if($oportunidad->tipo_servicio || $oportunidad->requiere_visita_tecnica)
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-header bg-transparent"><h6 class="mb-0"><i class="bi bi-clipboard-data me-2"></i>Datos Técnicos</h6></div>
                    <div class="card-body">
                        <div class="row g-3">
                            {{-- Servicio --}}
                            @if($oportunidad->tipo_servicio)
                            <div class="col-md-6">
                                <div class="bg-success bg-opacity-10 rounded p-3">
                                    <p class="mb-1 small text-muted"><i class="bi bi-wrench me-1"></i>Tipo de Servicio</p>
                                    <p class="mb-0 fw-bold">{{ ucfirst(str_replace('_', ' ', $oportunidad->tipo_servicio)) }}</p>
                                    @if($oportunidad->descripcion_servicio)
                                        <p class="mb-0 mt-1 small text-muted">{{ $oportunidad->descripcion_servicio }}</p>
                                    @endif
                                </div>
                            </div>
                            @endif

                            {{-- Visita Técnica --}}
                            @if($oportunidad->requiere_visita_tecnica)
                            <div class="col-12">
                                <div class="bg-warning bg-opacity-10 rounded p-3">
                                    <p class="mb-1 small text-muted"><i class="bi bi-geo-alt me-1"></i>Visita Técnica</p>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p class="mb-0"><strong>Fecha programada:</strong> {{ $oportunidad->fecha_visita_programada?->format('d/m/Y') ?? 'Por definir' }}</p>
                                        </div>
                                        @if($oportunidad->resultado_visita)
                                        <div class="col-md-8">
                                            <p class="mb-0"><strong>Resultado:</strong> {{ $oportunidad->resultado_visita }}</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                {{-- Productos de Interés --}}
                @if($oportunidad->productosInteres->count() > 0)
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up" data-aos-delay="150">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h6 class="mb-0"><i class="bi bi-box-seam me-2"></i>Productos de Interés</h6>
                        <span class="badge bg-primary">{{ $oportunidad->productosInteres->count() }} producto(s)</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Producto</th>
                                        <th class="text-center" style="width: 10%">Cant.</th>
                                        <th class="text-center" style="width: 12%">P. Unit.</th>
                                        <th class="text-center" style="width: 12%">Subtotal</th>
                                        <th>Notas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $totalProductos = 0; @endphp
                                    @foreach($oportunidad->productosInteres as $producto)
                                    @php
                                        $subtotal = $producto->precio * $producto->pivot->cantidad;
                                        $totalProductos += $subtotal;
                                    @endphp
                                    <tr>
                                        <td>
                                            <i class="bi bi-box-seam text-primary me-1"></i>
                                            <strong class="small">{{ $producto->name }}</strong>
                                            @if($producto->marca)
                                                <small class="text-muted ms-1">({{ $producto->marca->name }})</small>
                                            @endif
                                            <br>
                                            @if($producto->tipo)
                                                <span class="badge bg-secondary bg-opacity-10 text-secondary" style="font-size: 0.65rem;">{{ $producto->tipo->name }}</span>
                                            @endif
                                            @if($producto->categorie)
                                                <span class="badge bg-info bg-opacity-10 text-info" style="font-size: 0.65rem;">{{ $producto->categorie->name }}</span>
                                            @endif
                                            @if($producto->codigo)
                                                <small class="text-muted ms-1">{{ $producto->codigo }}</small>
                                            @endif
                                        </td>
                                        <td class="text-center fw-bold">{{ number_format($producto->pivot->cantidad, $producto->pivot->cantidad == intval($producto->pivot->cantidad) ? 0 : 2) }}</td>
                                        <td class="text-center">S/ {{ number_format($producto->precio, 2) }}</td>
                                        <td class="text-center fw-semibold">S/ {{ number_format($subtotal, 2) }}</td>
                                        <td><small class="text-muted">{{ $producto->pivot->notas ?? '-' }}</small></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="bg-light fw-bold">
                                        <td colspan="3" class="text-end">Total Productos:</td>
                                        <td class="text-center text-primary">S/ {{ number_format($totalProductos, 2) }}</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Cotizaciones --}}
                <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h6 class="mb-0"><i class="bi bi-file-text me-2"></i>Cotizaciones</h6>
                        @if(!in_array($oportunidad->etapa, ['ganada', 'perdida']))
                            <a href="{{ route('admin.crm.cotizaciones.create', ['oportunidad_id' => $oportunidad->id]) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-plus-circle me-1"></i>Nueva Cotización
                            </a>
                        @endif
                    </div>
                    <div class="card-body">
                        @forelse($oportunidad->cotizaciones ?? [] as $cotizacion)
                            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                                <div>
                                    <span class="badge bg-secondary me-2">{{ $cotizacion->codigo }}</span>
                                    <span class="badge bg-{{ $cotizacion->estado == 'aprobada' ? 'success' : ($cotizacion->estado == 'rechazada' ? 'danger' : 'warning') }}">{{ ucfirst($cotizacion->estado) }}</span>
                                </div>
                                <div>
                                    <span class="fw-bold text-primary">S/ {{ number_format($cotizacion->total, 0) }}</span>
                                    <a href="{{ route('admin.crm.cotizaciones.show', $cotizacion) }}" class="btn btn-sm btn-outline-primary ms-2"><i class="bi bi-eye"></i></a>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted text-center py-3"><i class="bi bi-inbox fs-3 d-block mb-2"></i>No hay cotizaciones</p>
                        @endforelse
                    </div>
                </div>

                {{-- Actividades --}}
                <div class="card border-4 borde-top-secondary shadow-sm mt-4" style="border-radius: 20px" data-aos="fade-up" data-aos-delay="300">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h6 class="mb-0"><i class="bi bi-calendar-check me-2"></i>Actividades</h6>
                        @if(!in_array($oportunidad->etapa, ['ganada', 'perdida']))
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalActividad">
                                <i class="bi bi-plus me-1"></i>Nueva Actividad
                            </button>
                        @endif
                    </div>
                    <div class="card-body">
                        @forelse($oportunidad->actividades ?? [] as $actividad)
                            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                                <div>
                                    @php
                                        $tipoIcons = [
                                            'llamada' => 'bi-telephone', 'email' => 'bi-envelope', 'reunion' => 'bi-people',
                                            'visita_tecnica' => 'bi-geo-alt', 'videollamada' => 'bi-camera-video',
                                            'whatsapp' => 'bi-whatsapp', 'tarea' => 'bi-check2-square', 'nota' => 'bi-sticky'
                                        ];
                                        $estadoColors = [
                                            'programada' => 'warning', 'en_progreso' => 'info', 'completada' => 'success',
                                            'cancelada' => 'danger', 'reprogramada' => 'secondary', 'no_realizada' => 'dark'
                                        ];
                                    @endphp
                                    <i class="bi {{ $tipoIcons[$actividad->tipo] ?? 'bi-circle' }} me-2 text-primary"></i>
                                    <strong class="small">{{ Str::limit($actividad->titulo, 35) }}</strong>
                                    <span class="badge bg-{{ $estadoColors[$actividad->estado] ?? 'secondary' }} ms-1">{{ ucfirst(str_replace('_', ' ', $actividad->estado)) }}</span>
                                </div>
                                <div class="text-end">
                                    <small class="text-muted">{{ $actividad->fecha_programada?->format('d/m/Y') }}</small>
                                    <a href="{{ route('admin.crm.actividades.show', $actividad) }}" class="btn btn-sm btn-outline-success ms-1"><i class="bi bi-eye"></i></a>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted text-center py-3"><i class="bi bi-calendar-x fs-3 d-block mb-2"></i>No hay actividades registradas</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                {{-- Valoración --}}
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-header bg-transparent"><h6 class="mb-0"><i class="bi bi-currency-dollar me-2"></i>Valoración</h6></div>
                    <div class="card-body text-center">
                        <h2 class="text-primary fw-bold mb-3">S/ {{ number_format($oportunidad->monto_estimado, 0) }}</h2>
                        <div class="mb-3">
                            <small class="text-muted">Probabilidad</small>
                            <div class="progress mt-1" style="height: 20px;">
                                <div class="progress-bar bg-{{ $oportunidad->probabilidad >= 70 ? 'success' : ($oportunidad->probabilidad >= 40 ? 'warning' : 'danger') }}"
                                     style="width: {{ $oportunidad->probabilidad }}%">{{ $oportunidad->probabilidad }}%</div>
                            </div>
                        </div>
                        <p class="mb-0"><strong>Valor Ponderado:</strong> S/ {{ number_format($oportunidad->monto_estimado * $oportunidad->probabilidad / 100, 0) }}</p>
                        @if($oportunidad->monto_final)
                            <p class="mt-2 mb-0 text-success"><strong>Monto Final:</strong> S/ {{ number_format($oportunidad->monto_final, 0) }}</p>
                        @endif
                    </div>
                </div>

                {{-- Acciones --}}
                @if(!in_array($oportunidad->etapa, ['ganada', 'perdida']))
                @php
                    $etapas = array_keys(\App\Models\Oportunidad::ETAPAS);
                    $indiceActual = array_search($oportunidad->etapa, $etapas);
                    $siguienteEtapa = ($indiceActual !== false && $indiceActual < count($etapas) - 2)
                        ? \App\Models\Oportunidad::ETAPAS[$etapas[$indiceActual + 1]] : null;
                    $etapaActualInfo = \App\Models\Oportunidad::ETAPAS[$oportunidad->etapa];
                @endphp
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-header bg-transparent"><h6 class="mb-0"><i class="bi bi-lightning me-2"></i>Acciones</h6></div>
                    <div class="card-body">
                        {{-- Indicador de etapa actual → siguiente --}}
                        @if($siguienteEtapa)
                            <div class="d-flex align-items-center justify-content-center gap-2 mb-3 py-2 bg-light rounded">
                                <span class="badge bg-{{ $etapaActualInfo['color'] }}">{{ $etapaActualInfo['nombre'] }}</span>
                                <i class="bi bi-arrow-right text-muted"></i>
                                <span class="badge bg-{{ $siguienteEtapa['color'] }}">{{ $siguienteEtapa['nombre'] }}</span>
                                <small class="text-muted ms-1">({{ $siguienteEtapa['probabilidad'] }}%)</small>
                            </div>
                        @else
                            <div class="text-center mb-3 py-2 bg-light rounded">
                                <small class="text-muted"><i class="bi bi-flag-fill text-success me-1"></i>Última etapa activa — Solo puede marcar como Ganada o Perdida</small>
                            </div>
                        @endif

                        <div class="d-grid gap-2">
                            @if($siguienteEtapa)
                            <form action="{{ route('admin.crm.oportunidades.avanzar', $oportunidad) }}" method="POST" id="form-avanzar">@csrf
                                <button type="button" class="btn btn-outline-primary btn-sm w-100 btn-avanzar">
                                    <i class="bi bi-arrow-right me-2"></i>Avanzar a {{ $siguienteEtapa['nombre'] }}
                                </button>
                            </form>
                            @endif
                            <form action="{{ route('admin.crm.oportunidades.ganada', $oportunidad) }}" method="POST" id="form-ganada">@csrf
                                <button type="button" class="btn btn-outline-success btn-sm w-100 btn-ganada">
                                    <i class="bi bi-trophy me-2"></i>Marcar Ganada
                                </button>
                            </form>
                            <form action="{{ route('admin.crm.oportunidades.perdida', $oportunidad) }}" method="POST" id="form-perdida">@csrf
                                <input type="hidden" name="motivo_perdida" id="input-motivo-perdida">
                                <button type="button" class="btn btn-outline-danger btn-sm w-100 btn-perdida">
                                    <i class="bi bi-x-circle me-2"></i>Marcar Perdida
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @elseif($oportunidad->etapa === 'ganada')
                <div class="card border-4 shadow-sm mb-4" style="border-radius: 20px; border-top: 4px solid #198754 !important;" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-header bg-success text-white" style="border-radius: 16px 16px 0 0;"><h6 class="mb-0"><i class="bi bi-trophy me-2"></i>¡Oportunidad Ganada!</h6></div>
                    <div class="card-body">
                        @if($oportunidad->prospecto && !$oportunidad->prospecto->es_cliente)
                            <p class="text-muted mb-3">El prospecto aún no ha sido convertido a cliente.</p>
                            <form action="{{ route('admin.crm.oportunidades.convertir-cliente', $oportunidad) }}" method="POST" id="form-convertir">@csrf
                                <button type="button" class="btn btn-success w-100 btn-convertir">
                                    <i class="bi bi-person-check me-2"></i>Convertir a Cliente
                                </button>
                            </form>
                        @elseif($oportunidad->cliente || ($oportunidad->prospecto && $oportunidad->prospecto->es_cliente))
                            <div class="alert alert-success mb-0">
                                <i class="bi bi-check-circle me-2"></i><strong>Cliente registrado:</strong> {{ $oportunidad->cliente?->codigo ?? $oportunidad->prospecto?->cliente?->codigo }}
                            </div>
                        @else
                            <p class="text-muted mb-0">Sin prospecto asociado para convertir.</p>
                        @endif
                    </div>
                </div>
                @elseif($oportunidad->etapa === 'perdida')
                <div class="card border-4 shadow-sm mb-4" style="border-radius: 20px; border-top: 4px solid #dc3545 !important;" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-header bg-danger text-white" style="border-radius: 16px 16px 0 0;"><h6 class="mb-0"><i class="bi bi-x-circle me-2"></i>Oportunidad Perdida</h6></div>
                    <div class="card-body">
                        @if($oportunidad->motivo_perdida)
                            <p class="mb-1"><strong>Motivo:</strong> {{ $oportunidad->motivo_perdida }}</p>
                            @if($oportunidad->detalle_perdida)<p class="mb-1 text-muted small">{{ $oportunidad->detalle_perdida }}</p>@endif
                            @if($oportunidad->competidor_ganador)<p class="mb-0"><strong>Competidor:</strong> {{ $oportunidad->competidor_ganador }}</p>@endif
                        @else
                            <p class="text-muted mb-0">Sin motivo registrado.</p>
                        @endif
                    </div>
                </div>
                @endif

                {{-- Fechas --}}
                <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up" data-aos-delay="300">
                    <div class="card-header bg-transparent"><h6 class="mb-0"><i class="bi bi-calendar me-2"></i>Fechas</h6></div>
                    <div class="card-body">
                        <div class="mb-2"><small class="text-muted">Creada</small><p class="mb-0">{{ $oportunidad->created_at->format('d/m/Y H:i') }}</p></div>
                        <div class="mb-2"><small class="text-muted">Cierre Estimado</small><p class="mb-0">{{ $oportunidad->fecha_cierre_estimada?->format('d/m/Y') ?? 'No definido' }}</p></div>
                        @if($oportunidad->fecha_cierre_real)
                            <div class="mb-2"><small class="text-muted">Cierre Real</small><p class="mb-0">{{ $oportunidad->fecha_cierre_real->format('d/m/Y') }}</p></div>
                        @endif
                        <div><small class="text-muted">Días en pipeline</small><p class="mb-0 fw-bold">{{ $oportunidad->dias_en_pipeline }} días</p></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Nueva Actividad -->
    <div class="modal fade" id="modalActividad" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Nueva Actividad</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.crm.oportunidades.actividad', $oportunidad) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        {{-- Info de entidad --}}
                        <div class="card border-0 rounded-0 border-start border-3 border-info mb-3" style="box-shadow: rgba(17, 17, 26, 0.1) 0px 1px 0px; background-color: #f6f6f6">
                            <div class="card-body py-2">
                                <i class="bi bi-link-45deg text-info me-2"></i>
                                <small class="text-muted">
                                    Actividad vinculada a <strong>Oportunidad</strong>:
                                    <span class="badge bg-secondary">{{ $oportunidad->codigo }}</span>
                                    {{ $oportunidad->nombre }}
                                </small>
                            </div>
                        </div>

                        <div class="row g-3">
                            {{-- Tipo de Actividad --}}
                            <div class="col-md-6">
                                <label class="form-label">Tipo de Actividad <span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm select2-modal" name="tipo" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="llamada">📞 Llamada</option>
                                    <option value="email">📧 Email</option>
                                    <option value="reunion">👥 Reunión</option>
                                    <option value="visita_tecnica">🏗️ Visita Técnica</option>
                                    <option value="videollamada">🎥 Videollamada</option>
                                    <option value="whatsapp">💬 WhatsApp</option>
                                    <option value="tarea">✅ Tarea</option>
                                    <option value="nota">📝 Nota</option>
                                </select>
                            </div>

                            {{-- Prioridad --}}
                            <div class="col-md-6">
                                <label class="form-label">Prioridad</label>
                                <select class="form-select form-select-sm select2-modal" name="prioridad">
                                    <option value="baja">🟢 Baja</option>
                                    <option value="media" selected>🟡 Media</option>
                                    <option value="alta">🔴 Alta</option>
                                    <option value="urgente">🚨 Urgente</option>
                                </select>
                            </div>

                            {{-- Título --}}
                            <div class="col-12">
                                <label class="form-label">Título <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" name="titulo" required placeholder="Ej: Reunión de presentación de propuesta">
                            </div>

                            {{-- Descripción --}}
                            <div class="col-12">
                                <label class="form-label">Descripción</label>
                                <textarea class="form-control form-control-sm" name="descripcion" rows="3" placeholder="Detalles adicionales de la actividad..."></textarea>
                            </div>

                            {{-- Fecha Programada --}}
                            <div class="col-md-6">
                                <label class="form-label">Fecha y Hora <span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control form-control-sm" name="fecha_programada" required>
                            </div>

                            {{-- Responsable --}}
                            <div class="col-md-6">
                                <label class="form-label">Responsable <span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm select2-modal" name="user_id" required>
                                    @foreach($vendedores ?? [] as $vendedor)
                                        <option value="{{ $vendedor->id }}" {{ auth()->id() == $vendedor->id ? 'selected' : '' }}>
                                            {{ $vendedor->persona?->name ?? $vendedor->email }} {{ $vendedor->persona?->surnames ?? '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-2"></i>Guardar Actividad
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
$(document).ready(function() {

    // ==================== SELECT2 EN MODAL ====================
    $('#modalActividad').on('shown.bs.modal', function() {
        $('.select2-modal').select2({
            theme: "bootstrap-5",
            width: '100%',
            dropdownParent: $('#modalActividad')
        });
    });

    // ==================== AVANZAR ETAPA ====================
    $('.btn-avanzar').on('click', function() {
        Swal.fire({
            title: '¿Avanzar de etapa?',
            html: `La oportunidad <strong>{{ $oportunidad->codigo }}</strong> pasará de <strong>{{ $etapaActualInfo['nombre'] }}</strong> a <strong>{{ $siguienteEtapa['nombre'] ?? 'siguiente' }}</strong>.
                   <br><br><small class="text-muted">La probabilidad se ajustará a {{ $siguienteEtapa['probabilidad'] ?? '-' }}%</small>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#0d6efd',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="bi bi-arrow-right me-1"></i> Sí, avanzar a {{ $siguienteEtapa['nombre'] ?? 'siguiente' }}',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form-avanzar').submit();
            }
        });
    });

    // ==================== MARCAR GANADA ====================
    $('.btn-ganada').on('click', function() {
        Swal.fire({
            title: '🏆 ¿Marcar como Ganada?',
            html: `La oportunidad <strong>{{ $oportunidad->codigo }}</strong> se marcará como <strong class="text-success">GANADA</strong> por <strong class="text-primary">S/ {{ number_format($oportunidad->monto_estimado, 0) }}</strong>.<br><br>
                   <small class="text-muted">Se registrará la fecha de cierre real.</small>`,
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="bi bi-trophy me-1"></i> Sí, marcar Ganada',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form-ganada').submit();
            }
        });
    });

    // ==================== MARCAR PERDIDA ====================
    $('.btn-perdida').on('click', function() {
        Swal.fire({
            title: '¿Marcar como Perdida?',
            html: `La oportunidad <strong>{{ $oportunidad->codigo }}</strong> se marcará como <strong class="text-danger">PERDIDA</strong>.`,
            icon: 'warning',
            input: 'textarea',
            inputLabel: 'Motivo de la pérdida',
            inputPlaceholder: 'Ej: El cliente eligió a la competencia por precio...',
            inputAttributes: { 'aria-label': 'Motivo de la pérdida', maxlength: 500 },
            inputValidator: (value) => {
                if (!value || value.trim().length < 5) {
                    return 'Debe ingresar un motivo (mínimo 5 caracteres)';
                }
            },
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="bi bi-x-circle me-1"></i> Sí, marcar Perdida',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#input-motivo-perdida').val(result.value);
                $('#form-perdida').submit();
            }
        });
    });

    // ==================== CONVERTIR A CLIENTE ====================
    $('.btn-convertir').on('click', function() {
        Swal.fire({
            title: '¿Convertir a Cliente?',
            html: `El prospecto <strong>{{ $oportunidad->prospecto->nombre_completo ?? 'N/A' }}</strong> será registrado como <strong class="text-success">Cliente</strong> en el sistema.<br><br>
                   <small class="text-muted">Se creará un registro de cliente con toda la información del prospecto.</small>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="bi bi-person-check me-1"></i> Sí, convertir',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form-convertir').submit();
            }
        });
    });

});
</script>
@endsection
