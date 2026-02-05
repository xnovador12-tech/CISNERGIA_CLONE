
<?php $__env->startSection('title', 'GARANTÍAS'); ?>

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
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">GESTIÓN DE GARANTÍAS</h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(route('admin-dashboard.index')); ?>">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Garantías</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    
    <div class="container-fluid mb-4">
        <div class="row g-3" data-aos="fade-up">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100"><div class="card-body"><div class="d-flex justify-content-between"><div><p class="text-muted mb-1 small">Total Garantías</p><h3 class="mb-0 fw-bold text-primary"><?php echo e($stats['total'] ?? 0); ?></h3></div><div class="bg-primary bg-opacity-10 p-3 rounded-3"><i class="bi bi-shield-check fs-3 text-primary"></i></div></div></div></div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100"><div class="card-body"><div class="d-flex justify-content-between"><div><p class="text-muted mb-1 small">Vigentes</p><h3 class="mb-0 fw-bold text-success"><?php echo e($stats['vigentes'] ?? 0); ?></h3></div><div class="bg-success bg-opacity-10 p-3 rounded-3"><i class="bi bi-check-circle fs-3 text-success"></i></div></div></div></div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100"><div class="card-body"><div class="d-flex justify-content-between"><div><p class="text-muted mb-1 small">Por Vencer (30d)</p><h3 class="mb-0 fw-bold text-warning"><?php echo e($stats['por_vencer'] ?? 0); ?></h3></div><div class="bg-warning bg-opacity-10 p-3 rounded-3"><i class="bi bi-exclamation-triangle fs-3 text-warning"></i></div></div></div></div>
            </div>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="container-fluid mb-3"><div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i><?php echo e(session('success')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div></div>
    <?php endif; ?>

    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up">
            <div class="card-header bg-transparent d-flex justify-content-between">
                <a href="<?php echo e(route('admin.crm.garantias.create')); ?>" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle-fill me-2"></i>Nueva Garantía</a>
            </div>
            <div class="card-body">
                
                <div class="row g-2 mb-3">
                    <div class="col-md-3">
                        <select id="filtro-estado" class="form-select form-select-sm">
                            <option value="">Todos los Estados</option>
                            <option value="Vigente">Vigente</option>
                            <option value="Vencida">Vencida</option>
                            <option value="En reclamo">En Reclamo</option>
                            <option value="Anulada">Anulada</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="filtro-tipo" class="form-select form-select-sm">
                            <option value="">Todos los Tipos</option>
                            <option value="Paneles">Paneles</option>
                            <option value="Inversor">Inversor</option>
                            <option value="Baterias">Baterías</option>
                            <option value="Instalacion">Instalación</option>
                            <option value="Mano obra">Mano de Obra</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="filtro-vencimiento" class="form-select form-select-sm">
                            <option value="">Todos</option>
                            <option value="30d">Por vencer (30 días)</option>
                        </select>
                    </div>
                </div>
                
                <div class="mb-2 col-12 col-md-6">
                    <span class="text-uppercase">Total de registros: <span class="fw-bold"><?php echo e($garantias->count()); ?></span></span>
                </div>
                <table id="tablaGarantias" class="table table-hover align-middle" style="width:100%">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th class="text-center">N°</th>
                            <th class="text-center">Código</th>
                            <th class="text-center">Cliente</th>
                            <th class="text-center">Producto/Sistema</th>
                            <th class="text-center">Tipo</th>
                            <th class="text-center">Inicio</th>
                            <th class="text-center">Vencimiento</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $garantias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $garantia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="text-center"><?php echo e($i + 1); ?></td>
                                    <td class="text-center"><span class="badge bg-secondary"><?php echo e($garantia->codigo); ?></span></td>
                                    <td class="text-center"><?php echo e(Str::limit($garantia->cliente->nombre ?? 'N/A', 25)); ?></td>
                                    <td class="text-start"><strong><?php echo e(Str::limit($garantia->descripcion_sistema, 35)); ?></strong></td>
                                    <td class="text-center">
                                        <?php $tipoColors = ['paneles' => 'warning', 'inversor' => 'info', 'baterias' => 'success', 'instalacion' => 'primary', 'mano_obra' => 'secondary']; ?>
                                        <span class="badge bg-<?php echo e($tipoColors[$garantia->tipo] ?? 'secondary'); ?>"><?php echo e(ucfirst(str_replace('_', ' ', $garantia->tipo))); ?></span>
                                    </td>
                                    <td class="text-center"><small><?php echo e($garantia->fecha_inicio->format('d/m/Y')); ?></small></td>
                                    <td class="text-center">
                                        <small><?php echo e($garantia->fecha_fin->format('d/m/Y')); ?></small>
                                        <?php $diasRestantes = round(now()->diffInDays($garantia->fecha_fin, false)); ?>
                                        <?php if($diasRestantes <= 30 && $diasRestantes > 0): ?>
                                            <br><span class="badge bg-warning text-dark"><?php echo e($diasRestantes); ?>d</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php $estadoColors = ['vigente' => 'success', 'vencida' => 'danger', 'en_reclamo' => 'warning', 'anulada' => 'secondary']; ?>
                                        <span class="badge bg-<?php echo e($estadoColors[$garantia->estado] ?? 'secondary'); ?>"><?php echo e(ucfirst(str_replace('_', ' ', $garantia->estado))); ?></span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <div class="dropstart">
                                            <button class="btn btn-sm btn-light rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 36px; height: 36px; padding: 0;"><i class="bi bi-three-dots-vertical"></i></button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                                <li><a class="dropdown-item" href="<?php echo e(route('admin.crm.garantias.show', $garantia)); ?>"><i class="bi bi-eye text-info me-2"></i>Ver Detalles</a></li>
                                                <li><a class="dropdown-item" href="<?php echo e(route('admin.crm.garantias.edit', $garantia)); ?>"><i class="bi bi-pencil text-secondary me-2"></i>Editar</a></li>
                                                <?php if($garantia->estado === 'vigente'): ?>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-warning" href="#" data-bs-toggle="modal" data-bs-target="#modalUso-<?php echo e($garantia->id); ?>"><i class="bi bi-tools me-2"></i>Registrar Uso</a></li>
                                                    <li><a class="dropdown-item text-success" href="#" data-bs-toggle="modal" data-bs-target="#modalExtender-<?php echo e($garantia->id); ?>"><i class="bi bi-plus-circle me-2"></i>Extender</a></li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="9" class="text-center py-4 text-muted"><i class="bi bi-inbox fs-1 d-block mb-2"></i>No hay garantías</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
            </div>
        </div>
    </div>

    
    <?php $__currentLoopData = $garantias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $garantia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($garantia->estado === 'vigente'): ?>
            
            <div class="modal fade" id="modalUso-<?php echo e($garantia->id); ?>" tabindex="-1">
                <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="<?php echo e(route('admin.crm.garantias.uso', $garantia)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="modal-header">
                            <h5 class="modal-title">Registrar Uso de Garantía - <?php echo e($garantia->codigo); ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="fecha_uso_<?php echo e($garantia->id); ?>" class="form-label fw-bold">Fecha de Uso <span class="text-danger">*</span></label>
                                    <input type="date" name="fecha_uso" id="fecha_uso_<?php echo e($garantia->id); ?>" class="form-control" value="<?php echo e(date('Y-m-d')); ?>" max="<?php echo e(date('Y-m-d')); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="motivo_<?php echo e($garantia->id); ?>" class="form-label fw-bold">Motivo <span class="text-danger">*</span></label>
                                    <select name="motivo" id="motivo_<?php echo e($garantia->id); ?>" class="form-select" required>
                                        <option value="">Seleccionar motivo</option>
                                        <option value="defecto_fabrica">Defecto de Fábrica</option>
                                        <option value="falla_funcionamiento">Falla de Funcionamiento</option>
                                        <option value="bajo_rendimiento">Bajo Rendimiento</option>
                                        <option value="reemplazo">Reemplazo</option>
                                        <option value="reparacion">Reparación</option>
                                        <option value="otro">Otro</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="descripcion_problema_<?php echo e($garantia->id); ?>" class="form-label fw-bold">Descripción del Problema <span class="text-danger">*</span></label>
                                    <textarea name="descripcion_problema" id="descripcion_problema_<?php echo e($garantia->id); ?>" class="form-control" rows="3" placeholder="Describa el problema detalladamente..." required></textarea>
                                </div>
                                <div class="col-12">
                                    <label for="solucion_aplicada_<?php echo e($garantia->id); ?>" class="form-label fw-bold">Solución Aplicada</label>
                                    <textarea name="solucion_aplicada" id="solucion_aplicada_<?php echo e($garantia->id); ?>" class="form-control" rows="2" placeholder="Describa la solución aplicada (si corresponde)..."></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="tecnico_responsable_<?php echo e($garantia->id); ?>" class="form-label fw-bold">Técnico Responsable</label>
                                    <input type="text" name="tecnico_responsable" id="tecnico_responsable_<?php echo e($garantia->id); ?>" class="form-control" placeholder="Nombre del técnico">
                                </div>
                                <div class="col-md-6">
                                    <label for="costo_cubierto_<?php echo e($garantia->id); ?>" class="form-label fw-bold">Costo Cubierto (S/.)</label>
                                    <input type="number" name="costo_cubierto" id="costo_cubierto_<?php echo e($garantia->id); ?>" class="form-control" step="0.01" min="0" value="0" placeholder="0.00">
                                </div>
                                <div class="col-12">
                                    <label for="observaciones_<?php echo e($garantia->id); ?>" class="form-label fw-bold">Observaciones</label>
                                    <textarea name="observaciones" id="observaciones_<?php echo e($garantia->id); ?>" class="form-control" rows="2" placeholder="Observaciones adicionales..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle me-2"></i>Registrar Uso</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        
        <div class="modal fade" id="modalExtender-<?php echo e($garantia->id); ?>" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="<?php echo e(route('admin.crm.garantias.extender', $garantia)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Extender Garantía - <?php echo e($garantia->codigo); ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-info mb-3">
                                <small>
                                    <strong>Garantía actual:</strong> <?php echo e($garantia->codigo); ?><br>
                                    <strong>Cliente:</strong> <?php echo e($garantia->cliente->nombre ?? 'N/A'); ?><br>
                                    <strong>Vence:</strong> <?php echo e($garantia->fecha_fin?->format('d/m/Y') ?? 'N/A'); ?>

                                </small>
                            </div>
                            <div class="mb-3">
                                <label for="anos_extension_<?php echo e($garantia->id); ?>" class="form-label fw-bold">Años a Extender <span class="text-danger">*</span></label>
                                <select name="anos_extension" id="anos_extension_<?php echo e($garantia->id); ?>" class="form-select" required>
                                    <option value="">Seleccionar...</option>
                                    <?php for($i = 1; $i <= 10; $i++): ?>
                                        <option value="<?php echo e($i); ?>"><?php echo e($i); ?> año<?php echo e($i > 1 ? 's' : ''); ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="motivo_extension_<?php echo e($garantia->id); ?>" class="form-label fw-bold">Motivo de Extensión <span class="text-danger">*</span></label>
                                <textarea name="motivo_extension" id="motivo_extension_<?php echo e($garantia->id); ?>" class="form-control" rows="3" placeholder="Describa el motivo de la extensión..." required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="costo_extension_<?php echo e($garantia->id); ?>" class="form-label fw-bold">Costo de Extensión (S/.)</label>
                                <input type="number" name="costo_extension" id="costo_extension_<?php echo e($garantia->id); ?>" class="form-control" step="0.01" min="0" value="0" placeholder="0.00">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success"><i class="bi bi-check-circle me-2"></i>Extender Garantía</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
$(document).ready(function() {
    // Inicializar DataTable con filtros del lado del cliente
    var table = $('#tablaGarantias').DataTable({
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

    // Filtro por Estado (columna 7)
    $('#filtro-estado').on('change', function() {
        var val = $(this).val();
        table.column(7).search(val).draw();
    });

    // Filtro por Tipo (columna 4)
    $('#filtro-tipo').on('change', function() {
        var val = $(this).val();
        table.column(4).search(val).draw();
    });

    // Filtro por Vencimiento (columna 6)
    $('#filtro-vencimiento').on('change', function() {
        var val = $(this).val();
        if (val === '30d') {
            table.column(6).search('d').draw(); // Buscar los que tienen días
        } else {
            table.column(6).search('').draw();
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

<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/PRINCIPAL/crm/garantias/index.blade.php ENDPATH**/ ?>