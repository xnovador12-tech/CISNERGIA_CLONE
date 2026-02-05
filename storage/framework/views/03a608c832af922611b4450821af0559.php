
<?php $__env->startSection('title', 'Editar Oportunidad'); ?>

<?php $__env->startSection('content'); ?>
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">EDITAR OPORTUNIDAD</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
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
        <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up">
            <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <span class="badge bg-secondary fs-6"><?php echo e($oportunidad->codigo); ?></span>
                <?php
                    $etapaColors = [
                        'calificacion' => 'secondary', 
                        'analisis_sitio' => 'info',
                        'propuesta_tecnica' => 'primary',
                        'negociacion' => 'warning', 
                        'contrato' => 'dark',
                        'ganada' => 'success', 
                        'perdida' => 'danger'
                    ];
                ?>
                <span class="badge bg-<?php echo e($etapaColors[$oportunidad->etapa] ?? 'secondary'); ?>"><?php echo e(ucfirst(str_replace('_', ' ', $oportunidad->etapa))); ?></span>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('admin.crm.oportunidades.update', $oportunidad->slug)); ?>" method="POST" class="needs-validation" novalidate>
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
                        </div>
                    <?php endif; ?>

                    <div class="row g-3">
                        
                        <div class="col-12"><h6 class="text-primary border-bottom pb-2"><i class="bi bi-info-circle me-2"></i>Información General</h6></div>

                        <div class="col-md-8">
                            <label class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['nombre'];
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

                        <div class="col-md-4">
                            <label class="form-label">Tipo de Proyecto <span class="text-danger">*</span></label>
                            <select class="form-select <?php $__errorArgs = ['tipo_proyecto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="tipo_proyecto" required>
                                <option value="residencial" <?php echo e(old('tipo_proyecto', $oportunidad->tipo_proyecto) == 'residencial' ? 'selected' : ''); ?>>Residencial</option>
                                <option value="comercial" <?php echo e(old('tipo_proyecto', $oportunidad->tipo_proyecto) == 'comercial' ? 'selected' : ''); ?>>Comercial</option>
                                <option value="industrial" <?php echo e(old('tipo_proyecto', $oportunidad->tipo_proyecto) == 'industrial' ? 'selected' : ''); ?>>Industrial</option>
                                <option value="agricola" <?php echo e(old('tipo_proyecto', $oportunidad->tipo_proyecto) == 'agricola' ? 'selected' : ''); ?>>Agrícola</option>
                                <option value="bombeo_solar" <?php echo e(old('tipo_proyecto', $oportunidad->tipo_proyecto) == 'bombeo_solar' ? 'selected' : ''); ?>>Bombeo Solar</option>
                            </select>
                            <?php $__errorArgs = ['tipo_proyecto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Prospecto</label>
                            <select class="form-select <?php $__errorArgs = ['prospecto_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="prospecto_id">
                                <option value="">Ninguno</option>
                                <?php $__currentLoopData = $prospectos ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prospecto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($prospecto->id); ?>" <?php echo e(old('prospecto_id', $oportunidad->prospecto_id) == $prospecto->id ? 'selected' : ''); ?>>
                                        <?php echo e($prospecto->codigo); ?> - <?php echo e($prospecto->nombre_completo); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['prospecto_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Cliente</label>
                            <select class="form-select <?php $__errorArgs = ['cliente_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="cliente_id">
                                <option value="">Ninguno</option>
                                <?php $__currentLoopData = $clientes ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($cliente->id); ?>" <?php echo e(old('cliente_id', $oportunidad->cliente_id) == $cliente->id ? 'selected' : ''); ?>>
                                        <?php echo e($cliente->codigo ?? ''); ?> - <?php echo e($cliente->nombre); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['cliente_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="col-12 mt-4"><h6 class="text-primary border-bottom pb-2"><i class="bi bi-sun me-2"></i>Sistema Solar</h6></div>

                        <div class="col-md-3">
                            <label class="form-label">Potencia (kW) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control <?php $__errorArgs = ['potencia_kw'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="potencia_kw" value="<?php echo e(old('potencia_kw', $oportunidad->potencia_kw)); ?>" step="0.01" required>
                            <?php $__errorArgs = ['potencia_kw'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">N° Paneles</label>
                            <input type="number" class="form-control <?php $__errorArgs = ['cantidad_paneles'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="cantidad_paneles" value="<?php echo e(old('cantidad_paneles', $oportunidad->cantidad_paneles)); ?>">
                            <?php $__errorArgs = ['cantidad_paneles'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Tipo Panel</label>
                            <select class="form-select <?php $__errorArgs = ['tipo_panel'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="tipo_panel">
                                <option value="">Seleccionar</option>
                                <option value="Monocristalino" <?php echo e(old('tipo_panel', $oportunidad->tipo_panel) == 'Monocristalino' ? 'selected' : ''); ?>>Monocristalino</option>
                                <option value="Policristalino" <?php echo e(old('tipo_panel', $oportunidad->tipo_panel) == 'Policristalino' ? 'selected' : ''); ?>>Policristalino</option>
                                <option value="Thin Film" <?php echo e(old('tipo_panel', $oportunidad->tipo_panel) == 'Thin Film' ? 'selected' : ''); ?>>Thin Film</option>
                            </select>
                            <?php $__errorArgs = ['tipo_panel'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Marca Panel</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['marca_panel'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="marca_panel" value="<?php echo e(old('marca_panel', $oportunidad->marca_panel)); ?>">
                            <?php $__errorArgs = ['marca_panel'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Tipo Inversor</label>
                            <select class="form-select <?php $__errorArgs = ['tipo_inversor'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="tipo_inversor">
                                <option value="">Seleccionar</option>
                                <option value="String" <?php echo e(old('tipo_inversor', $oportunidad->tipo_inversor) == 'String' ? 'selected' : ''); ?>>String</option>
                                <option value="Microinversor" <?php echo e(old('tipo_inversor', $oportunidad->tipo_inversor) == 'Microinversor' ? 'selected' : ''); ?>>Microinversor</option>
                                <option value="Híbrido" <?php echo e(old('tipo_inversor', $oportunidad->tipo_inversor) == 'Híbrido' ? 'selected' : ''); ?>>Híbrido</option>
                                <option value="Central" <?php echo e(old('tipo_inversor', $oportunidad->tipo_inversor) == 'Central' ? 'selected' : ''); ?>>Central</option>
                            </select>
                            <?php $__errorArgs = ['tipo_inversor'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Marca Inversor</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['marca_inversor'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="marca_inversor" value="<?php echo e(old('marca_inversor', $oportunidad->marca_inversor)); ?>">
                            <?php $__errorArgs = ['marca_inversor'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">¿Incluye Baterías?</label>
                            <select class="form-select <?php $__errorArgs = ['incluye_baterias'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="incluye_baterias">
                                <option value="0" <?php echo e(old('incluye_baterias', $oportunidad->incluye_baterias) == 0 ? 'selected' : ''); ?>>No</option>
                                <option value="1" <?php echo e(old('incluye_baterias', $oportunidad->incluye_baterias) == 1 ? 'selected' : ''); ?>>Sí</option>
                            </select>
                            <?php $__errorArgs = ['incluye_baterias'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Capacidad Baterías (kWh)</label>
                            <input type="number" class="form-control <?php $__errorArgs = ['capacidad_baterias_kwh'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="capacidad_baterias_kwh" value="<?php echo e(old('capacidad_baterias_kwh', $oportunidad->capacidad_baterias_kwh)); ?>" step="0.01">
                            <?php $__errorArgs = ['capacidad_baterias_kwh'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="col-12 mt-4"><h6 class="text-primary border-bottom pb-2"><i class="bi bi-lightning-charge me-2"></i>Producción y Ahorro Estimado</h6></div>

                        <div class="col-md-3">
                            <label class="form-label">Prod. Mensual (kWh)</label>
                            <input type="number" class="form-control <?php $__errorArgs = ['produccion_mensual_kwh'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="produccion_mensual_kwh" value="<?php echo e(old('produccion_mensual_kwh', $oportunidad->produccion_mensual_kwh)); ?>" step="0.01">
                            <?php $__errorArgs = ['produccion_mensual_kwh'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Prod. Anual (kWh)</label>
                            <input type="number" class="form-control <?php $__errorArgs = ['produccion_anual_kwh'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="produccion_anual_kwh" value="<?php echo e(old('produccion_anual_kwh', $oportunidad->produccion_anual_kwh)); ?>" step="0.01">
                            <?php $__errorArgs = ['produccion_anual_kwh'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Ahorro Mensual (S/)</label>
                            <input type="number" class="form-control <?php $__errorArgs = ['ahorro_mensual_soles'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="ahorro_mensual_soles" value="<?php echo e(old('ahorro_mensual_soles', $oportunidad->ahorro_mensual_soles)); ?>" step="0.01">
                            <?php $__errorArgs = ['ahorro_mensual_soles'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Ahorro Anual (S/)</label>
                            <input type="number" class="form-control <?php $__errorArgs = ['ahorro_anual_soles'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="ahorro_anual_soles" value="<?php echo e(old('ahorro_anual_soles', $oportunidad->ahorro_anual_soles)); ?>" step="0.01">
                            <?php $__errorArgs = ['ahorro_anual_soles'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Retorno Inversión (años)</label>
                            <input type="number" class="form-control <?php $__errorArgs = ['retorno_inversion_anos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="retorno_inversion_anos" value="<?php echo e(old('retorno_inversion_anos', $oportunidad->retorno_inversion_anos)); ?>" step="0.1">
                            <?php $__errorArgs = ['retorno_inversion_anos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="col-12 mt-4"><h6 class="text-primary border-bottom pb-2"><i class="bi bi-currency-dollar me-2"></i>Pipeline y Valores</h6></div>

                        <div class="col-md-3">
                            <label class="form-label">Monto Estimado (S/) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control <?php $__errorArgs = ['monto_estimado'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="monto_estimado" value="<?php echo e(old('monto_estimado', $oportunidad->monto_estimado)); ?>" step="0.01" required>
                            <?php $__errorArgs = ['monto_estimado'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Monto Final (S/)</label>
                            <input type="number" class="form-control <?php $__errorArgs = ['monto_final'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="monto_final" value="<?php echo e(old('monto_final', $oportunidad->monto_final)); ?>" step="0.01">
                            <?php $__errorArgs = ['monto_final'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Etapa <span class="text-danger">*</span></label>
                            <select class="form-select <?php $__errorArgs = ['etapa'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="etapa" required>
                                <option value="calificacion" <?php echo e(old('etapa', $oportunidad->etapa) == 'calificacion' ? 'selected' : ''); ?>>Calificación</option>
                                <option value="analisis_sitio" <?php echo e(old('etapa', $oportunidad->etapa) == 'analisis_sitio' ? 'selected' : ''); ?>>Análisis de Sitio</option>
                                <option value="propuesta_tecnica" <?php echo e(old('etapa', $oportunidad->etapa) == 'propuesta_tecnica' ? 'selected' : ''); ?>>Propuesta Técnica</option>
                                <option value="negociacion" <?php echo e(old('etapa', $oportunidad->etapa) == 'negociacion' ? 'selected' : ''); ?>>Negociación</option>
                                <option value="contrato" <?php echo e(old('etapa', $oportunidad->etapa) == 'contrato' ? 'selected' : ''); ?>>Contrato</option>
                                <option value="ganada" <?php echo e(old('etapa', $oportunidad->etapa) == 'ganada' ? 'selected' : ''); ?>>Ganada</option>
                                <option value="perdida" <?php echo e(old('etapa', $oportunidad->etapa) == 'perdida' ? 'selected' : ''); ?>>Perdida</option>
                            </select>
                            <?php $__errorArgs = ['etapa'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Probabilidad (%)</label>
                            <input type="number" class="form-control <?php $__errorArgs = ['probabilidad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="probabilidad" value="<?php echo e(old('probabilidad', $oportunidad->probabilidad)); ?>" min="0" max="100">
                            <?php $__errorArgs = ['probabilidad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="col-12 mt-4"><h6 class="text-primary border-bottom pb-2"><i class="bi bi-calendar me-2"></i>Fechas</h6></div>

                        <div class="col-md-3">
                            <label class="form-label">Fecha Cierre Estimada</label>
                            <input type="date" class="form-control <?php $__errorArgs = ['fecha_cierre_estimada'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="fecha_cierre_estimada" 
                                   value="<?php echo e(old('fecha_cierre_estimada', $oportunidad->fecha_cierre_estimada?->format('Y-m-d'))); ?>">
                            <?php $__errorArgs = ['fecha_cierre_estimada'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Fecha Cierre Real</label>
                            <input type="date" class="form-control <?php $__errorArgs = ['fecha_cierre_real'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="fecha_cierre_real" 
                                   value="<?php echo e(old('fecha_cierre_real', $oportunidad->fecha_cierre_real?->format('Y-m-d'))); ?>">
                            <?php $__errorArgs = ['fecha_cierre_real'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Fecha Instalación Estimada</label>
                            <input type="date" class="form-control <?php $__errorArgs = ['fecha_instalacion_estimada'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="fecha_instalacion_estimada" 
                                   value="<?php echo e(old('fecha_instalacion_estimada', $oportunidad->fecha_instalacion_estimada?->format('Y-m-d'))); ?>">
                            <?php $__errorArgs = ['fecha_instalacion_estimada'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="col-12 mt-4"><h6 class="text-primary border-bottom pb-2"><i class="bi bi-people me-2"></i>Asignación</h6></div>

                        <div class="col-md-4">
                            <label class="form-label">Vendedor Asignado</label>
                            <select class="form-select <?php $__errorArgs = ['user_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="user_id">
                                <option value="">Sin asignar</option>
                                <?php $__currentLoopData = $vendedores ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendedor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($vendedor->id); ?>" <?php echo e(old('user_id', $oportunidad->user_id) == $vendedor->id ? 'selected' : ''); ?>>
                                        <?php echo e($vendedor->persona->name ?? $vendedor->email); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['user_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Técnico Asignado</label>
                            <select class="form-select <?php $__errorArgs = ['tecnico_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="tecnico_id">
                                <option value="">Sin asignar</option>
                                <?php $__currentLoopData = $tecnicos ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tecnico): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($tecnico->id); ?>" <?php echo e(old('tecnico_id', $oportunidad->tecnico_id) == $tecnico->id ? 'selected' : ''); ?>>
                                        <?php echo e($tecnico->persona->name ?? $tecnico->email); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['tecnico_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Sede</label>
                            <select class="form-select <?php $__errorArgs = ['sede_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="sede_id">
                                <option value="">Sin asignar</option>
                                <?php $__currentLoopData = $sedes ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sede): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($sede->id); ?>" <?php echo e(old('sede_id', $oportunidad->sede_id) == $sede->id ? 'selected' : ''); ?>>
                                        <?php echo e($sede->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['sede_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="col-12 mt-4"><h6 class="text-primary border-bottom pb-2"><i class="bi bi-card-text me-2"></i>Notas</h6></div>

                        <div class="col-md-6">
                            <label class="form-label">Observaciones</label>
                            <textarea class="form-control <?php $__errorArgs = ['observaciones'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="observaciones" rows="3"><?php echo e(old('observaciones', $oportunidad->observaciones)); ?></textarea>
                            <?php $__errorArgs = ['observaciones'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Notas Técnicas</label>
                            <textarea class="form-control <?php $__errorArgs = ['notas_tecnicas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="notas_tecnicas" rows="3"><?php echo e(old('notas_tecnicas', $oportunidad->notas_tecnicas)); ?></textarea>
                            <?php $__errorArgs = ['notas_tecnicas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <?php if($oportunidad->etapa === 'perdida'): ?>
                        
                        <div class="col-12 mt-4"><h6 class="text-danger border-bottom pb-2"><i class="bi bi-x-circle me-2"></i>Motivo de Pérdida</h6></div>

                        <div class="col-md-4">
                            <label class="form-label">Motivo</label>
                            <select class="form-select <?php $__errorArgs = ['motivo_perdida'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="motivo_perdida">
                                <option value="">Seleccionar</option>
                                <option value="Precio alto" <?php echo e(old('motivo_perdida', $oportunidad->motivo_perdida) == 'Precio alto' ? 'selected' : ''); ?>>Precio alto</option>
                                <option value="Competencia" <?php echo e(old('motivo_perdida', $oportunidad->motivo_perdida) == 'Competencia' ? 'selected' : ''); ?>>Competencia</option>
                                <option value="Sin presupuesto" <?php echo e(old('motivo_perdida', $oportunidad->motivo_perdida) == 'Sin presupuesto' ? 'selected' : ''); ?>>Sin presupuesto</option>
                                <option value="Cambio de prioridades" <?php echo e(old('motivo_perdida', $oportunidad->motivo_perdida) == 'Cambio de prioridades' ? 'selected' : ''); ?>>Cambio de prioridades</option>
                                <option value="Sin respuesta" <?php echo e(old('motivo_perdida', $oportunidad->motivo_perdida) == 'Sin respuesta' ? 'selected' : ''); ?>>Sin respuesta</option>
                                <option value="Otro" <?php echo e(old('motivo_perdida', $oportunidad->motivo_perdida) == 'Otro' ? 'selected' : ''); ?>>Otro</option>
                            </select>
                            <?php $__errorArgs = ['motivo_perdida'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Competidor Ganador</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['competidor_ganador'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="competidor_ganador" value="<?php echo e(old('competidor_ganador', $oportunidad->competidor_ganador)); ?>">
                            <?php $__errorArgs = ['competidor_ganador'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Detalle de Pérdida</label>
                            <textarea class="form-control <?php $__errorArgs = ['detalle_perdida'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="detalle_perdida" rows="2"><?php echo e(old('detalle_perdida', $oportunidad->detalle_perdida)); ?></textarea>
                            <?php $__errorArgs = ['detalle_perdida'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <?php endif; ?>

                        
                        <div class="col-12 mt-4">
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="bi bi-clock-history me-1"></i>
                                    Creado: <?php echo e($oportunidad->created_at->format('d/m/Y H:i')); ?> | 
                                    Actualizado: <?php echo e($oportunidad->updated_at->format('d/m/Y H:i')); ?>

                                </small>
                                <div class="d-flex gap-2">
                                    <a href="<?php echo e(route('admin.crm.oportunidades.index')); ?>" class="btn btn-secondary">
                                        <i class="bi bi-x-circle me-2"></i>Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save me-2"></i>Actualizar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/PRINCIPAL/crm/oportunidades/edit.blade.php ENDPATH**/ ?>