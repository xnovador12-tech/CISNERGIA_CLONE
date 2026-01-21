@extends('TEMPLATES.administrador')

@section('title', 'ÓRDENES DE SERVICIOS')

@section('css')
@endsection

@section('content')
<!-- Encabezado -->
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">ORDEN DE SERVICIOS</h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ url('admin-ordenservicios') }}">Órdenes de servicios</a></li>
                        <li class="breadcrumb-item" aria-current="page">Actualizar registro</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
<!-- fin encabezado -->

    {{-- contenido --}}
        <form class="form-group" method="POST" action="{{ route('admin-ordenservicios.update', $admin_ordenservicio->slug) }}" enctype="multipart/form-data" autocomplete="off">      
            @csrf
            @method('PUT')
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
                                            <span class="text-uppercase">{{ $admin_ordenservicio->codigo }}</span>
                                            <input type="text" name="codigo" id="servicio_codigo" value="{{ $admin_ordenservicio->codigo }}" hidden>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 col-md-3" style="font-size: 13px">
                                        <div class="text-center">
                                            <p class="text-uppercase fw-bold mb-0">
                                                Fecha
                                            </p>
                                            <span class="text-uppercase">{{ $admin_ordenservicio->fecha }}</span>
                                            <input hidden name="fecha" value="{{ $admin_ordenservicio->fecha }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-12 col-md-3 col-lg-2">
                                <div class="mb-3 mb-lg-0">
                                    <label for="motivo_id" class=" d-block">Motivo<span class="text-danger">*</span></label>
                                    <select class="form-select form-select-sm @error ('motivo') is-invalid @enderror" required name="motivo" id="motivo_id" >
                                        <option value="{{ $admin_ordenservicio->motivo }}" selected="selected">{{ $admin_ordenservicio->motivo }}</option>
                                        <option value="VENTA DIRECTA">VENTA DIRECTA</option>
                                        <option value="VENTA INDIRECTA">VENTA INDIRECTA</option>   
                                    </select>
                                    @error('motivo')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror  
                                </div>
                            </div>
                            
                            <div class="col-12 col-md-3 col-lg-2">
                                <div class="mb-3 mb-lg-0">
                                    <label for="forma_pago_id" class=" d-block">Forma de pago<span class="text-danger">*</span></label>
                                    <select class="form-select form-select-sm @error ('formapago') is-invalid @enderror" required name="formapago" id="forma_pago_id" >
                                        <option value="{{ $admin_ordenservicio->formapago }}" selected="selected">{{ $admin_ordenservicio->formapago }}</option>
                                        @foreach($forma_pago as $forma_pagos)
                                            <option value="{{ $forma_pagos->name }}">{{ $forma_pagos->name }}</option>
                                        @endforeach
                                        
                                    </select>  
                                    @error('formapago')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-3 col-lg-2">
                                <div class="mb-3 mb-lg-0">
                                    <label for="plazo_pago_id" class=" d-block">Plazo<span class="text-danger">*</span></label>
                                    <select class="form-select form-select-sm @error ('plazo_pago') is-invalid @enderror" name="plazo_pago" required id="plazo_pago_id" >
                                        <option value="{{ $admin_ordenservicio->plazo_pago }}" selected="selected" hidden="hidden">{{ $admin_ordenservicio->plazo_pago }}</option>
                                        <option value="0">DE CONTADO</option>
                                        <option value="15">15 Días</option>
                                        <option value="30">30 Días</option>
                                        <option value="60">60 Días</option>
                                    </select>  
                                    @error('plazo_pago')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-3 col-lg-2">
                                <div class="mb-3 mb-lg-0">
                                    <label for="codigo_venta_id" class=" d-block">Codigo de Venta<span class="text-danger">*</span></label>
                                    <input class="form-control form-control-sm" type="text" id="codigo_venta_id" value="{{ $admin_ordenservicio->codigo_venta }}" disabled>
                                    @error('codigo_venta')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <p class="text-primary mb-1 mt-2 small text-uppercase fw-bold">Detalles</p>
                        <div class="row g-2">
                            <div class="col-12 col-md-2 col-lg-2 mb-3">
                                <label for="tipos_id" class=" d-block">Tipo</label>
                                <select class="form-select form-select-sm" id="tipos_id" >
                                    <option selected="selected" hidden="hidden">-- Seleccione --</option>
                                    <option value="Servicio Publico">PUBLICO</option>
                                    <option value="Servicio Privado">PRIVADO</option>
                                </select>  
                            </div>
                            <div class="col-6 col-md-3 col-lg-3 mb-3">
                                <label for="servicio_id" class=" d-block">Servicios</label>
                                <select class="form-select select2 form-select-sm" id="servicio_id" >
                                </select>  
                            </div>
                            <div class="col-12 col-md-1 col-lg-1">
                                <div class="mb-3">
                                    <label for="precio_id" class="">Precio</label>
                                    <input type="number" step="0.05" id="precio_id" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-6 col-md-2 col-lg-2 mb-3">
                                <label for="tiempo_id" class=" d-block">Tiempo</label>
                                <select class="form-select form-select-sm" id="tiempo_id">
                                    <option selected="selected" hidden="hidden">-- Seleccione --</option>
                                    <option value="1">1 MES</option>
                                    <option value="2">2 MESES</option>
                                    <option value="3">3 MESES</option>
                                    <option value="4">4 MESES</option>
                                    <option value="5">5 MESES</option>
                                    <option value="6">6 MESES</option>
                                    <option value="7">7 MESES</option>
                                    <option value="8">8 MESES</option>
                                    <option value="9">9 MESES</option>
                                    <option value="10">10 MESES</option>
                                    <option value="11">11 MESES</option>
                                    <option value="12">12 MESES</option>
                                    <option value="18">18 MESES</option>
                                    <option value="24">24 MESES</option>
                                    <option value="INDEFINIDO">INDEFINIDO</option>
                                </select>  
                            </div>
                            <div class="col-6 col-md-3 col-lg-2 mb-3">
                                <label for="monto__id" class=" d-block">Vigente hasta</label>
                                <input type="date" id="vigencia_id" class="float-end form-control form-control-sm">
                            </div>
                            <div class="col-6 col-md-2 col-lg-2 mb-3">
                                <label for="agre" class=" d-block text-white">..</label>
                                <button type="button" id="btnasignar" class="btn btn-secondary btn-sm w-100 align-bottom text-white mt-2 mt-md-0">
                                    Agregar
                                </button>
                            </div>
                        </div>
                        <table class="table table-sm table-hover mb-5">
                            <thead class="bg-light">
                            <tr>
                                <th class="fw-bold small text-uppercase">N°</th>
                                <th class="fw-bold small text-uppercase">Tipo</th>
                                <th class="fw-bold small text-uppercase">Descripción</th>
                                <th class="fw-bold small text-uppercase">Precio</th>
                                <th class="fw-bold small text-uppercase">Tiempo</th>
                                <th class="fw-bold small text-uppercase">Vigente hasta</th>
                                <th class="fw-bold small text-uppercase">Accion</th>
                            </tr>
                            </thead>
                            <tbody id="dtll_servicio">
                            
                            </tbody>
                        </table>
                        <div class="row justify-content-beetween">
                            <div class="col-12 col-md-6">
                                <textarea name="nota" id="" class="form-control w-100" placeholder="Observaciones" rows="3">{{ old('nota', $admin_ordenservicio->nota) }}</textarea>
                                @error('nota')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-1"></div>
                            <div class="col-12 col-md-5">
                                <table class="w-100">
                                    <tr>
                                        <td class="border-0 ps-2 py-1" style="width: 50%">
                                            Subtotal
                                        </td>
                                        <td class="border-0 pe-2 py-1" style="width: 50%">
                                            <div class="clearfix">
                                                <span class="float-start ps-2">S/ </span>
                                                <span class="float-end" id="subtotal_id">
                                                    0.00
                                                </span>
                                                <input hidden name="subtotal" id="subtotal">
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="border-0 fw-bold ps-2 py-1 bg-light" style="width: 50%">
                                            TOTAL
                                        </td>
                                        <td class="border-0 fw-bold pe-2 py-1 bg-light" style="width: 50%">
                                            <div class="clearfix">
                                                <span class="float-start ps-2">S/ </span>
                                                <span class="float-end"id="total_id">
                                                    0.00
                                                </span>
                                                <input hidden name="total" id="total">
                                            </div>
                                            @error('total')
                                                <small class="text-danger">{{$message}}</small>
                                            @enderror
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        
                    </div>
                </div>
                <div class="p-3 text-end" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
                    <a href="{{ url('admin-ordenes-servicios') }}" class="btn btn-outline-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary px-5 my-2 my-md-0 text-white">Registrar</button>
                </div>     
            </div> 
        </form>
    {{-- fin contenido --}}

@endsection

@section('js')
<script>
    (function ($) {
        $.fn.solonumeros = function () {
            return this.each(function () {
                $(this).keypress(function (e) {
                    const code = (e.which) ? e.which : e.keyCode;
                    if (code < 48 || code > 57) {
                        return false;
                    }
                });
            });
        };
    })(jQuery);

    var formap = $('#forma_pago_id').val();
    if(formap == 'Contado'){
        $("#plazo_pago_id").empty('');
        $('#plazo_pago_id').append("<option disabled>Selecciona una opcion</option>");
        $("#plazo_pago_id").append("<option selected value='0'>Contado</option>");
    }
    if(formap == 'Credito'){
        $("#plazo_pago_id").empty('');
        $('#plazo_pago_id').append("<option selected disabled>Selecciona una opcion</option>");
        $("#plazo_pago_id").append("<option value='15'>15 Días</option>");
        $("#plazo_pago_id").append("<option value='30'>30 Días</option>");
        $("#plazo_pago_id").append("<option value='60'>60 Días</option>");
    }

    $('#forma_pago_id').on('change', function(){
        formap = $(this).val();
        if(formap == 'Contado'){
            $("#plazo_pago_id").empty('');
            $('#plazo_pago_id').append("<option disabled>Selecciona una opcion</option>");
            $("#plazo_pago_id").append("<option selected value='0'>Contado</option>");
        }
        if(formap == 'Credito'){
            $("#plazo_pago_id").empty('');
            $('#plazo_pago_id').append("<option selected disabled>Selecciona una opcion</option>");
            $("#plazo_pago_id").append("<option value='15'>15 Días</option>");
            $("#plazo_pago_id").append("<option value='30'>30 Días</option>");
            $("#plazo_pago_id").append("<option value='60'>60 Días</option>");
        }
    });
    $('#tipos_id').on('change', function(){
        var tipo_servicio = $(this).val();
        $.get('/busqueda_tipos',{tipo_servicio: tipo_servicio}, function(busqueda){
            $("#servicio_id").empty('');
            $('#servicio_id').append("<option selected disabled>Selecciona una opcion</option>");
            $.each(busqueda, function(index, value){
                if(value[0] == 'sin valor'){
                    $("#servicio_id").empty('');
                }else{
                    $('#servicio_id').append("<option value='"+index+'_'+value[0]+'_'+value[1]+"'>" +value[1] + "</option>");
                }
            })
        });
    });

    $('#tiempo_id').on('change', function(){
        var value_tiempo = $(this).val();
        value_tiempo = Number(value_tiempo);
        $.get('/fecha_vigencia',{value_tiempo: value_tiempo}, function(busqueda){
            $.each(busqueda, function(index, value){
                if(value_tiempo == 'INDEFINIDO'){
                    $('#vigencia_id').val("");
                    $('#vigencia_id').attr('disabled',true);
                }else{
                    $('#vigencia_id').val("");
                    $('#vigencia_id').attr('disabled',false);
                    $('#vigencia_id').val(value[0]);
                }
            })
        });
    });

    $(document).ready(function() {
        var contador_mps = 1;
        var cont = 0;
        total=0;
        var subtotales = {};
        var codigo_servicio = $('#servicio_codigo').val();
        $.get('/dt_servicio',{codigo_servicio: codigo_servicio}, function(busqueda){
            $.each(busqueda, function(index, value){
                    var tipo_servicio = value[1];
                    var tiempo = value[5];
                    var precio = value[4];
                    var vigencia = value[6];
                    subtotales[contador_mps] = precio;
                    total=parseFloat(total)+parseFloat(precio);
                    var fila = '<tr class="selected igv_carta" id="filamp' + contador_mps +
                        '"><td class="align-middle fw-normal">' + contador_mps + '</td><td class="align-middle fw-normal">' + tipo_servicio +
                        '</td><td class="align-middle fw-normal">' + value[3] +
                        '</td><td class="align-middle fw-normal">' + precio +
                        '</td><td class="align-middle fw-normal">' + tiempo +
                        '</td><td class="align-middle fw-normal">' + vigencia +
                        '</td><input type="hidden" name="tipo_servicio[]" value="' + tipo_servicio +
                        '"><input type="hidden" name="codigo_servicio[]" value="' + value[2] +
                        '"><input type="hidden" name="servicio[]" value="' + value[3] +
                        '"><input type="hidden" name="precio[]" value="' + precio +
                        '"><input type="hidden" name="tiempo_meses[]" value="' + tiempo +
                        '"><input type="hidden" name="vigencia[]" value="' + vigencia +
                        '"><input type="" name="subtotal[]" value="' + subtotales[contador_mps] +
                        '"><td class="align-middle"><button class="btn btn-sm btn-danger" onclick="eliminaroservicio(' +
                contador_mps +','+subtotales[contador_mps]+');"><i class="bi bi-trash"></i></button></td></tr>'
                    contador_mps++;
                    cont++;

                    $("#subtotal_id").html(total.toFixed(2));
                    $("#subtotal").val(total.toFixed(2));
                    $("#total_id").html(total.toFixed(2));
                    $("#total").val(total.toFixed(2));

                    $('#dtll_servicio').append(fila);
            });
        });
        $('#btnasignar').click(function() {
            var tipo_servicio = $('#tipos_id').val();
            var servicio = document.getElementById('servicio_id').value.split('_');
            var tiempo = $('#tiempo_id').val();
            var precio = $('#precio_id').val();
            var vigencia = $('#vigencia_id').val();
            if (tipo_servicio != "" && servicio != "" && tiempo != "" && precio > 0) {
                    if(vigencia){
                        vigencia = vigencia;
                    }else{
                        vigencia = '';
                    }
                    subtotales[contador_mps] = precio;
                    total=parseFloat(total)+parseFloat(precio);
                    var fila = '<tr class="selected igv_carta" id="filamp' + contador_mps +
                        '"><td class="align-middle fw-normal">' + contador_mps + '</td><td class="align-middle fw-normal">' + tipo_servicio +
                        '</td><td class="align-middle fw-normal">' + servicio[2] +
                        '</td><td class="align-middle fw-normal">' + precio +
                        '</td><td class="align-middle fw-normal">' + tiempo +
                        '</td><td class="align-middle fw-normal">' + vigencia +
                        '</td><input type="hidden" name="tipo_servicio[]" value="' + tipo_servicio +
                        '"><input type="hidden" name="codigo_servicio[]" value="' + servicio[1] +
                        '"><input type="hidden" name="servicio[]" value="' + servicio[2] +
                        '"><input type="hidden" name="precio[]" value="' + precio +
                        '"><input type="hidden" name="tiempo_meses[]" value="' + tiempo +
                        '"><input type="hidden" name="vigencia[]" value="' + vigencia +
                        '"><input type="" name="subtotal[]" value="' + subtotales[contador_mps] +
                        '"><td class="align-middle"><button class="btn btn-sm btn-danger" onclick="eliminaroservicio(' +
                contador_mps +','+subtotales[contador_mps]+');"><i class="bi bi-trash"></i></button></td></tr>';
                    contador_mps++;
                    cont++;

                    
                    $("#subtotal_id").html(total.toFixed(2));
                    $("#subtotal").val(total.toFixed(2));
                    $("#total_id").html(total.toFixed(2));
                    $("#total").val(total.toFixed(2));
                    $('#tipos_id').prop('selectedIndex', 0).change();
                    $('#servicio_id').empty();
                    $('#precio_id').val("");
                    $('#tiempo_id').prop('selectedIndex', 0).change();
                    $('#vigencia_id').val("");
                    $('#dtll_servicio').append(fila);

                    

            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Error al ingresar el detalle del ingreso, revise los datos del requerimiento',
                })
            }

        });
    });

    function eliminaroservicio(indexmp,precio) {
            totalidad = $("#total").val();
            total=parseFloat(totalidad)-parseFloat(precio);
            if(total == 0){
                $("#subtotal_id").html(0.00);
                $("#subtotal").val(0.00);
                $("#total").val(0.00);
                $("#total_id").html(0.00);
            }else{
                $("#subtotal_id").html(total.toFixed(2));
                $("#subtotal").val(total.toFixed(2));
                $("#total").val(total);
                $("#total_id").html(total);
            }
            $("#filamp" + indexmp).remove();
        }
</script>
@endsection