@extends('TEMPLATES.ecommerce')

@section('title', 'Iniciar Sesión')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 p-4">
            <div class="card-body">
                <div class="row g-0">
                    <!-- ── Panel izquierdo: marca ── -->
                    <div class="col-lg-5 d-none d-lg-flex">
                        <div class="lm-panel w-100">
                            <div class="lm-panel__content">
                                <img src="images/logo_v.png" alt="CISNERGIA" class="lm-panel__logo">
                                <h4 class="lm-panel__title" id="loginModalLabel">Tu tienda,<br>tu energía</h4>
                                <p class="lm-panel__sub">Inicia sesión y disfruta de una experiencia de compra personalizada en CISNERGIA.</p>
                                <div class="lm-feature">
                                    <div class="lm-feature__icon"><i class="bi bi-bag-check"></i></div>
                                    <div>
                                        <span class="lm-feature__title">Historial de pedidos</span>
                                        <span class="lm-feature__sub">Revisa y rastrea todas tus compras fácilmente</span>
                                    </div>
                                </div>
                                <div class="lm-feature">
                                    <div class="lm-feature__icon"><i class="bi bi-tags"></i></div>
                                    <div>
                                        <span class="lm-feature__title">Ofertas exclusivas</span>
                                        <span class="lm-feature__sub">Precios especiales y descuentos para clientes</span>
                                    </div>
                                </div>
                                <div class="lm-feature">
                                    <div class="lm-feature__icon"><i class="bi bi-heart"></i></div>
                                    <div>
                                        <span class="lm-feature__title">Lista de favoritos</span>
                                        <span class="lm-feature__sub">Guarda los productos que más te interesan</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ── Panel derecho: formulario ── -->
                    <div class="col-lg-7 col-12">
                        <div class="lm-form">
                            <div class="lm-form__close">
                                <h3 class="lm-form__title">Iniciar sesión</h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>

                            <form method="POST" action="{{ route('login') }}" autocomplete="off">
                                @csrf

                                <!-- Correo -->
                                <div class="mb-3">
                                    <label class="lm-label" for="loginEmail">
                                        <i class="bi bi-envelope me-1"></i>Correo electrónico
                                    </label>
                                    <input type="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            id="loginEmail"
                                            name="email"
                                            value="{{ old('email') }}"
                                            required
                                            autocomplete="email"
                                            autofocus
                                            placeholder="nombre@ejemplo.com">
                                    @error('email')
                                        <div class="invalid-feedback d-block mt-1" style="font-size:.82rem;">
                                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Contraseña -->
                                <div class="mb-3">
                                    <label class="lm-label" for="loginPassword">
                                        <i class="bi bi-lock me-1"></i>Contraseña
                                    </label>
                                    <div class="lm-pw-wrap">
                                        <input type="password"
                                                name="password"
                                                id="loginPassword"
                                                class="form-control @error('password') is-invalid @enderror"
                                                required
                                                maxlength="16"
                                                autocomplete="current-password"
                                                placeholder="••••••••">
                                        <button type="button" class="lm-eye" onclick="togglePassword()">
                                            <i class="bi bi-eye" id="toggleIcon"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback d-block mt-1" style="font-size:.82rem;">
                                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Recordarme + ¿Olvidaste? -->
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="checkbox" name="remember" id="rememberMe" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="rememberMe" style="font-size:.875rem;color:var(--c-text-muted);">Recordarme</label>
                                    </div>
                                    <a href="#" class="lm-link">¿Olvidaste tu contraseña?</a>
                                </div>

                                <!-- Submit -->
                                <button type="submit" class="lm-submit">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
                                </button>
                            </form>

                            <!-- Divider social -->
                            <div class="lm-divider">
                                <span>o continúa con</span>
                            </div>

                            <!-- Botones sociales -->
                            <div class="d-grid gap-2 mb-1">
                                <button type="button" class="lm-social-btn">
                                    <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path d="M17.64 9.2c0-.637-.057-1.251-.164-1.84H9v3.481h4.844c-.209 1.125-.843 2.078-1.796 2.717v2.258h2.908c1.702-1.567 2.684-3.874 2.684-6.615z" fill="#4285F4"/>
                                        <path d="M9.003 18c2.43 0 4.467-.806 5.956-2.18L12.05 13.56c-.806.54-1.836.86-3.047.86-2.344 0-4.328-1.584-5.036-3.711H.96v2.332C2.44 15.983 5.485 18 9.003 18z" fill="#34A853"/>
                                        <path d="M3.964 10.71c-.18-.54-.282-1.117-.282-1.71 0-.593.102-1.17.282-1.71V4.958H.957C.347 6.173 0 7.548 0 9s.348 2.827.957 4.042l3.007-2.332z" fill="#FBBC05"/>
                                        <path d="M9.003 3.58c1.321 0 2.508.454 3.44 1.345l2.582-2.58C13.464.891 11.426 0 9.003 0 5.485 0 2.44 2.017.96 4.958L3.967 7.29c.708-2.127 2.692-3.71 5.036-3.71z" fill="#EA4335"/>
                                    </svg>
                                    <span>Continuar con Google</span>
                                </button>
                                <button type="button" class="lm-social-btn">
                                    <i class="bi bi-facebook" style="font-size:1.1rem;color:#1877F2;"></i>
                                    <span>Continuar con Facebook</span>
                                </button>
                            </div>

                            <div class="lm-register">
                                ¿No tienes cuenta?
                                <a href="{{ route('register') }}" class="lm-link fw-semibold">Regístrate gratis</a>
                            </div>
                        </div>
                    </div>

                </div><!-- /.row -->
            </div>
        </div>
    </div>
</div>
@endsection
