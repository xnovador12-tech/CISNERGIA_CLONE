@extends('TEMPLATES.ecommerce')

@section('title', 'Crear Cuenta')

@section('css')
<style>
    .register-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    .register-header {
        background: linear-gradient(135deg, #051833 0%, #020c19 100%);
        position: relative;
        padding: 2rem;
        text-align: center;
    }
    .register-header::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: radial-gradient(circle at top right, rgba(0, 163, 224, 0.15), transparent 70%);
    }
    .register-body .form-control,
    .register-body .form-select {
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.65rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: #f8fafc;
    }
    .register-body .form-control:focus,
    .register-body .form-select:focus {
        border-color: #00A3E0;
        box-shadow: 0 0 0 0.2rem rgba(0, 163, 224, 0.15);
        background: #fff;
    }
    .btn-register {
        background: linear-gradient(135deg, #00A3E0 0%, #0082b3 100%);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 0.8rem;
        font-size: 1rem;
        font-weight: 600;
        box-shadow: 0 8px 24px rgba(0, 163, 224, 0.25);
        transition: all 0.3s ease;
    }
    .btn-register:hover {
        background: linear-gradient(135deg, #0082b3 0%, #00A3E0 100%);
        transform: translateY(-2px);
        box-shadow: 0 12px 32px rgba(0, 163, 224, 0.35);
        color: white;
    }
</style>
@endsection

@section('content')

<!-- BREADCRUMB -->
<section class="py-3 bg-light">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('ecommerce.index') }}" class="text-decoration-none">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Crear Cuenta</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="register-card">
                    <!-- Header -->
                    <div class="register-header">
                        <div class="position-relative">
                            <img src="{{ asset('images/logo_v.png') }}" alt="CISNERGIA" style="height: 40px; filter: brightness(0) invert(1);" class="mb-3">
                            <h4 class="text-white fw-bold mb-1">Crear Cuenta</h4>
                            <p class="text-white-50 mb-0" style="font-size: 0.9rem;">Regístrate para acceder a nuestros productos y servicios</p>
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="register-body bg-white p-4">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="row g-3">
                                {{-- Nombre --}}
                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-semibold" style="font-size: 0.9rem;">
                                        <i class="bi bi-person me-1 text-primary"></i>Nombre <span class="text-danger">*</span>
                                    </label>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                           name="name" value="{{ old('name') }}" required autofocus placeholder="Tu nombre">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Apellidos --}}
                                <div class="col-md-6">
                                    <label for="surnames" class="form-label fw-semibold" style="font-size: 0.9rem;">
                                        <i class="bi bi-person me-1 text-primary"></i>Apellidos <span class="text-danger">*</span>
                                    </label>
                                    <input id="surnames" type="text" class="form-control @error('surnames') is-invalid @enderror"
                                           name="surnames" value="{{ old('surnames') }}" required placeholder="Tus apellidos">
                                    @error('surnames')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div class="col-12">
                                    <label for="email" class="form-label fw-semibold" style="font-size: 0.9rem;">
                                        <i class="bi bi-envelope me-1 text-primary"></i>Correo Electrónico <span class="text-danger">*</span>
                                    </label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                           name="email" value="{{ old('email') }}" required placeholder="correo@ejemplo.com">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Celular --}}
                                <div class="col-md-6">
                                    <label for="celular" class="form-label fw-semibold" style="font-size: 0.9rem;">
                                        <i class="bi bi-phone me-1 text-primary"></i>Celular <span class="text-danger">*</span>
                                    </label>
                                    <input id="celular" type="tel" class="form-control @error('celular') is-invalid @enderror"
                                           name="celular" value="{{ old('celular') }}" required placeholder="987654321" maxlength="20">
                                    @error('celular')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Distrito --}}
                                <div class="col-md-6">
                                    <label for="distrito_id" class="form-label fw-semibold" style="font-size: 0.9rem;">
                                        <i class="bi bi-geo-alt me-1 text-primary"></i>Distrito
                                    </label>
                                    <select class="form-select @error('distrito_id') is-invalid @enderror" name="distrito_id" id="distrito_id">
                                        <option value="">Seleccionar...</option>
                                        @foreach($distritos ?? [] as $distrito)
                                            <option value="{{ $distrito->id }}" {{ old('distrito_id') == $distrito->id ? 'selected' : '' }}>
                                                {{ $distrito->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('distrito_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Dirección --}}
                                <div class="col-12">
                                    <label for="direccion" class="form-label fw-semibold" style="font-size: 0.9rem;">
                                        <i class="bi bi-house me-1 text-primary"></i>Dirección
                                    </label>
                                    <input id="direccion" type="text" class="form-control @error('direccion') is-invalid @enderror"
                                           name="direccion" value="{{ old('direccion') }}" placeholder="Av. Principal 123">
                                    @error('direccion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Contraseña --}}
                                <div class="col-md-6">
                                    <label for="password" class="form-label fw-semibold" style="font-size: 0.9rem;">
                                        <i class="bi bi-lock me-1 text-primary"></i>Contraseña <span class="text-danger">*</span>
                                    </label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                           name="password" required placeholder="Mínimo 8 caracteres">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Confirmar Contraseña --}}
                                <div class="col-md-6">
                                    <label for="password-confirm" class="form-label fw-semibold" style="font-size: 0.9rem;">
                                        <i class="bi bi-lock-fill me-1 text-primary"></i>Confirmar <span class="text-danger">*</span>
                                    </label>
                                    <input id="password-confirm" type="password" class="form-control"
                                           name="password_confirmation" required placeholder="Repetir contraseña">
                                </div>

                                {{-- Botón --}}
                                <div class="col-12 mt-3">
                                    <button type="submit" class="btn btn-register w-100">
                                        <i class="bi bi-person-plus me-2"></i>Crear mi Cuenta
                                    </button>
                                </div>

                                <div class="col-12 text-center mt-2">
                                    <p class="mb-0" style="color: #64748b; font-size: 0.95rem;">
                                        ¿Ya tienes cuenta?
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#iniciar_sesion"
                                           style="color: #00A3E0; font-weight: 600; text-decoration: none;">
                                            Inicia sesión
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
