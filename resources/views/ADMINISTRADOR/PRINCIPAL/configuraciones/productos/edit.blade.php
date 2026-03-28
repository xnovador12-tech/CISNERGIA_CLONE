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

    .imagecard {
        position: relative;
        width: 100%;
        aspect-ratio: 1 / 1;
    }

    .imagecard:hover {
        border-color: #0d6efd !important;
        background-color: #f8f9fa;
    }

    .imagecard label {
        transition: all 0.3s ease;
        width: 100%;
        height: 100%;
    }

    .imagecard:hover label i {
        color: #0d6efd !important;
    }

    #uploadPreview1 {
        object-fit: cover;
        object-position: center;
    }

    @media only screen and (min-width:320px) and (max-width:768px){
        .img_opcional{
            width: 100%;
            height: 90px;
        }
        .imagecard {
            aspect-ratio: 4 / 3;
        }
    }
</style>
@endsection

@section('content')
<!-- Encabezado -->
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="row justify-content-beetween align-items-center mb-3">
                <div class="col-4 col-md-4 col-lg-6">
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
                {{-- Cartillas de stock --}}
                <div class="col-8 col-md-8 col-lg-6 d-flex justify-content-end">
                    <div class="d-flex gap-2">

                        {{-- Stock Crítico --}}
                        <div class="card border-danger border-2 shadow-sm" style="min-width: 220px;">
                            <div class="card-body p-3 d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-danger bg-opacity-10 p-3 d-flex align-items-center justify-content-center" style="width:52px; height:52px;">
                                    <i class="bi bi-exclamation-triangle-fill text-danger fs-4"></i>
                                </div>
                                <div>
                                    <p class="mb-0 text-muted fw-semibold fw-bold" style="font-size: 0.85rem;">STOCK CRÍTICO</p>
                                    <div class="d-flex align-items-center gap-2 mt-1">
                                        <span class="text-muted">≤</span>
                                        <input type="number"
                                            id="valor_stock_critico"
                                            value="{{ $admin_producto->stock_critico ?? 10 }}"
                                            class="form-control border-danger text-danger fw-bold text-center"
                                            style="width: 65px; font-size: 1.1rem;"
                                            min="1">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Stock Seguro --}}
                        <div class="card border-success border-2 shadow-sm" style="min-width: 220px;">
                            <div class="card-body p-3 d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-success bg-opacity-10 p-3 d-flex align-items-center justify-content-center" style="width:52px; height:52px;">
                                    <i class="bi bi-shield-fill-check text-success fs-4"></i>
                                </div>
                                <div>
                                    <p class="mb-0 text-muted fw-semibold fw-bold" style="font-size: 0.85rem;">STOCK SEGURO</p>
                                    <div class="d-flex align-items-center gap-2 mt-1">
                                        <span class="text-muted">≥</span>
                                        <input type="number"
                                            id="valor_stock_seguro"
                                            value="{{ $admin_producto->stock_seguro ?? 30 }}"
                                            class="form-control border-success text-success fw-bold text-center"
                                            style="width: 65px; font-size: 1.1rem;"
                                            min="1">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
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
        <input hidden name="stock_min" id="stock_min_ids" value="{{ $admin_producto->stock_critico ?? 10 }}">
        <input hidden name="stock_max" id="stock_max_ids" value="{{ $admin_producto->stock_seguro ?? 30 }}">
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
                                <div class="col-12 col-md-2 col-lg-2 mb-3">
                                    <label for="" class="mb-2">Imagen Principal</label>
                                    <div class="card text-center imagecard rounded p-0 mb-2" style="cursor: pointer; border: 2px dashed #dee2e6; overflow: hidden;">  
                                        <label for="uploadImage1" class="d-flex flex-column justify-content-center align-items-center h-100 m-0 p-3 w-100" style="cursor: pointer;">
                                            <i id="iconPreview1" class="bi bi-image text-muted" style="font-size: 5rem;"></i>
                                            <img id="uploadPreview1" alt="" class="w-100 h-100" style="object-fit: cover; display: none;" src="
                                            @if($admin_producto->imagen == 'NULL')
                                            /images/icon.png
                                            @else
                                            /images/productos/{{ $admin_producto->imagen }}
                                            @endif
                                            ">
                                            <small id="textPreview1" class="text-muted mt-3">Click para seleccionar imagen</small>
                                        </label>
                                    </div>
                                    
                                    <input id="uploadImage1" class="form-control-file" type="file" name="imagen" accept="image/*" onchange="previewImagePrincipal(1);" hidden/>
                                    @error('imagen')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-10 col-lg-10">
                                    <div class="row">
                                        <div class="col-6 col-md-3 col-lg-2">
                                            <div class="mb-3">
                                                <label for="codigo_id">Código<span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-4 col-lg-4">
                                            <div class="mb-3">
                                                <input type="text" id="codigo_show_id" class="form-control form-control-sm bg-white" value="{{ $admin_producto->codigo }}" disabled>
                                                <input hidden name="codigo" id="codigo_id" value="{{ $admin_producto->codigo }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-4 col-lg-4">
                                            <div class="mb-3">
                                                <label for="name_id" class="">Nombre<span class="text-danger">*</span></label>
                                                <input type="text" name="name" value="{{ $admin_producto->name }}" class="form-control form-control-sm @error('name') is-invalid @enderror" required>
                                                @error('name')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-2 col-lg-2">
                                            <div class="mb-3">
                                                <label for="peso__id" class="">Peso</label>
                                                <input type="decimal" value="{{ $admin_producto->peso }}" name="peso" class="form-control form-control-sm bg-white" id="peso__id">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3 col-lg-3">
                                            <div class="mb-3">
                                                <label for="tipos__producto_id" class="">Tipo de bien<span class="text-danger">*</span></label>
                                                <select class="form-select form-select-sm select2 @error('tipo_id') is-invalid @enderror" id="tipos__producto_id" required>
                                                    <option value="{{ $admin_producto->tipo_id }}" selected="selected" hidden="hidden">{{ $admin_producto->tipo->name }}</option>
                                                    @foreach($tipos as $tipo)
                                                        <option @if($admin_producto->tipo_id == $tipo->id) selected @endif value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                                                    @endforeach
                                                </select>
                                                <input hidden type="text" class="form-control form-control-sm" name="tipo_id" id="id_tipo" required>
                                                @error('tipo_id')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3 col-lg-3">
                                            <div class="mb-3">
                                                <label for="categorias__id" class="">Categoría<span class="text-danger">*</span></label>
                                                <select class="form-select form-select-sm select2 @error('categorie_id') is-invalid @enderror"  name="categorie_id" id="categorias__id" required>
                                                    <option value="{{ $admin_producto->categorie_id }}" selected="selected" hidden="hidden">{{ $admin_producto->categorie->name }}</option>
                                                    @foreach($categorias as $categoria)
                                                        <option @if($admin_producto->categorie_id == $categoria->id) selected @endif value="{{ $categoria->id }}">{{ $categoria->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('categorie_id')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3 col-lg-3">
                                            <div class="mb-3">
                                                <label for="subcategorias__id" class="">Sub-Categoría<span class="text-danger">*</span></label>
                                                <select class="form-select form-select-sm select2 @error('subcategoria_id') is-invalid @enderror" name="subcategoria_id" id="subcategorias__id" required>
                                                    <option value="{{ old('subcategoria_id') }}" selected="selected" hidden="hidden">{{ old('subcategoria_id') }}</option>
                                                </select>
                                                @error('subcategoria_id')
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
                                                        <option @if($admin_producto->medida_id == $medida->id) selected @endif value="{{ $medida->id }}">{{ $medida->nombre }}</option>
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
                                                <select class="form-select form-select-sm select2 @error('marca') is-invalid @enderror" name="marca_id"  id="marcas__id">
                                                    <option value="{{ old('marca_id') }}" selected="selected" hidden="hidden">{{ old('marca_id') }}</option>
                                                    @foreach($marcas as $marca)
                                                        <option @if($admin_producto->marca_id == $marca->id) selected @endif value="{{ $marca->id }}">{{ $marca->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('marca_id')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
        
                                        <div class="col-12 col-md-3 col-lg-3">
                                            <div class="mb-3">
                                                <label for="modelos__id" class="">Modelo</label>
                                                <select class="form-select form-select-sm select2 @error('modelo') is-invalid @enderror" name="modelo_id"  id="modelos__id">
                                                    <option value="{{ old('modelo_id') }}" selected="selected" hidden="hidden">{{ old('modelo_id') }}</option>
                                                    @foreach($modelos as $modelo)
                                                        <option @if(old('modelo_id', $admin_producto->modelo_id) == $modelo->id) selected @endif value="{{ $modelo->id }}">{{ $modelo->nombre }}</option>
                                                    @endforeach
                                                </select>
                                                @error('modelo_id')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <p class="text-secondary mb-2 small text-uppercase fw-bold" id="title_opcional">Datos adicionales</p>
                            <div class="row" >
                                <div class="col-12 col-md-2 col-lg-2">
                                    <div class="mb-3">
                                        <label for="vidautil__id" class="">Vida útil</label>
                                        <div class="input-group input-group-sm mb-3">
                                            <input type="text" name="vida_util" value="{{ old('vida_util', $admin_producto->vida_util) }}" class="form-control form-control-sm @error('vida_util') is-invalid @enderror" id="vidautil__id">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">AÑOS</span>
                                        </div>
                                        @error('vida_util')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-2 col-lg-2">
                                    <div class="mb-3">
                                        <label for="costo__id" class="">Costo</label>
                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">S/</span>
                                            <input type="text" name="costo" value="{{ old('costo', $admin_producto->costo) }}" class="form-control form-control-sm @error('costo') is-invalid @enderror" id="costo__id">
                                        </div>
                                        @error('costo')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-3 col-lg-3">
                                    <div class="mb-3">
                                        <label for="depreciacion__id" class="">Depreciación</label>
                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">S/</span>
                                            <input type="text" name="depreciacion" value="{{ old('depreciacion', $admin_producto->depreciacion) }}" class="form-control form-control-sm @error('depreciacion') is-invalid @enderror" id="depreciacion__id">
                                        </div>
                                        @error('depreciacion')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-3 col-lg-3">
                                    <div class="mb-3">
                                        <label for="tipo_adquisicion_id" class="">Tipo de adquisición</label>
                                        <div class="input-group input-group-sm mb-3">
                                            <select class="form-select form-select-sm @error('tipo_adquisicion') is-invalid @enderror" name="tipo_adquisicion" id="tipo_adquisicion_id">
                                                <option selected='selected' hidden='hidden'>-- Seleccione --</option>
                                                <option value="Publico" {{ old('tipo_adquisicion', $admin_producto->tipo_adquisicion) == 'Publico' ? 'selected' : '' }}>Publico</option>
                                                <option value="Privado" {{ old('tipo_adquisicion', $admin_producto->tipo_adquisicion) == 'Privado' ? 'selected' : '' }}>Privado</option>
                                            </select>
                                        </div>
                                        @error('tipo_adquisicion')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-2 col-lg-2">
                                    <div class="mb-3">
                                        <label for="precio__id" class="">Precio</label>
                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">S/</span>
                                            <input type="decimal" name="precio" value="{{ old('precio', $admin_producto->precio) }}" class="form-control form-control-sm @error('precio') is-invalid @enderror" id="precio__id">
                                        </div>
                                        @error('precio')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-12 col-md-12">
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            <button class="nav-link active" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="true">Datos</button>
                                            <button class="nav-link" id="nav-garantia-tab" data-bs-toggle="tab" data-bs-target="#nav-garantia" type="button" role="tab" aria-controls="nav-garantia" aria-selected="false">Garantias</button>
                                            <button class="nav-link" id="nav-ficha-tab" data-bs-toggle="tab" data-bs-target="#nav-ficha" type="button" role="tab" aria-controls="nav-ficha" aria-selected="false">Ficha Tecnica</button>
                                            <button class="nav-link" id="nav-descripcion-producto-tab" data-bs-toggle="tab" data-bs-target="#nav-descripcion-producto" type="button" role="tab" aria-controls="nav-descripcion-producto" aria-selected="false">Descripcion del Producto</button>
                                            <button class="nav-link" id="nav-fabricante-tab" data-bs-toggle="tab" data-bs-target="#nav-fabricante" type="button" role="tab" aria-controls="nav-fabricante" aria-selected="false">Fabricante</button>
                                        </div>
                                    </nav>
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                            <div class="mb-3">
                                                <textarea class="form-control editor-tab @error('datos') is-invalid @enderror" name="datos" id="editor_datos" placeholder="Escribe una descripción" style="height: 210px">{{ old('datos', $admin_producto->datos) }}</textarea>
                                                @error('datos')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="nav-garantia" role="tabpanel" aria-labelledby="nav-garantia-tab">
                                            <div class="mb-3">
                                                <textarea class="form-control editor-tab @error('garantias') is-invalid @enderror" name="garantias" id="editor_garantias" placeholder="Escribe una descripción" style="height: 210px">{{ old('garantias', $admin_producto->garantias) }}</textarea>
                                                @error('garantias')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="nav-ficha" role="tabpanel" aria-labelledby="nav-ficha-tab">
                                            <div class="mb-3">
                                                <textarea class="form-control editor-tab @error('ficha_tecnica') is-invalid @enderror" name="ficha_tecnica" id="editor_ficha_tecnica" placeholder="Escribe una descripción" style="height: 210px">{{ old('ficha_tecnica', $admin_producto->ficha_tecnica) }}</textarea>
                                                @error('ficha_tecnica')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="nav-descripcion-producto" role="tabpanel" aria-labelledby="nav-descripcion-producto-tab">
                                            <div class="mb-3">
                                                <textarea class="form-control editor-tab @error('descripcion') is-invalid @enderror" name="descripcion" id="editor_descripcion" placeholder="Escribe una descripción" style="height: 210px">{{ old('descripcion', $admin_producto->descripcion) }}</textarea>
                                                @error('descripcion')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="nav-fabricante" role="tabpanel" aria-labelledby="nav-fabricante-tab">
                                            <div class="mb-3">
                                                <textarea class="form-control editor-tab @error('fabricante') is-invalid @enderror" name="fabricante" id="editor_fabricante" placeholder="Escribe una descripción" style="height: 210px">{{ old('fabricante', $admin_producto->fabricante) }}</textarea>
                                                @error('fabricante')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>

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
                                <select class="js-example-basic-multiple form-select form-select-sm select2" name="etiquetas[]" multiple="multiple" style="width:100%">
                                    @foreach($etiquetas as $etiqueta)
                                    <option @if($admin_producto->etiquetas->contains($etiqueta->id)) selected @endif value="{{ $etiqueta->id }}">{{ $etiqueta->name }}</option>
                                    @endforeach
                                </select>
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
                <a href="{{ url('admin-productos') }}" class="btn btn-outline-secondary">Cancelar</a>
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
    document.querySelectorAll('.editor-tab').forEach((element) => {
        ClassicEditor
            .create(element)
            .catch(error => {
                console.error(error);
            });
    });
</script>
<script>
    function previewImagePrincipal(nb) {        
        var reader = new FileReader();         
        reader.readAsDataURL(document.getElementById('uploadImage'+nb).files[0]);                
        reader.onload = function (e) {   
            // Ocultar el icono y el texto, mostrar la imagen
            document.getElementById('iconPreview'+nb).style.display = 'none';
            document.getElementById('textPreview'+nb).style.display = 'none';
            document.getElementById('uploadPreview'+nb).style.display = 'block';
            document.getElementById('uploadPreview'+nb).src = e.target.result;                  
        };     
    }
</script>
<script>
    $(document).ready(function() {
        // Inicializar Select2
        $('.select2').select2();

        // Esperar a que Select2 esté completamente inicializado antes de disparar eventos
        setTimeout(function() {
            // Establecer los valores en los campos ocultos
            var tipo_id = $('#tipos__producto_id').val();
            if (tipo_id) {
                $("#id_tipo").val(tipo_id);
                $('#tipos__producto_id').trigger('change');
            }
        }, 300);

        // Establecer los valores en los campos ocultos de stock
        $('#valor_stock_critico').on('keyup', function() {
            $('#stock_min_ids').val($(this).val());
        });

        $('#valor_stock_seguro').on('keyup', function() {
            $('#stock_max_ids').val($(this).val());
        });
        
        // Evento cuando cambia el tipo de producto
        $('#tipos__producto_id').on('change', function() {
            var valor_bienes = $(this).val();
            $("#id_tipo").val(valor_bienes);
            var categoria_actual = "{{ $admin_producto->categorie_id }}";
            
            // Cargar categorías según tipo
            $.get('/busqueda_categoria_productos', {valor_bienes: valor_bienes}, function(bienes) {
                // Destruir Select2 para poder modificar las opciones
                $('#categorias__id').select2('destroy');
                $('#categorias__id').empty();
                
                // Agregar la opción por defecto
                $('#categorias__id').append("<option value=''>-- Seleccione --</option>");
                
                // Agregar todas las categorías
                $.each(bienes, function(index, value) {
                    $('#categorias__id').append("<option value='"+index+"'>" + value[0] + "</option>");
                });
                
                // Reinicializar Select2
                $('#categorias__id').select2();
                
                // Establecer el valor de la categoría actual
                if (categoria_actual && categoria_actual !== '') {
                    $('#categorias__id').trigger('change');
                    $('#categorias__id').val(categoria_actual).trigger('change');
                }
            });

            // Cargar proveedores según tipo
            $.get('/busqueda_proved', {valor_tip: valor_bienes}, function(bienes) {
                $('#mostrar_prov').empty();
                $('#mostrar_prov').append('<option>Seleccione una opcion</option>');
                $.each(bienes, function(index, value) {
                    $('#mostrar_prov').append("<option value='"+index+"'>"+value[0]+"</option>");
                });
            });

            // Cargar código de producto
            setTimeout(function() {
                var __cate_val = $("#categorias__id").val();
                if (__cate_val) {
                    $.get('/busqueda_codigo_producto', {tipo_val: valor_bienes, cate_val: __cate_val}, function(codigo_val) {
                        $('#codigo_show_id').val("");
                        $('#codigo_id').val("");
                        $.each(codigo_val, function(index, value) {
                            $('#codigo_show_id').val(value[0]);
                            $('#codigo_id').val(value[0]);
                        });
                    });
                }
            }, 100);
        });

        // Evento cuando cambia la categoría
        $('#categorias__id').on('change', function() {
            var __tipo_val = $("#id_tipo").val();
            var __cate_val = $(this).val();
            if(__tipo_val && __cate_val){
                $.get('/busqueda_codigo_producto', {tipo_val: __tipo_val, cate_val: __cate_val}, function(codigo_val) {
                    $('#codigo_show_id').val("");
                    $('#codigo_id').val("");
                    $.each(codigo_val, function(index, value) {
                        $('#codigo_show_id').val(value[0]);
                        $('#codigo_id').val(value[0]);
                    });
                });

                $.get('/busqueda_subcategoria_productos', {valor_categorias: __cate_val}, function(subcategorias) {
                    $('#subcategorias__id').empty();
                    $('#subcategorias__id').append(
                        "<option selected='selected' hidden='hidden'>-- Seleccione --</option>");
                    $.each(subcategorias, function(index, value) {
                        if(value[0] === 'No hay subcategorías disponibles'){
                            $('#subcategorias__id').empty();
                            $('#subcategorias__id').append(
                        "<option selected='selected' disabled>-- No aplicable --</option>");
                        }else{
                            $('#subcategorias__id').append("<option value='"+index+"'>" + value[0] + "</option>");
                        }
                    });
                });
            }
        });

        // Cargar proveedores de edición
        var valor_id_prod = $("#valir_prod").val();
        var tipo_val = $("#id_tipo").val();
        if (valor_id_prod && tipo_val) {
            $.get('/busqueda_proved_edit', {valor_tip: tipo_val, valor_id_prod: valor_id_prod}, function(bienes) {
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

    // Inicializar imagen principal si existe
    document.addEventListener('DOMContentLoaded', function() {
        const uploadPreview = document.getElementById('uploadPreview1');
        const iconPreview = document.getElementById('iconPreview1');
        const textPreview = document.getElementById('textPreview1');
        
        if (uploadPreview && uploadPreview.src) {
            const img = new Image();
            img.onload = function() {
                // La imagen existe y se cargó correctamente
                uploadPreview.style.display = 'block';
                if (iconPreview) iconPreview.style.display = 'none';
                if (textPreview) textPreview.style.display = 'none';
            };
            img.onerror = function() {
                // Si la imagen no existe, mostrar el icono
                uploadPreview.style.display = 'none';
                if (iconPreview) iconPreview.style.display = 'block';
                if (textPreview) textPreview.style.display = 'block';
            };
            img.src = uploadPreview.src;
        }
    });

</script>

@endsection