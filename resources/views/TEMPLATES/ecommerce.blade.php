<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>CISNERGIA | @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 Local -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilos.css">
    @yield('css')
    @stack('meta')
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg py-2">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center me-4" href="index.html">
                <img src="images/cisnergia_v.png" alt="CISNERGIA PERÚ" height="45">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link px-3 fw-500" href="{{ route('ecommerce.products') }}"
                            id="navItemProductos">Productos</a></li>
                    <li class="nav-item"><a class="nav-link px-3 fw-500" href="instalacion.html">Instalación</a></li>
                    <li class="nav-item"><a class="nav-link px-3 fw-500" href="contacto.html">Contacto</a></li>
                </ul>
                <div class="d-flex align-items-center gap-0 icons__navbar">
                    <!-- Hola, Inicia sesión -->
                    <div class="dropdown">
                        <button
                            class="bg-transparent border-0 rounded-0 d-flex flex-column align-items-start py-2 px-3 rounded hover-bg"
                            type="button" data-bs-toggle="dropdown" aria-expanded="false"
                            style="line-height: 1.3; transition: background 0.2s;">
                            <small class="text-secondary" style="font-size: 0.7rem; font-weight: 400;">Hola,</small>
                            <span class="fw-semibold d-flex align-items-center text-primary" style="font-size: 0.9rem;">
                                Inicia sesión
                                <i class="bi bi-chevron-down ms-1" style="font-size: 0.65rem;"></i>
                            </span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm mt-2 rounded-3">
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
                                <a class="dropdown-item py-2 rounded-2" href="#">
                                    <i class="bi bi-person-plus me-2 text-secondary"></i>Crear cuenta
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- ===============================================
                        MODAL: INICIO DE SESIÓN
                        =============================================== -->
                    <div class="modal fade" id="iniciar_sesion" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content login-modal-content">
                                <div class="modal-header border-0">
                                    <div class="login-modal-header-content">
                                        <div class="login-modal-logo">
                                            <!-- Logo -->
                                            <img src="images/LEIDINGER.png" alt="L'EINDINGER" style="height: 40px;">
                                            <!-- <span>⚔️ VIKINGOS</span> -->
                                        </div>
                                        <h4 class="modal-title" id="loginModalLabel">Bienvenido de vuelta</h4>
                                        <p class="login-modal-subtitle">Ingresa a tu cuenta L'EINDINGER</p>
                                    </div>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="{{ route('login') }}" autocomplete="off">
                                    @csrf
                                        <div class="mb-3">
                                            <label for="loginEmail" class="form-label">Correo Electrónico</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                                <input type="email" class="form-control border-dark @error('email') is-invalid @enderror" name="email" value="" required autocomplete="email" autofocus>

                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="loginPassword" class="form-label">Contraseña</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                                <input type="password" name="password" id="password" class="form-control border-dark border-end-0 @error('password') is-invalid @enderror" required maxlength="16" autocomplete="current-password">
                                                <span class="input-group-text border-start-0 px-2 border-dark" style="background-color: transparent;"><i class="bi bi-lock-fill icono" style="cursor: pointer"></i></span>
                                            </div>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="rememberMe" {{ old('remember') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="rememberMe">Recordarme</label>
                                            </div>
                                            <a href="#" class="forgot-password-link">¿Olvidaste tu contraseña?</a>
                                        </div>
                                        <button type="submit" class="btn btn-viking btn-viking-gold w-100 mb-3">
                                            <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
                                        </button>
                                    </form>

                                    <div class="login-divider">
                                        <span>o continúa con</span>
                                    </div>

                                    <div class="social-login-buttons">
                                        <button type="button" class="btn btn-social btn-google">
                                            <i class="bi bi-google me-2"></i>Google
                                        </button>
                                        <button type="button" class="btn btn-social btn-facebook">
                                            <i class="bi bi-facebook me-2"></i>Facebook
                                        </button>
                                    </div>
                                </div>
                                <div class="modal-footer border-0 justify-content-center">
                                    <p class="mb-0">¿No tienes cuenta? <a href="registro.html" class="register-link">Regístrate aquí</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Mis compras -->
                    <div class="border-start">
                        <a href="mis_compras.html"
                            class="text-decoration-none text-primary d-none d-lg-flex flex-column align-items-start py-2 px-3 rounded hover-bg"
                            style="line-height: 1.3; transition: background 0.2s;">
                            <small class="text-secondary" style="font-size: 0.7rem; font-weight: 400;">Mis</small>
                            <span class="fw-semibold" style="font-size: 0.9rem;">compras</span>
                        </a>
                    </div>

                    <!-- Favoritos -->
                    <div class="border-start">

                        <a href="favoritos.html"
                            class="bg-transparent border-0 icon__boton position-relative d-none d-lg-flex align-items-center justify-content-center px-3 py-2 rounded hover-bg"
                            style="text-decoration: none; transition: background 0.2s;">
                            <i class="bi bi-heart fs-4 text-secondary"></i>
                        </a>
                    </div>

                    <!-- Carrito -->
                    <div class="border-start">

                        <a href="{{ route('ecommerce.cart') }}"
                            class="bg-transparent border-0 icon__boton position-relative d-flex align-items-center justify-content-center px-3 py-2 rounded hover-bg"
                            style="text-decoration: none; transition: background 0.2s;">
                            <i class="bi bi-cart3 fs-4 text-primary"></i>
                            <span class="position-absolute badge rounded-circle bg-secondary text-white cart-count"
                                style="font-size: 0.6rem; width: 18px; height: 18px; padding: 0; display: flex; align-items: center; justify-content: center; top: 5px; right: 8px; font-weight: 600;">
                                0
                                <span class="visually-hidden">productos en carrito</span>
                            </span>
                        </a>
                    </div>
                </div>
                </span>
                </a>
            </div>
        </div>
        </div>
        <!-- MEGA MENÚ PRODUCTOS -->
        <div class="megamenu-productos" id="megamenuProductos">
            <div class="megamenu-content">
                <div class="megamenu-grid">
                    <!-- Columna: Categorías -->
                    <div class="megamenu-categorias">
                        <h3 class="megamenu-titulo">CATEGORÍAS</h3>
                        <ul class="megamenu-lista">
                            <li><a href="#">Módulo solar</a></li>
                            <li><a href="#">Inversor</a></li>
                            <li><a href="#">Batería</a></li>
                            <li><a href="#">Accesorios</a></li>
                        </ul>
                    </div>
                    <!-- Columna: Categorías Populares -->
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
        </div>
    </nav>

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

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
    
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
</body>

</html>
