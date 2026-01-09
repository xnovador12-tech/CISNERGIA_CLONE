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
    <link rel="stylesheet" href="/css/select2.min.css"/>
    <link rel="stylesheet" href="/css/select2-bootstrap-5-theme.min.css"/>
    <link rel="stylesheet" href="/css/dataTables.bootstrap5.css"/>
    <link rel="stylesheet" href="/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="/css/responsive.bootstrap5.css"/>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    @yield('css')
    @stack('meta')

    <style>
        .scroll___menu {
              max-height: 600px;
              overflow-y: scroll;
              scrollbar-width: thin;
        }
        
        .scroll___menu::-webkit-scrollbar {
              width: 6px;
        }
        
        .scroll___menu::-webkit-scrollbar-track {
              background: #f1f1f1;
        }
        
        .scroll___menu::-webkit-scrollbar-thumb {
              background: #888;
              border-radius: 3px;
        }
        
        .scroll___menu::-webkit-scrollbar-thumb:hover {
              background: #555;
        }
    </style>
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
                            <span class="badge bg-primary text-uppercase small bg-opacity-10 text-primary px-3 py-2">Administrador</span>
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
                                    <a href="{{ route('admin-dashboard.index') }}" class="nav-link px-3 {{ request()->is(['admin-dashboard*'])? 'active-item' : null}} menu">
                                        <span class="fw-bold">
                                            <i class="bi bi-speedometer2 me-2"></i>
                                        </span>
                                        <span>
                                            Dashboard
                                        </span>
                                    </a>
                                </li>
                                <li class="mx-2 my-1">
                                    <a href="{{ route('admin-configuraciones.index') }}" class="nav-link px-3 menu {{ request()->is(['admin-configuraciones*', 'admin-usuarios*', 'admin-empresa*', 'admin-perfil*', 'admin-categorias*', 'admin-etiquetas*', 'admin-clientes*', 'admin-equipo*'])? 'active-item' : null }}">
                                        <span class="fw-bold">
                                            <i class="bi bi-gear me-2"></i>
                                        </span>
                                        <span>
                                            Configuraciones
                                        </span>
                                    </a>
                                </li>

                                <li class="mx-2 my-1">
                                    <a href="{{ route('admin-reportes.index') }}" class="nav-link px-3 menu {{ request()->is(['admin-reportes*'])? 'active-item' : null }}">
                                        <span class="fw-bold">
                                            <i class="bi bi-graph-up-arrow me-2"></i>
                                        </span>
                                        <span>
                                            Reportes
                                        </span>
                                    </a>
                                </li>

                                                                <li>
                                    <div class="text-white small fw-bold text-uppercase px-3">CRM</div>
                                </li>
                    
                                <li class="mx-2 my-1">
                                    <a href="{{-- route('admin-formulas.index') --}}" class="nav-link px-3 {{ request()->is(['admin-formulas*'])? 'active-item' : null}} menu">
                                        <span class="fw-bold">
                                            <i class="bi bi-clipboard2-check me-2"></i>
                                        </span>
                                        <span>
                                            Clientes
                                        </span>
                                    </a>
                                </li>

                                <li class="mx-2 my-1">
                                    <a href="{{-- route('admin-preparacion.index') --}}" class="nav-link px-3 {{ request()->is(['admin-preparacion*'])? 'active-item' : null}} menu">
                                        <span class="fw-bold">
                                            <i class="bi bi-clock-history me-2"></i>
                                        </span>
                                        <span>
                                            Oportunidades y ventas
                                        </span>
                                    </a>
                                </li>

                                <li>
                                    <div class="text-white small fw-bold text-uppercase px-3">Finanzas</div>
                                </li>
                                <li class="mx-2 my-1">
                                    <a href="{{-- route('admin-reservas.index') --}}" class="nav-link px-3 {{ request()->is(['admin-reservas*'])? 'active-item' : null}} menu">
                                        <span class="fw-bold">
                                            <i class="bi bi-calendar-check me-2"></i>
                                        </span>
                                        <span>
                                            Contabilidad
                                        </span>
                                    </a>
                                </li>
                                <li class="mx-2 my-1">
                                    <a href="{{-- route('admin-cotizaciones.index') --}}" class="nav-link px-3 {{ request()->is(['admin-cotizaciones*'])? 'active-item' : null}} menu">
                                        <span class="fw-bold">
                                            <i class="bi bi-file-text me-2"></i>
                                        </span>
                                        <span>
                                            Tesorería
                                        </span>
                                    </a>
                                </li>
                                <li class="mx-2 my-1">
                                    <a href="{{-- route('admin-pedidos.index') --}}" class="nav-link px-3 {{ request()->is(['admin-pedidos*'])? 'active-item' : null}} menu">
                                        <span class="fw-bold">
                                            <i class="bi bi-cart me-2"></i>
                                        </span>
                                        <span>
                                            Cobros
                                        </span>
                                    </a>
                                </li>
                                <li class="mx-2 my-1">
                                    <a href="{{-- route('admin-ventas.index') --}}" class="nav-link px-3 {{ request()->is(['admin-ventas*'])? 'active-item' : null}} menu">
                                        <span class="fw-bold">
                                            <i class="bi bi-cash-coin me-2"></i>
                                        </span>
                                        <span>
                                            Pagos
                                        </span>
                                    </a>
                                </li>

                                <li class="mx-2 my-1">
                                    <a href="{{-- route('admin-ventas.index') --}}" class="nav-link px-3 {{ request()->is(['admin-ventas*'])? 'active-item' : null}} menu">
                                        <span class="fw-bold">
                                            <i class="bi bi-cash-coin me-2"></i>
                                        </span>
                                        <span>
                                            Presupuesto
                                        </span>
                                    </a>
                                </li>
                           
                                <li>
                                    <div class="text-white small fw-bold text-uppercase px-3">COMPRAS</div>
                                </li>
                                <li class="mx-2 my-1">
                                    <a href="{{-- route('admin-ordenes.index') --}}" class="nav-link px-3 {{ request()->is(['admin-ordenes*'])? 'active-item' : null}} menu">
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
                                    <a href="{{-- route('admin-inventario.index') --}}" class="nav-link px-3 {{ request()->is(['admin-inventario*'])? 'active-item' : null}} menu">
                                        <span class="fw-bold">
                                            <i class="bi bi-box-seam me-2"></i>
                                        </span>
                                        <span>
                                            Inventario
                                        </span>
                                    </a>
                                </li>
                           
                                <li class="mx-2 my-1">
                                    <a href="{{-- route('admin-ingresos.index') --}}" class="nav-link px-3 {{ request()->is(['admin-ingresos*'])? 'active-item' : null}} menu">
                                        <span class="fw-bold">
                                            <i class="bi bi-box-arrow-in-right me-2"></i>
                                        </span>
                                        <span>
                                            Ingresos
                                        </span>
                                    </a>
                                </li>

                                <li class="mx-2 my-1">
                                    <a href="{{-- route('admin-salidas.index') --}}" class="nav-link px-3 {{ request()->is(['admin-salidas*'])? 'active-item' : null}} menu">
                                        <span class="fw-bold">
                                            <i class="bi bi-box-arrow-up-right me-2"></i>
                                        </span>
                                        <span>
                                            Salidas
                                        </span>
                                    </a>
                                </li>

                                <li class="mx-2 my-1">
                                    <a href="{{-- route('admin-requerimientos.index') --}}" class="nav-link px-3 {{ request()->is(['admin-requerimientos*'])? 'active-item' : null}} menu">
                                        <span class="fw-bold">
                                            <i class="bi bi-clipboard-check me-2"></i>
                                        </span>
                                        <span>
                                            Requerimientos
                                        </span>
                                    </a>
                                </li>

                                <li>
                                    <div class="text-white small fw-bold text-uppercase px-3">RRHH</div>
                                </li>
                                <li class="mx-2 my-1">
                                    <a href="{{-- route('admin-caja.index') --}}" class="nav-link px-3 {{ request()->is(['admin-caja*'])? 'active-item' : null}} menu">
                                        <span class="fw-bold">
                                            <i class="bi bi-people me-2"></i>
                                        </span>
                                        <span>
                                            Reclutamiento y selección
                                        </span>
                                    </a>
                                </li>
                                <li class="mx-2 my-1">
                                    <a href="{{-- route('admin-comprobantes.index') --}}" class="nav-link px-3 {{ request()->is(['admin-comprobantes*'])? 'active-item' : null}} menu">
                                        <span class="fw-bold">
                                            <i class="bi bi-file-earmark-text me-2"></i>
                                        </span>
                                        <span>
                                            Gestión del personal
                                        </span>
                                    </a>
                                </li>
                                <li class="mx-2 my-1">
                                    <a href="{{-- route('admin-cobros.index') --}}" class="nav-link px-3 {{ request()->is(['admin-cobros*'])? 'active-item' : null}} menu">
                                        <span class="fw-bold">
                                            <i class="bi bi-credit-card me-2"></i>
                                        </span>
                                        <span>
                                            Planillas
                                        </span>
                                    </a>
                                </li>
                                <li class="mx-2 my-1">
                                    <a href="{{-- route('admin-pagos.index') --}}" class="nav-link px-3 {{ request()->is(['admin-pagos*'])? 'active-item' : null}} menu">
                                        <span class="fw-bold">
                                            <i class="bi bi-wallet2 me-2"></i>
                                        </span>
                                        <span>
                                            Evaluación y desempeño
                                        </span>
                                    </a>
                                </li>
                           
                                
                            
                                
                                <li>
                                    <div class="text-white small fw-bold text-uppercase px-3">Licitaciones</div>
                                </li>
                                <li class="mx-2 my-1">
                                    <a href="{{-- route('admin-entregas.index') --}}" class="nav-link px-3 {{ request()->is(['admin-entregas*'])? 'active-item' : null}} menu">
                                        <span class="fw-bold">
                                            <i class="bi bi-bicycle me-2"></i>
                                        </span>
                                        <span>
                                            Gestion de licitaciones
                                        </span>
                                    </a>
                                </li>
                                <li class="mx-2 my-1">
                                    <a href="{{-- route('admin-entregas.index') --}}" class="nav-link px-3 {{ request()->is(['admin-entregas*'])? 'active-item' : null}} menu">
                                        <span class="fw-bold">
                                            <i class="bi bi-bicycle me-2"></i>
                                        </span>
                                        <span>
                                            Gestion documentaria
                                        </span>
                                    </a>
                                </li>
                                
                        </div> 
                    </ul>
                </div>
            </div>
            <div class="offcanvas-footer border-top">
                <div class="text-white py-2">
                    <p class="mb-0" style="font-size: 12px" align="center">Copyright © 2025 <a href="#" style="text-decoration: none;" class="text-white fw-bold">VIKINGOS INVERSIONES</a> - Todos los derechos Reservados</p>
                </div>
            </div>
        </div>
    <!-- fin sidebar -->
    
    <!-- contenido -->
    <main>
        <!-- navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top py-3 mb-2">
                <div class="container-fluid mt-1">
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasmenu" aria-controls="offcanvasmenu">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                            <div class="ms-auto d-flex">
                                <button class="btn btn-sm btn-primary rounded-pill align-self-center me-3"
                                    type="button" id="dropdownMenuButton1"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-bell-fill text-white"></i>
                                    <span class="ms-1 badge bg-secondary">
                                        1
                                    </span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end scroll___carrito shadow border-0"
                                    aria-labelledby="dropdownMenuButton1" style="width: 285px; font-size: 15px;">
                                    <li class="dropdown-item py-2">
                                        <i class="bi bi-exclamation-circle me-2"></i>
                                        <span class="text-muted">No hay notificaciones nuevas</span>
                                    </li>
                                </ul>
                            </div>
                        <div class="dropdown align-self-center">
                            <a class="dropdown-toggle text-decoration-none link-dark" href="#" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                            Juan Diego
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 py-0" aria-labelledby="dropdownMenuButton2" style="width: 285px; font-size: 15px; border-radius: 20px; overflow: hidden">
                                <img src="/images/header_control.png" class="header_user" style="border-radius: 20px 20px 0 0" alt="">
                                <div class="contenido">
                                    <div class="avatar_dropdown ps-3">
                                        <img src="/images/avatar.png" alt="">
                                    </div>
                                    <div class="info_user ps-3">
                                        <p class="fw-bold mb-0">Juan Diego</p>
                                        <p class="fw-light small text-muted mb-0">juan.diego@example.com</p>
                                    </div>
                                </div>
                                <li>
                                    <a class="dropdown-item py-2" href="/admin-perfil">
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
                                    <a class="dropdown-item py-2" href="{{-- route('logout') --}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right me-2"></i>
                                        Cerrar Sesión
                                    </a>
                                    <form id="logout-form" action="{{-- route('logout') --}}" method="POST" class="d-none">
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
    <script>
        $( '.select2_bootstrap' ).select2( {
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
        } );
    </script>
    <script>
        $( '.select2_bootstrap_2' ).select2( {
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
        } );
    </script>

    <script>
        $( '.select2_bootstrap_multiple' ).select2( {
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
            closeOnSelect: false,
        } );
    </script>
    <script>
        AOS.init();
    </script>
    <script>
        var nav = document.querySelector('nav');
        window.addEventListener('scroll', function(){
            if(window.pageYOffset > 30){
                nav.classList.add('bg-nav');
                nav.classList.add('shadow');
            }else{
                nav.classList.remove('bg-nav');
                nav.classList.remove('shadow');
            }
        });
    </script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        new DataTable('#display', {
            responsive: true,
            fixedHeader: true,
            order: [[0, "desc"]],
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "No se encontró nada, lo siento",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(Filtrado de _MAX_ registros totales)",
                "search": "Buscar:"
            }
        });
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
        $('.select_location').on('change', function(){
            window.location = $(this).val();
        });
    </script>
    @yield('js')
    @stack('scripts')
</body>
</html>