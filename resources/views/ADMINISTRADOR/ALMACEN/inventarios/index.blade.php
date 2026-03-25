@extends('TEMPLATES.administrador')

@section('title', 'INVENTARIOS')

@section('css')
<style>
    /* Asegurar que Select2 dropdown aparezca delante del modal */
    .select2-container--open .select2-dropdown {
        z-index: 2000 !important;
    }

    /* Scroll desde el 6to item en la lista de tipos por almacen */
    .tipo-producto-list.scroll-enabled {
        overflow-y: auto;
        padding-right: 4px;
        scrollbar-width: thin;
        scrollbar-color: #50bb30 #d9f2e3;
    }

    .tipo-producto-list.scroll-enabled::-webkit-scrollbar {
        width: 6px;
    }

    .tipo-producto-list.scroll-enabled::-webkit-scrollbar-track {
        background: #d9f2e3;
        border-radius: 10px;
    }

    .tipo-producto-list.scroll-enabled::-webkit-scrollbar-thumb {
        background: #50bb30;
        border-radius: 10px;
    }

    .tipo-producto-list.scroll-enabled::-webkit-scrollbar-thumb:hover {
        background: #50bb30;
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
                        
                        @foreach($sedes as $sede)
                            @php
                                $almacenes_por_tipos = DB::table('inventarios')->select('tipo_producto', DB::raw('SUM(cantidad) as cantidad'))->where('sede_id',$sede->id)->groupBy('tipo_producto')->get();
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
                                        <div class="tipo-producto-list" id="tipo_producto_list_{{$sede->id}}">
                                            @php
                                                $alm_tipos_sum = $almacenes_por_tipos->sum('cantidad');
                                            @endphp

                                            @foreach($almacenes_por_tipos as $almacenes_por_tipo)
                                            <div class="card mb-3 shadow-sm border-0 bg-light tipo-producto-item">
                                                <div class="card-body">
                                                    <div class="clearfix text-uppercase fw-bold">
                                                        <span class="float-start">
                                                            <button class="stretched-link text-uppercase text-dark fw-bold bg-transparent border-0 p-0 m-0" 
                                                                onclick="tipo_productos(this)" 
                                                                data-tipo-producto="{{$almacenes_por_tipo->tipo_producto}}" 
                                                                data-modal-id="showtipoproducto{{$sede->id}}_{{ \Illuminate\Support\Str::slug($almacenes_por_tipo->tipo_producto, '-') }}" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#showtipoproducto{{$sede->id}}_{{ \Illuminate\Support\Str::slug($almacenes_por_tipo->tipo_producto, '-') }}" 
                                                                data-id="areaalmacen">
                                                                {{$almacenes_por_tipo->tipo_producto}}
                                                            </button>
                                                        </span>
                                                        <span class="float-end">
                                                            {{-- Cantidad solo de este tipo --}}
                                                            {{ $almacenes_por_tipo->cantidad ? round($almacenes_por_tipo->cantidad, 2) : '0' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach

                                            {{-- Total de todos los tipos, fuera del foreach --}}
                                            <div class="text-end fw-bold mt-2">
                                                Total: {{ $alm_tipos_sum ? round($alm_tipos_sum, 2) : '0' }}
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
        @php
            $tipos_modal = DB::table('inventarios')
                ->select('tipo_producto')
                ->where('sede_id', $sede->id)
                ->groupBy('tipo_producto')
                ->get();
        @endphp
        @foreach($tipos_modal as $tipo_modal)
            @include('ADMINISTRADOR.ALMACEN.inventarios.showaccesorios', [
                'sede_id' => $sede->id,
                'tipo_producto' => $tipo_modal->tipo_producto,
            ])
        @endforeach
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
        function tipo_productos(el) {
            var y = $(el).data('tipo-producto');
            var modal = $('#' + $(el).data('modal-id'));
            var filas = modal.find('#inventario_table tr');
            var visibles = 0;

            modal.find('[id^="tipo_producto_modal"]').text(y);
            modal.find('[id^="tipo_producto_value"]').val(y);

            filas.each(function () {
                var tipoFila = $(this).data('tipo');
                if (tipoFila === y) {
                    $(this).show();
                    visibles++;
                } else {
                    $(this).hide();
                }
            });

                modal.find('[id^="total_registros_tipo"]').text(visibles);
                
         }
    </script>

    <script>
        $(document).ready(function () {
            $('.tipo-producto-list').each(function () {
                var $lista = $(this);
                var $items = $lista.find('.tipo-producto-item');

                if ($items.length > 5) {
                    var alturaVisible = 0;

                    $items.slice(0, 5).each(function () {
                        alturaVisible += $(this).outerHeight(true);
                    });

                    $lista.addClass('scroll-enabled');
                    $lista.css('max-height', alturaVisible + 'px');
                }
            });
        });
    </script>

    <script>
        $(document).ready(function(){
                $('#sede_id_value').on('change', function(){
                var valor_sede = $(this).val();
                $('#sede_id_val').val(valor_sede);
            });
        });
    </script>

    <script>
        function tipoproductodetalle(el, sedeId, productoId){
            console.log('compradetalle called:', { el: el, sedeId: sedeId, productoId: productoId });
        }
        function repuestosdetalle(el, sedeId, productoId){
            console.log('compradetalle called:', { el: el, sedeId: sedeId, productoId: productoId });
        }
        function modulosolardetalle(el, sedeId, productoId){
            console.log('compradetalle called:', { el: el, sedeId: sedeId, productoId: productoId });
        }
    </script>
@endsection