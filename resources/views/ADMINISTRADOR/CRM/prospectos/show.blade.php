@extends('TEMPLATES.administrador')

@section('title', 'Detalle Prospecto')

@section('css')
<style>
    .timeline-item {
        position: relative;
        padding-left: 30px;
        padding-bottom: 20px;
        border-left: 2px solid #dee2e6;
    }
    .timeline-item:last-child { border-left: 2px solid transparent; }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -6px;
        top: 0;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #0d6efd;
    }
</style>
@endsection

@section('content')
    @php
        $wishlistTotal = isset($wishlistItems) && $wishlistItems->count() > 0
            ? $wishlistItems->sum(fn($i) => $i->precio_descuento && $i->precio_descuento < $i->precio ? $i->precio_descuento : $i->precio)
            : 0;
        $oportunidadParams = ['prospecto_id' => $prospecto->id];
        if ($wishlistTotal > 0) {
            $oportunidadParams['monto_estimado'] = $wishlistTotal;
        }
    @endphp

    <!-- Encabezado -->
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">DETALLE PROSPECTO</h1>
                <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin.crm.prospectos.index') }}">Prospectos</a></li>
                        <li class="breadcrumb-item link" aria-current="page">{{ $prospecto->codigo }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- Alertas --}}
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
            <!-- Columna Principal -->
            <div class="col-lg-8">
                <!-- Información del Prospecto -->
                <div class="card border-0 shadow-sm mb-4" data-aos="fade-in">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-secondary fs-6 me-2">{{ $prospecto->codigo }}</span>
                            @php
                                $estadoColors = [
                                    'nuevo' => 'secondary',
                                    'contactado' => 'primary',
                                    'calificado' => 'success',
                                    'descartado' => 'danger',
                                    'convertido' => 'dark',
                                ];
                            @endphp
                            <span class="badge bg-{{ $estadoColors[$prospecto->estado] ?? 'secondary' }}">
                                {{ ucfirst(str_replace('_', ' ', $prospecto->estado)) }}
                            </span>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.crm.prospectos.edit', ['prospecto' => $prospecto, 'redirect_to' => 'show']) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil me-1"></i>Editar
                            </a>
                            @if($prospecto->estado === 'calificado' && !$prospecto->es_cliente)
                                <a href="{{ route('admin.crm.oportunidades.create', $oportunidadParams) }}" class="btn btn-sm btn-success">
                                    <i class="bi bi-arrow-right-circle me-1"></i>Crear Oportunidad
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="fw-bold mb-1">
                                    @if($prospecto->tipo_persona == 'juridica')
                                        {{ $prospecto->razon_social ?? $prospecto->nombre }}
                                    @else
                                        {{ $prospecto->nombre }} {{ $prospecto->apellidos }}
                                    @endif
                                </h4>
                                <p class="text-muted mb-3">
                                    @if($prospecto->tipo_persona == 'juridica' && $prospecto->ruc)
                                        RUC: {{ $prospecto->ruc }}
                                    @elseif($prospecto->dni)
                                        DNI: {{ $prospecto->dni }}
                                    @endif
                                </p>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        @if($prospecto->email)
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-envelope text-primary me-2"></i>
                                            <a href="mailto:{{ $prospecto->email }}">{{ $prospecto->email }}</a>
                                        </div>
                                        @endif
                                        @if($prospecto->telefono)
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-telephone text-primary me-2"></i>
                                            <a href="tel:{{ $prospecto->telefono }}">{{ $prospecto->telefono }}</a>
                                        </div>
                                        @endif
                                        @if($prospecto->celular)
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-phone text-success me-2"></i>
                                            <a href="tel:{{ $prospecto->celular }}">{{ $prospecto->celular }}</a>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        @if($prospecto->direccion)
                                        <div class="d-flex align-items-start mb-2">
                                            <i class="bi bi-geo-alt text-primary me-2 mt-1"></i>
                                            <span>{{ $prospecto->direccion }}
                                                @if($prospecto->distrito)
                                                    <br>{{ $prospecto->distrito->nombre }}
                                                @endif
                                            </span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Observaciones -->
                @if($prospecto->observaciones)
                    <div class="card border-0 shadow-sm mb-4" data-aos="fade-in">
                        <div class="card-header bg-transparent">
                            <h6 class="mb-0"><i class="bi bi-journal-text me-2"></i>Observaciones</h6>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">{{ $prospecto->observaciones }}</p>
                        </div>
                    </div>
                @endif

                <!-- Oportunidades del Prospecto -->
                <div class="card border-0 shadow-sm mb-4" data-aos="fade-in">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h6 class="mb-0"><i class="bi bi-graph-up-arrow me-2"></i>Oportunidades</h6>
                        @if($prospecto->estado === 'calificado' && !$prospecto->es_cliente)
                            <a href="{{ route('admin.crm.oportunidades.create', $oportunidadParams) }}" class="btn btn-sm btn-success">
                                <i class="bi bi-plus-circle me-1"></i>Nueva
                            </a>
                        @endif
                    </div>
                    <div class="card-body">
                        @forelse($prospecto->oportunidades ?? [] as $oportunidad)
                            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                                <div>
                                    @php
                                        $etapaColors = [
                                            'calificacion' => 'primary', 'evaluacion' => 'info', 'propuesta_tecnica' => 'warning',
                                            'negociacion' => 'secondary', 'ganada' => 'success', 'perdida' => 'danger'
                                        ];
                                    @endphp
                                    <span class="badge bg-secondary me-1">{{ $oportunidad->codigo }}</span>
                                    <strong class="small">{{ Str::limit($oportunidad->nombre, 30) }}</strong>
                                    <span class="badge bg-{{ $etapaColors[$oportunidad->etapa] ?? 'secondary' }} ms-1">{{ ucfirst(str_replace('_', ' ', $oportunidad->etapa)) }}</span>
                                </div>
                                <div class="text-end">
                                    <span class="fw-bold text-primary small">S/ {{ number_format($oportunidad->monto_estimado, 0) }}</span>
                                    <a href="{{ route('admin.crm.oportunidades.show', $oportunidad) }}" class="btn btn-sm btn-outline-primary ms-1"><i class="bi bi-eye"></i></a>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted text-center py-3"><i class="bi bi-inbox fs-3 d-block mb-2"></i>No hay oportunidades registradas</p>
                        @endforelse
                    </div>
                </div>

                <!-- Productos de Interés - Wishlist E-commerce -->
                @if(isset($wishlistItems) && $wishlistItems->count() > 0)
                    <div class="card border-0 shadow-sm mb-4" data-aos="fade-in">
                        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                            <h6 class="mb-0"><i class="bi bi-heart text-danger me-2"></i>Productos de Interés (E-commerce)</h6>
                            <span class="badge bg-danger">{{ $wishlistItems->count() }} productos</span>
                        </div>
                        <div class="card-body">
                            <div class="card border-0 rounded-0 border-start border-3 border-warning mb-3" style="box-shadow: rgba(17, 17, 26, 0.1) 0px 1px 0px; background-color: #fff8e1">
                                <div class="card-body py-2">
                                    <i class="bi bi-lightbulb text-warning me-2"></i>
                                    <small class="text-muted">Estos son los productos que el prospecto agregó a favoritos en la tienda online. Use esta información para personalizar su propuesta.</small>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Producto</th>
                                            <th class="text-end">Precio</th>
                                            <th class="text-center">Fecha</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($wishlistItems as $item)
                                            <tr>
                                                <td><i class="bi bi-box-seam text-primary me-1"></i>{{ $item->nombre }}</td>
                                                <td class="text-end fw-bold">
                                                    @if($item->precio_descuento && $item->precio_descuento < $item->precio)
                                                        <span class="text-decoration-line-through text-muted small me-1">S/ {{ number_format($item->precio, 2) }}</span>
                                                        <span class="text-danger">S/ {{ number_format($item->precio_descuento, 2) }}</span>
                                                    @else
                                                        <span class="text-primary">S/ {{ number_format($item->precio, 2) }}</span>
                                                    @endif
                                                </td>
                                                <td class="text-center"><small class="text-muted">{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</small></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="bg-light">
                                        <tr>
                                            <td class="fw-bold">Valor total estimado</td>
                                            <td class="text-end fw-bold text-primary">
                                                S/ {{ number_format($wishlistItems->sum(fn($i) => $i->precio_descuento && $i->precio_descuento < $i->precio ? $i->precio_descuento : $i->precio), 2) }}
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                @elseif($prospecto->registered_user_id)
                    <div class="card border-0 shadow-sm mb-4" data-aos="fade-in">
                        <div class="card-header bg-transparent">
                            <h6 class="mb-0"><i class="bi bi-heart text-danger me-2"></i>Productos de Interés (E-commerce)</h6>
                        </div>
                        <div class="card-body text-center text-muted py-3">
                            <i class="bi bi-heart fs-3 d-block mb-2"></i>
                            El cliente tiene cuenta en la tienda pero aún no ha agregado productos a favoritos.
                        </div>
                    </div>
                @endif

                <!-- Actividades -->
                <div class="card border-0 shadow-sm" data-aos="fade-in">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h6 class="mb-0"><i class="bi bi-clock-history me-2"></i>Historial de Actividades</h6>
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalActividad">
                            <i class="bi bi-plus me-1"></i>Nueva Actividad
                        </button>
                    </div>
                    <div class="card-body">
                        @forelse($prospecto->actividades ?? [] as $actividad)
                            <div class="timeline-item">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <span class="badge bg-{{ $actividad->tipo == 'llamada' ? 'primary' : ($actividad->tipo == 'reunion' ? 'success' : 'info') }} me-2">
                                            {{ ucfirst($actividad->tipo) }}
                                        </span>
                                        <strong>{{ $actividad->titulo }}</strong>
                                    </div>
                                    <small class="text-muted">{{ $actividad->fecha_programada->format('d/m/Y H:i') }}</small>
                                </div>
                                @if($actividad->descripcion)
                                    <p class="text-muted small mb-0 mt-1">{{ $actividad->descripcion }}</p>
                                @endif
                            </div>
                        @empty
                            <p class="text-muted text-center py-3">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                No hay actividades registradas
                            </p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Columna Lateral -->
            <div class="col-lg-4">
                <!-- Cambiar Estado -->
                <div class="card border-0 shadow-sm mb-4" data-aos="fade-in">
                    <div class="card-header bg-transparent">
                        <h6 class="mb-0"><i class="bi bi-arrow-repeat me-2"></i>Cambiar Estado</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.crm.prospectos.actualizar-estado', $prospecto) }}" method="POST" id="form-actualizar-estado">
                            @csrf
                            @method('PATCH')
                            <select name="estado" id="select-estado-prospecto" class="form-select form-select-sm select2_bootstrap w-100 mb-2" data-placeholder="Seleccionar estado...">
                                @foreach(['nuevo' => 'Nuevo', 'contactado' => 'Contactado', 'calificado' => 'Calificado', 'descartado' => 'Descartado'] as $key => $label)
                                    <option value="{{ $key }}" {{ $prospecto->estado == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            <div id="motivo_descarte_show" style="{{ $prospecto->estado == 'descartado' ? '' : 'display:none' }}">
                                <input type="text" name="motivo_descarte" class="form-control form-control-sm mb-2" placeholder="Motivo de descarte..." value="{{ $prospecto->motivo_descarte }}">
                            </div>
                            <hr class="my-2">
                            <button type="button" class="btn btn-sm btn-primary w-100 btn-actualizar-estado">
                                <i class="bi bi-check-circle me-1"></i>Actualizar Estado
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Clasificación -->
                <div class="card border-0 shadow-sm mb-4" data-aos="fade-in">
                    <div class="card-header bg-transparent">
                        <h6 class="mb-0"><i class="bi bi-tags me-2"></i>Clasificación</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted">Tipo</small>
                            <p class="mb-0 fw-bold">{{ $prospecto->tipo_persona == 'natural' ? 'Persona Natural' : 'Empresa' }}</p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Segmento</small>
                            <p class="mb-0">
                                @php
                                    $segmentoColors = ['residencial' => 'info', 'comercial' => 'warning', 'industrial' => 'primary', 'agricola' => 'success'];
                                @endphp
                                <span class="badge bg-{{ $segmentoColors[$prospecto->segmento] ?? 'secondary' }}">
                                    {{ ucfirst($prospecto->segmento) }}
                                </span>
                            </p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Tipo de Interés</small>
                            <p class="mb-0 fw-bold">{{ ucfirst($prospecto->tipo_interes) }}</p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Origen</small>
                            <p class="mb-0">
                                @php
                                    $origenIcons = ['sitio_web' => 'globe', 'redes_sociales' => 'share', 'llamada' => 'telephone', 'referido' => 'people', 'ecommerce' => 'cart3', 'otro' => 'tag'];
                                @endphp
                                <i class="bi bi-{{ $origenIcons[$prospecto->origen] ?? 'tag' }} me-1"></i>
                                {{ ucfirst(str_replace('_', ' ', $prospecto->origen)) }}
                            </p>
                        </div>
                        @if($prospecto->nivel_interes)
                        <div class="mb-3">
                            <small class="text-muted">Nivel de Interés</small>
                            <p class="mb-0 fw-bold">{{ ucfirst(str_replace('_', ' ', $prospecto->nivel_interes)) }}</p>
                        </div>
                        @endif
                        @if($prospecto->urgencia)
                        <div class="mb-3">
                            <small class="text-muted">Urgencia</small>
                            <p class="mb-0">{{ ucfirst(str_replace('_', ' ', $prospecto->urgencia)) }}</p>
                        </div>
                        @endif
                        <div>
                            <small class="text-muted">Asignado a</small>
                            <p class="mb-0 fw-bold">{{ $prospecto->vendedor?->persona?->name ?? 'Sin asignar' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Acciones Rápidas -->
                <div class="card border-0 shadow-sm mb-4" data-aos="fade-in">
                    <div class="card-header bg-transparent">
                        <h6 class="mb-0"><i class="bi bi-lightning me-2"></i>Acciones Rápidas</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            @if($prospecto->email)
                            <a href="mailto:{{ $prospecto->email }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-envelope me-2"></i>Enviar Email
                            </a>
                            @endif
                            @if($prospecto->celular)
                            <a href="https://wa.me/51{{ preg_replace('/[^0-9]/', '', $prospecto->celular) }}" target="_blank" class="btn btn-outline-success btn-sm">
                                <i class="bi bi-whatsapp me-2"></i>WhatsApp
                            </a>
                            @endif
                            @if($prospecto->telefono || $prospecto->celular)
                            <a href="tel:{{ $prospecto->celular ?? $prospecto->telefono }}" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-telephone me-2"></i>Llamar
                            </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Fechas -->
                <div class="card border-0 shadow-sm" data-aos="fade-in">
                    <div class="card-header bg-transparent">
                        <h6 class="mb-0"><i class="bi bi-calendar me-2"></i>Fechas</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <small class="text-muted">Creado</small>
                            <p class="mb-0">{{ $prospecto->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Última actualización</small>
                            <p class="mb-0">{{ $prospecto->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                        @if($prospecto->fecha_primer_contacto)
                        <div class="mb-2">
                            <small class="text-muted">Primer contacto</small>
                            <p class="mb-0">{{ $prospecto->fecha_primer_contacto->format('d/m/Y') }}</p>
                        </div>
                        @endif
                        @if($prospecto->fecha_proximo_contacto)
                        <div>
                            <small class="text-muted">Próximo contacto</small>
                            <p class="mb-0 {{ $prospecto->fecha_proximo_contacto->isPast() ? 'text-danger fw-bold' : '' }}">
                                {{ $prospecto->fecha_proximo_contacto->format('d/m/Y') }}
                                @if($prospecto->fecha_proximo_contacto->isPast())
                                    <i class="bi bi-exclamation-triangle ms-1"></i>
                                @endif
                            </p>
                        </div>
                        @endif
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
                <form action="{{ route('admin.crm.prospectos.actividad', $prospecto) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        {{-- Info de entidad --}}
                        <div class="card border-0 rounded-0 border-start border-3 border-info mb-3" style="box-shadow: rgba(17, 17, 26, 0.1) 0px 1px 0px; background-color: #f6f6f6">
                            <div class="card-body py-2">
                                <i class="bi bi-link-45deg text-info me-2"></i>
                                <small class="text-muted">
                                    Actividad vinculada a <strong>Prospecto</strong>:
                                    <span class="badge bg-secondary">{{ $prospecto->codigo }}</span>
                                    {{ $prospecto->nombre_completo }}
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

    // ==================== TOGGLE MOTIVO DESCARTE ====================
    $('#select-estado-prospecto').on('change', function() {
        $('#motivo_descarte_show').toggle($(this).val() === 'descartado');
    }).trigger('change');

    // ==================== SELECT2 EN MODAL ====================
    $('#modalActividad').on('shown.bs.modal', function() {
        $('.select2-modal').select2({
            theme: "bootstrap-5",
            width: '100%',
            dropdownParent: $('#modalActividad')
        });
    });

    // ==================== ACTUALIZAR ESTADO ====================
    var estadoTextos = {
        'nuevo': { icon: 'info', color: '#6c757d', label: 'Nuevo' },
        'contactado': { icon: 'info', color: '#0d6efd', label: 'Contactado' },
        'calificado': { icon: 'success', color: '#198754', label: 'Calificado' },
        'descartado': { icon: 'error', color: '#dc3545', label: 'Descartado' }
    };

    $('.btn-actualizar-estado').on('click', function() {
        var estadoSeleccionado = $('#select-estado-prospecto').val();
        var info = estadoTextos[estadoSeleccionado] || { icon: 'question', color: '#0d6efd', label: estadoSeleccionado };
        var textoExtra = estadoSeleccionado === 'descartado' ? '<br><br><small class="text-danger">El prospecto quedará marcado como descartado.</small>' : '';

        Swal.fire({
            title: '¿Actualizar estado?',
            html: `El prospecto <strong>{{ $prospecto->nombre_completo }}</strong> cambiará a estado <strong>${info.label}</strong>.${textoExtra}`,
            icon: info.icon,
            showCancelButton: true,
            confirmButtonColor: info.color,
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="bi bi-check-circle me-1"></i> Sí, actualizar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form-actualizar-estado').submit();
            }
        });
    });

});
</script>
@endsection
