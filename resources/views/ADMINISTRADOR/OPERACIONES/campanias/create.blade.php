@extends('TEMPLATES.administrador')

@section('title', 'NUEVA CAMPANA')

@push('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('css')
    <style>
        /* =============================================
           FORM SECTION TITLES
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

        .form-section-title i {
            font-size: 1rem;
        }

        /* =============================================
           CARD STYLING
           ============================================= */
        .card-form {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .card-form .card-body {
            padding: 1.75rem;
        }

        /* =============================================
           PRODUCT SEARCH & TABLE
           ============================================= */
        .product-search-wrapper {
            position: relative;
        }

        .product-search-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            z-index: 1050;
            background: #fff;
            border: 1px solid #dee2e6;
            border-top: none;
            border-radius: 0 0 8px 8px;
            max-height: 220px;
            overflow-y: auto;
            display: none;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
        }

        .product-search-results .search-result-item {
            padding: 0.6rem 0.85rem;
            cursor: pointer;
            font-size: 0.85rem;
            border-bottom: 1px solid #f1f3f5;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background 0.15s ease;
        }

        .product-search-results .search-result-item:last-child {
            border-bottom: none;
        }

        .product-search-results .search-result-item:hover {
            background: #e9ecef;
        }

        .product-search-results .search-result-item .product-name {
            font-weight: 500;
            color: #212529;
        }

        .product-search-results .search-result-item .product-code {
            font-size: 0.75rem;
            color: #6c757d;
            margin-left: 0.5rem;
        }

        .product-search-results .search-result-item .product-price {
            font-weight: 600;
            color: #198754;
            white-space: nowrap;
        }

        .product-search-results .no-results {
            padding: 0.75rem;
            text-align: center;
            color: #6c757d;
            font-size: 0.85rem;
        }

        /* Selected Products Table */
        .table-productos-selected {
            font-size: 0.85rem;
        }

        .table-productos-selected thead th {
            background: #f8f9fa;
            font-weight: 600;
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            color: #495057;
            border-bottom: 2px solid #dee2e6;
        }

        .table-productos-selected tbody tr {
            transition: background 0.15s ease;
        }

        .table-productos-selected tbody tr:hover {
            background: #f8f9fa;
        }

        .table-productos-selected .btn-remove {
            color: #dc3545;
            border: none;
            background: none;
            cursor: pointer;
            font-size: 1rem;
            padding: 0.15rem 0.4rem;
            border-radius: 4px;
            transition: background 0.15s ease;
        }

        .table-productos-selected .btn-remove:hover {
            background: #dc354515;
        }

        .table-productos-selected .input-descuento {
            width: 80px;
            font-size: 0.82rem;
            text-align: center;
        }

        .empty-products-msg {
            text-align: center;
            padding: 2rem 1rem;
            color: #6c757d;
        }

        .empty-products-msg i {
            font-size: 2rem;
            display: block;
            margin-bottom: 0.5rem;
            opacity: 0.4;
        }

        /* =============================================
           IMAGE PREVIEW
           ============================================= */
        .image-preview-container {
            width: 100%;
            max-width: 280px;
            height: 140px;
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin-top: 0.5rem;
            background: #f8f9fa;
            transition: border-color 0.2s ease;
        }

        .image-preview-container:hover {
            border-color: #adb5bd;
        }

        .image-preview-container img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .image-preview-container .placeholder-text {
            font-size: 0.8rem;
            color: #adb5bd;
        }

        /* =============================================
           RESPONSIVE
           ============================================= */
        @media (max-width: 768px) {
            .card-form .card-body {
                padding: 1.25rem;
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
                    <i class="bi bi-megaphone me-2"></i>Nueva Campana
                </h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">Operaciones</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-operaciones-campanias.index') }}">Campanas</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Nueva Campana</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin encabezado -->

    {{-- Contenido --}}
    <form method="POST" action="{{ route('admin-operaciones-campanias.store') }}" enctype="multipart/form-data" autocomplete="off" id="formCampania" class="needs-validation" novalidate>
        @csrf
        <div class="container-fluid">
            <div class="card card-form" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
                <div class="card-body">

                    {{-- ================================================
                        SECCION A: Informacion General
                    ================================================= --}}
                    <div class="form-section-title">
                        <i class="bi bi-info-circle text-primary"></i> Informacion General
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-8">
                            <label for="nombre" class="form-label small fw-bold">Nombre de la Campana <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" id="nombre" value="{{ old('nombre') }}" placeholder="Ej: Verano Solar 2025" required>
                            @error('nombre')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="tipo" class="form-label small fw-bold">Tipo <span class="text-danger">*</span></label>
                            <select class="form-select @error('tipo') is-invalid @enderror" name="tipo" id="tipo" required>
                                <option value="" selected hidden>Seleccionar...</option>
                                <option value="descuento" {{ old('tipo') == 'descuento' ? 'selected' : '' }}>Descuento</option>
                                <option value="envio_gratis" {{ old('tipo') == 'envio_gratis' ? 'selected' : '' }}>Envio Gratis</option>
                                <option value="combo" {{ old('tipo') == 'combo' ? 'selected' : '' }}>Combo/Kit</option>
                                <option value="temporada" {{ old('tipo') == 'temporada' ? 'selected' : '' }}>Temporada</option>
                                <option value="flash_sale" {{ old('tipo') == 'flash_sale' ? 'selected' : '' }}>Flash Sale</option>
                            </select>
                            @error('tipo')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="descripcion" class="form-label small fw-bold">Descripcion</label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" id="descripcion" rows="3" placeholder="Describe el objetivo y detalles de la campana...">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- ================================================
                        SECCION B: Vigencia y Promocion
                    ================================================= --}}
                    <div class="form-section-title">
                        <i class="bi bi-calendar-event text-primary"></i> Vigencia y Promocion
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4 col-lg-3">
                            <label for="fecha_inicio" class="form-label small fw-bold">Fecha de Inicio <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('fecha_inicio') is-invalid @enderror" name="fecha_inicio" id="fecha_inicio" value="{{ old('fecha_inicio') }}" required>
                            @error('fecha_inicio')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-4 col-lg-3">
                            <label for="fecha_fin" class="form-label small fw-bold">Fecha de Fin <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('fecha_fin') is-invalid @enderror" name="fecha_fin" id="fecha_fin" value="{{ old('fecha_fin') }}" required>
                            @error('fecha_fin')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-4 col-lg-2">
                            <label for="descuento_porcentaje" class="form-label small fw-bold">Descuento (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control @error('descuento_porcentaje') is-invalid @enderror" name="descuento_porcentaje" id="descuento_porcentaje" value="{{ old('descuento_porcentaje') }}" min="0" max="100" step="0.01" placeholder="0">
                                <span class="input-group-text">%</span>
                            </div>
                            @error('descuento_porcentaje')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-4 col-lg-2">
                            <label for="descuento_monto" class="form-label small fw-bold">Descuento (Monto)</label>
                            <div class="input-group">
                                <span class="input-group-text">S/</span>
                                <input type="number" class="form-control @error('descuento_monto') is-invalid @enderror" name="descuento_monto" id="descuento_monto" value="{{ old('descuento_monto') }}" min="0" step="0.01" placeholder="0.00">
                            </div>
                            @error('descuento_monto')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-4 col-lg-2">
                            <label for="condicion_minimo" class="form-label small fw-bold">Compra Minima</label>
                            <div class="input-group">
                                <span class="input-group-text">S/</span>
                                <input type="number" class="form-control @error('condicion_minimo') is-invalid @enderror" name="condicion_minimo" id="condicion_minimo" value="{{ old('condicion_minimo') }}" min="0" step="0.01" placeholder="0.00">
                            </div>
                            @error('condicion_minimo')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- ================================================
                        SECCION C: Productos Asociados
                    ================================================= --}}
                    <div class="form-section-title">
                        <i class="bi bi-box text-primary"></i> Productos Asociados
                    </div>
                    <div class="row g-3 mb-4">
                        {{-- Checkbox aplica todos --}}
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="aplica_todos_productos" id="aplica_todos_productos" value="1" {{ old('aplica_todos_productos') ? 'checked' : '' }}>
                                <label class="form-check-label small fw-bold" for="aplica_todos_productos">
                                    Aplicar a todos los productos del catalogo
                                </label>
                            </div>
                        </div>

                        {{-- Product selector area --}}
                        <div class="col-12" id="productSelectorArea">
                            {{-- Search input --}}
                            <label class="form-label small fw-bold">Buscar y agregar productos</label>
                            <div class="product-search-wrapper">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                                    <input type="text" class="form-control" id="productSearch" placeholder="Buscar por nombre o codigo de producto..." autocomplete="off">
                                </div>
                                <div class="product-search-results" id="searchResults"></div>
                            </div>

                            {{-- Selected products table --}}
                            <div class="table-responsive mt-3">
                                <table class="table table-bordered table-productos-selected mb-0" id="selectedProductsTable">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th class="text-end" style="width: 120px;">Precio</th>
                                            <th class="text-center" style="width: 130px;">Dto. Especifico (%)</th>
                                            <th class="text-center" style="width: 80px;">Quitar</th>
                                        </tr>
                                    </thead>
                                    <tbody id="selectedProductsBody">
                                        {{-- Rows inserted dynamically --}}
                                    </tbody>
                                </table>
                                <div class="empty-products-msg" id="emptyProductsMsg">
                                    <i class="bi bi-inbox"></i>
                                    <span class="small">No hay productos seleccionados. Usa el buscador para agregar productos.</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ================================================
                        SECCION D: Configuracion
                    ================================================= --}}
                    <div class="form-section-title">
                        <i class="bi bi-gear text-primary"></i> Configuracion
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="estado" class="form-label small fw-bold">Estado Inicial</label>
                            <select class="form-select @error('estado') is-invalid @enderror" name="estado" id="estado">
                                <option value="borrador" {{ old('estado', 'borrador') == 'borrador' ? 'selected' : '' }}>Borrador (publicar despues)</option>
                                <option value="activa" {{ old('estado') == 'activa' ? 'selected' : '' }}>Activa (publicar inmediatamente)</option>
                            </select>
                            @error('estado')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="imagen_banner" class="form-label small fw-bold">Imagen de Banner</label>
                            <input type="file" class="form-control @error('imagen_banner') is-invalid @enderror" name="imagen_banner" id="imagen_banner" accept="image/*">
                            @error('imagen_banner')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <div class="image-preview-container mt-2" id="imagePreviewContainer">
                                <span class="placeholder-text" id="imagePreviewPlaceholder"><i class="bi bi-image me-1"></i>Vista previa</span>
                                <img src="" alt="Vista previa" id="imagePreview" style="display: none;">
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Botones de accion --}}
            <div class="pt-3 pb-3 text-end" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
                <a href="{{ route('admin-operaciones-campanias.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle me-1"></i>Cancelar
                </a>
                <button type="submit" class="btn btn-primary px-5 my-2 my-md-0 text-white">
                    <i class="bi bi-save me-1"></i>Guardar Campaña
                </button>
            </div>
        </div>
    </form>
    {{-- Fin contenido --}}
@endsection

@section('js')
    <script>
        $(document).ready(function () {

            // =============================================
            // DATA: Selected products store
            // =============================================
            var selectedProducts = {};
            var searchTimer = null;

            // =============================================
            // Toggle product selector based on checkbox
            // =============================================
            function toggleProductSelector() {
                if ($('#aplica_todos_productos').is(':checked')) {
                    $('#productSelectorArea').slideUp(250);
                } else {
                    $('#productSelectorArea').slideDown(250);
                }
            }

            // Initialize on page load
            toggleProductSelector();

            $('#aplica_todos_productos').on('change', function () {
                toggleProductSelector();
            });

            // =============================================
            // AJAX Product Search with Debounce (300ms)
            // =============================================
            $('#productSearch').on('keyup', function () {
                var query = $(this).val().trim();

                clearTimeout(searchTimer);

                if (query.length < 2) {
                    $('#searchResults').hide().empty();
                    return;
                }

                searchTimer = setTimeout(function () {
                    $.ajax({
                        url: "{{ route('admin-operaciones-campanias.ajax.productos') }}",
                        type: 'GET',
                        data: { q: query },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            var $results = $('#searchResults');
                            $results.empty();

                            if (data.length === 0) {
                                $results.append('<div class="no-results">No se encontraron productos</div>');
                            } else {
                                $.each(data, function (index, product) {
                                    // Skip already selected products
                                    if (selectedProducts[product.id]) return;

                                    var precio = parseFloat(product.precio).toFixed(2);
                                    var item = $(
                                        '<div class="search-result-item" data-id="' + product.id + '" data-name="' + $('<span>').text(product.name).html() + '" data-codigo="' + $('<span>').text(product.codigo).html() + '" data-precio="' + product.precio + '">' +
                                            '<div>' +
                                                '<span class="product-name">' + $('<span>').text(product.name).html() + '</span>' +
                                                '<span class="product-code">(' + $('<span>').text(product.codigo).html() + ')</span>' +
                                            '</div>' +
                                            '<span class="product-price">S/ ' + precio + '</span>' +
                                        '</div>'
                                    );
                                    $results.append(item);
                                });

                                // If all results are already selected
                                if ($results.children('.search-result-item').length === 0 && data.length > 0) {
                                    $results.append('<div class="no-results">Todos los resultados ya fueron agregados</div>');
                                }
                            }

                            $results.show();
                        },
                        error: function () {
                            var $results = $('#searchResults');
                            $results.empty().append('<div class="no-results">Error al buscar productos</div>').show();
                        }
                    });
                }, 300);
            });

            // Hide results when clicking outside
            $(document).on('click', function (e) {
                if (!$(e.target).closest('.product-search-wrapper').length) {
                    $('#searchResults').hide();
                }
            });

            // Focus back on search shows results if present
            $('#productSearch').on('focus', function () {
                if ($('#searchResults').children().length > 0 && $(this).val().trim().length >= 2) {
                    $('#searchResults').show();
                }
            });

            // =============================================
            // Add product from search results
            // =============================================
            $(document).on('click', '.search-result-item', function () {
                var id = $(this).data('id');
                var name = $(this).data('name');
                var codigo = $(this).data('codigo');
                var precio = parseFloat($(this).data('precio'));

                addProductToTable(id, name, codigo, precio);

                // Clear search
                $('#productSearch').val('');
                $('#searchResults').hide().empty();
            });

            function addProductToTable(id, name, codigo, precio) {
                if (selectedProducts[id]) return;

                selectedProducts[id] = { id: id, name: name, codigo: codigo, precio: precio };

                var precioStr = precio.toFixed(2);
                var row = $(
                    '<tr data-product-id="' + id + '">' +
                        '<td>' +
                            '<span class="fw-semibold">' + name + '</span>' +
                            '<br><small class="text-muted">' + codigo + '</small>' +
                            '<input type="hidden" name="productos[]" value="' + id + '">' +
                        '</td>' +
                        '<td class="text-end align-middle">S/ ' + precioStr + '</td>' +
                        '<td class="text-center align-middle">' +
                            '<div class="input-group input-group-sm justify-content-center">' +
                                '<input type="number" class="form-control input-descuento" name="descuentos_especificos[' + id + ']" value="0" min="0" max="100" step="0.01">' +
                                '<span class="input-group-text">%</span>' +
                            '</div>' +
                        '</td>' +
                        '<td class="text-center align-middle">' +
                            '<button type="button" class="btn-remove" title="Quitar producto">' +
                                '<i class="bi bi-trash"></i>' +
                            '</button>' +
                        '</td>' +
                    '</tr>'
                );

                $('#selectedProductsBody').append(row);
                updateEmptyMessage();
            }

            // =============================================
            // Remove product from table
            // =============================================
            $(document).on('click', '.btn-remove', function () {
                var $row = $(this).closest('tr');
                var productId = $row.data('product-id');
                delete selectedProducts[productId];
                $row.fadeOut(200, function () {
                    $(this).remove();
                    updateEmptyMessage();
                });
            });

            // =============================================
            // Update empty message visibility
            // =============================================
            function updateEmptyMessage() {
                if ($('#selectedProductsBody tr').length === 0) {
                    $('#emptyProductsMsg').show();
                    $('#selectedProductsTable').hide();
                } else {
                    $('#emptyProductsMsg').hide();
                    $('#selectedProductsTable').show();
                }
            }

            // Initialize empty state
            updateEmptyMessage();

            // =============================================
            // Pre-populate with $productos from controller
            // =============================================
            @if(isset($productos) && $productos->count() > 0)
                var productosIniciales = @json($productos);
                // Products are available for search, not auto-added
                // They will be found via the AJAX search endpoint
            @endif

            // =============================================
            // Image Preview on file select
            // =============================================
            $('#imagen_banner').on('change', function () {
                var file = this.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#imagePreview').attr('src', e.target.result).show();
                        $('#imagePreviewPlaceholder').hide();
                    };
                    reader.readAsDataURL(file);
                } else {
                    $('#imagePreview').hide().attr('src', '');
                    $('#imagePreviewPlaceholder').show();
                }
            });

            // =============================================
            // Form Validation before submit
            // =============================================
            $('#formCampania').on('submit', function (e) {
                var isValid = true;
                var errorMessages = [];

                // Nombre is required
                var nombre = $('#nombre').val().trim();
                if (!nombre) {
                    isValid = false;
                    errorMessages.push('El nombre de la campana es obligatorio.');
                    $('#nombre').addClass('is-invalid');
                } else {
                    $('#nombre').removeClass('is-invalid');
                }

                // Tipo is required
                var tipo = $('#tipo').val();
                if (!tipo) {
                    isValid = false;
                    errorMessages.push('Selecciona un tipo de campana.');
                    $('#tipo').addClass('is-invalid');
                } else {
                    $('#tipo').removeClass('is-invalid');
                }

                // Fecha inicio is required
                var fechaInicio = $('#fecha_inicio').val();
                if (!fechaInicio) {
                    isValid = false;
                    errorMessages.push('La fecha de inicio es obligatoria.');
                    $('#fecha_inicio').addClass('is-invalid');
                } else {
                    $('#fecha_inicio').removeClass('is-invalid');
                }

                // Fecha fin is required
                var fechaFin = $('#fecha_fin').val();
                if (!fechaFin) {
                    isValid = false;
                    errorMessages.push('La fecha de fin es obligatoria.');
                    $('#fecha_fin').addClass('is-invalid');
                } else {
                    $('#fecha_fin').removeClass('is-invalid');
                }

                // Validate date range
                if (fechaInicio && fechaFin && fechaInicio > fechaFin) {
                    isValid = false;
                    errorMessages.push('La fecha de fin debe ser posterior a la fecha de inicio.');
                    $('#fecha_fin').addClass('is-invalid');
                }

                // Validate products (if not aplica todos)
                if (!$('#aplica_todos_productos').is(':checked')) {
                    if ($('#selectedProductsBody tr').length === 0) {
                        isValid = false;
                        errorMessages.push('Selecciona al menos un producto o marca "Aplicar a todos los productos".');
                    }
                }

                if (!isValid) {
                    e.preventDefault();

                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Campos incompletos',
                            html: '<ul class="text-start mb-0" style="font-size:0.9rem;">' +
                                errorMessages.map(function (msg) { return '<li>' + msg + '</li>'; }).join('') +
                                '</ul>',
                            confirmButtonColor: '#0d6efd'
                        });
                    } else {
                        alert(errorMessages.join('\n'));
                    }

                    return false;
                }
            });

            // Remove is-invalid class on input change
            $('input, select, textarea').on('input change', function () {
                $(this).removeClass('is-invalid');
            });

            console.log('Modulo Crear Campana cargado correctamente.');
        });
    </script>
@endsection
