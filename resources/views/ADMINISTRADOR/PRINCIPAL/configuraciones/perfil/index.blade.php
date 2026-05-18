@extends('TEMPLATES.administrador')
@section('title', 'Mi Perfil')

@section('content')
<div class="header_section">
    <div class="bg-transparent mb-3" style="height: 67px"></div>
    <div class="container-fluid">
        <div data-aos="fade-right">
            <h1 class="titulo h2 text-uppercase fw-bold mb-0">MI PERFIL</h1>
            <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                    <li class="breadcrumb-item link" aria-current="page">Mi Perfil</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row g-4">

        {{-- ═══════════════════════════════════════════════════════════ --}}
        {{-- COLUMNA IZQUIERDA — INFORMACIÓN DEL USUARIO                  --}}
        {{-- ═══════════════════════════════════════════════════════════ --}}
        <div class="col-lg-4">
            <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius:20px" data-aos="fade-up">
                <div class="card-body text-center py-4">

                    {{-- Avatar con fallback robusto:
                         1° Intenta /images/users/{avatar} (ruta de avatares personalizados)
                         2° Si no existe, usa /images/avatar.png (genérico del proyecto) --}}
                    @php
                        $avatarUser = $user->persona?->avatar;
                        if ($avatarUser && file_exists(public_path('images/users/' . $avatarUser))) {
                            $avatarSrc = asset('images/users/' . $avatarUser);
                        } else {
                            $avatarSrc = asset('images/avatar.png');
                        }
                    @endphp
                    <div class="mb-3">
                        <img src="{{ $avatarSrc }}"
                             alt="{{ $user->persona?->name }}"
                             class="rounded-circle shadow-sm"
                             style="width: 120px; height: 120px; object-fit: cover; border: 4px solid #f1f3f4;">
                    </div>

                    {{-- Nombre --}}
                    <h4 class="fw-bold mb-1">{{ $user->persona?->name }} {{ $user->persona?->surnames }}</h4>
                    <p class="text-muted small mb-3">
                        <i class="bi bi-envelope me-1"></i> {{ $user->email }}
                    </p>

                    {{-- Rol(es) --}}
                    @if($roles->count() > 0)
                        <div class="mb-3">
                            @foreach($roles as $rol)
                                <span class="badge bg-primary rounded-pill px-3 py-2 me-1">
                                    <i class="bi bi-shield-check me-1"></i> {{ $rol }}
                                </span>
                            @endforeach
                        </div>
                    @else
                        <div class="mb-3">
                            <span class="badge bg-secondary rounded-pill px-3 py-2">
                                <i class="bi bi-shield-slash me-1"></i> Sin rol asignado
                            </span>
                        </div>
                    @endif

                    {{-- Estado --}}
                    <div class="small text-muted">
                        <i class="bi bi-circle-fill text-success me-1" style="font-size: 8px;"></i>
                        Cuenta {{ strtolower($user->estado ?? 'Activo') }}
                    </div>
                </div>
            </div>

            {{-- Card informativa de permisos --}}
            <div class="card border-4 borde-top-secondary shadow-sm mt-3" style="border-radius:20px" data-aos="fade-up" data-aos-delay="100">
                <div class="card-header bg-transparent">
                    <span class="fw-semibold text-uppercase small">
                        <i class="bi bi-key me-2"></i>Mis Accesos
                    </span>
                </div>
                <div class="card-body">
                    @if($permisos->count() === 0)
                        <div class="text-center py-3">
                            <i class="bi bi-shield-exclamation text-warning" style="font-size: 2.5rem;"></i>
                            <p class="mt-2 mb-1 fw-semibold">Sin permisos asignados</p>
                            <p class="small text-muted mb-0">
                                Contacta a Gerencia para que configure tus accesos al sistema.
                            </p>
                        </div>
                    @else
                        <p class="small text-muted mb-2">Tienes <strong>{{ $permisos->count() }}</strong> permiso(s) asignado(s).</p>
                        @php
                            $permisosPorModulo = $permisos->groupBy('modulo');
                        @endphp
                        <div style="max-height: 280px; overflow-y: auto;">
                            @foreach($permisosPorModulo as $modulo => $perms)
                                <div class="mb-2">
                                    <small class="text-uppercase fw-bold text-primary">{{ $modulo }}</small>
                                    <div class="small">
                                        @foreach($perms as $permiso)
                                            <span class="d-block text-muted">
                                                <i class="bi bi-check2 text-success me-1"></i>{{ $permiso->label }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════════════════ --}}
        {{-- COLUMNA DERECHA — FORMULARIOS DE EDICIÓN                     --}}
        {{-- ═══════════════════════════════════════════════════════════ --}}
        <div class="col-lg-8">

            {{-- ─── Datos personales ─── --}}
            <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius:20px" data-aos="fade-up">
                <div class="card-header bg-transparent">
                    <span class="fw-semibold text-uppercase small">
                        <i class="bi bi-person me-2"></i>Datos Personales
                    </span>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin-perfil.update') }}" class="needs-validation" novalidate>
                        @csrf @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nombre(s) <span class="text-danger">*</span></label>
                                <input type="text" name="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $user->persona?->name) }}"
                                       maxlength="100" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Apellidos</label>
                                <input type="text" name="surnames"
                                       class="form-control @error('surnames') is-invalid @enderror"
                                       value="{{ old('surnames', $user->persona?->surnames) }}"
                                       maxlength="100">
                                @error('surnames')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Correo Electrónico</label>
                                <input type="email" class="form-control" value="{{ $user->email }}" readonly disabled>
                                <small class="text-muted">El correo no se puede modificar. Contacta a Gerencia si necesitas cambiarlo.</small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Celular</label>
                                <input type="tel" name="celular"
                                       class="form-control @error('celular') is-invalid @enderror"
                                       value="{{ old('celular', $user->persona?->celular) }}"
                                       maxlength="20">
                                @error('celular')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Dirección</label>
                                <input type="text" name="direccion"
                                       class="form-control @error('direccion') is-invalid @enderror"
                                       value="{{ old('direccion', $user->persona?->direccion) }}"
                                       maxlength="255">
                                @error('direccion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Referencia</label>
                                <input type="text" name="referencia"
                                       class="form-control @error('referencia') is-invalid @enderror"
                                       value="{{ old('referencia', $user->persona?->referencia) }}"
                                       maxlength="255"
                                       placeholder="Ej: Entre av. Principal y calle Secundaria">
                                @error('referencia')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-check-lg me-1"></i> Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ─── Cambiar contraseña ─── --}}
            <div class="card border-4 borde-top-secondary shadow-sm mt-3" style="border-radius:20px" data-aos="fade-up" data-aos-delay="100">
                <div class="card-header bg-transparent">
                    <span class="fw-semibold text-uppercase small">
                        <i class="bi bi-lock me-2"></i>Cambiar Contraseña
                    </span>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin-perfil.password') }}" class="needs-validation" novalidate>
                        @csrf @method('PUT')

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Contraseña Actual <span class="text-danger">*</span></label>
                                <input type="password" name="password_actual"
                                       class="form-control @error('password_actual') is-invalid @enderror"
                                       required>
                                @error('password_actual')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nueva Contraseña <span class="text-danger">*</span></label>
                                <input type="password" name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       minlength="8" required>
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <small class="text-muted">Mínimo 8 caracteres</small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Confirmar Nueva Contraseña <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation"
                                       class="form-control"
                                       minlength="8" required>
                            </div>
                        </div>

                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-warning px-4">
                                <i class="bi bi-shield-lock me-1"></i> Cambiar Contraseña
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // ── Feedback SweetAlert de acciones ──────────────────────────────
    @if(session('update'))
    Swal.fire({
        icon: 'success',
        title: 'Perfil actualizado',
        text: 'Tus datos personales se guardaron correctamente.',
        timer: 2200,
        showConfirmButton: false
    });
    @endif

    @if(session('password_update'))
    Swal.fire({
        icon: 'success',
        title: 'Contraseña actualizada',
        text: 'Tu contraseña se cambió correctamente. Úsala en tu próximo inicio de sesión.',
        timer: 2500,
        showConfirmButton: false
    });
    @endif

    @if(session('password_error'))
    Swal.fire({
        icon: 'error',
        title: 'Contraseña incorrecta',
        text: 'La contraseña actual que ingresaste no es correcta.',
        confirmButtonColor: '#1C3146'
    });
    @endif

    // ── Validación Bootstrap (needs-validation) ──────────────────────
    (() => {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>
@endpush
