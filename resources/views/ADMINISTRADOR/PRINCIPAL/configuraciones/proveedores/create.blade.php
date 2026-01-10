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
                        <li class="breadcrumb-item link" aria-current="page">Inicio</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
<!-- fin encabezado -->

    {{-- Contenido --}}
    <form method="POST" action="/admin-proveedores" enctype="multipart/form-data" autocomplete="off" class="needs-validation" novalidate>      
        @csrf
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
                        <div class="col-12 col-md-8 col-lg-9">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Datos del proveedor</p>
                            <div class="row g-2">
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="pb-2">
                                        <label for="nro_identificacion_id" class="">Nro de Identificación<span class="text-danger">*</span></label>
                                        <div class="input-group input-group-sm">
                                            <input type="number" name="nro_documento" class="form-control @error('nro_documento') is-invalid @enderror" required value="{{ old('nro_documento') }}" id="nro_iden_reniec">
                                            <button class="btn btn-secondary" type="button" id="button_addon2">Buscar</button>
                                        </div>
                                        @error('nro_documento')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="pb-2">
                                        <label for="identificacion_id" class="">Identificación<span class="text-danger">*</span></label>
                                        <select id="identificacion_id" name="tipo_documento" class="form-select form-select-sm @error('tipo_documento') is-invalid @enderror" required>
                                            <option value="{{ old('tipo_documento') }}" selected="selected" hidden="hidden">{{ old('tipo_documento') }}</option>
                                            @foreach($tiposdocumento as $tiposdocumentos)
                                                <option value="{{ $tiposdocumentos->abreviatura }}">{{$tiposdocumentos->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('identificacion')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="pb-2">
                                        <label for="giro_id" class="">Giro<span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm @error('giro') is-invalid @enderror" required name="giro" id="giro_id" >
                                            <option value="{{ old('giro') }}" selected="selected" hidden="hidden">{{ old('giro') }}</option>
                                            <option value="GENERAL">GENERAL</option>
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
                                        <label for="razonsocial_id" class="">Nombre o Razón social<span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="razonsocial_id" class="form-control form-control-sm @error('name') is-invalid @enderror" required value="{{ old('name') }}" maxLength="100">  
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="pb-2">
                                        <label for="email_id2" class="">Correo electrónico</label>
                                        <input type="email" name="email" id="email_id2" class="form-control form-control-sm @error('email') is-invalid @enderror" value="{{ old('email') }}" maxLength="100">  
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="pb-2">
                                        <label for="nro_celular_contacto_id" class="">Nro de contacto<span class="text-danger">*</span></label>
                                        <input type="number" name="nro_celular_contacto" id="nro_celular_contacto_id" class="form-control form-control-sm @error('nro_celular_contacto') is-invalid @enderror" required value="{{ old('nro_celular_contacto') }}" maxLength="100">  
                                        @error('nro_contacto')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-8">
                                    <div class="pb-2">
                                        <label for="direccion_id" class="">Dirección</label>
                                        <input type="text" name="direccion" id="direccion_id" class="form-control form-control-sm @error('direccion') is-invalid @enderror" value="{{ old('direccion') }}" maxLength="100">  
                                        @error('direccion')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="pb-2">
                                        <label for="referencia_id" class="">Referencia</label>
                                        <input type="text" name="referencia" id="referencia_id" class="form-control form-control-sm @error('referencia') is-invalid @enderror" value="{{ old('referencia') }}" maxLength="100">  
                                        @error('referencia')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="pb-2">
                                        <label for="direccion_fiscal__id" class="">Dirección Fiscal</label>
                                        <input type="text" name="direccion_fiscal" id="direccion_fiscal__id" class="form-control form-control-sm @error('direccion_fiscal') is-invalid @enderror" value="{{ old('direccion_fiscal') }}" maxLength="100">  
                                        @error('direccion_fiscal')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-4 col-lg-4">
                                    <div class="pb-2">
                                        <label for="ubigeos__ids" class="">Departamento - Provincia - Distrito<span class="text-danger">*</span></label>
                                        <select id="ubigeos__ids" class="form-select form-select-sm select2 @error('email') is-invalid @enderror" required style="width: 90%;">
                                            <option selected="selected" hidden="hidden">Seleccione una opcion</option>
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
                                                <option>Seleccione una opcion</option>
                                                @foreach($tipos as $tipo)
                                                    <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
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
                                        <label for="contacto_name_id" class="">Nombres y Apellidos</label>
                                        <input type="text" name="name_contacto" id="contacto_name_id" class="form-control form-control-sm @error('name_contacto') is-invalid @enderror" value="{{ old('name_contacto') }}" maxLength="100">  
                                        @error('name_contacto')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="pb-2">
                                        <label for="email_pnatural_id" class="">Correo electrónico</label>
                                        <input type="email" name="email_pnatural" id="email_pnatural_id" class="form-control form-control-sm @error('email_pnatural') is-invalid @enderror" value="{{ old('email_pnatural') }}" maxLength="100">  
                                        @error('email_pnatural')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="pb-2">
                                        <label for="nro_celular_id" class="">Nro de contacto</label>
                                        <input type="number" name="celular" id="nro_celular_id" class="form-control form-control-sm @error('celular') is-invalid @enderror" value="{{ old('celular') }}" maxLength="100">  
                                        @error('celular')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>    
                        <div class="col-12 col-md-4 col-lg-3">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Cuenta bancaria</p>
                            <div class="pb-2">
                                <label for="tipo_cuenta__id" class="">Tipo de cuenta</label>
                                <select name="tipo_cuenta_normal" class="form-select form-select-sm @error('tipo_cuenta_normal') is-invalid @enderror">
                                    <option value="{{ old('tipo_cuenta_normal') }}" selected="selected" hidden="hidden">{{ old('tipo_cuenta_normal') }}</option>
                                    @foreach($tiposcuentas as $tiposcuenta)
                                        <option value="{{ $tiposcuenta->name }}">{{ $tiposcuenta->name }}</option>
                                    @endforeach
                                </select>
                                @error('tipo_cuenta_normal')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="pb-2">
                                <label for="tipo_cuenta__id" class="">Banco</label>
                                <select name="entidad_bancaria_normal" class="form-select form-select-sm @error('entidad_bancaria_normal') is-invalid @enderror">
                                    <option value="{{ old('entidad_bancaria_normal') }}" selected="selected" hidden="hidden">{{ old('entidad_bancaria_normal') }}</option>
                                    @foreach($bancos as $banco)
                                        <option value="{{ $banco->name }}">{{ $banco->name }}</option>
                                    @endforeach
                                </select>
                                @error('entidad_bancaria_normal')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="pb-2">
                                <label for="nro_cuenta__id" class="">Nro de cuenta</label>
                                <input type="number" name="nro_cuenta_normal" class="form-control form-control-sm @error('nro_cuenta_normal') is-invalid @enderror" value="{{ old('nro_cuenta_normal') }}">   
                                @error('nro_cuenta_normal')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="pb-2">
                                <label for="nro_cuenta_cci__id" class="">Nro de cuenta CCI</label>
                                <input type="number" name="nro_cci_normal" class="form-control form-control-sm @error('nro_cci_normal') is-invalid @enderror" value="{{ old('nro_cci_normal') }}">   
                                @error('nro_cci_normal')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Cuenta de detracción</p>

                            <div class="pb-2">
                                <label for="tipo_cuenta__detraccion" class="">Tipo de cuenta</label>
                                <input hidden name="tipo_cuenta_detraccion" value="Cuenta Corriente de Detracciones">
                                <select class="form-select form-select-sm" disabled>
                                    @foreach($tiposcuentas as $tiposcuenta)
                                        <option value="{{ $tiposcuenta->name }}" @if($tiposcuenta->id == 11)
                                            selected                                            
                                        @endif>{{ $tiposcuenta->name }}</option>
                                    @endforeach
                                </select>
                                @error('tipo_cuenta__detraccion')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="pb-2">
                                <label for="banco_detraccion___id" class="">Banco</label>
                                <input hidden name="entidad_bancaria_detraccion" value="Banco de la Nación">
                                <select class="form-select form-select-sm" disabled>
                                    <option selected hidden>Selecciona banco</option>
                                    @foreach($bancos as $banco)
                                        <option value="{{ $banco->name }}" @if($banco->id == 8)
                                            selected                                            
                                        @endif>{{ $banco->name }}</option>
                                    @endforeach
                                </select>
                                @error('entidad_bancaria_detraccion')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="pb-2">
                                <label for="nro_cuenta_detraccion__id" class="">Nro de cuenta de detracción</label>
                                <input type="number" name="nro_cuenta_detraccion" class="form-control form-control-sm @error('nro_cuenta_detraccion') is-invalid @enderror" value="{{ old('nro_cuenta_detraccion') }}">   
                                @error('nro_cuenta_detraccion')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>                                      
                </div>
            </div>
            <div class="pt-2 pb-3 text-end" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
                <a href="{{ url('admin-proveedores') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary px-5 my-2 my-md-0 text-white">Registrar</button>
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
    $(document).ready(function() {
        $('#button_addon2').on('click', function(){
            var busqueda_iden = $('#nro_iden_reniec').val();
            if(busqueda_iden.length == 11){
                var tipo_reniec = 'RUC';
                $('#identificacion_id').prop('selectedIndex', 1);
            }if(busqueda_iden.length == 8){
                var tipo_reniec = 'DNI';
                $('#identificacion_id').prop('selectedIndex', 2);
            }
            $.get('/busqueda_reniec',{buscando: busqueda_iden, tipo_reniecs:tipo_reniec}, function(busqueda){
                $.each(busqueda, function(index, value){
                    let datos = JSON.parse(value);
                    var valor_docu_ruc = datos.data.nombre_o_razon_social;
                    var valor_docu_dni = datos.data.numero;
                    console.log(datos);
                    if(valor_docu_ruc){
                        $('#razonsocial_id').val("");
                        $('#direccion_id').val("");
                        $('#direccion_fiscal__id').val("");
                        $('#razonsocial_id').val(datos.data.nombre_o_razon_social);
                        $('#direccion_id').val(datos.data.direccion);
                        $('#direccion_fiscal__id').val(datos.data.direccion_completa);
                        $.get('/busqueda_reniec_ubigeo',{buscando_ubigeo: datos.data.ubigeo_sunat}, function(busqueda_ub){
                            $.each(busqueda_ub, function(index, value){
                                $('#ubigeos__ids').prop('selectedIndex', 0).change();
                                $('#ubigeos__ids').prop('selectedIndex', index).change();
                                //$('#ubigeos__ids').append("<option value='" + index +"'>" + value[1] +'/'+value[2]+'/'+value[3]+ "</option>");
                            });
                        });
                    }if(valor_docu_dni){
                        $('#razonsocial_id').val("");
                        $('#razonsocial_id').val(datos.data.apellido_paterno+' '+datos.data.apellido_materno+' '+datos.data.nombres);
                    }
                })
            });
        });

        /*$('#identificacion_id').on('change', function(){
            var iden = document.getElementById('identificacion_id').value.split('_');
            console.log(iden[0]);
            $('#tipod_id').empty();
            $('#tipod_id').val(iden[1]);
        });*/
    });
</script>
@endsection