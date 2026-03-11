@extends('TEMPLATES.administrador')

@section('title', 'SALIDAS')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<!-- Encabezado -->
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">SALIDAS</h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none" href="">Almacén</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none" href="{{url('admin-salidas')}}">Salidas</a></li>
                        <li class="breadcrumb-item" aria-current="page">Nuevo registro</li>
                </div>
            </div>
        </div>
    </div>
<!-- fin encabezado -->

    {{-- contenido --}}
        <form method="POST" action="/admin-salidas" enctype="multipart/form-data" autocomplete="off" class="needs-validation" novalidate>      
            @csrf
            <div class="container-fluid">
                <div class="card border-4 borde-top-secondary shadow-sm h-100" style="border-radius: 20px; min-height: 500px" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
                    <div class="card-body">
                        <div class="card border-0 rounded-0 border-start border-3 border-info mb-4" style="box-shadow: rgba(17, 17, 26, 0.1) 0px 1px 0px; background-color: #f6f6f6">
                            <div class="card-body py-2">
                                <i class="bi bi-info-circle text-info me-2"></i>Importante:
                                <ul class="list-unstyled mb-0 pb-0">
                                    <li class="mb-0 pb-0">
                                        <small class="text-muted py-0 my-0 text-start"> Se consideran campos obligatorios los campos que tengan este simbolo: <span class="text-danger">*</small></span>
                                    </li>
                                </ul>
                            </div>
                        </div>  
                        <p class="text-primary mb-2 small text-uppercase fw-bold">Principal</p>
                        <div class="card mb-3 rounded-3">
                            <div class="card-body p-2">
                                <div class="row">
                                    <div class="col-12 col-md-3">
                                        <div class="text-center" style="font-size: 13px">
                                            <p class="text-uppercase fw-bold mb-0">
                                                Código
                                            </p>
                                            <span class="text-uppercase">{{ $codigo }}</span>
                                            <input type="text" name="codigo" value="{{ $codigo }}" hidden>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="text-center" style="font-size: 13px">
                                            <p class="text-uppercase fw-bold mb-0">
                                                Usuario
                                            </p>
                                            <span class="text-uppercase">{{ Auth::user()->persona->name.' '.Auth::user()->persona->surnames }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-3" style="font-size: 13px">
                                        <div class="text-center">
                                            <p class="text-uppercase fw-bold mb-0">
                                                Fecha
                                            </p>
                                            <span class="text-uppercase">{{ $fecha_actual->format('d-m-Y') }}</span>
                                            <input hidden name="fecha" value="{{ $fecha_actual->format('Y-m-d') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-12 col-md-3 col-lg-2">
                                <div class="mb-3">
                                    <label for="categoria_id" class=" d-block">Motivo<span class="text-danger">*</span></label>
                                    <select class="form-select form-select-sm @error ('motivo') is-invalid @enderror select2_bootstrap_2" required name="motivo" id="motivo_id" required>
                                        <option value="{{ old('motivo') }}" selected="selected" hidden="hidden">{{ old('motivo') }}</option>
                                        @foreach ($motivos as $motivo)
                                            @if($motivo->id == '2' || $motivo->id == '4' || $motivo->id == '5')
                                                <option value="{{ $motivo->name }}">{{ $motivo->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>  
                                    @error('motivo')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror  
                                </div>
                            </div>
                            <!-- <div class="col-12 col-md-6 col-lg-3" id="concepto_div">
                                <label for="Concepto_id" class=" d-block">Concepto<span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm @error ('Concepto_id') is-invalid @enderror" required name="concepto" id="Concepto_id" required>
                                    <option value="{{ old('concepto') }}" selected="selected" hidden="hidden">{{ old('concepto') }}</option>
                                        <option value="P_TERMINADO">PRODUCTO TERMINADO</option>
                                </select>  
                                @error('concepto')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror  
                            </div> -->
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="mb-3">
                                    <label for="codigo_id" class="">Sale de<span class="text-danger">*</span></label>
                                    <select class="form-select form-select-sm @error ('salida_de') is-invalid @enderror select2_bootstrap_2" required id="salida_de_id">
                                        <option value="{{ old('salida_de') }}" selected="selected" hidden="hidden">{{ old('salida_de') }}</option>
                                        @foreach ($almacen as $almacenes)
                                            <option @if($almacenes->id == 1) selected @endif value="{{ $almacenes->id }}">{{ $almacenes->name.' | '.$almacenes->sede->name }}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" name="id_almacen" hidden id="id_almacen_id">
                                    @error('salida_de')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror  
                                </div>
                            </div>
                                                        
                            <div class="col-12 col-md-3 col-lg-2" id="codventa_div">
                                <div class="mb-3">
                                    <label for="cventa_id" class=" d-block">Codigo de venta</label>
                                    <select class="form-select form-select-sm select2_bootstrap_2 w-100" name="cventa" id="cventa_id" style="width: 100%">
                                        <option value="{{ old('cventa') }}" selected="selected" hidden="hidden">{{ old('cventa') }}</option>
                                        @foreach ($venta as $ventas)
                                            <option value="{{ $ventas->id }}">{{ $ventas->codigo }}</option>
                                        @endforeach
                                    </select>
                                    @error('cventa')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    <input hidden name="id_venta" id="id_venta">  
                                </div>
                            </div>
                        </div>
                        <p class="text-primary mb-2 small text-uppercase fw-bold">Detalles</p>
                        <div class="row g-2">
                            <div class="col-6 col-md-4 col-lg-4 mb-3">
                                <label for="categoria_id" class=" d-block">Bienes</label>
                                <select class="form-select select2_bootstrap_2 form-select-sm w-100" id="bienes_id" >
                                </select>  
                            </div>
                            <div class="col-6 col-md-3 col-lg-1 mb-3">
                                <label for="lote__id" class=" d-block">Lote</label>
                                <select class="form-select select2_bootstrap_2 form-select-sm" id="lote_id">
                                </select>
                            </div>
                            <div class="col-6 col-md-3 col-lg-2 mb-3">
                                <label for="monto__id" class=" d-block">Cantidad</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" min="0" id="cantidad_id" class="float-end form-control form-control-sm">
                                    <span class="input-group-text" id="umedida_id">U.M.</span>
                                    <span class="input-group-text text-danger" id="cantidad_disponible_text">0</span>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 col-lg-2 mb-3">
                                <label for="monto__id" class=" d-block">Precio</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text" id="basic-addon1">S/</span>
                                    <input type="number" disabled step="0.05" min="0" id="precio_id" class="float-end form-control form-control-sm">
                                </div>
                            </div>
                            <!-- <div class="col-6 col-md-3 col-lg-2 mb-3">
                                <label for="fecha_vencimiento__id" class=" d-block">Fecha de vencimiento</label>
                                <input type="date" id="fecha_vencimiento_id" class="float-end form-control form-control-sm">
                            </div> -->
                            <div class="col-6 col-md-2 col-lg-2 mb-3 d-flex align-items-end">
                                <button type="button" id="btnasignar" class="btn btn-secondary btn-sm w-100 text-white" style="padding: 0.375rem 0.75rem;">
                                    Agregar
                                </button>
                            </div>
                        </div>
                        <table class=" table table-sm table-hover">
                            <thead class="bg-light">
                            <tr>
                                <th class="fw-bold small text-uppercase">N°</th>
                                <th class="fw-bold small text-uppercase">Tipo</th>
                                <th class="fw-bold small text-uppercase">Descripción</th>
                                <th class="fw-bold small text-uppercase">Lote</th>
                                <th class="fw-bold small text-uppercase">U.M.</th>
                                <th class="fw-bold small text-uppercase">Cantidad</th>
                                <th class="fw-bold small text-uppercase">Precio</th>
                                <!-- <th class="fw-bold small text-uppercase">F.V.</th> -->
                                <th class="fw-bold small text-uppercase"></th>
                            </tr>
                            </thead>
                            <tbody id="dtll_salida">
                                
                            </tbody>
                        </table>
                        
                        <div class="row justify-content-beetween mt-3">
                            <div class="col-12 col-md-5">
                                <label for="identificacion_id" class="">Observaciones<span class="text-danger">*</span></label>
                                <textarea name="descripcion" id="" class="form-control" cols="30" rows="5"></textarea>
                            </div>
                            <div class="col-2"></div>
                            <div class="col-12 col-md-5">
                                <table class="w-100">
                                    <tr>
                                        <td class="border-0 fw-bold ps-2 py-1 bg-light" style="width: 50%">
                                            TOTAL
                                        </td>
                                        <td class="border-0 fw-bold pe-2 py-1 bg-light" style="width: 50%">
                                            <div class="clearfix">
                                                <span class="float-start ps-2">- </span>
                                                <span class="float-end" id="total_id">
                                                    0
                                                </span>
                                            </div>
                                            <input hidden name="total" value="0" id="total_ids" required>
                                            @error('total')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-3 text-end" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
                    <a href="{{ url('admin-ingresos') }}" class="btn btn-outline-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary px-5 my-2 my-md-0 text-white">Registrar</button>
                </div>     
            </div> 
        </form>
    {{-- fin contenido --}}

@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2_bootstrap_2').select2();
    });
</script>
<script>

$('#concepto_div').hide();
$('#codventa_div').hide();

$(document).ready(function() {

    function syncAlmacenId() {
        $('#id_almacen_id').val($('#salida_de_id').val());
    }

    // Carga inicial: toma el option seleccionado por defecto
    syncAlmacenId();

    // Mantiene sincronizado cuando cambie el select
    $('#salida_de_id').on('change', syncAlmacenId);

    $('#motivo_id').on('change', function(){
        valormotivo = $(this).val();

        if(valormotivo == 'Venta'){
            $('#codventa_div').show();
            $('#cventa_id').attr('disabled',false);
        }

        if(valormotivo == 'Merma' || valormotivo == 'Robo o perdida'){
            $('#cventa_id').attr('disabled',true);
            $('#codventa_div').hide();
            valor_almacen = $('#salida_de_id').val();
            console.log(valormotivo, valor_almacen);
            $.get('/busqueda_producto_inventario', {valormotivo: valormotivo, valor_almacen: valor_almacen}, function(productos){
                $('#bienes_id').empty();
                $('#bienes_id').append("<option selected='selected' hidden='hidden'>-- Seleccione --</option>");
                $.each(productos, function(index, value){
                    $('#bienes_id').append("<option value='"+index+'_'+value[0]+'_'+value[1]+'_'+value[2]+'_'+value[3]+'_'+value[4]+'_'+value[5]+'_'+value[6]+'_'+value[7]+"'>"+value[1]+"</option>");
                });
            });
        }
    });

    $('#cventa_id').on('change', function(){
        valor_venta = $(this).val();
        valor_almacen = $('#salida_de_id').val();
        $('#id_venta').val(valor_venta);
        $.get('/busqueda_producto_inventario', {valormotivo: valormotivo, valor_almacen: valor_almacen,valor_venta:valor_venta}, function(productos){
            $('#bienes_id').empty();
            $('#bienes_id').append("<option selected='selected' hidden='hidden'>-- Seleccione --</option>");
            $.each(productos, function(index, value){
                $('#bienes_id').append("<option value='"+index+'_'+value[0]+'_'+value[1]+'_'+value[2]+'_'+value[3]+'_'+value[4]+'_'+value[5]+'_'+value[6]+'_'+value[7]+"'>"+value[1]+"</option>");
            });
        });
    });
    
    $('#bienes_id').on('change', function(){
        var valor_producto = document.getElementById('bienes_id').value.split('_');
        valormotivo = $('#motivo_id').val();
        valor_almacen = $('#salida_de_id').val();
        console.log(valor_producto[2], valormotivo, valor_almacen);
        $.get('/busqueda_lotes', {valor_id_producto:valor_producto[3], valormotivo:valormotivo, valor_almacen:valor_almacen}, function(productos){
            $('#lote_id').empty();
            $('#lote_id').append("<option selected='selected' hidden='hidden'>-- Seleccione --</option>");
            $('#umedida_id').html('U.M.');
            $('#cantidad_id').val("");
            $('#precio_id').val("");
            $.each(productos, function(index, value){
                $('#lote_id').append("<option value='"+value[0]+'_'+value[1]+'_'+value[2]+'_'+value[3]+"'>"+value[0]+"</option>");
            });
        });
    });

    $('#lote_id').on('change', function(){
        valor_lotes = document.getElementById('lote_id').value.split('_');
        if(valor_lotes){
            $('#umedida_id').html(valor_lotes[1]);
            $('#cantidad_id').val('');
            $('#cantidad_disponible_text').html(valor_lotes[2]);
            $('#precio_id').val(valor_lotes[3]);
        }
    });

});
        var contador_mps = 1;
        var cont = 0;
        cantidad_totalma=0;
        cantidades_tma=[];
        cantidad_totalac=0;
        cantidades_tac=[];
        cantidad_totalpt=0;
        cantidades_tpt=[];
        cantidad_totalg=0;
        cantidad_totalglobal=[];
        cantidad_totalal=0;
        var tipo_b;
        $('#btnasignar').click(function() {
                var producto = document.getElementById('bienes_id').value.split('_');
                var lote = document.getElementById('lote_id').value.split('_');
                var cantidad = Number($('#cantidad_id').val() || 0);
                var precio = Number($('#precio_id').val() || 0);
                    valormotivo = $('#motivo_id').val();
                var cantidad_disponible = Number(lote[2] || 0);
                
                if (producto != "" && cantidad > 0 && cantidad <= cantidad_disponible && precio > 0) {
                            cantidad_totalg = Number(cantidad_totalg) + cantidad;
                            var fila = '<tr class="selected igv_carta" id="filamp' + contador_mps +
                                '"><td class="align-middle fw-normal">' + contador_mps + '</td><td class="align-middle fw-normal">' + producto[7] +
                                '</td><td class="align-middle fw-normal">' + producto[2] +
                                '</td><td class="align-middle fw-normal">'+lote[0]+'</td><td class="align-middle fw-normal">' + lote[1] +
                                '</td><td class="align-middle fw-normal">'+cantidad+'</td><td class="align-middle fw-normal">' + precio +
                                '</td><td><input type="hidden" name="producto_id[]" value="' + producto[0] +
                                '"><input type="hidden" name="producto_tipo_id[]" value="' + producto[7] +
                                '"><input type="hidden" name="producto[]" value="' + producto[2] +
                                '"><input type="hidden" class="form-control form-control-sm w-50" required name="lote[]" value="'+lote[0]+'"><input type="hidden" name="medida[]" value="' + lote[1] +
                                '"><input type="hidden" class="form-control form-control-sm w-50" required name="cantidad[]" value="' + cantidad +
                                '"><input type="hidden" name="precio[]" value="' + precio +
                                '"></td><td class="align-middle text-center"><button type="button" class="btn btn-sm btn-danger" onclick="eliminardtc(' + contador_mps +','+cantidad+',\'' +producto[2]+ '\');"><i class="bi bi-trash"></i></button></td></tr>';
                        contador_mps++;
                        cont++;
                        $('#bienes_id').prop('selectedIndex', 0).change();
                        $('#cantidad_id').val("");
                        $('#precio_id').val("");
                        $('#lote_id').val("");
                        $('#umedida_id').html('U.M.');
                        $('#cantidad_recepcionada_id').val("");
                        $('#total_id').html(cantidad_totalg);
                        $('#total_ids').val(cantidad_totalg);
                        $('#dtll_salida').append(fila);
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Error al ingresar el detalle del movimiento, revise los datos de lo solicitado',
                    })
                }
        });
        function eliminardtc(indexmp, cantidad,protipo_id) {
            cantidad = Number(cantidad || 0);
            cantidad_totalg=cantidad_totalg+cantidad;
            //tproductos = tproductos - cantidades[indexmp];
            $('#total_id').html(cantidad_totalg);
            $('#total_ids').val(cantidad_totalg);
            //$("#tproductos").html(+tproductos);
            //$("#total_product").val(tproductos);
            $("#filamp" + indexmp).remove();
        }
</script>
@endsection