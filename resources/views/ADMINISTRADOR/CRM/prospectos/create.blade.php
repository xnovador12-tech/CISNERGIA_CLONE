@extends('TEMPLATES.administrador')

@section('title', 'Nuevo Prospecto')

@section('content')
    <!-- Encabezado -->
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">NUEVO PROSPECTO</h1>
                <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin.crm.prospectos.index') }}">Prospectos</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Nuevo</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.crm.prospectos.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf
        <div class="container-fluid">
            <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-in">
                <div class="card-body">

                    {{-- Info --}}
                    <div class="card border-0 rounded-0 border-start border-3 border-info mb-4" style="box-shadow: rgba(17, 17, 26, 0.1) 0px 1px 0px; background-color: #f6f6f6">
                        <div class="card-body py-2">
                            <i class="bi bi-info-circle text-info me-2"></i>
                            <small class="text-muted">Los campos con <span class="text-danger">*</span> son obligatorios.</small>
                        </div>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                        </div>
                    @endif

                    <div class="row g-3">
                        {{-- ===================== INFORMACIÓN GENERAL ===================== --}}
                        <div class="col-12">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Información General</p>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Tipo de Persona <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="tipo_persona" id="tipo_persona" required data-placeholder="Seleccionar...">
                                <option value="natural" {{ old('tipo_persona') == 'natural' ? 'selected' : '' }}>Persona Natural</option>
                                <option value="juridica" {{ old('tipo_persona') == 'juridica' ? 'selected' : '' }}>Persona Jurídica</option>
                            </select>
                        </div>

                        <div class="col-md-2" id="campo_dni">
                            <label class="form-label">DNI</label>
                            <input type="text" class="form-control form-control-sm" name="dni" maxlength="8" value="{{ old('dni') }}" placeholder="12345678">
                        </div>

                        <div class="col-md-2" id="campo_ruc">
                            <label class="form-label">RUC</label>
                            <input type="text" class="form-control form-control-sm" name="ruc" maxlength="11" value="{{ old('ruc') }}" placeholder="20123456789">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" required placeholder="Nombre o razón comercial">
                            @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4" id="campo_apellidos">
                            <label class="form-label">Apellidos</label>
                            <input type="text" class="form-control form-control-sm" name="apellidos" value="{{ old('apellidos') }}" placeholder="Apellido paterno y materno">
                        </div>

                        <div class="col-md-6" id="campo_razon_social">
                            <label class="form-label">Razón Social</label>
                            <input type="text" class="form-control form-control-sm" name="razon_social" value="{{ old('razon_social') }}" placeholder="Razón social de la empresa">
                        </div>

                        {{-- ===================== DATOS DE CONTACTO ===================== --}}
                        <div class="col-12 mt-3">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Datos de Contacto</p>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control form-control-sm" name="email" value="{{ old('email') }}" placeholder="correo@ejemplo.com">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Celular</label>
                            <input type="tel" class="form-control form-control-sm" name="celular" value="{{ old('celular') }}" placeholder="987654321">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Teléfono</label>
                            <input type="tel" class="form-control form-control-sm" name="telefono" value="{{ old('telefono') }}" placeholder="01-1234567">
                        </div>

                        <div class="col-md-5">
                            <label class="form-label">Dirección</label>
                            <input type="text" class="form-control form-control-sm" name="direccion" value="{{ old('direccion') }}" placeholder="Av. Principal 123">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Distrito</label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="distrito_id" data-placeholder="Seleccionar...">
                                <option value="">Seleccionar...</option>
                                @foreach($distritos ?? [] as $distrito)
                                    <option value="{{ $distrito->id }}" {{ old('distrito_id') == $distrito->id ? 'selected' : '' }}>{{ $distrito->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- ===================== CLASIFICACIÓN ===================== --}}
                        <div class="col-12 mt-3">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Clasificación</p>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Origen <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="origen" required data-placeholder="Seleccionar...">
                                <option value="">Seleccionar...</option>
                                @foreach(['sitio_web' => 'Sitio Web', 'redes_sociales' => 'Redes Sociales', 'llamada' => 'Llamada', 'referido' => 'Referido', 'ecommerce' => 'E-commerce', 'otro' => 'Otro'] as $key => $label)
                                    <option value="{{ $key }}" {{ old('origen') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Tipo de Interés <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="tipo_interes" required data-placeholder="Seleccionar...">
                                <option value="producto" {{ old('tipo_interes', 'producto') == 'producto' ? 'selected' : '' }}>Producto</option>
                                <option value="servicio" {{ old('tipo_interes') == 'servicio' ? 'selected' : '' }}>Servicio</option>
                                <option value="ambos" {{ old('tipo_interes') == 'ambos' ? 'selected' : '' }}>Ambos</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Segmento <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="segmento" required data-placeholder="Seleccionar...">
                                <option value="">Seleccionar...</option>
                                @foreach(['residencial' => 'Residencial', 'comercial' => 'Comercial', 'industrial' => 'Industrial', 'agricola' => 'Agrícola'] as $key => $label)
                                    <option value="{{ $key }}" {{ old('segmento') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Asignar a</label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="user_id" data-placeholder="Seleccionar vendedor...">
                                @foreach($vendedores ?? [] as $vendedor)
                                    <option value="{{ $vendedor->id }}" {{ old('user_id', auth()->id()) == $vendedor->id ? 'selected' : '' }}>
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
                            <textarea class="form-control form-control-sm" name="observaciones" rows="3" placeholder="Notas adicionales sobre el prospecto...">{{ old('observaciones') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Botones --}}
            <div class="pt-3 pb-5 d-flex justify-content-end gap-2">
                <a href="{{ route('admin.crm.prospectos.index') }}" class="btn btn-outline-secondary px-4">
                    <i class="bi bi-x-circle me-2"></i>Cancelar
                </a>
                <button type="submit" class="btn btn-primary px-5 text-white">
                    <i class="bi bi-save me-2"></i>Registrar Prospecto
                </button>
            </div>
        </div>
    </form>
@endsection

@section('js')
<script>
$(document).ready(function() {
    // Toggle Persona Natural / Jurídica (jQuery para compatibilidad con Select2)
    $('#tipo_persona').on('change', function() {
        var esJuridica = $(this).val() === 'juridica';
        $('#campo_apellidos').toggle(!esJuridica);
        $('#campo_razon_social').toggle(esJuridica);
        $('#campo_dni').toggle(!esJuridica);
        $('#campo_ruc').toggle(esJuridica);
    }).trigger('change');
});
</script>
@endsection
