
<?php $__env->startSection('title', 'Nueva Actividad'); ?>

<?php $__env->startSection('content'); ?>
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">NUEVA ACTIVIDAD</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
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

    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up">
            <div class="card-body p-4">
                <form action="<?php echo e(route('admin.crm.actividades.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    
                    <div class="row g-3">
                        
                        <div class="col-md-6">
                            <label for="tipo" class="form-label fw-bold">Tipo de Actividad <span class="text-danger">*</span></label>
                            <select name="tipo" id="tipo" class="form-select <?php $__errorArgs = ['tipo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="">Seleccionar...</option>
                                <option value="llamada" <?php echo e(old('tipo') == 'llamada' ? 'selected' : ''); ?>>📞 Llamada</option>
                                <option value="email" <?php echo e(old('tipo') == 'email' ? 'selected' : ''); ?>>📧 Email</option>
                                <option value="reunion" <?php echo e(old('tipo') == 'reunion' ? 'selected' : ''); ?>>👥 Reunión</option>
                                <option value="visita_tecnica" <?php echo e(old('tipo') == 'visita_tecnica' ? 'selected' : ''); ?>>🏗️ Visita Técnica</option>
                                <option value="videollamada" <?php echo e(old('tipo') == 'videollamada' ? 'selected' : ''); ?>>🎥 Videollamada</option>
                                <option value="whatsapp" <?php echo e(old('tipo') == 'whatsapp' ? 'selected' : ''); ?>>💬 WhatsApp</option>
                                <option value="tarea" <?php echo e(old('tipo') == 'tarea' ? 'selected' : ''); ?>>✅ Tarea</option>
                                <option value="nota" <?php echo e(old('tipo') == 'nota' ? 'selected' : ''); ?>>📝 Nota</option>
                            </select>
                            <?php $__errorArgs = ['tipo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="col-md-6">
                            <label for="estado" class="form-label fw-bold">Estado <span class="text-danger">*</span></label>
                            <select name="estado" id="estado" class="form-select <?php $__errorArgs = ['estado'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="programada" <?php echo e(old('estado', 'programada') == 'programada' ? 'selected' : ''); ?>>Programada</option>
                                <option value="en_progreso" <?php echo e(old('estado') == 'en_progreso' ? 'selected' : ''); ?>>En Progreso</option>
                                <option value="completada" <?php echo e(old('estado') == 'completada' ? 'selected' : ''); ?>>Completada</option>
                                <option value="cancelada" <?php echo e(old('estado') == 'cancelada' ? 'selected' : ''); ?>>Cancelada</option>
                                <option value="reprogramada" <?php echo e(old('estado') == 'reprogramada' ? 'selected' : ''); ?>>Reprogramada</option>
                                <option value="no_realizada" <?php echo e(old('estado') == 'no_realizada' ? 'selected' : ''); ?>>No Realizada</option>
                            </select>
                            <?php $__errorArgs = ['estado'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="col-md-12">
                            <label for="titulo" class="form-label fw-bold">Título <span class="text-danger">*</span></label>
                            <input type="text" name="titulo" id="titulo" class="form-control <?php $__errorArgs = ['titulo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('titulo')); ?>" placeholder="Ej: Reunión de presentación de propuesta" required>
                            <?php $__errorArgs = ['titulo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="col-md-12">
                            <label for="descripcion" class="form-label fw-bold">Descripción</label>
                            <textarea name="descripcion" id="descripcion" rows="4" class="form-control <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                      placeholder="Detalles adicionales de la actividad"><?php echo e(old('descripcion')); ?></textarea>
                            <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="col-md-6">
                            <label for="fecha_programada" class="form-label fw-bold">Fecha y Hora <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="fecha_programada" id="fecha_programada" 
                                   class="form-control <?php $__errorArgs = ['fecha_programada'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('fecha_programada')); ?>" required>
                            <?php $__errorArgs = ['fecha_programada'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="col-md-6">
                            <label for="duracion_minutos" class="form-label fw-bold">Duración (minutos)</label>
                            <input type="number" name="duracion_minutos" id="duracion_minutos" 
                                   class="form-control <?php $__errorArgs = ['duracion_minutos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('duracion_minutos', 30)); ?>" min="0">
                            <?php $__errorArgs = ['duracion_minutos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="col-md-6">
                            <label for="prioridad" class="form-label fw-bold">Prioridad</label>
                            <select name="prioridad" id="prioridad" class="form-select <?php $__errorArgs = ['prioridad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="baja" <?php echo e(old('prioridad') == 'baja' ? 'selected' : ''); ?>>🟢 Baja</option>
                                <option value="media" <?php echo e(old('prioridad', 'media') == 'media' ? 'selected' : ''); ?>>🟡 Media</option>
                                <option value="alta" <?php echo e(old('prioridad') == 'alta' ? 'selected' : ''); ?>>🔴 Alta</option>
                            </select>
                            <?php $__errorArgs = ['prioridad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="col-md-6">
                            <label for="user_id" class="form-label fw-bold">Asignar a <span class="text-danger">*</span></label>
                            <select name="user_id" id="user_id" class="form-select <?php $__errorArgs = ['user_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($usuario->id); ?>" <?php echo e(old('user_id', auth()->id()) == $usuario->id ? 'selected' : ''); ?>>
                                        <?php echo e($usuario->persona?->name ?? $usuario->email); ?> <?php echo e($usuario->persona?->surnames ?? ''); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['user_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="col-md-12">
                            <hr>
                            <h6 class="fw-bold mb-3">Relacionar con entidad (opcional)</h6>
                        </div>

                        <div class="col-md-6">
                            <label for="activable_type" class="form-label fw-bold">Tipo de Entidad</label>
                            <select name="activable_type" id="activable_type" class="form-select <?php $__errorArgs = ['activable_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="">Ninguna</option>
                                <option value="App\Models\Prospecto" <?php echo e(old('activable_type', $entidadTipo) == 'App\Models\Prospecto' ? 'selected' : ''); ?>>Prospecto</option>
                                <option value="App\Models\Oportunidad" <?php echo e(old('activable_type', $entidadTipo) == 'App\Models\Oportunidad' ? 'selected' : ''); ?>>Oportunidad</option>
                            </select>
                            <?php $__errorArgs = ['activable_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-6">
                            <label for="activable_id" class="form-label fw-bold">Entidad</label>
                            <select name="activable_id" id="activable_id" class="form-select <?php $__errorArgs = ['activable_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="">Seleccionar...</option>
                            </select>
                            <?php $__errorArgs = ['activable_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="col-md-12">
                            <label for="ubicacion" class="form-label fw-bold">Ubicación</label>
                            <input type="text" name="ubicacion" id="ubicacion" class="form-control <?php $__errorArgs = ['ubicacion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('ubicacion')); ?>" placeholder="Ej: Oficina principal, Google Meet, etc.">
                            <?php $__errorArgs = ['ubicacion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="col-md-6">
                            <label for="recordatorio_minutos" class="form-label fw-bold">Recordatorio (minutos antes)</label>
                            <select name="recordatorio_minutos" id="recordatorio_minutos" class="form-select <?php $__errorArgs = ['recordatorio_minutos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="">Sin recordatorio</option>
                                <option value="15" <?php echo e(old('recordatorio_minutos') == '15' ? 'selected' : ''); ?>>15 minutos</option>
                                <option value="30" <?php echo e(old('recordatorio_minutos') == '30' ? 'selected' : ''); ?>>30 minutos</option>
                                <option value="60" <?php echo e(old('recordatorio_minutos') == '60' ? 'selected' : ''); ?>>1 hora</option>
                                <option value="1440" <?php echo e(old('recordatorio_minutos') == '1440' ? 'selected' : ''); ?>>1 día</option>
                            </select>
                            <?php $__errorArgs = ['recordatorio_minutos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary text-uppercase">
                            <i class="bi bi-save me-2"></i>Guardar Actividad
                        </button>
                        <a href="<?php echo e(route('admin.crm.actividades.index')); ?>" class="btn btn-secondary text-uppercase">
                            <i class="bi bi-x-circle me-2"></i>Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
$(document).ready(function() {
    const prospectos = <?php echo json_encode($prospectos, 15, 512) ?>;
    const oportunidades = <?php echo json_encode($oportunidades, 15, 512) ?>;
    const entidadIdInicial = "<?php echo e(old('activable_id', $entidadId ?? '')); ?>";

    // Cambiar opciones según tipo de entidad
    $('#activable_type').on('change', function() {
        const tipo = $(this).val();
        const selectEntidad = $('#activable_id');
        selectEntidad.empty().append('<option value="">Seleccionar...</option>');

        if (tipo === 'App\\Models\\Prospecto') {
            prospectos.forEach(p => {
                selectEntidad.append(`<option value="${p.id}">${p.nombre}</option>`);
            });
        } else if (tipo === 'App\\Models\\Oportunidad') {
            oportunidades.forEach(o => {
                const nombre = o.prospecto ? o.prospecto.nombre : 'Sin nombre';
                selectEntidad.append(`<option value="${o.id}">${o.codigo} - ${nombre}</option>`);
            });
        }

        if (entidadIdInicial && selectEntidad.find(`option[value="${entidadIdInicial}"]`).length) {
            selectEntidad.val(entidadIdInicial);
        }
    });

    // Cargar inicial si hay tipo seleccionado
    if ($('#activable_type').val()) {
        $('#activable_type').trigger('change');
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/CRM/actividades/create.blade.php ENDPATH**/ ?>