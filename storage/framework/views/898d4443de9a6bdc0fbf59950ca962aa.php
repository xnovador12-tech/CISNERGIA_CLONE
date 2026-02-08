<?php $__env->startSection('title', 'OPORTUNIDADES'); ?>

<?php $__env->startSection('css'); ?>
    <style>
        .kanban-stage {
            min-width: 280px;
            max-width: 280px;
        }

        .opportunity-card {
            cursor: pointer;
            transition: all 0.2s;
        }

        .opportunity-card:hover {
            transform: translateY(-2px);
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">OPORTUNIDADES</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link"
                                href="<?php echo e(route('admin-dashboard.index')); ?>">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Oportunidades</li>
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
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 small">Valor Pipeline</p>
                                <h3 class="mb-0 fw-bold text-primary">S/ 2.4M</h3>
                            </div>
                            <div class="bg-primary bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-cash-stack fs-3 text-primary"></i>
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
                                <p class="text-muted mb-1 small">Oportunidades Activas</p>
                                <h3 class="mb-0 fw-bold">47</h3>
                            </div>
                            <div class="bg-info bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-diagram-3 fs-3 text-info"></i>
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
                                <p class="text-muted mb-1 small">Tasa Conversión</p>
                                <h3 class="mb-0 fw-bold text-success">34%</h3>
                            </div>
                            <div class="bg-success bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-graph-up-arrow fs-3 text-success"></i>
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
                                <p class="text-muted mb-1 small">Ciclo Promedio</p>
                                <h3 class="mb-0 fw-bold text-warning">24 días</h3>
                            </div>
                            <div class="bg-warning bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-clock-history fs-3 text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="container-fluid mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <div></div>
            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-outline-primary active" id="btnKanban">
                    <i class="bi bi-kanban me-1"></i> Vista Pipeline
                </button>
                <button class="btn btn-sm btn-outline-primary" id="btnTabla">
                    <i class="bi bi-table me-1"></i> Vista Tabla
                </button>
            </div>
        </div>
    </div>

    
    <div class="container-fluid" id="vistaKanban">
        <div class="overflow-auto pb-3">
            <div class="d-flex gap-3" style="min-width: max-content;">
                
                <div class="kanban-stage">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0 fw-bold"><i class="bi bi-funnel me-2"></i>Calificación</h6>
                            <small>12 oportunidades | S/ 420K</small>
                        </div>
                        <div class="card-body p-2" style="max-height: 600px; overflow-y: auto;">
                            <div class="card opportunity-card border-start border-primary border-4 mb-2">
                                <div class="card-body p-3">
                                    <h6 class="fw-bold mb-2">Sistema Residencial 5kW</h6>
                                    <p class="text-muted small mb-2">Carlos Mendoza SAC</p>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="fw-bold text-primary">S/ 45,000</span>
                                        <span class="badge bg-success small">85%</span>
                                    </div>
                                    <div class="progress mb-2" style="height: 4px;">
                                        <div class="progress-bar bg-success" style="width: 85%"></div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center small text-muted">
                                        <span><i class="bi bi-person me-1"></i>Juan D.</span>
                                        <span><i class="bi bi-calendar3 me-1"></i>5 días</span>
                                    </div>
                                </div>
                            </div>

                            <div class="card opportunity-card border-start border-primary border-4 mb-2">
                                <div class="card-body p-3">
                                    <h6 class="fw-bold mb-2">Comercial 15kW</h6>
                                    <p class="text-muted small mb-2">Ana García Torres</p>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="fw-bold text-primary">S/ 120,000</span>
                                        <span class="badge bg-warning text-dark small">60%</span>
                                    </div>
                                    <div class="progress mb-2" style="height: 4px;">
                                        <div class="progress-bar bg-warning" style="width: 60%"></div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center small text-muted">
                                        <span><i class="bi bi-person me-1"></i>María L.</span>
                                        <span><i class="bi bi-calendar3 me-1"></i>3 días</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="kanban-stage">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0 fw-bold"><i class="bi bi-file-text me-2"></i>Propuesta Técnica</h6>
                            <small>8 oportunidades | S/ 580K</small>
                        </div>
                        <div class="card-body p-2" style="max-height: 600px; overflow-y: auto;">
                            <div class="card opportunity-card border-start border-info border-4 mb-2">
                                <div class="card-body p-3">
                                    <h6 class="fw-bold mb-2">Granja Solar 50kW</h6>
                                    <p class="text-muted small mb-2">Agroindustrias del Sur</p>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="fw-bold text-primary">S/ 280,000</span>
                                        <span class="badge bg-success small">75%</span>
                                    </div>
                                    <div class="progress mb-2" style="height: 4px;">
                                        <div class="progress-bar bg-success" style="width: 75%"></div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center small text-muted">
                                        <span><i class="bi bi-person me-1"></i>Juan D.</span>
                                        <span><i class="bi bi-calendar3 me-1"></i>12 días</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="kanban-stage">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-warning text-dark">
                            <h6 class="mb-0 fw-bold"><i class="bi bi-calculator me-2"></i>Cotización</h6>
                            <small>15 oportunidades | S/ 820K</small>
                        </div>
                        <div class="card-body p-2" style="max-height: 600px; overflow-y: auto;">
                            <div class="card opportunity-card border-start border-warning border-4 mb-2">
                                <div class="card-body p-3">
                                    <h6 class="fw-bold mb-2">Edificio Comercial 30kW</h6>
                                    <p class="text-muted small mb-2">Inversiones Plaza SAC</p>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="fw-bold text-primary">S/ 180,000</span>
                                        <span class="badge bg-success small">90%</span>
                                    </div>
                                    <div class="progress mb-2" style="height: 4px;">
                                        <div class="progress-bar bg-success" style="width: 90%"></div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center small text-muted">
                                        <span><i class="bi bi-person me-1"></i>María L.</span>
                                        <span><i class="bi bi-calendar3 me-1"></i>18 días</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="kanban-stage">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0 fw-bold"><i class="bi bi-hand-thumbs-up me-2"></i>Negociación</h6>
                            <small>6 oportunidades | S/ 350K</small>
                        </div>
                        <div class="card-body p-2" style="max-height: 600px; overflow-y: auto;">
                            <div class="card opportunity-card border-start border-success border-4 mb-2">
                                <div class="card-body p-3">
                                    <h6 class="fw-bold mb-2">Minimarket 8kW</h6>
                                    <p class="text-muted small mb-2">Bodega Don Pepe</p>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="fw-bold text-primary">S/ 65,000</span>
                                        <span class="badge bg-success small">95%</span>
                                    </div>
                                    <div class="progress mb-2" style="height: 4px;">
                                        <div class="progress-bar bg-success" style="width: 95%"></div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center small text-muted">
                                        <span><i class="bi bi-person me-1"></i>Juan D.</span>
                                        <span><i class="bi bi-calendar3 me-1"></i>25 días</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="kanban-stage">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-secondary text-white">
                            <h6 class="mb-0 fw-bold"><i class="bi bi-check-circle me-2"></i>Cierre</h6>
                            <small>6 oportunidades | S/ 280K</small>
                        </div>
                        <div class="card-body p-2" style="max-height: 600px; overflow-y: auto;">
                            <div class="card opportunity-card border-start border-secondary border-4 mb-2">
                                <div class="card-body p-3">
                                    <h6 class="fw-bold mb-2">Casa Unifamiliar 4kW</h6>
                                    <p class="text-muted small mb-2">Familia Rodríguez</p>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="fw-bold text-primary">S/ 35,000</span>
                                        <span class="badge bg-success small">100%</span>
                                    </div>
                                    <div class="progress mb-2" style="height: 4px;">
                                        <div class="progress-bar bg-success" style="width: 100%"></div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center small text-muted">
                                        <span><i class="bi bi-person me-1"></i>María L.</span>
                                        <span><i class="bi bi-calendar3 me-1"></i>30 días</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="container-fluid d-none" id="vistaTabla">
        <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px;" data-aos="fade-up">
            <div class="card-header bg-transparent">
                <button type="button" data-bs-toggle="modal" data-bs-target="#createOportunidad"
                    class="btn btn-primary text-uppercase text-white btn-sm">
                    <i class="bi bi-plus-circle-fill me-2"></i>
                    Nueva Oportunidad
                </button>
            </div>
            <div class="card-body">
                <table id="tablaOportunidades" class="table table-hover align-middle nowrap" cellspacing="0"
                    style="width:100%">
                    <thead class="bg-dark text-white border-0">
                        <tr>
                            <th class="h6 small text-center text-uppercase fw-bold">N°</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Oportunidad</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Cliente</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Etapa</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Probabilidad</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Monto</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Asignado</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $contador = 1; ?>
                        <tr>
                            <td class="fw-normal text-center align-middle"><?php echo e($contador); ?></td>
                            <td class="fw-normal text-start align-middle">
                                <strong>Sistema Residencial 5kW</strong><br>
                                <small class="text-muted">5 días en etapa</small>
                            </td>
                            <td class="fw-normal text-center align-middle">Carlos Mendoza SAC</td>
                            <td class="fw-normal text-center align-middle">
                                <span class="badge bg-primary">Calificación</span>
                            </td>
                            <td class="fw-normal text-center align-middle">
                                <span class="badge bg-success">85%</span>
                            </td>
                            <td class="fw-normal text-center align-middle fw-bold text-primary">S/ 45,000</td>
                            <td class="fw-normal text-center align-middle"><small>Juan Diego</small></td>
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
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item text-danger" href="#"><i
                                                    class="bi bi-trash me-2"></i>Eliminar</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal: Crear Oportunidad -->
    <div class="modal fade" id="createOportunidad" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Nueva Oportunidad</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="#" method="POST" class="needs-validation" novalidate>
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <h6 class="text-primary border-bottom pb-2 mb-3"><i
                                        class="bi bi-info-circle me-2"></i>Información General</h6>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Cliente / Prospecto <span class="text-danger">*</span></label>
                                <select class="form-select select2" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="1">Carlos Mendoza SAC</option>
                                    <option value="2">Ana García Torres</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nombre Oportunidad <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Ej: Sistema Solar 5kW" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tipo Solución <span class="text-danger">*</span></label>
                                <select class="form-select" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="residencial">Residencial</option>
                                    <option value="comercial">Comercial</option>
                                    <option value="industrial">Industrial</option>
                                    <option value="agricola">Agrícola</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Potencia Estimada (kW)</label>
                                <input type="number" class="form-control" placeholder="5.5" step="0.1">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Monto Estimado (S/) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" placeholder="45000" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Probabilidad Cierre</label>
                                <select class="form-select">
                                    <option value="25">25% - Baja</option>
                                    <option value="50">50% - Media</option>
                                    <option value="75" selected>75% - Alta</option>
                                    <option value="90">90% - Muy Alta</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Etapa Inicial</label>
                                <select class="form-select">
                                    <option value="calificacion" selected>Calificación</option>
                                    <option value="propuesta">Propuesta Técnica</option>
                                    <option value="cotizacion">Cotización</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Fecha Cierre Estimada</label>
                                <input type="date" class="form-control">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Descripción</label>
                                <textarea class="form-control" rows="3" placeholder="Detalles..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Crear
                            Oportunidad</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        $(document).ready(function() {
            // Toggle entre vistas
            $('#btnKanban').click(function() {
                $('#vistaKanban').removeClass('d-none');
                $('#vistaTabla').addClass('d-none');
                $(this).addClass('active');
                $('#btnTabla').removeClass('active');
            });

            $('#btnTabla').click(function() {
                $('#vistaTabla').removeClass('d-none');
                $('#vistaKanban').addClass('d-none');
                $(this).addClass('active');
                $('#btnKanban').removeClass('active');

                // Inicializar DataTable cuando se muestra
                if (!$.fn.DataTable.isDataTable('#tablaOportunidades')) {
                    $('#tablaOportunidades').DataTable({
                        responsive: true,
                        language: {
                            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
                        },
                        pageLength: 10
                    });
                }
            });

            // Select2
            $('.select2').select2({
                theme: 'bootstrap-5',
                width: '100%',
                dropdownParent: $('#createOportunidad')
            });
        });

        // Validación
        (function() {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\CESHER\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/PRINCIPAL/crm/oportunidades/index.blade.php ENDPATH**/ ?>