<?php $__env->startSection('title', 'AGENDA'); ?>

<?php $__env->startSection('content'); ?>
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">AGENDA Y SEGUIMIENTO</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link"
                                href="<?php echo e(route('admin-dashboard.index')); ?>">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Agenda</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mb-4">
        <div class="row g-3" data-aos="fade-up">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body"><small class="text-muted">Actividades Hoy</small>
                        <h3 class="mb-0 fw-bold text-primary">12</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body"><small class="text-muted">Llamadas Pendientes</small>
                        <h3 class="mb-0 fw-bold text-warning">8</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body"><small class="text-muted">Reuniones</small>
                        <h3 class="mb-0 fw-bold text-info">5</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body"><small class="text-muted">Visitas Técnicas</small>
                        <h3 class="mb-0 fw-bold text-success">3</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm h-100" style="border-radius: 20px; min-height: 500px"
            data-aos="fade-up">
            <div class="card-header bg-transparent">
                <button type="button" data-bs-toggle="modal" data-bs-target="#createActividad"
                    class="btn btn-primary text-uppercase text-white btn-sm">
                    <i class="bi bi-plus-circle-fill me-2"></i>Nueva Actividad
                </button>
            </div>
            <div class="card-body">
                <table id="tablaActividades" class="table table-hover align-middle nowrap" cellspacing="0"
                    style="width:100%">
                    <thead class="bg-dark text-white border-0">
                        <tr>
                            <th class="h6 small text-center text-uppercase fw-bold">N°</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Tipo</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Título</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Cliente/Prospecto</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Fecha y Hora</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Asignado</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Estado</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $contador = 1; ?>
                        <tr>
                            <td class="fw-normal text-center align-middle"><?php echo e($contador); ?></td>
                            <td class="fw-normal text-center align-middle"><span class="badge bg-primary"><i
                                        class="bi bi-telephone me-1"></i>Llamada</span></td>
                            <td class="fw-normal text-start align-middle">Seguimiento Sistema Solar</td>
                            <td class="fw-normal text-center align-middle">Carlos Mendoza SAC</td>
                            <td class="fw-normal text-center align-middle"><small>11/01/2024<br>10:00 AM</small></td>
                            <td class="fw-normal text-center align-middle"><small>Juan Diego</small></td>
                            <td class="fw-normal text-center align-middle"><span class="badge bg-warning">Programada</span>
                            </td>
                            <td class="text-center align-middle">
                                <div class="dropstart">
                                    <button class="btn btn-sm btn-light rounded-circle shadow-sm" type="button"
                                        data-bs-toggle="dropdown" style="width: 36px; height: 36px; padding: 0;">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu shadow">
                                        <li><a class="dropdown-item" href="#"><i
                                                    class="bi bi-check-circle text-success me-2"></i>Marcar realizada</a>
                                        </li>
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

    <!-- Modal: Crear Actividad -->
    <div class="modal fade" id="createActividad" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Nueva Actividad</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form class="needs-validation" novalidate>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Tipo <span class="text-danger">*</span></label>
                                <select class="form-select" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="llamada">Llamada</option>
                                    <option value="reunion">Reunión</option>
                                    <option value="visita">Visita Técnica</option>
                                    <option value="email">Email</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Relacionado con</label>
                                <select class="form-select">
                                    <option value="">Seleccionar...</option>
                                    <option>Prospecto - Carlos Mendoza SAC</option>
                                    <option>Cliente - Ana García Torres</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Título <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Fecha <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Hora <span class="text-danger">*</span></label>
                                <input type="time" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Duración (minutos)</label>
                                <input type="number" class="form-control" value="30">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Asignado a</label>
                                <select class="form-select">
                                    <option>Juan Diego</option>
                                    <option>María López</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Descripción</label>
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
            $('#tablaActividades').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\CESHER\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/PRINCIPAL/crm/agenda/index.blade.php ENDPATH**/ ?>