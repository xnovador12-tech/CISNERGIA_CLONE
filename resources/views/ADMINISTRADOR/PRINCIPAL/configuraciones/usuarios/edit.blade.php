@extends('TEMPLATES.administrador')
@section('title', 'Editar Usuario')

@section('content')
<div class="header_section">
    <div class="bg-transparent mb-3" style="height: 67px"></div>
    <div class="container-fluid">
        <div data-aos="fade-right">
            <h1 class="titulo h2 text-uppercase fw-bold mb-0">EDITAR USUARIO</h1>
            <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                    <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ url('admin-configuraciones') }}">Configuraciones</a></li>
                    <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-usuarios.index') }}">Usuarios</a></li>
                    <li class="breadcrumb-item link" aria-current="page">{{ $admin_usuario->name }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <form method="POST" action="{{ route('admin-usuarios.update', $admin_usuario->id) }}" class="needs-validation" novalidate>
        @csrf @method('PUT')
        <div class="row g-4">

            {{-- DATOS PERSONALES --}}
            <div class="col-lg-8">
                <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius:20px" data-aos="fade-up">
                    <div class="card-header bg-transparent">
                        <span class="fw-semibold text-uppercase small"><i class="bi bi-person me-2"></i>Datos Personales</span>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nombre(s) <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $admin_usuario->persona?->name) }}" maxlength="255" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Apellidos</label>
                                <input type="text" name="surnames" class="form-control"
                                    value="{{ old('surnames', $admin_usuario->persona?->surnames) }}" maxlength="255">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Correo Electrónico <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $admin_usuario->email) }}" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Celular</label>
                                <input type="tel" name="celular" class="form-control"
                                    value="{{ old('celular', $admin_usuario->persona?->celular) }}" maxlength="20">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Dirección</label>
                                <input type="text" name="direccion" class="form-control"
                                    value="{{ old('direccion', $admin_usuario->persona?->direccion) }}" maxlength="255">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CAMBIAR CONTRASEÑA --}}
                <div class="card border-4 borde-top-secondary shadow-sm mt-4" style="border-radius:20px" data-aos="fade-up">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <span class="fw-semibold text-uppercase small"><i class="bi bi-shield-lock me-2"></i>Cambiar Contraseña</span>
                        <small class="text-muted">Dejar en blanco para mantener la actual</small>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nueva Contraseña</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        minlength="8" placeholder="Mínimo 8 caracteres">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePass('password')">
                                        <i class="bi bi-eye" id="icon-password"></i>
                                    </button>
                                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Confirmar Contraseña</label>
                                <div class="input-group">
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control" placeholder="Repetir contraseña">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePass('password_confirmation')">
                                        <i class="bi bi-eye" id="icon-password_confirmation"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ACCESO AL SISTEMA --}}
            <div class="col-lg-4">
                <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius:20px" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-header bg-transparent">
                        <span class="fw-semibold text-uppercase small"><i class="bi bi-lock me-2"></i>Acceso al Sistema</span>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Rol <span class="text-danger">*</span></label>
                            <select name="role_id" class="form-select @error('role_id') is-invalid @enderror" required>
                                <option value="">Seleccionar rol...</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}"
                                        {{ old('role_id', $rolActual?->id) == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Estado</label>
                            <div class="d-flex gap-2 align-items-center mt-1">
                                @if($admin_usuario->estado === 'Activo')
                                    <span class="badge bg-success fs-6">Activo</span>
                                @else
                                    <span class="badge bg-danger fs-6">Inactivo</span>
                                @endif
                                <form method="POST" action="/admin-usuarios/estado/{{ $admin_usuario->id }}" class="d-inline">
                                    @csrf @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-outline-secondary">
                                        Cambiar estado
                                    </button>
                                </form>
                            </div>
                        </div>

                        <hr>
                        <div class="text-muted small">
                            <div><i class="bi bi-calendar me-1"></i>Creado: {{ $admin_usuario->created_at->format('d/m/Y') }}</div>
                            <div><i class="bi bi-envelope me-1"></i>{{ $admin_usuario->email }}</div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent d-flex gap-2">
                        <button type="submit" class="btn btn-primary text-uppercase btn-sm px-4">
                            <i class="bi bi-check-circle me-1"></i>Actualizar
                        </button>
                        <a href="{{ route('admin-usuarios.index') }}" class="btn btn-outline-secondary btn-sm text-uppercase">
                            Cancelar
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection

@section('js')
@include('ADMINISTRADOR.PRINCIPAL.configuraciones.roles._alerts')
<script>
function togglePass(id) {
    const input = document.getElementById(id);
    const icon  = document.getElementById('icon-' + id);
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
    }
}
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
