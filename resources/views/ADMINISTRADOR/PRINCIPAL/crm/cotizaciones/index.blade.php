@extends('TEMPLATES.administrador')
@section('title', 'COTIZACIONES')

@section('css')
<style>
    /* Estilos de paginación DataTables */
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
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">COTIZACIONES TÉCNICAS</h1>
                <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Cotizaciones</li>
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
                                <p class="text-muted mb-1 small">Cotizaciones Mes</p>
                                <h3 class="mb-0 fw-bold">{{ $stats['total_mes'] ?? 0 }}</h3>
                            </div>
                            <div class="bg-primary bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-file-text fs-3 text-primary"></i>
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
                                <p class="text-muted mb-1 small">Valor Total</p>
                                <h3 class="mb-0 fw-bold text-success">S/ {{ number_format($stats['valor_total'] ?? 0, 0) }}</h3>
                            </div>
                            <div class="bg-success bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-cash-stack fs-3 text-success"></i>
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
                                <p class="text-muted mb-1 small">Aprobadas</p>
                                <h3 class="mb-0 fw-bold text-info">{{ $stats['aprobadas'] ?? 0 }}</h3>
                            </div>
                            <div class="bg-info bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-check-circle fs-3 text-info"></i>
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
                                <p class="text-muted mb-1 small">Pendientes</p>
                                <h3 class="mb-0 fw-bold text-warning">{{ $stats['pendientes'] ?? 0 }}</h3>
                            </div>
                            <div class="bg-warning bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-clock fs-3 text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="container-fluid mb-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="container-fluid mb-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px; min-height: 500px" data-aos="fade-up">
            <div class="card-header bg-transparent">
                <div class="row justify-content-between align-items-center">
                    <div class="col-12 col-md-6 mb-2 mb-md-0">
                        <a href="{{ route('admin.crm.cotizaciones.create') }}" class="btn btn-primary text-uppercase text-white btn-sm">
                            <i class="bi bi-plus-circle-fill me-2"></i>Nueva Cotización
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                {{-- Filtros --}}
                <div class="row g-2 mb-3 align-items-center">
                    <div class="col-md-3">
                        <select id="filtro-estado" class="form-select form-select-sm">
                            <option value="">Todos los Estados</option>
                            <option value="borrador">Borrador</option>
                            <option value="enviada">Enviada</option>
                            <option value="vista">Vista</option>
                            <option value="en_revision">En Revisión</option>
                            <option value="aceptada">Aceptada</option>
                            <option value="rechazada">Rechazada</option>
                            <option value="vencida">Vencida</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="filtro-usuario" class="form-select form-select-sm">
                            <option value="">Todos los Usuarios</option>
                            @foreach($usuarios as $usuario)
                                <option value="{{ $usuario->persona->name ?? $usuario->email }}">
                                    {{ $usuario->persona->name ?? $usuario->email }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="mb-2 col-12 col-md-6">
                    <span class="text-uppercase">Total de registros: <span class="fw-bold">{{ $cotizaciones->count() }}</span></span>
                </div>
                <table id="tablaCotizaciones" class="table table-hover align-middle" cellspacing="0" style="width:100%">
                    <thead class="bg-dark text-white border-0">
                        <tr>
                            <th class="h6 small text-center text-uppercase fw-bold">N°</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Código</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Oportunidad / Cliente</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Potencia</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Producción Anual</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Ahorro Anual</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Total</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Estado</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Acciones</th>
                        </tr>
                    </thead>
                        <tbody>
                            @forelse($cotizaciones as $i => $cotizacione)
                                @php
                                    $estadoColors = [
                                        'borrador' => 'secondary', 
                                        'enviada' => 'primary', 
                                        'vista' => 'info',
                                        'en_revision' => 'warning',
                                        'aceptada' => 'success', 
                                        'rechazada' => 'danger', 
                                        'vencida' => 'dark',
                                        'cancelada' => 'dark'
                                    ];
                                @endphp
                                <tr>
                                    <td class="text-center">{{ $i + 1 }}</td>
                                    <td class="text-center">
                                        <strong>{{ $cotizacione->codigo }}</strong>
                                        <br><small class="text-muted">{{ $cotizacione->created_at->format('d/m/Y') }}</small>
                                        @if($cotizacione->version > 1)
                                            <br><span class="badge bg-info">v{{ $cotizacione->version }}</span>
                                        @endif
                                    </td>
                                    <td class="text-start">
                                        @if($cotizacione->oportunidad)
                                            <strong>{{ Str::limit($cotizacione->oportunidad->nombre, 30) }}</strong>
                                            @if($cotizacione->oportunidad->prospecto)
                                                <br><small class="text-muted">{{ Str::limit($cotizacione->oportunidad->prospecto->nombre_completo, 30) }}</small>
                                            @endif
                                        @else
                                            <span class="text-muted">Sin oportunidad</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info">{{ number_format($cotizacione->potencia_kw ?? 0, 1) }} kW</span>
                                    </td>
                                    <td class="text-center">{{ number_format($cotizacione->produccion_anual_kwh ?? 0, 0) }} kWh</td>
                                    <td class="text-center text-success fw-bold">S/ {{ number_format($cotizacione->ahorro_anual_soles ?? 0, 0) }}</td>
                                    <td class="text-center text-primary fw-bold">S/ {{ number_format($cotizacione->total ?? 0, 0) }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-{{ $estadoColors[$cotizacione->estado] ?? 'secondary' }}">
                                            {{ ucfirst(str_replace('_', ' ', $cotizacione->estado)) }}
                                        </span>
                                        @if($cotizacione->fecha_vigencia && $cotizacione->fecha_vigencia->isPast() && !in_array($cotizacione->estado, ['aceptada', 'rechazada', 'vencida']))
                                            <br><small class="text-danger"><i class="bi bi-exclamation-triangle"></i> Vencida</small>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="dropstart">
                                            <button class="btn btn-sm btn-light rounded-circle shadow-sm" data-bs-toggle="dropdown" style="width: 36px; height: 36px; padding: 0;">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu shadow">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.crm.cotizaciones.show', $cotizacione) }}">
                                                        <i class="bi bi-eye text-info me-2"></i>Ver Detalles
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.crm.cotizaciones.pdf', $cotizacione) }}">
                                                        <i class="bi bi-file-pdf text-danger me-2"></i>Descargar PDF
                                                    </a>
                                                </li>
                                                @if(!in_array($cotizacione->estado, ['aceptada', 'rechazada']))
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('admin.crm.cotizaciones.edit', $cotizacione) }}">
                                                            <i class="bi bi-pencil text-secondary me-2"></i>Editar
                                                        </a>
                                                    </li>
                                                @endif
                                                @if($cotizacione->estado === 'borrador')
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <form action="{{ route('admin.crm.cotizaciones.enviar', $cotizacione) }}" method="POST">
                                                            @csrf
                                                            <button class="dropdown-item text-primary">
                                                                <i class="bi bi-send me-2"></i>Enviar al Cliente
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                                @if($cotizacione->estado === 'enviada')
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <form action="{{ route('admin.crm.cotizaciones.aprobar', $cotizacione) }}" method="POST">
                                                            @csrf
                                                            <button class="dropdown-item text-success">
                                                                <i class="bi bi-check-circle me-2"></i>Marcar Aprobada
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <button type="button" class="dropdown-item text-danger" 
                                                                onclick="rechazarCotizacion('{{ $cotizacione->slug }}')">
                                                            <i class="bi bi-x-circle me-2"></i>Marcar Rechazada
                                                        </button>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        No hay cotizaciones registradas
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    // Inicializar DataTable con filtros del lado del cliente
    var table = $('#tablaCotizaciones').DataTable({
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
            paginate: {
                first: '«',
                previous: '‹',
                next: '›',
                last: '»'
            },
            info: 'Mostrando página _PAGE_ de _PAGES_'
        },
        pageLength: 10,
        order: [[1, 'desc']],
        columnDefs: [
            { orderable: false, targets: [8] } // Desactivar orden en columna de acciones
        ],
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row align-items-center"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7 d-flex justify-content-end"p>>'
    });

    // Filtro por Estado (columna 7)
    $('#filtro-estado').on('change', function() {
        var val = $(this).val();
        table.column(7).search(val).draw();
    });

    // Filtro por Usuario (en columna 2 - dentro del nombre de oportunidad)
    $('#filtro-usuario').on('change', function() {
        var val = $(this).val();
        table.search(val).draw();
    });
});

// Función para rechazar cotización con motivo
function rechazarCotizacion(slug) {
    Swal.fire({
        title: '¿Rechazar Cotización?',
        html: '<textarea id="motivo_rechazo" class="form-control" rows="3" placeholder="Ingrese el motivo del rechazo..." required></textarea>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, rechazar',
        cancelButtonText: 'Cancelar',
        preConfirm: () => {
            const motivo = document.getElementById('motivo_rechazo').value;
            if (!motivo) {
                Swal.showValidationMessage('Debe ingresar un motivo');
                return false;
            }
            return motivo;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Crear formulario y enviarlo
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("admin.crm.cotizaciones.index") }}/' + slug + '/rechazar';
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);
            
            const motivoInput = document.createElement('input');
            motivoInput.type = 'hidden';
            motivoInput.name = 'motivo_rechazo';
            motivoInput.value = result.value;
            form.appendChild(motivoInput);
            
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
@endsection
