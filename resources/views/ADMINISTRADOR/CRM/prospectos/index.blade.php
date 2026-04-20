@extends('TEMPLATES.administrador')

@section('title', 'PROSPECTOS')

@section('css')
<style>
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.375rem 0.75rem;
        margin-left: 2px;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        background: #fff;
        color: #212529 !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #1C3146 !important;
        color: #fff !important;
        border-color: #1C3146;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #e9ecef !important;
        color: #212529 !important;
        border-color: #dee2e6;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: #1C3146 !important;
        color: #fff !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
        color: #6c757d !important;
        cursor: not-allowed;
    }
    .dataTables_wrapper .dataTables_info {
        padding-top: 0.85em;
        color: #6c757d;
    }
    .dataTables_wrapper .dataTables_paginate {
        float: right;
        text-align: right;
    }
</style>
@endsection

@section('content')
    <!-- Encabezado -->
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">PROSPECTOS</h1>
                <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Prospectos</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- KPIs --}}
    <div class="container-fluid mb-4">
        <div class="row g-3" data-aos="fade-up">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 small">Total Prospectos</p>
                                <h3 class="mb-0 fw-bold text-primary">{{ $estadisticas['total'] ?? 0 }}</h3>
                            </div>
                            <div class="bg-primary bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-people fs-3 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 small">Nuevos este Mes</p>
                                <h3 class="mb-0 fw-bold text-info">{{ $estadisticas['nuevos_mes'] ?? 0 }}</h3>
                            </div>
                            <div class="bg-info bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-calendar-plus fs-3 text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 small">Calificados</p>
                                <h3 class="mb-0 fw-bold text-success">{{ $estadisticas['calificados'] ?? 0 }}</h3>
                            </div>
                            <div class="bg-success bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-check-circle fs-3 text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 small">Tasa de Conversión</p>
                                <h3 class="mb-0 fw-bold text-warning">{{ $estadisticas['tasa_conversion'] ?? 0 }}%</h3>
                            </div>
                            <div class="bg-warning bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-graph-up-arrow fs-3 text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Alertas --}}

    {{-- Tabla --}}
    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px; min-height: 500px"
            data-aos="fade-up" data-aos-anchor-placement="top-bottom">
            <div class="card-header bg-transparent">
                <div class="row justify-content-between align-items-center">
                    <div class="col-12 col-md-6 d-flex gap-2 flex-wrap">
                        <a href="{{ route('admin.crm.prospectos.create') }}"
                            class="btn btn-primary text-uppercase text-white btn-sm">
                            <i class="bi bi-plus-circle-fill me-2"></i>Nuevo Prospecto
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">

                {{-- Filtros --}}
                <div class="row g-2 mb-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label small text-muted mb-1">Estado</label>
                        <select id="filtro-estado" class="form-select form-select-sm select2_bootstrap_2 w-100" data-placeholder="Todos los Estados">
                            <option value="">Todos los Estados</option>
                            <option value="Nuevo">Nuevo</option>
                            <option value="Contactado">Contactado</option>
                            <option value="Calificado">Calificado</option>
                            <option value="Descartado">Descartado</option>
                            <option value="Convertido">Convertido</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted mb-1">Origen</label>
                        <select id="filtro-origen" class="form-select form-select-sm select2_bootstrap_2 w-100" data-placeholder="Todos los Orígenes">
                            <option value="">Todos los Orígenes</option>
                            <option value="Sitio web">Sitio Web</option>
                            <option value="Redes sociales">Redes Sociales</option>
                            <option value="Llamada">Llamada</option>
                            <option value="Referido">Referido</option>
                            <option value="Ecommerce">E-commerce</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted mb-1">Segmento</label>
                        <select id="filtro-segmento" class="form-select form-select-sm select2_bootstrap_2 w-100" data-placeholder="Todos los Segmentos">
                            <option value="">Todos los Segmentos</option>
                            <option value="Residencial">Residencial</option>
                            <option value="Comercial">Comercial</option>
                            <option value="Industrial">Industrial</option>
                            <option value="Agricola">Agrícola</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small text-muted mb-1">Vendedor</label>
                        <select id="filtro-vendedor" class="form-select form-select-sm select2_bootstrap_2 w-100" data-placeholder="Todos los Vendedores">
                            <option value="">Todos los Vendedores</option>
                            <option value="[uid:null]">— Sin asignar —</option>
                            @foreach($vendedores as $vendedor)
                                <option value="[uid:{{ $vendedor->id }}]">
                                    {{ $vendedor->persona?->name ?? $vendedor->email }} {{ $vendedor->persona?->surnames ?? '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto">
                        <button type="button" id="btn-limpiar"
                                class="btn btn-sm btn-outline-secondary"
                                title="Limpiar filtros"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                style="height: 31px; padding: 0 8px; border-radius: 6px;">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-2">
                    <span class="text-uppercase small">Total de registros: <span class="fw-bold">{{ $prospectos->count() }}</span></span>
                </div>

                <table id="tablaProspectos" class="table table-hover align-middle" style="width:100%">
                    <thead class="bg-dark text-white border-0">
                        <tr>
                            <th class="h6 small text-center text-uppercase fw-bold">N°</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Código</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Nombre / Razón Social</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Contacto</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Origen</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Segmento</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Estado</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Asignado</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prospectos as $index => $prospecto)
                            @php
                                $estadoColors = [
                                    'nuevo'      => 'secondary',
                                    'contactado' => 'primary',
                                    'calificado' => 'success',
                                    'descartado' => 'danger',
                                    'convertido' => 'dark',
                                ];
                                $origenColors = [
                                    'sitio_web'      => 'info',
                                    'redes_sociales' => 'primary',
                                    'llamada'        => 'secondary',
                                    'referido'       => 'success',
                                    'ecommerce'      => 'warning',
                                    'otro'           => 'dark',
                                ];
                                $origenIcons = [
                                    'sitio_web'      => 'globe',
                                    'redes_sociales' => 'share',
                                    'llamada'        => 'telephone',
                                    'referido'       => 'people',
                                    'ecommerce'      => 'cart3',
                                    'otro'           => 'tag',
                                ];
                                $segmentoColors = [
                                    'residencial' => 'info',
                                    'comercial'   => 'warning text-dark',
                                    'industrial'  => 'primary',
                                    'agricola'    => 'success',
                                ];
                            @endphp
                            <tr>
                                {{-- N° --}}
                                <td class="text-center align-middle small">{{ $index + 1 }}</td>

                                {{-- Código --}}
                                <td class="text-center align-middle">
                                    <span class="fw-semibold">{{ $prospecto->codigo }}</span>
                                    <br><small class="text-muted">{{ $prospecto->created_at->format('d/m/Y') }}</small>
                                </td>

                                {{-- Nombre --}}
                                <td class="text-start align-middle">
                                    <span class="fw-semibold">
                                        @if($prospecto->tipo_persona === 'juridica')
                                            {{ $prospecto->razon_social ?? $prospecto->nombre }}
                                        @else
                                            {{ $prospecto->nombre }} {{ $prospecto->apellidos }}
                                        @endif
                                    </span>
                                    @if($prospecto->tipo_persona === 'juridica' && $prospecto->ruc)
                                        <br><small class="text-muted">RUC: {{ $prospecto->ruc }}</small>
                                    @elseif($prospecto->dni)
                                        <br><small class="text-muted">DNI: {{ $prospecto->dni }}</small>
                                    @endif
                                </td>

                                {{-- Contacto: solo celular/teléfono; email en tooltip --}}
                                <td class="text-center align-middle">
                                    <small>
                                        @if($prospecto->celular)
                                            <i class="bi bi-phone text-success me-1"></i>{{ $prospecto->celular }}
                                        @elseif($prospecto->telefono)
                                            <i class="bi bi-telephone text-secondary me-1"></i>{{ $prospecto->telefono }}
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </small>
                                    @if($prospecto->email)
                                        <br>
                                        <a href="mailto:{{ $prospecto->email }}"
                                           class="text-decoration-none text-muted"
                                           title="{{ $prospecto->email }}"
                                           data-bs-toggle="tooltip">
                                            <small><i class="bi bi-envelope me-1"></i>
                                                {{ Str::limit($prospecto->email, 20) }}
                                            </small>
                                        </a>
                                    @endif
                                </td>

                                {{-- Origen: badge + wishlist como tooltip, no como badge extra --}}
                                <td class="text-center align-middle">
                                    <span class="badge bg-{{ $origenColors[$prospecto->origen] ?? 'secondary' }}"
                                          @if($prospecto->origen === 'ecommerce' && ($prospecto->wishlist_count ?? 0) > 0)
                                              title="{{ $prospecto->wishlist_count }} productos en lista de deseos"
                                              data-bs-toggle="tooltip"
                                          @endif>
                                        <i class="bi bi-{{ $origenIcons[$prospecto->origen] ?? 'tag' }} me-1"></i>
                                        {{ ucfirst(str_replace('_', ' ', $prospecto->origen)) }}
                                        @if($prospecto->origen === 'ecommerce' && ($prospecto->wishlist_count ?? 0) > 0)
                                            <span class="ms-1 opacity-75">({{ $prospecto->wishlist_count }})</span>
                                        @endif
                                    </span>
                                </td>

                                {{-- Segmento --}}
                                <td class="text-center align-middle">
                                    <span class="badge bg-{{ $segmentoColors[$prospecto->segmento] ?? 'secondary' }}">
                                        {{ ucfirst($prospecto->segmento) }}
                                    </span>
                                </td>

                                {{-- Estado: un solo badge, sin "Es Cliente" --}}
                                <td class="text-center align-middle">
                                    <span class="badge bg-{{ $estadoColors[$prospecto->estado] ?? 'secondary' }}">
                                        {{ ucfirst(str_replace('_', ' ', $prospecto->estado)) }}
                                    </span>
                                </td>

                                {{-- Asignado --}}
                                <td class="text-center align-middle">
                                    <small>{{ $prospecto->vendedor?->persona?->name ?? 'Sin asignar' }}</small>
                                    {{-- Tag oculto con ID del vendedor para filtrado DataTables exacto.
                                         El filtro #filtro-vendedor busca '[uid:1]', '[uid:null]', etc. --}}
                                    <span class="d-none">[uid:{{ $prospecto->user_id ?? 'null' }}]</span>
                                </td>

                                {{-- Acciones --}}
                                <td class="text-center align-middle">
                                    <div class="dropstart">
                                        <button class="btn btn-sm btn-light rounded-circle shadow-sm" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            style="width: 36px; height: 36px; padding: 0;">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow">
                                            <li>
                                                <a href="{{ route('admin.crm.prospectos.show', $prospecto) }}"
                                                   class="dropdown-item d-flex align-items-center">
                                                    <i class="bi bi-eye text-info me-2"></i>Ver Detalles
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin.crm.prospectos.edit', ['prospecto' => $prospecto, 'redirect_to' => 'index']) }}"
                                                   class="dropdown-item d-flex align-items-center">
                                                    <i class="bi bi-pencil text-secondary me-2"></i>Editar
                                                </a>
                                            </li>
                                            @if($prospecto->estado === 'calificado')
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a href="{{ route('admin.crm.oportunidades.create', ['prospecto_id' => $prospecto->id]) }}"
                                                   class="dropdown-item d-flex align-items-center text-success">
                                                    <i class="bi bi-bullseye me-2"></i>Crear Oportunidad
                                                </a>
                                            </li>
                                            @endif
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('admin.crm.prospectos.destroy', $prospecto) }}"
                                                      method="POST" class="form-delete d-inline"
                                                      data-nombre="{{ $prospecto->nombre_completo }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="dropdown-item d-flex align-items-center text-danger">
                                                        <i class="bi bi-trash me-2"></i>Eliminar
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
$(document).ready(function() {

    // Inicializar tooltips
    $('[data-bs-toggle="tooltip"]').each(function() {
        new bootstrap.Tooltip(this);
    });

    // DataTable
    var table = $('#tablaProspectos').DataTable({
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
            paginate: { first: '«', previous: '‹', next: '›', last: '»' },
            info: 'Mostrando página _PAGE_ de _PAGES_',
            emptyTable: '<div class="text-center py-4"><div class="text-muted"><i class="bi bi-inbox fs-1 d-block mb-2"></i>No hay prospectos registrados</div><a href="{{ route("admin.crm.prospectos.create") }}" class="btn btn-primary btn-sm mt-2"><i class="bi bi-plus-circle me-1"></i>Crear primer prospecto</a></div>'
        },
        pageLength: 10,
        order: [[1, 'desc']], // Más reciente primero
        columnDefs: [
            { orderable: false, targets: [8] }
        ],
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row align-items-center"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7 d-flex justify-content-end"p>>'
    });

    // Filtros
    $('#filtro-estado').on('change', function() {
        table.column(6).search($(this).val()).draw();
    });
    $('#filtro-origen').on('change', function() {
        table.column(4).search($(this).val()).draw();
    });
    $('#filtro-segmento').on('change', function() {
        table.column(5).search($(this).val()).draw();
    });
    $('#filtro-vendedor').on('change', function() {
        // Usar regex exacta (no substring) para evitar que [uid:1] matchee [uid:10], [uid:11], etc.
        // El tag está encapsulado entre [ y ] así que ^...$ garantiza match exacto dentro del span oculto.
        const val = $(this).val();
        table.column(7).search(
            val ? $.fn.dataTable.util.escapeRegex(val) : '',
            true,   // es regex
            false   // smart search desactivado
        ).draw();
    });

    // Limpiar filtros
    $('#btn-limpiar').on('click', function() {
        $('[id^="filtro-"]').each(function() {
            $(this).val('').trigger('change');
        });
        table.search('').columns().search('').draw();
    });

    // Inicializar tooltip Bootstrap
    var tooltipEl = document.querySelector('#btn-limpiar');
    if (tooltipEl) { new bootstrap.Tooltip(tooltipEl); }

    // SweetAlert eliminar
    $('.form-delete').submit(function(e) {
        e.preventDefault();
        const form = this;
        Swal.fire({
            title: '¿Estás seguro?',
            text: '¡No podrás revertir esto!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1C3146',
            cancelButtonColor: '#FF9C00',
            confirmButtonText: '¡Sí, eliminar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) { form.submit(); }
        });
    });

});
</script>
@endsection
