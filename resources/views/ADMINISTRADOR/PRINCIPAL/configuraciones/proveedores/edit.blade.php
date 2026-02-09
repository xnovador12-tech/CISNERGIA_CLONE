@extends('TEMPLATES.administrador')

@section('title', 'PROVEEDORES')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<!-- Encabezado -->
<div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">PROVEEDORES</h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ url('admin-configuraciones') }}">Configuraciones</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ url('admin-proveedores') }}">Proveedores</a></li>
                        <li class="breadcrumb-item" aria-current="page">Actualizar registro</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
<!-- fin encabezado -->

    {{-- Contenido --}}
    <form method="POST" action="/admin-proveedores/{{ $admin_proveedore->slug }}" enctype="multipart/form-data" autocomplete="off" class="needs-validation" novalidate>      
        @csrf
        @method('put')
        <div class="container-fluid">
            <div class="card border-4 borde-top-primary shadow-sm h-100" style="border-radius: 20px; min-height: 500px" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
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
                    <div class="row">
                        <input hidden id="proveedors_id" value="{{ $admin_proveedore->proveedor->id }}">
                        <div class="col-12 col-md-6 col-lg-6">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Datos del proveedor</p>
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="pb-2">
                                        <label for="nro_identificacion_id" class="">Nro de Identificación<span class="text-danger">*</span></label>
                                        <div class="input-group input-group-sm">
                                            <input type="number" value="{{ $admin_proveedore->nro_identificacion }}" name="nro_identificacion" required class="form-control @error('nro_identificacion') is-invalid @enderror">
                                            <button class="btn btn-secondary" type="button" id="button-addon2">Buscar</button>
                                        </div>
                                        @error('nro_identificacion')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="pb-2">
                                        <label for="identificacion_id"  class="">Identificación<span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm @error('identificacion') is-invalid @enderror" required name="identificacion">
                                            @if($admin_proveedore->identificacion == 'RUC')
                                                <option value="{{ $admin_proveedore->identificacion }}" selected="selected" hidden="hidden">Registro unico del contribuyente</option>
                                            @elseif($admin_proveedore->identificacion == 'DNI')
                                                <option value="{{ $admin_proveedore->identificacion }}" selected="selected" hidden="hidden">Documento Nacional de identidad</option>
                                            @elseif($admin_proveedore->identificacion == 'CE')
                                                <option value="{{ $admin_proveedore->identificacion }}" selected="selected" hidden="hidden">Carnet de extranjería</option>
                                            @elseif($admin_proveedore->identificacion == 'PP')
                                                <option value="{{ $admin_proveedore->identificacion }}" selected="selected" hidden="hidden">Pasaporte</option>
                                            @else
                                                <option value="{{ $admin_proveedore->identificacion }}" selected="selected" hidden="hidden">Documento tributario no domiciliado sin ruc</option>
                                            @endif
                                            @foreach($tiposdocumento as $tiposdocumentos)
                                                <option value="{{ $tiposdocumentos->abreviatura }}">{{ $tiposdocumentos->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('tipo_documento')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="pb-2">
                                        <label for="giro_id" class="">Giro<span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm @error('giro') is-invalid @enderror" required name="giro" id="giro_id" >
                                            <option value="{{ $admin_proveedore->proveedor->giro }}" selected="selected" hidden="hidden">{{ $admin_proveedore->proveedor->giro }}</option>
                                            <option value="Agropecuario">Agropecuario</option>
                                            <option value="Comercio">Comercio</option>
                                            <option value="Produccion">Produccion</option>
                                            <option value="Servicio">Servicio</option>
                                        </select>
                                        @error('giro')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="pb-2">
                                        <label for="name_contacto_id" class="">Nombre o Razón social<span class="text-danger">*</span></label>
                                        <input type="text" name="name_contacto" id="name_contacto_id" class="form-control form-control-sm @error('name_contacto') is-invalid @enderror" required value="{{ $admin_proveedore->proveedor->name_contacto }}" maxLength="100">  
                                        @error('name_contacto')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="pb-2">
                                        <label for="email_contacto_id" class="">Correo electrónico<span class="text-danger">*</span></label>
                                        <input type="email" name="email_contacto" id="email_contacto_id" class="form-control form-control-sm @error('email_contacto') is-invalid @enderror" required value="{{ $admin_proveedore->proveedor->email_contacto }}" maxLength="100">  
                                        @error('email_contacto')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="pb-2">
                                        <label for="nro_celular_contacto_id" class="">Nro de contacto<span class="text-danger">*</span></label>
                                        <input type="number" name="nro_celular_contacto" id="nro_celular_contacto_id" class="form-control form-control-sm @error('nro_celular_contacto') is-invalid @enderror" required value="{{ $admin_proveedore->proveedor->nro_celular_contacto }}" maxLength="100">  
                                        @error('nro_celular_contacto')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-8">
                                    <div class="pb-2">
                                        <label for="direccion_id" class="">Dirección</label>
                                        <input type="text" name="direccion" id="direccion_id" class="form-control form-control-sm @error('direccion') is-invalid @enderror" value="{{ $admin_proveedore->direccion }}" maxLength="100">  
                                        @error('direccion')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="pb-2">
                                        <label for="referencia_id" class="">Referencia</label>
                                        <input type="text" name="referencia" id="referencia_id" class="form-control form-control-sm @error('referencia') is-invalid @enderror" value="{{ $admin_proveedore->referencia }}" maxLength="100">  
                                        @error('referencia')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="pb-2">
                                        <label for="direccion_fiscal__id" class="">Dirección Fiscal</label>
                                        <input type="text" name="direccion_fiscal" id="direccion_fiscal__id" class="form-control form-control-sm @error('direccion_fiscal') is-invalid @enderror" value="{{ $admin_proveedore->proveedor->direccion_fiscal }}" maxLength="100">  
                                        @error('direccion_fiscal')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-4 col-lg-4">
                                    <div class="pb-2">
                                        <label for="identificacion_id" class="">Departamento<span class="text-danger">*</span></label>
                                        <select id="ubigeos__ids" class="form-select form-select-sm @error('distrito_id') is-invalid @enderror">
                                            <option value="{{ $admin_proveedore->proveedor->departamento->id }}" selected="selected" hidden="hidden">{{ $admin_proveedore->proveedor->departamento->name}}</option>
                                            @foreach($ubigeos as $ubigeo) 
                                                <option value="{{ $ubigeo->departamento_ids }}">{{ $ubigeo->departamento_name}}</option>
                                            @endforeach
                                        </select>
                                        <input hidden id="departamento_ids" name="departamento_id">
                                        <!-- <input hidden id="provincias_ids" name="provincia_id"> -->
                                        <!-- <input hidden id="distritos_ids" name="distrito_id"> -->
                                        @error('distrito_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-8 col-lg-8">
                                    <div class="pb-2">
                                    <label for="tipo_id" class="">Tipo</label>
                                        <div class="row">
                                            <select class="js-example-basic-multiple form-select form-select-sm select2" name="tipos[]" multiple="multiple">
                                                @foreach($tipos as $tipo)
                                                @php
                                                    $tip = false;
                                                    $tipos_asigns = DB::table('proveedor_tipo')->join('tipos','proveedor_tipo.tipo_id','=','tipos.id')
                                                    ->select('proveedor_tipo.tipo_id', 'tipos.name')
                                                    ->where('proveedor_tipo.tipo_id',$tipo->id)
                                                    ->where('proveedor_tipo.proveedor_id',$admin_proveedore->proveedor->id)->get();
    
                                                    foreach($tipos_asigns as $tipos_asign){
                                                        $tip = $tipos_asign->tipo_id;
                                                        $tipn = $tipos_asign->name;
                                                    }
                                                @endphp
                                                <option {{ $tip?'selected':'' }} value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Datos de persona de contacto</p>

                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="pb-2">
                                        <label for="name_id" class="">Nombres y Apellidos</label>
                                        <input type="text" name="name" id="name_id" class="form-control form-control-sm @error('name') is-invalid @enderror" value="{{ $admin_proveedore->name }}" maxLength="100">  
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="pb-2">
                                        <label for="email_pnatural_id" class="">Correo electrónico</label>
                                        <input type="email" name="email_pnatural" id="email_pnatural_id" class="form-control form-control-sm @error('email_pnatural') is-invalid @enderror" value="{{ $admin_proveedore->email_pnatural }}" maxLength="100">  
                                        @error('email_pnatural')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="pb-2">
                                        <label for="celular__id" class="">Nro de contacto</label>
                                        <input type="number" name="celular" id="celular__id" class="form-control form-control-sm @error('celular') is-invalid @enderror" value="{{ $admin_proveedore->celular }}" maxLength="100">  
                                        @error('celular')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>    
                        <div class="col-12 col-md-6 col-lg-6">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Cuenta bancaria</p>
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <p class="text-primary mb-0 small text-uppercase fw-bold">Detalles</p>
                                        <button type="button" id="btnasignar" class="btn btn-secondary btn-sm text-white py-0 px-2">
                                            Agregar
                                        </button>
                                    </div>
                                    <div class="row g-2 align-items-end">
                                        <div class="col-6 col-md-3 col-lg-3 mb-3">
                                            <label for="tipo_cuenta_id" class=" d-block">Tipo de Cuenta</label>
                                            <select class="form-select select2 form-select-sm" id="tipo_cuenta_id">
                                                <option selected disabled>Seleccione opción</option>
                                                        @foreach($tiposcuentas as $tiposcuenta)
                                                <option value="{{ $tiposcuenta->name }}">{{ $tiposcuenta->name }}</option>
                                            @endforeach
                                            </select>  
                                        </div>
                                        <div class="col-6 col-md-3 col-lg-3 mb-3">
                                            <label for="banco_id" class=" d-block">Banco</label>
                                            <select class="form-select form-select-sm select2 @error('entidad_bancaria_normal') is-invalid @enderror" id="banco_id">
                                                <option value="{{ old('entidad_bancaria_normal') }}" selected="selected" hidden="hidden">{{ old('entidad_bancaria_normal') }}</option>
                                                @foreach($bancos as $banco)
                                                    <option value="{{ $banco->name }}">{{ $banco->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6 col-md-3 col-lg-3 mb-3">
                                            <label for="nro_cuenta_id" class=" d-block">Nro de cuenta</label>
                                            <input type="number" id="nro_cuenta_id" class="form-control form-control-sm @error('nro_cuenta_normal') is-invalid @enderror" value="{{ old('nro_cuenta_normal') }}" maxLength="100">
                                        </div>
                                        <div class="col-6 col-md-3 col-lg-3 mb-3">
                                            <label for="nro_cci_id" class=" d-block">Nro de cuenta CCI</label>
                                            <input type="number" id="nro_cci_id" class="form-control form-control-sm @error('nro_cci_normal') is-invalid @enderror" value="{{ old('nro_cci_normal') }}" maxLength="100">
                                        </div>
                                    </div>
                                    <table class=" table table-sm table-hover">
                                        <thead class="bg-light">
                                        <tr>
                                            <th class="fw-bold small text-uppercase">Tipo de Cuenta</th>
                                            <th class="fw-bold small text-uppercase">Banco</th>
                                            <th class="fw-bold small text-uppercase">Nro de cuenta</th>
                                            <th class="fw-bold small text-uppercase">Nro de CCI</th>
                                            <th class="fw-bold small text-uppercase"></th>
                                        </tr>
                                        </thead>
                                        <tbody id="dtll_cuentas">
                                            
                                        </tbody>
                                    </table>
                                </div>    
                            </div>

                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Cuenta de detracción</p>

                            <div class="pb-2">
                                <label for="tipo_cuenta__id" class="">Tipo de cuenta<span class="text-danger">*</span></label>
                                <input name="tipo_cuenta_detraccion" hidden value="Cuenta Corriente de Detracciones" class="form-select form-select-sm">
                                <select class="form-select form-select-sm" disabled>
                                    @foreach($tiposcuentas as $tiposcuenta)
                                        <option value="{{ $tiposcuenta->name }}" @if($tiposcuenta->id == 11)
                                            selected                                            
                                        @endif>{{ $tiposcuenta->name }}</option>
                                    @endforeach
                                </select>
                                @error('tipo_cuenta_detraccion')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="pb-2">
                                <label for="banco_detraccion___id" class="">Banco<span class="text-danger">*</span></label>
                                <input name="entidad_bancaria_detraccion" hidden value="Banco de la Nación" class="form-select form-select-sm">
                                <select class="form-select form-select-sm" disabled>
                                    @foreach($bancos as $banco)
                                        <option value="{{ $banco->name }}" @if($banco->id == 8)
                                            selected                                            
                                        @endif>{{ $banco->name }}</option>
                                    @endforeach
                                </select>
                                @error('banco_detraccion')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="pb-2">
                                <label for="nro_cuenta_detraccion__id" class="">Nro de cuenta de detracción<span class="text-danger">*</span></label>
                                <input type="number" name="nro_cuenta_detraccion" class="form-control form-control-sm @error('nro_cuenta_detraccion') is-invalid @enderror" required value="{{ $admin_proveedore->proveedor->nro_cuenta_detraccion }}">   
                                @error('nro_cuenta_detraccion')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>                                      
                </div>
            </div>
            <div class="pt-3 pb-3 text-end" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
                <a href="{{ url('admin-proveedores') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary px-5 my-2 my-md-0 text-white">Actualizar</button>
            </div>     
        </div>  
    </form>
    {{-- Fin contenido --}}

@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
<script>
    $(document).ready(function() {
        var ubigeos_carga_rapida = document.getElementById('ubigeos__ids').value.split('_');
        $('#departamento_ids').val("");
        $('#provincias_ids').val("");
        $('#distritos_ids').val("");
        $('#departamento_ids').val(ubigeos_carga_rapida[0]);
        $('#provincias_ids').val(ubigeos_carga_rapida[1]);
        $('#distritos_ids').val(ubigeos_carga_rapida[2]);
        $('#ubigeos__ids').on('change', function(){
            
            var ubigeos_consulta = document.getElementById('ubigeos__ids').value.split('_');
            $('#departamento_ids').val("");
            $('#provincias_ids').val("");
            $('#distritos_ids').val("");
            $('#departamento_ids').val(ubigeos_consulta[0]);
            $('#provincias_ids').val(ubigeos_consulta[1]);
            $('#distritos_ids').val(ubigeos_consulta[2]);
        });
    });
</script>

<script>
    var contador_cuentas = 1;

    $.get('/busqueda_list_cuentas',{id_proveedor: $('#proveedors_id').val()}, function(busqueda){
        $.each(busqueda, function(index, value){
            var fila = '<tr class="selected igv_carta" id="filamp' + contador_cuentas +
                        '"><input type="hidden" name="contadores[]" value="' + contador_cuentas +
                        '"><td class="align-middle fw-normal">' + value[0] + '</td><td class="align-middle fw-normal">' + value[1] +
                        '</td><td class="align-middle fw-normal"><input type="text" class="form-control form-control-sm" name="nro_cuenta_normal[]" value="' + value[2] +
                        '"></td><td class="align-middle fw-normal"><input type="text" class="form-control form-control-sm" name="nro_cci_normal[]" value="' + value[3] +
                        '"></td><input type="hidden" name="tipo_cuenta_normal[]" value="' + value[0] +
                        '"><input type="hidden" name="entidad_bancaria_normal[]" value="' + value[1] +
                        '"><td class="align-middle"><button type="button" class="btn btn-sm btn-danger text-white" onclick="eliminarcuentas(' +
                contador_cuentas +');"><i class="bi bi-trash"></i></button></td></tr>';
                contador_cuentas++;

                $('#dtll_cuentas').append(fila);
        });
    });
    $('#btnasignar').click(function() {
        var tipo_cuenta = $('#tipo_cuenta_id').val();
        var banco = $('#banco_id').val();
        var nro_cuenta = $('#nro_cuenta_id').val();
        var nro_cci = $('#nro_cci_id').val();
        if(tipo_cuenta && banco && nro_cuenta && nro_cci){
            var fila = '<tr class="selected igv_carta" id="filamp' + contador_cuentas +
                        '"><input type="hidden" name="contadores[]" value="' + contador_cuentas +
                        '"><td class="align-middle fw-normal">' + tipo_cuenta + '</td><td class="align-middle fw-normal">' + banco +
                        '</td><td class="align-middle fw-normal"><input type="text" class="form-control form-control-sm" name="nro_cuenta_normal[]" value="' + nro_cuenta +
                        '"></td><td class="align-middle fw-normal"><input type="text" class="form-control form-control-sm" name="nro_cci_normal[]" value="' + nro_cci +
                        '"></td><input type="hidden" name="tipo_cuenta_normal[]" value="' + tipo_cuenta +
                        '"><input type="hidden" name="entidad_bancaria_normal[]" value="' + banco +
                        '"><td class="align-middle"><button type="button" class="btn btn-sm btn-danger text-white" onclick="eliminarcuentas(' +
                contador_cuentas +');"><i class="bi bi-trash"></i></button></td></tr>';
                contador_cuentas++;
                $('#tipo_cuenta_id').prop('selectedIndex', 0).change();
                $('#banco_id').prop('selectedIndex', 0).change();
                $('#nro_cuenta_id').val("");
                $('#nro_cci_id').val("");
                $('#dtll_cuentas').append(fila);
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Error al ingresar el detalle del ingreso, revise los datos del requerimiento',
            })
        }
    });

    function eliminarcuentas(indexmp) {
        
        $("#filamp" + indexmp).remove();

        if(indexmp == 0 || indexmp == 1 || indexmp == ''){
            contador_cuentas = 1;
        }
    }
</script>
@endsection