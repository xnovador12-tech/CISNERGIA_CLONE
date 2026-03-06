@extends('TEMPLATES.administrador')

@section('title', 'EDITAR CAMPANA')

@push('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('css')
    <style>
        /* =============================================
           FORM SECTIONS
           ============================================= */

        .form-section-title {
            font-weight: 700;
            font-size: 0.9rem;
            color: #212529;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e9ecef;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-card .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #495057;
        }

        .form-card .form-control,
        .form-card .form-select {
            font-size: 0.85rem;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }

        .form-card .form-control:focus,
        .form-card .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15);
        }

        /* =============================================
           PRODUCT TABLE
           ============================================= */

        .product-search-wrapper {
            position: relative;
        }

        .product-search-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #dee2e6;
            border-top: none;
            border-radius: 0 0 8px 8px;
            max-height: 250px;
            overflow-y: auto;
            z-index: 1050;
            display: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .product-search-results .search-item {
            padding: 0.6rem 1rem;
            cursor: pointer;
            font-size: 0.85rem;
            border-bottom: 1px solid #f0f0f0;
            transition: background 0.15s ease;
        }

        .product-search-results .search-item:hover {
            background: #f0f7ff;
        }

        .product-search-results .search-item:last-child {
            border-bottom: none;
        }

        .product-search-results .search-item .product-code {
            font-size: 0.75rem;
            color: #6c757d;
            font-weight: 600;
        }

        .product-search-results .search-item .product-name {
            font-weight: 500;
            color: #212529;
        }

        .product-search-results .search-item .product-price {
            font-size: 0.8rem;
            color: #198754;
            font-weight: 600;
        }

        .product-search-results .search-no-results {
            padding: 1rem;
            text-align: center;
            font-size: 0.85rem;
            color: #6c757d;
        }

        .selected-products-table {
            font-size: 0.85rem;
        }

        .selected-products-table thead th {
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6c757d;
            font-weight: 700;
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }

        .selected-products-table tbody tr {
            transition: background 0.15s ease;
        }

        .selected-products-table tbody tr:hover {
            background: #f8f9fa;
        }

        .selected-products-table .btn-remove {
            color: #dc3545;
            border: none;
            background: none;
            font-size: 1.1rem;
            cursor: pointer;
            padding: 0.2rem 0.5rem;
            border-radius: 6px;
            transition: background 0.15s ease;
        }

        .selected-products-table .btn-remove:hover {
            background: #dc354515;
        }

        .selected-products-table .discount-input {
            width: 90px;
            font-size: 0.85rem;
            text-align: center;
        }

        .empty-products-message {
            text-align: center;
            padding: 2rem;
            color: #6c757d;
        }

        .empty-products-message i {
            font-size: 2rem;
            display: block;
            margin-bottom: 0.5rem;
        }

        /* =============================================
           IMAGE PREVIEW
           ============================================= */

        .banner-preview-container {
            width: 100%;
            max-height: 200px;
            border-radius: 8px;
            overflow: hidden;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.75rem;
        }

        .banner-preview-container img {
            width: 100%;
            max-height: 200px;
            object-fit: cover;
        }

        .banner-preview-container .placeholder-icon {
            color: #adb5bd;
            font-size: 3rem;
        }

        /* =============================================
           RESPONSIVE
           ============================================= */

        @media (max-width: 768px) {
            .form-card {
                padding: 1rem;
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
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">
                    <i class="bi bi-megaphone me-2"></i>Editar Campana
                </h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">Operaciones</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-operaciones-campanias.index') }}">Campanas</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Editar: {{ $campania->nombre }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin encabezado -->

    {{-- Contenido --}}
    <div class="container-fluid">

        {{-- Alerta si la campana esta activa --}}
        @if($campania->estado === 'activa')
            <div class="alert alert-warning d-flex align-items-center mb-3" role="alert" data-aos="fade-up">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <div>
                    <strong>Atencion:</strong> Esta campana esta activa. Los cambios se aplicaran inmediatamente.
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('admin-operaciones-campanias.update', $campania->id) }}" enctype="multipart/form-data" autocomplete="off" id="formEditCampania">
            @csrf
            @method('PUT')

            {{-- ============================================= --}}
            {{-- SECCION: Informacion General --}}
            {{-- ============================================= --}}
            <div class="form-card" data-aos="fade-up">
                <div class="form-section-title">
                    <i class="bi bi-info-circle text-primary"></i> Informacion General
                </div>
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label">Nombre de la Campana <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $campania->nombre) }}" placeholder="Ej: Verano Solar 2025" required>
                        @error('nombre')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tipo <span class="text-danger">*</span></label>
                        <select name="tipo" class="form-select @error('tipo') is-invalid @enderror" required>
                            <option value="">Seleccionar...</option>
                            <option value="descuento" {{ old('tipo', $campania->tipo) == 'descuento' ? 'selected' : '' }}>Descuento</option>
                            <option value="envio-gratis" {{ old('tipo', $campania->tipo) == 'envio-gratis' ? 'selected' : '' }}>Envio Gratis</option>
                            <option value="combo" {{ old('tipo', $campania->tipo) == 'combo' ? 'selected' : '' }}>Combo/Kit</option>
                            <option value="temporada" {{ old('tipo', $campania->tipo) == 'temporada' ? 'selected' : '' }}>Temporada</option>
                            <option value="flash-sale" {{ old('tipo', $campania->tipo) == 'flash-sale' ? 'selected' : '' }}>Flash Sale</option>
                        </select>
                        @error('tipo')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Descripcion</label>
                        <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" rows="3" placeholder="Describe el objetivo y detalles de la campana...">{{ old('descripcion', $campania->descripcion) }}</textarea>
                        @error('descripcion')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- ============================================= --}}
            {{-- SECCION: Vigencia y Promocion --}}
            {{-- ============================================= --}}
            <div class="form-card" data-aos="fade-up" data-aos-delay="100">
                <div class="form-section-title">
                    <i class="bi bi-calendar-event text-primary"></i> Vigencia y Promocion
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Fecha de Inicio <span class="text-danger">*</span></label>
                        <input type="date" name="fecha_inicio" class="form-control @error('fecha_inicio') is-invalid @enderror" value="{{ old('fecha_inicio', $campania->fecha_inicio->format('Y-m-d')) }}" required>
                        @error('fecha_inicio')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Fecha de Fin <span class="text-danger">*</span></label>
                        <input type="date" name="fecha_fin" class="form-control @error('fecha_fin') is-invalid @enderror" value="{{ old('fecha_fin', $campania->fecha_fin->format('Y-m-d')) }}" required>
                        @error('fecha_fin')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Descuento (%)</label>
                        <div class="input-group">
                            <input type="number" name="descuento_porcentaje" class="form-control @error('descuento_porcentaje') is-invalid @enderror" min="0" max="100" step="0.01" value="{{ old('descuento_porcentaje', $campania->descuento_porcentaje) }}" placeholder="0">
                            <span class="input-group-text">%</span>
                        </div>
                        @error('descuento_porcentaje')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Descuento Monto Fijo</label>
                        <div class="input-group">
                            <span class="input-group-text">S/</span>
                            <input type="number" name="descuento_monto" class="form-control @error('descuento_monto') is-invalid @enderror" min="0" step="0.01" value="{{ old('descuento_monto', $campania->descuento_monto) }}" placeholder="0.00">
                        </div>
                        @error('descuento_monto')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Condicion Minima (Monto)</label>
                        <div class="input-group">
                            <span class="input-group-text">S/</span>
                            <input type="number" name="condicion_minimo" class="form-control @error('condicion_minimo') is-invalid @enderror" min="0" step="0.01" value="{{ old('condicion_minimo', $campania->condicion_minimo) }}" placeholder="0.00">
                        </div>
                        @error('condicion_minimo')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- ============================================= --}}
            {{-- SECCION: Productos Asociados --}}
            {{-- ============================================= --}}
            <div class="form-card" data-aos="fade-up" data-aos-delay="200">
                <div class="form-section-title">
                    <i class="bi bi-box text-primary"></i> Productos Asociados
                </div>

                {{-- Checkbox aplica a todos --}}
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="aplica_todos_productos" value="1" id="aplicaTodosProductos" {{ old('aplica_todos_productos', $campania->aplica_todos_productos) ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold" for="aplicaTodosProductos">
                        Aplicar a todos los productos del catalogo
                    </label>
                </div>

                {{-- Selector de productos --}}
                <div id="productSelectorContainer" style="{{ old('aplica_todos_productos', $campania->aplica_todos_productos) ? 'display:none;' : '' }}">
                    {{-- Buscador --}}
                    <div class="mb-3">
                        <label class="form-label">Buscar y agregar productos</label>
                        <div class="product-search-wrapper">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input type="text" class="form-control" id="productSearchInput" placeholder="Buscar por nombre o codigo...">
                            </div>
                            <div class="product-search-results" id="productSearchResults"></div>
                        </div>
                    </div>

                    {{-- Tabla de productos seleccionados --}}
                    <div class="table-responsive">
                        <table class="table selected-products-table" id="selectedProductsTable">
                            <thead>
                                <tr>
                                    <th>Codigo</th>
                                    <th>Producto</th>
                                    <th class="text-end">Precio</th>
                                    <th class="text-center">Dto. Especifico (%)</th>
                                    <th class="text-center" style="width: 60px;">Accion</th>
                                </tr>
                            </thead>
                            <tbody id="selectedProductsBody">
                                {{-- Se llena via JS --}}
                            </tbody>
                        </table>
                    </div>

                    {{-- Mensaje cuando no hay productos --}}
                    <div class="empty-products-message" id="emptyProductsMsg" style="display:none;">
                        <i class="bi bi-inbox"></i>
                        <p class="mb-0">No hay productos asociados. Usa el buscador para agregar productos.</p>
                    </div>
                </div>
            </div>

            {{-- ============================================= --}}
            {{-- SECCION: Imagen Banner --}}
            {{-- ============================================= --}}
            <div class="form-card" data-aos="fade-up" data-aos-delay="300">
                <div class="form-section-title">
                    <i class="bi bi-image text-primary"></i> Imagen Banner
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Imagen Actual</label>
                        <div class="banner-preview-container" id="currentBannerPreview">
                            @if($campania->imagen_banner)
                                <img src="{{ asset('images/campanias/' . $campania->imagen_banner) }}" alt="Banner actual">
                            @else
                                <i class="bi bi-image placeholder-icon"></i>
                            @endif
                        </div>
                        <small class="text-muted">
                            @if($campania->imagen_banner)
                                Archivo actual: {{ $campania->imagen_banner }}
                            @else
                                No hay imagen de banner cargada.
                            @endif
                        </small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Subir Nueva Imagen</label>
                        <input type="file" name="imagen_banner" class="form-control @error('imagen_banner') is-invalid @enderror" id="imagenBannerInput" accept="image/*">
                        @error('imagen_banner')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <small class="text-muted d-block mt-1">Formatos: JPG, PNG, WEBP. Peso maximo: 2 MB.</small>

                        {{-- Preview de nueva imagen --}}
                        <div class="banner-preview-container mt-2" id="newBannerPreview" style="display:none;">
                            <img src="" alt="Nueva imagen" id="newBannerImage">
                        </div>
                    </div>
                </div>
            </div>

            {{-- ============================================= --}}
            {{-- BOTONES DE ACCION --}}
            {{-- ============================================= --}}
            <div class="d-flex justify-content-end gap-2 mb-4" data-aos="fade-up" data-aos-delay="400">
                <a href="{{ route('admin-operaciones-campanias.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle me-1"></i>Cancelar
                </a>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-save me-1"></i>Guardar Cambios
                </button>
            </div>

        </form>

    </div>
    {{-- Fin contenido --}}
@endsection

@section('js')
    <script>
        $(document).ready(function () {

            // =============================================
            // DATA: Productos previamente seleccionados
            // =============================================
            var selectedProducts = {};

            @foreach($campania->productos as $prod)
                selectedProducts[{{ $prod->id }}] = {
                    id: {{ $prod->id }},
                    codigo: "{{ $prod->codigo }}",
                    name: "{{ addslashes($prod->name) }}",
                    precio: "{{ $prod->precio }}",
                    descuento_especifico: "{{ $prod->pivot->descuento_especifico ?? '' }}"
                };
            @endforeach

            // =============================================
            // RENDER: Tabla de productos seleccionados
            // =============================================
            function renderSelectedProducts() {
                var $tbody = $('#selectedProductsBody');
                $tbody.empty();

                var keys = Object.keys(selectedProducts);

                if (keys.length === 0) {
                    $('#emptyProductsMsg').show();
                    $('#selectedProductsTable').hide();
                    return;
                }

                $('#emptyProductsMsg').hide();
                $('#selectedProductsTable').show();

                keys.forEach(function (id) {
                    var prod = selectedProducts[id];
                    var row = '<tr data-product-id="' + prod.id + '">' +
                        '<td>' + prod.codigo + '</td>' +
                        '<td>' + prod.name + '</td>' +
                        '<td class="text-end">S/ ' + parseFloat(prod.precio).toFixed(2) + '</td>' +
                        '<td class="text-center">' +
                            '<div class="input-group input-group-sm justify-content-center">' +
                                '<input type="number" class="form-control discount-input" name="descuentos_especificos[' + prod.id + ']" ' +
                                    'value="' + (prod.descuento_especifico || '') + '" min="0" max="100" step="0.01" placeholder="0">' +
                                '<span class="input-group-text">%</span>' +
                            '</div>' +
                        '</td>' +
                        '<td class="text-center">' +
                            '<button type="button" class="btn-remove" data-id="' + prod.id + '" title="Quitar producto">' +
                                '<i class="bi bi-x-circle-fill"></i>' +
                            '</button>' +
                        '</td>' +
                        '<input type="hidden" name="productos[]" value="' + prod.id + '">' +
                    '</tr>';
                    $tbody.append(row);
                });
            }

            // Render inicial
            renderSelectedProducts();

            // =============================================
            // TOGGLE: Aplica a todos los productos
            // =============================================
            $('#aplicaTodosProductos').on('change', function () {
                if ($(this).is(':checked')) {
                    $('#productSelectorContainer').slideUp(200);
                } else {
                    $('#productSelectorContainer').slideDown(200);
                }
            });

            // =============================================
            // AJAX: Busqueda de productos con debounce
            // =============================================
            var searchTimer = null;

            $('#productSearchInput').on('keyup', function () {
                var query = $(this).val().trim();

                if (searchTimer) {
                    clearTimeout(searchTimer);
                }

                if (query.length < 2) {
                    $('#productSearchResults').hide().empty();
                    return;
                }

                searchTimer = setTimeout(function () {
                    $.ajax({
                        url: "{{ route('admin-operaciones-campanias.ajax.productos') }}",
                        method: 'GET',
                        data: { q: query },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            var $results = $('#productSearchResults');
                            $results.empty();

                            if (data.length === 0) {
                                $results.append('<div class="search-no-results">No se encontraron productos.</div>');
                                $results.show();
                                return;
                            }

                            data.forEach(function (prod) {
                                // No mostrar si ya esta seleccionado
                                if (selectedProducts[prod.id]) {
                                    return;
                                }

                                var item = '<div class="search-item" ' +
                                    'data-id="' + prod.id + '" ' +
                                    'data-codigo="' + prod.codigo + '" ' +
                                    'data-name="' + prod.name + '" ' +
                                    'data-precio="' + prod.precio + '">' +
                                    '<div class="d-flex justify-content-between align-items-center">' +
                                        '<div>' +
                                            '<span class="product-code">' + prod.codigo + '</span> — ' +
                                            '<span class="product-name">' + prod.name + '</span>' +
                                        '</div>' +
                                        '<span class="product-price">S/ ' + parseFloat(prod.precio).toFixed(2) + '</span>' +
                                    '</div>' +
                                '</div>';
                                $results.append(item);
                            });

                            // Si todos ya estan seleccionados
                            if ($results.children().length === 0) {
                                $results.append('<div class="search-no-results">Todos los resultados ya estan seleccionados.</div>');
                            }

                            $results.show();
                        },
                        error: function () {
                            $('#productSearchResults').empty()
                                .append('<div class="search-no-results">Error al buscar productos.</div>')
                                .show();
                        }
                    });
                }, 350);
            });

            // =============================================
            // Agregar producto desde resultados de busqueda
            // =============================================
            $(document).on('click', '.search-item', function () {
                var id = $(this).data('id');
                var codigo = $(this).data('codigo');
                var name = $(this).data('name');
                var precio = $(this).data('precio');

                if (!selectedProducts[id]) {
                    selectedProducts[id] = {
                        id: id,
                        codigo: codigo,
                        name: name,
                        precio: precio,
                        descuento_especifico: ''
                    };
                    renderSelectedProducts();
                }

                $('#productSearchInput').val('');
                $('#productSearchResults').hide().empty();
            });

            // =============================================
            // Quitar producto de la tabla
            // =============================================
            $(document).on('click', '.btn-remove', function () {
                var id = $(this).data('id');
                delete selectedProducts[id];
                renderSelectedProducts();
            });

            // =============================================
            // Cerrar resultados de busqueda al hacer clic fuera
            // =============================================
            $(document).on('click', function (e) {
                if (!$(e.target).closest('.product-search-wrapper').length) {
                    $('#productSearchResults').hide();
                }
            });

            // =============================================
            // IMAGE PREVIEW: Nueva imagen de banner
            // =============================================
            $('#imagenBannerInput').on('change', function () {
                var file = this.files[0];

                if (file) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#newBannerImage').attr('src', e.target.result);
                        $('#newBannerPreview').show();
                    };
                    reader.readAsDataURL(file);
                } else {
                    $('#newBannerPreview').hide();
                    $('#newBannerImage').attr('src', '');
                }
            });

            console.log('Modulo Editar Campana cargado correctamente.');
        });
    </script>
@endsection
