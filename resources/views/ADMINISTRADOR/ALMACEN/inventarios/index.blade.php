@extends('TEMPLATES.administrador')

@section('title', 'INVENTARIOS')

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
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">INVENTARIOS</h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ url('admin-inventarios') }}">Inventarios</a></li>
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
            <div class="card-body">
                <div class="card-body">
                    <div class="mb-2">
                        <span class="text-uppercase">Total de registros encontrados: <span class="fw-bold">{{$sedes->count()}}</span></span>
                    </div>
                    <div class="row">
                        @php
                            $alm_accesorios_sum = 0;
                            $alm_repuestos_sum = 0;
                            $alm_modulo_solar_sum = 0;
                        @endphp
                        @foreach($sedes as $sede)
                            @php
                                $almacenes_accesorios = App\Models\Inventario::where('tipo_producto','Accesorios')->where('sede_id',$sede->id)->get();
                                foreach($almacenes_accesorios as $almacenes_accesorio){
                                    $alm_accesorios_sum = $alm_accesorios_sum+($almacenes_accesorio?$almacenes_accesorio->cantidad:'0');
                                }
                                $almacenes_repuestos = App\Models\Inventario::where('tipo_producto','Repuestos')->where('sede_id',$sede->id)->get();
                                foreach($almacenes_repuestos as $almacenes_repuesto){
                                    $alm_repuestos_sum = $alm_repuestos_sum+($almacenes_repuesto?$almacenes_repuesto->cantidad:'0');
                                }
                                $almacenes_modulo_solar = App\Models\Inventario::where('tipo_producto','Modulo Solar')->where('sede_id',$sede->id)->get();
                                foreach($almacenes_modulo_solar as $almacenes_modulo_solar_item){
                                    $alm_modulo_solar_sum = $alm_modulo_solar_sum+($almacenes_modulo_solar_item?$almacenes_modulo_solar_item->cantidad:'0');
                                }
                            @endphp
                            <div class="col-12 col-md-4 col-xl-3">
                                <div class="card border-3 borde-top-primary box-shadow">
                                    <div class="card-body pb-0 mb-0">
                                        <div class="row pb-2 mb-3">
                                            <img src="/images/panl_solar.png" class="img-fluid" style="height: 100px;" alt="">
                                        </div>
                                        <div class="row pb-2 mb-3">
                                            <div class="align-self-center bg-primary text-center">
                                                <small class="fw-bold text-white">ALMACEN</small>
                                                <p class="mb-0 fw-bold text-uppercase text-white">{{ $sede->name }}</p>
                                            </div>
                                        </div>
                                        <div class="card mb-3 shadow-sm border-0 bg-light">
                                            <div class="card-body">
                                                <div class="clearfix text-uppercase fw-bold">
                                                    <span class="float-start">
                                                        <button class="stretched-link text-uppercase text-dark fw-bold bg-transparent border-0 p-0 m-0" onclick="accesorio({{$sede->id}})" data-bs-toggle="modal" data-bs-target="#showaccesorios{{$sede->id}}" data-id="areaalmacen" >Accesorios</button>
                                                    </span>
                                                    <span class="float-end">
                                                        {{$alm_accesorios_sum?round($alm_accesorios_sum, 2):'0'}}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card mb-3 shadow-sm border-0 bg-light">
                                            <div class="card-body">
                                                <div class="clearfix text-uppercase fw-bold">
                                                    <span class="float-start">
                                                        <button class="stretched-link text-uppercase text-dark fw-bold bg-transparent border-0 p-0 m-0" onclick="repuestos({{$sede->id}})" data-bs-toggle="modal" data-bs-target="#showrepuestos{{$sede->id}}" data-id="areaalmacen" >Repuestos</button>
                                                    </span>
                                                    <span class="float-end">
                                                        {{$alm_repuestos_sum?round($alm_repuestos_sum, 2):'0'}}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card mb-3 shadow-sm border-0 bg-light">
                                            <div class="card-body">
                                                <div class="clearfix text-uppercase fw-bold">
                                                    <span class="float-start">
                                                        <button class="stretched-link text-uppercase text-dark fw-bold bg-transparent border-0 p-0 m-0" onclick="modulo_solar({{$sede->id}})" data-bs-toggle="modal" data-bs-target="#showmodulo_solar{{$sede->id}}" data-id="modulo_solar" >Modulo Solar</button>
                                                    </span>
                                                    <span class="float-end">
                                                        {{$alm_modulo_solar_sum?$alm_modulo_solar_sum:'0'}}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
{{-- Fin contenido --}}
    @foreach($sedes as $sede)
        @include('ADMINISTRADOR.ALMACEN.inventarios.show_dtlleaccesorios', ['sede_id' => $sede->id])
        @include('ADMINISTRADOR.ALMACEN.inventarios.show_dtllerepuesto', ['sede_id' => $sede->id])
        @include('ADMINISTRADOR.ALMACEN.inventarios.show_dtllemodulo_solar', ['sede_id' => $sede->id])
    @endforeach
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
        function accesorios(x) {
            $filtro_inventario = $('#tipo_accesorios'+x).val();
            $('#filtro_tipo').val($filtro_inventario);
            $('#filtro_tipo').val('accesorios_request');
            $('#filtro_tipo_total').val('accesorios_request');
            
            $('#filtro_tipo'+x).val('accesorios_request');
            $('#filtro_tipo_total'+x).val('accesorios_request');
            console.log($filtro_inventario);
            
            $('#sede_id_value'+x).on('change', function(){
                var valor_sede = $(this).val();
                $('#sede_id_val'+x).val(valor_sede);
            });
                
         }
        function ptermina(x) {
            $filtro_inventario = $('#tipo_almacenes'+x).val();
            $('#filtro_tipo').val($filtro_inventario);
            $('#filtro_tipo').val('pterminado_request');
            $('#filtro_tipo_total').val('pterminado_request');
            
            $('#filtro_tipo'+x).val('pterminado_request');
            $('#filtro_tipo_total'+x).val('pterminado_request');
            console.log($filtro_inventario);
            
            $('#sede_id_value'+x).on('change', function(){
                var valor_sede = $(this).val();
                $('#sede_id_val'+x).val(valor_sede);
            });
         }
         function merma(x) {
            $filtro_inventario = $('#tipo_merma'+x).val();
            $('#filtro_tipo').val($filtro_inventario);
            $('#filtro_tipo').val('merma_request');
            $('#filtro_tipo_total').val('merma_request');
            
            $('#filtro_tipo'+x).val('merma_request');
            $('#filtro_tipo_total'+x).val('merma_request');
            console.log($filtro_inventario);
            
            $('#sede_id_value'+x).on('change', function(){
                var valor_sede = $(this).val();
                $('#sede_id_val'+x).val(valor_sede);
            });
         }
         function devolucion(x) {
            $filtro_inventario = $('#tipo_devo'+x).val();
            $('#filtro_tipo').val($filtro_inventario);
            $('#filtro_tipo').val('devolucion_request');
            $('#filtro_tipo_total').val('devolucion_request');
            
            $('#filtro_tipo'+x).val('devolucion_request');
            $('#filtro_tipo_total'+x).val('devolucion_request');
            console.log($filtro_inventario);
            
            $('#sede_id_value'+x).on('change', function(){
                var valor_sede = $(this).val();
                $('#sede_id_val'+x).val(valor_sede);
            });
         }
    </script>

    <script>
        $(document).ready(function(){
                $('#sede_id_value').on('change', function(){
                var valor_sede = $(this).val();
                $('#sede_id_val').val(valor_sede);
            });
        });
    </script>
@endsection