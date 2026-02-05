@extends('TEMPLATES.administrador')
@section('title', 'Nueva Oportunidad')

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">NUEVA OPORTUNIDAD</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin.crm.oportunidades.index') }}">Oportunidades</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Nueva</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up">
            <div class="card-body">
                <form action="{{ route('admin.crm.oportunidades.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                        </div>
                    @endif

                    <div class="row g-3">
                        <div class="col-12"><h6 class="text-primary border-bottom pb-2"><i class="bi bi-info-circle me-2"></i>Información General</h6></div>

                        <div class="col-md-8">
                            <label class="form-label">Nombre de la Oportunidad <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" 
                                   placeholder="Ej: Sistema Solar Residencial 5kW - Juan Pérez" required>
                            @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Tipo de Proyecto <span class="text-danger">*</span></label>
                            <select class="form-select @error('tipo_proyecto') is-invalid @enderror" name="tipo_proyecto" required>
                                <option value="">Seleccionar...</option>
                                <option value="residencial" {{ old('tipo_proyecto') == 'residencial' ? 'selected' : '' }}>Residencial</option>
                                <option value="comercial" {{ old('tipo_proyecto') == 'comercial' ? 'selected' : '' }}>Comercial</option>
                                <option value="industrial" {{ old('tipo_proyecto') == 'industrial' ? 'selected' : '' }}>Industrial</option>
                                <option value="agricola" {{ old('tipo_proyecto') == 'agricola' ? 'selected' : '' }}>Agrícola</option>
                                <option value="bombeo_solar" {{ old('tipo_proyecto') == 'bombeo_solar' ? 'selected' : '' }}>Bombeo Solar</option>
                            </select>
                            @error('tipo_proyecto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Prospecto <span class="text-danger">*</span></label>
                            <select class="form-select @error('prospecto_id') is-invalid @enderror" name="prospecto_id" required>
                                <option value="">Seleccionar prospecto...</option>
                                @foreach($prospectos ?? [] as $prospecto)
                                    <option value="{{ $prospecto->id }}" {{ old('prospecto_id', $prospectoId ?? '') == $prospecto->id ? 'selected' : '' }}>
                                        {{ $prospecto->codigo }} - {{ $prospecto->nombre_completo }}
                                    </option>
                                @endforeach
                            </select>
                            @error('prospecto_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Vendedor Asignado</label>
                            <select class="form-select @error('user_id') is-invalid @enderror" name="user_id">
                                <option value="">Sin asignar (me asigno yo)</option>
                                @foreach($vendedores ?? [] as $vendedor)
                                    <option value="{{ $vendedor->id }}" {{ old('user_id') == $vendedor->id ? 'selected' : '' }}>
                                        {{ $vendedor->persona?->name ?? $vendedor->email }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12 mt-4"><h6 class="text-primary border-bottom pb-2"><i class="bi bi-sun me-2"></i>Detalles del Sistema Solar</h6></div>

                        <div class="col-md-3">
                            <label class="form-label">Potencia del Sistema (kW) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('potencia_kw') is-invalid @enderror" name="potencia_kw" value="{{ old('potencia_kw') }}" 
                                   step="0.1" min="0" placeholder="Ej: 5.5">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Número de Paneles</label>
                            <input type="number" class="form-control" name="cantidad_paneles" value="{{ old('cantidad_paneles') }}" 
                                   min="0" placeholder="Ej: 12">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Tipo de Panel</label>
                            <input type="text" class="form-control" name="tipo_panel" value="{{ old('tipo_panel') }}" 
                                   placeholder="Ej: Monocristalino">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Marca de Panel</label>
                            <input type="text" class="form-control" name="marca_panel" value="{{ old('marca_panel') }}" 
                                   placeholder="Ej: Jinko Solar">
                        </div>

                        <div class="col-12 mt-4"><h6 class="text-primary border-bottom pb-2"><i class="bi bi-currency-dollar me-2"></i>Valoración y Pipeline</h6></div>

                        <div class="col-md-3">
                            <label class="form-label">Monto Estimado (S/) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="monto_estimado" value="{{ old('monto_estimado') }}" 
                                   step="0.01" min="0" placeholder="Ej: 45000" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Fecha Cierre Estimada <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="fecha_cierre_estimada" value="{{ old('fecha_cierre_estimada') }}" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Tipo de Inversor</label>
                            <input type="text" class="form-control" name="tipo_inversor" value="{{ old('tipo_inversor') }}" 
                                   placeholder="Ej: String">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Marca de Inversor</label>
                            <input type="text" class="form-control" name="marca_inversor" value="{{ old('marca_inversor') }}" 
                                   placeholder="Ej: Growatt">
                        </div>

                        <div class="col-md-3">
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" name="incluye_baterias" value="1" id="incluyeBaterias" {{ old('incluye_baterias') ? 'checked' : '' }}>
                                <label class="form-check-label" for="incluyeBaterias">Incluye Baterías</label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Capacidad Baterías (kWh)</label>
                            <input type="number" class="form-control" name="capacidad_baterias_kwh" value="{{ old('capacidad_baterias_kwh') }}" 
                                   step="0.1" min="0" placeholder="Ej: 10">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Observaciones</label>
                            <textarea class="form-control" name="observaciones" rows="3" placeholder="Detalles adicionales sobre la oportunidad...">{{ old('observaciones') }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Notas Técnicas</label>
                            <textarea class="form-control" name="notas_tecnicas" rows="2" placeholder="Aspectos técnicos a considerar...">{{ old('notas_tecnicas') }}</textarea>
                        </div>

                        <div class="col-12 mt-4">
                            <hr>
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.crm.oportunidades.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-2"></i>Cancelar</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-2"></i>Guardar Oportunidad</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    (function() {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) { event.preventDefault(); event.stopPropagation(); }
                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>
@endsection
