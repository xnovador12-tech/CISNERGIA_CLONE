@extends('TEMPLATES.administrador')
@section('title', 'CLIENTES')

@section('css')
<style>
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.375rem 0.75rem; margin-left: 2px; border: 1px solid #dee2e6; border-radius: 0.25rem; background: #fff; color: #212529 !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current { background: #1C3146 !important; color: #fff !important; border-color: #1C3146; }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover { background: #e9ecef !important; color: #212529 !important; }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover { background: #1C3146 !important; color: #fff !important; }
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled { color: #6c757d !important; cursor: not-allowed; }
    .dataTables_wrapper .dataTables_info { padding-top: 0.85em; color: #6c757d; }
    .dataTables_wrapper .dataTables_paginate { float: right; text-align: right; }
</style>
@endsection

@section('content')
    <!-- Encabezado -->
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">CLIENTES</h1>
                <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Clientes</li>
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
                                <p class="text-muted mb-1 small">Total Clientes</p>
                                <h3 class="mb-0 fw-bold">{{ $stats['total'] ?? 0 }}</h3>
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
                                <p class="text-muted mb-1 small">Activos</p>
                                <h3 class="mb-0 fw-bold text-success">{{ $stats['activos'] ?? 0 }}</h3>
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
                                <p class="text-muted mb-1 small">Inactivos</p>
                                <h3 class="mb-0 fw-bold text-danger">{{ $stats['inactivos'] ?? 0 }}</h3>
                            </div>
                            <div class="bg-danger bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-person-x fs-3 text-danger"></i>
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
                                <p class="text-muted mb-1 small">Suspendidos</p>
                                <h3 class="mb-0 fw-bold text-warning">{{ $stats['suspendidos'] ?? 0 }}</h3>
                            </div>
                            <div class="bg-warning bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-exclamation-triangle fs-3 text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Alertas de sesión --}}

    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm h-100" style="border-radius: 20px; min-height: 500px"
            data-aos="fade-up" data-aos-anchor-placement="top-bottom">
            <div class="card-header bg-transparent">
                <div class="d-flex justify-content-end">
                    <div class="card border-0 rounded-0 border-start border-3 border-info" style="box-shadow: rgba(17, 17, 26, 0.1) 0px 1px 0px; background-color: #f6f6f6">
                        <div class="card-body py-2">
                            <i class="bi bi-info-circle text-info me-2"></i>
                            <small class="text-muted">Los clientes se generan automáticamente al completar una venta (CRM o E-commerce).</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                {{-- Filtros --}}
                <div class="row g-2 mb-3 align-items-end">
                    <div class="col-md-3">
                        <label for="filtro-estado" class="form-label small text-muted mb-1">Estado</label>
                        <select id="filtro-estado" class="form-select form-select-sm select2_bootstrap_2 w-100" data-placeholder="Todos los Estados">
                            <option value="">Todos los Estados</option>
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                            <option value="Suspendido">Suspendido</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="filtro-segmento" class="form-label small text-muted mb-1">Segmento</label>
                        <select id="filtro-segmento" class="form-select form-select-sm select2_bootstrap_2 w-100" data-placeholder="Todos los Segmentos">
                            <option value="">Todos los Segmentos</option>
                            <option value="Residencial">Residencial</option>
                            <option value="Comercial">Comercial</option>
                            <option value="Industrial">Industrial</option>
                            <option value="Agricola">Agrícola</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="filtro-origen" class="form-label small text-muted mb-1">Origen</label>
                        <select id="filtro-origen" class="form-select form-select-sm select2_bootstrap_2 w-100" data-placeholder="Todos los Orígenes">
                            <option value="">Todos los Orígenes</option>
                            <option value="E-commerce">E-commerce</option>
                            <option value="Directo">Directo</option>
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

                <div class="mb-2 col-12 col-md-6">
                    <span class="text-uppercase">Total de registros: <span class="fw-bold">{{ $clientes->count() }}</span></span>
                </div>

                <table id="tablaClientes" class="table table-hover align-middle" cellspacing="0" style="width:100%">
                    <thead class="bg-dark text-white border-0">
                        <tr>
                            <th class="h6 small text-center text-uppercase fw-bold">N°</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Código</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Nombre / Razón Social</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Contacto</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Origen</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Segmento</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Estado</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Vendedor</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clientes as $index => $cliente)
                            @php
                                $estadoColors = ['activo' => 'success', 'inactivo' => 'secondary', 'suspendido' => 'danger'];
                                $origenColors = ['ecommerce' => 'info', 'directo' => 'primary'];
                                $segmentoColors = ['residencial' => 'primary', 'comercial' => 'success', 'industrial' => 'warning', 'agricola' => 'info'];
                            @endphp
                            <tr>
                                <td class="fw-normal text-center align-middle"></td>
                                <td class="fw-normal text-center align-middle">
                                    <span class="fw-semibold">{{ $cliente->codigo }}</span>
                                    <br><small class="text-muted">{{ $cliente->created_at->format('d/m/Y') }}</small>
                                </td>
                                <td class="fw-normal text-start align-middle" style="max-width: 250px;">
                                    <div class="text-truncate" style="max-width: 250px;" title="{{ $cliente->nombre_completo }}">
                                        <strong>{{ $cliente->nombre_completo }}</strong>
                                    </div>
                                    @if($cliente->tipo_persona === 'juridica' && $cliente->razon_social)
                                        <small class="text-muted">{{ $cliente->documento }}</small>
                                    @else
                                        <small class="text-muted">DNI: {{ $cliente->dni ?? '-' }}</small>
                                    @endif
                                </td>
                                <td class="fw-normal text-center align-middle">
                                    <small>
                                        @if($cliente->email)
                                            <i class="bi bi-envelope text-info me-1"></i>{{ Str::limit($cliente->email, 22) }}<br>
                                        @endif
                                        @if($cliente->celular)
                                            <i class="bi bi-phone text-success me-1"></i>{{ $cliente->celular }}
                                        @endif
                                    </small>
                                </td>
                                <td class="fw-normal text-center align-middle">
                                    <span class="badge bg-{{ $origenColors[$cliente->origen] ?? 'secondary' }}">
                                        {{ $cliente->origen === 'ecommerce' ? 'E-commerce' : 'Directo' }}
                                    </span>
                                </td>
                                <td class="fw-normal text-center align-middle">
                                    <span class="badge bg-{{ $segmentoColors[$cliente->segmento] ?? 'secondary' }}">
                                        {{ ucfirst($cliente->segmento) }}
                                    </span>
                                </td>
                                <td class="fw-normal text-center align-middle">
                                    <span class="badge bg-{{ $estadoColors[$cliente->estado] ?? 'secondary' }}">
                                        {{ ucfirst($cliente->estado) }}
                                    </span>
                                </td>
                                <td class="fw-normal text-center align-middle">
                                    <small>{{ $cliente->vendedor?->persona?->name ?? 'Sin asignar' }}</small>
                                </td>
                                <td class="text-center align-middle">
                                    <div class="dropstart">
                                        <button class="btn btn-sm btn-light rounded-circle shadow-sm" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            style="width: 36px; height: 36px; padding: 0;">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow">
                                            <li>
                                                <a href="{{ route('admin.crm.clientes.show', $cliente) }}"
                                                   class="dropdown-item d-flex align-items-center">
                                                    <i class="bi bi-eye text-info me-2"></i>Ver Ficha
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin.crm.clientes.edit', $cliente) }}"
                                                   class="dropdown-item d-flex align-items-center">
                                                    <i class="bi bi-pencil text-secondary me-2"></i>Editar
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('admin.crm.clientes.destroy', $cliente) }}"
                                                      method="POST" class="form-delete d-inline">
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
    var table = $('#tablaClientes').DataTable({
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
            paginate: { first: '«', previous: '‹', next: '›', last: '»' },
            info: 'Mostrando página _PAGE_ de _PAGES_',
            emptyTable: '<div class="text-center py-4"><div class="text-muted"><i class="bi bi-people fs-1 d-block mb-2"></i>No hay clientes registrados</div><p class="text-muted small mt-2">Los clientes se crean automáticamente al completar una venta.</p></div>'
        },
        pageLength: 10,
        order: [[1, 'desc']],
        columnDefs: [
            { orderable: false, searchable: false, targets: [0, 8] }
        ],
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row align-items-center"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7 d-flex justify-content-end"p>>',
        drawCallback: function(settings) {
            var api = this.api();
            api.column(0, { search: 'applied', order: 'applied', page: 'current' }).nodes().each(function(cell, i) {
                cell.innerHTML = api.page.info().start + i + 1;
            });
        }
    });

    // Filtro por Estado (columna 6)
    $('#filtro-estado').on('change', function() {
        table.column(6).search($(this).val()).draw();
    });

    // Filtro por Segmento (columna 5)
    $('#filtro-segmento').on('change', function() {
        table.column(5).search($(this).val()).draw();
    });

    // Filtro por Origen (columna 4)
    $('#filtro-origen').on('change', function() {
        table.column(4).search($(this).val()).draw();
    });

    // Limpiar filtros
    $('#btn-limpiar').on('click', function() {
        $('[id^="filtro-"]').each(function() {
            $(this).val('').trigger('change');
        });
        table.search('').columns().search('').draw();
    });

    // Inicializar tooltip
    var tooltipEl = document.querySelector('#btn-limpiar');
    if (tooltipEl) { new bootstrap.Tooltip(tooltipEl); }

    // SweetAlert para eliminar
    $('.form-delete').submit(function(e) {
        e.preventDefault();
        const form = this;
        Swal.fire({
            title: '¿Eliminar cliente?',
            html: 'Se eliminará este cliente y toda su información asociada.<br><strong class="text-danger">Esta acción no se puede deshacer.</strong>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1C3146',
            cancelButtonColor: '#FF9C00',
            confirmButtonText: '<i class="bi bi-trash me-1"></i> Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) { form.submit(); }
        });
    });
});
</script>
@endsection
