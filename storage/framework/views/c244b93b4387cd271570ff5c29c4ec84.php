<?php $__env->startSection('title', 'OPORTUNIDADES'); ?>

<?php $__env->startSection('css'); ?>
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">OPORTUNIDADES</h1>
                <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(route('admin-dashboard.index')); ?>">Principal</a></li>
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
                                <h3 class="mb-0 fw-bold text-primary">S/ <?php echo e(number_format($estadisticas['valor_pipeline'] ?? 0, 0)); ?></h3>
                            </div>
                            <div class="bg-primary bg-opacity-10 p-3 rounded-3"><i class="bi bi-cash-stack fs-3 text-primary"></i></div>
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
                                <h3 class="mb-0 fw-bold"><?php echo e($estadisticas['activas'] ?? 0); ?></h3>
                            </div>
                            <div class="bg-info bg-opacity-10 p-3 rounded-3"><i class="bi bi-diagram-3 fs-3 text-info"></i></div>
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
                                <h3 class="mb-0 fw-bold text-success"><?php echo e($estadisticas['tasa_conversion'] ?? 0); ?>%</h3>
                            </div>
                            <div class="bg-success bg-opacity-10 p-3 rounded-3"><i class="bi bi-graph-up-arrow fs-3 text-success"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 small">Ganado este Mes</p>
                                <h3 class="mb-0 fw-bold text-warning">S/ <?php echo e(number_format($estadisticas['valor_ganado_mes'] ?? 0, 0)); ?></h3>
                            </div>
                            <div class="bg-warning bg-opacity-10 p-3 rounded-3"><i class="bi bi-trophy fs-3 text-warning"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

    
    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px; min-height: 500px" data-aos="fade-up">
            <div class="card-header bg-transparent">
                <div class="row justify-content-between align-items-center">
                    <div class="col-12 col-md-6 mb-2 mb-md-0 d-flex gap-2">
                        <a href="<?php echo e(route('admin.crm.oportunidades.create')); ?>" class="btn btn-primary text-uppercase text-white btn-sm">
                            <i class="bi bi-plus-circle-fill me-2"></i>Nueva Oportunidad
                        </a>
                
                    </div>
                </div>
            </div>
            <div class="card-body">
                
                <div class="row g-2 mb-3 align-items-end flex-nowrap">
                    <div class="col">
                        <label for="filtro-etapa" class="form-label small text-muted mb-1">Etapa</label>
                        <select id="filtro-etapa" class="form-select form-select-sm select2_bootstrap_2 w-100" data-placeholder="Todas las Etapas">
                            <option value="">Todas las Etapas</option>
                            <option value="Calificación">Calificación</option>
                            <option value="Evaluación">Evaluación</option>
                            <option value="Cotización">Cotización</option>
                            <option value="Negociación">Negociación</option>
                            <option value="Ganada">Ganada</option>
                            <option value="Perdida">Perdida</option>
                        </select>
                    </div>
                    <div class="col">
                        <label for="filtro-tipo" class="form-label small text-muted mb-1">Tipo Proyecto</label>
                        <select id="filtro-tipo" class="form-select form-select-sm select2_bootstrap_2 w-100" data-placeholder="Todos los Proyectos">
                            <option value="">Todos los Proyectos</option>
                            <option value="Residencial">Residencial</option>
                            <option value="Comercial">Comercial</option>
                            <option value="Industrial">Industrial</option>
                            <option value="Agrícola">Agrícola</option>
                        </select>
                    </div>
                    <div class="col">
                        <label for="filtro-tipo-oportunidad" class="form-label small text-muted mb-1">Tipo Oportunidad</label>
                        <select id="filtro-tipo-oportunidad" class="form-select form-select-sm select2_bootstrap_2 w-100" data-placeholder="Producto / Servicio">
                            <option value="">Producto / Servicio</option>
                            <option value="Producto">Producto</option>
                            <option value="Servicio">Servicio</option>
                            <option value="Mixto">Mixto</option>
                        </select>
                    </div>
                    <?php if($esAdmin): ?>
                    <div class="col">
                        <label class="form-label small text-muted mb-1">Vendedor</label>
                        <select id="filtro-vendedor" class="form-select form-select-sm select2_bootstrap_2 w-100" data-placeholder="Todos los Vendedores">
                            <option value="">Todos los Vendedores</option>
                            <?php $__currentLoopData = $vendedores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendedor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e(trim(($vendedor->persona?->name ?? $vendedor->email) . ' ' . ($vendedor->persona?->surnames ?? ''))); ?>">
                                    <?php echo e($vendedor->persona?->name ?? $vendedor->email); ?> <?php echo e($vendedor->persona?->surnames ?? ''); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <?php endif; ?>
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
                    <span class="text-uppercase">Total de registros: <span class="fw-bold"><?php echo e($oportunidades->count()); ?></span></span>
                </div>
                <table id="tablaOportunidades" class="table table-hover align-middle" style="width:100%">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th class="text-center">N°</th>
                            <th class="text-center">Código</th>
                            <th class="text-center">Nombre</th>
                            <th class="text-center">Cliente/Prospecto</th>
                            <th class="text-center">Tipo</th>
                            <th class="text-center">Valor</th>
                            <th class="text-center">Etapa</th>
                            <th class="text-center">Probabilidad</th>
                            <?php if($esAdmin): ?>
                            <th class="text-center">Vendedor</th>
                            <?php endif; ?>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <?php
                        $tipoOpoColors = ['producto' => 'success', 'servicio' => 'warning text-dark', 'mixto' => 'info'];
                        $etapaColors   = [
                            'calificacion'    => 'primary',
                            'evaluacion'      => 'info',
                            'cotizacion' => 'warning text-dark',
                            'negociacion'     => 'secondary',
                            'ganada'          => 'success',
                            'perdida'         => 'danger',
                        ];
                    ?>
                    <tbody>
                        <?php $__currentLoopData = $oportunidades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $oportunidad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $vencida = !in_array($oportunidad->etapa, ['ganada', 'perdida'])
                                    && $oportunidad->fecha_cierre_estimada
                                    && $oportunidad->fecha_cierre_estimada->isPast();
                            ?>
                            <tr class="<?php echo e($vencida ? 'table-warning' : ''); ?>">
                                <td class="text-center"></td>
                                <td class="text-center">
                                    <span class="fw-semibold"><?php echo e($oportunidad->codigo); ?></span>
                                    <br><small class="text-muted"><?php echo e($oportunidad->created_at->format('d/m/Y')); ?></small>
                                    <?php if($vencida): ?>
                                        <br><span class="badge bg-danger" style="font-size:0.6rem;" title="Fecha de cierre vencida">
                                            <i class="bi bi-exclamation-triangle-fill me-1"></i>Vencida
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-start">
                                    <span class="fw-semibold"><?php echo e(Str::limit($oportunidad->nombre, 30)); ?></span>
                                    <?php if($oportunidad->tipo_proyecto): ?>
                                        <br><small class="text-muted"><?php echo e(ucfirst($oportunidad->tipo_proyecto)); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if($oportunidad->cliente): ?>
                                        <small class="text-dark fw-semibold"><?php echo e(Str::limit($oportunidad->cliente->nombre, 22)); ?></small>
                                    <?php elseif($oportunidad->prospecto): ?>
                                        <small class="text-dark fw-semibold"><?php echo e(Str::limit($oportunidad->prospecto->nombre_completo, 22)); ?></small>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-<?php echo e($tipoOpoColors[$oportunidad->tipo_oportunidad ?? 'producto'] ?? 'secondary'); ?>">
                                        <?php echo e(ucfirst($oportunidad->tipo_oportunidad ?? 'producto')); ?>

                                    </span>
                                </td>
                                <td class="text-center fw-bold">
                                    <?php if($oportunidad->monto_final): ?>
                                        <span class="text-success">S/ <?php echo e(number_format($oportunidad->monto_final, 0)); ?></span>
                                        <br><small class="text-muted fw-normal">est. S/ <?php echo e(number_format($oportunidad->monto_estimado, 0)); ?></small>
                                    <?php else: ?>
                                        <span class="text-primary">S/ <?php echo e(number_format($oportunidad->monto_estimado, 0)); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-<?php echo e($etapaColors[$oportunidad->etapa] ?? 'secondary'); ?>">
                                        <?php echo e(\App\Models\Oportunidad::ETAPAS[$oportunidad->etapa]['nombre'] ?? ucfirst($oportunidad->etapa)); ?>

                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                        <div class="progress" style="width: 50px; height: 6px;">
                                            <div class="progress-bar bg-<?php echo e($oportunidad->probabilidad >= 70 ? 'success' : ($oportunidad->probabilidad >= 40 ? 'warning' : 'danger')); ?>"
                                                 style="width: <?php echo e($oportunidad->probabilidad); ?>%"></div>
                                        </div>
                                        <small><?php echo e($oportunidad->probabilidad); ?>%</small>
                                    </div>
                                </td>
                                <?php if($esAdmin): ?>
                                <td class="text-center small">
                                    <?php echo e(trim(($oportunidad->vendedor?->persona?->name ?? $oportunidad->vendedor?->email ?? '—') . ' ' . ($oportunidad->vendedor?->persona?->surnames ?? ''))); ?>

                                </td>
                                <?php endif; ?>
                                <td class="text-center">
                                    <div class="dropstart">
                                        <button class="btn btn-sm btn-light rounded-circle shadow-sm" type="button"
                                            data-bs-toggle="dropdown" style="width: 36px; height: 36px; padding: 0;">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu shadow">
                                            <li><a class="dropdown-item" href="<?php echo e(route('admin.crm.oportunidades.show', $oportunidad)); ?>">
                                                <i class="bi bi-eye text-info me-2"></i>Ver Detalles</a></li>
                                            <li><a class="dropdown-item" href="<?php echo e(route('admin.crm.oportunidades.edit', ['oportunidad' => $oportunidad, 'redirect_to' => 'index'])); ?>">
                                                <i class="bi bi-pencil text-secondary me-2"></i>Editar</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="<?php echo e(route('admin.crm.oportunidades.destroy', $oportunidad)); ?>"
                                                      method="POST" class="form-delete d-inline"
                                                      data-nombre="<?php echo e($oportunidad->nombre); ?>">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
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
        // ==================== FILTRO OCULTAR CERRADAS (registrar ANTES de inicializar DataTable) ====================
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            if (settings.nTable.id !== 'tablaOportunidades') return true;
            if (!$('#ocultar-cerradas').is(':checked')) return true;
            // data[6] = texto de la columna Etapa
            var etapa = (data[6] || '').trim();
            return etapa !== 'Ganada' && etapa !== 'Perdida';
        });

        var table = $('#tablaOportunidades').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
                paginate: { first: '«', previous: '‹', next: '›', last: '»' },
                info: 'Mostrando página _PAGE_ de _PAGES_'
            },
            pageLength: 10,
            order: [[1, 'desc']],
            columnDefs: [
                { orderable: false, searchable: false, targets: <?php echo e($esAdmin ? '[0, 9]' : '[0, 8]'); ?> }
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

        // ==================== FILTROS POR COLUMNA ====================
        // Filtro por Etapa (columna 6)
        $('#filtro-etapa').on('change', function() { table.column(6).search($(this).val()).draw(); });
        // Filtro por Tipo Proyecto (columna 2 - subtexto en Nombre)
        $('#filtro-tipo').on('change', function() { table.column(2).search($(this).val()).draw(); });
        // Filtro por Tipo Oportunidad (columna 4)
        $('#filtro-tipo-oportunidad').on('change', function() { table.column(4).search($(this).val()).draw(); });

        <?php if($esAdmin): ?>
        $('#filtro-vendedor').on('change', function() { table.column(8).search($(this).val()).draw(); });
        <?php endif; ?>

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

        // Al cambiar el checkbox, redibujar la tabla
        $('#ocultar-cerradas').on('change', function() {
            table.draw();
        });

        // ==================== SWEETALERT: ELIMINAR ====================
        $(document).on('submit', '.form-delete', function(e) {
            e.preventDefault();
            var form = this;
            var nombre = $(this).data('nombre') || 'esta oportunidad';
            Swal.fire({
                title: '¿Eliminar oportunidad?',
                html: 'Se eliminará permanentemente <strong>' + nombre + '</strong>.<br><small class="text-muted">Esta acción no se puede deshacer.</small>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1C3146',
                cancelButtonColor: '#FF9C00',
                confirmButtonText: '<i class="bi bi-trash me-1"></i> Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then(function(result) {
                if (result.isConfirmed) { form.submit(); }
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/CRM/oportunidades/index.blade.php ENDPATH**/ ?>