<?php $__env->startSection('title', isset($pedido) ? 'EDITAR PEDIDO' : 'CREAR PEDIDO'); ?>

<?php $__env->startSection('content'); ?>
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0"><?php echo e(isset($pedido) ? 'EDITAR PEDIDO' : 'CREAR PEDIDO'); ?></h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(route('admin-dashboard.index')); ?>">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(route('admin-pedidos.index')); ?>">Pedidos</a></li>
                        <li class="breadcrumb-item link" aria-current="page"><?php echo e(isset($pedido) ? 'Editar' : 'Crear'); ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <form action="<?php echo e(isset($pedido) ? route('admin-pedidos.update', $pedido) : route('admin-pedidos.store')); ?>" method="POST" id="formPedido">
            <?php echo csrf_field(); ?>
            <?php if(isset($pedido)): ?>
                <?php echo method_field('PUT'); ?>
            <?php endif; ?>
            <div class="row g-3">
                <!-- Columna Izquierda: Información + Productos -->
                <div class="col-lg-8">
                    <!-- Card: Información del Pedido -->
                    <div class="card border-0 shadow-sm mb-3" data-aos="fade-up">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="bi bi-file-text me-2"></i>Información del Pedido</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Cliente <span class="text-danger">*</span></label>
                                    <select name="cliente_id" id="cliente_id" class="form-select <?php $__errorArgs = ['cliente_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                         <option value="">Seleccione un cliente</option>
                                         <?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                             <option value="<?php echo e($cliente->id); ?>" <?php echo e((isset($pedido) && $pedido->cliente_id == $cliente->id) || old('cliente_id') == $cliente->id ? 'selected' : ''); ?>>
                                                 <?php echo e($cliente->nombre); ?> <?php echo e($cliente->apellidos); ?> - <?php echo e($cliente->ruc ?? $cliente->dni ?? 'Sin documento'); ?>

                                             </option>
                                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                     </select>
                                     <?php $__errorArgs = ['cliente_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                         <small class="text-danger"><?php echo e($message); ?></small>
                                     <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                 </div>

                                 <div class="col-md-6">
                                     <label class="form-label">Fecha Entrega Estimada</label>
                                     <input type="date" name="fecha_entrega_estimada" class="form-control" value="<?php echo e(isset($pedido) ? ($pedido->fecha_entrega_estimada ? $pedido->fecha_entrega_estimada->format('Y-m-d') : '') : old('fecha_entrega_estimada')); ?>">
                                 </div>

                                 <?php if(isset($pedido)): ?>
                                 <div class="col-md-6">
                                    <label class="form-label">Estado del Pedido <span class="text-danger">*</span></label>
                                    <select name="estado" class="form-select" required>
                                        <option value="pendiente" <?php echo e($pedido->estado == 'pendiente' ? 'selected' : ''); ?>>Pendiente</option>
                                        <option value="proceso" <?php echo e($pedido->estado == 'proceso' ? 'selected' : ''); ?>>En Proceso</option>
                                        <option value="entregado" <?php echo e($pedido->estado == 'entregado' ? 'selected' : ''); ?>>Entregado</option>
                                        <option value="cancelado" <?php echo e($pedido->estado == 'cancelado' ? 'selected' : ''); ?>>Anular / Cancelado</option>
                                    </select>
                                 </div>
                                 <?php endif; ?>

                                 <div class="col-md-<?php echo e(isset($pedido) ? '6' : '8'); ?>">
                                     <label class="form-label">Dirección de Instalación</label>
                                     <input type="text" name="direccion_instalacion" class="form-control" value="<?php echo e(isset($pedido) ? $pedido->direccion_instalacion : old('direccion_instalacion')); ?>" placeholder="Dirección completa">
                                 </div>

                                 <div class="col-md-4">
                                     <label class="form-label">Distrito</label>
                                     <select name="distrito_id" class="form-select">
                                         <option value="">Seleccione distrito</option>
                                         <?php $__currentLoopData = $distritos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $distrito): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                             <option value="<?php echo e($distrito->id); ?>" <?php echo e((isset($pedido) && $pedido->distrito_id == $distrito->id) || old('distrito_id') == $distrito->id ? 'selected' : ''); ?>>
                                                 <?php echo e($distrito->name); ?>

                                             </option>
                                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                     </select>
                                 </div>

                                 <div class="col-md-4">
                                     <label class="form-label">Técnico Asignado</label>
                                     <select name="tecnico_asignado_id" class="form-select">
                                         <option value="">Sin asignar</option>
                                         <?php $__currentLoopData = $tecnicos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tecnico): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                             <option value="<?php echo e($tecnico->id); ?>" <?php echo e((isset($pedido) && $pedido->tecnico_asignado_id == $tecnico->id) || old('tecnico_asignado_id') == $tecnico->id ? 'selected' : ''); ?>>
                                                 <?php echo e($tecnico->name); ?>

                                             </option>
                                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                     </select>
                                 </div>

                                 <div class="col-md-4">
                                     <label class="form-label">Almacén</label>
                                     <select name="almacen_id" class="form-select">
                                         <option value="">Seleccione almacén</option>
                                         <?php $__currentLoopData = $almacenes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $almacen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                             <option value="<?php echo e($almacen->id); ?>" <?php echo e((isset($pedido) && $pedido->almacen_id == $almacen->id) || old('almacen_id') == $almacen->id ? 'selected' : ''); ?>>
                                                 <?php echo e($almacen->nombre ?? $almacen->name); ?>

                                             </option>
                                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                     </select>
                                 </div>

                                 <div class="col-md-4">
                                     <label class="form-label">Observaciones</label>
                                     <textarea name="observaciones" class="form-control" rows="2" placeholder="Notas adicionales"><?php echo e(isset($pedido) ? $pedido->observaciones : old('observaciones')); ?></textarea>
                                 </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card: Detalle de Productos/Servicios -->
                    <div class="card border-0 shadow-sm" data-aos="fade-up">
                        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="bi bi-box-seam me-2"></i>Detalle del Pedido</h5>
                            <button type="button" class="btn btn-success btn-sm" id="btnAgregarFila">
                                <i class="bi bi-plus-circle me-1"></i>Agregar Ítem
                            </button>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="tablaDetalles">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 40%">Producto/Servicio</th>
                                            <th style="width: 10%" class="text-center">Cant.</th>
                                            <th style="width: 15%" class="text-end">P. Unit.</th>
                                            <th style="width: 10%" class="text-end">Desc.</th>
                                            <th style="width: 15%" class="text-end">Subtotal</th>
                                            <th style="width: 10%" class="text-center">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyDetalles">
                                        <?php if(isset($pedido) && $pedido->detalles->count() > 0): ?>
                                            <?php $__currentLoopData = $pedido->detalles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $detalle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr class="fila-detalle">
                                                    <td>
                                                        <select name="detalles[<?php echo e($index); ?>][producto_id]" class="form-select form-select-sm select-producto">
                                                            <option value="">Seleccione producto...</option>
                                                            <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($producto->id); ?>" data-precio="<?php echo e($producto->precio_venta ?? 0); ?>" <?php echo e($detalle->producto_id == $producto->id ? 'selected' : ''); ?>>
                                                                    <?php echo e($producto->name); ?>

                                                                </option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                        <input type="hidden" name="detalles[<?php echo e($index); ?>][tipo]" value="<?php echo e($detalle->tipo ?? 'producto'); ?>">
                                                        <input type="text" name="detalles[<?php echo e($index); ?>][descripcion]" class="form-control form-control-sm mt-1 input-descripcion" placeholder="Descripción adicional..." value="<?php echo e($detalle->descripcion); ?>">
                                                    </td>
                                                    <td>
                                                        <input type="number" name="detalles[<?php echo e($index); ?>][cantidad]" class="form-control form-control-sm text-center input-cantidad" value="<?php echo e($detalle->cantidad); ?>" min="1">
                                                    </td>
                                                    <td>
                                                        <input type="number" name="detalles[<?php echo e($index); ?>][precio_unitario]" class="form-control form-control-sm text-end input-precio" value="<?php echo e($detalle->precio_unitario); ?>" step="0.01">
                                                    </td>
                                                    <td>
                                                        <input type="number" name="detalles[<?php echo e($index); ?>][descuento]" class="form-control form-control-sm text-end input-descuento" value="<?php echo e($detalle->descuento); ?>" step="0.01">
                                                    </td>
                                                    <td>
                                                        <input type="number" name="detalles[<?php echo e($index); ?>][subtotal]" class="form-control form-control-sm text-end input-subtotal" value="<?php echo e($detalle->subtotal); ?>" step="0.01" readonly>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-outline-danger btn-sm btn-eliminar-fila">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <!-- Fila inicial (Para pedidos nuevos) -->
                                            <tr class="fila-detalle">
                                                <td>
                                                    <select name="detalles[0][producto_id]" class="form-select form-select-sm select-producto">
                                                        <option value="">Seleccione producto...</option>
                                                        <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($producto->id); ?>" data-precio="<?php echo e($producto->precio_venta ?? 0); ?>">
                                                                <?php echo e($producto->name); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                    <input type="hidden" name="detalles[0][tipo]" value="producto">
                                                    <input type="text" name="detalles[0][descripcion]" class="form-control form-control-sm mt-1 input-descripcion" placeholder="Descripción adicional...">
                                                </td>
                                                <td>
                                                    <input type="number" name="detalles[0][cantidad]" class="form-control form-control-sm text-center input-cantidad" value="1" min="1">
                                                </td>
                                                <td>
                                                    <input type="number" name="detalles[0][precio_unitario]" class="form-control form-control-sm text-end input-precio" value="0" step="0.01">
                                                </td>
                                                <td>
                                                    <input type="number" name="detalles[0][descuento]" class="form-control form-control-sm text-end input-descuento" value="0" step="0.01">
                                                </td>
                                                <td>
                                                    <input type="number" name="detalles[0][subtotal]" class="form-control form-control-sm text-end input-subtotal" value="0" step="0.01" readonly>
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-outline-danger btn-sm btn-eliminar-fila">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="p-3 text-muted small">
                                <i class="bi bi-info-circle me-1"></i>Agregue los productos o servicios que incluye este pedido.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Columna Derecha: Totales + Acciones -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm sticky-top" style="top: 80px" data-aos="fade-up">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="bi bi-calculator me-2"></i>Resumen</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Subtotal:</span>
                                <span class="fw-bold" id="displaySubtotal">S/ 0.00</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Descuento:</span>
                                <span class="text-danger" id="displayDescuento">- S/ 0.00</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">IGV (18%):</span>
                                <span id="displayIgv">S/ 0.00</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="h5 mb-0">TOTAL:</span>
                                <span class="h5 mb-0 text-primary" id="displayTotal">S/ 0.00</span>
                            </div>

                            <!-- Campos ocultos para enviar los totales -->
                            <input type="hidden" name="subtotal" id="inputSubtotal" value="0">
                            <input type="hidden" name="descuento" id="inputDescuento" value="0">
                            <input type="hidden" name="igv" id="inputIgv" value="0">
                            <input type="hidden" name="total" id="inputTotal" value="0">

                            <hr>

                            <button type="submit" class="btn btn-primary w-100 mb-2">
                                <i class="bi bi-save me-2"></i>Guardar Pedido
                            </button>
                            <a href="<?php echo e(route('admin-pedidos.index')); ?>" class="btn btn-outline-secondary w-100">
                                <i class="bi bi-x-circle me-2"></i>Cancelar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
$(document).ready(function() {
    let filaIndex = <?php echo e(isset($pedido) ? $pedido->detalles->count() : 1); ?>;

    <?php if(isset($pedido)): ?>
        calcularTotales();
    <?php endif; ?>

    // Agregar nueva fila
    $('#btnAgregarFila').on('click', function() {
        const nuevaFila = `
            <tr class="fila-detalle">
                <td>
                    <select name="detalles[${filaIndex}][producto_id]" class="form-select form-select-sm select-producto">
                        <option value="">Seleccione producto...</option>
                        <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($producto->id); ?>" data-precio="<?php echo e($producto->precio_venta ?? 0); ?>">
                                <?php echo e($producto->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <input type="hidden" name="detalles[${filaIndex}][tipo]" value="producto">
                    <input type="text" name="detalles[${filaIndex}][descripcion]" class="form-control form-control-sm mt-1 input-descripcion" placeholder="Descripción adicional...">
                </td>
                <td>
                    <input type="number" name="detalles[${filaIndex}][cantidad]" class="form-control form-control-sm text-center input-cantidad" value="1" min="1">
                </td>
                <td>
                    <input type="number" name="detalles[${filaIndex}][precio_unitario]" class="form-control form-control-sm text-end input-precio" value="0" step="0.01">
                </td>
                <td>
                    <input type="number" name="detalles[${filaIndex}][descuento]" class="form-control form-control-sm text-end input-descuento" value="0" step="0.01">
                </td>
                <td>
                    <input type="number" name="detalles[${filaIndex}][subtotal]" class="form-control form-control-sm text-end input-subtotal" value="0" step="0.01" readonly>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-outline-danger btn-sm btn-eliminar-fila">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        `;
        $('#tbodyDetalles').append(nuevaFila);
        filaIndex++;
    });

    // Eliminar fila
    $(document).on('click', '.btn-eliminar-fila', function() {
        const filas = $('.fila-detalle').length;
        if (filas > 1) {
            $(this).closest('tr').remove();
            calcularTotales();
        } else {
            alert('Debe haber al menos un ítem en el pedido.');
        }
    });

    // Al seleccionar producto, cargar precio
    $(document).on('change', '.select-producto', function() {
        const precio = $(this).find(':selected').data('precio') || 0;
        const fila = $(this).closest('tr');
        fila.find('.input-precio').val(precio);
        fila.find('.input-descripcion').val($(this).find(':selected').text().trim());
        calcularSubtotalFila(fila);
    });

    // Al cambiar cantidad, precio o descuento
    $(document).on('input', '.input-cantidad, .input-precio, .input-descuento', function() {
        const fila = $(this).closest('tr');
        calcularSubtotalFila(fila);
    });

    // Calcular subtotal de una fila
    function calcularSubtotalFila(fila) {
        const cantidad = parseFloat(fila.find('.input-cantidad').val()) || 0;
        const precio = parseFloat(fila.find('.input-precio').val()) || 0;
        const descuento = parseFloat(fila.find('.input-descuento').val()) || 0;
        const subtotal = (cantidad * precio) - descuento;
        fila.find('.input-subtotal').val(subtotal.toFixed(2));
        calcularTotales();
    }

    // Calcular totales generales (Lógica: Precios incluyen IGV)
    function calcularTotales() {
        let totalGeneral = 0; // Total a pagar (Inc. IGV)
        let descuentoTotal = 0; // Solo informativo/visual

        $('.fila-detalle').each(function() {
            const subtotalFila = parseFloat($(this).find('.input-subtotal').val()) || 0;
            const descuentoFila = parseFloat($(this).find('.input-descuento').val()) || 0;
            
            // El subtotalFila ya es (Qty * Precio) - Descuento. O sea, el precio final de la línea.
            totalGeneral += subtotalFila;
            descuentoTotal += descuentoFila;
        });

        // Desglosar IGV del Total
        // Venta = Base + IGV
        // Base = Venta / 1.18
        const baseImponible = totalGeneral / 1.18;
        const igv = totalGeneral - baseImponible;

        // Actualizar displays
        // Nota: 'Subtotal' en el resumen mostrará el Valor de Venta (Base Imponible) para que matemáticamente cuadre: Base + IGV = Total
        $('#displaySubtotal').text('S/ ' + baseImponible.toFixed(2));
        
        // El descuento ya está aplicado en el total, mostrarlo aquí puede confundir la suma vertical si no se aclara.
        // Sin embargo, lo mostraremos informativo. Si restamos Base - Descuento + IGV no cuadraría si Base ya tiene descuento.
        // Para que cuadre visualmente: Base + IGV = Total. El descuento mostramos solo como info.
        $('#displayDescuento').text('- S/ ' + descuentoTotal.toFixed(2) + ' (Incluido)');
        
        $('#displayIgv').text('S/ ' + igv.toFixed(2));
        $('#displayTotal').text('S/ ' + totalGeneral.toFixed(2));

        // Actualizar inputs ocultos para el Backend
        $('#inputSubtotal').val(baseImponible.toFixed(2)); // Guardamos la Base
        $('#inputDescuento').val(descuentoTotal.toFixed(2));
        $('#inputIgv').val(igv.toFixed(2));
        $('#inputTotal').val(totalGeneral.toFixed(2));
    }

    // Validar antes de enviar
    $('#formPedido').on('submit', function(e) {
        const total = parseFloat($('#inputTotal').val());
        if (total <= 0) {
            e.preventDefault();
            alert('Debe agregar al menos un producto con precio válido.');
            return false;
        }
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/PRINCIPAL/ventas/pedidos/create.blade.php ENDPATH**/ ?>