<?php $__env->startSection('title', 'Nuevo Prospecto'); ?>

<?php $__env->startSection('content'); ?>
    <!-- Encabezado -->
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">NUEVO PROSPECTO</h1>
                <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(route('admin-dashboard.index')); ?>">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(route('admin.crm.prospectos.index')); ?>">Prospectos</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Nuevo</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <form action="<?php echo e(route('admin.crm.prospectos.store')); ?>" method="POST" class="needs-validation" novalidate>
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
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Información General</p>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Tipo de Persona <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="tipo_persona" id="tipo_persona" required data-placeholder="Seleccionar...">
                                <option value="natural" <?php echo e(old('tipo_persona') == 'natural' ? 'selected' : ''); ?>>Persona Natural</option>
                                <option value="juridica" <?php echo e(old('tipo_persona') == 'juridica' ? 'selected' : ''); ?>>Persona Jurídica</option>
                            </select>
                        </div>

                        <div class="col-md-2" id="campo_dni">
                            <label class="form-label">DNI</label>
                            <input type="text" class="form-control form-control-sm" name="dni" maxlength="8" value="<?php echo e(old('dni')); ?>" placeholder="12345678">
                        </div>

                        <div class="col-md-2" id="campo_ruc">
                            <label class="form-label">RUC</label>
                            <input type="text" class="form-control form-control-sm" name="ruc" maxlength="11" value="<?php echo e(old('ruc')); ?>" placeholder="20123456789">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="nombre" id="campo_nombre_input" value="<?php echo e(old('nombre')); ?>" required placeholder="Nombre completo">
                            <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-4" id="campo_apellidos">
                            <label class="form-label">Apellidos</label>
                            <input type="text" class="form-control form-control-sm" name="apellidos" value="<?php echo e(old('apellidos')); ?>" placeholder="Apellido paterno y materno">
                        </div>

                        <div class="col-md-6" id="campo_razon_social">
                            <label class="form-label">Razón Social</label>
                            <input type="text" class="form-control form-control-sm" name="razon_social" value="<?php echo e(old('razon_social')); ?>" placeholder="Razón social de la empresa">
                        </div>

                        
                        <div class="col-12 mt-3">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Datos de Contacto</p>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control form-control-sm" name="email" value="<?php echo e(old('email')); ?>" placeholder="correo@ejemplo.com">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Celular</label>
                            <input type="tel" class="form-control form-control-sm" name="celular" value="<?php echo e(old('celular')); ?>" placeholder="987654321">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Teléfono</label>
                            <input type="tel" class="form-control form-control-sm" name="telefono" value="<?php echo e(old('telefono')); ?>" placeholder="01-1234567">
                        </div>

                        <div class="col-md-5">
                            <label class="form-label">Dirección</label>
                            <input type="text" class="form-control form-control-sm" name="direccion" value="<?php echo e(old('direccion')); ?>" placeholder="Av. Principal 123">
                        </div>

                        
                        <div class="col-md-4">
                            <label class="form-label">Departamento</label>
                            <select class="form-select form-select-sm select2_bootstrap w-100"
                                    id="select_departamento" data-placeholder="Seleccionar...">
                                <option value="">Seleccionar...</option>
                                <?php $__currentLoopData = $departamentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($dep->id); ?>"><?php echo e($dep->nombre); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Provincia</label>
                            <select class="form-select form-select-sm w-100"
                                    id="select_provincia" data-placeholder="Seleccione un departamento" disabled>
                                <option value="">Seleccione un departamento</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Distrito</label>
                            <select class="form-select form-select-sm w-100"
                                    name="distrito_id" id="select_distrito"
                                    data-placeholder="Seleccione una provincia" disabled>
                                <option value="">Seleccione una provincia</option>
                            </select>
                        </div>

                        
                        <div class="col-12 mt-3">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Clasificación</p>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Origen <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="origen" required data-placeholder="Seleccionar...">
                                <option value="">Seleccionar...</option>
                                <?php $__currentLoopData = ['sitio_web' => 'Sitio Web', 'redes_sociales' => 'Redes Sociales', 'llamada' => 'Llamada', 'referido' => 'Referido', 'otro' => 'Otro']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key); ?>" <?php echo e(old('origen') == $key ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Tipo de Interés <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="tipo_interes" required data-placeholder="Seleccionar...">
                                <option value="producto" <?php echo e(old('tipo_interes', 'producto') == 'producto' ? 'selected' : ''); ?>>Producto</option>
                                <option value="servicio" <?php echo e(old('tipo_interes') == 'servicio' ? 'selected' : ''); ?>>Servicio</option>
                                <option value="ambos" <?php echo e(old('tipo_interes') == 'ambos' ? 'selected' : ''); ?>>Ambos</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Segmento <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="segmento" required data-placeholder="Seleccionar...">
                                <option value="">Seleccionar...</option>
                                <?php $__currentLoopData = ['residencial' => 'Residencial', 'comercial' => 'Comercial', 'industrial' => 'Industrial', 'agricola' => 'Agrícola']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key); ?>" <?php echo e(old('segmento') == $key ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Asignar a</label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="user_id" data-placeholder="Sin asignar">
                                <option value="">Sin asignar</option>
                                <?php $__currentLoopData = $vendedores ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendedor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($vendedor->id); ?>" <?php echo e(old('user_id', auth()->id()) == $vendedor->id ? 'selected' : ''); ?>>
                                        <?php echo e($vendedor->persona?->name ?? $vendedor->email); ?> <?php echo e($vendedor->persona?->surnames ?? ''); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        
                        <div class="col-12 mt-3">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Seguimiento</p>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Nivel de Interés</label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="nivel_interes" data-placeholder="Sin definir">
                                <option value="">Sin definir</option>
                                <?php $__currentLoopData = ['bajo' => 'Bajo', 'medio' => 'Medio', 'alto' => 'Alto', 'muy_alto' => 'Muy Alto']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key); ?>" <?php echo e(old('nivel_interes') == $key ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Urgencia</label>
                            <select class="form-select form-select-sm select2_bootstrap w-100" name="urgencia" data-placeholder="Sin definir">
                                <option value="">Sin definir</option>
                                <?php $__currentLoopData = ['inmediata' => 'Inmediata', 'corto_plazo' => 'Corto Plazo', 'mediano_plazo' => 'Mediano Plazo', 'largo_plazo' => 'Largo Plazo']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key); ?>" <?php echo e(old('urgencia') == $key ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Próximo Contacto</label>
                            <input type="date" class="form-control form-control-sm" name="fecha_proximo_contacto"
                                   value="<?php echo e(old('fecha_proximo_contacto')); ?>">
                        </div>

                        
                        <div class="col-12 mt-3">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Observaciones</p>
                        </div>

                        <div class="col-12">
                            <textarea class="form-control form-control-sm" name="observaciones" rows="3" placeholder="Notas adicionales sobre el prospecto..."><?php echo e(old('observaciones')); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="pt-3 pb-5 d-flex justify-content-end gap-2">
                <a href="<?php echo e(route('admin.crm.prospectos.index')); ?>" class="btn btn-outline-secondary px-4">
                    <i class="bi bi-x-circle me-2"></i>Cancelar
                </a>
                <button type="submit" class="btn btn-primary px-5 text-white">
                    <i class="bi bi-save me-2"></i>Registrar Prospecto
                </button>
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
$(document).ready(function() {

    // ===== TOGGLE PERSONA NATURAL / JURÍDICA =====
    $('#tipo_persona').on('change', function() {
        var esJuridica = $(this).val() === 'juridica';
        $('#campo_apellidos').toggle(!esJuridica);
        $('#campo_razon_social').toggle(esJuridica);
        $('#campo_dni').toggle(!esJuridica);
        $('#campo_ruc').toggle(esJuridica);
        $('#campo_nombre_input').attr('placeholder', esJuridica ? 'Nombre comercial' : 'Nombre completo');
    }).trigger('change');

    // ===== UBIGEO CASCADING =====
    var urlProvincias = '<?php echo e(route("ajax.provincias")); ?>';
    var urlDistritos  = '<?php echo e(route("ajax.distritos")); ?>';

    function destroySelect2(selector) {
        if ($(selector).hasClass('select2-hidden-accessible')) {
            $(selector).select2('destroy');
        }
    }

    function initSelect2(selector, placeholder) {
        $(selector).select2({
            theme: 'bootstrap-5',
            placeholder: placeholder,
            width: '100%'
        });
    }

    function resetSelect(selector, msg) {
        destroySelect2(selector);
        $(selector).empty()
                   .append('<option value="">' + msg + '</option>')
                   .prop('disabled', true);
    }

    // Al cambiar Departamento → cargar Provincias
    // Usamos $(document).on para que funcione incluso si Select2 reinicia el elemento
    $(document).on('change', '#select_departamento', function() {
        var depId = $(this).val();

        resetSelect('#select_provincia', 'Seleccione un departamento');
        resetSelect('#select_distrito',  'Seleccione una provincia');

        if (!depId) return;

        $.getJSON(urlProvincias, { departamento_id: depId })
            .done(function(data) {
                destroySelect2('#select_provincia');
                var $prov = $('#select_provincia').empty()
                    .append('<option value="">Seleccionar...</option>');

                $.each(data, function(i, p) {
                    $prov.append('<option value="' + p.id + '">' + p.nombre + '</option>');
                });

                $prov.prop('disabled', false);
                initSelect2('#select_provincia', 'Seleccionar provincia...');
            })
            .fail(function() {
                alert('Error al cargar provincias. Intente nuevamente.');
            });
    });

    // Al cambiar Provincia → cargar Distritos (delegado en document para capturar Select2)
    $(document).on('change', '#select_provincia', function() {
        var provId = $(this).val();

        resetSelect('#select_distrito', 'Seleccione una provincia');

        if (!provId) return;

        $.getJSON(urlDistritos, { provincia_id: provId })
            .done(function(data) {
                destroySelect2('#select_distrito');
                var $dist = $('#select_distrito').empty()
                    .append('<option value="">Seleccionar...</option>');

                $.each(data, function(i, d) {
                    $dist.append('<option value="' + d.id + '">' + d.nombre + '</option>');
                });

                $dist.prop('disabled', false);
                initSelect2('#select_distrito', 'Seleccionar distrito...');
            })
            .fail(function() {
                alert('Error al cargar distritos. Intente nuevamente.');
            });
    });

});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/CRM/prospectos/create.blade.php ENDPATH**/ ?>