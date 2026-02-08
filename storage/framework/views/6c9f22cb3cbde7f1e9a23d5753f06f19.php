<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>CISNERGIA | <?php echo $__env->yieldContent('title'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 Local -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilos.css">
    <?php echo $__env->yieldContent('css'); ?>
    <?php echo $__env->yieldPushContent('meta'); ?>
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
                    <li class="nav-item"><a class="nav-link px-3 fw-500" href="<?php echo e(route('ecommerce.products')); ?>"
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
                            <div class="modal-content" style="border: none; border-radius: 24px; overflow: hidden; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);">
                                <!-- Header con gradiente -->
                                <div class="modal-header border-0 position-relative" style="background: linear-gradient(135deg, #051833 0%, #020c19 100%); padding: 2.5rem 2rem 2rem; z-index: 1;">
                                    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: radial-gradient(circle at top right, rgba(0, 163, 224, 0.15), transparent 70%); z-index: -1;"></div>
                                    
                                    <div class="w-100 text-center">
                                        <div class="mb-3">
                                            <img src="images/logo_v.png" alt="CISNERGIA" style="height: 45px; filter: brightness(0) invert(1);">
                                        </div>
                                        <h4 class="text-white fw-bold mb-2" id="loginModalLabel" style="font-size: 1.75rem;">Bienvenido de vuelta</h4>
                                        <p class="text-white-50 mb-0" style="font-size: 0.95rem;">Ingresa a tu cuenta CISNERGIA</p>
                                    </div>
                                    
                                    <button type="button" class="btn-close btn-close-white position-absolute" data-bs-dismiss="modal" aria-label="Close" style="top: 1rem; right: 1rem; opacity: 0.8;"></button>
                                </div>
                                
                                <!-- Body del modal -->
                                <div class="modal-body" style="padding: 2.5rem 2rem 1.5rem; background: #ffffff;">
                                    <form method="POST" action="<?php echo e(route('login')); ?>" autocomplete="off">
                                    <?php echo csrf_field(); ?>
                                        <!-- Email Input -->
                                        <div class="mb-4">
                                            <label for="loginEmail" class="form-label fw-semibold" style="color: #334155; font-size: 0.9rem; margin-bottom: 0.5rem;">
                                                <i class="bi bi-envelope me-1 text-primary"></i>Correo Electrónico
                                            </label>
                                            <input type="email" 
                                                   class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                   id="loginEmail"
                                                   name="email" 
                                                   value="<?php echo e(old('email')); ?>" 
                                                   required 
                                                   autocomplete="email" 
                                                   autofocus
                                                   placeholder="nombre@ejemplo.com"
                                                   style="border: 2px solid #e2e8f0; border-radius: 12px; padding: 0.75rem 1rem; font-size: 0.95rem; transition: all 0.3s ease; background: #f8fafc;">
                                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="invalid-feedback d-block mt-2" style="font-size: 0.85rem;">
                                                    <i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?>

                                                </div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>

                                        <!-- Password Input -->
                                        <div class="mb-4">
                                            <label for="loginPassword" class="form-label fw-semibold" style="color: #334155; font-size: 0.9rem; margin-bottom: 0.5rem;">
                                                <i class="bi bi-lock me-1 text-primary"></i>Contraseña
                                            </label>
                                            <div class="position-relative">
                                                <input type="password" 
                                                       name="password" 
                                                       id="loginPassword" 
                                                       class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                       required 
                                                       maxlength="16" 
                                                       autocomplete="current-password"
                                                       placeholder="••••••••"
                                                       style="border: 2px solid #e2e8f0; border-radius: 12px; padding: 0.75rem 3rem 0.75rem 1rem; font-size: 0.95rem; transition: all 0.3s ease; background: #f8fafc;">
                                                <button type="button" 
                                                        class="btn position-absolute top-50 end-0 translate-middle-y pe-3" 
                                                        style="border: none; background: transparent; z-index: 10;"
                                                        onclick="togglePassword()">
                                                    <i class="bi bi-eye text-secondary" id="toggleIcon" style="font-size: 1.1rem; cursor: pointer;"></i>
                                                </button>
                                            </div>
                                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="invalid-feedback d-block mt-2" style="font-size: 0.85rem;">
                                                    <i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?>

                                                </div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>

                                        <!-- Recordarme y Olvidaste contraseña -->
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="rememberMe" <?php echo e(old('remember') ? 'checked' : ''); ?> style="border: 2px solid #cbd5e1; border-radius: 6px; width: 1.1em; height: 1.1em;">
                                                <label class="form-check-label" for="rememberMe" style="color: #64748b; font-size: 0.9rem; margin-left: 0.25rem;">
                                                    Recordarme
                                                </label>
                                            </div>
                                            <a href="#" style="color: #00A3E0; text-decoration: none; font-size: 0.9rem; font-weight: 500; transition: color 0.3s ease;">
                                                ¿Olvidaste tu contraseña?
                                            </a>
                                        </div>

                                        <!-- Botón de Iniciar Sesión -->
                                        <button type="submit" class="btn w-100 mb-3" style="background: linear-gradient(135deg, #00A3E0 0%, #0082b3 100%); color: white; border: none; border-radius: 12px; padding: 0.875rem 1.5rem; font-size: 1rem; font-weight: 600; box-shadow: 0 8px 24px rgba(0, 163, 224, 0.25); transition: all 0.3s ease;">
                                            <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
                                        </button>
                                    </form>

                                    <!-- Divider -->
                                    <div class="position-relative my-4">
                                        <hr style="border-color: #e2e8f0; margin: 0;">
                                        <span class="position-absolute top-50 start-50 translate-middle px-3" style="background: white; color: #94a3b8; font-size: 0.85rem; font-weight: 500;">
                                            o continúa con
                                        </span>
                                    </div>

                                    <!-- Botones sociales -->
                                    <div class="d-grid gap-2">
                                        <button type="button" class="btn btn-outline-secondary d-flex align-items-center justify-content-center gap-2" style="border: 2px solid #e2e8f0; border-radius: 12px; padding: 0.75rem 1.5rem; font-weight: 500; transition: all 0.3s ease; background: #f8fafc;">
                                            <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M17.64 9.2c0-.637-.057-1.251-.164-1.84H9v3.481h4.844c-.209 1.125-.843 2.078-1.796 2.717v2.258h2.908c1.702-1.567 2.684-3.874 2.684-6.615z" fill="#4285F4"/>
                                                <path d="M9.003 18c2.43 0 4.467-.806 5.956-2.18L12.05 13.56c-.806.54-1.836.86-3.047.86-2.344 0-4.328-1.584-5.036-3.711H.96v2.332C2.44 15.983 5.485 18 9.003 18z" fill="#34A853"/>
                                                <path d="M3.964 10.71c-.18-.54-.282-1.117-.282-1.71 0-.593.102-1.17.282-1.71V4.958H.957C.347 6.173 0 7.548 0 9s.348 2.827.957 4.042l3.007-2.332z" fill="#FBBC05"/>
                                                <path d="M9.003 3.58c1.321 0 2.508.454 3.44 1.345l2.582-2.58C13.464.891 11.426 0 9.003 0 5.485 0 2.44 2.017.96 4.958L3.967 7.29c.708-2.127 2.692-3.71 5.036-3.71z" fill="#EA4335"/>
                                            </svg>
                                            <span style="color: #334155;">Continuar con Google</span>
                                        </button>
                                        
                                        <button type="button" class="btn btn-outline-secondary d-flex align-items-center justify-content-center gap-2" style="border: 2px solid #e2e8f0; border-radius: 12px; padding: 0.75rem 1.5rem; font-weight: 500; transition: all 0.3s ease; background: #f8fafc;">
                                            <i class="bi bi-facebook" style="font-size: 1.25rem; color: #1877F2;"></i>
                                            <span style="color: #334155;">Continuar con Facebook</span>
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Footer -->
                                <div class="modal-footer border-0 justify-content-center" style="background: #f8fafc; padding: 1.5rem 2rem;">
                                    <p class="mb-0" style="color: #64748b; font-size: 0.95rem;">
                                        ¿No tienes cuenta? 
                                        <a href="registro.html" style="color: #00A3E0; font-weight: 600; text-decoration: none; transition: color 0.3s ease;">
                                            Regístrate aquí
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <style>
                        /* Estilos para el modal de login */
                        #iniciar_sesion .form-control:focus {
                            border-color: #00A3E0 !important;
                            box-shadow: 0 0 0 0.2rem rgba(0, 163, 224, 0.15) !important;
                            background: #ffffff !important;
                        }

                        #iniciar_sesion .form-check-input:checked {
                            background-color: #00A3E0;
                            border-color: #00A3E0;
                        }

                        #iniciar_sesion .btn-outline-secondary:hover {
                            background: #ffffff !important;
                            border-color: #00A3E0 !important;
                            transform: translateY(-2px);
                            box-shadow: 0 8px 16px rgba(0, 163, 224, 0.15);
                        }

                        #iniciar_sesion .btn-primary:hover {
                            background: linear-gradient(135deg, #0082b3 0%, #00A3E0 100%) !important;
                            transform: translateY(-2px);
                            box-shadow: 0 12px 32px rgba(0, 163, 224, 0.35) !important;
                        }

                        #iniciar_sesion a:not(.btn):hover {
                            color: #0082b3 !important;
                        }

                        #iniciar_sesion .modal.fade .modal-dialog {
                            transition: transform 0.3s ease-out;
                        }

                        #iniciar_sesion .modal.show .modal-dialog {
                            transform: none;
                        }

                        @keyframes fadeInModal {
                            from {
                                opacity: 0;
                                transform: translateY(-20px);
                            }
                            to {
                                opacity: 1;
                                transform: translateY(0);
                            }
                        }

                        #iniciar_sesion.show .modal-content {
                            animation: fadeInModal 0.3s ease-out;
                        }
                    </style>

                    <script>
                        function togglePassword() {
                            const passwordInput = document.getElementById('loginPassword');
                            const toggleIcon = document.getElementById('toggleIcon');
                            
                            if (passwordInput.type === 'password') {
                                passwordInput.type = 'text';
                                toggleIcon.classList.remove('bi-eye');
                                toggleIcon.classList.add('bi-eye-slash');
                            } else {
                                passwordInput.type = 'password';
                                toggleIcon.classList.remove('bi-eye-slash');
                                toggleIcon.classList.add('bi-eye');
                            }
                        }
                    </script>


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

                        <a href="<?php echo e(route('ecommerce.cart')); ?>"
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

    <?php echo $__env->yieldContent('content'); ?>

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
            fetch('<?php echo e(route("ecommerce.cart.count")); ?>')
                .then(response => response.json())
                .then(data => {
                    document.querySelectorAll('.cart-count').forEach(el => {
                        el.textContent = data.count;
                    });
                })
                .catch(error => console.error('Error al cargar contador:', error));
        });
    </script>
    
    <?php echo $__env->yieldContent('js'); ?>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html>
<?php /**PATH C:\Users\CESHER\Documents\GitHub\project_cisnergia\resources\views/TEMPLATES/ecommerce.blade.php ENDPATH**/ ?>