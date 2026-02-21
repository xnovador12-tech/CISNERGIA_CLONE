@extends('TEMPLATES.administrador')

@section('title', 'SERVICIOS')

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
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">SERVICIOS</h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ url('admin-configuraciones') }}">Configuraciones</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ url('admin-servicios') }}">Servicios</a></li>
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
                    <div class="col-md-3 d-flex">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#createservicios" class="btn btn-dark text-uppercase text-white btn-sm w-100">
                            <i class="bi bi-plus-circle-fill me-2"></i>
                            Nuevo Registro
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-2 col-12 col-md-6">
                    <span class="text-uppercase">Total de registros encontrados: <span class="fw-bold">{{ $admin_servicios->count() }}</span></span>
                </div>
                <table id="display" class="table table-hover table-sm text-center" cellspacing="0" style="width:100%">
                    <thead class="bg-dark text-white border-0">
                        <tr>
                            <th class="h6 small text-center text-uppercase fw-bold">N°</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Codigo</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Nombre</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Tipo</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Estado</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $contador = 1;
                        @endphp
                        @foreach($admin_servicios as $admin_servicio)
                            <tr>
                                <td class="fw-normal text-center align-middle">{{ $contador }}</td>
                                <td class="fw-normal text-center align-middle">{{ $admin_servicio->codigo }}</td>
                                <td class="fw-normal text-center align-middle">{{ $admin_servicio->name }}</td>
                                <td class="fw-normal text-center align-middle">{{ $admin_servicio->tipo_servicio }}</td>
                                <td class="fw-normal align-middle">
                                    <form method="POST" action="/admin-servicios/estado/{{$admin_servicio->slug}}" class="form-update">
                                    @csrf
                                    @method('PUT')
                                        @if($admin_servicio->estado == 'Activo')
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
                                                <button type="button" data-bs-toggle="modal" data-bs-target="#editservicios{{$admin_servicio->slug}}" data-id="{{$admin_servicio->slug}}" class="dropdown-item d-flex align-items-center"><i class="bi bi-pencil text-secondary me-2"></i>Editar</button>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form method="POST" action="{{ route('admin-servicios.destroy',$admin_servicio->slug) }}" class="form-delete">
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
        @foreach($admin_servicios as $admin_servicio)
            @include('ADMINISTRADOR.PRINCIPAL.configuraciones.servicios.edit')
        @endforeach
            @include('ADMINISTRADOR.PRINCIPAL.configuraciones.servicios.create')
    </div>
{{-- Fin contenido --}}
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
                // Ejecutar el filtro cuando se abre el modal
                ejecutarFiltrosProveedor($(this));
            });
            
            // Inicializar Select2 fuera de modales
            $('.select2').filter(function() {
                return $(this).closest('.modal').length === 0;
            }).select2();

            // Función para ejecutar filtros de proveedor
            function ejecutarFiltrosProveedor(context) {
                var tipoSelect = context.find('[id*="tipos__servicio_id"]');
                tipoSelect.trigger('change');
            }

            //filtro para poder mostrar los proveedores dependiendo del tipo de bien seleccionado
            $(document).on('change', '#tipos__servicio_id', function() {
                var valor_servicio = $(this).val();  
                if(valor_servicio == 'Servicio Publico'){
                    $('#proveedor__id').attr('disabled', false);
                    $('#view_proveedor_id').show();
                }else{
                    $('#proveedor__id').attr('disabled', true);
                    $('#proveedor__id').prop('selectedIndex', 0).change();
                    $('#view_proveedor_id').hide();
                }
            });

            //filtro para poder mostrar los proveedores dependiendo del tipo de bien seleccionado en el formulario editar
            $(document).on('change', '[id^="tipos__servicio_id_edit_"]', function() {
                var valor_servicio = $(this).val();
                var slug = $(this).attr('id').replace('tipos__servicio_id_edit_', '');
                console.log('Cambio detectado en edit:', slug, valor_servicio); // Debug
                if(valor_servicio == 'Servicio Publico'){
                    $('#proveedor__id_edit_' + slug).attr('disabled', false);
                    $('#view_proveedor_id_edit_' + slug).show();
                }else{
                    $('#proveedor__id_edit_' + slug).attr('disabled', true);
                    $('#proveedor__id_edit_' + slug).prop('selectedIndex', 0).change();
                    $('#view_proveedor_id_edit_' + slug).hide();
                }
            });

        });
    </script>

    <script>
        
    </script>
@endsection