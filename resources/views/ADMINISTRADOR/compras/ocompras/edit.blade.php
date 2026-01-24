@extends('TEMPLATES.administrador')

@section('title', 'ÓRDENES DE COMPRA')

@section('css')
@endsection

@section('content')
<!-- Encabezado -->
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">ORDEN DE COMPRAS</h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ url('admin-configuraciones') }}">Configuraciones</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ url('admin-ordencompras') }}">Órdenes de compra</a></li>
                        <li class="breadcrumb-item" aria-current="page">Actualizar registro</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
<!-- fin encabezado -->

    {{-- contenido --}}
    <form method="POST" action="{{ route('admin-ordencompras.update', $admin_ordencompra->slug) }}" autocomplete="off" class="needs-validation" novalidate>      
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
                    <div class="row g-2">
                        <input hidden id="compra_codigo" value="{{$admin_ordencompra->codigo}}">
                        <div class="col-12 col-md-4 col-lg-6">
                            <div class="mb-3">
                                <label for="umed_id" class=" d-block">Proveedor</label>
                                <select class="form-select form-select-sm @error('tipo_servicio') is-invalid @enderror" required name="proveedor_id" id="proveedor_id" >
                                    <option selected="selected" value="{{ old('proveedor_id', $admin_ordencompra->proveedor_id) }}" hidden="hidden">{{ old('proveedor_id', $admin_ordencompra->proveedor->name_contacto) }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-2">
                            <div class="mb-3">
                                <label for="fecha_actual" class=" d-block">Fecha</label>
                                <input type="text" disabled class="form-control form-control-sm bg-white" id="fecha_actual" name="fecha_actual" value="{{ $admin_ordencompra->fecha }}" readonly>
                                <input type="hidden" name="fecha_actual" value="{{ old('fecha_actual', $admin_ordencompra->fecha) }}">
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-2">
                            <div class="mb-3">
                                <label for="prove_id" class=" d-block">Tipo de Moneda<span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm select2" name="tipo_moneda" id="tipo_moneda_id">
                                    <option value="Soles" {{ old('tipo_moneda', $admin_ordencompra->tipo_moneda) == 'Soles' ? 'selected' : '' }}>Soles</option>
                                    <option value="Dolares" {{ old('tipo_moneda', $admin_ordencompra->tipo_moneda) == 'Dolares' ? 'selected' : '' }}>Dolares</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-2">
                            <div class="mb-3">
                                <label for="formapago__id" class=" d-block">Forma de pago<span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm @error ('forma_pago') is-invalid @enderror" required id="forma_pago_id" >
                                    <option value="{{$admin_ordencompra->forma_pago}}" selected="selected" hidden="hidden">{{$admin_ordencompra->forma_pago}}</option>
                                    <option value="Contado">Contado</option>
                                    <option value="Credito">Credito</option>
                                </select>
                                @error('forma_pago')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror  
                            </div>
                            <input hidden id="forma_pago_ids" name="forma_pago" value="{{$admin_ordencompra->forma_pago}}">
                        </div>
                        <div class="col-12 col-md-4 col-lg-2">
                            <div class="mb-3">
                                <label for="plazopago__id" class=" d-block">Plazo de pago<span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm @error ('plazo_pago') is-invalid @enderror" required id="plazo_pago_id">
                                    <option value="{{$admin_ordencompra->plazo_pago}}" selected="selected" hidden="hidden">{{$admin_ordencompra->plazo_pago == 0?'DE CONTADO':$admin_ordencompra->plazo_pago.' dias'}}</option>
                                    <option value="0">DE CONTADO</option>
                                    <option value="30">30 días</option>
                                    <option value="60">60 días</option>
                                    <option value="90">90 días</option>
                                </select>
                                @error('plazo_pago')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror  
                            </div>
                            <input hidden id="plazo_pago_ids" name="plazo_pago" value="{{$admin_ordencompra->plazo_pago}}">
                        </div>
                        <div class="col-12 col-md-4 col-lg-2">
                            <div class="mb-3">
                                <label for="fechavencimiento__id" class=" d-block">Fecha de vencimiento<span class="text-danger">*</span></label>
                                <input type="date" value="{{$admin_ordencompra->fecha_pago}}" class="form-control form-control-sm @error ('fecha_pago') is-invalid @enderror" required name="fecha_pago" id="fecha_venc">  
                                @error('fecha_pago')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror 
                            </div>
                        </div>
                    </div>
                    <hr>
                    <p class="text-primary mb-2 small text-uppercase fw-bold">órden de compra</p>
                    <div class="row">
                        <div class="col-6 col-md-4 col-lg-3 mb-3">
                            <label for="bien_id" class=" d-block">Bienes</label>
                            <select class="form-select select2 form-select-sm" id="bien_id" >
                            </select>  
                        </div>
                        <div class="col-6 col-md-3 col-lg-1 mb-3">
                            <label for="umed_id" class=" d-block">U.M.</label>
                            <input type="text" name="name" value="" class="form-control form-control-sm bg-white" disabled id="umed_id">
                        </div>
                        <div class="col-6 col-md-3 col-lg-2 mb-3">
                            <label for="canti_id" class=" d-block">Cantidad</label>
                            <input type="number" class="float-end form-control form-control-sm" id="canti_id">
                        </div>
                        <div class="col-6 col-md-3 col-lg-2 mb-3">
                            <label for="prec_id" class=" d-block">Precio</label>
                            <div class="input-group input-group-sm mb-3">
                                <span class="input-group-text" id="moneda_html">S/</span>
                                <input type="number" name="precio" value="" class="form-control form-control-sm" id="prec_id">
                            </div>
                        </div>
                        <div class="col-6 col-md-2 col-lg-2 mb-3">
                            <label for="prove_id" class=" d-block">Tipo de Impuesto</label>
                            <select class="form-select form-select-sm select2" id="tipo_impuesto_id">
                                <option selected="selected" disabled>--Seleccionar--</option>
                                <option value="IGV">IGV (18%)</option>
                                <option value="SIN IGV">SIN IGV(0%)</option>
                            </select>  
                        </div>
                        <div class="col-6 col-md-2 col-lg-2 mb-3">
                            <label for="agre" class=" d-block text-white">..</label>
                            <button type="button" id="btnasignar" class="btn btn-secondary btn-sm w-100 align-bottom text-white mt-2 mt-md-0">
                                Agregar
                            </button>
                        </div>
                    </div>
                    <p class="text-primary mb-2 small text-uppercase fw-bold">Detalles</p>
                    <table class="table table-sm table-hover">
                        <thead class="bg-light">
                        <tr>
                            <th class="fw-bold small text-uppercase">N°</th>
                            <th class="fw-bold small text-uppercase">Tipo</th>
                            <th class="fw-bold small text-uppercase">Descripción</th>
                            <th class="fw-bold small text-uppercase">U.M.</th>
                            <th class="fw-bold small text-uppercase">Cantidad</th>
                            <th class="fw-bold small text-uppercase">Precio</th>
                            <th class="fw-bold small text-uppercase">Tipo Afectacion</th>
                            <th class="fw-bold small text-uppercase">Total</th> 
                            <th class="fw-bold small text-uppercase">Accion</th>
                        </tr>
                        </thead>
                        <tbody id="dtll_compra">
                            
                        </tbody>
                    </table>

                    <div class="row justify-content-beetween mt-3">
                        <div class="col-12 col-md-7">
                            <textarea name="observacion" class="form-control mb-0 @error ('observacion') is-invalid @enderror">{{ $admin_ordencompra->observacion }}</textarea>
                            @error('observacion')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror 
                        </div>
                        <div class="col-12 col-md-5">
                            <table class="w-100">
                                <tr>
                                    <td class="border-0 ps-2 py-1 bg-light" style="width: 50%">
                                        Subtotal
                                    </td>
                                    <td class="border-0 pe-2 py-1 bg-light" style="width: 50%">
                                        <div class="clearfix">
                                            <span class="float-start ps-2">S/ </span>
                                            <span class="float-end" id="subto_id">
                                                0.00
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                
                                
                                <tr>
                                    <td class="border-0 ps-2 py-1" style="width: 50%">
                                        I.G.V.
                                    </td>
                                    <td class="border-0 pe-2 py-1" style="width: 50%">
                                        <div class="clearfix">
                                            <span class="float-start ps-2">S/ </span>
                                            <span class="float-end" id="igv_id">
                                                0.00
                                            </span>
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
                                            <span class="float-end" id="totalidad_id">
                                                0.00
                                            </span>
                                            <input type="hidden" name="total" required id="total_id">
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-3 text-end" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
                <a href="{{ url('admin-ordencompras') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary px-5 my-2 my-md-0 text-white">Actualizar</button>
            </div>     
        </div> 
    </form>
    {{-- fin contenido --}}
@endsection

@section('js')
<script>
    function previewImagePrincipal(nb) {        
        var reader = new FileReader();         
        reader.readAsDataURL(document.getElementById('uploadImage'+nb).files[0]);                
        reader.onload = function (e) {   
            document.getElementById('uploadPreview'+nb).src = e.target.result;                  
        };     
    }
    
    function previewImagePrincipalcot(nb) {        
        var reader = new FileReader();         
        reader.readAsDataURL(document.getElementById('uploadImage'+nb).files[0]);                
        reader.onload = function (e) {   
            document.getElementById('uploadPreview'+nb).src = e.target.result;                  
        };     
    }
</script>
<script>
    $(document).ready(function() {

        $('#tipo_moneda_id').on('change', function() {
            var valor_moneda = $(this).val();
            console.log(valor_moneda);
            if(valor_moneda == 'Soles'){
                $('#moneda_html').html('PEN');
            }else{
                $('#moneda_html').html('USD');
            }
            
        });
        
        $('#forma_pago_id').on('change', function(){
            var forma_p = document.getElementById('forma_pago_id').value.split('_');
            $('#forma_pago_id').prop('disabled', true);
            if(forma_p[0] == 'Contado'){
                $('#forma_pago_ids').val(forma_p[0]);
                $('#plazo_pago_id').empty("");
                $('#plazo_pago_id').append("<option selected='selected' hidden='hidden'></option>");
                $('#plazo_pago_id').append("<option selected value='0'>DE CONTADO</option>");
                $('#plazo_pago_ids').val("0");
                
                $('#p_cuota_id').prop('disabled', true);
                $('#fp_cuota_id').prop('disabled', true);
                $('#s_cuota_id').prop('disabled', true);
                $('#fs_cuota_id').prop('disabled', true);
                $.get('/fecha_cuotas',{cuotas: 0}, function(busqueda){
                    $.each(busqueda, function(index, value){
                        $('#fecha_venc').val(value[0]);
                    })
                });
            }else{
                $('#forma_pago_ids').val(forma_p[0]);
                $('#plazo_pago_id').empty("");
                $('#plazo_pago_id').append("<option selected='selected' hidden='hidden'></option>");
                $('#plazo_pago_id').append("<option value='30'>30 Días</option>");
                $('#plazo_pago_id').append("<option value='60'>60 Días</option>");
                $('#plazo_pago_id').append("<option value='90'>90 Días</option>");
            }
        });

        $('#plazo_pago_id').on('change', function(){
            $('#plazo_pago_id').prop('disabled', true);
            var cuotas = $(this).val();
            if(cuotas == '30'){
                $('#plazo_pago_ids').val("30");
                $('#p_cuota_id').prop('disabled', false);
                $('#s_cuota_id').prop('disabled', true);
                $.get('/fecha_cuotas',{cuotas: cuotas}, function(busqueda){
                    $.each(busqueda, function(index, value){
                        $('#fecha_venc').val(value[0]);
                    })
                });
            }else if(cuotas == '60'){
                $('#plazo_pago_ids').val("60");
                $('#p_cuota_id').prop('disabled', false);
                $('#s_cuota_id').prop('disabled', false);
                $.get('/fecha_cuotas',{cuotas: cuotas}, function(busqueda){
                    $.each(busqueda, function(index, value){
                        $('#fecha_venc').val(value[1]);
                    })
                });
            }else{
                $('#plazo_pago_ids').val("90");
                $('#p_cuota_id').prop('disabled', false);
                $('#s_cuota_id').prop('disabled', false);
                $.get('/fecha_cuotas',{cuotas: cuotas}, function(busqueda){
                    $.each(busqueda, function(index, value){
                        $('#fecha_venc').val(value[1]);
                    })
                });
            }
            
        });
        
        // Inicio de seleccionar proveedor y cargar bienes
            var proveedor_ids = $('#proveedor_id').val();
            $.get('/busqueda_biene_compra', {proveedor_ids: proveedor_ids}, function(bienes) {
                $('#bien_id').empty();
                $('#bien_id').append("<option selected='selected' hidden='hidden'></option>");
                $.each(bienes, function(index, value) {
                    $('#bien_id').append("<option value='"+index+'_'+value[0]+'_'+value[1]+'_'+value[2]+"'>" + value[0] + "</option>");
                });
            });
        // fin de seleccionar proveedor y cargar bienes

        $('#proveedor_id').on('change', function() {
            var proveedor_ids = $(this).val();
            $.get('/busqueda_biene_compra', {proveedor_ids: proveedor_ids}, function(bienes) {
                $('#bien_id').empty();
                $('#bien_id').append("<option selected='selected' hidden='hidden'></option>");
                $.each(bienes, function(index, value) {
                    $('#bien_id').append("<option value='"+index+'_'+value[0]+'_'+value[1]+'_'+value[2]+"'>" + value[0] + "</option>");
                });
            });
        });

        $('#bien_id').on('change', function() {
            var valor_tip = document.getElementById("bien_id").value.split('_');
            $('#umed_id').val("");
            $('#umed_id').val(valor_tip[2]);
        });

        var contador_mp = 1;
        var cont = 0;
        total=0;
        subtotal=[];
        
        $.get('/busqueda_detalle_compra', {codigo_compra: $('#compra_codigo').val()}, function(bienes) {
            $.each(bienes, function(index, value) {
                var medida = value[3];
                var cantidad = value[4];
                var precio = value[5];
                var tipo_impuesto_value = value[6];
                subtotal = (cantidad*precio).toFixed(2);

                total=parseFloat(total)+parseFloat(subtotal);
                console.log(total);
                var fila = '<tr class="selected igv_carta" id="filamp' + contador_mp +
                    '"><td class="align-middle fw-normal">' + contador_mp + '</td><td class="align-middle fw-normal">' + value[2] +
                '</td><td class="align-middle fw-normal">' + value[1] +
                    '</td><td class="align-middle fw-normal">' + medida +
                    '</td><td class="align-middle fw-normal">' + cantidad +
                    '</td><td class="align-middle fw-normal">' + precio +
                    '</td><td class="align-middle fw-normal">' + tipo_impuesto_value +
                    '</td><td class="align-middle fw-normal">' + subtotal +
                    '</td><input type="hidden" name="tipo_producto[]" value="' + value[2] +
                    '"><input type="hidden" name="bienes[]" value="' + value[1] +
                    '"><input type="hidden" name="bien_id[]" value="' + value[0] +
                    '"><input type="hidden" name="medida[]" value="' + medida +
                    '"><input type="hidden" name="cantidad[]" value="' + cantidad +
                    '"><input type="hidden" name="precio[]" value="' + precio +
                    '"><input type="hidden" name="tipo_impuesto_value[]" value="' + tipo_impuesto_value +
                    '"><input type="hidden" name="subtotal[]" value="' + subtotal +
                    '"><td class="align-middle"><button class="btn btn-sm btn-danger" onclick="eliminardes(' +
                    contador_mp +','+subtotal + ');"><i class="bi bi-trash text-white"></i></button></td></tr>';
                contador_mp++;
                $("#subto_id").html((total/1.18).toFixed(2));
                $("#total_id").val(total.toFixed(2));
                $("#igv_id").html((parseFloat(((total/1.18)*0.18).toFixed(2))));
                $("#totalidad_id").html(total.toFixed(2));
                $('#dtll_compra').append(fila);
            });
        });


        $('#btnasignar').click(function() {
            var bienes = document.getElementById('bien_id').value.split('_');
            var medida = $('#umed_id').val();
            var cantidad = $('#canti_id').val();
            var precio = $('#prec_id').val();
            var tipo_impuesto_value = $('#tipo_impuesto_id').val();
            subtotal = (cantidad*precio).toFixed(2);
            if (bienes != "" && medida != "" && cantidad > 0 && precio > 0) {
                    total=parseFloat(total)+parseFloat(subtotal);
                    console.log(total);
                    var fila = '<tr class="selected igv_carta" id="filamp' + contador_mp +
                        '"><td class="align-middle fw-normal">' + contador_mp + '</td><td class="align-middle fw-normal">' + bienes[3] +
                    '</td><td class="align-middle fw-normal">' + bienes[1] +
                        '</td><td class="align-middle fw-normal">' + medida +
                        '</td><td class="align-middle fw-normal">' + cantidad +
                        '</td><td class="align-middle fw-normal">' + precio +
                        '</td><td class="align-middle fw-normal">' + tipo_impuesto_value +
                        '</td><td class="align-middle fw-normal">' + subtotal +
                        '</td><input type="hidden" name="tipo_producto[]" value="' + bienes[3] +
                        '"><input type="hidden" name="bienes[]" value="' + bienes[1] +
                        '"><input type="hidden" name="bien_id[]" value="' + bienes[0] +
                        '"><input type="hidden" name="medida[]" value="' + medida +
                        '"><input type="hidden" name="cantidad[]" value="' + cantidad +
                        '"><input type="hidden" name="precio[]" value="' + precio +
                        '"><input type="hidden" name="tipo_impuesto_value[]" value="' + tipo_impuesto_value +
                        '"><input type="hidden" name="subtotal[]" value="' + subtotal +
                        '"><td class="align-middle"><button class="btn btn-sm btn-danger" onclick="eliminardes(' +
                        contador_mp +','+subtotal + ');"><i class="bi bi-trash text-white"></i></button></td></tr>';
                    contador_mp++;
                    $("#subto_id").html((total/1.18).toFixed(2));
                    $("#total_id").val(total.toFixed(2));
                    $("#igv_id").html((parseFloat(((total/1.18)*0.18).toFixed(2))));
                    $("#totalidad_id").html(total.toFixed(2));
                    $('#bien_id').prop('selectedIndex', 0).change();
                    $('#tipo_impuesto_id').prop('selectedIndex', 0).change();
                    $('#umed_id').val("");
                    $('#canti_id').val("");
                    $('#prec_id').val("");
                    $('#dtll_compra').append(fila);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Error al ingresar el detalle del ingreso, revise los datos del requerimiento',
                })
            }
        });
    });
    function eliminardes(indexmp,subtotal) {
        total=parseFloat(total)-parseFloat(subtotal);
        if(total <= 0){
            $("#subto_id").html('0.00');
            $("#igv_id").html('0.00');
            total = 0;
        }else{
            $("#subto_id").html((total/1.18).toFixed(2));
            $("#igv_id").html((parseFloat(((total/1.18)*0.18).toFixed(2))));
        }
        $("#totalidad_id").html(total.toFixed(2));
        $("#total_id").val(total.toFixed(2));
        $("#filamp" + indexmp).remove();

        $('#bien_id').prop('selectedIndex', 0).change();
        $('#tipo_impuesto_id').prop('selectedIndex', 0).change();
    }
    
</script>
@endsection