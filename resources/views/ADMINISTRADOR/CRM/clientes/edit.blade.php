@extends('TEMPLATES.administrador')
@section('title', 'Editar Cliente')

@section('content')
    <!-- Encabezado -->
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">EDITAR CLIENTE</h1>
                <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin.crm.clientes.index') }}">Clientes</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Editar</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.crm.clientes.update', $cliente) }}" method="POST" class="needs-validation" novalidate>
        @csrf
        @method('PUT')
        <div class="container-fluid">
            <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up">
                <div class="card-body">

                    {{-- Info --}}
                    <div class="card border-0 rounded-0 border-start border-3 border-info mb-4" style="box-shadow: rgba(17, 17, 26, 0.1) 0px 1px 0px; background-color: #f6f6f6">
                        <div class="card-body py-2">
                            <i class="bi bi-info-circle text-info me-2"></i>
                            <small class="text-muted">
                                Editando cliente <span class="badge bg-secondary">{{ $cliente->codigo }}</span>
                                — Origen: <span class="badge bg-{{ $cliente->origen === 'ecommerce' ? 'info' : 'primary' }}">{{ $cliente->origen === 'ecommerce' ? 'E-commerce' : 'Directo' }}</span>
                                — Los campos con <span class="text-danger">*</span> son obligatorios.
                            </small>
                        </div>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                        </div>
                    @endif

                    <div class="row g-3">
                        {{-- ===================== DATOS PERSONALES ===================== --}}
                        <div class="col-12">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Datos Personales</p>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Tipo de Persona <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="tipo_persona" id="tipo_persona" required data-placeholder="Seleccionar...">
                                <option value="natural" {{ old('tipo_persona', $cliente->tipo_persona) == 'natural' ? 'selected' : '' }}>Natural</option>
                                <option value="juridica" {{ old('tipo_persona', $cliente->tipo_persona) == 'juridica' ? 'selected' : '' }}>Jurídica</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre', $cliente->nombre) }}" required>
                            @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Apellidos</label>
                            <input type="text" class="form-control form-control-sm" name="apellidos" value="{{ old('apellidos', $cliente->apellidos) }}">
                        </div>

                        <div class="col-md-3" id="campo-dni">
                            <label class="form-label">DNI</label>
                            <input type="text" class="form-control form-control-sm" name="dni" value="{{ old('dni', $cliente->dni) }}" maxlength="8">
                        </div>

                        <div class="col-md-6" id="campo-razon-social" style="display: none;">
                            <label class="form-label">Razón Social</label>
                            <input type="text" class="form-control form-control-sm" name="razon_social" value="{{ old('razon_social', $cliente->razon_social) }}">
                        </div>

                        <div class="col-md-3" id="campo-ruc" style="display: none;">
                            <label class="form-label">RUC</label>
                            <input type="text" class="form-control form-control-sm" name="ruc" value="{{ old('ruc', $cliente->ruc) }}" maxlength="11">
                        </div>

                        {{-- ===================== CONTACTO ===================== --}}
                        <div class="col-12 mt-3">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Contacto</p>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror" name="email" value="{{ old('email', $cliente->email) }}">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Celular</label>
                            <input type="text" class="form-control form-control-sm" name="celular" value="{{ old('celular', $cliente->celular) }}" maxlength="20">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Teléfono</label>
                            <input type="text" class="form-control form-control-sm" name="telefono" value="{{ old('telefono', $cliente->telefono) }}" maxlength="20">
                        </div>

                        {{-- ===================== UBICACIÓN ===================== --}}
                        <div class="col-12 mt-3">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Ubicación</p>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label">Dirección</label>
                            <input type="text" class="form-control form-control-sm" name="direccion" value="{{ old('direccion', $cliente->direccion) }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Distrito</label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="distrito_id" data-placeholder="Seleccionar distrito...">
                                <option value="">Seleccionar distrito...</option>
                                @foreach($distritos as $distrito)
                                    <option value="{{ $distrito->id }}" {{ old('distrito_id', $cliente->distrito_id) == $distrito->id ? 'selected' : '' }}>
                                        {{ $distrito->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- ===================== CLASIFICACIÓN ===================== --}}
                        <div class="col-12 mt-3">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Clasificación</p>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Segmento <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="segmento" required data-placeholder="Seleccionar...">
                                <option value="residencial" {{ old('segmento', $cliente->segmento) == 'residencial' ? 'selected' : '' }}>Residencial</option>
                                <option value="comercial" {{ old('segmento', $cliente->segmento) == 'comercial' ? 'selected' : '' }}>Comercial</option>
                                <option value="industrial" {{ old('segmento', $cliente->segmento) == 'industrial' ? 'selected' : '' }}>Industrial</option>
                                <option value="agricola" {{ old('segmento', $cliente->segmento) == 'agricola' ? 'selected' : '' }}>Agrícola</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Estado <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="estado" required data-placeholder="Seleccionar...">
                                <option value="activo" {{ old('estado', $cliente->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                                <option value="inactivo" {{ old('estado', $cliente->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                <option value="suspendido" {{ old('estado', $cliente->estado) == 'suspendido' ? 'selected' : '' }}>Suspendido</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Vendedor Asignado</label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="vendedor_id" data-placeholder="Sin asignar">
                                <option value="">Sin asignar</option>
                                @foreach($vendedores as $vendedor)
                                    <option value="{{ $vendedor->id }}" {{ old('vendedor_id', $cliente->vendedor_id) == $vendedor->id ? 'selected' : '' }}>
                                        {{ $vendedor->persona?->name ?? $vendedor->email }} {{ $vendedor->persona?->surnames ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- ===================== OBSERVACIONES ===================== --}}
                        <div class="col-12 mt-3">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Observaciones</p>
                        </div>

                        <div class="col-12">
                            <textarea class="form-control form-control-sm" name="observaciones" rows="3" placeholder="Notas adicionales sobre el cliente...">{{ old('observaciones', $cliente->observaciones) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Botones --}}
            <div class="pt-3 pb-5 d-flex justify-content-end gap-2">
                <a href="{{ route('admin.crm.clientes.show', $cliente) }}" class="btn btn-outline-secondary px-4">
                    <i class="bi bi-x-circle me-2"></i>Cancelar
                </a>
                <button type="submit" class="btn btn-primary px-5 text-white">
                    <i class="bi bi-save me-2"></i>Guardar Cambios
                </button>
            </div>
        </div>
    </form>
@endsection

@section('js')
<script>
$(document).ready(function() {
    // Toggle campos según tipo de persona
    function toggleTipoPersona() {
        var tipo = $('#tipo_persona').val();
        if (tipo === 'juridica') {
            $('#campo-razon-social, #campo-ruc').show();
            $('#campo-dni').hide();
        } else {
            $('#campo-razon-social, #campo-ruc').hide();
            $('#campo-dni').show();
        }
    }

    $('#tipo_persona').on('change', toggleTipoPersona);
    toggleTipoPersona(); // Ejecutar al cargar
});
</script>
@endsection
