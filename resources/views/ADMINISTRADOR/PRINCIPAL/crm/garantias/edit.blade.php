@extends('TEMPLATES.administrador')
@section('title', 'Editar Garantía ' . $garantia->codigo)

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">EDITAR GARANTÍA {{ $garantia->codigo }}</h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin.crm.garantias.index') }}">Garantías</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Editar {{ $garantia->codigo }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @if(session('error'))
        <div class="container-fluid mb-3">
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up">
            <div class="card-body p-4">
                <form action="{{ route('admin.crm.garantias.update', $garantia) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    {{-- Sección: Cliente (solo lectura) --}}
                    <h5 class="fw-bold mb-3"><i class="bi bi-person me-2"></i>Información del Cliente</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Cliente</label>
                            <input type="text" class="form-control" value="{{ $garantia->cliente->nombre ?? $garantia->cliente->razon_social ?? 'N/A' }}" readonly disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Código de Garantía</label>
                            <input type="text" class="form-control" value="{{ $garantia->codigo }}" readonly disabled>
                        </div>
                    </div>

                    <hr>

                    {{-- Sección: Producto --}}
                    <h5 class="fw-bold mb-3"><i class="bi bi-box me-2"></i>Información del Producto</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label for="tipo" class="form-label fw-bold">Tipo de Producto <span class="text-danger">*</span></label>
                            <select name="tipo" id="tipo" class="form-select @error('tipo') is-invalid @enderror" required>
                                <option value="paneles" {{ old('tipo', $garantia->tipo) == 'paneles' ? 'selected' : '' }}>☀️ Paneles Solares</option>
                                <option value="inversor" {{ old('tipo', $garantia->tipo) == 'inversor' ? 'selected' : '' }}>⚡ Inversor</option>
                                <option value="baterias" {{ old('tipo', $garantia->tipo) == 'baterias' ? 'selected' : '' }}>🔋 Baterías</option>
                                <option value="estructura" {{ old('tipo', $garantia->tipo) == 'estructura' ? 'selected' : '' }}>🏗️ Estructura</option>
                                <option value="instalacion" {{ old('tipo', $garantia->tipo) == 'instalacion' ? 'selected' : '' }}>🔧 Instalación</option>
                                <option value="sistema_completo" {{ old('tipo', $garantia->tipo) == 'sistema_completo' ? 'selected' : '' }}>🏠 Sistema Completo</option>
                            </select>
                            @error('tipo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="marca" class="form-label fw-bold">Marca</label>
                            <input type="text" name="marca" id="marca" class="form-control @error('marca') is-invalid @enderror" 
                                   value="{{ old('marca', $garantia->marca) }}" placeholder="Ej: Jinko Solar, Huawei">
                            @error('marca')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="modelo" class="form-label fw-bold">Modelo</label>
                            <input type="text" name="modelo" id="modelo" class="form-control @error('modelo') is-invalid @enderror" 
                                   value="{{ old('modelo', $garantia->modelo) }}" placeholder="Ej: JKM545M-72HL4">
                            @error('modelo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="numero_serie" class="form-label fw-bold">Número de Serie</label>
                            <input type="text" name="numero_serie" id="numero_serie" class="form-control @error('numero_serie') is-invalid @enderror" 
                                   value="{{ old('numero_serie', $garantia->numero_serie) }}" placeholder="Ej: SN-2024-12345">
                            @error('numero_serie')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="cantidad" class="form-label fw-bold">Cantidad</label>
                            <input type="number" name="cantidad" id="cantidad" class="form-control @error('cantidad') is-invalid @enderror" 
                                   value="{{ old('cantidad', $garantia->cantidad ?? 1) }}" min="1">
                            @error('cantidad')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr>

                    {{-- Sección: Vigencia --}}
                    <h5 class="fw-bold mb-3"><i class="bi bi-calendar me-2"></i>Vigencia</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Fecha Inicio</label>
                            <input type="date" class="form-control" value="{{ $garantia->fecha_inicio?->format('Y-m-d') }}" readonly disabled>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Fecha Fin</label>
                            <input type="date" class="form-control" value="{{ $garantia->fecha_fin?->format('Y-m-d') }}" readonly disabled>
                        </div>
                        <div class="col-md-4">
                            <label for="anos_garantia" class="form-label fw-bold">Años de Garantía <span class="text-danger">*</span></label>
                            <input type="number" name="anos_garantia" id="anos_garantia" class="form-control @error('anos_garantia') is-invalid @enderror" 
                                   value="{{ old('anos_garantia', $garantia->anos_garantia) }}" min="1" max="30" required>
                            <small class="text-muted">Si cambia los años, se recalculará la fecha de fin</small>
                            @error('anos_garantia')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr>

                    {{-- Sección: Cobertura --}}
                    <h5 class="fw-bold mb-3"><i class="bi bi-shield me-2"></i>Cobertura</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="cubre_mano_obra" id="cubre_mano_obra" value="1"
                                       {{ old('cubre_mano_obra', $garantia->cubre_mano_obra) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="cubre_mano_obra">
                                    <i class="bi bi-tools me-1"></i>Cubre Mano de Obra
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="cubre_repuestos" id="cubre_repuestos" value="1"
                                       {{ old('cubre_repuestos', $garantia->cubre_repuestos) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="cubre_repuestos">
                                    <i class="bi bi-box-seam me-1"></i>Cubre Repuestos
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="cubre_transporte" id="cubre_transporte" value="1"
                                       {{ old('cubre_transporte', $garantia->cubre_transporte) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="cubre_transporte">
                                    <i class="bi bi-truck me-1"></i>Cubre Transporte
                                </label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="condiciones" class="form-label fw-bold">Condiciones de la Garantía</label>
                            <textarea name="condiciones" id="condiciones" class="form-control @error('condiciones') is-invalid @enderror" 
                                      rows="3" placeholder="Describa las condiciones...">{{ old('condiciones', $garantia->condiciones) }}</textarea>
                            @error('condiciones')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="exclusiones" class="form-label fw-bold">Exclusiones</label>
                            <textarea name="exclusiones" id="exclusiones" class="form-control @error('exclusiones') is-invalid @enderror" 
                                      rows="3" placeholder="Qué NO cubre la garantía...">{{ old('exclusiones', $garantia->exclusiones) }}</textarea>
                            @error('exclusiones')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr>

                    {{-- Sección: Estado --}}
                    <h5 class="fw-bold mb-3"><i class="bi bi-flag me-2"></i>Estado</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label for="estado" class="form-label fw-bold">Estado de la Garantía</label>
                            <select name="estado" id="estado" class="form-select @error('estado') is-invalid @enderror">
                                <option value="vigente" {{ old('estado', $garantia->estado) == 'vigente' ? 'selected' : '' }}>✅ Vigente</option>
                                <option value="vencida" {{ old('estado', $garantia->estado) == 'vencida' ? 'selected' : '' }}>⚠️ Vencida</option>
                                <option value="anulada" {{ old('estado', $garantia->estado) == 'anulada' ? 'selected' : '' }}>❌ Anulada</option>
                                <option value="aplicada" {{ old('estado', $garantia->estado) == 'aplicada' ? 'selected' : '' }}>🔧 Aplicada</option>
                            </select>
                            @error('estado')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr>

                    {{-- Sección: Documentos --}}
                    <h5 class="fw-bold mb-3"><i class="bi bi-file-earmark me-2"></i>Documentos</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="certificado_garantia" class="form-label fw-bold">Certificado de Garantía (PDF)</label>
                            @if($garantia->certificado_garantia)
                                <div class="mb-2">
                                    <a href="{{ Storage::url($garantia->certificado_garantia) }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                                        <i class="bi bi-file-pdf me-2"></i>Ver documento actual
                                    </a>
                                </div>
                            @endif
                            <input type="file" name="certificado_garantia" id="certificado_garantia" 
                                   class="form-control @error('certificado_garantia') is-invalid @enderror" accept=".pdf">
                            <small class="text-muted">Suba un nuevo archivo para reemplazar el actual (máx. 5MB)</small>
                            @error('certificado_garantia')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr>

                    {{-- Sección: Observaciones --}}
                    <h5 class="fw-bold mb-3"><i class="bi bi-sticky me-2"></i>Observaciones</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-12">
                            <textarea name="observaciones" id="observaciones" class="form-control @error('observaciones') is-invalid @enderror" 
                                      rows="3" placeholder="Notas adicionales...">{{ old('observaciones', $garantia->observaciones) }}</textarea>
                            @error('observaciones')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.crm.garantias.show', $garantia) }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
