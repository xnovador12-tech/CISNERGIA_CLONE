
<?php $__env->startSection('title', 'Nueva Cotización'); ?>

<?php $__env->startSection('content'); ?>
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">NUEVA COTIZACIÓN</h1>
                <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(route('admin-dashboard.index')); ?>">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(route('admin.crm.cotizaciones.index')); ?>">Cotizaciones</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Nueva</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <?php if($errors->any()): ?>
        <div class="container-fluid mb-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><i class="bi bi-exclamation-triangle me-2"></i>Errores de validación:</strong>
                <ul class="mb-0 mt-2">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    <?php endif; ?>

    <div class="container-fluid">
        <form action="<?php echo e(route('admin.crm.cotizaciones.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            
            <div class="row g-4">
                
                <div class="col-lg-8">
                    
                    <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" >
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0"><i class="bi bi-link-45deg me-2"></i>Oportunidad Vinculada</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label for="oportunidad_id" class="form-label">Oportunidad <span class="text-danger">*</span></label>
                                    <select name="oportunidad_id" id="oportunidad_id" class="form-select <?php $__errorArgs = ['oportunidad_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                        <option value="">Seleccione una oportunidad...</option>
                                        <?php $__currentLoopData = $oportunidades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $oportunidad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($oportunidad->id); ?>" 
                                                    <?php echo e(old('oportunidad_id', $oportunidadId) == $oportunidad->id ? 'selected' : ''); ?>

                                                    data-potencia="<?php echo e($oportunidad->potencia_kw); ?>"
                                                    data-paneles="<?php echo e($oportunidad->cantidad_paneles); ?>"
                                                    data-monto="<?php echo e($oportunidad->monto_estimado); ?>">
                                                <?php echo e($oportunidad->codigo); ?> - <?php echo e($oportunidad->nombre); ?> 
                                                <?php if($oportunidad->prospecto): ?>
                                                    (<?php echo e($oportunidad->prospecto->nombre_completo); ?>)
                                                <?php endif; ?>
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['oportunidad_id'];
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
                                <div class="col-md-4">
                                    <label for="vigencia_dias" class="form-label">Vigencia (días) <span class="text-danger">*</span></label>
                                    <select name="vigencia_dias" id="vigencia_dias" class="form-select <?php $__errorArgs = ['vigencia_dias'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                        <option value="15" <?php echo e(old('vigencia_dias') == 15 ? 'selected' : ''); ?>>15 días</option>
                                        <option value="30" <?php echo e(old('vigencia_dias', 30) == 30 ? 'selected' : ''); ?>>30 días</option>
                                        <option value="45" <?php echo e(old('vigencia_dias') == 45 ? 'selected' : ''); ?>>45 días</option>
                                        <option value="60" <?php echo e(old('vigencia_dias') == 60 ? 'selected' : ''); ?>>60 días</option>
                                        <option value="90" <?php echo e(old('vigencia_dias') == 90 ? 'selected' : ''); ?>>90 días</option>
                                    </select>
                                    <?php $__errorArgs = ['vigencia_dias'];
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
                        </div>
                    </div>

                    
                    <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" >
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0"><i class="bi bi-sun me-2"></i>Paneles Solares</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label for="potencia_kw" class="form-label">Potencia Total (kW) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="potencia_kw" id="potencia_kw" 
                                           class="form-control <?php $__errorArgs = ['potencia_kw'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           value="<?php echo e(old('potencia_kw')); ?>" required>
                                    <?php $__errorArgs = ['potencia_kw'];
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
                                <div class="col-md-3">
                                    <label for="cantidad_paneles" class="form-label">Cantidad Paneles <span class="text-danger">*</span></label>
                                    <input type="number" name="cantidad_paneles" id="cantidad_paneles" 
                                           class="form-control <?php $__errorArgs = ['cantidad_paneles'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           value="<?php echo e(old('cantidad_paneles')); ?>" required min="1">
                                    <?php $__errorArgs = ['cantidad_paneles'];
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
                                <div class="col-md-3">
                                    <label for="potencia_panel_w" class="form-label">Potencia/Panel (W) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="potencia_panel_w" id="potencia_panel_w" 
                                           class="form-control <?php $__errorArgs = ['potencia_panel_w'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           value="<?php echo e(old('potencia_panel_w', 550)); ?>" required>
                                    <?php $__errorArgs = ['potencia_panel_w'];
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
                                <div class="col-md-3">
                                    <label for="marca_panel" class="form-label">Marca Panel <span class="text-danger">*</span></label>
                                    <select name="marca_panel" id="marca_panel" class="form-select <?php $__errorArgs = ['marca_panel'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                        <option value="">Seleccione...</option>
                                        <option value="Jinko Solar" <?php echo e(old('marca_panel') == 'Jinko Solar' ? 'selected' : ''); ?>>Jinko Solar</option>
                                        <option value="Trina Solar" <?php echo e(old('marca_panel') == 'Trina Solar' ? 'selected' : ''); ?>>Trina Solar</option>
                                        <option value="Canadian Solar" <?php echo e(old('marca_panel') == 'Canadian Solar' ? 'selected' : ''); ?>>Canadian Solar</option>
                                        <option value="LONGi" <?php echo e(old('marca_panel') == 'LONGi' ? 'selected' : ''); ?>>LONGi</option>
                                        <option value="JA Solar" <?php echo e(old('marca_panel') == 'JA Solar' ? 'selected' : ''); ?>>JA Solar</option>
                                        <option value="Risen" <?php echo e(old('marca_panel') == 'Risen' ? 'selected' : ''); ?>>Risen</option>
                                    </select>
                                    <?php $__errorArgs = ['marca_panel'];
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
                                    <label for="modelo_panel" class="form-label">Modelo Panel</label>
                                    <input type="text" name="modelo_panel" id="modelo_panel" 
                                           class="form-control <?php $__errorArgs = ['modelo_panel'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           value="<?php echo e(old('modelo_panel')); ?>" placeholder="Ej: Tiger Neo N-type 550W">
                                    <?php $__errorArgs = ['modelo_panel'];
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
                        </div>
                    </div>

                    
                    <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" >
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0"><i class="bi bi-lightning-charge me-2"></i>Inversor</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="marca_inversor" class="form-label">Marca Inversor <span class="text-danger">*</span></label>
                                    <select name="marca_inversor" id="marca_inversor" class="form-select <?php $__errorArgs = ['marca_inversor'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                        <option value="">Seleccione...</option>
                                        <option value="Huawei" <?php echo e(old('marca_inversor') == 'Huawei' ? 'selected' : ''); ?>>Huawei</option>
                                        <option value="Growatt" <?php echo e(old('marca_inversor') == 'Growatt' ? 'selected' : ''); ?>>Growatt</option>
                                        <option value="Sungrow" <?php echo e(old('marca_inversor') == 'Sungrow' ? 'selected' : ''); ?>>Sungrow</option>
                                        <option value="Fronius" <?php echo e(old('marca_inversor') == 'Fronius' ? 'selected' : ''); ?>>Fronius</option>
                                        <option value="SMA" <?php echo e(old('marca_inversor') == 'SMA' ? 'selected' : ''); ?>>SMA</option>
                                        <option value="Goodwe" <?php echo e(old('marca_inversor') == 'Goodwe' ? 'selected' : ''); ?>>Goodwe</option>
                                        <option value="Deye" <?php echo e(old('marca_inversor') == 'Deye' ? 'selected' : ''); ?>>Deye</option>
                                    </select>
                                    <?php $__errorArgs = ['marca_inversor'];
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
                                <div class="col-md-4">
                                    <label for="modelo_inversor" class="form-label">Modelo Inversor</label>
                                    <input type="text" name="modelo_inversor" id="modelo_inversor" 
                                           class="form-control <?php $__errorArgs = ['modelo_inversor'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           value="<?php echo e(old('modelo_inversor')); ?>" placeholder="Ej: SUN-10K-SG04LP3">
                                    <?php $__errorArgs = ['modelo_inversor'];
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
                                <div class="col-md-4">
                                    <label for="potencia_inversor_kw" class="form-label">Potencia Inversor (kW) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="potencia_inversor_kw" id="potencia_inversor_kw" 
                                           class="form-control <?php $__errorArgs = ['potencia_inversor_kw'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           value="<?php echo e(old('potencia_inversor_kw')); ?>" required>
                                    <?php $__errorArgs = ['potencia_inversor_kw'];
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
                        </div>
                    </div>

                    
                    <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" >
                        <div class="card-header bg-transparent">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0"><i class="bi bi-battery-charging me-2"></i>Baterías (Opcional)</h5>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="incluye_baterias" name="incluye_baterias" value="1" <?php echo e(old('incluye_baterias') ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="incluye_baterias">Incluir</label>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" id="seccion-baterias" style="<?php echo e(old('incluye_baterias') ? '' : 'display: none;'); ?>">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="marca_bateria" class="form-label">Marca Batería</label>
                                    <select name="marca_bateria" id="marca_bateria" class="form-select <?php $__errorArgs = ['marca_bateria'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <option value="">Seleccione...</option>
                                        <option value="Pylontech" <?php echo e(old('marca_bateria') == 'Pylontech' ? 'selected' : ''); ?>>Pylontech</option>
                                        <option value="BYD" <?php echo e(old('marca_bateria') == 'BYD' ? 'selected' : ''); ?>>BYD</option>
                                        <option value="Huawei LUNA" <?php echo e(old('marca_bateria') == 'Huawei LUNA' ? 'selected' : ''); ?>>Huawei LUNA</option>
                                        <option value="Tesla Powerwall" <?php echo e(old('marca_bateria') == 'Tesla Powerwall' ? 'selected' : ''); ?>>Tesla Powerwall</option>
                                        <option value="LG Chem" <?php echo e(old('marca_bateria') == 'LG Chem' ? 'selected' : ''); ?>>LG Chem</option>
                                    </select>
                                    <?php $__errorArgs = ['marca_bateria'];
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
                                <div class="col-md-4">
                                    <label for="modelo_bateria" class="form-label">Modelo Batería</label>
                                    <input type="text" name="modelo_bateria" id="modelo_bateria" 
                                           class="form-control <?php $__errorArgs = ['modelo_bateria'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           value="<?php echo e(old('modelo_bateria')); ?>">
                                    <?php $__errorArgs = ['modelo_bateria'];
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
                                <div class="col-md-4">
                                    <label for="capacidad_baterias_kwh" class="form-label">Capacidad Total (kWh)</label>
                                    <input type="number" step="0.01" name="capacidad_baterias_kwh" id="capacidad_baterias_kwh" 
                                           class="form-control <?php $__errorArgs = ['capacidad_baterias_kwh'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           value="<?php echo e(old('capacidad_baterias_kwh')); ?>">
                                    <?php $__errorArgs = ['capacidad_baterias_kwh'];
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
                        </div>
                    </div>

                    
                    <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" >
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0"><i class="bi bi-currency-dollar me-2"></i>Precios (Sin IGV)</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="precio_equipos" class="form-label">Equipos <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">S/</span>
                                        <input type="number" step="0.01" name="precio_equipos" id="precio_equipos" 
                                               class="form-control <?php $__errorArgs = ['precio_equipos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               value="<?php echo e(old('precio_equipos', 0)); ?>" required>
                                    </div>
                                    <?php $__errorArgs = ['precio_equipos'];
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
                                <div class="col-md-4">
                                    <label for="precio_instalacion" class="form-label">Instalación <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">S/</span>
                                        <input type="number" step="0.01" name="precio_instalacion" id="precio_instalacion" 
                                               class="form-control <?php $__errorArgs = ['precio_instalacion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               value="<?php echo e(old('precio_instalacion', 0)); ?>" required>
                                    </div>
                                    <?php $__errorArgs = ['precio_instalacion'];
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
                                <div class="col-md-4">
                                    <label for="precio_estructura" class="form-label">Estructura</label>
                                    <div class="input-group">
                                        <span class="input-group-text">S/</span>
                                        <input type="number" step="0.01" name="precio_estructura" id="precio_estructura" 
                                               class="form-control <?php $__errorArgs = ['precio_estructura'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               value="<?php echo e(old('precio_estructura', 0)); ?>">
                                    </div>
                                    <?php $__errorArgs = ['precio_estructura'];
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
                                <div class="col-md-4">
                                    <label for="precio_tramites" class="form-label">Trámites</label>
                                    <div class="input-group">
                                        <span class="input-group-text">S/</span>
                                        <input type="number" step="0.01" name="precio_tramites" id="precio_tramites" 
                                               class="form-control <?php $__errorArgs = ['precio_tramites'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               value="<?php echo e(old('precio_tramites', 0)); ?>">
                                    </div>
                                    <?php $__errorArgs = ['precio_tramites'];
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
                                <div class="col-md-4">
                                    <label for="precio_otros" class="form-label">Otros</label>
                                    <div class="input-group">
                                        <span class="input-group-text">S/</span>
                                        <input type="number" step="0.01" name="precio_otros" id="precio_otros" 
                                               class="form-control <?php $__errorArgs = ['precio_otros'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               value="<?php echo e(old('precio_otros', 0)); ?>">
                                    </div>
                                    <?php $__errorArgs = ['precio_otros'];
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
                                <div class="col-md-4">
                                    <label for="descuento_porcentaje" class="form-label">Descuento (%)</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" name="descuento_porcentaje" id="descuento_porcentaje" 
                                               class="form-control <?php $__errorArgs = ['descuento_porcentaje'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               value="<?php echo e(old('descuento_porcentaje', 0)); ?>" min="0" max="50">
                                        <span class="input-group-text">%</span>
                                    </div>
                                    <?php $__errorArgs = ['descuento_porcentaje'];
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
                        </div>
                    </div>

                    
                    <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" >
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0"><i class="bi bi-card-text me-2"></i>Notas y Condiciones</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="condiciones_comerciales" class="form-label">Condiciones Comerciales</label>
                                    <textarea name="condiciones_comerciales" id="condiciones_comerciales" rows="3" 
                                              class="form-control <?php $__errorArgs = ['condiciones_comerciales'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                              placeholder="Condiciones de pago, plazos de entrega, etc."><?php echo e(old('condiciones_comerciales')); ?></textarea>
                                    <?php $__errorArgs = ['condiciones_comerciales'];
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
                                    <label for="notas_internas" class="form-label">Notas Internas</label>
                                    <textarea name="notas_internas" id="notas_internas" rows="2" 
                                              class="form-control <?php $__errorArgs = ['notas_internas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                              placeholder="Notas visibles solo para el equipo interno"><?php echo e(old('notas_internas')); ?></textarea>
                                    <?php $__errorArgs = ['notas_internas'];
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
                                    <label for="observaciones" class="form-label">Observaciones</label>
                                    <textarea name="observaciones" id="observaciones" rows="2" 
                                              class="form-control <?php $__errorArgs = ['observaciones'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                              placeholder="Observaciones generales"><?php echo e(old('observaciones')); ?></textarea>
                                    <?php $__errorArgs = ['observaciones'];
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
                        </div>
                    </div>
                </div>

                
                <div class="col-lg-4">
                    
                    <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" >
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0"><i class="bi bi-calculator me-2"></i>Resumen</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span class="fw-bold" id="calc-subtotal">S/ 0.00</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2 text-danger">
                                <span>Descuento:</span>
                                <span id="calc-descuento">- S/ 0.00</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Base Imponible:</span>
                                <span id="calc-base">S/ 0.00</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>IGV (18%):</span>
                                <span id="calc-igv">S/ 0.00</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <span class="h5 mb-0">TOTAL:</span>
                                <span class="h5 mb-0 text-primary fw-bold" id="calc-total">S/ 0.00</span>
                            </div>
                            
                            <hr>
                            
                            <h6 class="mt-3">Producción Estimada:</h6>
                            <div class="d-flex justify-content-between mb-1 small">
                                <span>Diaria:</span>
                                <span id="calc-prod-diaria">0 kWh</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1 small">
                                <span>Mensual:</span>
                                <span id="calc-prod-mensual">0 kWh</span>
                            </div>
                            <div class="d-flex justify-content-between small">
                                <span>Anual:</span>
                                <span class="fw-bold text-success" id="calc-prod-anual">0 kWh</span>
                            </div>
                        </div>
                    </div>

                    
                    <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" >
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0"><i class="bi bi-shield-check me-2"></i>Garantías y Tiempos</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-6">
                                    <label for="garantia_paneles_anos" class="form-label small">Garantía Paneles</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="garantia_paneles_anos" id="garantia_paneles_anos" 
                                               class="form-control" value="<?php echo e(old('garantia_paneles_anos', 25)); ?>" min="1" max="30">
                                        <span class="input-group-text">años</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="garantia_inversor_anos" class="form-label small">Garantía Inversor</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="garantia_inversor_anos" id="garantia_inversor_anos" 
                                               class="form-control" value="<?php echo e(old('garantia_inversor_anos', 10)); ?>" min="1" max="15">
                                        <span class="input-group-text">años</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="garantia_instalacion_anos" class="form-label small">Garantía Instalación</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="garantia_instalacion_anos" id="garantia_instalacion_anos" 
                                               class="form-control" value="<?php echo e(old('garantia_instalacion_anos', 2)); ?>" min="1" max="10">
                                        <span class="input-group-text">años</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="tiempo_instalacion_dias" class="form-label small">Tiempo Instalación</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="tiempo_instalacion_dias" id="tiempo_instalacion_dias" 
                                               class="form-control" value="<?php echo e(old('tiempo_instalacion_dias', 5)); ?>" min="1">
                                        <span class="input-group-text">días</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" >
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Parámetros de Cálculo</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-6">
                                    <label for="horas_sol_pico" class="form-label small">Horas Sol Pico</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" step="0.1" name="horas_sol_pico" id="horas_sol_pico" 
                                               class="form-control" value="<?php echo e(old('horas_sol_pico', 5.0)); ?>" min="1" max="10">
                                        <span class="input-group-text">h/día</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="tarifa_electrica_kwh" class="form-label small">Tarifa Eléctrica</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text">S/</span>
                                        <input type="number" step="0.01" name="tarifa_electrica_kwh" id="tarifa_electrica_kwh" 
                                               class="form-control" value="<?php echo e(old('tarifa_electrica_kwh', 0.65)); ?>" min="0">
                                        <span class="input-group-text">/kWh</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-check-circle me-2"></i>Crear Cotización
                        </button>
                        <a href="<?php echo e(route('admin.crm.cotizaciones.index')); ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Cancelar
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
$(document).ready(function() {
    // Toggle sección de baterías
    $('#incluye_baterias').on('change', function() {
        $('#seccion-baterias').toggle(this.checked);
    });

    // Calcular totales en tiempo real
    function calcularTotales() {
        const equipos = parseFloat($('#precio_equipos').val()) || 0;
        const instalacion = parseFloat($('#precio_instalacion').val()) || 0;
        const estructura = parseFloat($('#precio_estructura').val()) || 0;
        const tramites = parseFloat($('#precio_tramites').val()) || 0;
        const otros = parseFloat($('#precio_otros').val()) || 0;
        const descuentoPct = parseFloat($('#descuento_porcentaje').val()) || 0;

        const subtotal = equipos + instalacion + estructura + tramites + otros;
        const descuento = subtotal * (descuentoPct / 100);
        const base = subtotal - descuento;
        const igv = base * 0.18;
        const total = base + igv;

        $('#calc-subtotal').text('S/ ' + subtotal.toLocaleString('es-PE', {minimumFractionDigits: 2}));
        $('#calc-descuento').text('- S/ ' + descuento.toLocaleString('es-PE', {minimumFractionDigits: 2}));
        $('#calc-base').text('S/ ' + base.toLocaleString('es-PE', {minimumFractionDigits: 2}));
        $('#calc-igv').text('S/ ' + igv.toLocaleString('es-PE', {minimumFractionDigits: 2}));
        $('#calc-total').text('S/ ' + total.toLocaleString('es-PE', {minimumFractionDigits: 2}));
    }

    // Calcular producción estimada
    function calcularProduccion() {
        const potenciaKw = parseFloat($('#potencia_kw').val()) || 0;
        const horasSol = parseFloat($('#horas_sol_pico').val()) || 5;
        const eficiencia = 0.85; // Factor de eficiencia del sistema

        const prodDiaria = potenciaKw * horasSol * eficiencia;
        const prodMensual = prodDiaria * 30;
        const prodAnual = prodDiaria * 365;

        $('#calc-prod-diaria').text(prodDiaria.toFixed(1) + ' kWh');
        $('#calc-prod-mensual').text(prodMensual.toFixed(0) + ' kWh');
        $('#calc-prod-anual').text(prodAnual.toFixed(0) + ' kWh');
    }

    // Event listeners para cálculos
    $('#precio_equipos, #precio_instalacion, #precio_estructura, #precio_tramites, #precio_otros, #descuento_porcentaje').on('input', calcularTotales);
    $('#potencia_kw, #horas_sol_pico').on('input', calcularProduccion);

    // Cargar datos de oportunidad seleccionada
    $('#oportunidad_id').on('change', function() {
        const selected = $(this).find(':selected');
        const potencia = selected.data('potencia');
        const paneles = selected.data('paneles');
        
        if (potencia) $('#potencia_kw').val(potencia);
        if (paneles) $('#cantidad_paneles').val(paneles);
        
        calcularProduccion();
    });

    // Calcular potencia total desde cantidad de paneles
    $('#cantidad_paneles, #potencia_panel_w').on('input', function() {
        const cantidad = parseInt($('#cantidad_paneles').val()) || 0;
        const potenciaW = parseFloat($('#potencia_panel_w').val()) || 0;
        const potenciaKw = (cantidad * potenciaW) / 1000;
        
        $('#potencia_kw').val(potenciaKw.toFixed(2));
        calcularProduccion();
    });

    // Inicializar cálculos
    calcularTotales();
    calcularProduccion();

    // Si hay oportunidad preseleccionada, cargar sus datos
    if ($('#oportunidad_id').val()) {
        $('#oportunidad_id').trigger('change');
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/PRINCIPAL/crm/cotizaciones/create.blade.php ENDPATH**/ ?>