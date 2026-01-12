@extends('TEMPLATES.administrador')
@section('title', 'POSTVENTA')

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">POSTVENTA</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link"
                                href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Postventa</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mb-4">
        <div class="row g-3" data-aos="fade-up">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body"><small class="text-muted">Reclamos Abiertos</small>
                        <h3 class="mb-0 fw-bold text-danger">8</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body"><small class="text-muted">En Proceso</small>
                        <h3 class="mb-0 fw-bold text-warning">12</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body"><small class="text-muted">Resueltos Hoy</small>
                        <h3 class="mb-0 fw-bold text-success">5</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body"><small class="text-muted">SLA Cumplido</small>
                        <h3 class="mb-0 fw-bold text-info">92%</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <ul class="nav nav-tabs mb-3" data-aos="fade-up">
            <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#reclamos"><i
                        class="bi bi-exclamation-triangle me-2"></i>Reclamos</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#garantias"><i
                        class="bi bi-shield-check me-2"></i>Garantías</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#mantenimientos"><i
                        class="bi bi-tools me-2"></i>Mantenimientos</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="reclamos">
                <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px; min-height: 400px"
                    data-aos="fade-up">
                    <div class="card-header bg-transparent">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#createReclamo"
                            class="btn btn-primary text-uppercase text-white btn-sm">
                            <i class="bi bi-plus-circle-fill me-2"></i>Nuevo Reclamo
                        </button>
                    </div>
                    <div class="card-body">
                        <table id="tablaReclamos" class="table table-hover align-middle nowrap" cellspacing="0"
                            style="width:100%">
                            <thead class="bg-dark text-white border-0">
                                <tr>
                                    <th class="h6 small text-center text-uppercase fw-bold">Ticket</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Cliente</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Asunto</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Tipo</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Prioridad</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Estado</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">SLA</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-normal text-center align-middle"><strong>#TK-001</strong></td>
                                    <td class="fw-normal text-center align-middle">Carlos Mendoza SAC</td>
                                    <td class="fw-normal text-start align-middle">Falla en inversor</td>
                                    <td class="fw-normal text-center align-middle"><span
                                            class="badge bg-warning">Técnico</span></td>
                                    <td class="fw-normal text-center align-middle"><span class="badge bg-danger">Alta</span>
                                    </td>
                                    <td class="fw-normal text-center align-middle"><span class="badge bg-info">En
                                            Proceso</span></td>
                                    <td class="fw-normal text-center align-middle"><small class="text-success">2h
                                            restantes</small></td>
                                    <td class="text-center align-middle">
                                        <div class="dropstart">
                                            <button class="btn btn-sm btn-light rounded-circle shadow-sm" type="button"
                                                data-bs-toggle="dropdown" style="width: 36px; height: 36px; padding: 0;">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu shadow">
                                                <li><a class="dropdown-item" href="#"><i
                                                            class="bi bi-eye text-info me-2"></i>Ver</a></li>
                                                <li><a class="dropdown-item" href="#"><i
                                                            class="bi bi-pencil text-secondary me-2"></i>Editar</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="garantias">
                <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px; min-height: 400px">
                    <div class="card-body">
                        <p class="text-muted">Gestión de garantías de productos y servicios...</p>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="mantenimientos">
                <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px; min-height: 400px">
                    <div class="card-body">
                        <p class="text-muted">Programación de mantenimientos preventivos...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Crear Reclamo -->
    <div class="modal fade" id="createReclamo" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Nuevo Reclamo</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form class="needs-validation" novalidate>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Cliente <span class="text-danger">*</span></label>
                                <select class="form-select" required>
                                    <option value="">Seleccionar...</option>
                                    <option>Carlos Mendoza SAC</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tipo <span class="text-danger">*</span></label>
                                <select class="form-select" required>
                                    <option value="">Seleccionar...</option>
                                    <option>Técnico</option>
                                    <option>Comercial</option>
                                    <option>Garantía</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Prioridad <span class="text-danger">*</span></label>
                                <select class="form-select" required>
                                    <option>Alta</option>
                                    <option>Media</option>
                                    <option>Baja</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Asignado a</label>
                                <select class="form-select">
                                    <option>Juan Diego</option>
                                    <option>María López</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Asunto <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Descripción</label>
                                <textarea class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#tablaReclamos').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
                }
            });
        });
    </script>
@endsection
