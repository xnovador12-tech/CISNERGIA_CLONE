@extends('TEMPLATES.administrador')
@section('title', 'Nueva Garantía')

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">NUEVA GARANTÍA</h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin.crm.garantias.index') }}">Garantías</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Nueva</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up">
            <div class="card-body p-4">
                <form action="{{ route('admin.crm.garantias.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    {{-- Sección: Cliente --}}
                    <h5 class="fw-bold mb-3"><i class="bi bi-person me-2"></i>Información del Cliente</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="cliente_id" class="form-label fw-bold">Cliente <span class="text-danger">*</span></label>
                            <select name="cliente_id" id="cliente_id" class="form-select @error('cliente_id') is-invalid @enderror" required>
                                <option value="">Seleccionar cliente...</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}" {{ old('cliente_id', $clienteId ?? '') == $cliente->id ? 'selected' : '' }}>
                                        {{ $cliente->nombre ?? $cliente->razon_social }} - {{ $cliente->codigo }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cliente_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr>

                    {{-- Sección: Producto --}}
                    <h5 class="fw-bold mb-3"><i class="bi bi-box me-2"></i>Información del Producto/Equipo</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label for="tipo" class="form-label fw-bold">Tipo de Producto <span class="text-danger">*</span></label>
                            <select name="tipo" id="tipo" class="form-select @error('tipo') is-invalid @enderror" required>
                                <option value="">Seleccionar...</option>
                                <option value="paneles" {{ old('tipo') == 'paneles' ? 'selected' : '' }}>☀️ Paneles Solares</option>
                                <option value="inversor" {{ old('tipo') == 'inversor' ? 'selected' : '' }}>⚡ Inversor</option>
                                <option value="baterias" {{ old('tipo') == 'baterias' ? 'selected' : '' }}>🔋 Baterías</option>
                                <option value="estructura" {{ old('tipo') == 'estructura' ? 'selected' : '' }}>🏗️ Estructura</option>
                                <option value="instalacion" {{ old('tipo') == 'instalacion' ? 'selected' : '' }}>🔧 Instalación</option>
                                <option value="sistema_completo" {{ old('tipo') == 'sistema_completo' ? 'selected' : '' }}>📦 Sistema Completo</option>
                            </select>
                            @error('tipo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="marca" class="form-label fw-bold">Marca</label>
                            <input type="text" name="marca" id="marca" class="form-control @error('marca') is-invalid @enderror" 
                                   value="{{ old('marca') }}" placeholder="Ej: JA Solar">
                            @error('marca')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="modelo" class="form-label fw-bold">Modelo</label>
                            <input type="text" name="modelo" id="modelo" class="form-control @error('modelo') is-invalid @enderror" 
                                   value="{{ old('modelo') }}" placeholder="Ej: JAM72S30-550/MR">
                            @error('modelo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="numero_serie" class="form-label fw-bold">Número de Serie</label>
                            <input type="text" name="numero_serie" id="numero_serie" class="form-control @error('numero_serie') is-invalid @enderror" 
                                   value="{{ old('numero_serie') }}" placeholder="Ej: SN2024123456">
                            @error('numero_serie')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="cantidad" class="form-label fw-bold">Cantidad</label>
                            <input type="number" name="cantidad" id="cantidad" class="form-control @error('cantidad') is-invalid @enderror" 
                                   value="{{ old('cantidad', 1) }}" min="1">
                            @error('cantidad')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr>

                    {{-- Sección: Fechas y Garantía --}}
                    <h5 class="fw-bold mb-3"><i class="bi bi-calendar me-2"></i>Fechas y Cobertura</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <label for="fecha_compra" class="form-label fw-bold">Fecha de Compra <span class="text-danger">*</span></label>
                            <input type="date" name="fecha_compra" id="fecha_compra" class="form-control @error('fecha_compra') is-invalid @enderror" 
                                   value="{{ old('fecha_compra') }}" required>
                            @error('fecha_compra')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="fecha_instalacion" class="form-label fw-bold">Fecha de Instalación</label>
                            <input type="date" name="fecha_instalacion" id="fecha_instalacion" class="form-control @error('fecha_instalacion') is-invalid @enderror" 
                                   value="{{ old('fecha_instalacion') }}">
                            @error('fecha_instalacion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="anos_garantia" class="form-label fw-bold">Años de Garantía <span class="text-danger">*</span></label>
                            <input type="number" name="anos_garantia" id="anos_garantia" class="form-control @error('anos_garantia') is-invalid @enderror" 
                                   value="{{ old('anos_garantia', 5) }}" min="1" max="30" required>
                            @error('anos_garantia')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Cobertura --}}
                    <div class="row g-3 mb-4">
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Cobertura Incluida</label>
                            <div class="d-flex gap-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="cubre_mano_obra" id="cubre_mano_obra" value="1" {{ old('cubre_mano_obra', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cubre_mano_obra">Mano de Obra</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="cubre_repuestos" id="cubre_repuestos" value="1" {{ old('cubre_repuestos', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cubre_repuestos">Repuestos</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="cubre_transporte" id="cubre_transporte" value="1" {{ old('cubre_transporte') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cubre_transporte">Transporte</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="condiciones" class="form-label fw-bold">Condiciones</label>
                            <textarea name="condiciones" id="condiciones" class="form-control @error('condiciones') is-invalid @enderror" 
                                      rows="2" placeholder="Condiciones de la garantía...">{{ old('condiciones') }}</textarea>
                            @error('condiciones')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="exclusiones" class="form-label fw-bold">Exclusiones</label>
                            <textarea name="exclusiones" id="exclusiones" class="form-control @error('exclusiones') is-invalid @enderror" 
                                      rows="2" placeholder="Exclusiones de la garantía...">{{ old('exclusiones') }}</textarea>
                            @error('exclusiones')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr>

                    {{-- Sección: Documentos --}}
                    <h5 class="fw-bold mb-3"><i class="bi bi-file-earmark me-2"></i>Documentos y Notas</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label for="certificado_garantia" class="form-label fw-bold">Certificado de Garantía (PDF)</label>
                            <input type="file" name="certificado_garantia" id="certificado_garantia" class="form-control @error('certificado_garantia') is-invalid @enderror" accept=".pdf">
                            @error('certificado_garantia')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-8">
                            <label for="observaciones" class="form-label fw-bold">Observaciones</label>
                            <textarea name="observaciones" id="observaciones" class="form-control @error('observaciones') is-invalid @enderror" 
                                      rows="2" placeholder="Notas adicionales...">{{ old('observaciones') }}</textarea>
                            @error('observaciones')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.crm.garantias.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-shield-check me-2"></i>Registrar Garantía
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
    $('#cliente_id').select2({
        theme: 'bootstrap-5',
        placeholder: 'Buscar cliente...',
        allowClear: true
    });
});
</script>
@endsection
