@extends('TEMPLATES.administrador')

@section('title', 'INGRESOS')

@section('css')
<style>
    /* Asegurar que Select2 dropdown aparezca delante del modal */
    .select2-container--open .select2-dropdown {
        z-index: 2000 !important;
    }
</style>
@endsection
 
@section('content')
<!-- Encabezado -->
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">INGRESOS</h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ url('admin-ingresos') }}">Ingresos</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Inicio</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
<!-- fin encabezado -->

{{-- Contenido --}}
    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm h-100" style="border-radius: 20px; min-height: 500px" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
            <div class="card-header bg-transparent">
                <div class="row justify-content-beetween">
                    <div class="col-12 col-md-2 col-lg-2 col-xl-2 d-flex order-1 order-md-1">
                        <a type="button" href="{{ url('admin-ingresos/create') }}" class="btn btn-dark text-uppercase text-white btn-sm w-100">
                            <i class="bi bi-plus-circle-fill me-2"></i>
                            Nuevo Registro
                        </a>
                    </div>
                    <div class="col-12 col-md-5 col-lg-4 col-xl-4 mb-lg-0 order-3 order-md-3 d-flex justify-content-center">
                        <form method="POST" action="{{ route('ingreso_general.index') }}" enctype="multipart/form-data" autocomplete="off" class="needs-validation" novalidate>
					    @csrf
                            <div class="input-group input-group-sm w-100">
                                <input type="date" class="form-control" name="fecha_inicio">
                                <input type="date" class="form-control" name="fecha_fin">
                                <button class="btn btn-dark" id="button_search"><i class="bi bi-search"></i></button>
                            </div>
                        </form>
                    </div>

                    <div class="col-12 col-md-2 col-lg-2 col-xl-1 mb-2 mb-lg-0 ms-md-auto order-4 order-md-4">
                        <button type="button" class="btn btn-dark btn-sm w-100" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-download"></i></button>
                        <ul class="dropdown-menu">      
                            <li class="dropdown-item">
                                <button class="bg-transparent border-0 px-0 mx-0" data-bs-toggle="modal" data-bs-target="#reporte_PDF"><i class="bi bi-file-pdf me-2"></i><small>PDF</small></button>
                            </li>                                                    
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-2 col-12 col-md-6">
                    <span class="text-uppercase">Total de registros encontrados: <span class="fw-bold">{{ $admin_ingresos->count() }}</span></span>
                </div>
                <table id="display" class="table table-hover table-sm text-center" cellspacing="0" style="width:100%">
                    <thead class="bg-dark text-white border-0">
                        <tr>
                            <th class="h6 small text-center text-uppercase fw-bold">N°</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Código</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Motivo</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Ingresó a</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Fecha</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Total</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $contador = 1;
                        @endphp
                        @foreach ($admin_ingresos as $admin_ingreso)
                            <tr>
                                <td class="fw-normal align-middle">{{ $contador }}</td>
                                @if($admin_ingreso->motivo == 'Inventario')
                                    <td class="fw-normal align-middle">{{ $admin_ingreso->codigo_ocompra }}</td>
                                @endif
                                <td class="fw-normal align-middle">{{ $admin_ingreso->motivo }}</td>
                                <td class="fw-normal align-middle text-uppercase small">{{ $admin_ingreso->almacen->name }}</td>
                                <td class="fw-normal align-middle text-uppercase">{{ $admin_ingreso->created_at->format('d-m-Y') }}</td>
                                <td class="fw-normal align-middle text-end">{{ number_format($admin_ingreso->total, 2, '.', ',') }}</td> 
                                <td class="align-middle">                                        
                                    <div class="dropstart">
                                        <button class="btn btn-sm btn-light rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 36px; height: 36px; padding: 0;">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow"> 
                                            <li class="dropdown-item">
                                                <a target="_blank" href="{{ route('detalle_ingreso.pdf', $admin_ingreso->slug) }}" class="link-dark text-decoration-none"><i class="bi bi-printer-fill text-secondary me-2"></i>Imprimir</a>
                                            </li>
                                            <li class="dropdown-item">
                                                <a href="{{ url("admin-ingresos/$admin_ingreso->slug") }}" class="link-dark text-decoration-none"><i class="bi bi-eye text-secondary me-2"></i>Detalles</a>
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
    @include('ADMINISTRADOR.ALMACEN.ingresos.reporte_modal_pdf')

@endsection

@section('js')
    <!--sweet alert agregar-->
    @if(session('new_registration') == 'ok')
    <script>
        Swal.fire({
        icon: 'success',
        confirmButtonColor: '#1C3146',
        title: '¡Éxito!',
        text: 'Nuevo registro guardado correctamente',
        })
    </script>
    @endif

    @if(session('exists') == 'ok')
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
    @if(session('error') == 'ok')
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
    @if(session('update') == 'ok')
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
    @if(session('delete') == 'ok')
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
        $('.form-delete').submit(function(e){
            e.preventDefault();

            Swal.fire({
            title: '¿Estas seguro?',
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
        $(document).ready(function(){
        @if($message = Session::get('errors'))
            $("#createcategoria").modal('show');
        @endif
        });
    </script>

    <script>
        (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
            })
        })()
    </script>

    <script>
        $(document).ready(function() {
            // Inicializar Select2 dentro de modales con dropdownParent
            $('.modal').on('shown.bs.modal', function() {
                $(this).find('.select2').select2({
                    dropdownParent: $(this)
                });
            });
            
            // Inicializar Select2 fuera de modales
            $('.select2').filter(function() {
                return $(this).closest('.modal').length === 0;
            }).select2();
        });
    </script>

    <script>
        
    </script>
@endsection