@extends('TEMPLATES.administrador')
@section('title', 'Nuevo Rol')

@section('content')
<div class="header_section">
    <div class="bg-transparent mb-3" style="height: 67px"></div>
    <div class="container-fluid">
        <div data-aos="fade-right">
            <h1 class="titulo h2 text-uppercase fw-bold mb-0">NUEVO ROL</h1>
            <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                    <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ url('admin-configuraciones') }}">Configuraciones</a></li>
                    <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-roles.index') }}">Roles</a></li>
                    <li class="breadcrumb-item link" aria-current="page">Nuevo</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <form method="POST" action="{{ route('admin-roles.store') }}" class="needs-validation" novalidate>
        @csrf
        <div class="row g-4">

            {{-- DATOS DEL ROL --}}
            <div class="col-lg-4">
                <div class="card border-4 borde-top-secondary shadow-sm h-100" style="border-radius:20px" data-aos="fade-up">
                    <div class="card-header bg-transparent">
                        <span class="fw-semibold text-uppercase small"><i class="bi bi-shield me-2"></i>Datos del Rol</span>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" maxlength="100" required
                                placeholder="Ej: Ventas">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="invalid-feedback">El nombre es obligatorio.</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Descripción</label>
                            <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @enderror"
                                rows="3" maxlength="255"
                                placeholder="Describe brevemente las funciones de este rol">{{ old('descripcion') }}</textarea>
                            @error('descripcion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Estado <span class="text-danger">*</span></label>
                            <select name="estado" class="form-select @error('estado') is-invalid @enderror" required>
                                <option value="Activo" {{ old('estado','Activo') === 'Activo' ? 'selected' : '' }}>Activo</option>
                                <option value="Inactivo" {{ old('estado') === 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                            @error('estado')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="card-footer bg-transparent d-flex gap-2">
                        <button type="submit" class="btn btn-primary text-uppercase btn-sm px-4">
                            <i class="bi bi-check-circle me-1"></i>Guardar Rol
                        </button>
                        <a href="{{ route('admin-roles.index') }}" class="btn btn-outline-secondary btn-sm text-uppercase">
                            Cancelar
                        </a>
                    </div>
                </div>
            </div>

            {{-- PERMISOS --}}
            <div class="col-lg-8">
                <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius:20px" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <span class="fw-semibold text-uppercase small"><i class="bi bi-key me-2"></i>Permisos</span>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-success btn-sm" id="btnSelectAll">
                                <i class="bi bi-check-all me-1"></i>Todos
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" id="btnClearAll">
                                <i class="bi bi-x me-1"></i>Ninguno
                            </button>
                        </div>
                    </div>
                    <div class="card-body" style="max-height: 65vh; overflow-y: auto;">

                        @php
                            $iconosModulo = [
                                'Dashboard'             => 'bi-speedometer2',
                                'CRM - Prospectos'      => 'bi-person-plus',
                                'CRM - Oportunidades'   => 'bi-graph-up-arrow',
                                'CRM - Cotizaciones'    => 'bi-file-earmark-text',
                                'CRM - Actividades'     => 'bi-calendar-check',
                                'CRM - Clientes'        => 'bi-people',
                                'CRM - Tickets'         => 'bi-ticket-perforated',
                                'CRM - Mantenimientos'  => 'bi-tools',
                                'Ventas - Pedidos'      => 'bi-cart3',
                                'Ventas - Ventas'       => 'bi-bag-check',
                                'Compras'               => 'bi-truck',
                                'Almacén'               => 'bi-box-seam',
                                'Operaciones'           => 'bi-gear',
                                'Reportes'              => 'bi-bar-chart',
                                'Config - Tipos'        => 'bi-tags',
                                'Config - Categorías'   => 'bi-folder',
                                'Config - Marcas'       => 'bi-bookmark-star',
                                'Config - Productos'    => 'bi-box',
                                'Config - Proveedores'  => 'bi-building',
                                'Config - Usuarios'     => 'bi-person-gear',
                                'Config - Roles'        => 'bi-shield-lock',
                            ];
                        @endphp

                        @foreach($permisosAgrupados as $modulo => $permisos)
                        <div class="mb-3">
                            <div class="d-flex align-items-center justify-content-between mb-2 pb-1 border-bottom">
                                <span class="fw-semibold small text-uppercase">
                                    <i class="bi {{ $iconosModulo[$modulo] ?? 'bi-circle' }} me-2 text-primary"></i>
                                    {{ $modulo }}
                                </span>
                                <button type="button" class="btn btn-link btn-sm text-muted p-0 toggle-modulo"
                                    data-modulo="{{ Str::slug($modulo) }}">
                                    <small>seleccionar todos</small>
                                </button>
                            </div>
                            <div class="row g-2">
                                @foreach($permisos as $permiso)
                                <div class="col-6 col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input perm-check perm-{{ Str::slug($modulo) }}"
                                            type="checkbox"
                                            name="permissions[]"
                                            value="{{ $permiso->id }}"
                                            id="perm_{{ $permiso->id }}"
                                            {{ in_array($permiso->id, old('permissions', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="perm_{{ $permiso->id }}">
                                            {{ $permiso->label }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection

@section('js')
<script>
// Seleccionar / deseleccionar todos los permisos
document.getElementById('btnSelectAll').addEventListener('click', () => {
    document.querySelectorAll('.perm-check').forEach(c => c.checked = true);
});
document.getElementById('btnClearAll').addEventListener('click', () => {
    document.querySelectorAll('.perm-check').forEach(c => c.checked = false);
});

// Toggle por módulo
document.querySelectorAll('.toggle-modulo').forEach(btn => {
    btn.addEventListener('click', function() {
        const modulo = this.dataset.modulo;
        const checks = document.querySelectorAll('.perm-' + modulo);
        const allChecked = [...checks].every(c => c.checked);
        checks.forEach(c => c.checked = !allChecked);
    });
});

// Validación HTML5
(function() {
    'use strict';
    document.querySelectorAll('.needs-validation').forEach(form => {
        form.addEventListener('submit', e => {
            if (!form.checkValidity()) { e.preventDefault(); e.stopPropagation(); }
            form.classList.add('was-validated');
        }, false);
    });
})();
</script>
@endsection
