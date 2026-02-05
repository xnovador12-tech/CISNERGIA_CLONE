@extends('TEMPLATES.administrador')
@section('title', 'Garantía ' . $garantia->codigo)

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">GARANTÍA {{ $garantia->codigo }}</h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin.crm.garantias.index') }}">Garantías</a></li>
                        <li class="breadcrumb-item link" aria-current="page">{{ $garantia->codigo }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="container-fluid mb-3">
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <div class="container-fluid">
        <div class="row g-4">
            {{-- Columna Principal --}}
            <div class="col-lg-8">
                {{-- Estado y Vigencia --}}
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-shield-check me-2"></i>Estado de la Garantía
                        </h5>
                        @php
                            $estadoColors = ['activa' => 'success', 'vigente' => 'success', 'vencida' => 'danger', 'en_reclamo' => 'warning', 'anulada' => 'secondary'];
                        @endphp
                        <span class="badge bg-{{ $estadoColors[$garantia->estado] ?? 'secondary' }} fs-6">
                            {{ ucfirst(str_replace('_', ' ', $garantia->estado)) }}
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 text-center">
                            <div class="col-md-4">
                                <div class="bg-light p-3 rounded">
                                    <p class="text-muted mb-1 small">Fecha Inicio</p>
                                    <h5 class="mb-0 fw-bold">{{ $garantia->fecha_inicio?->format('d/m/Y') ?? 'N/A' }}</h5>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="bg-light p-3 rounded">
                                    <p class="text-muted mb-1 small">Fecha Vencimiento</p>
                                    <h5 class="mb-0 fw-bold {{ $diasRestantes < 30 ? 'text-warning' : '' }} {{ $diasRestantes < 0 ? 'text-danger' : '' }}">
                                        {{ $garantia->fecha_fin?->format('d/m/Y') ?? 'N/A' }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="bg-{{ $diasRestantes < 0 ? 'danger' : ($diasRestantes < 30 ? 'warning' : 'success') }} bg-opacity-10 p-3 rounded">
                                    <p class="text-muted mb-1 small">Días Restantes</p>
                                    <h5 class="mb-0 fw-bold text-{{ $diasRestantes < 0 ? 'danger' : ($diasRestantes < 30 ? 'warning' : 'success') }}">
                                        {{ $diasRestantes < 0 ? 'Vencida' : $diasRestantes . ' días' }}
                                    </h5>
                                </div>
                            </div>
                        </div>

                        @if($diasRestantes > 0)
                            <div class="mt-3">
                                <div class="d-flex justify-content-between small text-muted mb-1">
                                    <span>Progreso de la garantía</span>
                                    <span>{{ min(100, max(0, $porcentajeUsado)) }}% transcurrido</span>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar bg-{{ $porcentajeUsado > 80 ? 'danger' : ($porcentajeUsado > 50 ? 'warning' : 'success') }}" 
                                         style="width: {{ min(100, max(0, $porcentajeUsado)) }}%"></div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Información del Producto --}}
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px" data-aos="fade-up">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-box me-2"></i>Información del Producto</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <p class="text-muted mb-1 small">Tipo de Producto</p>
                                <p class="mb-0 fw-bold">{{ ucfirst(str_replace('_', ' ', $garantia->tipo)) }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted mb-1 small">Cantidad</p>
                                <p class="mb-0 fw-bold">{{ $garantia->cantidad ?? 1 }} unidad(es)</p>
                            </div>
                            <div class="col-md-4">
                                <p class="text-muted mb-1 small">Marca</p>
                                <p class="mb-0">{{ $garantia->marca ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-4">
                                <p class="text-muted mb-1 small">Modelo</p>
                                <p class="mb-0">{{ $garantia->modelo ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-4">
                                <p class="text-muted mb-1 small">Número de Serie</p>
                                <p class="mb-0"><code>{{ $garantia->numero_serie ?? 'N/A' }}</code></p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Historial de Usos/Reclamos --}}
                <div class="card border-0 shadow-sm" style="border-radius: 15px" data-aos="fade-up">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-clock-history me-2"></i>Historial de Uso de Garantía</h5>
                        @if($garantia->estado !== 'vencida' && $garantia->estado !== 'anulada')
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalRegistrarUso">
                                <i class="bi bi-plus-circle me-1"></i>Registrar Uso
                            </button>
                        @endif
                    </div>
                    <div class="card-body">
                        @if($garantia->usos && $garantia->usos->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Motivo</th>
                                            <th>Descripción</th>
                                            <th>Registrado por</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($garantia->usos as $uso)
                                            <tr>
                                                <td>{{ $uso->fecha_uso?->format('d/m/Y') ?? $uso->created_at->format('d/m/Y') }}</td>
                                                <td>{{ ucfirst($uso->motivo) }}</td>
                                                <td>{{ Str::limit($uso->descripcion_problema, 50) }}</td>
                                                <td>{{ $uso->usuario?->persona?->name ?? $uso->usuario?->name ?? 'N/A' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No hay registros de uso de garantía
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Columna Lateral --}}
            <div class="col-lg-4">
                {{-- Acciones --}}
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px" data-aos="fade-left">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3"><i class="bi bi-gear me-2"></i>Acciones</h6>
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.crm.garantias.edit', $garantia) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-pencil me-2"></i>Editar Garantía
                            </a>
                            
                            @if($garantia->estado === 'vigente')
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalExtender">
                                    <i class="bi bi-plus-circle me-2"></i>Extender Garantía
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Cliente --}}
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px" data-aos="fade-left">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3"><i class="bi bi-person me-2"></i>Cliente</h6>
                        <p class="mb-1"><strong>{{ $garantia->cliente->nombre ?? $garantia->cliente->razon_social ?? 'N/A' }}</strong></p>
                        <p class="text-muted small mb-1">{{ $garantia->cliente->codigo ?? '' }}</p>
                        @if($garantia->cliente->email)
                            <p class="mb-1"><i class="bi bi-envelope me-2"></i>{{ $garantia->cliente->email }}</p>
                        @endif
                        @if($garantia->cliente->telefono)
                            <p class="mb-0"><i class="bi bi-telephone me-2"></i>{{ $garantia->cliente->telefono }}</p>
                        @endif
                    </div>
                </div>

                {{-- Cobertura --}}
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px" data-aos="fade-left">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3"><i class="bi bi-shield me-2"></i>Cobertura</h6>
                        <p class="mb-2">
                            <strong>Años de Garantía:</strong><br>
                            {{ $garantia->anos_garantia ?? 'N/A' }} años
                        </p>
                        <div class="mb-2">
                            <strong>Incluye:</strong>
                            <ul class="mb-0 ps-3">
                                @if($garantia->cubre_mano_obra)
                                    <li class="text-success"><i class="bi bi-check me-1"></i>Mano de obra</li>
                                @endif
                                @if($garantia->cubre_repuestos)
                                    <li class="text-success"><i class="bi bi-check me-1"></i>Repuestos</li>
                                @endif
                                @if($garantia->cubre_transporte)
                                    <li class="text-success"><i class="bi bi-check me-1"></i>Transporte</li>
                                @endif
                            </ul>
                        </div>
                        @if($garantia->condiciones)
                            <p class="mb-2">
                                <strong>Condiciones:</strong><br>
                                <small>{{ $garantia->condiciones }}</small>
                            </p>
                        @endif
                        @if($garantia->exclusiones)
                            <p class="mb-0">
                                <strong>Exclusiones:</strong><br>
                                <small class="text-danger">{{ $garantia->exclusiones }}</small>
                            </p>
                        @endif
                    </div>
                </div>

                {{-- Observaciones --}}
                @if($garantia->observaciones)
                    <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px" data-aos="fade-left">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3"><i class="bi bi-sticky me-2"></i>Observaciones</h6>
                            <p class="mb-0 small">{{ $garantia->observaciones }}</p>
                        </div>
                    </div>
                @endif

                {{-- Documentos --}}
                <div class="card border-0 shadow-sm" style="border-radius: 15px" data-aos="fade-left">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3"><i class="bi bi-file-earmark me-2"></i>Documentos</h6>
                        @if($garantia->certificado_garantia)
                            <a href="{{ Storage::url($garantia->certificado_garantia) }}" target="_blank" class="btn btn-outline-secondary btn-sm w-100">
                                <i class="bi bi-file-pdf me-2"></i>Certificado de Garantía
                            </a>
                        @else
                            <p class="text-muted small mb-0 text-center">No hay documentos adjuntos</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('admin.crm.garantias.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Volver al listado
            </a>
        </div>
    </div>

    {{-- Modal Registrar Uso --}}
    <div class="modal fade" id="modalRegistrarUso" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('admin.crm.garantias.uso', $garantia) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Registrar Uso de Garantía</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="fecha_uso" class="form-label fw-bold">Fecha de Uso <span class="text-danger">*</span></label>
                                <input type="date" name="fecha_uso" id="fecha_uso" class="form-control" 
                                       value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="motivo" class="form-label fw-bold">Motivo <span class="text-danger">*</span></label>
                                <select name="motivo" id="motivo" class="form-select" required>
                                    <option value="">Seleccionar motivo</option>
                                    <option value="defecto_fabrica">Defecto de Fábrica</option>
                                    <option value="falla_funcionamiento">Falla de Funcionamiento</option>
                                    <option value="bajo_rendimiento">Bajo Rendimiento</option>
                                    <option value="reemplazo">Reemplazo</option>
                                    <option value="reparacion">Reparación</option>
                                    <option value="otro">Otro</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="descripcion_problema" class="form-label fw-bold">Descripción del Problema <span class="text-danger">*</span></label>
                                <textarea name="descripcion_problema" id="descripcion_problema" class="form-control" rows="3" 
                                          placeholder="Describa el problema detalladamente..." required></textarea>
                            </div>
                            <div class="col-12">
                                <label for="solucion_aplicada" class="form-label fw-bold">Solución Aplicada</label>
                                <textarea name="solucion_aplicada" id="solucion_aplicada" class="form-control" rows="2" 
                                          placeholder="Describa la solución aplicada (si corresponde)..."></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="tecnico_responsable" class="form-label fw-bold">Técnico Responsable</label>
                                <input type="text" name="tecnico_responsable" id="tecnico_responsable" class="form-control" 
                                       placeholder="Nombre del técnico">
                            </div>
                            <div class="col-md-6">
                                <label for="costo_cubierto" class="form-label fw-bold">Costo Cubierto (S/.)</label>
                                <input type="number" name="costo_cubierto" id="costo_cubierto" class="form-control" 
                                       step="0.01" min="0" value="0" placeholder="0.00">
                            </div>
                            <div class="col-12">
                                <label for="observaciones" class="form-label fw-bold">Observaciones</label>
                                <textarea name="observaciones" id="observaciones" class="form-control" rows="2" 
                                          placeholder="Observaciones adicionales..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Registrar Uso
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Extender Garantía --}}
    <div class="modal fade" id="modalExtender" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.crm.garantias.extender', $garantia) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Extender Garantía</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info mb-3">
                            <small>
                                <strong>Garantía actual:</strong> {{ $garantia->codigo }}<br>
                                <strong>Vence:</strong> {{ $garantia->fecha_fin?->format('d/m/Y') ?? 'N/A' }}
                            </small>
                        </div>
                        <div class="mb-3">
                            <label for="anos_extension" class="form-label fw-bold">Años a Extender <span class="text-danger">*</span></label>
                            <select name="anos_extension" id="anos_extension" class="form-select" required>
                                <option value="">Seleccionar...</option>
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}">{{ $i }} año{{ $i > 1 ? 's' : '' }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="motivo_extension" class="form-label fw-bold">Motivo de Extensión <span class="text-danger">*</span></label>
                            <textarea name="motivo_extension" id="motivo_extension" class="form-control" rows="3" 
                                      placeholder="Describa el motivo de la extensión..." required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="costo_extension" class="form-label fw-bold">Costo de Extensión (S/.)</label>
                            <input type="number" name="costo_extension" id="costo_extension" class="form-control" 
                                   step="0.01" min="0" value="0" placeholder="0.00">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle me-2"></i>Extender Garantía
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
