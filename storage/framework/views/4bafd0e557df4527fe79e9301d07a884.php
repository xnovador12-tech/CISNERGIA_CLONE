
<?php $__env->startSection('title', 'TICKETS DE SOPORTE'); ?>

<?php $__env->startSection('css'); ?>
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">TICKETS DE SOPORTE</h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(route('admin-dashboard.index')); ?>">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Tickets</li>
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
                        <div class="d-flex justify-content-between"><div><p class="text-muted mb-1 small">Tickets Abiertos</p><h3 class="mb-0 fw-bold text-danger"><?php echo e($stats['abiertos'] ?? 0); ?></h3></div><div class="bg-danger bg-opacity-10 p-3 rounded-3"><i class="bi bi-ticket-detailed fs-3 text-danger"></i></div></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between"><div><p class="text-muted mb-1 small">En Progreso</p><h3 class="mb-0 fw-bold text-warning"><?php echo e($stats['en_progreso'] ?? 0); ?></h3></div><div class="bg-warning bg-opacity-10 p-3 rounded-3"><i class="bi bi-clock-history fs-3 text-warning"></i></div></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between"><div><p class="text-muted mb-1 small">Resueltos Hoy</p><h3 class="mb-0 fw-bold text-success"><?php echo e($stats['resueltos_hoy'] ?? 0); ?></h3></div><div class="bg-success bg-opacity-10 p-3 rounded-3"><i class="bi bi-check-circle fs-3 text-success"></i></div></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between"><div><p class="text-muted mb-1 small">Tiempo Promedio</p><h3 class="mb-0 fw-bold text-info"><?php echo e($stats['tiempo_promedio'] ?? '0h'); ?></h3></div><div class="bg-info bg-opacity-10 p-3 rounded-3"><i class="bi bi-speedometer2 fs-3 text-info"></i></div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="container-fluid mb-3"><div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i><?php echo e(session('success')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div></div>
    <?php endif; ?>

    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up">
            <div class="card-header bg-transparent d-flex justify-content-between">
                <a href="<?php echo e(route('admin.crm.tickets.create')); ?>" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle-fill me-2"></i>Nuevo Ticket</a>
                <a href="<?php echo e(route('admin.crm.tickets.metricas')); ?>" class="btn btn-outline-info btn-sm"><i class="bi bi-graph-up me-2"></i>Métricas SLA</a>
            </div>
            <div class="card-body">
                
                <div class="row g-2 mb-3">
                    <div class="col-md-3">
                        <select id="filtro-estado" class="form-select form-select-sm">
                            <option value="">Todos los Estados</option>
                            <option value="Abierto">Abierto</option>
                            <option value="En progreso">En Progreso</option>
                            <option value="Pendiente cliente">Pendiente Cliente</option>
                            <option value="Resuelto">Resuelto</option>
                            <option value="Cerrado">Cerrado</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="filtro-prioridad" class="form-select form-select-sm">
                            <option value="">Todas las Prioridades</option>
                            <option value="Baja">Baja</option>
                            <option value="Media">Media</option>
                            <option value="Alta">Alta</option>
                            <option value="Critica">Crítica</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="filtro-categoria" class="form-select form-select-sm">
                            <option value="">Todas las Categorías</option>
                            <option value="Soporte">Soporte</option>
                            <option value="Instalacion">Instalación</option>
                            <option value="Mantenimiento">Mantenimiento</option>
                            <option value="Facturacion">Facturación</option>
                            <option value="Garantia">Garantía</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="filtro-sla" class="form-select form-select-sm">
                            <option value="">Todos los SLA</option>
                            <option value="OK">OK</option>
                            <option value="Vencido">Vencido</option>
                        </select>
                    </div>
                </div>
                
                <div class="mb-2 col-12 col-md-6">
                    <span class="text-uppercase">Total de registros: <span class="fw-bold"><?php echo e($tickets->count()); ?></span></span>
                </div>
                <table id="tablaTickets" class="table table-hover align-middle" style="width:100%">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th class="text-center">N°</th>
                            <th class="text-center">Ticket</th>
                            <th class="text-center">Cliente</th>
                            <th class="text-center">Asunto</th>
                            <th class="text-center">Categoría</th>
                            <th class="text-center">Prioridad</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">SLA</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="text-center"><?php echo e($i + 1); ?></td>
                                    <td class="text-center"><span class="badge bg-secondary"><?php echo e($ticket->codigo); ?></span><br><small class="text-muted"><?php echo e($ticket->created_at->format('d/m/Y H:i')); ?></small></td>
                                    <td class="text-center"><?php echo e($ticket->cliente->nombre ?? 'N/A'); ?></td>
                                    <td class="text-start"><strong><?php echo e(Str::limit($ticket->asunto, 40)); ?></strong></td>
                                    <td class="text-center"><span class="badge bg-light text-dark"><?php echo e(ucfirst($ticket->categoria)); ?></span></td>
                                    <td class="text-center">
                                        <?php $prioridadColors = ['baja' => 'success', 'media' => 'warning', 'alta' => 'danger', 'critica' => 'dark']; ?>
                                        <span class="badge bg-<?php echo e($prioridadColors[$ticket->prioridad] ?? 'secondary'); ?>"><?php echo e(ucfirst($ticket->prioridad)); ?></span>
                                    </td>
                                    <td class="text-center">
                                        <?php $estadoColors = ['abierto' => 'danger', 'en_progreso' => 'warning', 'pendiente_cliente' => 'info', 'resuelto' => 'success', 'cerrado' => 'secondary']; ?>
                                        <span class="badge bg-<?php echo e($estadoColors[$ticket->estado] ?? 'secondary'); ?>"><?php echo e(str_replace('_', ' ', ucfirst($ticket->estado))); ?></span>
                                    </td>
                                    <td class="text-center">
                                        <?php if($ticket->esta_vencido): ?>
                                            <span class="badge bg-danger"><i class="bi bi-exclamation-triangle"></i> Vencido</span>
                                        <?php elseif($ticket->sla_vencimiento && $ticket->sla_vencimiento->diffInHours(now()) <= 2): ?>
                                            <span class="badge bg-warning text-dark"><i class="bi bi-clock"></i> <?php echo e($ticket->tiempo_restante_sla); ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-success"><i class="bi bi-check"></i> OK</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center align-middle">
                                        <div class="dropstart">
                                            <button class="btn btn-sm btn-light rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 36px; height: 36px; padding: 0;"><i class="bi bi-three-dots-vertical"></i></button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                                <li><a class="dropdown-item" href="<?php echo e(route('admin.crm.tickets.show', $ticket)); ?>"><i class="bi bi-eye text-info me-2"></i>Ver/Responder</a></li>
                                                <li><a class="dropdown-item" href="<?php echo e(route('admin.crm.tickets.edit', $ticket)); ?>"><i class="bi bi-pencil text-secondary me-2"></i>Editar</a></li>
                                                <?php if(!in_array($ticket->estado, ['resuelto', 'cerrado'])): ?>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><form action="<?php echo e(route('admin.crm.tickets.cambiar-estado', $ticket)); ?>" method="POST"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?><input type="hidden" name="estado" value="resuelto"><button class="dropdown-item text-success"><i class="bi bi-check-circle me-2"></i>Resolver</button></form></li>
                                                    <li><form action="<?php echo e(route('admin.crm.tickets.escalar', $ticket)); ?>" method="POST"><?php echo csrf_field(); ?><button class="dropdown-item text-danger"><i class="bi bi-arrow-up-circle me-2"></i>Escalar</button></form></li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="9" class="text-center py-4 text-muted"><i class="bi bi-inbox fs-1 d-block mb-2"></i>No hay tickets</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
$(document).ready(function() {
    // Inicializar DataTable con filtros del lado del cliente
    var table = $('#tablaTickets').DataTable({
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
        order: [[0, 'asc']],
        columnDefs: [
            { orderable: false, targets: [8] } // Desactivar orden en columna de acciones
        ],
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row align-items-center"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7 d-flex justify-content-end"p>>'
    });

    // Filtro por Estado (columna 6)
    $('#filtro-estado').on('change', function() {
        var val = $(this).val();
        table.column(6).search(val).draw();
    });

    // Filtro por Prioridad (columna 5)
    $('#filtro-prioridad').on('change', function() {
        var val = $(this).val();
        table.column(5).search(val).draw();
    });

    // Filtro por Categoría (columna 4)
    $('#filtro-categoria').on('change', function() {
        var val = $(this).val();
        table.column(4).search(val).draw();
    });

    // Filtro por SLA (columna 7)
    $('#filtro-sla').on('change', function() {
        var val = $(this).val();
        table.column(7).search(val).draw();
    });
});

// SweetAlert para eliminar
$('.form-delete').submit(function(e) {
    e.preventDefault();
    const form = this;

    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1C3146',
        cancelButtonColor: '#FF9C00',
        confirmButtonText: '¡Sí, eliminar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/PRINCIPAL/crm/tickets/index.blade.php ENDPATH**/ ?>