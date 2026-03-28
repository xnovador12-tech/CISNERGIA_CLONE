@extends('TEMPLATES.ecommerce')

@section('title', 'Crear Cuenta')

@section('content')

<section class="rg-section">
    <div class="container">
        <div class="rg-card">
            <div class="row g-0">

                <!-- ── Panel izquierdo: marca ── -->
                <div class="col-lg-5 d-none d-lg-flex">
                    <div class="rg-panel w-100">
                        <div class="rg-panel__content">
                            <img src="{{ asset('images/logo_v.png') }}" alt="CISNERGIA" class="rg-panel__logo">
                            <h4 class="rg-panel__title">Únete a<br>CISNERGIA</h4>
                            <p class="rg-panel__sub">Crea tu cuenta y accede a miles de productos solares con precios especiales para clientes registrados.</p>
                            <div class="rg-feature">
                                <div class="rg-feature__icon"><i class="bi bi-shield-check"></i></div>
                                <div>
                                    <span class="rg-feature__title">Cuenta segura</span>
                                    <span class="rg-feature__sub">Tus datos protegidos bajo cifrado SSL</span>
                                </div>
                            </div>
                            <div class="rg-feature">
                                <div class="rg-feature__icon"><i class="bi bi-truck"></i></div>
                                <div>
                                    <span class="rg-feature__title">Seguimiento de envíos</span>
                                    <span class="rg-feature__sub">Rastrea tus pedidos en tiempo real</span>
                                </div>
                            </div>
                            <div class="rg-feature">
                                <div class="rg-feature__icon"><i class="bi bi-percent"></i></div>
                                <div>
                                    <span class="rg-feature__title">Precios exclusivos</span>
                                    <span class="rg-feature__sub">Descuentos y ofertas solo para clientes</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ── Panel derecho: formulario ── -->
                <div class="col-lg-7 col-12">
                    <div class="rg-form">
                        <div class="rg-form__header">
                            <div>
                                <h3 class="rg-form__title">Crear cuenta</h3>
                                <p class="rg-form__sub">Completa los datos para registrarte</p>
                            </div>
                            <a href="{{ route('ecommerce.index') }}" class="rg-back" title="Volver al inicio">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        </div>

                        <form method="POST" action="{{ route('register') }}" autocomplete="off">
                            @csrf
                            <div class="row g-3">

                                {{-- Nombre --}}
                                <div class="col-md-6">
                                    <label class="rg-label" for="name">
                                        <i class="bi bi-person me-1"></i>Nombre <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           id="name" name="name"
                                           value="{{ old('name') }}"
                                           required autofocus
                                           placeholder="Tu nombre">
                                    @error('name')
                                        <div class="invalid-feedback"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Apellidos --}}
                                <div class="col-md-6">
                                    <label class="rg-label" for="surnames">
                                        <i class="bi bi-person me-1"></i>Apellidos <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           class="form-control @error('surnames') is-invalid @enderror"
                                           id="surnames" name="surnames"
                                           value="{{ old('surnames') }}"
                                           required
                                           placeholder="Tus apellidos">
                                    @error('surnames')
                                        <div class="invalid-feedback"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Correo --}}
                                <div class="col-12">
                                    <label class="rg-label" for="email">
                                        <i class="bi bi-envelope me-1"></i>Correo electrónico <span class="text-danger">*</span>
                                    </label>
                                    <input type="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           id="email" name="email"
                                           value="{{ old('email') }}"
                                           required
                                           placeholder="nombre@ejemplo.com">
                                    @error('email')
                                        <div class="invalid-feedback"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Celular --}}
                                <div class="col-md-6">
                                    <label class="rg-label" for="celular">
                                        <i class="bi bi-phone me-1"></i>Celular <span class="text-danger">*</span>
                                    </label>
                                    <input type="tel"
                                           class="form-control @error('celular') is-invalid @enderror"
                                           id="celular" name="celular"
                                           value="{{ old('celular') }}"
                                           required maxlength="20"
                                           placeholder="987 654 321">
                                    @error('celular')
                                        <div class="invalid-feedback"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Distrito --}}
                                <div class="col-md-6">
                                    <label class="rg-label" for="distrito_id">
                                        <i class="bi bi-geo-alt me-1"></i>Distrito
                                    </label>
                                    <select class="form-select @error('distrito_id') is-invalid @enderror"
                                            id="distrito_id" name="distrito_id">
                                        <option value="">Seleccionar...</option>
                                        @foreach($distritos ?? [] as $distrito)
                                            <option value="{{ $distrito->id }}" {{ old('distrito_id') == $distrito->id ? 'selected' : '' }}>
                                                {{ $distrito->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('distrito_id')
                                        <div class="invalid-feedback"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Dirección --}}
                                <div class="col-12">
                                    <label class="rg-label" for="direccion">
                                        <i class="bi bi-house me-1"></i>Dirección
                                    </label>
                                    <input type="text"
                                           class="form-control @error('direccion') is-invalid @enderror"
                                           id="direccion" name="direccion"
                                           value="{{ old('direccion') }}"
                                           placeholder="Av. Principal 123">
                                    @error('direccion')
                                        <div class="invalid-feedback"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Contraseña --}}
                                <div class="col-md-6">
                                    <label class="rg-label" for="password">
                                        <i class="bi bi-lock me-1"></i>Contraseña <span class="text-danger">*</span>
                                    </label>
                                    <div class="rg-pw-wrap">
                                        <input type="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               id="password" name="password"
                                               required
                                               placeholder="Mínimo 8 caracteres">
                                        <button type="button" class="rg-eye" onclick="toggleRgPw('password','rgIcon1')">
                                            <i class="bi bi-eye" id="rgIcon1"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback d-block"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Confirmar contraseña --}}
                                <div class="col-md-6">
                                    <label class="rg-label" for="password-confirm">
                                        <i class="bi bi-lock-fill me-1"></i>Confirmar <span class="text-danger">*</span>
                                    </label>
                                    <div class="rg-pw-wrap">
                                        <input type="password"
                                               class="form-control"
                                               id="password-confirm"
                                               name="password_confirmation"
                                               required
                                               placeholder="Repetir contraseña">
                                        <button type="button" class="rg-eye" onclick="toggleRgPw('password-confirm','rgIcon2')">
                                            <i class="bi bi-eye" id="rgIcon2"></i>
                                        </button>
                                    </div>
                                </div>

                                {{-- Submit --}}
                                <div class="col-12 mt-2">
                                    <button type="submit" class="rg-submit">
                                        <i class="bi bi-person-plus me-2"></i>Crear mi cuenta
                                    </button>
                                </div>

                            </div>
                        </form>

                        <div class="rg-login-link">
                            ¿Ya tienes cuenta?
                            <a href="#" data-bs-toggle="modal" data-bs-target="#iniciar_sesion" class="rg-link fw-semibold">Inicia sesión</a>
                        </div>
                    </div>
                </div>

            </div><!-- /.row -->
        </div><!-- /.rg-card -->
    </div>
</section>

@endsection

@push('scripts')
<script>
function toggleRgPw(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
    }
}
</script>
@endpush
