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
                        <div class="d-flex justify-content-between"><div><p class="text-muted mb-1 small">Tickets Activos</p><h3 class="mb-0 fw-bold text-danger"><?php echo e($stats['abiertos'] ?? 0); ?></h3></div><div class="bg-danger bg-opacity-10 p-3 rounded-3"><i class="bi bi-ticket-detailed fs-3 text-danger"></i></div></div>
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
                        <div class="d-flex justify-content-between"><div><p class="text-muted mb-1 small">Primera Respuesta Prom.</p><h3 class="mb-0 fw-bold text-info"><?php echo e($stats['tiempo_promedio'] ?? '0h'); ?></h3></div><div class="bg-info bg-opacity-10 p-3 rounded-3"><i class="bi bi-speedometer2 fs-3 text-info"></i></div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up">
            <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <a href="<?php echo e(route('admin.crm.tickets.create')); ?>" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle-fill me-2"></i>Nuevo Ticket
                </a>
                <?php $verResueltos = request()->filled('incluir_resueltos'); ?>
                <a href="<?php echo e($verResueltos ? route('admin.crm.tickets.index') : route('admin.crm.tickets.index', ['incluir_resueltos' => 1])); ?>"
                   class="btn btn-sm <?php echo e($verResueltos ? 'btn-success' : 'btn-outline-secondary'); ?>">
                    <i class="bi bi-<?php echo e($verResueltos ? 'eye-slash' : 'archive'); ?> me-1"></i>
                    <?php echo e($verResueltos ? 'Ocultar Resueltos' : 'Ver Historial Resueltos'); ?>

                </a>
            </div>
            <div class="card-body">
                
                <div class="row g-2 mb-3 align-items-end flex-nowrap">
                    <div class="col">
                        <label class="form-label small text-muted mb-1">Estado</label>
                        <select id="filtro-estado" class="form-select form-select-sm select2_bootstrap_2 w-100" data-placeholder="Todos los Estados">
                            <option value="">Todos los Estados</option>
                            <option value="Abierto">Abierto</option>
                            <option value="En progreso">En Progreso</option>
                            <option value="Pendiente cliente">Pendiente Cliente</option>
                            <option value="Resuelto">Resuelto</option>
                            <option value="Reabierto">Reabierto</option>
                        </select>
                    </div>
                    <div class="col">
                        <label class="form-label small text-muted mb-1">Prioridad</label>
                        <select id="filtro-prioridad" class="form-select form-select-sm select2_bootstrap_2 w-100" data-placeholder="Todas las Prioridades">
                            <option value="">Todas las Prioridades</option>
                            <option value="Baja">Baja</option>
                            <option value="Media">Media</option>
                            <option value="Alta">Alta</option>
                            <option value="Critica">Crítica</option>
                        </select>
                    </div>
                    <div class="col">
                        <label class="form-label small text-muted mb-1">Categoría</label>
                        <select id="filtro-categoria" class="form-select form-select-sm select2_bootstrap_2 w-100" data-placeholder="Todas las Categorías">
                            <option value="">Todas las Categorías</option>
                            <option value="Mantenimiento">🔩 Mantenimiento</option>
                            <option value="Soporte Técnico">🔧 Soporte Técnico</option>
                            <option value="Garantía">🛡️ Garantía</option>
                            <option value="Facturación">💰 Facturación / Cobranza</option>
                            <option value="Consulta">❓ Consulta / Reclamo</option>
                        </select>
                    </div>
                    <div class="col">
                        <label class="form-label small text-muted mb-1">SLA</label>
                        <select id="filtro-sla" class="form-select form-select-sm select2_bootstrap_2 w-100" data-placeholder="Todos los SLA">
                            <option value="">Todos los SLA</option>
                            <option value="Dentro">Dentro del SLA</option>
                            <option value="Vencido">Vencido</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <label class="form-label small text-muted mb-1 d-block invisible">.</label>
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
                            <?php
                            $prioridadColors = ['baja' => 'success', 'media' => 'warning text-dark', 'alta' => 'danger', 'critica' => 'dark'];
                            $estadoColors    = ['abierto' => 'danger', 'en_progreso' => 'warning text-dark', 'pendiente_cliente' => 'info', 'resuelto' => 'success'];
                        ?>
                        <?php $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="text-center"><?php echo e($i + 1); ?></td>
                                    <td class="text-center">
                                        <span class="fw-semibold"><?php echo e($ticket->codigo); ?></span>
                                        <br><small class="text-muted"><?php echo e($ticket->created_at->format('d/m/Y')); ?></small>
                                    </td>
                                    <td class="text-center"><small><?php echo e($ticket->cliente->nombre ?? 'N/A'); ?></small></td>
                                    <td class="text-start">
                                        <span class="fw-semibold"><?php echo e(Str::limit($ticket->asunto, 40)); ?></span>
                                        <div class="d-flex gap-1 mt-1 flex-wrap">
                                            <?php if($ticket->pedido_id): ?>
                                                <span class="badge bg-light text-secondary border" style="font-size:10px">
                                                    <i class="bi bi-receipt me-1"></i><?php echo e($ticket->pedido->codigo ?? 'Pedido'); ?>

                                                </span>
                                            <?php endif; ?>
                                            <?php if($ticket->adjuntos && count($ticket->adjuntos) > 0): ?>
                                                <span class="badge bg-light text-secondary border" style="font-size:10px"
                                                      title="<?php echo e(count($ticket->adjuntos)); ?> adjunto(s)" data-bs-toggle="tooltip">
                                                    <i class="bi bi-paperclip"></i> <?php echo e(count($ticket->adjuntos)); ?>

                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <small class="text-muted"><?php echo e($ticket->categoria_label); ?></small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-<?php echo e($prioridadColors[$ticket->prioridad] ?? 'secondary'); ?>"><?php echo e(ucfirst($ticket->prioridad)); ?></span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-<?php echo e($estadoColors[$ticket->estado] ?? 'secondary'); ?>"><?php echo e(str_replace('_', ' ', ucfirst($ticket->estado))); ?></span>
                                    </td>
                                    <td class="text-center">
                                        <?php if($ticket->esta_vencido): ?>
                                            <span class="badge bg-danger"><i class="bi bi-exclamation-triangle-fill me-1"></i>Vencido</span>
                                        <?php elseif($ticket->sla_vencimiento && $ticket->sla_vencimiento->diffInHours(now()) <= 2): ?>
                                            <span class="badge bg-warning text-dark"><i class="bi bi-clock me-1"></i><?php echo e($ticket->tiempo_restante_sla); ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-success bg-opacity-10 text-success"><i class="bi bi-check-circle-fill me-1"></i>Dentro del SLA</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center align-middle">
                                        <div class="dropstart">
                                            <button class="btn btn-sm btn-light rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 36px; height: 36px; padding: 0;"><i class="bi bi-three-dots-vertical"></i></button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                                <li><a class="dropdown-item" href="<?php echo e(route('admin.crm.tickets.show', $ticket)); ?>"><i class="bi bi-eye text-info me-2"></i>Ver/Responder</a></li>
                                                <li><a class="dropdown-item" href="<?php echo e(route('admin.crm.tickets.edit', $ticket)); ?>"><i class="bi bi-pencil text-secondary me-2"></i>Editar</a></li>
                                                <?php if($ticket->estado !== 'resuelto'): ?>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <?php if(!$ticket->es_mantenimiento || ($ticket->mantenimiento && in_array($ticket->mantenimiento->estado, ['completado', 'cancelado']))): ?>
                                                        <li>
                                                            <form action="<?php echo e(route('admin.crm.tickets.cambiar-estado', $ticket)); ?>" method="POST" class="form-resolver">
                                                                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                                                <input type="hidden" name="estado" value="resuelto">
                                                                <button type="submit" class="dropdown-item text-success"><i class="bi bi-check-circle me-2"></i>Resolver</button>
                                                            </form>
                                                        </li>
                                                    <?php else: ?>
                                                        <li><span class="dropdown-item text-muted small disabled"><i class="bi bi-hourglass-split me-2"></i>Pendiente mantenimiento</span></li>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="<?php echo e(route('admin.crm.tickets.destroy', $ticket)); ?>" method="POST" class="form-delete">
                                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="dropdown-item text-danger"><i class="bi bi-trash me-2"></i>Eliminar</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
            emptyTable: '<div class="text-center py-4 text-muted"><i class="bi bi-inbox fs-1 d-block mb-2"></i>No hay tickets registrados</div>',
            paginate: {
                first: '«',
                previous: '‹',
                next: '›',
                last: '»'
            },
            info: 'Mostrando página _PAGE_ de _PAGES_'
        },
        pageLength: 10,
        order: [[1, 'desc']], // Más reciente primero
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

    // Limpiar filtros
    $('#btn-limpiar').on('click', function() {
        $('[id^="filtro-"]').each(function() {
            $(this).val('').trigger('change');
        });
        table.search('').columns().search('').draw();
    });

    // Inicializar tooltip del botón limpiar
    var tooltipEl = document.querySelector('#btn-limpiar');
    if (tooltipEl) { new bootstrap.Tooltip(tooltipEl); }
});

// SweetAlert para resolver con solución
$('.form-resolver').submit(function(e) {
    e.preventDefault();
    const form = this;

    Swal.fire({
        title: 'Resolver Ticket',
        width: 520,
        padding: '1.5rem',
        html: `
            <div class="text-start">
                <div class="mb-3">
                    <label class="form-label fw-bold small">Tipo de resolución</label>
                    <select id="swal-tipo-solucion" class="form-select form-select-sm">
                        <option value="">Seleccionar...</option>
                        <option value="resuelto_remoto">Resuelto de forma remota</option>
                        <option value="visita_tecnica">Visita técnica realizada</option>
                        <option value="cambio_equipo">Cambio / reemplazo de equipo</option>
                        <option value="ajuste_configuracion">Ajuste de configuración</option>
                        <option value="garantia_aplicada">Garantía aplicada</option>
                        <option value="derivado_proveedor">Derivado al proveedor</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold small">Descripción de la solución <span class="text-danger">*</span></label>
                    <textarea id="swal-solucion" class="form-control form-control-sm" rows="3" placeholder="Describe cómo se resolvió el ticket..."></textarea>
                </div>
                <div class="border rounded p-2 bg-light">
                    <div class="form-check mb-0">
                        <input class="form-check-input" type="checkbox" id="swal-seguimiento">
                        <label class="form-check-label fw-bold small" for="swal-seguimiento">
                            Requiere seguimiento
                        </label>
                    </div>
                    <div id="bloque-dias" style="display:none; margin-top:8px;">
                        <label class="form-label small mb-1">Verificar en (días)</label>
                        <input type="number" id="swal-dias" class="form-control form-control-sm" value="7" min="1" max="90" style="width:100px">
                        <small class="text-muted">Se creará una actividad de seguimiento para recordártelo.</small>
                    </div>
                </div>
            </div>`,
        icon: 'success',
        showCancelButton: true,
        confirmButtonColor: '#1C3146',
        cancelButtonColor: '#FF9C00',
        confirmButtonText: '<i class="bi bi-check-circle me-1"></i> Resolver',
        cancelButtonText: 'Cancelar',
        didOpen: () => {
            document.getElementById('swal-seguimiento').addEventListener('change', function() {
                document.getElementById('bloque-dias').style.display = this.checked ? 'block' : 'none';
            });
        },
        preConfirm: () => {
            const solucion = document.getElementById('swal-solucion').value;
            if (!solucion.trim()) {
                Swal.showValidationMessage('La descripción de la solución es requerida');
                return false;
            }
            return {
                solucion,
                tipoSolucion:        document.getElementById('swal-tipo-solucion').value,
                requiereSeguimiento: document.getElementById('swal-seguimiento').checked,
                diasSeguimiento:     document.getElementById('swal-dias').value,
            };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $('<input>').attr({ type: 'hidden', name: 'solucion',             value: result.value.solucion }).appendTo(form);
            $('<input>').attr({ type: 'hidden', name: 'tipo_solucion',        value: result.value.tipoSolucion }).appendTo(form);
            $('<input>').attr({ type: 'hidden', name: 'requiere_seguimiento', value: result.value.requiereSeguimiento ? '1' : '0' }).appendTo(form);
            $('<input>').attr({ type: 'hidden', name: 'dias_seguimiento',     value: result.value.diasSeguimiento }).appendTo(form);
            form.submit();
        }
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

<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/CRM/tickets/index.blade.php ENDPATH**/ ?>