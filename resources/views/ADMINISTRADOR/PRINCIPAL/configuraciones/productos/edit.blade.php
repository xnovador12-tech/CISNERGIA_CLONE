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
                        <li class="breadcrumb-item" aria-current="page">Actualizar registro</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
<!-- fin encabezado -->

    {{-- Contenido --}}
    <form method="POST" action="/admin-productos/{{ $admin_producto->slug }}" enctype="multipart/form-data" autocomplete="off" class="needs-validation" novalidate>      
        @csrf
        @method('put')
        <input hidden value="{{ $admin_producto->id }}" id="valir_prod">
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
                                        <input type="text" value="{{ $admin_producto->codigo }}" class="form-control form-control-sm bg-white" disabled id="codigo_id">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-3 col-lg-3">
                                    <div class="mb-3">
                                        <label for="clasificacion___id" class="">Clasificación<span class="text-danger">*</span></label>
                                        <select class="form-select form-select-sm @error('clasificacion') is-invalid @enderror" disabled id="clasificacion___id" required>
                                            <option value="{{ $admin_producto->clasificacion }}" selected="selected" hidden="hidden">{{ $admin_producto->clasificacion }}</option>
                                        </select>
                                        <input type="text" class="form-control form-control-sm" name="clasificacion" id="id_tipo" required>
                                        @error('clasificacion')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-7">
                                    <div class="mb-3">
                                        <label for="codigo_id" class="">Nombre<span class="text-danger">*</span></label>
                                        <input type="text" name="name" value="{{ $admin_producto->name }}" class="form-control form-control-sm @error('name') is-invalid @enderror" required>
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6 col-md-3 col-lg-2">
                                    <div class="mb-3">
                                        <label for="peso_id" class="">Peso</label>
                                        <input type="decimal" name="peso" value="{{ $admin_producto->peso }}" class="form-control form-control-sm bg-white" id="peso_id">
                                    </div>
                                </div>
                                <div class="col-12 col-md-3 col-lg-3">
                                    <div class="mb-3">
                                        <label for="tipos__bien_id" class="">Tipo de bien<span class="text-danger">*</span></label>
                                        <label type="text" class="form-control form-control-sm @error('tipo_id') is-invalid @enderror">{{ $admin_producto->tipo->name }}</label required>
                                        <input hidden id="tipos__bien_id" value="{{ $admin_producto->tipo->id }}">
                                        @error('tipo_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-3 col-lg-3">
                                    <div class="mb-3">
                                        <label for="categories__id" class="">Categoría<span class="text-danger">*</span></label>
                                        <label type="text" class="form-control form-control-sm @error('categoria_id') is-invalid @enderror">{{ $admin_producto->categorie->name }}</label>
                                        @error('categoria_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-3 col-lg-3">
                                    <div class="mb-3">
                                        <label for="categorias__id" class="">Unidad de medida<span class="text-danger">*</span></label>
                                        <label type="text" class="form-control form-control-sm @error('medida_id') is-invalid @enderror">{{ $admin_producto->medida->nombre }}</label>
                                        @error('medida_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-3 col-lg-3">
                                    <div class="mb-3">
                                        <label for="marcas__id" class="">Marca</label>
                                        <select class="form-select form-select-sm select2 @error('marca') is-invalid @enderror" name="marca_id" id="marcas__id" >
                                            <option value="{{ $admin_producto->marca->id }}" selected="selected" hidden="hidden">{{ $admin_producto->marca->name }}</option>
                                            @foreach($marcas as $marca)
                                                <option value="{{ $marca->id }}">{{ $marca->name }}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" id="id_marca" value="{{ $admin_producto->marca }}" name="marca" class="form-control form-control-sm @error('marca') is-invalid @enderror">
                                        @error('marca')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-3 col-lg-3" id="tipo_afectacion_show">
                                    <div class="mb-3">
                                        <label for="tipo_afectacion" class="">Asignacion de Impuesto</label>
                                        <select class="form-select form-select-sm @error('tipo_afectacion') is-invalid @enderror" name="tipo_afectacion"  id="tipo_afectacion">
                                            <option value="{{ $admin_producto->tipo_afectacion }}" selected="selected" hidden="hidden">{{ $admin_producto->tipo_afectacion }}</option>
                                            <option value="0.18">IGV (18%)</option>
                                            <option value="0">SIN IGV</option>
                                        </select>
                                        @error('tipo_afectacion')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <br>
                            <div class="row">
                                <div class="col-12 col-md-9 py-1">
                                        <label for="descripcion_id" class="">Descripción</label>
                                        <textarea class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" id="editor" placeholder="Escribe una descripción" style="height: 210px">{{ $admin_producto->descripcion }}</textarea>
                                    @error('descripcion')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-9 col-md-3 py-1">
                                    <label for="" class="">Imagen Principal</label>
                                    <div class="card text-center imagecard rounded bg-light mb-0" style="height: auto">  
                                        <label for="uploadImage1" class=" my-auto text-center">
                                            <img for="uploadImage1" id="uploadPreview1" alt="" class="py-auto rounded" style="width: 100%; height: 100%;" src="
                                            @if($admin_producto->imagen == 'NULL')
                                            /images/icon.png
                                            @else
                                            /images/productos/{{ $admin_producto->imagen }}
                                            @endif
                                            ">   
                                        </label>
                                    </div>
                                    <input id="uploadImage1" class="form-control-file" type="file" name="imagen" onchange="previewImagePrincipal(1);" hidden/>
                                    @error('imagen')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <p class="text-secondary mb-2 small text-uppercase fw-bold" id="title_opcional">Datos adicionales</p>

                            <div class="row" >
                                <div class="col-12 col-md-3 col-lg-3" id="mp_tempconservacion">
                                    <div class="mb-3">
                                        <label for="tempconserv__id" class="">Temp. de conservación</label>
                                        <div class="input-group input-group-sm mb-3">
                                            <input type="text" name="temperatura_conservacion" value="{{ $admin_producto->temperatura_conservacion }}" class="form-control form-control-sm @error('temperatura_conservacion') is-invalid @enderror" id="tempconserv__id">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">°C</span>
                                        </div>
                                        @error('temperatura_conservacion')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-3 col-lg-3" id="pt_costo">
                                    <div class="mb-3">
                                        <label for="costo__id" class="">Costo</label>
                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">S/</span>
                                            <input type="text" name="costo" value="{{ $admin_producto->costo }}" class="form-control form-control-sm @error('costo') is-invalid @enderror" id="costo__id">
                                        </div>
                                        @error('costo')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-3 col-lg-3" id="pt_precio">
                                    <div class="mb-3">
                                        <label for="precio__id" class="">Precio</label>
                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">S/</span>
                                            <input type="text" name="precio" value="{{ $admin_producto->precio }}" class="form-control form-control-sm @error('precio') is-invalid @enderror" id="precio__id">
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
                                        <div class="row my-3">
                                            @foreach($admin_producto->images as $image)
                                                <div class="col-6 col-md-3 col-lg-4">
                                                    <div class="card text-center imagecard rounded bg-light mb-0" style="height: 160px">  
                                                        <label class=" my-auto text-center">
                                                            <img for="uploadImage1" id="uploadPreview1" alt="" class="py-auto rounded" style="width: 100%; height: 156px;" src="{{ $image->url }}">   
                                                        </label>
                                                        <div class="card-img-overlay">
                                                            <a href="/images/{{ $image->id }}/delete" class="btn btn-danger btn-sm float-end"><i class="bi bi-trash"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>    
                        <div class="col-12 col-md-4 col-lg-3">
                            <div class="mb-3" id="etiquetas">
                                <p class="text-secondary mb-2 small text-uppercase fw-bold">Etiquetas</p>
                                @forelse($etiquetas as $etiqueta)
                                    @php
                                        $var_etiq = DB::Table("etiqueta_producto")->where('etiqueta_id',$etiqueta->id)->where('producto_id',$admin_producto->id)->first();
                                    @endphp
                                    @if($var_etiq)
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" name="etiquetas[]" checked type="checkbox" role="switch" value="{{ $etiqueta->id }}" id="etiqueta{{ $etiqueta->id }}">
                                            <label class="form-check-label" for="etiqueta{{ $etiqueta->id }}">{{ $etiqueta->name }}</label>
                                        </div>
                                    @else
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" name="etiquetas[]" type="checkbox" role="switch" value="{{ $etiqueta->id }}" id="etiqueta{{ $etiqueta->id }}">
                                            <label class="form-check-label" for="etiqueta{{ $etiqueta->id }}">{{ $etiqueta->name }}</label>
                                        </div>
                                    @endif
                                @empty
                                    <div class="w-100 d-flex justify-content-center align-items-center" style="min-height: 180px">
                                        <p class="text-muted align-middle small mb-0">Aun no hay etiquetas. <a href="{{ url('admin-etiquetas') }}" class="link-primary">Crear nuevos</a></p>
                                    </div>
                                @endforelse
                            </div>
                            <div class="mb-3" id="proveedores">
                                <p class="text-secondary mb-2 small text-uppercase fw-bold">Proveedores</p>
                                    <div class="col-12 mb-2">
                                        <select class="js-example-basic-multiple form-select form-select-sm select2" name="proveedores[]" id="mostrar_prov" multiple="multiple" style="width:100%">
                                        </select>
                                    </div>
                            </div>
                        </div>
                    </div>                                      
                </div>
            </div>
            <div class="pt-3 pb-3 text-end" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
                <a href="{{ url('admin-mercaderia') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary px-5 my-2 my-md-0 text-white">Actualizar</button>
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
            valor_id_prod = $("#valir_prod").val();
            $('#clasificacion___id').attr("disabled","disabled");
            var clasificacion = document.getElementById("clasificacion___id").value.split('_');
            console.log(clasificacion[0],'aqui');
            $("#id_clasificacion").val(clasificacion[0]);
            var __clasificacion = $("#id_clasificacion").val();
            if (clasificacion[0] == "Compras")
            {
                $("#id_marca").show();
                $("#marcas__id").hide();
                var valor_bienes = clasificacion[0];
            }
            else
            {
                $("#id_marca").hide();
                $("#marcas__id").show();
                var valor_bienes = clasificacion[0];
            }

            
            $('#tipos__bien_id').attr("disabled","disabled");
            $("#id_tipo").val(valor_bienes);
            $.get('/busqueda_categoria_bienes', {valor_bienes: valor_bienes}, function(bienes) {
                $('#categorias__id').empty();
                $('#categorias__id').append(
                    "<option selected disabled>-- Seleccione --</option>");
                $.each(bienes, function(index, value) {
                    $('#categorias__id').append("<option value='"+index+"'>" + value[0] + "</option>");
                });
            });

            $("#id_tipo").val(valor_bienes);
            var __tipo = $("#tipos__bien_id").val();
                
                if (__tipo == 1)
                {
                    $("#title_opcional").hide();
                    $("#mp_tempconservacion").hide();
                    $("#pt_precio").show();
                    $("#pt_costo").show();
                    $("#pt_imgopcional").hide();
                    $("#proveedores").show();
                    $("#etiquetas").hide();

                    $.get('/busqueda_proved_edit', {valor_tip: 2, valor_id_prod:valor_id_prod}, function(bienes) {
                        $('#mostrar_prov').empty();
                        $('#mostrar_prov').append('<option>Seleccione una opcion</option>');
                        $.each(bienes, function(index, value) {
                            if(index != '' && value[1] == ''){
                                $('#mostrar_prov').append("<option value='"+index+"'>"+value[0]+"</option>");
                            }else{
                                $('#mostrar_prov').append("<option selected value='"+index+"'>"+value[0]+"</option>");
                            }
                            
                        });
                    });
                }
                if (__tipo == 2)
                {
                    $("#title_opcional").show();
                    $("#mp_tempconservacion").hide();
                    $("#pt_precio").show();
                    $("#pt_costo").show();
                    $("#pt_imgopcional").hide();
                    $("#proveedores").show();
                    $("#etiquetas").hide();

                    $.get('/busqueda_proved_edit', {valor_tip: 3, valor_id_prod:valor_id_prod}, function(bienes) {
                        $('#mostrar_prov').empty();
                        $('#mostrar_prov').append('<option>Seleccione una opcion</option>');
                        $.each(bienes, function(index, value) {
                            if(index != '' && value[1] == ''){
                                $('#mostrar_prov').append("<option value='"+index+"'>"+value[0]+"</option>");
                            }else{
                                $('#mostrar_prov').append("<option selected value='"+index+"'>"+value[0]+"</option>");
                            }
                            
                        });
                    });
                }

                if (__tipo == 3)
                {
                    $("#title_opcional").hide();
                    $("#mp_tempconservacion").hide();
                    $("#pt_precio").show();
                    $("#pt_costo").show();
                    $("#pt_imgopcional").show();
                    $("#show").hide();
                    $("#proveedores").hide();
                    $("#etiquetas").show();
                    $("#tipo_afectacion_show").show();

                    $.get('/busqueda_proved_edit', {valor_tip: __tipo, valor_id_prod:valor_id_prod}, function(bienes) {
                        $('#mostrar_prov').empty();
                        $('#mostrar_prov').append('<option>Seleccione una opcion</option>');
                        $.each(bienes, function(index, value) {
                            if(index != '' && value[1] == ''){
                                $('#mostrar_prov').append("<option value='"+index+"'>"+value[0]+"</option>");
                            }else{
                                $('#mostrar_prov').append("<option selected value='"+index+"'>"+value[0]+"</option>");
                            }
                            
                        });
                    });
                }
    });

    $("#title_opcional").hide();
    $("#mp_tempconservacion").hide();
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