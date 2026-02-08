<?php $__env->startSection('title', 'COTIZACIONES'); ?>

<?php $__env->startSection('content'); ?>
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">COTIZACIONES TÉCNICAS</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link"
                                href="<?php echo e(route('admin-dashboard.index')); ?>">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Cotizaciones</li>
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
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small">Cotizaciones Mes</p>
                                <h3 class="mb-0 fw-bold">32</h3>
                            </div>
                            <div class="bg-primary bg-opacity-10 p-3 rounded-3"><i
                                    class="bi bi-file-text fs-3 text-primary"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small">Valor Total</p>
                                <h3 class="mb-0 fw-bold text-success">S/ 1.2M</h3>
                            </div>
                            <div class="bg-success bg-opacity-10 p-3 rounded-3"><i
                                    class="bi bi-cash-stack fs-3 text-success"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small">Aceptadas</p>
                                <h3 class="mb-0 fw-bold text-info">18</h3>
                            </div>
                            <div class="bg-info bg-opacity-10 p-3 rounded-3"><i
                                    class="bi bi-check-circle fs-3 text-info"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small">Pendientes</p>
                                <h3 class="mb-0 fw-bold text-warning">14</h3>
                            </div>
                            <div class="bg-warning bg-opacity-10 p-3 rounded-3"><i
                                    class="bi bi-clock fs-3 text-warning"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm h-100" style="border-radius: 20px; min-height: 500px"
            data-aos="fade-up">
            <div class="card-header bg-transparent">
                <button type="button" data-bs-toggle="modal" data-bs-target="#createCotizacion"
                    class="btn btn-primary text-uppercase text-white btn-sm">
                    <i class="bi bi-plus-circle-fill me-2"></i>Nueva Cotización
                </button>
            </div>
            <div class="card-body">
                <table id="tablaCotizaciones" class="table table-hover align-middle nowrap" cellspacing="0"
                    style="width:100%">
                    <thead class="bg-dark text-white border-0">
                        <tr>
                            <th class="h6 small text-center text-uppercase fw-bold">N°</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Cotización</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Cliente</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Potencia</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Producción Anual</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Ahorro Anual</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Monto</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Estado</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $contador = 1; ?>
                        <tr>
                            <td class="fw-normal text-center align-middle"><?php echo e($contador); ?></td>
                            <td class="fw-normal text-center align-middle"><strong>#COT-2024-001</strong><br><small
                                    class="text-muted">10/01/2024</small></td>
                            <td class="fw-normal text-center align-middle">Carlos Mendoza SAC</td>
                            <td class="fw-normal text-center align-middle"><span class="badge bg-info">15 kW</span></td>
                            <td class="fw-normal text-center align-middle">24,500 kWh</td>
                            <td class="fw-normal text-center align-middle text-success fw-bold">S/ 12,250</td>
                            <td class="fw-normal text-center align-middle text-primary fw-bold">S/ 120,000</td>
                            <td class="fw-normal text-center align-middle"><span class="badge bg-success">Aceptada</span>
                            </td>
                            <td class="text-center align-middle">
                                <div class="dropstart">
                                    <button class="btn btn-sm btn-light rounded-circle shadow-sm" type="button"
                                        data-bs-toggle="dropdown" style="width: 36px; height: 36px; padding: 0;">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu shadow">
                                        <li><a class="dropdown-item" href="#"><i
                                                    class="bi bi-file-pdf text-danger me-2"></i>Descargar PDF</a></li>
                                        <li><a class="dropdown-item" href="#"><i
                                                    class="bi bi-eye text-info me-2"></i>Ver Detalles</a></li>
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

    <!-- Modal: Crear Cotización -->
    <div class="modal fade" id="createCotizacion" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Nueva Cotización</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form class="needs-validation" novalidate>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Oportunidad <span class="text-danger">*</span></label>
                                <select class="form-select" required>
                                    <option value="">Seleccionar...</option>
                                    <option>Sistema Comercial 15kW - Carlos Mendoza</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Potencia Instalada (kW) <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" step="0.1" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Producción Estimada Anual (kWh)</label>
                                <input type="number" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Ahorro Estimado Anual (S/)</label>
                                <input type="number" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Monto Total (S/) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Fecha de Vigencia</label>
                                <input type="date" class="form-control">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Observaciones</label>
                                <textarea class="form-control" rows="3"></textarea>
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        $(document).ready(function() {
            $('#tablaCotizaciones').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
                },
                order: [
                    [0, 'desc']
                ]
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\CESHER\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/PRINCIPAL/crm/cotizaciones/index.blade.php ENDPATH**/ ?>