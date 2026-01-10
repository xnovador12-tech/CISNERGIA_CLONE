@extends('TEMPLATES.administrador')

@section('title', 'PRODUCTOS')

@section('css')
    <style>
        /* ===== MODAL VER PRODUCTO - ESTILO VIKINGO ===== */
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap');

        .modal-producto .modal-content {
            background: linear-gradient(145deg, #0d0d0d 0%, #1a1a1a 100%);
            border: 2px solid #c9a227;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5), 0 0 40px rgba(201, 162, 39, 0.15);
        }

        .modal-producto .modal-header {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            border-bottom: 2px solid #c9a227;
            padding: 1.5rem 2rem;
            position: relative;
        }

        .modal-producto .modal-title {
            font-family: 'Cinzel', serif;
            font-weight: 700;
            color: #c9a227;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 1.1rem;
            width: 100%;
            text-align: center;
        }

        .modal-producto .btn-close {
            filter: invert(1);
            opacity: 0.7;
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
        }

        .modal-producto .btn-close:hover {
            opacity: 1;
        }

        .modal-producto .modal-body {
            padding: 0;
        }

        /* Contenedor de la producto */
        .producto-container {
            display: flex;
            flex-direction: column;
        }

        /* Imagen del plato */
        .producto-imagen-container {
            position: relative;
            width: 100%;
            height: 280px;
            overflow: hidden;
        }

        .producto-imagen {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .producto-imagen-container:hover .producto-imagen {
            transform: scale(1.05);
        }

        .producto-imagen-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #2d2d2d 0%, #1a1a1a 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #444;
            font-size: 4rem;
        }

        .producto-badge-container {
            position: absolute;
            top: 1rem;
            left: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .producto-badge {
            padding: 0.35rem 1rem;
            font-family: 'Cinzel', serif;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-radius: 20px;
        }

        .producto-badge.popular {
            background: linear-gradient(135deg, #c9a227 0%, #e8c547 100%);
            color: #0d0d0d;
        }

        .producto-badge.nuevo {
            background: linear-gradient(135deg, #8b1e1e 0%, #a02828 100%);
            color: #fff;
        }

        .producto-precio-tag {
            position: absolute;
            bottom: 1rem;
            right: 1rem;
            background: rgba(13, 13, 13, 0.95);
            border: 2px solid #c9a227;
            padding: 0.75rem 1.5rem;
            border-radius: 30px;
        }

        .producto-precio {
            font-family: 'Cinzel', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: #c9a227;
            margin: 0;
        }

        .producto-precio small {
            font-size: 0.9rem;
            color: #888;
        }

        /* Contenido de la producto */
        .producto-contenido {
            padding: 2rem;
            background: linear-gradient(180deg, #1a1a1a 0%, #0d0d0d 100%);
        }

        .producto-categoria {
            display: inline-block;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.75rem;
            font-weight: 600;
            color: #c9a227;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 0.5rem;
            padding: 0.25rem 0;
            border-bottom: 1px solid rgba(201, 162, 39, 0.3);
        }

        .producto-nombre {
            font-family: 'Cinzel', serif;
            font-size: 1.75rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 1rem;
            line-height: 1.3;
        }

        .producto-descripcion {
            font-family: 'Montserrat', sans-serif;
            font-size: 0.95rem;
            color: #888;
            line-height: 1.8;
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Detalles del plato */
        .producto-detalles {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
        }

        .producto-detalle-item {
            text-align: center;
            padding: 1rem;
            background: rgba(45, 45, 45, 0.5);
            border-radius: 12px;
            border: 1px solid rgba(201, 162, 39, 0.2);
            transition: all 0.3s ease;
        }

        .producto-detalle-item:hover {
            border-color: #c9a227;
            transform: translateY(-3px);
        }

        .producto-detalle-icon {
            font-size: 1.5rem;
            color: #c9a227;
            margin-bottom: 0.5rem;
        }

        .producto-detalle-label {
            font-family: 'Montserrat', sans-serif;
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #666;
            margin-bottom: 0.25rem;
        }

        .producto-detalle-value {
            font-family: 'Cinzel', serif;
            font-size: 0.9rem;
            font-weight: 600;
            color: #fff;
        }

        /* Footer del modal */
        .modal-producto .modal-footer {
            background: #0d0d0d;
            border-top: 1px solid rgba(201, 162, 39, 0.3);
            padding: 1.25rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .producto-codigo {
            font-family: 'Montserrat', sans-serif;
            font-size: 0.75rem;
            color: #666;
        }

        .producto-codigo span {
            color: #c9a227;
            font-weight: 600;
        }

        .producto-estado {
            padding: 0.35rem 1rem;
            border-radius: 20px;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .producto-estado.activo {
            background: rgba(39, 174, 96, 0.2);
            color: #27ae60;
            border: 1px solid rgba(39, 174, 96, 0.3);
        }

        .producto-estado.inactivo {
            background: rgba(231, 76, 60, 0.2);
            color: #e74c3c;
            border: 1px solid rgba(231, 76, 60, 0.3);
        }

        /* Ornamentos vikingos */
        .viking-ornament {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin: 1rem 0;
            color: #c9a227;
            opacity: 0.5;
        }

        .viking-ornament::before,
        .viking-ornament::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, transparent, #c9a227, transparent);
        }

        /* Responsive */
        @media (max-width: 576px) {
            .producto-imagen-container {
                height: 220px;
            }

            .producto-contenido {
                padding: 1.5rem;
            }

            .producto-nombre {
                font-size: 1.4rem;
            }

            .producto-detalles {
                grid-template-columns: repeat(3, 1fr);
                gap: 0.5rem;
            }

            .producto-detalle-item {
                padding: 0.75rem 0.5rem;
            }

            .producto-detalle-icon {
                font-size: 1.2rem;
            }

            .producto-detalle-value {
                font-size: 0.8rem;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Encabezado -->
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">PRODUCTOS</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link"
                                href="{{ url('admin-configuraciones') }}">Configuraciones</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link"
                                href="{{ url('admin-productos') }}">Productos</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Inicio</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- fin encabezado -->

    {{-- Contenido --}}
    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm h-100" style="border-radius: 20px; min-height: 500px"
            data-aos="fade-up" data-aos-anchor-placement="top-bottom">
            <div class="card-header bg-transparent">
                <div class="row justify-content-between">
                    <div class="col-12 col-md-6 col-xl-3 mb-2 mb-lg-0">
                        <a href="{{ url('admin-productos/create') }}" class="btn btn-primary btn-sm text-uppercase text-white w-100">
                            <i class="bi bi-plus-circle-fill me-2"></i>
                            Nuevo registro
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-2 col-12 col-md-6">
                    <span class="text-uppercase">Total de registros encontrados: <span
                            class="fw-bold">{{ $admin_productos->count() }}</span></span>
                </div>
                <table id="display" class="table table-hover align-middle nowrap" cellspacing="0" style="width:100%">
                    <thead class="bg-dark text-white border-0">
                        <tr>
                            <th class="h6 small text-center text-uppercase fw-bold">N°</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Código</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Nombre</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Precio</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Categoría</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Medida</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Marca</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Estado</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $contador = 1;
                        @endphp
                        @foreach ($admin_productos as $admin_producto)
                            <tr>
                                <td class="fw-normal text-center align-middle">{{ $contador }}</td>
                                <td class="fw-normal text-center align-middle">{{ $admin_producto->codigo }}</td>
                                <td class="fw-normal text-center align-middle">{{ $admin_producto->name }}</td>
                                <td class="fw-normal text-center align-middle">S/
                                    {{ number_format($admin_producto->precio, 2) }}</td>
                                <td class="fw-normal text-center align-middle">
                                    {{ $admin_producto->categorie->name ?? '-' }}
                                </td>
                                <td class="fw-normal text-center align-middle">{{ $admin_producto->medida->nombre ?? '-' }}
                                <td class="fw-normal text-center align-middle">{{ $admin_producto->marca->name ?? '-' }}
                                </td>
                                <td class="fw-normal align-middle text-center">
                                    <form method="POST" action="/admin-productos/estado/{{ $admin_producto->slug }}"
                                        class="form-update">
                                        @csrf
                                        @method('PUT')
                                        @if ($admin_producto->estado == 'Activo')
                                            <button type="submit" class="badge bg-success border-0">Activo</button>
                                        @else
                                            <button type="submit" class="badge bg-danger border-0">Inactivo</button>
                                        @endif
                                    </form>
                                </td>
                                <td class="align-middle">                                        
                                    <div class="dropstart">
                                        <button class="btn btn-sm btn-light rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 36px; height: 36px; padding: 0;">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow">   
                                            <li>
                                                <a href="{{ url("/admin-productos/$admin_producto->slug") }}" class="dropdown-item d-flex align-items-center"><i class="bi bi-eye text-secondary me-2"></i>Detalles</a>
                                            </li>
                                            
                                            <li>
                                                <a href="{{ url("/admin-productos/$admin_producto->slug/edit") }}" class="dropdown-item d-flex align-items-center"><i class="bi bi-pencil text-secondary me-2"></i>Editar</a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form method="POST" action="{{ route('admin-productos.destroy',$admin_producto->slug) }}" class="form-delete">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item d-flex align-items-center text-danger"><i class="bi bi-trash me-2"></i>Eliminar</button>        
                                                </form>                                                      
                                            </li>
                                        </ul>
                                    </div>       
                                </td>
                            </tr>
                            @php
                                $contador++;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- Fin contenido --}}
@endsection

@section('js')
    <!--sweet alert agregar-->
    @if (session('new_registration') == 'ok')
        <script>
            Swal.fire({
                icon: 'success',
                confirmButtonColor: '#1C3146',
                title: '¡Éxito!',
                text: 'Nuevo registro guardado correctamente',
            })
        </script>
    @endif

    @if (session('exists') == 'ok')
        <script>
            Swal.fire({
                icon: 'warning',
                confirmButtonColor: '#1C3146',
                title: '¡Lo sentimos!',
                text: 'Este registro ya existe',
            })
        </script>
    @endif

    <!--sweet alert actualizar-->
    @if (session('error') == 'ok')
        <script>
            Swal.fire({
                icon: 'warning',
                confirmButtonColor: '#1C3146',
                title: '¡Lo sentimos!',
                text: 'Este registro no se puede eliminar porque está siendo utilizado en otro registro',
            })
        </script>
    @endif

    <!--sweet alert actualizar-->
    @if (session('update') == 'ok')
        <script>
            Swal.fire({
                icon: 'success',
                confirmButtonColor: '#1C3146',
                title: '¡Actualizado!',
                text: 'Registro actualizado correctamente',
            })
        </script>
    @endif

    <!--sweet alert eliminar-->
    @if (session('delete') == 'ok')
        <script>
            Swal.fire({
                icon: 'success',
                confirmButtonColor: '#1C3146',
                title: '¡Eliminado!',
                text: 'Registro eliminado correctamente',
            })
        </script>
    @endif
    <script>
        $('.form-delete').submit(function(e) {
            e.preventDefault();

            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1C3146',
                cancelButtonColor: '#FF9C00',
                confirmButtonText: '¡Sí, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            })
        });
    </script>
    <script>
        $(document).ready(function() {
            @if ($message = Session::get('errors'))
                $("#createproducto").modal('show');
            @endif
        });
    </script>

    <script>
        (function() {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>
@endsection
