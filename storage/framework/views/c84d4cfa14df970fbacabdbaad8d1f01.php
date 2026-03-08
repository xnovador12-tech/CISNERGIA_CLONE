<?php $__env->startSection('title', 'VER PEDIDO'); ?>

<?php $__env->startSection('content'); ?>
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">DETALLE DEL PEDIDO</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link"
                                href="<?php echo e(route('admin-dashboard.index')); ?>">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(route('admin-pedidos.index')); ?>">Pedidos</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Ver Pedido</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-3" role="alert">
                <i class="bi bi-check-circle-fill fs-5"></i>
                <div><?php echo e(session('success')); ?></div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-3" role="alert">
                <i class="bi bi-x-circle-fill fs-5"></i>
                <div><?php echo e(session('error')); ?></div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if(session('warning')): ?>
            <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center gap-2 mb-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                <div><?php echo e(session('warning')); ?></div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if(session('info')): ?>
            <div class="alert alert-info alert-dismissible fade show d-flex align-items-center gap-2 mb-3" role="alert">
                <i class="bi bi-info-circle-fill fs-5"></i>
                <div><?php echo e(session('info')); ?></div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        

        <div class="row g-3">
            <!-- Información del Pedido -->
            <div class="col-md-8">
                
                <!-- Indicador de Origen -->
                <div class="mb-3" data-aos="fade-up">
                    <?php if($pedido->origen === 'ecommerce'): ?>
                        <span class="badge bg-info fs-6">
                            <i class="bi bi-cart-check me-2"></i>Pedido E-commerce (Pago Online Confirmado)
                        </span>
                    <?php elseif($pedido->origen === 'cotizacion'): ?>
                        <span class="badge bg-primary fs-6">
                            <i class="bi bi-file-earmark-text me-2"></i>Pedido desde Cotización
                            <?php if($pedido->cotizacion_id): ?>
                                <a href="<?php echo e(route('admin.crm.cotizaciones.show', $pedido->cotizacion_id)); ?>" 
                                   class="text-white text-decoration-none ms-2 fw-bold"
                                   title="Ver cotización de origen">
                                    #<?php echo e($pedido->cotizacionCrm->codigo ?? $pedido->cotizacion_id); ?>

                                </a>
                            <?php endif; ?>
                        </span>
                    <?php else: ?>
                        <span class="badge bg-secondary fs-6">
                            <i class="bi bi-briefcase me-2"></i>Pedido Manual (Proyecto B2B)
                        </span>
                    <?php endif; ?>
                </div>

                
                <?php if(!$pedido->aprobacion_stock && $pedido->estado === 'pendiente'): ?>
                    <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center gap-3 mb-3" data-aos="fade-up">
                        <i class="bi bi-exclamation-triangle-fill fs-3"></i>
                        <div>
                            <h6 class="mb-0 fw-bold">Atención: Stock insuficiente</h6>
                            <small>No se pudo reservar el stock automáticamente. Por favor, revisa el inventario y una vez abastecido vuelve a intentar la reserva.</small>
                            <form action="<?php echo e(route('admin-pedidos.aprobar-stock', $pedido)); ?>" method="POST" class="mt-2">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-sm btn-dark">Re-intentar reserva de stock</button>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>


                <div class="card border-0 shadow-sm" data-aos="fade-up">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-file-text me-2"></i>Información del Pedido</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Código:</strong> <?php echo e($pedido->codigo); ?></p>
                                <p class="mb-1"><strong>Fecha:</strong> <?php echo e($pedido->created_at->format('d/m/Y H:i')); ?></p>
                                <p class="mb-1"><strong>Origen:</strong> 
                                    <span class="badge <?php echo e($pedido->origen == 'ecommerce' ? 'bg-purple' : 'bg-secondary'); ?>">
                                        <?php echo e(ucfirst($pedido->origen)); ?>

                                    </span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Estado:</strong>
                                    <?php if($pedido->estado == 'pendiente'): ?>
                                        <span class="badge bg-warning text-dark">Pendiente</span>
                                    <?php elseif($pedido->estado == 'proceso'): ?>
                                        <span class="badge bg-info">En Proceso</span>
                                    <?php elseif($pedido->estado == 'entregado'): ?>
                                        <span class="badge bg-success">Entregado</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Anulado / Cancelado</span>
                                    <?php endif; ?>
                                </p>
                                <p class="mb-1"><strong>Fecha Entrega:</strong> <?php echo e($pedido->fecha_entrega_estimada ? $pedido->fecha_entrega_estimada->format('d/m/Y') : 'Sin fecha'); ?></p>
                                <p class="mb-1"><strong>Vigencia:</strong> 
                                    <span class="badge bg-secondary"><?php echo e($pedido->vigencia_dias ?? 15); ?> días</span>
                                </p>
                                <p class="mb-1"><strong>Vendedor:</strong> <?php echo e($pedido->usuario->name ?? 'N/A'); ?></p>
                            </div>
                        </div>

                        <hr>

                        <div class="row mb-3">
                            <!-- Cliente -->
                            <div class="col-md-6">
                                <h6 class="text-uppercase fw-bold mb-3">Cliente</h6>
                                <p class="mb-1"><strong>Nombre:</strong> <?php echo e($pedido->cliente->nombre_completo ?? 'N/A'); ?></p>
                                <p class="mb-1"><strong>Documento:</strong> <?php echo e($pedido->cliente->documento ?? 'N/A'); ?></p>
                                <p class="mb-1"><strong>Correo:</strong> <?php echo e($pedido->cliente->email ?? 'N/A'); ?></p>
                                <p class="mb-1"><strong>Teléfono:</strong> <?php echo e($pedido->cliente->telefono ?? 'N/A'); ?></p>
                            </div>

                            <!-- Instalación -->
                            <div class="col-md-6">
                                <h6 class="text-uppercase fw-bold mb-3">Instalación</h6>
                                <p class="mb-1"><strong>Dirección:</strong> <?php echo e($pedido->direccion_instalacion ?? 'No especificada'); ?></p>
                                <p class="mb-1"><strong>Distrito:</strong> <?php echo e($pedido->distrito->nombre ?? 'No especificado'); ?></p>
                                <p class="mb-1"><strong>Almacén:</strong> <?php echo e($pedido->almacen->name ?? 'Sin asignar'); ?></p>
                            </div>
                        </div>

                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <h6 class="text-uppercase fw-bold mb-3">Información de Pago</h6>
                                <p class="mb-1">
                                    <strong>Condición de Pago:</strong> 
                                    <span class="badge <?php echo e($pedido->condicion_pago == 'Contado' ? 'bg-success' : 'bg-primary'); ?>">
                                        <?php echo e($pedido->condicion_pago ?? 'Contado'); ?>

                                    </span>
                                </p>
                                
                                <?php if($pedido->condicion_pago === 'Crédito' && $pedido->cuotas && $pedido->cuotas->count() > 0): ?>
                                <div class="mt-3 p-3 bg-light rounded border border-primary">
                                    <h6 class="fw-bold text-primary mb-2"><i class="bi bi-calendar3 me-2"></i>Cronograma de Cuotas</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered bg-white mb-0">
                                            <thead class="table-light text-muted small">
                                                <tr>
                                                    <th class="text-center" style="width: 50px;">N°</th>
                                                    <th>Fecha de Vencimiento</th>
                                                    <th class="text-end">Importe</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $pedido->cuotas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cuota): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td class="text-center fw-bold text-muted"><?php echo e($cuota->numero_cuota); ?></td>
                                                    <td><?php echo e($cuota->fecha_vencimiento ? \Carbon\Carbon::parse($cuota->fecha_vencimiento)->format('d/m/Y') : 'Sin fecha'); ?></td>
                                                    <td class="text-end fw-bold">S/ <?php echo e(number_format($cuota->importe, 2)); ?></td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if($pedido->observaciones): ?>
                        <hr>
                        <h6 class="text-uppercase fw-bold mb-2">Observaciones</h6>
                        <p><?php echo e($pedido->observaciones); ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Detalles del Pedido -->
                <div class="card border-0 shadow-sm mt-3" data-aos="fade-up">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>Detalles del Pedido</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <thead class="bg-light">
                                <tr>
                                    <th>N°</th>
                                    <th>Descripción</th>
                                    <th class="text-center">Cant.</th>
                                    <th class="text-end">P. Unit.</th>
                                    <th class="text-end">Desc.</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $contador = 1; ?>
                                <?php $__currentLoopData = $pedido->detalles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detalle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($contador++); ?></td>
                                    <td>
                                        <?php echo e($detalle->descripcion); ?>

                                        <br><small class="text-muted">Tipo: <?php echo e(ucfirst($detalle->tipo)); ?></small>
                                        <?php if($detalle->subcategoria): ?>
                                            <br><small class="text-muted">Subcategoría: <?php echo e($detalle->subcategoria->name); ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center"><?php echo e($detalle->cantidad); ?></td>
                                    <td class="text-end">S/ <?php echo e(number_format($detalle->precio_unitario, 2)); ?></td>
                                    <td class="text-end">S/ <?php echo e(number_format($detalle->descuento, 2)); ?></td>
                                    <td class="text-end">S/ <?php echo e(number_format($detalle->subtotal, 2)); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Resumen Financiero -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm" data-aos="fade-up">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-calculator me-2"></i>Resumen</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <strong>S/ <?php echo e(number_format($pedido->subtotal, 2)); ?></strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Descuento:</span>
                            <strong class="text-danger">- S/ <?php echo e(number_format($pedido->descuento, 2)); ?></strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>IGV (18%):</span>
                            <strong>S/ <?php echo e(number_format($pedido->igv, 2)); ?></strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <h5 class="mb-0">TOTAL:</h5>
                            <h5 class="mb-0 text-primary">S/ <?php echo e(number_format($pedido->total, 2)); ?></h5>
                        </div>
                    </div>
                </div>

                <!-- Acciones -->
                <div class="card border-0 shadow-sm mt-3" data-aos="fade-up">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="bi bi-tools me-2"></i>Acciones</h5>
                    </div>
                    <div class="card-body">
                        <?php if($pedido->venta): ?>
                            <a href="<?php echo e(route('admin-ventas.show', $pedido->venta)); ?>" class="btn btn-success w-100 mb-2">
                                <i class="bi bi-check-circle me-2"></i>Ver Comprobante: <?php echo e($pedido->venta->codigo); ?>

                            </a>
                        <?php else: ?>
                            
                            <?php if(!$pedido->aprobacion_finanzas): ?>
                                <form action="<?php echo e(route('admin-pedidos.aprobar-finanzas', $pedido)); ?>" method="POST" class="mb-2">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-primary w-100 py-2">
                                        <i class="bi bi-cash-coin me-2"></i>Confirmar Pago
                                    </button>
                                </form>
                            <?php else: ?>
                                <div class="alert alert-success py-2 mb-2 text-center" style="font-size:0.85rem;">
                                    <i class="bi bi-check-all me-1"></i> Pago Verificado
                                    <form action="<?php echo e(route('admin-pedidos.aprobar-finanzas', $pedido)); ?>" method="POST" class="d-inline ms-2">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-link p-0 text-danger text-decoration-none small" title="Revocar Pago">
                                            <i class="bi bi-arrow-counterclockwise"></i>
                                        </button>
                                    </form>
                                </div>

                                <button type="button" class="btn btn-outline-primary w-100 mb-2" data-bs-toggle="modal" data-bs-target="#modalGenerarComprobante">
                                    <i class="bi bi-receipt me-2"></i>Generar Comprobante
                                </button>
                            <?php endif; ?>
                        <?php endif; ?>
                        
                        
                        <?php if(!$pedido->venta): ?>
                            <a href="<?php echo e(route('admin-pedidos.edit', $pedido)); ?>" class="btn btn-warning w-100 mb-2">
                                <i class="bi bi-pencil me-2"></i>Editar Pedido
                            </a>
                        <?php else: ?>
                            <div class="alert alert-warning py-2 mb-2 text-center small">
                                <i class="bi bi-lock-fill me-1"></i> Pedido bloqueado. Ya tiene comprobante generado.
                            </div>
                        <?php endif; ?>
                        
                        <a href="<?php echo e(route('admin-pedidos.index')); ?>" class="btn btn-secondary w-100">
                            <i class="bi bi-arrow-left me-2"></i>Volver al Listado
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php $cuotasExistentes = $pedido->cuotas()->orderBy('numero_cuota')->get(); ?>

    <!-- Modal: Generar Comprobante -->
    <?php if(!$pedido->venta): ?>
    <div class="modal fade" id="modalGenerarComprobante" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title font-weight-bold"><i class="bi bi-receipt me-2"></i>Facturación Directa</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?php echo e(route('admin-pedidos.generar-comprobante', $pedido)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="alert alert-primary bg-opacity-10 border-primary text-primary" style="font-size: 0.9rem;">
                            <i class="bi bi-info-circle-fill me-2"></i> Verifique el tipo de comprobante y los medios de pago finales para el pedido <b><?php echo e($pedido->codigo); ?></b>.
                        </div>
                        
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Tipo de Comprobante <span class="text-danger">*</span></label>
                                <select name="tiposcomprobante_id" class="form-select" required>
                                    <option value="">Seleccionar...</option>
                                    <?php $__currentLoopData = \App\Models\Tiposcomprobante::where('tipo', 'ventas')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($tipo->id); ?>"><?php echo e($tipo->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Medio de Pago Principal <span class="text-danger">*</span></label>
                                <select name="mediopago_id" class="form-select" required>
                                    <?php $__currentLoopData = \App\Models\Mediopago::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $medio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($medio->id); ?>" <?php echo e($pedido->mediopago_id == $medio->id ? 'selected' : ''); ?>><?php echo e($medio->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Condición de Pago <span class="text-danger">*</span></label>
                                <select name="condicion_pago" class="form-select selector-condicion-pago" required>
                                    <option value="Contado" <?php echo e($pedido->condicion_pago == 'Contado' ? 'selected' : ''); ?>>Al Contado</option>
                                    <option value="Crédito" <?php echo e($pedido->condicion_pago == 'Crédito' ? 'selected' : ''); ?>>A Crédito</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">N° Comprobante (Manual/Fijo)</label>
                                <input type="text" name="numero_comprobante" class="form-control" placeholder="Dejar vacío para correlativo auto">
                            </div>
                        </div>

                        <!-- SECCIÓN CUOTAS -->
                        <div class="seccion-cuotas-container mb-3 p-3 bg-light border rounded" style="display: none;">
                            <h6 class="fw-bold mb-3 d-flex justify-content-between">
                                <span><i class="bi bi-calendar-check me-2"></i>Cronograma de Facturación</span>
                                <small class="text-muted">Total: S/ <span class="monto-total-pedido"><?php echo e(number_format($pedido->total, 2, '.', '')); ?></span></small>
                            </h6>
                            
                            <table class="table table-sm table-bordered bg-white tabla-cuotas-dinamica">
                                <thead class="table-secondary small">
                                    <tr>
                                        <th class="text-center">N°</th>
                                        <th>Fecha Venc.</th>
                                        <th>Importe (S/)</th>
                                        <th class="text-center"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $cuotasExistentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $cuota): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="align-middle text-center fw-bold cuota-numero"><?php echo e($index + 1); ?></td>
                                            <td>
                                                <input type="date" name="cuotas[<?php echo e($index); ?>][fecha_vencimiento]" class="form-control form-control-sm" value="<?php echo e($cuota->fecha_vencimiento); ?>" required>
                                            </td>
                                            <td>
                                                <input type="number" step="0.01" min="0.01" name="cuotas[<?php echo e($index); ?>][importe]" class="form-control form-control-sm input-cuota-monto" value="<?php echo e($cuota->importe); ?>" required>
                                            </td>
                                            <td class="align-middle text-center">
                                                <button type="button" class="btn btn-sm text-danger btn-eliminar-cuota"><i class="bi bi-trash"></i></button>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-sm btn-outline-primary w-100 btn-agregar-cuota">
                                <i class="bi bi-plus-circle me-1"></i>Añadir Línea de Crédito
                            </button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-1"></i>Emitir Comprobante
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
    $(document).ready(function() {
        const totalFacturar = parseFloat("<?php echo e($pedido->total); ?>");

        // Función unificada para manejar el cambio de condición
        function initCuotasLogic(modal) {
            const $modal = $(modal);
            const $selectSub = $modal.find('.selector-condicion-pago');
            const $container = $modal.find('.seccion-cuotas-container');
            const $btnAgregar = $modal.find('.btn-agregar-cuota');
            const $tbody = $modal.find('.tabla-cuotas-dinamica tbody');

            function toggleSeccion() {
                const esCredito = $selectSub.val() === 'Crédito';
                if (esCredito) {
                    $container.slideDown();
                    $container.find('input').prop('disabled', false); // Habilitar para validación y envío
                    if ($tbody.children().length === 0) {
                        agregarCuota($modal);
                    }
                } else {
                    $container.slideUp();
                    $container.find('input').prop('disabled', true); // Deshabilitar para evitar bloqueos por 'required' ocultos
                }
            }

            // Trigger inicial
            toggleSeccion();

            $selectSub.on('change', toggleSeccion);
            
            $btnAgregar.off('click').on('click', function() {
                agregarCuota($modal);
            });
        }

        // Función para agregar fila de cuota
        function agregarCuota($modal) {
            const $tbody = $modal.find('.tabla-cuotas-dinamica tbody');
            const index = $tbody.children().length;
            
            // Sugerir monto restante
            let suma = 0;
            $modal.find('.input-cuota-monto').each(function() {
                suma += parseFloat($(this).val() || 0);
            });
            let sug = Math.max(0, totalFacturar - suma);

            const row = `
                <tr>
                    <td class="align-middle text-center fw-bold cuota-numero">${index + 1}</td>
                    <td><input type="date" name="cuotas[${index}][fecha_vencimiento]" class="form-control form-control-sm" required></td>
                    <td><input type="number" step="0.01" min="0.01" name="cuotas[${index}][importe]" class="form-control form-control-sm input-cuota-monto" value="${sug.toFixed(2)}" required></td>
                    <td class="align-middle text-center"><button type="button" class="btn btn-sm text-danger btn-eliminar-cuota"><i class="bi bi-trash"></i></button></td>
                </tr>
            `;
            $tbody.append(row);
            reordenarIndices($modal);
        }

        function reordenarIndices($modal) {
            $modal.find('.tabla-cuotas-dinamica tbody tr').each(function(i) {
                $(this).find('.cuota-numero').text(i + 1);
                $(this).find('input[name*="fecha_vencimiento"]').attr('name', `cuotas[${i}][fecha_vencimiento]`);
                $(this).find('input[name*="importe"]').attr('name', `cuotas[${i}][importe]`);
            });
        }

        // Delegación de eventos para eliminar
        $(document).on('click', '.btn-eliminar-cuota', function() {
            const $modal = $(this).closest('.modal');
            $(this).closest('tr').remove();
            reordenarIndices($modal);
        });

        // Inicializar lógica de cuotas en modal de facturación
        ['#modalGenerarComprobante'].forEach(id => {
            if ($(id).length) initCuotasLogic(id);
        });

        // Validación global de montos al enviar
        $('form').on('submit', function(e) {
            const $form = $(this);
            const $sel = $form.find('.selector-condicion-pago');
            
            if ($sel.val() === 'Crédito') {
                let suma = 0;
                $form.find('.input-cuota-monto').each(function() {
                    suma += parseFloat($(this).val() || 0);
                });

                if (Math.abs(suma - totalFacturar) > 0.05) {
                    e.preventDefault();
                    alert(`La suma de las cuotas (S/ ${suma.toFixed(2)}) debe coincidir con el total (S/ ${totalFacturar.toFixed(2)}).`);
                }
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/PRINCIPAL/ventas/pedidos/show.blade.php ENDPATH**/ ?>