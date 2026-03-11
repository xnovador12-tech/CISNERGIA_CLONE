@extends('TEMPLATES.administrador')
@section('title', 'Nuevo Usuario')

@section('content')
<div class="header_section">
    <div class="bg-transparent mb-3" style="height: 67px"></div>
    <div class="container-fluid">
        <div data-aos="fade-right">
            <h1 class="titulo h2 text-uppercase fw-bold mb-0">NUEVO USUARIO</h1>
            <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                    <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ url('admin-configuraciones') }}">Configuraciones</a></li>
                    <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-usuarios.index') }}">Usuarios</a></li>
                    <li class="breadcrumb-item link" aria-current="page">Nuevo</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <form method="POST" action="{{ route('admin-usuarios.store') }}" class="needs-validation" novalidate>
        @csrf
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
                                    value="{{ old('name') }}" maxlength="255" required placeholder="Nombres">
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <div class="invalid-feedback">El nombre es obligatorio.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Apellidos</label>
                                <input type="text" name="surnames" class="form-control @error('surnames') is-invalid @enderror"
                                    value="{{ old('surnames') }}" maxlength="255" placeholder="Apellidos">
                                @error('surnames')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Correo Electrónico <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" required placeholder="correo@empresa.com">
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <div class="invalid-feedback">Ingrese un correo válido.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Celular</label>
                                <input type="tel" name="celular" class="form-control @error('celular') is-invalid @enderror"
                                    value="{{ old('celular') }}" maxlength="20" placeholder="987654321">
                                @error('celular')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Dirección</label>
                                <input type="text" name="direccion" class="form-control @error('direccion') is-invalid @enderror"
                                    value="{{ old('direccion') }}" maxlength="255" placeholder="Av. Principal 123">
                                @error('direccion')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
                                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="invalid-feedback">Seleccione un rol.</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Contraseña <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    required minlength="8" placeholder="Mínimo 8 caracteres">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePass('password')">
                                    <i class="bi bi-eye" id="icon-password"></i>
                                </button>
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="invalid-feedback">Mínimo 8 caracteres.</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Confirmar Contraseña <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control" required placeholder="Repetir contraseña">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePass('password_confirmation')">
                                    <i class="bi bi-eye" id="icon-password_confirmation"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent d-flex gap-2">
                        <button type="submit" class="btn btn-primary text-uppercase btn-sm px-4">
                            <i class="bi bi-person-plus me-1"></i>Crear Usuario
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
