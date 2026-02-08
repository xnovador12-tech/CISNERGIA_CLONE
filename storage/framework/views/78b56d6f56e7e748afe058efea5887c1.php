<?php $__env->startSection('title', 'MARKETING'); ?>

<?php $__env->startSection('content'); ?>
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">MARKETING DIGITAL</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link"
                                href="<?php echo e(route('admin-dashboard.index')); ?>">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Marketing</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mb-4">
        <div class="row g-3" data-aos="fade-up">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <small class="text-muted">Leads Generados (Mes)</small>
                        <h3 class="mb-0 fw-bold text-primary">247</h3>
                        <small class="text-success"><i class="bi bi-arrow-up"></i> +18%</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <small class="text-muted">Tasa Conversión</small>
                        <h3 class="mb-0 fw-bold text-success">12.4%</h3>
                        <small class="text-success"><i class="bi bi-arrow-up"></i> +2.3%</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <small class="text-muted">Costo por Lead</small>
                        <h3 class="mb-0 fw-bold text-warning">S/ 45</h3>
                        <small class="text-success"><i class="bi bi-arrow-down"></i> -5%</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <small class="text-muted">ROI Campañas</small>
                        <h3 class="mb-0 fw-bold text-info">320%</h3>
                        <small class="text-success"><i class="bi bi-arrow-up"></i> +45%</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <ul class="nav nav-tabs mb-3" data-aos="fade-up">
            <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#campanas"><i
                        class="bi bi-broadcast me-2"></i>Campañas</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#segmentacion"><i
                        class="bi bi-diagram-3 me-2"></i>Segmentación</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#analytics"><i
                        class="bi bi-graph-up me-2"></i>Analytics</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="campanas">
                <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px; min-height: 400px"
                    data-aos="fade-up">
                    <div class="card-header bg-transparent">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#createCampana"
                            class="btn btn-primary text-uppercase text-white btn-sm">
                            <i class="bi bi-plus-circle-fill me-2"></i>Nueva Campaña
                        </button>
                    </div>
                    <div class="card-body">
                        <table id="tablaCampanas" class="table table-hover align-middle nowrap" cellspacing="0"
                            style="width:100%">
                            <thead class="bg-dark text-white border-0">
                                <tr>
                                    <th class="h6 small text-center text-uppercase fw-bold">Campaña</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Tipo</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Estado</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Enviados</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Aperturas</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Clicks</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Conversiones</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">ROI</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-normal text-start align-middle"><strong>Promo Verano 2024</strong></td>
                                    <td class="fw-normal text-center align-middle"><span class="badge bg-primary"><i
                                                class="bi bi-envelope me-1"></i>Email</span></td>
                                    <td class="fw-normal text-center align-middle"><span
                                            class="badge bg-success">Activa</span></td>
                                    <td class="fw-normal text-center align-middle">1,198</td>
                                    <td class="fw-normal text-center align-middle">456 <small
                                            class="text-muted">(38%)</small></td>
                                    <td class="fw-normal text-center align-middle">127 <small
                                            class="text-muted">(28%)</small></td>
                                    <td class="fw-normal text-center align-middle">23 <small
                                            class="text-muted">(18%)</small></td>
                                    <td class="fw-normal text-center align-middle"><span
                                            class="text-success fw-bold">280%</span></td>
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

            <div class="tab-pane fade" id="segmentacion">
                <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px; min-height: 400px">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Segmentos Disponibles</h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6>Clientes Residenciales</h6>
                                        <p class="text-muted small mb-2">Filtro: Segmento = Residencial</p>
                                        <p class="mb-0"><strong>456 contactos</strong></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6>Empresas Comerciales</h6>
                                        <p class="text-muted small mb-2">Filtro: Segmento = Comercial</p>
                                        <p class="mb-0"><strong>234 contactos</strong></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6>Leads Alta Prioridad</h6>
                                        <p class="text-muted small mb-2">Filtro: Scoring = A</p>
                                        <p class="mb-0"><strong>89 contactos</strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="analytics">
                <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px; min-height: 400px">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Rendimiento por Canal</h6>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <div class="card text-center bg-light">
                                    <div class="card-body">
                                        <i class="bi bi-envelope fs-2 text-primary"></i>
                                        <h6 class="mt-2">Email Marketing</h6>
                                        <p class="mb-0"><strong>145 leads</strong></p>
                                        <small class="text-muted">Costo: S/ 38/lead</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card text-center bg-light">
                                    <div class="card-body">
                                        <i class="bi bi-facebook fs-2 text-info"></i>
                                        <h6 class="mt-2">Facebook Ads</h6>
                                        <p class="mb-0"><strong>67 leads</strong></p>
                                        <small class="text-muted">Costo: S/ 52/lead</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card text-center bg-light">
                                    <div class="card-body">
                                        <i class="bi bi-google fs-2 text-danger"></i>
                                        <h6 class="mt-2">Google Ads</h6>
                                        <p class="mb-0"><strong>35 leads</strong></p>
                                        <small class="text-muted">Costo: S/ 68/lead</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card text-center bg-light">
                                    <div class="card-body">
                                        <i class="bi bi-share fs-2 text-success"></i>
                                        <h6 class="mt-2">Referidos</h6>
                                        <p class="mb-0"><strong>23 leads</strong></p>
                                        <small class="text-muted">Costo: S/ 15/lead</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Crear Campaña -->
    <div class="modal fade" id="createCampana" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Nueva Campaña</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nombre Campaña</label>
                                <input type="text" class="form-control" placeholder="Promo Verano 2024">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tipo</label>
                                <select class="form-select">
                                    <option>Email Marketing</option>
                                    <option>SMS</option>
                                    <option>WhatsApp</option>
                                    <option>Redes Sociales</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Fecha Inicio</label>
                                <input type="date" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Fecha Fin</label>
                                <input type="date" class="form-control">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Segmento Objetivo</label>
                                <select class="form-select">
                                    <option>Clientes Residenciales</option>
                                    <option>Empresas Comerciales</option>
                                    <option>Leads Alta Prioridad</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Presupuesto (S/)</label>
                                <input type="number" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Crear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        $(document).ready(function() {
            $('#tablaCampanas').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
                },
                order: [
                    [1, 'desc']
                ]
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\CESHER\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/PRINCIPAL/crm/marketing/index.blade.php ENDPATH**/ ?>