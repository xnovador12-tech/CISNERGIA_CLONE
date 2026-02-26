<?php $__env->startSection('title', 'Editar Oportunidad'); ?>

<?php $__env->startSection('css'); ?>
<style>
    .tabla-items th { font-size: 0.75rem; text-transform: uppercase; background: #f8f9fa; }
    .tabla-items td { vertical-align: top; }
    .tabla-items .form-control, .tabla-items .form-select { font-size: 0.8rem; }
    .item-subtotal { font-weight: 600; min-width: 100px; text-align: right; }
    .btn-quitar { padding: 0.15rem 0.4rem; font-size: 0.75rem; }
    .cascada-selects { display: flex; flex-wrap: wrap; gap: 4px; }
    .cascada-selects .sel-wrap { flex: 1; min-width: 120px; }
    .producto-info { font-size: 0.72rem; color: #6c757d; margin-top: 2px; }
    .cascada-selects .select2-container { font-size: 0.8rem; }
    .cascada-selects .select2-container--bootstrap-5 .select2-selection { min-height: 28px; padding: 0.15rem 0.5rem; font-size: 0.8rem; }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">EDITAR OPORTUNIDAD</h1>
                <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(route('admin-dashboard.index')); ?>">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(route('admin.crm.oportunidades.index')); ?>">Oportunidades</a></li>
                        <li class="breadcrumb-item link" aria-current="page"><?php echo e($oportunidad->codigo); ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <form action="<?php echo e(route('admin.crm.oportunidades.update', $oportunidad)); ?>" method="POST" class="needs-validation" novalidate>
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <input type="hidden" name="redirect_to" value="<?php echo e(request('redirect_to', 'show')); ?>">

            <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <span class="badge bg-secondary fs-6"><?php echo e($oportunidad->codigo); ?></span>
                    <?php
                        $etapaColors = [
                            'calificacion' => 'primary', 'evaluacion' => 'info',
                            'propuesta_tecnica' => 'warning', 'negociacion' => 'secondary',
                            'ganada' => 'success', 'perdida' => 'danger'
                        ];
                    ?>
                    <span class="badge bg-<?php echo e($etapaColors[$oportunidad->etapa] ?? 'secondary'); ?>">
                        <?php echo e(\App\Models\Oportunidad::ETAPAS[$oportunidad->etapa]['nombre'] ?? ucfirst($oportunidad->etapa)); ?>

                    </span>
                </div>
                <div class="card-body">

                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
                        </div>
                    <?php endif; ?>

                    <div class="row g-3">
                        
                        <div class="col-12"><h6 class="text-primary border-bottom pb-2"><i class="bi bi-info-circle me-2"></i>Información General</h6></div>

                        <div class="col-md-6">
                            <label class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="nombre" value="<?php echo e(old('nombre', $oportunidad->nombre)); ?>" required>
                            <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Tipo de Proyecto <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm select2_bootstrap w-100 <?php $__errorArgs = ['tipo_proyecto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="tipo_proyecto" required>
                                <?php $__currentLoopData = ['residencial' => 'Residencial', 'comercial' => 'Comercial', 'industrial' => 'Industrial', 'agricola' => 'Agrícola']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key); ?>" <?php echo e(old('tipo_proyecto', $oportunidad->tipo_proyecto) == $key ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Tipo de Oportunidad <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm select2_bootstrap w-100 <?php $__errorArgs = ['tipo_oportunidad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="tipo_oportunidad" id="tipo_oportunidad" required>
                                <option value="producto" <?php echo e(old('tipo_oportunidad', $oportunidad->tipo_oportunidad) == 'producto' ? 'selected' : ''); ?>>Producto</option>
                                <option value="servicio" <?php echo e(old('tipo_oportunidad', $oportunidad->tipo_oportunidad) == 'servicio' ? 'selected' : ''); ?>>Servicio</option>
                                <option value="mixto" <?php echo e(old('tipo_oportunidad', $oportunidad->tipo_oportunidad) == 'mixto' ? 'selected' : ''); ?>>Mixto</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Prospecto</label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="prospecto_id" data-placeholder="Seleccionar prospecto...">
                                <option value="">Ninguno</option>
                                <?php $__currentLoopData = $prospectos ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prospecto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($prospecto->id); ?>" <?php echo e(old('prospecto_id', $oportunidad->prospecto_id) == $prospecto->id ? 'selected' : ''); ?>>
                                        <?php echo e($prospecto->codigo); ?> - <?php echo e($prospecto->nombre_completo); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Cliente</label>
                            <?php if($oportunidad->cliente): ?>
                                <div class="form-control form-control-sm bg-light">
                                    <i class="bi bi-person-check text-success me-1"></i><?php echo e($oportunidad->cliente->codigo); ?> - <?php echo e($oportunidad->cliente->nombre); ?>

                                </div>
                            <?php else: ?>
                                <div class="form-control form-control-sm bg-light text-muted">Sin cliente asignado</div>
                            <?php endif; ?>
                            <small class="text-muted"><i class="bi bi-lock me-1"></i>Se asigna al marcar ganada</small>
                        </div>

                        
                        <div id="seccion_servicio" class="col-12" style="display: none;">
                            <div class="row g-3">
                                <div class="col-12 mt-4"><h6 class="text-success border-bottom pb-2"><i class="bi bi-wrench me-2"></i>Detalle del Servicio</h6></div>
                                <div class="col-md-4">
                                    <label class="form-label">Tipo de Servicio</label>
                                    <select class="form-select form-select-sm select2_bootstrap w-100" name="tipo_servicio" data-placeholder="Seleccionar...">
                                        <option value="">Seleccionar...</option>
                                        <?php $__currentLoopData = ['instalacion' => 'Instalación', 'mantenimiento_preventivo' => 'Mant. Preventivo', 'mantenimiento_correctivo' => 'Mant. Correctivo', 'ampliacion' => 'Ampliación', 'otro' => 'Otro']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($key); ?>" <?php echo e(old('tipo_servicio', $oportunidad->tipo_servicio) == $key ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label">Descripción del Servicio</label>
                                    <textarea class="form-control form-control-sm" name="descripcion_servicio" rows="2"><?php echo e(old('descripcion_servicio', $oportunidad->descripcion_servicio)); ?></textarea>
                                </div>
                            </div>
                        </div>

                        
                        <div class="col-12 mt-4"><h6 class="text-primary border-bottom pb-2"><i class="bi bi-geo-alt me-2"></i>Visita Técnica</h6></div>

                        <div class="col-md-3">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="requiere_visita_tecnica" id="requiere_visita" value="1"
                                       <?php echo e(old('requiere_visita_tecnica', $oportunidad->requiere_visita_tecnica) ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="requiere_visita">¿Requiere visita técnica?</label>
                            </div>
                        </div>

                        <div class="col-md-3" id="campo_fecha_visita" style="display: none;">
                            <label class="form-label">Fecha Programada</label>
                            <input type="date" class="form-control form-control-sm" name="fecha_visita_programada" value="<?php echo e(old('fecha_visita_programada', $oportunidad->fecha_visita_programada?->format('Y-m-d'))); ?>">
                        </div>

                        <div class="col-md-6" id="campo_resultado_visita" style="display: none;">
                            <label class="form-label">Resultado de la Visita</label>
                            <textarea class="form-control form-control-sm" name="resultado_visita" rows="2" placeholder="Hallazgos, diagnóstico, recomendaciones..."><?php echo e(old('resultado_visita', $oportunidad->resultado_visita)); ?></textarea>
                        </div>

                        
                        <div class="col-12 mt-4"><h6 class="text-primary border-bottom pb-2"><i class="bi bi-currency-dollar me-2"></i>Pipeline y Valores</h6></div>

                        <div class="col-md-3">
                            <label class="form-label">Etapa</label>
                            <?php $etapaInfo = \App\Models\Oportunidad::ETAPAS[$oportunidad->etapa] ?? ['nombre' => ucfirst($oportunidad->etapa), 'color' => 'secondary']; ?>
                            <div class="form-control form-control-sm bg-light">
                                <span class="badge bg-<?php echo e($etapaInfo['color']); ?>"><?php echo e($etapaInfo['nombre']); ?></span>
                            </div>
                            <small class="text-muted"><i class="bi bi-lock me-1"></i>Se gestiona desde el detalle</small>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Monto Estimado (S/) <span class="text-danger">*</span></label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">S/</span>
                                <input type="number" class="form-control form-control-sm" name="monto_estimado" id="monto_estimado" value="<?php echo e(old('monto_estimado', $oportunidad->monto_estimado)); ?>" step="0.01" required>
                            </div>
                            <small class="text-muted" id="monto-auto-msg" style="display: none;"><i class="bi bi-calculator me-1"></i>Calculado desde productos</small>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Monto Final (S/)</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">S/</span>
                                <input type="number" class="form-control form-control-sm bg-light" value="<?php echo e($oportunidad->monto_final); ?>" step="0.01" readonly>
                            </div>
                            <small class="text-muted"><i class="bi bi-lock me-1"></i>Se define al marcar ganada</small>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Probabilidad (%)</label>
                            <input type="number" class="form-control form-control-sm bg-light" value="<?php echo e($oportunidad->probabilidad); ?>" readonly>
                            <small class="text-muted"><i class="bi bi-lock me-1"></i>Se ajusta con la etapa</small>
                        </div>

                        
                        <div class="col-12 mt-4"><h6 class="text-primary border-bottom pb-2"><i class="bi bi-calendar me-2"></i>Fechas</h6></div>

                        <div class="col-md-4">
                            <label class="form-label">Fecha Cierre Estimada</label>
                            <input type="date" class="form-control form-control-sm" name="fecha_cierre_estimada" value="<?php echo e(old('fecha_cierre_estimada', $oportunidad->fecha_cierre_estimada?->format('Y-m-d'))); ?>">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Fecha Cierre Real</label>
                            <input type="date" class="form-control form-control-sm bg-light" value="<?php echo e($oportunidad->fecha_cierre_real?->format('Y-m-d')); ?>" readonly>
                            <small class="text-muted"><i class="bi bi-lock me-1"></i>Se define al marcar ganada</small>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Vendedor Asignado</label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="user_id" data-placeholder="Seleccionar vendedor...">
                                <option value="">Sin asignar</option>
                                <?php $__currentLoopData = $vendedores ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendedor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($vendedor->id); ?>" <?php echo e(old('user_id', $oportunidad->user_id) == $vendedor->id ? 'selected' : ''); ?>>
                                        <?php echo e($vendedor->persona->name ?? $vendedor->email); ?> <?php echo e($vendedor->persona->surnames ?? ''); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        
                        <div class="col-12 mt-4"><h6 class="text-primary border-bottom pb-2"><i class="bi bi-card-text me-2"></i>Descripción y Notas</h6></div>

                        <div class="col-12">
                            <label class="form-label">Descripción del negocio</label>
                            <textarea class="form-control form-control-sm" name="descripcion" rows="3"><?php echo e(old('descripcion', $oportunidad->descripcion)); ?></textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Observaciones internas</label>
                            <textarea class="form-control form-control-sm" name="observaciones" rows="2"><?php echo e(old('observaciones', $oportunidad->observaciones)); ?></textarea>
                        </div>

                        
                        <div id="seccion_productos" class="col-12 mt-3" style="display: none;">
                            <p class="text-secondary mb-3 small text-uppercase fw-bold"><i class="bi bi-box-seam me-1"></i>Productos de Interés</p>

                            <div class="table-responsive">
                                <table class="table table-sm table-bordered tabla-items mb-0" id="tablaProductos">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th style="width: 70px;">Cant.</th>
                                            <th style="width: 110px;">P. Unit.</th>
                                            <th style="width: 110px;">Subtotal</th>
                                            <th>Notas</th>
                                            <th style="width: 35px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody-productos"></tbody>
                                    <tfoot id="tfoot-totales" style="display: none;">
                                        <tr>
                                            <td colspan="3" class="text-end fw-bold">Total Productos:</td>
                                            <td class="item-subtotal text-primary" id="total-productos">S/ 0.00</td>
                                            <td colspan="2"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div id="sinItems" class="text-center text-muted py-4">
                                <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                <p class="mb-0 mt-2">No hay productos. Haga clic en <strong>"Agregar Producto"</strong> para comenzar.</p>
                            </div>

                            <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="btn-agregar-producto">
                                <i class="bi bi-plus-circle me-1"></i>Agregar Producto
                            </button>
                        </div>

                        <?php if($oportunidad->etapa === 'perdida'): ?>
                        
                        <div class="col-12 mt-4"><h6 class="text-danger border-bottom pb-2"><i class="bi bi-x-circle me-2"></i>Motivo de Pérdida</h6></div>

                        <div class="col-md-4">
                            <label class="form-label">Motivo</label>
                            <input type="text" class="form-control form-control-sm bg-light" value="<?php echo e($oportunidad->motivo_perdida); ?>" readonly>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Competidor Ganador</label>
                            <input type="text" class="form-control form-control-sm bg-light" value="<?php echo e($oportunidad->competidor_ganador); ?>" readonly>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Detalle de Pérdida</label>
                            <textarea class="form-control form-control-sm bg-light" rows="2" readonly><?php echo e($oportunidad->detalle_perdida); ?></textarea>
                        </div>
                        <small class="text-muted"><i class="bi bi-lock me-1"></i>Estos datos se registran al marcar como perdida desde el detalle</small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php
                $redirectTo = request('redirect_to', 'show');
                $cancelUrl = $redirectTo === 'index'
                    ? route('admin.crm.oportunidades.index')
                    : route('admin.crm.oportunidades.show', $oportunidad);
            ?>

            
            <div class="pt-3 pb-5 d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    <i class="bi bi-clock-history me-1"></i>
                    Creado: <?php echo e($oportunidad->created_at->format('d/m/Y H:i')); ?> | Actualizado: <?php echo e($oportunidad->updated_at->format('d/m/Y H:i')); ?>

                </small>
                <div class="d-flex gap-2">
                    <a href="<?php echo e($cancelUrl); ?>" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-x-circle me-2"></i>Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary px-5 text-white">
                        <i class="bi bi-save me-2"></i>Guardar Cambios
                    </button>
                </div>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('js'); ?>
<script>
$(document).ready(function() {

    // ==================== DATOS DEL SERVIDOR ====================
    const tipos = <?php echo json_encode($tipos, 15, 512) ?>;
    const productosDB = <?php echo json_encode($productos, 15, 512) ?>;
    var productosExistentes = <?php echo json_encode($productosExistentesJson, 15, 512) ?>;
    var contadorItems = 0;

    // ==================== TOGGLE SECCIONES ====================
    $('#tipo_oportunidad').on('change', function() {
        var valor = $(this).val();
        $('#seccion_servicio').toggle(valor === 'servicio' || valor === 'mixto');
        $('#seccion_productos').toggle(valor === 'producto' || valor === 'mixto');
    }).trigger('change');

    // Toggle visita técnica
    $('#requiere_visita').on('change', function() {
        var checked = $(this).is(':checked');
        $('#campo_fecha_visita').toggle(checked);
        $('#campo_resultado_visita').toggle(checked);
    }).trigger('change');

    // ==================== CÁLCULOS ====================
    function calcularSubtotalFila(idx) {
        var fila = $('#fila-' + idx);
        var cant = parseFloat(fila.find('.input-cantidad').val()) || 0;
        var precio = parseFloat(fila.find('.input-precio').val()) || 0;
        var subtotal = cant * precio;
        $('#subtotal-' + idx).text('S/ ' + subtotal.toFixed(2));
        return subtotal;
    }

    function calcularTotales() {
        var total = 0;
        $('.item-fila').each(function() {
            var idx = $(this).attr('id').replace('fila-', '');
            total += calcularSubtotalFila(idx);
        });

        $('#total-productos').text('S/ ' + total.toFixed(2));
        $('#tfoot-totales').toggle($('.item-fila').length > 0);
        $('#sinItems').toggle($('.item-fila').length === 0);

        if (total > 0) {
            $('#monto_estimado').val(total.toFixed(2));
            $('#monto-auto-msg').show();
        } else {
            $('#monto-auto-msg').hide();
        }
    }

    $(document).on('input', '.input-cantidad, .input-precio', function() {
        var idx = $(this).closest('tr').attr('id').replace('fila-', '');
        calcularSubtotalFila(idx);
        calcularTotales();
    });

    // ==================== SELECT2 HELPERS ====================
    function initSelect2Fila(idx) {
        var fila = $('#fila-' + idx);
        fila.find('.sel-tipo, .sel-subcategoria, .sel-producto').each(function() {
            if ($(this).hasClass('select2-hidden-accessible')) {
                $(this).select2('destroy');
            }
            $(this).select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: $(this).find('option:first').text()
            });
        });
    }

    function reinitSelect2(selector) {
        var el = $(selector);
        if (el.hasClass('select2-hidden-accessible')) {
            el.select2('destroy');
        }
        el.select2({
            theme: 'bootstrap-5',
            width: '100%',
            placeholder: el.find('option:first').text()
        });
    }

    // ==================== AGREGAR FILA ====================
    function agregarFila(datos) {
        datos = datos || {};
        var i = contadorItems++;
        $('#sinItems').hide();
        $('#tfoot-totales').show();

        var optTipos = '<option value="">-- Tipo --</option>';
        tipos.forEach(function(t) {
            var sel = (datos.tipo_id && datos.tipo_id == t.id) ? 'selected' : '';
            optTipos += '<option value="' + t.id + '" ' + sel + '>' + t.name + '</option>';
        });

        var celdaProducto = '<div class="cascada-selects">' +
            '<div class="sel-wrap"><select class="form-select form-select-sm sel-tipo" data-index="' + i + '">' + optTipos + '</select></div>' +
            '<div class="sel-wrap"><select class="form-select form-select-sm sel-subcategoria" data-index="' + i + '" disabled><option value="">-- Categoría --</option></select></div>' +
            '<div class="sel-wrap"><select class="form-select form-select-sm sel-producto" data-index="' + i + '" disabled><option value="">-- Producto --</option></select></div>' +
            '</div>' +
            '<input type="hidden" name="items[' + i + '][producto_id]" class="input-producto-id" value="' + (datos.producto_id || '') + '">' +
            '<div class="producto-info" id="producto-info-' + i + '"></div>';

        var fila = '<tr id="fila-' + i + '" class="item-fila">' +
            '<td>' + celdaProducto + '</td>' +
            '<td><input type="number" name="items[' + i + '][cantidad]" class="form-control form-control-sm input-cantidad" value="' + (datos.cantidad || 1) + '" step="0.01" min="0.01" required></td>' +
            '<td><div class="input-group input-group-sm"><span class="input-group-text" style="font-size:0.7rem;">S/</span><input type="number" name="items[' + i + '][precio_unitario]" class="form-control form-control-sm input-precio" value="' + (datos.precio || 0) + '" step="0.01" min="0" readonly></div></td>' +
            '<td class="item-subtotal text-end pt-2" id="subtotal-' + i + '">S/ 0.00</td>' +
            '<td><input type="text" name="items[' + i + '][notas]" class="form-control form-control-sm" value="' + (datos.notas || '') + '" placeholder="Notas..."></td>' +
            '<td class="text-center pt-2"><button type="button" class="btn btn-outline-danger btn-quitar" onclick="quitarFila(' + i + ')"><i class="bi bi-trash"></i></button></td>' +
        '</tr>';

        $('#tbody-productos').append(fila);
        initSelect2Fila(i);

        if (datos.producto_id) {
            cargarCascadaCompleta(i, datos.tipo_id, datos.categorie_id, datos.producto_id, datos.precio);
        }

        calcularSubtotalFila(i);
        calcularTotales();
    }

    // ==================== CASCADA COMPLETA (PRE-CARGA) ====================
    function cargarCascadaCompleta(idx, tipoId, categorieId, productoId, precio) {
        var tipo = null;
        for (var t = 0; t < tipos.length; t++) {
            if (tipos[t].id == tipoId) { tipo = tipos[t]; break; }
        }

        var selSubcat = $('.sel-subcategoria[data-index="' + idx + '"]');
        var selProducto = $('.sel-producto[data-index="' + idx + '"]');

        if (tipo && tipo.categories) {
            var opts = '<option value="">-- Categoría --</option>';
            tipo.categories.forEach(function(c) {
                var sel = (c.id == categorieId) ? 'selected' : '';
                opts += '<option value="' + c.id + '" ' + sel + '>' + c.name + '</option>';
            });
            selSubcat.html(opts).prop('disabled', false);
        }

        var prods = productosDB.filter(function(p) { return p.categorie_id == categorieId; });
        if (prods.length > 0) {
            var opts2 = '<option value="">-- Producto --</option>';
            prods.forEach(function(p) {
                var sel = (p.id == productoId) ? 'selected' : '';
                var marca = p.marca ? ' (' + p.marca.name + ')' : '';
                var precioTxt = p.precio ? ' - S/ ' + parseFloat(p.precio).toFixed(2) : '';
                opts2 += '<option value="' + p.id + '" data-precio="' + (p.precio || 0) + '" data-nombre="' + p.name + '" data-marca="' + (p.marca ? p.marca.name : '') + '" ' + sel + '>' + (p.codigo ? p.codigo + ' - ' : '') + p.name + marca + precioTxt + '</option>';
            });
            selProducto.html(opts2).prop('disabled', false);
        }

        var prod = productosDB.find(function(p) { return p.id == productoId; });
        if (prod) {
            var marca = prod.marca ? prod.marca.name : '';
            var info = '<i class="bi bi-check-circle text-success me-1"></i><strong>' + prod.name + '</strong>';
            if (marca) info += ' — ' + marca;
            $('#producto-info-' + idx).html(info);
            $('#fila-' + idx).find('.input-precio').val(parseFloat(precio || prod.precio || 0).toFixed(2));
        }

        reinitSelect2('.sel-subcategoria[data-index="' + idx + '"]');
        reinitSelect2('.sel-producto[data-index="' + idx + '"]');
    }

    // Botones
    $('#btn-agregar-producto').on('click', function() { agregarFila(); });
    window.quitarFila = function(i) { $('#fila-' + i).remove(); calcularTotales(); };

    // ==================== CASCADA: TIPO → CATEGORÍA ====================
    $(document).on('change', '.sel-tipo', function() {
        var idx = $(this).data('index');
        var tipoId = parseInt($(this).val());
        var selSubcat = $('.sel-subcategoria[data-index="' + idx + '"]');
        var selProducto = $('.sel-producto[data-index="' + idx + '"]');

        selProducto.html('<option value="">-- Producto --</option>').prop('disabled', true);
        reinitSelect2('.sel-producto[data-index="' + idx + '"]');
        $('#fila-' + idx).find('.input-producto-id').val('');
        $('#fila-' + idx).find('.input-precio').val(0);
        $('#producto-info-' + idx).html('');

        if (!tipoId) {
            selSubcat.html('<option value="">-- Categoría --</option>').prop('disabled', true);
            reinitSelect2('.sel-subcategoria[data-index="' + idx + '"]');
            calcularTotales();
            return;
        }

        var tipo = null;
        for (var t = 0; t < tipos.length; t++) {
            if (tipos[t].id === tipoId) { tipo = tipos[t]; break; }
        }

        if (!tipo || !tipo.categories || tipo.categories.length === 0) {
            selSubcat.html('<option value="">Sin categorías</option>').prop('disabled', true);
            reinitSelect2('.sel-subcategoria[data-index="' + idx + '"]');
            return;
        }

        var opts = '<option value="">-- Categoría --</option>';
        tipo.categories.forEach(function(c) {
            opts += '<option value="' + c.id + '">' + c.name + '</option>';
        });
        selSubcat.html(opts).prop('disabled', false);
        reinitSelect2('.sel-subcategoria[data-index="' + idx + '"]');
        calcularTotales();
    });

    // ==================== CASCADA: CATEGORÍA → PRODUCTO ====================
    $(document).on('change', '.sel-subcategoria', function() {
        var idx = $(this).data('index');
        var categoriaId = parseInt($(this).val());
        var selProducto = $('.sel-producto[data-index="' + idx + '"]');

        $('#fila-' + idx).find('.input-producto-id').val('');
        $('#fila-' + idx).find('.input-precio').val(0);
        $('#producto-info-' + idx).html('');

        if (!categoriaId) {
            selProducto.html('<option value="">-- Producto --</option>').prop('disabled', true);
            reinitSelect2('.sel-producto[data-index="' + idx + '"]');
            calcularTotales();
            return;
        }

        var prods = productosDB.filter(function(p) { return p.categorie_id === categoriaId; });

        if (prods.length === 0) {
            selProducto.html('<option value="">Sin productos</option>').prop('disabled', true);
            reinitSelect2('.sel-producto[data-index="' + idx + '"]');
            return;
        }

        var opts = '<option value="">-- Producto --</option>';
        prods.forEach(function(p) {
            var marca = p.marca ? ' (' + p.marca.name + ')' : '';
            var precio = p.precio ? ' - S/ ' + parseFloat(p.precio).toFixed(2) : '';
            opts += '<option value="' + p.id + '" data-precio="' + (p.precio || 0) + '" data-nombre="' + p.name + '" data-marca="' + (p.marca ? p.marca.name : '') + '">' + (p.codigo ? p.codigo + ' - ' : '') + p.name + marca + precio + '</option>';
        });
        selProducto.html(opts).prop('disabled', false);
        reinitSelect2('.sel-producto[data-index="' + idx + '"]');
        calcularTotales();
    });

    // ==================== SELECCIÓN DE PRODUCTO ====================
    $(document).on('change', '.sel-producto', function() {
        var idx = $(this).data('index');
        var fila = $('#fila-' + idx);
        var selected = $(this).find(':selected');
        var productoId = $(this).val();

        if (productoId) {
            fila.find('.input-producto-id').val(productoId);
            fila.find('.input-precio').val(parseFloat(selected.data('precio') || 0).toFixed(2));

            var marca = selected.data('marca');
            var info = '<i class="bi bi-check-circle text-success me-1"></i><strong>' + selected.data('nombre') + '</strong>';
            if (marca) info += ' — ' + marca;
            $('#producto-info-' + idx).html(info);
        } else {
            fila.find('.input-producto-id').val('');
            fila.find('.input-precio').val(0);
            $('#producto-info-' + idx).html('');
        }

        calcularSubtotalFila(idx);
        calcularTotales();
    });

    // ==================== PRE-CARGAR PRODUCTOS EXISTENTES ====================
    for (var j = 0; j < productosExistentes.length; j++) {
        var item = productosExistentes[j];
        agregarFila(item);
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/CRM/oportunidades/edit.blade.php ENDPATH**/ ?>