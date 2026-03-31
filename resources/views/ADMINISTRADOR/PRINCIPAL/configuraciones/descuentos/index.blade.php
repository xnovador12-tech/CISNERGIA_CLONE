@extends('TEMPLATES.administrador')

@section('title', 'DESCUENTOS')

@section('css')

@endsection
 
@section('content')
<!-- Encabezado -->
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">DESCUENTOS</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link"
                                href="{{ url('admin-configuraciones') }}">Configuraciones</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link"
                                href="{{ url('admin-descuentos') }}">Descuentos</a></li>
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
                <div class="row justify-content-beetween">
                    <div class="col-md-3 d-flex">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#createdescuento" class="btn btn-dark text-uppercase text-white btn-sm w-100">
                            <i class="bi bi-plus-circle-fill me-2"></i>
                            Nuevo Registro
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-2 col-12 col-md-6">
                    <span class="text-uppercase">Total de registros encontrados: <span class="fw-bold">{{ $admin_descuentos->count() }}</span></span>
                </div>
                <table id="" class="display table table-hover table-sm" cellspacing="0" style="width:100%">
                    <thead class="bg-dark text-white border-0">
                        <tr>
                            <th class="h6 small text-center text-uppercase fw-bold">N°</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Título</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Categoría</th>
                            <!-- <th class="h6 small text-center text-uppercase fw-bold">Curso</th> -->
                            <th class="h6 small text-center text-uppercase fw-bold">Fecha Inicio</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Fecha Fin</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Estado</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $contador = 1;
                        @endphp
                        @foreach($admin_descuentos as $admin_descuento)
                            <tr>
                                <td class="fw-normal text-center align-middle">{{ $contador }}</td>
                                <td class="fw-normal text-center align-middle">{{ $admin_descuento->titulo }}</td>
                                <td class="fw-normal text-center align-middle">{{ $admin_descuento->categorie->name }}</td>
                                <td class="fw-normal text-center align-middle">{{ $admin_descuento->fecha_inicio }}</td>
                                <td class="fw-normal text-center align-middle">{{ $admin_descuento->fecha_fin }}</td>
                                <td class="fw-normal align-middle">
                                    <form method="POST" action="/admin-descuentos/estado/{{$admin_descuento->slug}}" class="form-update">
                                    @csrf
                                    @method('PUT')
                                        @if($admin_descuento->estado == 'Activo')
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
                                                <button type="button" data-bs-toggle="modal" data-bs-target="#showdescuento{{$admin_descuento->slug}}" class="dropdown-item d-flex align-items-center"><i class="bi bi-eye text-secondary me-2"></i>Detalles</button>
                                            </li>
                                            <li>
                                                <button type="button" data-bs-toggle="modal" data-bs-target="#editdescuento{{$admin_descuento->slug}}" class="dropdown-item d-flex align-items-center"><i class="bi bi-pencil text-secondary me-2"></i>Editar</button>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form method="POST" action="{{ route('admin-descuentos.destroy',$admin_descuento->slug) }}" class="form-delete">
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
        @include('ADMINISTRADOR.PRINCIPAL.configuraciones.descuentos.create')
        @foreach($admin_descuentos as $admin_descuento)
            @include('ADMINISTRADOR.PRINCIPAL.configuraciones.descuentos.edit')
            @include('ADMINISTRADOR.PRINCIPAL.configuraciones.descuentos.show')            
        @endforeach
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
        $(document).ready(function(){

            // Select2
            $('#categoria_ids').select2({
                dropdownParent: $('#createdescuento'),
                placeholder: 'Seleccione una categoria',
                width: '100%'
            });

            // Sincronizar porcentaje y fechas con inputs hidden
            $('#porcentaje_id').on('input', function() {
                $("input[name='porcentaje[]']").val($(this).val());
            });

            $('#fecha__inicio__id, #hora__inicio__id').on('input', function() {
                $("input[name='fecha_inicios[]']").val(
                    $('#fecha__inicio__id').val() + ' ' + $('#hora__inicio__id').val()
                );
            });

            $('#fecha_fin_id, #hora__fin__id').on('input', function() {
                $("input[name='fecha_finales[]']").val(
                    $('#fecha_fin_id').val() + ' ' + $('#hora__fin__id').val()
                );
            });

            // Seleccionar todos
            $("#option-all").on("change", function(){
                $(".producto").prop('checked', $(this).prop('checked'));
            });

            // Cambio de categoría
            $('#categoria_ids').on('change', function(){
                $("#option-all").prop('checked', false);
                $(".producto").prop('checked', false);

                let categoria = $(this).val().split('_');
                $('#__categoria__').val(categoria[0]);

                if(categoria[0] != ''){
                    $.get('/descuentos_productos/filtro', {categoria_id: categoria[0]}, function(productos_){
                        $('#subc').html("");
                            $.each(productos_, function(index, value){
                                var todo = '';
                                todo += '<div class="col-12 col-md-6 col-lg-4 mb-3">';
                                todo +=   '<label for="producto1'+index+'" class="w-100 h-100" style="cursor:pointer">';
                                todo +=     '<div class="card shadow-sm h-100 producto-card" id="card'+index+'" style="border:2px solid #dee2e6; border-radius:10px; transition: all 0.2s ease;">';
                                todo +=       '<div class="card-body p-3">';
                                todo +=         '<div class="d-flex align-items-start gap-2">';
                                todo +=           '<input type="checkbox" class="form-check-input producto mt-1 flex-shrink-0" value="'+index+'" name="producto_id[]" id="producto1'+index+'" style="width:18px;height:18px;">';
                                todo +=           '<div class="flex-grow-1">';
                                todo +=             '<p class="fw-semibold mb-1 text-dark" style="font-size:0.85rem;line-height:1.3">'+value[0]+'</p>';
                                todo +=             '<span class="badge bg-success bg-opacity-10 text-success fw-bold" style="font-size:0.8rem;">S/ '+parseFloat(value[2]).toFixed(2)+'</span>';
                                todo +=           '</div>';
                                todo +=         '</div>';
                                todo +=       '</div>';
                                todo +=     '</div>';
                                todo +=   '</label>';
                                todo +=   '<input hidden value="'+value[2]+'" name="precio[]">';
                                todo +=   '<input hidden name="porcentaje[]">';
                                todo +=   '<input hidden name="fecha_inicios[]">';
                                todo +=   '<input hidden name="fecha_finales[]">';
                                todo +=   '<input hidden value="'+value[1]+'" name="codigo_producto[]">';
                                todo += '</div>';
                                $('#subc').append(todo);
                            });
                    });
                }
            });
        });
    </script>
@endsection