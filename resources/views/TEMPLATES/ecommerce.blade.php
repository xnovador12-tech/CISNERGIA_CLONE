<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>CISNERGIA | @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 Local -->
    <link href="/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/estilos.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    @yield('css')
    @stack('meta')
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg py-2">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center me-4" href="{{ route('ecommerce.index') }}">
                <img src="/images/logo_v.png" alt="CISNERGIA PERÚ" height="45">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link px-3 fw-500" href="{{ route('ecommerce.products') }}"
                            id="navItemProductos">Productos</a></li>
                    <li class="nav-item"><a class="nav-link px-3 fw-500" href="{{ route('ecommerce.installation') }}">Instalación</a></li>
                    <li class="nav-item"><a class="nav-link px-3 fw-500" href="{{ route('ecommerce.contact') }}">Contacto</a></li>
                </ul>
                <div class="d-flex align-items-center gap-0 icons__navbar">
                    <!-- Sesión de usuario -->
                    <div class="dropdown">
                        <button
                            class="bg-transparent border-0 rounded-0 d-flex flex-column align-items-start py-2 px-3 rounded hover-bg"
                            type="button" data-bs-toggle="dropdown" aria-expanded="false"
                            style="line-height: 1.3; transition: background 0.2s;">
                            <small class="text-secondary" style="font-size: 0.7rem; font-weight: 400;">Hola,</small>
                            <span class="fw-semibold d-flex align-items-center text-primary" style="font-size: 0.9rem;">
                                @auth
                                    {{ Auth::user()->persona->name ?? 'Mi cuenta' }}
                                @else
                                    Inicia sesión
                                @endauth
                                <i class="bi bi-chevron-down ms-1" style="font-size: 0.65rem;"></i>
                            </span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm mt-2 rounded-3">
                            @auth
                                <li>
                                    <a class="dropdown-item py-2 rounded-2" href="{{ route('ecommerce.mi_perfil') }}">
                                        <i class="bi bi-person me-2 text-primary"></i>Mi cuenta
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item py-2 rounded-2" href="{{ route('ecommerce.mis_favoritos') }}">
                                        <i class="bi bi-heart me-2 text-danger"></i>Mis favoritos
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider my-1">
                                </li>
                                <li>
                                    <a class="dropdown-item py-2 rounded-2" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-left me-2 text-secondary"></i>Cerrar sesión
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            @else
                                <li>
                                    <button type="button" class="dropdown-item py-2 rounded-2" data-bs-toggle="modal"
                                        data-bs-target="#iniciar_sesion">
                                        <i class="bi bi-box-arrow-in-right me-2 text-primary"></i>Iniciar sesión
                                    </button>
                                </li>
                                <li>
                                    <hr class="dropdown-divider my-1">
                                </li>
                                <li>
                                    <a class="dropdown-item py-2 rounded-2" href="{{ route('register') }}">
                                        <i class="bi bi-person-plus me-2 text-secondary"></i>Crear cuenta
                                    </a>
                                </li>
                            @endauth
                        </ul>
                    </div>

                    <!-- ===============================================
                        MODAL: INICIO DE SESIÓN
                        =============================================== -->
                    <div class="modal fade" id="iniciar_sesion" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered lm-dialog">
                            <div class="modal-content lm-content">
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

                    <script>
                        function togglePassword() {
                            const passwordInput = document.getElementById('loginPassword');
                            const toggleIcon    = document.getElementById('toggleIcon');
                            if (passwordInput.type === 'password') {
                                passwordInput.type = 'text';
                                toggleIcon.classList.replace('bi-eye', 'bi-eye-slash');
                            } else {
                                passwordInput.type = 'password';
                                toggleIcon.classList.replace('bi-eye-slash', 'bi-eye');
                            }
                        }
                    </script>


                    <!-- Mis compras -->
                    <div class="border-start">
                        <a href="{{ route('ecommerce.mis_compras') }}"
                            class="text-decoration-none text-primary d-none d-lg-flex flex-column align-items-start py-2 px-3 rounded hover-bg"
                            style="line-height: 1.3; transition: background 0.2s;">
                            <small class="text-secondary" style="font-size: 0.7rem; font-weight: 400;">Mis</small>
                            <span class="fw-semibold" style="font-size: 0.9rem;">compras</span>
                        </a>
                    </div>

                    <!-- Favoritos -->
                    <div class="border-start">

                        <a href="{{ route('ecommerce.mis_favoritos') }}"
                            class="bg-transparent border-0 icon__boton position-relative d-none d-lg-flex align-items-center justify-content-center px-3 py-2 rounded hover-bg"
                            style="text-decoration: none; transition: background 0.2s;">
                            <i class="bi bi-heart fs-4 text-secondary"></i>
                        </a>
                    </div>

                    <!-- Carrito -->
                    <div class="border-start">

                        <button class="bg-transparent border-0 icon__boton position-relative d-flex align-items-center justify-content-center px-3 py-2 rounded hover-bg"
                            style="text-decoration: none; transition: background 0.2s;" type="button" data-bs-toggle="offcanvas" data-bs-target="#carrito_compras" aria-controls="carrito_compras">
                        <i class="bi bi-cart3 fs-4 text-primary"></i>
                        <span class="position-absolute badge rounded-circle bg-secondary text-white cart-count"
                                style="font-size: 0.6rem; width: 18px; height: 18px; padding: 0; display: flex; align-items: center; justify-content: center; top: 5px; right: 8px; font-weight: 600;" id="carrito_count_id">
                                0
                                <span class="visually-hidden">productos en carrito</span>
                            </span>
                    </button>
                    </div>
                </div>
                </span>
                </a>
            </div>
        </div>
        </div>
        <!-- MEGA MENÚ PRODUCTOS -->
        <!-- <div class="megamenu-productos" id="megamenuProductos">
            <div class="megamenu-content">
                <div class="megamenu-grid">
                    <div class="megamenu-categorias">
                        <h3 class="megamenu-titulo">CATEGORÍAS</h3>
                        <ul class="megamenu-lista">
                            <li><a href="#">Módulo solar</a></li>
                            <li><a href="#">Inversor</a></li>
                            <li><a href="#">Batería</a></li>
                            <li><a href="#">Accesorios</a></li>
                        </ul>
                    </div>
                    <div class="megamenu-populares">
                        <h3 class="megamenu-titulo">Categorías populares</h3>
                        <ul class="megamenu-lista">
                            <li><a href="#">Inversor híbrido</a></li>
                            <li><a href="#">Baterías de bajo voltaje</a></li>
                            <li><a href="#">Módulo All Black</a></li>
                            <li><a href="#">Módulos de Cristal-Cristal</a></li>
                            <li><a href="#">Módulos n-type TOPCon</a></li>
                            <li><a href="#">Eficacia &gt;21%</a></li>
                            <li><a href="#" class="megamenu-destacado">Las mejores ofertas - Hasta un 30% más
                                    barato en los
                                    últimos 30 días</a></li>
                            <li><a href="#">Baterías de alto voltaje</a></li>
                            <li><a href="#">bifacial</a></li>
                            <li><a href="#">Optimizador</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div> -->
    </nav>
    <!-- carrito de compras -->
    @include('ECOMMERCE.carrito.carrito_compras')

    @yield('content')

    <!-- FOOTER -->
    <footer class="bg-dark text-light py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <h5 class="fw-bold mb-3"></i> CISNERGIA PERÚ</h5>
                    <p class="small text-light opacity-75 mb-3">
                        Líderes en energía solar en Perú. Transformamos hogares y empresas con soluciones sostenibles y
                        de alta calidad.
                    </p>
                    <div class="d-flex gap-2 mb-3">
                        <a href="#" class="btn btn-outline-light btn-sm"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="btn btn-outline-light btn-sm"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="btn btn-outline-light btn-sm"><i class="bi bi-linkedin"></i></a>
                        <a href="#" class="btn btn-outline-light btn-sm"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <h6 class="fw-bold mb-3">Enlaces rápidos</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#inicio" class="text-light opacity-75 text-decoration-none"><i
                                    class="bi bi-chevron-right"></i> Inicio</a></li>
                        <li class="mb-2"><a href="#productos" class="text-light opacity-75 text-decoration-none"><i
                                    class="bi bi-chevron-right"></i> Productos</a></li>
                        <li class="mb-2"><a href="#instalacion"
                                class="text-light opacity-75 text-decoration-none"><i class="bi bi-chevron-right"></i>
                                Instalación</a></li>
                        <li class="mb-2"><a href="#proceso" class="text-light opacity-75 text-decoration-none"><i
                                    class="bi bi-chevron-right"></i> Proceso</a></li>
                        <li class="mb-2"><a href="#contacto" class="text-light opacity-75 text-decoration-none"><i
                                    class="bi bi-chevron-right"></i> Contacto</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h6 class="fw-bold mb-3">Productos</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-light opacity-75 text-decoration-none"><i
                                    class="bi bi-chevron-right"></i> Paneles Solares</a></li>
                        <li class="mb-2"><a href="#" class="text-light opacity-75 text-decoration-none"><i
                                    class="bi bi-chevron-right"></i> Inversores</a></li>
                        <li class="mb-2"><a href="#" class="text-light opacity-75 text-decoration-none"><i
                                    class="bi bi-chevron-right"></i> Baterías</a></li>
                        <li class="mb-2"><a href="#" class="text-light opacity-75 text-decoration-none"><i
                                    class="bi bi-chevron-right"></i> Kits Completos</a></li>
                        <li class="mb-2"><a href="#" class="text-light opacity-75 text-decoration-none"><i
                                    class="bi bi-chevron-right"></i> Accesorios</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h6 class="fw-bold mb-3">Contacto</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2 text-light opacity-75">
                            <i class="bi bi-geo-alt-fill text-light me-2"></i>Av. Principal 123, San Isidro, Lima
                        </li>
                        <li class="mb-2 text-light opacity-75">
                            <i class="bi bi-telephone-fill text-light me-2"></i>+51 999 999 999
                        </li>
                        <li class="mb-2 text-light opacity-75">
                            <i class="bi bi-envelope-fill text-light me-2"></i>ventas@cisnergia.pe
                        </li>
                        <li class="mb-2 text-light opacity-75">
                            <i class="bi bi-clock-fill text-light me-2"></i>Lun-Vie: 9AM-6PM
                        </li>
                    </ul>
                </div>
            </div>

            <hr class="my-4 opacity-25">

            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="small mb-0 opacity-75">© 2025 Cisnergia Perú. Todos los derechos reservados.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="#" class="text-light opacity-75 text-decoration-none small me-3">Términos y
                        Condiciones</a>
                    <a href="#" class="text-light opacity-75 text-decoration-none small me-3">Política de
                        Privacidad</a>
                    <a href="#" class="text-light opacity-75 text-decoration-none small">Libro de
                        Reclamaciones</a>
                </div>
            </div>
        </div>
    </footer>
    
    @stack('modals')
    <script src="/js/jquery-3.7.1.js"></script>
    <script src="/js/bootstrap.bundle.min.js"></script>
    <script src="/js/scripts.js"></script>
    <script src="/js/sweetalert2.all.min.js"></script>
    
    <!-- Script para cargar contador del carrito -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Cargar contador del carrito al iniciar
            fetch('{{ route("ecommerce.cart.count") }}')
                .then(response => response.json())
                .then(data => {
                    document.querySelectorAll('.cart-count').forEach(el => {
                        el.textContent = data.count;
                    });
                })
                .catch(error => console.error('Error al cargar contador:', error));
        });
    </script>
    
    @yield('js')
    @stack('scripts')

    <!-- ══════════════════════════════════════════
         WHATSAPP FLOATING CHATBOT
    ══════════════════════════════════════════ -->

    <!-- ── Markup ── -->
    <div id="wa-fab">
      <div id="wa-bubble">¡Hola! ¿Necesitas ayuda? 👋</div>
      <button id="wa-btn" aria-label="Abrir chat de WhatsApp" title="Chatea con nosotros">
        <div id="wa-badge">1</div>
        <!-- Ícono oficial WhatsApp SVG -->
        <svg viewBox="0 0 24 24" fill="#fff" xmlns="http://www.w3.org/2000/svg">
          <path d="M20.52 3.48A11.83 11.83 0 0 0 12 0C5.373 0 0 5.373 0 12a11.9 11.9 0 0 0 1.594 5.986L0 24l6.195-1.623A11.89 11.89 0 0 0 12 24c6.627 0 12-5.373 12-12 0-3.206-1.248-6.219-3.48-8.52zM12 22a9.9 9.9 0 0 1-5.031-1.374l-.361-.214-3.676.963.98-3.582-.234-.368A9.9 9.9 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm5.447-7.308c-.3-.15-1.767-.872-2.04-.97-.273-.099-.472-.15-.671.15-.198.298-.771.97-.945 1.169-.173.199-.347.224-.645.074-.298-.149-1.258-.463-2.397-1.48-.885-.79-1.482-1.765-1.656-2.063-.173-.298-.018-.459.13-.607.133-.133.298-.347.447-.52.149-.174.198-.298.298-.497.099-.198.05-.372-.025-.52-.074-.15-.671-1.618-.92-2.215-.242-.581-.487-.502-.671-.511l-.572-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.71.306 1.263.489 1.694.626.712.227 1.36.195 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.29.173-1.413-.074-.124-.272-.198-.571-.347z"/>
        </svg>
      </button>
    </div>

    <!-- ── Panel chat ── -->
    <div id="wa-chat" role="dialog" aria-label="Chat de WhatsApp">

      <!-- Encabezado -->
      <div class="wa-header">
        <div class="wa-avatar">🤖</div>
        <div class="wa-header-info">
          <strong>Soporte por WhatsApp</strong>
          <span><span class="wa-online-dot"></span>En línea ahora</span>
        </div>
        <button class="wa-close" id="wa-close-btn" aria-label="Cerrar chat">&times;</button>
      </div>

      <!-- Conversación -->
      <div class="wa-body" id="wa-body"></div>

      <!-- Footer -->
      <div class="wa-footer">
        <svg viewBox="0 0 24 24"><path d="M20.52 3.48A11.83 11.83 0 0 0 12 0C5.373 0 0 5.373 0 12a11.9 11.9 0 0 0 1.594 5.986L0 24l6.195-1.623A11.89 11.89 0 0 0 12 24c6.627 0 12-5.373 12-12 0-3.206-1.248-6.219-3.48-8.52z"/></svg>
        Conversación cifrada · WhatsApp
      </div>

    </div>

    <script>
    (function () {
      /* ── Configuración ── */
      const WA_NUMBER  = '51999999999';   // Número sin + ni espacios
      const WA_ORIGIN  = 'Hola, me comunico desde la web de CISNERGIA.';

      const OPTIONS = [
        { icon: 'bi bi-info-circle',    label: 'Solicitar información',  msg: 'Hola 👋, me gustaría recibir más información sobre sus productos y servicios solares.' },
        { icon: 'bi bi-tag',            label: 'Consultar precios',       msg: 'Hola, quisiera consultar los precios de sus paneles solares e instalaciones.' },
        { icon: 'bi bi-person-lines-fill', label: 'Hablar con un asesor', msg: 'Hola, deseo hablar con un asesor comercial para recibir orientación personalizada.' },
        { icon: 'bi bi-tools',          label: 'Soporte técnico',         msg: 'Hola, necesito soporte técnico para mi instalación solar.' },
      ];

      /* ── Referencias DOM ── */
      const fab      = document.getElementById('wa-fab');
      const btn      = document.getElementById('wa-btn');
      const badge    = document.getElementById('wa-badge');
      const bubble   = document.getElementById('wa-bubble');
      const chat     = document.getElementById('wa-chat');
      const body     = document.getElementById('wa-body');
      const closeBtn = document.getElementById('wa-close-btn');

      let chatInitialized = false;

      /* ── Helpers ── */
      function now() {
        return new Date().toLocaleTimeString('es-PE', { hour: '2-digit', minute: '2-digit' });
      }

      function addMsg(text, isUser = false) {
        const div = document.createElement('div');
        div.className = 'wa-msg' + (isUser ? ' user' : '');
        div.innerHTML = text + '<div class="wa-msg-time">' + now() + (isUser ? ' ✓✓' : '') + '</div>';
        body.appendChild(div);
        body.scrollTop = body.scrollHeight;
        return div;
      }

      function showTyping() {
        const t = document.createElement('div');
        t.className = 'wa-typing';
        t.innerHTML = '<span></span><span></span><span></span>';
        body.appendChild(t);
        body.scrollTop = body.scrollHeight;
        return t;
      }

      function addOptions() {
        const wrap = document.createElement('div');
        wrap.className = 'wa-options';
        OPTIONS.forEach(opt => {
          const b = document.createElement('button');
          b.className = 'wa-option';
          b.innerHTML = '<i class="' + opt.icon + '"></i>' + opt.label;
          b.addEventListener('click', function () {
            /* Mostrar elección del usuario */
            wrap.remove();
            addMsg(opt.label, true);
            /* Redirigir a WhatsApp con mensaje precargado */
            const text = encodeURIComponent(WA_ORIGIN + ' ' + opt.msg);
            setTimeout(function () {
              window.open('https://wa.me/' + WA_NUMBER + '?text=' + text, '_blank', 'noopener');
            }, 500);
          });
          wrap.appendChild(b);
        });
        body.appendChild(wrap);
        body.scrollTop = body.scrollHeight;
      }

      /* ── Inicializar conversación ── */
      function initChat() {
        if (chatInitialized) return;
        chatInitialized = true;

        /* Paso 1: indicador escribiendo */
        const typing = showTyping();
        setTimeout(function () {
          typing.remove();
          addMsg('Hola 👋, gracias por comunicarte con <strong>CISNERGIA</strong>. ¿En qué podemos ayudarte hoy?');
          /* Paso 2: segundo indicador antes de opciones */
          const typing2 = showTyping();
          setTimeout(function () {
            typing2.remove();
            addMsg('Por favor selecciona una opción:');
            addOptions();
          }, 1000);
        }, 1200);
      }

      /* ── Abrir chat ── */
      function openChat() {
        chat.classList.add('open');
        bubble.style.display = 'none';
        badge.style.display  = 'none';
        initChat();
      }

      /* ── Cerrar chat ── */
      function closeChat() {
        chat.classList.remove('open');
      }

      /* ── Eventos ── */
      btn.addEventListener('click', function () {
        chat.classList.contains('open') ? closeChat() : openChat();
      });
      bubble.addEventListener('click', openChat);
      closeBtn.addEventListener('click', closeChat);

      /* Ocultar burbuja después de 6 s si no se interactuó */
      setTimeout(function () {
        if (!chat.classList.contains('open')) {
          bubble.style.animation = 'none';
          bubble.style.opacity   = '0';
          bubble.style.pointerEvents = 'none';
          setTimeout(function () { bubble.style.display = 'none'; }, 400);
        }
      }, 6000);
    })();
    </script>
    
<script>
// comprobar si el carrito de compras esta cargado
    setInterval(() => {
        $.get('/ver_carrito',{validar_carrito: 'verificar_carrito'}, function(busqueda){
            $('#lista_carrito_id').empty("");
            count = 0;
            subtotales = 0;
            $.each(busqueda, function(index, value){
                if(value[0] == 'no existe'){
                    $('#contador_productos').html('( 0 ) Producto(s) en el carrito');
                    $('#montotal_productos').html('TOTAL: S/ 00.00');
                    const micardshopping = document.getElementById('button_carrito');
                    micardshopping.classList.add('disabled');
                    
                }else{
                    const micardshopping = document.getElementById('button_carrito');
                    micardshopping.classList.remove('disabled');
                    subtotales = subtotales+parseFloat(value[4]);
                    var todo = '<li class="border-bottom">';
                        todo += '<div class="card border-0 py-2">';
                            todo += '<div class="row g-0">';
                                    todo += '<div class="col-3 d-flex">';
                                    todo += '<img src="'+value[3]+'" class="img_curso" alt="" style="width:70px; height:70px; object-fit:cover; border-radius:6px;">';
                                    todo += '</div>';
                                    todo += '<div class="col-9 ps-2">';
                                        todo += '<p class="mb-0 fw-bold" align="justify">'+value[2]+'</p>';
                                        todo += '<p class="text-primary text-start fw-bold mb-0">S/ '+value[4]+'</p>';
                                    todo += '</div>';
                            todo += '</div>';
                        todo += '</div>';
                    todo += '</li>';
                    
                    count++;

                    // Formatear subtotal sólo al mostrar
                    const subtotalFormatted = subtotales.toFixed(2);

                    $('#lista_carrito_id').append(todo);
                    $('#contador_productos').html('( '+count+' ) Producto(s) en el carrito');
                    $('#montotal_productos').html('TOTAL: S/ '+subtotalFormatted+'');
                    $('#carrito_count_id').html(value[6]);
                }
            });
        });
    }, 3000);
// fin de la validacion


// añadir al carrito de compras
    function add_carrito_id(id_producto){
        $.get('/ver_carrito',{validar_carrito:'agregar_carrito',id_element_producto: id_producto}, function(busqueda){
            $('#lista_carrito_id').empty("");
            $.each(busqueda, function(index, value){
                if(value[0] == 'producto_agregado_al_carrito'){
                    $('#carrito_count_id').html(value[1]);
                }else{
                    Swal.fire({
                        imageUrl: "/images/solar_panel.png",
                        title: '¡Upss!',
                        text: 'Este producto ya fue registrado en tu carrito de compras',
                    });
                }
            });
        });
    };
// fin de añadir al carrito de compras
</script>

<script>
// Generar la compra directa
    function agregar_carrito_id(id_producto){
        $.get('/agregar_compra_carrito',{id_element_producto: id_producto}, function(busqueda){
            $.each(busqueda, function(index, value){
                if(value[0] == 'producto_agregado_al_carrito'){
                    window.location.href = "/carrito-compras";
                }else{
                    Swal.fire({
                        imageUrl: "/images/online_shop.png",
                        title: '¡Upss!',
                        text: 'Este producto ya fue registrado en tu carrito de compras',
                    });
                }
            });
        });
    }
// 
</script>

<!--sweet alert actualizar-->
@if(session('error_ingreso') == 'ok')
    <script>
        Swal.fire({
        icon: 'warning',
        confirmButtonColor: '#1C3146',
        title: '¡Lo sentimos!',
        text: 'Debes iniciar sesión para proceder al checkout',
        })
    </script>
@endif

<!-- lista de deseos -->
<script>
    function lista_deseo_carrito_id(producto_id){
        $.get('/lista_deseo_carrito',{id_element_producto: producto_id}, function(busqueda){
            $.each(busqueda, function(index, value){
                if(value[0] == 'deseo_guardado'){
                    Swal.fire({
                        imageUrl: "/images/favorito.png",
                        title: '¡Éxito!',
                        text: 'Producto guardado exitosamente',
                        icon: 'success',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                }else{
                    Swal.fire({
                        imageUrl: "/images/favorito.png",
                        title: '¡Upss!',
                        text: 'Este producto ya fue registrado en tu lista de deseos',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                }
            });
        });
    }

    function eliminar_lista_id(producto_id){
        $.get('/eliminar_lista_deseo_carrito',{id_element_producto: producto_id}, function(busqueda){
            $.each(busqueda, function(index, value){
                if(value[0] == 'producto_eliminado_de_lista_deseos'){
                    Swal.fire({
                        imageUrl: "/images/favorito.png",
                        title: '¡Éxito!',
                        text: 'Producto eliminado de tu lista de deseos',
                        icon: 'success',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                }else{
                    Swal.fire({
                        imageUrl: "/images/favorito.png",
                        title: '¡Upss!',
                        text: 'No se pudo eliminar el producto de tu lista de deseos',
                    });
                }
            });
        });
    }

    function eliminartodofavoritos(){
        $.get('/eliminar_lista_deseo_carrito',{eliminar_todo: true}, function(busqueda){
            $.each(busqueda, function(index, value){
                if(value[0] == 'lista_deseos_eliminada'){
                    Swal.fire({
                        imageUrl: "/images/favorito.png",
                        title: '¡Éxito!',
                        text: 'Lista de deseos eliminada exitosamente',
                        icon: 'success',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                }else{
                    Swal.fire({
                        imageUrl: "/images/favorito.png",
                        title: '¡Upss!',
                        text: 'No se pudo eliminar la lista de deseos',
                    });
                }
            });
        });
    }
</script>
<!-- fin de agregar a la lista de deseo -->

<!-- agregar al carrito desde favoritos -->
 <script>
    function agregar_carrito_idfavorito(id_producto){
        var valor_cantidad = $('#cantidad-' + id_producto).val();
        $.get('/agregar_compra_carritofavoritos',{id_element_producto: id_producto, valor_cantidad: valor_cantidad}, function(busqueda){
            $.each(busqueda, function(index, value){
                if(value[0] == 'producto_agregado_al_carrito'){
                    // window.location.href = "/carrito-compras";
                }else{
                    Swal.fire({
                        imageUrl: "/images/online_shop.png",
                        title: '¡Upss!',
                        text: 'Este producto ya fue registrado en tu carrito de compras',
                    });
                }
            });
        });
    }
// fin de añadir al carrito de compras

//aplicar cuponera
$('#aplicar_cuponera_id').on('click', function(){
    valor_total = $('#cart-total').val();
    valor_cuponeras = $('#valor_cuponera_id').val();
    $.get('/ver_carrito',{valor_total:valor_total, valor_cuponera:valor_cuponeras, procedencia:'cuponera'}, function(busqueda){
        $.each(busqueda, function(index, value){
            if(value[0] == 'cupon_aplicado'){
                $('#cupon_html').html(value[1]);
                $('#valor_cuponera_hidden').val(value[1]);
                $('#cart-total').html(value[2]);
                $('#valor_cuponera_id').val('');
                Swal.fire({
                    imageUrl: "/images/online_shop.png",
                    title: '¡Éxito!',
                    text: 'Cupón aplicado exitosamente',
                    icon: 'success',
                });
            }else{
                Swal.fire({
                    imageUrl: "/images/online_shop.png",
                    title: '¡Upss!',
                    text: 'Este cupon ya fue aplicado anteriormente',
                });
            }
        });
    });
});
// fin de aplicacion de la cuponera
 </script>