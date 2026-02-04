@extends('TEMPLATES.administrador')

@section('title', 'PRODUCTOS')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    #container_images_multiple{
        display: flex;
        justify-content: space-evenly;
        gap: 20px;
        flex-wrap: wrap;
    }

    figure{
        width: 30%;
    }

    .img_opcional{
        width: 100%;
        height: 150px;
    }

    figcaption{
        text-align: center;
        font-size: 1.8vmin;
        margin-top: 0.5vmin;
    }

    @media only screen and (min-width:320px) and (max-width:768px){
        .img_opcional{
        width: 100%;
        height: 90px;
    }
    }
</style>
@endsection

@section('content')
<!-- Encabezado -->
<div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">PRODUCTOS</h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ url('admin-configuraciones') }}">Configuraciones</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ url('admin-productos') }}">Productos</a></li>
                        <li class="breadcrumb-item" aria-current="page">Nuevo registro</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
<!-- fin encabezado -->

    {{-- Contenido --}}
    <form method="POST" action="/admin-productos" enctype="multipart/form-data" autocomplete="off" class="needs-validation" novalidate>      
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
                                <li class="mb-0 pb-0">
                                    <small class="text-muted">Se recomienda tener en cuenta las siguientes medidas para la imágen: <span class="fw-bold">1200 x 1200 px.</span> Peso máximo de imagen:<span class="fw-bold"> 3 MB.</span></small>
                                </li>
                            </ul>
                        </div>
                    </div>     

                    <div class="row">
                        <div class="col-12 col-md-8 col-lg-9">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Datos generales</p>
                            <div class="row">
                                <div class="col-6 col-md-3 col-lg-2">
                                    <div class="mb-3">
                                        <label for="codigo_id" class="">Código<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3 col-lg-2">
                                    <div class="mb-3">
                                        <input type="text" value="{{ $codigo }}" class="form-control form-control-sm bg-white" disabled id="codigo_id">
                                        <input hidden value="{{ $codigo }}" name="codigo">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-7">
                                    <div class="mb-3">
                                        <label for="codigo_id" class="">Nombre<span class="text-danger">*</span></label>
                                        <input type="text" name="name"  class="form-control form-control-sm @error('name') is-invalid @enderror" required>
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-3 col-lg-2">
                                    <div class="mb-3">
                                        <label for="peso__id" class="">Peso</label>
                                        <input type="decimal" value="{{ old('peso') }}" name="peso" class="form-control form-control-sm bg-white" id="peso__id">
                                    </div>
                                </div>
                                <div class="col-12 col-md-3 col-lg-3">
                                    <div class="mb-3">
                                        <label for="tipos__producto_id" class="">Tipo de bien<span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm @error('tipo_id') is-invalid @enderror" id="tipos__producto_id" required>
                                            <option value="{{old('tipo_id')}}" selected="selected" hidden="hidden">{{ old('tipo_id') }}</option>
                                            @foreach($tipos as $tipo)
                                                <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" class="form-control form-control-sm" name="tipo_id" id="id_tipo" required>
                                        @error('tipo_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-3 col-lg-3">
                                    <div class="mb-3">
                                        <label for="categorias__id" class="">Categoría<span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm select2 @error('categoria_id') is-invalid @enderror"  name="categorie_id" id="categorias__id" required>
                                            <option value="{{ old('categoria_id') }}" selected="selected" hidden="hidden">{{ old('categoria_id') }}</option>
                                        </select>
                                        @error('categoria_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-3 col-lg-3">
                                    <div class="mb-3">
                                        <label for="medida__id" class="">Unidad de medida<span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm @error('medida_id') is-invalid @enderror" name="medida_id"  id="medida__id" required>
                                            <option value="{{ old('medida_id') }}" selected="selected" hidden="hidden">-- Seleccione --</option>
                                            @foreach($medidas as $medida)
                                                <option value="{{ $medida->id }}">{{ $medida->nombre }}</option>
                                            @endforeach
                                        </select>
                                        @error('medida_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-3 col-lg-3">
                                    <div class="mb-3">
                                        <label for="marcas__id" class="">Marca</label>
                                        <select class="form-select form-select-sm @error('marca') is-invalid @enderror" name="marca_id"  id="marcas__id">
                                            <option value="{{ old('marca_id') }}" selected="selected" hidden="hidden">{{ old('marca_id') }}</option>
                                            @foreach($marcas as $marca)
                                                <option value="{{ $marca->id }}">{{ $marca->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('marca_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            
                            <div class="row">
                                <div class="col-12 col-md-9">
                                    <div class="mb-3">
                                        <label for="descripcion_id" class="">Descripción</label>
                                        <textarea class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" id="editor" placeholder="Escribe una descripción" style="height: 210px">{{ old('descripcion') }}</textarea>
                                        @error('descripcion')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-9 col-md-3 mb-3">
                                    <label for="" class="">Imagen Principal</label>
                                    <div class="card text-center imagecard rounded mb-0" style="height: auto">  
                                        <label for="uploadImage1" class=" my-auto text-center">
                                            <img for="uploadImage1" id="uploadPreview1" alt="" class="py-auto rounded" style="width: 100%; height: 100%;" src="/images/icon-photo.png">   
                                        </label>
                                    </div>
                                    <input id="uploadImage1" class="form-control-file" type="file" name="imagen" onchange="previewImagePrincipal(1);" hidden/>
                                    @error('imagen')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <br>
                            <p class="text-secondary mb-2 small text-uppercase fw-bold" id="title_opcional">Datos adicionales</p>

                            <div class="row" >
                                <div class="col-12 col-md-2 col-lg-2" id="act_vidautil">
                                    <div class="mb-3">
                                        <label for="vidautil__id" class="">Vida útil</label>
                                        <div class="input-group input-group-sm mb-3">
                                            <input type="text" name="vida_util" value="" class="form-control form-control-sm @error('vida_util') is-invalid @enderror" id="vidautil__id">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">AÑOS</span>
                                        </div>
                                        @error('vida_util')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-2 col-lg-2" id="act_costo">
                                    <div class="mb-3">
                                        <label for="costo__id" class="">Costo</label>
                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">S/</span>
                                            <input type="text" name="costo" value="" class="form-control form-control-sm @error('costo') is-invalid @enderror" id="costo__id">
                                        </div>
                                        @error('costo')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-3 col-lg-3" id="act_depreciacion">
                                    <div class="mb-3">
                                        <label for="depreciacion__id" class="">Depreciación</label>
                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">S/</span>
                                            <input type="text" name="depreciacion" class="form-control form-control-sm @error('depreciacion') is-invalid @enderror" id="depreciacion__id">
                                        </div>
                                        @error('depreciacion')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-3 col-lg-3" id="act_tipo_adquisicion">
                                    <div class="mb-3">
                                        <label for="tipo_adquisicion_id" class="">Tipo de adquisición</label>
                                        <div class="input-group input-group-sm mb-3">
                                            <select class="form-select form-select-sm @error('tipo_adquisicion') is-invalid @enderror" name="tipo_adquisicion" id="tipo_adquisicion_id">
                                                <option selected='selected' hidden='hidden'>-- Seleccione --</option>
                                                <option value="Publico">Publico</option>
                                                <option value="Privado">Privado</option>
                                            </select>
                                        </div>
                                        @error('tipo_adquisicion')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-2 col-lg-2" id="pt_precio">
                                    <div class="mb-3">
                                        <label for="precio__id" class="">Precio</label>
                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">S/</span>
                                            <input type="decimal" name="precio" value="" class="form-control form-control-sm @error('precio') is-invalid @enderror" id="precio__id">
                                        </div>
                                        @error('precio')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3" id="pt_imgopcional">
                                <p class="text-muted mb-2 small text-uppercase fw-bold">Cargue más imágenes (opcional)</p> 
                                <div class="card imagecardfiles" style="min-height: 200px">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <label for="multiple__imagenes" class="btn btn-sm btn-secondary"><i class="bi bi-upload me-2"></i>Subir imágenes</label>
                                                <input type="file" onchange="preview()" multiple accept="image/*" id="multiple__imagenes" name="images_opcional[]" hidden>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <p id="numero_archivos" class="text-start text-md-end small fw-bold text-muted">0 archivos seleccionados</p>
                                            </div>
                                        </div>
                                        <div id="container_images_multiple">
    
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>    
                        <div class="col-12 col-md-4 col-lg-3">
                            <div class="mb-3" id="etiquetas">
                                <p class="text-secondary mb-2 small text-uppercase fw-bold">Etiquetas</p>
                                <select class="js-example-basic-multiple form-select form-select-sm select2" name="etiquetas[]" multiple="multiple" style="width:100%">
                                    @foreach($etiquetas as $etiqueta)
                                    <option value="{{ $etiqueta->id }}">{{ $etiqueta->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3" id="proveedores">
                                <p class="text-secondary mb-2 small text-uppercase fw-bold">Proveedores</p>
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <select class="js-example-basic-multiple form-select form-select-sm select2" name="proveedores[]" id="mostrar_prov" multiple="multiple" style="width:100%">
                                        </select>
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>                                      
                </div>
            </div>
            <div class="pt-3 pb-3 text-end" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
                <a href="{{ url('admin-productos') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary px-5 my-2 my-md-0 text-white">Registrar</button>
            </div>     
        </div> 
    </form>
    {{-- Fin contenido --}}

@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>
<script>
    function previewImagePrincipal(nb) {        
        var reader = new FileReader();         
        reader.readAsDataURL(document.getElementById('uploadImage'+nb).files[0]);                
        reader.onload = function (e) {   
            document.getElementById('uploadPreview'+nb).src = e.target.result;                  
        };     
    }
</script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
<script>
    $(document).ready(function() {
        $('#tipos__producto_id').on('change', function() {
            var valor_bienes = $(this).val();
            $('#tipos__producto_id').attr("disabled","disabled");
            $("#id_tipo").val(valor_bienes);
            $.get('/busqueda_categoria_productos', {valor_bienes: valor_bienes}, function(bienes) {
                $('#categorias__id').empty();
                $('#categorias__id').append(
                    "<option selected='selected' hidden='hidden'>-- Seleccione --</option>");
                $.each(bienes, function(index, value) {
                    $('#categorias__id').append("<option value='"+index+"'>" + value[0] + "</option>");
                });
            });

            $("#id_tipo").val(valor_bienes);
            var __tipo = $("#id_tipo").val();
            console.log(__tipo);
                if (__tipo == 1)
                {
                    $("#title_opcional").hide();
                    $("#act_vidautil").show();
                    $("#act_costo").show();
                    $("#act_depreciacion").show();
                    $("#act_tipo_adquisicion").show();
                    $("#pt_precio").show();
                    $("#pt_costo").show();
                    $("#pt_imgopcional").hide();
                    $("#proveedores").show();
                    $("#etiquetas").show();

                    $.get('/busqueda_proved', {valor_tip: __tipo}, function(bienes) {
                        $('#mostrar_prov').empty();
                        $('#mostrar_prov').append('<option>Seleccione una opcion</option>');
                        $.each(bienes, function(index, value) {
                            $('#mostrar_prov').append("<option value='"+index+"'>"+value[0]+"</option>");
                            
                        });
                    });
                }
                if (__tipo == 2)
                {
                    $("#title_opcional").show();
                    $("#act_vidautil").show();
                    $("#act_costo").show();
                    $("#act_depreciacion").show();
                    $("#act_tipo_adquisicion").show();
                    $("#pt_precio").show();
                    $("#pt_costo").show();
                    $("#pt_imgopcional").hide();
                    $("#proveedores").show();
                    $("#etiquetas").show();

                    $.get('/busqueda_proved', {valor_tip: __tipo}, function(bienes) {
                         $('#mostrar_prov').empty();
                        $('#mostrar_prov').append('<option>Seleccione una opcion</option>');
                        $.each(bienes, function(index, value) {
                            $('#mostrar_prov').append("<option value='"+index+"'>"+value[0]+"</option>");
                            
                        });
                    });
                }

                if (__tipo == 3 || __tipo == 4 )
                {
                    $("#title_opcional").hide();
                    $("#act_vidautil").show();
                    $("#act_costo").show();
                    $("#act_depreciacion").show();
                    $("#act_tipo_adquisicion").show();
                    $("#pt_precio").show();
                    $("#pt_costo").show();
                    $("#pt_imgopcional").show();
                    $("#show").hide();
                    $("#proveedores").show();
                    $("#etiquetas").show();

                    $.get('/busqueda_proved', {valor_tip: __tipo}, function(bienes) {
                        $('#mostrar_prov').empty();
                        $('#mostrar_prov').append('<option>Seleccione una opcion</option>');
                        $.each(bienes, function(index, value) {
                            $('#mostrar_prov').append("<option value='"+index+"'>"+value[0]+"</option>");
                            
                        });
                    });

                }
        });
    });

    $("#title_opcional").hide();
    $("#act_vidautil").hide();
    $("#act_costo").hide();
    $("#act_depreciacion").hide();
    $("#act_tipo_adquisicion").hide();
    $("#pt_precio").hide();
    $("#pt_costo").hide();
    $("#pt_imgopcional").hide();
    $("#id_tipo").hide();
    $("#etiquetas").hide();
    $("#proveedores").hide();
    
</script>
<script>
    let multiple__imagenes = document.getElementById("multiple__imagenes");
    let container_images_multiple = document.getElementById("container_images_multiple");
    let numero_archivos = document.getElementById("numero_archivos");

    function preview(){
        container_images_multiple.innerHTML = "";
        numero_archivos.textContent = `${multiple__imagenes.files.length} archivos seleccionados`;

        for(i of multiple__imagenes.files){
            let reader = new FileReader();
            let figure = document.createElement("figure");
            let figCap = document.createElement("figcaption");
            figCap.innerText = i.name;
            figure.appendChild(figCap);
            reader.onload=()=>{
                let img = document.createElement("img");
                img.setAttribute("src",reader.result);
                img.classList.add('img_opcional');
                figure.insertBefore(img,figCap);
            }
            container_images_multiple.appendChild(figure);
            reader.readAsDataURL(i);
        }

    }

</script>

@endsection