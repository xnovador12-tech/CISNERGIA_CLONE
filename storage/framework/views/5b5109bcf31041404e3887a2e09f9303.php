<?php $__env->startSection('title', 'Nueva Actividad'); ?>

<?php $__env->startSection('content'); ?>
    <!-- Encabezado -->
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">NUEVA ACTIVIDAD</h1>
                <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(route('admin-dashboard.index')); ?>">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(route('admin.crm.actividades.index')); ?>">Actividades</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Nueva</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <form action="<?php echo e(route('admin.crm.actividades.store')); ?>" method="POST" class="needs-validation" novalidate>
        <?php echo csrf_field(); ?>
        <div class="container-fluid">
            <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up">
                <div class="card-body">

                    
                    <div class="card border-0 rounded-0 border-start border-3 border-info mb-4" style="box-shadow: rgba(17, 17, 26, 0.1) 0px 1px 0px; background-color: #f6f6f6">
                        <div class="card-body py-2">
                            <i class="bi bi-info-circle text-info me-2"></i>
                            <small class="text-muted">Los campos con <span class="text-danger">*</span> son obligatorios.</small>
                        </div>
                    </div>

                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
                        </div>
                    <?php endif; ?>

                    <div class="row g-3">
                        
                        <div class="col-12">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Información de la Actividad</p>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Tipo de Actividad <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="tipo" id="tipo" required data-placeholder="Seleccionar...">
                                <option value="">Seleccionar...</option>
                                <option value="llamada" <?php echo e(old('tipo') == 'llamada' ? 'selected' : ''); ?>>📞 Llamada</option>
                                <option value="email" <?php echo e(old('tipo') == 'email' ? 'selected' : ''); ?>>📧 Email</option>
                                <option value="reunion" <?php echo e(old('tipo') == 'reunion' ? 'selected' : ''); ?>>👥 Reunión</option>
                                <option value="visita_tecnica" <?php echo e(old('tipo') == 'visita_tecnica' ? 'selected' : ''); ?>>🏗️ Visita Técnica</option>
                                <option value="whatsapp" <?php echo e(old('tipo') == 'whatsapp' ? 'selected' : ''); ?>>💬 WhatsApp</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Prioridad</label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="prioridad" data-placeholder="Seleccionar...">
                                <option value="baja" <?php echo e(old('prioridad') == 'baja' ? 'selected' : ''); ?>>🟢 Baja</option>
                                <option value="media" <?php echo e(old('prioridad', 'media') == 'media' ? 'selected' : ''); ?>>🟡 Media</option>
                                <option value="alta" <?php echo e(old('prioridad') == 'alta' ? 'selected' : ''); ?>>🔴 Alta</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Asignar a <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="user_id" required data-placeholder="Seleccionar responsable...">
                                <?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($usuario->id); ?>" <?php echo e(old('user_id', auth()->id()) == $usuario->id ? 'selected' : ''); ?>>
                                        <?php echo e($usuario->persona?->name ?? $usuario->email); ?> <?php echo e($usuario->persona?->surnames ?? ''); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Título <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm <?php $__errorArgs = ['titulo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="titulo" value="<?php echo e(old('titulo')); ?>" required placeholder="Ej: Reunión de presentación de propuesta">
                            <?php $__errorArgs = ['titulo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="col-12 mt-3">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Programación</p>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Fecha y Hora <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control form-control-sm <?php $__errorArgs = ['fecha_programada'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="fecha_programada" value="<?php echo e(old('fecha_programada')); ?>" required>
                            <?php $__errorArgs = ['fecha_programada'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Recordatorio</label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="recordatorio_minutos" data-placeholder="Sin recordatorio">
                                <option value="">Sin recordatorio</option>
                                <option value="15" <?php echo e(old('recordatorio_minutos') == '15' ? 'selected' : ''); ?>>15 minutos antes</option>
                                <option value="30" <?php echo e(old('recordatorio_minutos') == '30' ? 'selected' : ''); ?>>30 minutos antes</option>
                                <option value="60" <?php echo e(old('recordatorio_minutos') == '60' ? 'selected' : ''); ?>>1 hora antes</option>
                                <option value="1440" <?php echo e(old('recordatorio_minutos') == '1440' ? 'selected' : ''); ?>>1 día antes</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Ubicación</label>
                            <input type="text" class="form-control form-control-sm" name="ubicacion" value="<?php echo e(old('ubicacion')); ?>" placeholder="Ej: Oficina principal, Google Meet, etc.">
                        </div>

                        
                        <div class="col-12 mt-3">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Relacionar con Entidad (opcional)</p>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tipo de Entidad</label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="activable_type" id="activable_type" data-placeholder="Ninguna">
                                <option value="">Ninguna</option>
                                <option value="App\Models\Prospecto" <?php echo e(old('activable_type', $entidadTipo) == 'App\Models\Prospecto' ? 'selected' : ''); ?>>Prospecto</option>
                                <option value="App\Models\Oportunidad" <?php echo e(old('activable_type', $entidadTipo) == 'App\Models\Oportunidad' ? 'selected' : ''); ?>>Oportunidad</option>
                                <option value="App\Models\Cliente" <?php echo e(old('activable_type', $entidadTipo) == 'App\Models\Cliente' ? 'selected' : ''); ?>>Cliente</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Entidad</label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="activable_id" id="activable_id" data-placeholder="Seleccionar...">
                                <option value="">Seleccionar...</option>
                            </select>
                        </div>

                        
                        <div class="col-12 mt-3">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Descripción</p>
                        </div>

                        <div class="col-12">
                            <textarea class="form-control form-control-sm" name="descripcion" rows="3" placeholder="Detalles adicionales de la actividad..."><?php echo e(old('descripcion')); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="pt-3 pb-5 d-flex justify-content-end gap-2">
                <a href="<?php echo e(route('admin.crm.actividades.index')); ?>" class="btn btn-outline-secondary px-4">
                    <i class="bi bi-x-circle me-2"></i>Cancelar
                </a>
                <button type="submit" class="btn btn-primary px-5 text-white">
                    <i class="bi bi-save me-2"></i>Registrar Actividad
                </button>
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
$(document).ready(function() {
    const prospectos   = <?php echo json_encode($prospectos, 15, 512) ?>;
    const oportunidades = <?php echo json_encode($oportunidades, 15, 512) ?>;
    const clientes     = <?php echo json_encode($clientes, 15, 512) ?>;
    const entidadIdInicial = "<?php echo e(old('activable_id', $entidadId ?? '')); ?>";

    // Cambiar opciones según tipo de entidad
    $('#activable_type').on('change', function() {
        const tipo = $(this).val();
        const selectEntidad = $('#activable_id');

        // Destruir select2 antes de modificar opciones
        if (selectEntidad.hasClass('select2-hidden-accessible')) {
            selectEntidad.select2('destroy');
        }

        selectEntidad.empty().append('<option value="">Seleccionar...</option>');

        if (tipo === 'App\\Models\\Prospecto') {
            prospectos.forEach(p => {
                selectEntidad.append(`<option value="${p.id}">${p.nombre} ${p.apellidos ?? ''}</option>`);
            });
        } else if (tipo === 'App\\Models\\Oportunidad') {
            oportunidades.forEach(o => {
                const nombre = o.prospecto ? o.prospecto.nombre : 'Sin nombre';
                selectEntidad.append(`<option value="${o.id}">${o.codigo} - ${nombre}</option>`);
            });
        } else if (tipo === 'App\\Models\\Cliente') {
            clientes.forEach(c => {
                const nombre = c.razon_social ?? `${c.nombre} ${c.apellidos ?? ''}`.trim();
                selectEntidad.append(`<option value="${c.id}">${nombre}</option>`);
            });
        }

        if (entidadIdInicial && selectEntidad.find(`option[value="${entidadIdInicial}"]`).length) {
            selectEntidad.val(entidadIdInicial);
        }

        // Reinicializar select2
        selectEntidad.select2({
            theme: "bootstrap-5",
            width: '100%',
            placeholder: 'Seleccionar...',
            allowClear: true
        });
    });

    // Cargar inicial si hay tipo seleccionado
    if ($('#activable_type').val()) {
        $('#activable_type').trigger('change');
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/CRM/actividades/create.blade.php ENDPATH**/ ?>