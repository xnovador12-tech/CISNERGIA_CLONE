@extends('TEMPLATES.administrador')

@section('title', 'INGRESOS')

@section('css')
@endsection

@section('content')
<!-- Encabezado -->
<div class="header_section">
    <div class="bg-transparent" style="height: 57px"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9">
                <h1 class="text-white h2 text-uppercase fw-bold mb-0"> INGRESOS</h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link-light" href="">Almacén</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link-light" href="{{url('admin-ingresos')}}">Ingresos</a></li>
                        <li class="breadcrumb-item text-white" aria-current="page">Nuevo registro</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-3 d-flex">
                
            </div>
        </div>
    </div>
</div>
<!-- fin encabezado -->

    {{-- contenido --}}
        <form method="POST" action="/admin-ingresos" enctype="multipart/form-data" autocomplete="off" class="needs-validation" novalidate>      
            @csrf
            <div class="container-fluid">
                <div class="card border-4 borde-top-secondary shadow-sm mb-3" style="margin-top: -80px" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
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
                                            <!-- <span class="text-uppercase">{{ Auth::user()->persona->name.' '.Auth::user()->persona->lastname_padre.' '.Auth::user()->persona->lastname_madre }}</span> -->
                                             <span class="text-uppercase">cesar</span>
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
                                    <select class="form-select form-select-sm @error ('motivo') is-invalid @enderror" required name="motivo" id="motivo_id" required>
                                        <option value="{{ old('motivo') }}" selected="selected" hidden="hidden">{{ old('motivo') }}</option>
                                        @foreach ($motivos as $motivo)
                                            @if($motivo->id == '1')
                                                <option value="{{ $motivo->name }}">{{ $motivo->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>  
                                    @error('motivo')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror  
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="mb-3">
                                    <label for="codigo_id" class="">Ingresa a<span class="text-danger">*</span></label>
                                    <select class="form-select form-select-sm @error ('ingreso_a') is-invalid @enderror" required id="ingresoa_id">
                                        <option value="{{ old('ingreso_a') }}" selected="selected" hidden="hidden">{{ old('ingreso_a') }}</option>
                                        @foreach ($almacen as $almacenes)
                                            <option value="{{ $almacenes->name.' | '.$almacenes->sede->name }}_{{ $almacenes->id }}_{{ $almacenes->clasificacion }}">{{ $almacenes->name.' | '.$almacenes->sede->name }}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" name="ingreso_a"  hidden id="ingreso_a_id">
                                    <input type="text" name="id_almacen"  hidden id="id_almacen_id">
                                    @error('ingreso_a')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror  
                                </div>
                            </div>
                                                        
                            <div class="col-12 col-md-3 col-lg-2" id="mostrar_selects">
                                <div class="mb-3" id="showcompra">
                                    <label for="categoria_id" class=" d-block">Órden de compra</label>
                                    <select class="form-select form-select-sm select2" name="ocompra" id="ocompra_id" style="width: 100%">
                                        <option value="{{ old('ocompra') }}" selected="selected" hidden="hidden">{{ old('ocompra') }}</option>
                                        @foreach ($ocompra as $ocompras)
                                                <option value="{{ $ocompras->codigo }}">{{ $ocompras->codigo }}</option>
                                        @endforeach
                                    </select>
                                    @error('ocompra')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    <input hidden name="codigo_ocompra" id="codigo_ocompra_id">  
                                </div>
                            </div>
                        </div>
                        <p class="text-primary mb-2 small text-uppercase fw-bold">Detalles</p>
                        <div class="row g-2">
                            <div class="col-6 col-md-4 col-lg-4 mb-3">
                                <label for="categoria_id" class=" d-block">Bienes</label>
                                <select class="form-select select2 form-select-sm" id="bienes_id" >
                                </select>  
                            </div>
                            <div class="col-6 col-md-3 col-lg-1 mb-3">
                                <label for="lote__id" class=" d-block">Lote</label>
                                <input type="text" class="form-control form-control-sm bg-white" id="lote_id">
                            </div>
                            <div class="col-6 col-md-3 col-lg-2 mb-3">
                                <label for="monto__id" class=" d-block">Cantidad</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" min="0" id="cantidad_id" class="float-end form-control form-control-sm">
                                    <span class="input-group-text" id="basic-addon1">U.M.</span>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 col-lg-2 mb-3">
                                <label for="monto__id" class=" d-block">Precio</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text" id="basic-addon1">S/</span>
                                    <input type="number" step="0.05" min="0" id="precio_id" class="float-end form-control form-control-sm">
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
                            <tbody id="dtll_ingreso">
                                
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
                                        <td class="border-0 ps-2 py-1" style="width: 50%">
                                            Total Materiales
                                        </td>
                                        <td class="border-0 pe-2 py-1" style="width: 50%">
                                            <div class="clearfix">
                                                <span class="float-start ps-2">- </span>
                                                <span class="float-end" id="tmaterial">
                                                    0
                                                </span>
                                                <input hidden name="total_mat" id="tmaterial_id">
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="border-0 ps-2 py-1 bg-light" style="width: 50%">
                                            Total Activos
                                        </td>
                                        <td class="border-0 pe-2 py-1 bg-light" style="width: 50%">
                                            <div class="clearfix">
                                                <span class="float-start ps-2">- </span>
                                                <span class="float-end" id="tactivo">
                                                    0
                                                </span>
                                                 <input hidden name="total_act" id="tactivo_id">
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="border-0 ps-2 py-1" style="width: 50%">
                                            Total Productos terminados
                                        </td>
                                        <td class="border-0 pe-2 py-1" style="width: 50%">
                                            <div class="clearfix">
                                                <span class="float-start ps-2">- </span>
                                                <span class="float-end" id="tprot">
                                                    0
                                                </span>
                                            </div>
                                            <input hidden name="total_pte" id="tprot_id">
                                        </td>
                                    </tr>

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
                                            <input hidden name="total" id="total_ids" required>
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
                <div class="pb-3 text-end" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
                    <a href="{{ url('admin-ingresos') }}" class="btn btn-outline-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary px-5 my-2 my-md-0 text-white">Registrar</button>
                </div>     
            </div> 
        </form>
    {{-- fin contenido --}}

@endsection

@section('js')
<script>
$('#showcompra').hide();
$('#mostrar_selects').hide();

$(document).ready(function() {

    $('#motivo_id').on('change', function(){
        valormotivo = $(this).val();
        
        if(valormotivo == 'Inventario'){
            $('#showcompra').show();
            $('#mostrar_selects').show();
        }
        
        $.get('/busqueda_valormotivo', {codigo_motivo:valormotivo}, function(productos){
            $('#ingresoa_id').empty();
            $('#ingresoa_id').append("<option selected='selected' hidden='hidden'>-- Seleccione --</option>");
            $.each(productos, function(index, value){
                $('#ingresoa_id').append("<option value='"+value[0]+'_'+index+'_'+value[1]+"'>"+value[0]+"</option>");
            });
        });
    });

    $('#ocompra_id').on('change', function(){
        $('#ocompra_id').attr('disabled',true);
        var codigo_orden = document.getElementById('ocompra_id').value.split('_');
        $('#codigo_ocompra_id').val(codigo_orden[0]);
        $.get('/busqueda_dtll_oc', {codigo_orden:codigo_orden[0]}, function(productos){
            $('#bienes_id').empty();
            $('#bienes_id').append("<option selected='selected' hidden='hidden'>-- Seleccione --</option>");
            $.each(productos, function(index, value){
                $('#bienes_id').append("<option value='"+index+'_'+value[0]+'_'+value[1]+'_'+value[2]+'_'+value[3]+'_'+value[4]+'_'+value[5]+'_'+value[6]+"'>"+value[1]+"</option>");
            
            
                var producto = document.getElementById('bienes_id').value.split('_');
                valormotivo = $('#motivo_id').val();
                if (producto != "") {
                    if(valormotivo == 'Inventario'){
                        if(value[2] == 'Materiales'){
                            tipo_b = 'Materiales';
                            cantidades_tma[contador_mps]= null; 
                            cantidades_tma[contador_mps]=Number(value[4])
                            cantidad_totalma=cantidad_totalma+cantidades_tma[contador_mps];
                        }if(value[2] == 'Activos'){
                            tipo_b = 'Activos';
                            cantidades_tac[contador_mps]= null; 
                            cantidades_tac[contador_mps]=Number(value[4])
                            cantidad_totalac=cantidad_totalac+cantidades_tac[contador_mps];
                        }
                            cantidad_totalg=cantidad_totalma+cantidad_totalac;
                                var fila = '<tr class="selected igv_carta" id="filamp' + contador_mps +
                                    '"><td class="align-middle fw-normal">' + contador_mps + '</td><td class="align-middle fw-normal">' + tipo_b +
                                    '</td><td class="align-middle fw-normal">' + value[1] +
                                    '</td><td class="align-middle fw-normal"><input type="text" class="form-control form-control-sm w-50" required name="lote[]" ></td><td class="align-middle fw-normal">' + value[3] +
                                    '</td><td class="align-middle fw-normal"><input type="text" class="form-control form-control-sm w-50" required name="cantidad[]" value="' + value[4] +
                                    '"></td><td class="align-middle fw-normal">' + value[5] +
                                    '</td><td class="align-middle fw-normal"><input type="date" class="form-control form-control-sm" name="fechas[]" ></td><input type="hidden" name="producto_id[]" value="' + value[0] +
                                    '"><input type="hidden" name="producto_tipo_id[]" value="' + value[2] +
                                    '"><input type="hidden" name="producto[]" value="' + value[1] +
                                    '"><input type="hidden" name="medida[]" value="' + value[3] +
                                    '"><input type="hidden" name="precio[]" value="' + value[5] +
                                    '"><td class="align-middle"><button type="button" class="btn btn-sm btn-danger" onclick="eliminardtc(' +
                            contador_mps +','+value[4]+','+value[2]+');"><i class="bi bi-trash"></i></button></td></tr>';
                            contador_mps++;
                            cont++;
                            if(value[2] == 'Materiales'){
                                $("#tmaterial").html(cantidad_totalma);
                                $("#tmaterial_id").val(cantidad_totalma);
                            }if(value[2] == 'Activos'){
                                $("#tactivo").html(cantidad_totalac);
                                $("#tactivo_id").val(cantidad_totalac);
                            }
                            $('#bienes_id').prop('selectedIndex', 0).change();
                            $('#cantidad_id').val("");
                            $('#precio_id').val("");
                            $('#lote_id').val("");
                            // $('#fecha_vencimiento_id').val("");
                            $('#total_id').html(cantidad_totalg);
                            $('#total_ids').val(cantidad_totalg);
                            $('#dtll_ingreso').append(fila);
                        
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Error al ingresar el detalle del ingreso, revise los datos del requerimiento',
                        })
                    }
                }
            
            });
        });
    });

    $('#bienes_id').on('change', function(){
        var select_oc = document.getElementById('bienes_id').value.split('_');
        valormotivo = $('#motivo_id').val();
        if(valormotivo == 'Inventario'){
            $('#cantidad_id').val(select_oc[7]);
            $('#precio_id').val(select_oc[6]);
        }if(valormotivo == 'Produccion'){
            $('#lote_id').val(select_oc[8]);
            $('#cantidad_id').val(select_oc[6]);
            $('#precio_id').val(select_oc[9]);
            $('#fecha_vencimiento_id').val(select_oc[7]);
        }if(valormotivo == 'Devolucion por Produccion'){
            $('#lote_id').val(select_oc[6]);
            $('#cantidad_id').val(select_oc[5]);
            $('#precio_id').attr('disabled',true);
            $('#fecha_vencimiento_id').attr('disabled',true);
        }
            
    });

    $('#ingresoa_id').on('change', function(){
        var valor_ingresoa = document.getElementById('ingresoa_id').value.split('_');
        $('#ingreso_a_id').val(valor_ingresoa[0]);
        $('#id_almacen_id').val(valor_ingresoa[1]);
        
        /*if(valor_ingresoa[2] == 'Compras'){
            $('#motivo_id').empty();
            $('#motivo_id').append("<option selected='selected' hidden='hidden'>-- Seleccione --</option>");
            $('#motivo_id').append("<option value='Inventario'>Inventario</option>");
        }if(valor_ingresoa[2] == 'Producto Terminado'){
            $('#motivo_id').empty();
            $('#motivo_id').append("<option selected='selected' hidden='hidden'>-- Seleccione --</option>");
            $('#motivo_id').append("<option value='Produccion'>Produccion</option>");
        }if(valor_ingresoa[2] == 'Merma'){
            $('#motivo_id').empty();
            $('#motivo_id').append("<option selected='selected' hidden='hidden'>-- Seleccione --</option>");
            //$('#motivo_id').append("<option value='Merma'>Merma</option>");
            $('#motivo_id').append("<option value='Devolucion por Produccion'>Devolucion por Produccion</option>");
        }if(valor_ingresoa[2] == 'Devolucion de Venta'){
            $('#motivo_id').empty();
            $('#motivo_id').append("<option selected='selected' hidden='hidden'>-- Seleccione --</option>");
            $('#motivo_id').append("<option value='Devolucion de Venta'>Devolucion de Venta</option>");
        }*/
    });

});
        var contador_mps = 1;
        var cont = 0;
        cantidad_totalmp=0;
        cantidades_tmp=[];
        cantidad_totalma=0;
        cantidades_tma=[];
        cantidad_totalac=0;
        cantidades_tac=[];
        cantidad_totalal=0;
        cantidades_tal=[];
        cantidad_totalcoc=0;
        cantidades_tco=[];
        cantidad_totalg=0;
        cantidad_totalglobal=[];
        var tipo_b;
        $('#btnasignar').click(function() {
                if(valormotivo == 'Inventario'){
                    var producto = document.getElementById('bienes_id').value.split('_');
                    var lote = $('#lote_id').val();
                    var cantidad = $('#cantidad_id').val();
                    var precio = $('#precio_id').val();
                    var fecha = $('#fecha_vencimiento_id').val();
                    valormotivo = $('#motivo_id').val();
                    
                    if (producto != "" && fecha != "" && cantidad > 0 && precio > 0) {
                        if(producto[3] == '1'){
                            tipo_b = 'Materia Prima';
                            cantidades_tmp[contador_mps]=Number(cantidad);
                            cantidad_totalmp+=cantidades_tmp[contador_mps];
                        }if(producto[3] == '2'){
                            tipo_b = 'Materiales';
                            cantidades_tma[contador_mps]= null; 
                            cantidades_tma[contador_mps]=Number(cantidad)
                            cantidad_totalma=cantidad_totalma+cantidades_tma[contador_mps];
                            console.log(cantidad_totalma);
                        }if(producto[3] == '3'){
                            tipo_b = 'Activos';
                            cantidades_tac[contador_mps]= null; 
                            cantidades_tac[contador_mps]=Number(cantidad)
                            cantidad_totalac=cantidad_totalac+cantidades_tac[contador_mps];
                        }if(producto[3] == '4'){
                            tipo_b = 'Alimentos';
                            cantidades_tal[contador_mps]= null; 
                            cantidades_tal[contador_mps]=Number(cantidad)
                            cantidad_totalal=cantidad_totalal+cantidades_tal[contador_mps];
                        }if(producto[3] == '5'){
                            tipo_b = 'Cosmeticos';
                            cantidades_tco[contador_mps]= null; 
                            cantidades_tco[contador_mps]=Number(cantidad)
                            cantidad_totalcoc=cantidad_totalcoc+cantidades_tco[contador_mps];
                        }
                            cantidad_totalg=cantidad_totalmp+cantidad_totalma+cantidad_totalac+cantidad_totalal+cantidad_totalcoc;
                                var fila = '<tr class="selected igv_carta" id="filamp' + contador_mps +
                                    '"><td class="align-middle fw-normal">' + contador_mps + '</td><td class="align-middle fw-normal">' + tipo_b +
                                    '</td><td class="align-middle fw-normal">' + producto[2] +
                                    '</td><td class="align-middle fw-normal">' + lote +
                                    '</td><td class="align-middle fw-normal">' + producto[4] +
                                    '</td><td class="align-middle fw-normal">' + cantidad +
                                    '</td><td class="align-middle fw-normal">' + producto[6] +
                                    '</td><td class="align-middle fw-normal">' + fecha +
                                    '</td><input type="hidden" name="producto_id[]" value="' + producto[1] +
                                    '"><input type="hidden" name="producto_tipo_id[]" value="' + producto[3] +
                                    '"><input type="hidden" name="producto[]" value="' + producto[2] +
                                    '"><input type="hidden" name="lote[]" value="' + lote +
                                    '"><input type="hidden" name="medida[]" value="' + producto[4] +
                                    '"><input type="hidden" name="cantidad[]" value="' + cantidad +
                                    '"><input type="hidden" name="precio[]" value="' + producto[6] +
                                    '"><input type="hidden" name="fechas[]" value="' + fecha +
                                    '"><td class="align-middle"><button type="button" class="btn btn-sm btn-danger" onclick="eliminardtc(' +
                            contador_mps +','+cantidad+','+producto[3]+');"><i class="bi bi-trash"></i></button></td></tr>';
                            contador_mps++;
                            cont++;
                            if(producto[3] == '1'){
                                $("#tprima").html(cantidad_totalmp);
                                $("#tprima_id").val(cantidad_totalmp);
                            }if(producto[3] == '2'){
                                $("#tmaterial").html(cantidad_totalma);
                                $("#tmaterial_id").val(cantidad_totalma);
                            }if(producto[3] == '3'){
                                $("#tactivo").html(cantidad_totalac);
                                $("#tactivo_id").val(cantidad_totalac);
                            }
                            if(producto[3] == '4' || producto[3] == '5'){
                                $("#tprot").html(cantidad_totalal+cantidad_totalcoc);
                                $("#tprot_id").val(cantidad_totalal+cantidad_totalcoc);
                            }
                            $('#bienes_id').prop('selectedIndex', 0).change();
                            $('#cantidad_id').val("");
                            $('#precio_id').val("");
                            $('#lote_id').val("");
                            $('#fecha_vencimiento_id').val("");
                            $('#total_id').html(cantidad_totalg);
                            $('#total_ids').val(cantidad_totalg);
                            $('#dtll_ingreso').append(fila);
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Error al ingresar el detalle del ingreso, revise los datos del requerimiento',
                        })
                    }
                }else if(valormotivo == 'Devolucion por Produccion'){
                    var producto = document.getElementById('bienes_id').value.split('_');
                    var lote = $('#lote_id').val();
                    var cantidad = $('#cantidad_id').val();
                    var precio = $('#precio_id').val();
                    var fecha = $('#fecha_vencimiento_id').val();
                    valormotivo = $('#motivo_id').val();
                    if (producto != "" && cantidad > 0 ) {

                    if(producto[3] == '1'){
                        tipo_b = 'Materia Prima';
                        cantidades_tmp[contador_mps]=Number(cantidad);
                        cantidad_totalmp+=cantidades_tmp[contador_mps];
                    }if(producto[3] == '2'){
                        tipo_b = 'Materiales';
                        cantidades_tma[contador_mps]= null; 
                        cantidades_tma[contador_mps]=Number(cantidad)
                        cantidad_totalma=cantidad_totalma+cantidades_tma[contador_mps];
                        console.log(cantidad_totalma);
                    }if(producto[3] == '3'){
                        tipo_b = 'Activos';
                        cantidades_tac[contador_mps]= null; 
                        cantidades_tac[contador_mps]=Number(cantidad)
                        cantidad_totalac=cantidad_totalac+cantidades_tac[contador_mps];
                    }if(producto[3] == '4'){
                        tipo_b = 'Alimentos';
                        cantidades_tal[contador_mps]= null; 
                        cantidades_tal[contador_mps]=Number(cantidad)
                        cantidad_totalal=cantidad_totalal+cantidades_tal[contador_mps];
                    }if(producto[3] == '5'){
                        tipo_b = 'Cosmeticos';
                        cantidades_tco[contador_mps]= null; 
                        cantidades_tco[contador_mps]=Number(cantidad)
                        cantidad_totalcoc=cantidad_totalcoc+cantidades_tco[contador_mps];
                    }
                        cantidad_totalg=cantidad_totalmp+cantidad_totalma+cantidad_totalac+cantidad_totalal+cantidad_totalcoc;
                            var fila = '<tr class="selected igv_carta" id="filamp' + contador_mps +
                                '"><td class="align-middle fw-normal">' + contador_mps + '</td><td class="align-middle fw-normal">' + tipo_b +
                                '</td><td class="align-middle fw-normal">' + producto[1] +' | '+producto[7]+
                                '</td><td class="align-middle fw-normal">' + lote +
                                '</td><td class="align-middle fw-normal">' + producto[4] +
                                '</td><td class="align-middle fw-normal">' + cantidad +
                                '</td><td class="align-middle fw-normal">' + 'No requerido' +
                                '</td><td class="align-middle fw-normal">' + 'No requerido' +
                                '</td><input type="hidden" name="producto_id[]" value="' + producto[0] +
                                '"><input type="hidden" name="producto_tipo_id[]" value="' + producto[3] +
                                '"><input type="hidden" name="producto[]" value="' + producto[1] +
                                '"><input type="hidden" name="lote[]" value="' + lote +
                                '"><input type="hidden" name="medida[]" value="' + producto[4] +
                                '"><input type="hidden" name="cantidad[]" value="' + cantidad +
                                '"><input type="hidden" name="precio[]" value="' + producto[9] +
                                '"><input type="hidden" name="fechas[]" value="' + producto[10] +
                                '"><input type="hidden" name="condicion_devolucion[]" value="' +producto[7] +
                                    '"><input type="hidden" name="id_almacenes[]" value="' + producto[8] +
                                '"><td class="align-middle"><button type="button" class="btn btn-sm btn-danger" onclick="eliminardtc(' +
                        contador_mps +','+cantidad+','+producto[3]+');"><i class="bi bi-trash"></i></button></td></tr>';
                        contador_mps++;
                        cont++;
                        if(producto[3] == '1'){
                            $("#tprima").html(cantidad_totalmp);
                            $("#tprima_id").val(cantidad_totalmp);
                        }if(producto[3] == '2'){
                            $("#tmaterial").html(cantidad_totalma);
                            $("#tmaterial_id").val(cantidad_totalma);
                        }if(producto[3] == '3'){
                            $("#tactivo").html(cantidad_totalac);
                            $("#tactivo_id").val(cantidad_totalac);
                        }
                        if(producto[3] == '4' || producto[3] == '5'){
                            $("#tprot").html(cantidad_totalal+cantidad_totalcoc);
                            $("#tprot_id").val(cantidad_totalal+cantidad_totalcoc);
                        }
                        $('#bienes_id').prop('selectedIndex', 0).change();
                        $('#cantidad_id').val("");
                        $('#precio_id').val("");
                        $('#lote_id').val("");
                        $('#fecha_vencimiento_id').val("");
                        $('#total_id').html(cantidad_totalg);
                        $('#total_ids').val(cantidad_totalg);
                        $('#dtll_ingreso').append(fila);
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Error al ingresar el detalle del ingreso, revise los datos del requerimiento',
                        })
                    }
                }else if(valormotivo == 'Produccion'){
                    var producto = document.getElementById('bienes_id').value.split('_');
                    var lote = $('#lote_id').val();
                    var cantidad = $('#cantidad_id').val();
                    var precio = $('#precio_id').val();
                    var fecha = $('#fecha_vencimiento_id').val();
                    valormotivo = $('#motivo_id').val();
                    if (producto != "" && fecha != "" && cantidad > 0 && precio > 0) {

                        if(producto[4] == '4'){
                            tipo_b = 'Alimentos';
                            cantidades_tal[contador_mps]= null; 
                            cantidades_tal[contador_mps]=Number(cantidad)
                            cantidad_totalal=cantidad_totalal+cantidades_tal[contador_mps];
                        }if(producto[4] == '5'){
                            tipo_b = 'Cosmeticos';
                            cantidades_tco[contador_mps]= null; 
                            cantidades_tco[contador_mps]=Number(cantidad)
                            cantidad_totalcoc=cantidad_totalcoc+cantidades_tco[contador_mps];
                        }
                            cantidad_totalg=cantidad_totalmp+cantidad_totalma+cantidad_totalac+cantidad_totalal+cantidad_totalcoc;
                                var fila = '<tr class="selected igv_carta" id="filamp' + contador_mps +
                                    '"><td class="align-middle fw-normal">' + contador_mps + '</td><td class="align-middle fw-normal">' + tipo_b +
                                    '</td><td class="align-middle fw-normal">' + producto[2] +
                                    '</td><td class="align-middle fw-normal">' + lote +
                                    '</td><td class="align-middle fw-normal">' + producto[5] +
                                    '</td><td class="align-middle fw-normal">' + cantidad +
                                    '</td><td class="align-middle fw-normal">' + precio +
                                    '</td><td class="align-middle fw-normal">' + fecha +
                                    '</td><input type="hidden" name="producto_id[]" value="' + producto[1] +
                                    '"><input type="hidden" name="producto_tipo_id[]" value="' + producto[4] +
                                    '"><input type="hidden" name="producto[]" value="' + producto[2] +
                                    '"><input type="hidden" name="lote[]" value="' + lote +
                                    '"><input type="hidden" name="medida[]" value="' + producto[5] +
                                    '"><input type="hidden" name="cantidad[]" value="' + cantidad +
                                    '"><input type="hidden" name="precio[]" value="' + precio +
                                    '"><input type="hidden" name="fechas[]" value="' + fecha +
                                    '"><td class="align-middle"><button type="button" class="btn btn-sm btn-danger" onclick="eliminardtc(' +
                            contador_mps +','+cantidad+','+producto[4]+');"><i class="bi bi-trash"></i></button></td></tr>';
                            contador_mps++;
                            cont++;
                            if(producto[4] == '4' || producto[4] == '5'){
                                $("#tprot").html(cantidad_totalal+cantidad_totalcoc);
                                $("#tprot_id").val(cantidad_totalal+cantidad_totalcoc);
                            }
                            $('#bienes_id').prop('selectedIndex', 0).change();
                            $('#cantidad_id').val("");
                            $('#precio_id').val("");
                            $('#lote_id').val("");
                            $('#fecha_vencimiento_id').val("");
                            $('#total_id').html(cantidad_totalg);
                            $('#total_ids').val(cantidad_totalg);
                            $('#dtll_ingreso').append(fila);
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Error al ingresar el detalle del ingreso, revise los datos del requerimiento',
                        })
                    }
                }else if(valormotivo == 'Devolucion de Venta'){
                    var producto = document.getElementById('bienes_id').value.split('_');
                    var lote = $('#lote_id').val();
                    var cantidad = $('#cantidad_id').val();
                    var precio = $('#precio_id').val();
                    var fecha_vencimiento = $('#fecha_vencimiento_id').val();
                    valormotivo = $('#motivo_id').val();
                    if (producto != "" && fecha != "" && cantidad > 0 && precio > 0) {
                        if(producto[5] == '1'){
                        tipo_b = 'Materia Prima';
                        cantidades_tmp[contador_mps]=Number(cantidad);
                        cantidad_totalmp+=cantidades_tmp[contador_mps];
                        var valornew_mp = $('#val_map').val();
                        descuento_ = valornew_mp - cantidad;
                        $('#val_map').val(descuento_);
                        $('#map').html(descuento_);
                        cat = '001';
                    }if(producto[5] == '2'){
                        tipo_b = 'Materiales';
                        cantidades_tma[contador_mps]= null; 
                        cantidades_tma[contador_mps]=Number(cantidad)
                        cantidad_totalma=cantidad_totalma+cantidades_tma[contador_mps];
                        var valornew_mt = $('#val_mat').val();
                        descuento_ = valornew_mt - cantidad;
                        $('#val_mat').val(descuento_);
                        $('#mat').html(descuento_);
                        if(producto[2] == 'Emvases y embalajes'){
                            cantidad_totalmt=cantidad_totalmt+Number(cantidad);
                            $('#tmatE_id').val(cantidad_totalmt);
                            cat = '009';
                        }else{
                            cantidad_totalmtO=cantidad_totalmtO+Number(cantidad);
                            $("#tmatO_id").val(cantidad_totalmtO);
                            cat = '008';
                        }
                    }if(producto[5] == '3'){
                        tipo_b = 'Activos';
                        cantidades_tac[contador_mps]= null; 
                        cantidades_tac[contador_mps]=Number(cantidad)
                        cantidad_totalac=cantidad_totalac+cantidades_tac[contador_mps];
                        var valornew_ac = $('#val_ac').val();
                        descuento_ = valornew_ac - cantidad;
                        $('#val_ac').val(descuento_);
                        $('#ac').html(descuento_);
                        cat = '003';
                    }if(producto[5] == '4'){
                        tipo_b = 'Alimentos';
                        console.log(tipo_b);
                        cantidades_tal[contador_mps]= null; 
                        cantidades_tal[contador_mps]=Number(cantidad)
                        cantidad_totalal=cantidad_totalal+cantidades_tal[contador_mps];
                        cat = '004';
                    }if(producto[5] == '5'){
                        tipo_b = 'Cosmeticos';
                        console.log(tipo_b);
                        cantidades_tco[contador_mps]= null; 
                        cantidades_tco[contador_mps]=Number(cantidad)
                        cantidad_totalcoc=cantidad_totalcoc+cantidades_tco[contador_mps];
                        cat = '005';
                    }
                        cantidad_totalg=cantidad_totalmp+cantidad_totalma+cantidad_totalac+cantidad_totalal+cantidad_totalcoc;
                        var fila = '<tr class="selected igv_carta" id="filamp' + contador_mps +
                            '"><td class="align-middle fw-normal">' + contador_mps + '</td><td class="align-middle fw-normal">' + tipo_b +
                            '</td><td class="align-middle fw-normal">' + producto[0] +
                            '</td><td class="align-middle fw-normal">' + lote +
                            '</td><td class="align-middle fw-normal">' + producto[7] +
                            '</td><td class="align-middle fw-normal">' + cantidad +
                            '</td><td class="align-middle fw-normal">' + precio +
                            '</td><td class="align-middle fw-normal">' + fecha_vencimiento +
                            '</td><input type="hidden" name="producto_id[]" value="' + producto[1] +
                            '"><input type="hidden" name="producto_tipo_id[]" value="' + producto[5] +
                            '"><input type="hidden" name="producto[]" value="' + producto[0] +
                            '"><input type="hidden" name="categoria[]" value="' + producto[2] +
                            '"><input type="hidden" name="lote[]" value="' + lote +
                            '"><input type="hidden" name="medida[]" value="' + producto[7] +
                            '"><input type="hidden" name="cantidad[]" value="' + cantidad +
                            '"><input type="hidden" name="precio[]" value="' + precio +
                            '"><input type="hidden" name="fechas[]" value="' + fecha_vencimiento +
                            '"><td class="align-middle"><button type="button" class="btn btn-sm btn-danger" onclick="eliminardtc(' +
                    contador_mps +','+cantidad+','+producto[5]+','+cat+');"><i class="bi bi-trash"></i></button></td></tr>';
                        contador_mps++;
                        cont++;
                        if(producto[5] == '1'){
                            $("#tprima").html(cantidad_totalmp);
                            $("#tprima_id").val(cantidad_totalmp);
                        }if(producto[5] == '2'){
                            $("#tmaterial").html(cantidad_totalma);
                            $("#tmaterial_id").val(cantidad_totalma);
                        }if(producto[5] == '3'){
                            $("#tactivo").html(cantidad_totalac);
                            $("#tactivo_id").val(cantidad_totalac);
                        }
                        if(producto[5] == '4' || producto[5] == '5'){
                            $("#tprot").html(cantidad_totalal+cantidad_totalcoc);
                            $("#tprot_id").val(cantidad_totalal+cantidad_totalcoc);
                        }
                        $('#bienes_id').prop('selectedIndex', 0).change();
                        $('#cantidad_id').val("");
                        $('#stock_disponible_add').val("");
                        $('#precio_id').val("");
                        $('#lote_id').empty("");
                        $('#total_id').html(cantidad_totalg);
                        $('#total_ids').val(cantidad_totalg);
                        $('#dtll_ingreso').append(fila);
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Error al ingresar el detalle del ingreso, revise los datos del requerimiento',
                        })
                    }
                }
        });
        function eliminardtc(indexmp, cantidad,protipo_id) {
            if(protipo_id == '1'){
                value_mp = Number($('#tprima_id').val());
                console.log(value_mp);
                cantidad_totalmp=value_mp-cantidad;
                if(cantidad_totalmp>0){
                    $("#tprima").html(cantidad_totalmp);
                    $("#tprima_id").val(cantidad_totalmp);
                }else{
                    $("#tprima").html(0.00);
                    $("#tprima_id").val(0.00);
                }
            }if(protipo_id == '2'){
                value_mt = Number($('#tmaterial_id').val());
                cantidad_totalma=value_mt-cantidad;
                if(cantidad_totalma>0){
                    $("#tmaterial").html(cantidad_totalma);
                    $("#tmaterial_id").val(cantidad_totalma);
                }else{
                    $("#tmaterial").html(0.00);
                    $("#tmaterial_id").val(0.00);
                }
            }if(protipo_id == '3'){
                value_ac = Number($('#tactivo_id').val());
                cantidad_totalac=value_ac-cantidad;
                if(cantidad_totalac>0){
                    $("#tactivo").html(cantidad_totalac);
                    $("#tactivo_id").val(cantidad_totalac);
                }else{
                    $("#tactivo").html(0.00);
                    $("#tactivo_id").val(0.00);
                }
            }if(protipo_id == '4'){
                value_al = Number($('#tprot_id').val());
                cantidad_totalal=value_al-cantidad;
                if(cantidad_totalal>0){
                    $("#tprot").html(cantidad_totalal);
                    $("#tprot_id").val(cantidad_totalal);
                }else{
                    $("#tprot").html(0.00);
                    $("#tprot_id").val(0.00);
                }
            }if(protipo_id == '5'){
                value_co = Number($('#tprot_id').val());
                cantidad_totalcoc=value_co-cantidad;
                if(cantidad_totalcoc>0){
                    $("#tprot").html(cantidad_totalcoc);
                    $("#tprot_id").val(cantidad_totalcoc);
                }else{
                    $("#tprot").html(0.00);
                    $("#tprot_id").val(0.00);
                }
            }
            cantidad_totalg=cantidad_totalmp+cantidad_totalma+cantidad_totalac+cantidad_totalal+cantidad_totalcoc;
            //tproductos = tproductos - cantidades[indexmp];
            $('#total_id').html(cantidad_totalg);
            $('#total_ids').val(cantidad_totalg);
            //$("#tproductos").html(+tproductos);
            //$("#total_product").val(tproductos);
            $("#filamp" + indexmp).remove();
        }
</script>
@endsection