

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

    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up">
            <div class="card-header bg-transparent">
                <h5 class="mb-0"><i class="bi bi-person-plus me-2"></i>Registrar Nuevo Prospecto</h5>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('admin.crm.prospectos.store')); ?>" method="POST" class="needs-validation" novalidate>
                    <?php echo csrf_field(); ?>

                    
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <div class="row g-3">
                        <!-- Información General -->
                        <div class="col-md-12">
                            <h6 class="text-primary border-bottom pb-2 mb-3">
                                <i class="bi bi-info-circle me-2"></i>Información General
                            </h6>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Tipo de Persona <span class="text-danger">*</span></label>
                            <select class="form-select" name="tipo_persona" id="tipo_persona" required>
                                <option value="natural" <?php echo e(old('tipo_persona') == 'natural' ? 'selected' : ''); ?>>Persona Natural</option>
                                <option value="juridica" <?php echo e(old('tipo_persona') == 'juridica' ? 'selected' : ''); ?>>Persona Jurídica</option>
                            </select>
                        </div>

                        <div class="col-md-3" id="campo_dni">
                            <label class="form-label">DNI</label>
                            <input type="text" class="form-control" name="dni" maxlength="8"
                                   value="<?php echo e(old('dni')); ?>" placeholder="12345678">
                        </div>

                        <div class="col-md-3" id="campo_ruc">
                            <label class="form-label">RUC</label>
                            <input type="text" class="form-control" name="ruc" maxlength="11"
                                   value="<?php echo e(old('ruc')); ?>" placeholder="20123456789">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nombre"
                                   value="<?php echo e(old('nombre')); ?>" required placeholder="Nombre o nombre comercial">
                        </div>

                        <div class="col-md-3" id="campo_apellidos">
                            <label class="form-label">Apellidos</label>
                            <input type="text" class="form-control" name="apellidos"
                                   value="<?php echo e(old('apellidos')); ?>" placeholder="Apellido paterno y materno">
                        </div>

                        <div class="col-md-6" id="campo_razon_social">
                            <label class="form-label">Razón Social</label>
                            <input type="text" class="form-control" name="razon_social"
                                   value="<?php echo e(old('razon_social')); ?>" placeholder="Razón social de la empresa">
                        </div>

                        <!-- Datos de Contacto -->
                        <div class="col-md-12 mt-4">
                            <h6 class="text-primary border-bottom pb-2 mb-3">
                                <i class="bi bi-telephone me-2"></i>Datos de Contacto
                            </h6>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email"
                                   value="<?php echo e(old('email')); ?>" placeholder="correo@ejemplo.com">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Teléfono Fijo</label>
                            <input type="tel" class="form-control" name="telefono"
                                   value="<?php echo e(old('telefono')); ?>" placeholder="01-1234567">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Celular</label>
                            <input type="tel" class="form-control" name="celular"
                                   value="<?php echo e(old('celular')); ?>" placeholder="987654321">
                        </div>

                        <div class="col-md-8">
                            <label class="form-label">Dirección</label>
                            <input type="text" class="form-control" name="direccion"
                                   value="<?php echo e(old('direccion')); ?>" placeholder="Av. Principal 123, Urbanización">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Distrito</label>
                            <select class="form-select" name="distrito_id">
                                <option value="">Seleccionar...</option>
                                <?php $__currentLoopData = $distritos ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $distrito): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($distrito->id); ?>" <?php echo e(old('distrito_id') == $distrito->id ? 'selected' : ''); ?>>
                                        <?php echo e($distrito->nombre); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- Clasificación -->
                        <div class="col-md-12 mt-4">
                            <h6 class="text-primary border-bottom pb-2 mb-3">
                                <i class="bi bi-tags me-2"></i>Clasificación
                            </h6>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Origen <span class="text-danger">*</span></label>
                            <select class="form-select" name="origen" required>
                                <option value="">Seleccionar...</option>
                                <?php $__currentLoopData = ['web' => 'Sitio Web', 'facebook' => 'Facebook', 'instagram' => 'Instagram', 'google_ads' => 'Google Ads', 'referido' => 'Referido', 'llamada' => 'Llamada', 'visita' => 'Visita', 'feria' => 'Feria/Evento', 'otro' => 'Otro']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key); ?>" <?php echo e(old('origen') == $key ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Segmento <span class="text-danger">*</span></label>
                            <select class="form-select" name="segmento" required>
                                <option value="">Seleccionar...</option>
                                <?php $__currentLoopData = ['residencial' => 'Residencial', 'comercial' => 'Comercial', 'industrial' => 'Industrial', 'agricola' => 'Agrícola']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key); ?>" <?php echo e(old('segmento') == $key ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Asignar a</label>
                            <select class="form-select" name="user_id">
                                <option value="">Sin asignar</option>
                                <?php $__currentLoopData = $vendedores ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendedor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($vendedor->id); ?>" <?php echo e(old('user_id') == $vendedor->id ? 'selected' : ''); ?>>
                                        <?php echo e($vendedor->persona?->name ?? $vendedor->email); ?> <?php echo e($vendedor->persona?->surnames ?? ''); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Detalle de Origen</label>
                            <input type="text" class="form-control" name="origen_detalle"
                                   value="<?php echo e(old('origen_detalle')); ?>" placeholder="Ej: Campaña de verano 2026">
                        </div>

                        <!-- Interés en Energía Solar -->
                        <div class="col-md-12 mt-4">
                            <h6 class="text-primary border-bottom pb-2 mb-3">
                                <i class="bi bi-sun me-2"></i>Interés en Energía Solar
                            </h6>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Consumo Mensual (kWh)</label>
                            <input type="number" class="form-control" name="consumo_mensual_kwh"
                                   value="<?php echo e(old('consumo_mensual_kwh')); ?>" step="0.01" placeholder="450">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Factura Mensual (S/)</label>
                            <input type="number" class="form-control" name="factura_mensual_soles"
                                   value="<?php echo e(old('factura_mensual_soles')); ?>" step="0.01" placeholder="350.00">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Área Disponible (m²)</label>
                            <input type="number" class="form-control" name="area_disponible_m2"
                                   value="<?php echo e(old('area_disponible_m2')); ?>" step="0.01" placeholder="50">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Tipo de Inmueble</label>
                            <select class="form-select" name="tipo_inmueble">
                                <option value="">Seleccionar...</option>
                                <?php $__currentLoopData = ['casa' => 'Casa', 'departamento' => 'Departamento', 'local_comercial' => 'Local Comercial', 'oficina' => 'Oficina', 'fabrica' => 'Fábrica', 'almacen' => 'Almacén', 'terreno' => 'Terreno']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key); ?>" <?php echo e(old('tipo_inmueble') == $key ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Empresa Eléctrica</label>
                            <select class="form-select" name="empresa_electrica">
                                <option value="">Seleccionar...</option>
                                <?php $__currentLoopData = ['Luz del Sur', 'Enel', 'Seal', 'Electronoroeste', 'Hidrandina', 'Electrocentro', 'Electrosur', 'Electro Oriente', 'Otro']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empresa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($empresa); ?>" <?php echo e(old('empresa_electrica') == $empresa ? 'selected' : ''); ?>><?php echo e($empresa); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Presupuesto Estimado (S/)</label>
                            <input type="number" class="form-control" name="presupuesto_estimado"
                                   value="<?php echo e(old('presupuesto_estimado')); ?>" step="0.01" placeholder="15000.00">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Nivel de Interés</label>
                            <select class="form-select" name="nivel_interes">
                                <option value="">Seleccionar...</option>
                                <?php $__currentLoopData = ['muy_alto' => 'Muy Alto', 'alto' => 'Alto', 'medio' => 'Medio', 'bajo' => 'Bajo']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key); ?>" <?php echo e(old('nivel_interes') == $key ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Urgencia</label>
                            <select class="form-select" name="urgencia">
                                <option value="">Seleccionar...</option>
                                <?php $__currentLoopData = ['inmediata' => 'Inmediata', 'corto_plazo' => 'Corto Plazo (1-3 meses)', 'mediano_plazo' => 'Mediano Plazo (3-6 meses)', 'largo_plazo' => 'Largo Plazo (+6 meses)']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key); ?>" <?php echo e(old('urgencia') == $key ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label d-block">Opciones Adicionales</label>
                            <div class="form-check form-check-inline mt-2">
                                <input class="form-check-input" type="checkbox" name="tiene_medidor_bidireccional" value="1"
                                       <?php echo e(old('tiene_medidor_bidireccional') ? 'checked' : ''); ?>>
                                <label class="form-check-label">Tiene Medidor Bidireccional</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="requiere_financiamiento" value="1"
                                       <?php echo e(old('requiere_financiamiento') ? 'checked' : ''); ?>>
                                <label class="form-check-label">Requiere Financiamiento</label>
                            </div>
                        </div>

                        <!-- Observaciones -->
                        <div class="col-md-12 mt-4">
                            <h6 class="text-primary border-bottom pb-2 mb-3">
                                <i class="bi bi-chat-text me-2"></i>Observaciones
                            </h6>
                        </div>

                        <div class="col-md-12">
                            <textarea class="form-control" name="observaciones" rows="3" placeholder="Notas adicionales sobre el prospecto..."><?php echo e(old('observaciones')); ?></textarea>
                        </div>

                        <!-- Botones -->
                        <div class="col-12 mt-4">
                            <hr>
                            <div class="d-flex justify-content-end gap-2">
                                <a href="<?php echo e(route('admin.crm.prospectos.index')); ?>" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-2"></i>Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-2"></i>Guardar Prospecto
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mostrar/ocultar campos según tipo de persona
        const tipoPersona = document.getElementById('tipo_persona');
        const campoApellidos = document.getElementById('campo_apellidos');
        const campoRazonSocial = document.getElementById('campo_razon_social');
        const campoDni = document.getElementById('campo_dni');
        const campoRuc = document.getElementById('campo_ruc');
        
        function toggleCampos() {
            if (tipoPersona.value === 'juridica') {
                campoApellidos.style.display = 'none';
                campoRazonSocial.style.display = 'block';
                campoDni.style.display = 'none';
                campoRuc.style.display = 'block';
            } else {
                campoApellidos.style.display = 'block';
                campoRazonSocial.style.display = 'none';
                campoDni.style.display = 'block';
                campoRuc.style.display = 'none';
            }
        }
        
        tipoPersona.addEventListener('change', toggleCampos);
        toggleCampos();
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/PRINCIPAL/crm/prospectos/create.blade.php ENDPATH**/ ?>