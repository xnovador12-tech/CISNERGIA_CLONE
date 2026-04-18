<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CISNERGIA | @yield('title')</title>
    <link rel="icon" href="/images/icon.png">
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="/css/dashboard.css">
    <link rel="stylesheet" href="/css/select2.min.css" />
    <link rel="stylesheet" href="/css/select2-bootstrap-5-theme.min.css" />
    <link rel="stylesheet" href="/css/dataTables.bootstrap5.css" />
    <link rel="stylesheet" href="/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="/css/responsive.bootstrap5.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    @yield('css')
    @stack('meta')


</head>

<body class="bg-light">
    <!-- sidebar -->
    <div class="offcanvas offcanvas-start sidebar-nav" tabindex="-1" id="offcanvasmenu">
        <div class="card content_user">
            <img src="/images/header_control.png" class="header_user" alt="">
            <div class="card-body text-center">
                <div class="avatar">
                    <img src="/images/avatar.png" alt="">
                </div>
                <div class="info_user">
                    <p class="fw-bold text-white fs-5 mb-0">Juan Diego</p>
                    <p class="fw-light text-light mb-0">juan.diego@example.com</p>
                    <p class="mb-0">
                        <span
                            class="badge bg-primary text-uppercase small bg-opacity-10 text-primary px-3 py-2">Administrador</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="offcanvas-body pb-2 p-0 scroll___menu">
            <div class="navbar-white">
                <ul class="navbar-nav">
                    <div class="">
                        <li>
                            <div class="text-white small fw-bold text-uppercase px-3">Principal</div>
                        </li>
                        <li class="mx-2 my-1">
                            <a href="{{ route('admin-dashboard.index') }}"
                                class="nav-link px-3 {{ request()->is(['admin-dashboard*']) ? 'active-item' : null }} menu">
                                <span class="fw-bold">
                                    <i class="bi bi-speedometer2 me-2"></i>
                                </span>
                                <span>
                                    Dashboard
                                </span>
                            </a>
                        </li>
                        <li class="mx-2 my-1">
                            <a href="{{ route('admin-configuraciones.index') }}"
                                class="nav-link px-3 menu {{ request()->is(['admin-configuraciones*', 'admin-usuarios*', 'admin-empresa*', 'admin-perfil*', 'admin-categorias*', 'admin-etiquetas*', 'admin-equipo*']) ? 'active-item' : null }}">
                                <span class="fw-bold">
                                    <i class="bi bi-gear me-2"></i>
                                </span>
                                <span>
                                    Configuraciones
                                </span>
                            </a>
                        </li>

                        <li class="mx-2 my-1">
                            <a href="{{ route('admin-reportes.index') }}"
                                class="nav-link px-3 menu {{ request()->is(['admin-reportes*']) ? 'active-item' : null }}">
                                <span class="fw-bold">
                                    <i class="bi bi-graph-up-arrow me-2"></i>
                                </span>
                                <span>
                                    Reportes
                                </span>
                            </a>
                        </li>

                        <!-- CRM -->
                        <li>
                            <div class="text-white small fw-bold text-uppercase px-3 mt-3">CRM</div>
                        </li>

                        <li class="mx-2 my-1">
                            <a href="{{ route('admin.crm.prospectos.index') }}"
                                class="nav-link px-3 {{ request()->is(['admin/crm/prospectos*']) ? 'active-item' : null }} menu">
                                <span class="fw-bold">
                                    <i class="bi bi-person-plus me-2"></i>
                                </span>
                                <span>Prospectos</span>
                            </a>
                        </li>

                        <li class="mx-2 my-1">
                            <a href="{{ route('admin.crm.oportunidades.index') }}"
                                class="nav-link px-3 {{ request()->is(['admin/crm/oportunidades*']) ? 'active-item' : null }} menu">
                                <span class="fw-bold">
                                    <i class="bi bi-bullseye me-2"></i>
                                </span>
                                <span>Oportunidades</span>
                            </a>
                        </li>

                        <li class="mx-2 my-1">
                            <a href="{{ route('admin.crm.cotizaciones.index') }}"
                                class="nav-link px-3 {{ request()->is(['admin/crm/cotizaciones*']) ? 'active-item' : null }} menu">
                                <span class="fw-bold">
                                    <i class="bi bi-file-earmark-text me-2"></i>
                                </span>
                                <span>Cotizaciones</span>
                            </a>
                        </li>

                        <li class="mx-2 my-1">
                            <a href="{{ route('admin.crm.actividades.index') }}"
                                class="nav-link px-3 {{ request()->is(['admin/crm/actividades*']) ? 'active-item' : null }} menu">
                                <span class="fw-bold">
                                    <i class="bi bi-calendar-check me-2"></i>
                                </span>
                                <span>Actividades</span>
                            </a>
                        </li>

                        <li class="mx-2 my-1">
                            <a href="{{ route('admin.crm.clientes.index') }}"
                                class="nav-link px-3 {{ request()->is(['admin/crm/clientes*']) ? 'active-item' : null }} menu">
                                <span class="fw-bold">
                                    <i class="bi bi-people me-2"></i>
                                </span>
                                <span>Clientes</span>
                            </a>
                        </li>

                        <li class="mx-2 my-1">
                            <a href="{{ route('admin.crm.tickets.index') }}"
                                class="nav-link px-3 {{ request()->is(['admin/crm/tickets*']) ? 'active-item' : null }} menu">
                                <span class="fw-bold">
                                    <i class="bi bi-headset me-2"></i>
                                </span>
                                <span>Tickets</span>
                            </a>
                        </li>

                        <li class="mx-2 my-1">
                            <a href="{{ route('admin.crm.mantenimientos.index') }}"
                                class="nav-link px-3 {{ request()->is(['admin/crm/mantenimientos*']) ? 'active-item' : null }} menu">
                                <span class="fw-bold">
                                    <i class="bi bi-tools me-2"></i>
                                </span>
                                <span>Mantenimientos</span>
                            </a>
                        </li>

                        <li>
                            <div class="text-white small fw-bold text-uppercase px-3">Ventas</div>
                        </li>

                        <li class="mx-2 my-1">
                            <a href="{{ route('admin-pedidos.index') }}"
                                class="nav-link px-3 {{ request()->is(['admin-pedidos*']) ? 'active-item' : null }} menu">
                                <span class="fw-bold">
                                    <i class="bi bi-cart me-2"></i>
                                </span>
                                <span>
                                    Pedidos
                                </span>
                            </a>
                        </li>
                        <li class="mx-2 my-1">
                            <a href="{{ route('admin-ventas.index') }}"
                                class="nav-link px-3 {{ request()->is(['admin-ventas*']) ? 'active-item' : null }} menu">
                                <span class="fw-bold">
                                    <i class="bi bi-cash-coin me-2"></i>
                                </span>
                                <span>
                                    Ventas
                                </span>
                            </a>
                        </li>


                        <!-- Operaciones -->
                        <li>
                            <div class="text-white small fw-bold text-uppercase px-3 mt-3">Operaciones</div>
                        </li>
                        <li class="mx-2 my-1">
                            <a href="{{ route('admin-operaciones-asignaciones.index') }}"
                                class="nav-link px-3 {{ request()->is(['admin-operaciones-asignaciones*']) ? 'active-item' : null }} menu">
                                <span class="fw-bold">
                                    <i class="bi bi-kanban me-2"></i>
                                </span>
                                <span>Asignaciones</span>
                            </a>
                        </li>
                        <li class="mx-2 my-1">
                            <a href="{{ route('admin-operaciones-calidad.index') }}"
                                class="nav-link px-3 {{ request()->is(['admin-operaciones-calidad*']) ? 'active-item' : null }} menu">
                                <span class="fw-bold">
                                    <i class="bi bi-clipboard-check me-2"></i>
                                </span>
                                <span>Control de Calidad</span>
                            </a>
                        </li>
                        <li class="mx-2 my-1">
                            <a href="{{ route('admin-operaciones-campanias.index') }}"
                                class="nav-link px-3 {{ request()->is(['admin-operaciones-campanias*']) ? 'active-item' : null }} menu">
                                <span class="fw-bold">
                                    <i class="bi bi-megaphone me-2"></i>
                                </span>
                                <span>Campañas</span>
                            </a>
                        </li>

                        <li>
                            <div class="text-white small fw-bold text-uppercase px-3">COMPRAS</div>
                        </li>
                        <li class="mx-2 my-1">
                            <a href="{{ route('admin-ordencompras.index') }}"
                                class="nav-link px-3 {{ request()->is(['admin-ordencompras*']) ? 'active-item' : null }} menu">
                                <span class="fw-bold">
                                    <i class="bi bi-basket me-2"></i>
                                </span>
                                <span>
                                    Orden de compra
                                </span>
                            </a>
                        </li>

                        <li>
                            <div class="text-white small fw-bold text-uppercase px-3">ALMACÉN</div>
                        </li>

                        <li class="mx-2 my-1">
                            <a href="{{ route('admin-inventarios.index') }}"
                                class="nav-link px-3 {{ request()->is(['admin-inventarios*']) ? 'active-item' : null }} menu">
                                <span class="fw-bold">
                                    <i class="bi bi-box-seam me-2"></i>
                                </span>
                                <span>
                                    Inventario
                                </span>
                            </a>
                        </li>

                        <li class="mx-2 my-1">
                            <a href="{{ route('admin-ingresos.index') }}"
                                class="nav-link px-3 {{ request()->is(['admin-ingresos*']) ? 'active-item' : null }} menu">
                                <span class="fw-bold">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>
                                </span>
                                <span>
                                    Ingresos
                                </span>
                            </a>
                        </li>

                        <li class="mx-2 my-1">
                            <a href="{{ route('admin-salidas.index') }}"
                                class="nav-link px-3 {{ request()->is(['admin-salidas*']) ? 'active-item' : null }} menu">
                                <span class="fw-bold">
                                    <i class="bi bi-box-arrow-up-right me-2"></i>
                                </span>
                                <span>
                                    Salidas
                                </span>
                            </a>
                        </li>

                        <li>
                            <div class="text-white small fw-bold text-uppercase px-3">Finanzas</div>
                        </li>
                        <li class="mx-2 my-1">
                            <a href="{{ route('admin-cobros.index') }}"
                                class="nav-link px-3 {{ request()->is(['admin-cobros*']) ? 'active-item' : null }} menu">
                                <span class="fw-bold">
                                    <i class="bi bi-cash-coin me-2"></i>
                                </span>
                                <span>
                                    Cobros
                                </span>
                            </a>
                        </li>
                        <li class="mx-2 my-1">
                            <a href="{{ route('admin-pagos.index') }}"
                                class="nav-link px-3 {{ request()->is(['admin-pagos*']) ? 'active-item' : null }} menu">
                                <span class="fw-bold">
                                    <i class="bi bi-wallet2 me-2"></i>
                                </span>
                                <span>
                                    Pagos
                                </span>
                            </a>
                        </li>
                        <li class="mx-2 my-1">
                            <a href="{{ route('admin-caja-chica.index') }}"
                                class="nav-link px-3 {{ request()->is(['admin-caja-chica*']) ? 'active-item' : null }} menu">
                                <span class="fw-bold">
                                    <i class="bi bi-safe me-2"></i>
                                </span>
                                <span>
                                    Caja Chica
                                </span>
                            </a>
                        </li>
                        <li class="mx-2 my-1">
                            <a href="{{ route('admin-comprobantes-finanzas.index') }}"
                                class="nav-link px-3 {{ request()->is(['admin-comprobantes-finanzas*']) ? 'active-item' : null }} menu">
                                <span class="fw-bold">
                                    <i class="bi bi-receipt me-2"></i>
                                </span>
                                <span>
                                    Comprobantes
                                </span>
                            </a>
                        </li>
                        <li class="mx-2 my-1">
                            <a href="{{ route('admin-notas.index') }}"
                                class="nav-link px-3 {{ request()->is(['admin-notas*']) ? 'active-item' : null }} menu">
                                <span class="fw-bold">
                                    <i class="bi bi-file-earmark-minus me-2"></i>
                                </span>
                                <span>
                                    Notas NC/ND
                                </span>
                            </a>
                        </li>
                        <li class="mx-2 my-1">
                            <a href="{{ route('admin-cuentasbancarias.index') }}"
                                class="nav-link px-3 {{ request()->is(['admin-cuentasbancarias*']) ? 'active-item' : null }} menu">
                                <span class="fw-bold">
                                    <i class="bi bi-bank me-2"></i>
                                </span>
                                <span>
                                    Cuentas Bancarias
                                </span>
                            </a>
                        </li>

                        <li>
                            <div class="text-white small fw-bold text-uppercase px-3">Otros</div>
                        </li>
                        <li class="mx-2 my-1">
                            <a href="{{-- route('admin-contacto.index') --}}"
                                class="nav-link px-3 {{ request()->is(['admin-contacto*']) ? 'active-item' : null }} menu">
                                <span class="fw-bold">
                                    <i class="bi bi-envelope me-2"></i>
                                </span>
                                <span>
                                    Contacto
                                </span>
                            </a>
                        </li>
                        <li class="mx-2 my-1">
                            <a href="{{-- route('admin-contacto.index') --}}"
                                class="nav-link px-3 {{ request()->is(['admin-contacto*']) ? 'active-item' : null }} menu">
                                <span class="fw-bold">
                                    <i class="bi bi-journal-text me-2"></i>
                                </span>
                                <span>
                                    Libro de reclamaciones
                                </span>
                            </a>
                        </li>
                    </div>
                </ul>
            </div>
        </div>
        <div class="offcanvas-footer border-top">
            <div class="text-white py-2">
                <p class="mb-0" style="font-size: 12px" align="center">Copyright © @php echo date('Y'); @endphp <a
                        href="#" style="text-decoration: none;" class="text-white fw-bold">CISNERGIA PERU</a> -
                    Todos los
                    derechos Reservados</p>
            </div>
        </div>
    </div>
    <!-- fin sidebar -->

    <!-- contenido -->
    <main>
        <!-- navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top py-3 mb-2">
            <div class="container-fluid mt-1">
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasmenu" aria-controls="offcanvasmenu">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="ms-auto d-flex">
                    <div class="dropdown align-self-center me-3">
                        <button class="btn btn-sm btn-primary rounded-pill position-relative" type="button"
                            id="btnNotificaciones" data-bs-toggle="dropdown" aria-expanded="false"
                            data-bs-auto-close="outside">
                            <i class="bi bi-bell-fill text-white"></i>
                            <span class="badge bg-danger rounded-pill ms-1 d-none" id="badgeNotificaciones">0</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end shadow border-0 p-0"
                            aria-labelledby="btnNotificaciones"
                            style="width: 380px; border-radius: 12px; overflow: hidden;">
                            {{-- Header --}}
                            <div
                                class="d-flex justify-content-between align-items-center px-3 py-2 bg-dark text-white">
                                <span class="fw-bold small"><i class="bi bi-bell me-1"></i>Notificaciones</span>
                                <span class="small" id="notifResumen"></span>
                            </div>
                            {{-- Contenido dinámico --}}
                            <div id="notifContenido" style="max-height: 420px; overflow-y: auto;">
                                <div class="text-center py-4 text-muted" id="notifVacio">
                                    <i class="bi bi-check-circle fs-3 d-block mb-1 text-success"></i>
                                    <small>Sin notificaciones pendientes</small>
                                </div>
                                <div class="d-none" id="notifLista"></div>
                            </div>
                            {{-- Footer --}}
                            <div class="border-top px-3 py-2 text-center bg-light">
                                <a href="{{ route('admin.crm.actividades.index') }}"
                                    class="text-decoration-none small text-primary fw-bold">
                                    <i class="bi bi-list-task me-1"></i>Ver todas las actividades
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown align-self-center">
                        <a class="dropdown-toggle text-decoration-none link-dark" href="#" type="button"
                            id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()?->persona?->name . ' ' . Auth::user()?->persona?->surnames }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 py-0"
                            aria-labelledby="dropdownMenuButton2"
                            style="width: 285px; font-size: 15px; border-radius: 20px; overflow: hidden">
                            <img src="/images/header_control.png" class="header_user"
                                style="border-radius: 20px 20px 0 0" alt="">
                            <div class="contenido">
                                <div class="avatar_dropdown ps-3">
                                    <img src="/images/users/{{ Auth::user()?->persona?->avatar }}" alt="">
                                </div>
                                <div class="info_user ps-3">
                                    <p class="fw-bold mb-0">
                                        {{ Auth::user()?->persona?->name . ' ' . Auth::user()?->persona?->surnames }}</p>
                                    <p class="fw-light small text-muted mb-0">{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                            <li>
                                <a class="dropdown-item py-2" href="/">
                                    <i class="bi bi-globe me-2"></i>
                                    Ir a la plataforma
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item py-2" href="/admin-perfil">
                                    <i class="bi bi-person-circle me-2"></i>
                                    Mi perfil
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item py-2" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right me-2"></i>
                                    Cerrar Sesión
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <!-- fin navbar -->

        <!-- Contenido -->
        <div class="mb-3" id="contenido">
            {{-- Alerta global de acceso denegado (403) --}}
        @if(session('sin_permiso'))
        <div class="container-fluid">
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2" role="alert" data-aos="fade-down">
                <i class="bi bi-shield-lock-fill fs-5"></i>
                <div>{{ session('sin_permiso') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        @endif

        @yield('content')
        </div>
        <!-- Fin contenido -->
    </main>

    <!-- fin contenido -->

    <script src="/js/jquery-3.7.1.js"></script>
    <script src="/js/bootstrap.bundle.min.js"></script>
    <script src="/js/popper.min.js"></script>
    <script src="/js/sweetalert2.all.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="/js/select2.full.min.js"></script>
    <script src="/js/dataTables.js"></script>
    <script src="/js/dataTables.bootstrap5.js"></script>
    <script src="/js/dataTables.responsive.js"></script>
    <script src="/js/responsive.bootstrap5.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        $('.select2_bootstrap').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
        });
    </script>
    <script>
        $('.select2_bootstrap_2').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
        });
    </script>

    <script>
        $('.select2_bootstrap_multiple').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            closeOnSelect: false,
        });
    </script>
    <script>
        AOS.init();
    </script>
    <script>
        var nav = document.querySelector('nav');
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 30) {
                nav.classList.add('bg-nav');
                nav.classList.add('shadow');
            } else {
                nav.classList.remove('bg-nav');
                nav.classList.remove('shadow');
            }
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        if (document.querySelector('#display')) {
            new DataTable('#display', {
                responsive: true,
                fixedHeader: true,
                order: [
                    [0, "desc"]
                ],
                "language": {
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "zeroRecords": "No se encontró nada, lo siento",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros disponibles",
                    "infoFiltered": "(Filtrado de _MAX_ registros totales)",
                    "search": "Buscar:"
                }
            });
        }
    </script>

    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
    <script>
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        })
    </script>

    <script>
        $('.select_location').on('change', function() {
            window.location = $(this).val();
        });
    </script>

    <!-- script del descuento para aplicar-->
    <script>
        $(document).ready(function() {
            // comprobar si el descuento esta activo
            setInterval(() => {
                $.get('/ver_descuento', {
                    validar_descuento: 'varificar_descuento'
                }, function(busqueda) {
                    $.each(busqueda, function(index, value) {
                        if (value[0] == 'no_existe') {
                            console.log('no_existe');
                        } else {
                            console.log('existe');
                        }
                    });
                });
            }, 3000);
            // fin de la validacion
        });
    </script>
    <!-- fin de la carga del descuento para aplicar -->

    <!-- script del descuento para aplicar-->
    <script>
        $(document).ready(function() {
            // comprobar si el descuento esta activo
            setInterval(() => {
                $.get('/ver_cuponera', {
                    validar_cupones: 'varificar_cupones'
                }, function(busqueda) {
                    $.each(busqueda, function(index, value) {
                        if (value[0] == 'no_existe') {
                            console.log('no_existe_cupon');
                        } else {
                            console.log('existe_cupon');
                        }
                    });
                });
            }, 3000);
            // fin de la validacion
        });
    </script>
    <!-- fin de la carga del descuento para aplicar -->

    {{-- ============ NOTIFICACIONES CRM - Polling AJAX ============ --}}
    <script>
        $(document).ready(function() {
            var notifUrl = "{{ route('admin.crm.actividades.notificaciones') }}";
            var descartarUrl = "{{ route('admin.crm.actividades.notificaciones.descartar') }}";
            var csrfToken = "{{ csrf_token() }}";
            var notifIntervalo = 60000; // 1 minuto

            // Colores por categoría
            var coloresMap = {
                'danger': {
                    border: '#dc3545',
                    bg: 'rgba(220,53,69,0.08)'
                },
                'warning': {
                    border: '#ffc107',
                    bg: 'rgba(255,193,7,0.08)'
                },
                'info': {
                    border: '#0dcaf0',
                    bg: 'rgba(13,202,240,0.08)'
                }
            };

            function cargarNotificaciones() {
                $.ajax({
                    url: notifUrl,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var $badge = $('#badgeNotificaciones');
                        var $lista = $('#notifLista');
                        var $vacio = $('#notifVacio');
                        var $resumen = $('#notifResumen');

                        // Badge
                        if (data.total > 0) {
                            $badge.text(data.total > 99 ? '99+' : data.total).removeClass('d-none');
                        } else {
                            $badge.addClass('d-none');
                        }

                        // Resumen en header
                        var badges = [];
                        if (data.vencidas > 0) badges.push('<span class="badge bg-danger">' + data
                            .vencidas + ' vencida' + (data.vencidas > 1 ? 's' : '') + '</span>');
                        if (data.proximas > 0) badges.push('<span class="badge bg-warning text-dark">' +
                            data.proximas + ' por iniciar</span>');
                        if (data.recordatorios > 0) badges.push('<span class="badge bg-info">' + data
                            .recordatorios + ' recordatorio' + (data.recordatorios > 1 ? 's' : '') +
                            '</span>');
                        if (data.seguimientos > 0) badges.push('<span class="badge bg-info">' + data
                            .seguimientos + ' seguimiento' + (data.seguimientos > 1 ? 's' : '') +
                            '</span>');
                        $resumen.html(badges.length > 0 ? badges.join(' ') :
                            '<span class="badge bg-success">Al día</span>');

                        // Lista
                        if (data.items.length === 0) {
                            $vacio.show();
                            $lista.addClass('d-none').empty();
                            return;
                        }

                        $vacio.hide();
                        var html = '';

                        $.each(data.items, function(i, item) {
                            var colors = coloresMap[item.color] || coloresMap['info'];

                            // El cuadro completo es clickeable para todos los items
                            var cursor = 'style="border-left: 4px solid ' + colors.border +
                                ' !important; background: ' + colors.bg + '; cursor: pointer;"';

                            if (item.descartable) {
                                // Cuadro clickeable que descarta + navega
                                html +=
                                    '<div class="px-3 py-2 border-bottom notif-item-clickeable" ' +
                                    'data-id="' + item.id + '" ' +
                                    'data-categoria="' + item.categoria + '" ' +
                                    'data-url="' + item.url + '" ' +
                                    (item.prospecto_id ? 'data-prospecto-id="' + item
                                        .prospecto_id + '" ' : '') +
                                    cursor + '>';
                            } else {
                                // Vencidas: solo navegan, no descartan
                                html +=
                                    '<div class="px-3 py-2 border-bottom notif-item-link" ' +
                                    'data-url="' + item.url + '" ' +
                                    cursor + '>';
                            }

                            // Fila 1: tipo + badge etiqueta
                            html +=
                                '<div class="d-flex justify-content-between align-items-center mb-1">';
                            html += '<span class="small fw-semibold"><i class="bi ' + item
                                .icono + ' me-1"></i>' + item.tipo_actividad + '</span>';
                            html += '<span class="badge bg-' + item.color + (item.color ===
                                    'warning' ? ' text-dark' : '') +
                                '" style="font-size: 0.65rem;">' + item.etiqueta + '</span>';
                            html += '</div>';

                            // Fila 2: título (solo si no es seguimiento, para no repetir)
                            if (item.categoria !== 'seguimiento') {
                                html +=
                                    '<div class="small text-truncate mb-1" style="max-width: 220px;">' +
                                    item.titulo + '</div>';
                            } else {
                                // Para seguimiento mostramos el nombre del prospecto
                                html +=
                                    '<div class="small text-truncate mb-1" style="max-width: 220px;">' +
                                    item.titulo.replace('Seguimiento: ', '') + '</div>';
                            }

                            // Fila 3: fecha
                            html += '<div class="text-muted" style="font-size: 0.75rem;">';
                            html += '<i class="bi bi-calendar3 me-1"></i>' + item.fecha +
                                ' · ' + item.tiempo;
                            html += '</div>';

                            html += '</div>';
                        });

                        $lista.html(html).removeClass('d-none');
                    },
                    error: function() {}
                });
            }

            // Click en cuadro descartable: descartar + navegar
            $(document).on('click', '.notif-item-clickeable', function(e) {
                var $item = $(this);
                var itemId = $item.data('id');
                var categoria = $item.data('categoria');
                var url = $item.data('url');
                var prospectoId = $item.data('prospecto-id') || null;

                // Feedback visual inmediato
                $item.css('opacity', '0.5').css('pointer-events', 'none');

                var payload = {
                    _token: csrfToken,
                    categoria: categoria
                };
                if (categoria === 'seguimiento') {
                    payload.prospecto_id = prospectoId;
                } else {
                    payload.actividad_id = itemId;
                }

                $.ajax({
                    url: descartarUrl,
                    method: 'POST',
                    data: payload,
                    complete: function() {
                        window.location.href = url;
                    }
                });
            });

            // Click en cuadro no descartable (vencidas): solo navegar
            $(document).on('click', '.notif-item-link', function() {
                window.location.href = $(this).data('url');
            });

            // Carga inicial + polling cada minuto
            cargarNotificaciones();
            setInterval(cargarNotificaciones, notifIntervalo);
        });
    </script>
    {{-- ============ FIN NOTIFICACIONES CRM ============ --}}

    {{-- ============ TOAST GLOBAL (flash messages) ============ --}}
    <script>
        (function() {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3500,
                timerProgressBar: true,
                didOpen: function(toast) {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });

            @if (session('success'))
                Toast.fire({
                    icon: 'success',
                    title: @json(session('success'))
                });
            @endif

            @if (session('error'))
                Toast.fire({
                    icon: 'error',
                    title: @json(session('error')),
                    timer: 5000
                });
            @endif

            @if (session('info'))
                Toast.fire({
                    icon: 'info',
                    title: @json(session('info'))
                });
            @endif

            @if (session('warning'))
                Toast.fire({
                    icon: 'warning',
                    title: @json(session('warning')),
                    timer: 5000
                });
            @endif
        })();
    </script>
    {{-- ============ FIN TOAST GLOBAL ============ --}}

    @yield('js')
    @stack('scripts')
</body>

</html>
