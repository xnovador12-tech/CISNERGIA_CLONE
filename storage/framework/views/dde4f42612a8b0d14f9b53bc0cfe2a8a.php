<?php $__env->startSection('title', 'Nuevo Ticket'); ?>

<?php $__env->startSection('content'); ?>
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">NUEVO TICKET DE SOPORTE</h1>
                <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(route('admin-dashboard.index')); ?>">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(route('admin.crm.tickets.index')); ?>">Tickets</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Nuevo</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px" data-aos="fade-up">
            <div class="card-body p-4">

                <div class="card border-0 rounded-0 border-start border-3 border-info mb-4" style="box-shadow: rgba(17,17,26,0.1) 0px 1px 0px; background-color:#f6f6f6">
                    <div class="card-body py-2">
                        <i class="bi bi-info-circle text-info me-2"></i>
                        <small class="text-muted">Los campos con <span class="text-danger">*</span> son obligatorios. Los campos adicionales aparecen según la categoría seleccionada.</small>
                    </div>
                </div>

                <form action="<?php echo e(route('admin.crm.tickets.store')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

                    
                    <div class="row g-3">

                        
                        <div class="col-md-8">
                            <label for="cliente_id" class="form-label fw-bold">Cliente <span class="text-danger">*</span></label>
                            <select name="cliente_id" id="cliente_id" class="form-select select2_bootstrap_2 <?php $__errorArgs = ['cliente_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="">Seleccionar cliente...</option>
                                <?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($c->id); ?>" <?php echo e(old('cliente_id', $clienteId ?? '') == $c->id ? 'selected' : ''); ?>>
                                        <?php echo e($c->nombre_completo); ?><?php echo e(($c->ruc ?? $c->dni) ? ' — ' . ($c->ruc ?? $c->dni) : ''); ?> — <?php echo e($c->codigo); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['cliente_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="col-md-4">
                            <label for="prioridad" class="form-label fw-bold">Prioridad <span class="text-danger">*</span></label>
                            <select name="prioridad" id="prioridad" class="form-select select2_bootstrap_2 <?php $__errorArgs = ['prioridad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="baja"    <?php echo e(old('prioridad') == 'baja'             ? 'selected' : ''); ?>>🟢 Baja — 72h SLA</option>
                                <option value="media"   <?php echo e(old('prioridad', 'media') == 'media'   ? 'selected' : ''); ?>>🟡 Media — 48h SLA</option>
                                <option value="alta"    <?php echo e(old('prioridad') == 'alta'             ? 'selected' : ''); ?>>🟠 Alta — 24h SLA</option>
                                <option value="critica" <?php echo e(old('prioridad') == 'critica'          ? 'selected' : ''); ?>>🔴 Crítica — 4h SLA</option>
                            </select>
                            <?php $__errorArgs = ['prioridad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="col-md-6">
                            <label for="categoria" class="form-label fw-bold">Categoría <span class="text-danger">*</span></label>
                            <select name="categoria" id="categoria" class="form-select select2_bootstrap_2 <?php $__errorArgs = ['categoria'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="">Seleccionar categoría...</option>
                                <option value="mantenimiento"    <?php echo e(old('categoria') == 'mantenimiento'    ? 'selected' : ''); ?>>🔩 Mantenimiento</option>
                                <option value="soporte_tecnico"  <?php echo e(old('categoria') == 'soporte_tecnico'  ? 'selected' : ''); ?>>🔧 Soporte Técnico</option>
                                <option value="garantia"         <?php echo e(old('categoria') == 'garantia'         ? 'selected' : ''); ?>>🛡️ Garantía</option>
                                <option value="facturacion"      <?php echo e(old('categoria') == 'facturacion'      ? 'selected' : ''); ?>>💰 Facturación / Cobranza</option>
                                <option value="consulta_reclamo" <?php echo e(old('categoria') == 'consulta_reclamo' ? 'selected' : ''); ?>>❓ Consulta / Reclamo</option>
                            </select>
                            <?php $__errorArgs = ['categoria'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="col-md-6">
                            <label for="asunto" class="form-label fw-bold">Asunto <span class="text-danger">*</span></label>
                            <input type="text" name="asunto" id="asunto"
                                   class="form-control <?php $__errorArgs = ['asunto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('asunto')); ?>" placeholder="Descripción breve del problema" maxlength="200" required>
                            <?php $__errorArgs = ['asunto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    
                    <div id="bloque-mantenimiento" class="row g-3 mt-1 d-none">
                        <div class="col-12">
                            <div class="card border-0 border-start border-3 border-primary" style="background:#f0f4ff">
                                <div class="card-body py-2 px-3">
                                    <small class="fw-bold text-primary-emphasis"><i class="bi bi-tools me-1"></i>Datos del Mantenimiento — se programará automáticamente al guardar</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="tipo_mantenimiento" class="form-label fw-bold">Tipo <span class="text-danger">*</span></label>
                            <select name="tipo_mantenimiento" id="tipo_mantenimiento" class="form-select select2_bootstrap_2 <?php $__errorArgs = ['tipo_mantenimiento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="preventivo"  <?php echo e(old('tipo_mantenimiento', 'preventivo') == 'preventivo'  ? 'selected' : ''); ?>>Preventivo</option>
                                <option value="correctivo"  <?php echo e(old('tipo_mantenimiento') == 'correctivo'  ? 'selected' : ''); ?>>Correctivo</option>
                                <option value="limpieza"    <?php echo e(old('tipo_mantenimiento') == 'limpieza'    ? 'selected' : ''); ?>>Limpieza</option>
                                <option value="inspeccion"  <?php echo e(old('tipo_mantenimiento') == 'inspeccion'  ? 'selected' : ''); ?>>Inspección</option>
                                <option value="predictivo"  <?php echo e(old('tipo_mantenimiento') == 'predictivo'  ? 'selected' : ''); ?>>Predictivo</option>
                            </select>
                            <?php $__errorArgs = ['tipo_mantenimiento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-4">
                            <label for="fecha_mantenimiento" class="form-label fw-bold">Fecha Programada <span class="text-danger">*</span></label>
                            <input type="date" name="fecha_mantenimiento" id="fecha_mantenimiento"
                                   class="form-control <?php $__errorArgs = ['fecha_mantenimiento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('fecha_mantenimiento')); ?>"
                                   min="<?php echo e(now()->toDateString()); ?>">
                            <?php $__errorArgs = ['fecha_mantenimiento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-4">
                            <label for="hora_mantenimiento" class="form-label fw-bold">Hora</label>
                            <input type="time" name="hora_mantenimiento" id="hora_mantenimiento"
                                   class="form-control <?php $__errorArgs = ['hora_mantenimiento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('hora_mantenimiento', '09:00')); ?>">
                            <?php $__errorArgs = ['hora_mantenimiento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    
                    <div id="bloque-tecnico" class="row g-3 mt-1 d-none">
                        <div class="col-12">
                            <div class="card border-0 border-start border-3 border-warning" style="background:#fffbf0">
                                <div class="card-body py-2 px-3">
                                    <small class="fw-bold text-warning-emphasis"><i class="bi bi-tools me-1"></i>Datos del Sistema Solar</small>
                                </div>
                            </div>
                        </div>

                        
                        <div class="col-md-6">
                            <label for="componente_afectado" class="form-label fw-bold">Componente Afectado</label>
                            <input type="text" name="componente_afectado" id="componente_afectado"
                                   class="form-control <?php $__errorArgs = ['componente_afectado'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('componente_afectado')); ?>"
                                   placeholder="Ej: Inversor Fronius 5kW, Panel 400W, Batería BYD...">
                            <div class="form-text">Describe el equipo o componente con falla.</div>
                            <?php $__errorArgs = ['componente_afectado'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="col-md-6">
                            <label for="pedido_id" class="form-label fw-bold">Pedido de Referencia</label>
                            <select name="pedido_id" id="pedido_id" class="form-select select2_bootstrap_2 <?php $__errorArgs = ['pedido_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="">Sin referencia</option>
                                <?php $__currentLoopData = $pedidos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($p->id); ?>"
                                            data-direccion="<?php echo e($p->direccion_instalacion); ?>"
                                            <?php echo e(old('pedido_id') == $p->id ? 'selected' : ''); ?>>
                                        <?php echo e($p->codigo); ?> — S/ <?php echo e(number_format($p->total, 2)); ?> (<?php echo e(ucfirst($p->estado)); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['pedido_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="col-md-12">
                            <label for="direccion_sistema" class="form-label fw-bold">Dirección del Sistema</label>
                            <input type="text" name="direccion_sistema" id="direccion_sistema"
                                   class="form-control <?php $__errorArgs = ['direccion_sistema'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('direccion_sistema')); ?>"
                                   placeholder="Se completa automáticamente al seleccionar un pedido" maxlength="255">
                            <?php $__errorArgs = ['direccion_sistema'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    
                    <div id="bloque-facturacion" class="row g-3 mt-1 d-none">
                        <div class="col-12">
                            <div class="card border-0 border-start border-3 border-success" style="background:#f0fff4">
                                <div class="card-body py-2 px-3">
                                    <small class="fw-bold text-success-emphasis"><i class="bi bi-receipt me-1"></i>Referencia de Venta</small>
                                </div>
                        </div>
                        </div>
                        <div class="col-md-12">
                            <label for="venta_id" class="form-label fw-bold">Venta / Comprobante de Referencia</label>
                            <select name="venta_id" id="venta_id" class="form-select select2_bootstrap_2 <?php $__errorArgs = ['venta_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="">Sin referencia</option>
                            </select>
                            <div class="form-text"><i class="bi bi-info-circle me-1"></i>Selecciona primero el cliente para ver sus ventas.</div>
                            <?php $__errorArgs = ['venta_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    
                    <div class="row g-3 mt-1">
                        <div class="col-12">
                            <label for="descripcion" class="form-label fw-bold">Descripción Detallada <span class="text-danger">*</span></label>
                            <textarea name="descripcion" id="descripcion" rows="5"
                                      class="form-control <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                      placeholder="Describe el problema, lo que ocurre, cuándo empezó y cualquier detalle relevante..." required><?php echo e(old('descripcion')); ?></textarea>
                            <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-12">
                            <label for="adjuntos" class="form-label fw-bold">
                                <i class="bi bi-paperclip me-1"></i>Evidencias / Adjuntos
                                <span class="text-muted fw-normal small">(máx. 3 archivos · 5MB c/u)</span>
                            </label>
                            <input type="file" name="adjuntos[]" id="adjuntos"
                                   class="form-control <?php $__errorArgs = ['adjuntos.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   accept=".jpg,.jpeg,.png,.pdf" multiple>
                            <div class="form-text">Fotos del equipo, capturas de error o documentos PDF.</div>
                            <?php $__errorArgs = ['adjuntos.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    
                    <div class="row g-3 mt-1">
                        <div class="col-md-4">
                            <label for="user_id" class="form-label fw-bold">Técnico / Agente Responsable</label>
                            <select name="user_id" id="user_id" class="form-select select2_bootstrap_2 <?php $__errorArgs = ['user_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="">Sin asignar</option>
                                <?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($u->id); ?>" <?php echo e(old('user_id') == $u->id ? 'selected' : ''); ?>>
                                        <?php echo e($u->persona?->name ?? $u->name); ?> <?php echo e($u->persona?->surnames ?? ''); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['user_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-4">
                            <label for="canal" class="form-label fw-bold">Canal de Contacto <span class="text-danger">*</span></label>
                            <select name="canal" id="canal" class="form-select select2_bootstrap_2 <?php $__errorArgs = ['canal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="whatsapp"  <?php echo e(old('canal', 'whatsapp') == 'whatsapp'  ? 'selected' : ''); ?>>💬 WhatsApp</option>
                                <option value="telefono"  <?php echo e(old('canal') == 'telefono'  ? 'selected' : ''); ?>>📞 Teléfono</option>
                                <option value="email"     <?php echo e(old('canal') == 'email'     ? 'selected' : ''); ?>>📧 Email</option>
                                <option value="presencial"<?php echo e(old('canal') == 'presencial'? 'selected' : ''); ?>>🏢 Presencial</option>
                                <option value="web"       <?php echo e(old('canal') == 'web'       ? 'selected' : ''); ?>>🌐 Web</option>
                            </select>
                            <?php $__errorArgs = ['canal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-4">
                            <label for="notas_internas" class="form-label fw-bold">
                                <i class="bi bi-lock me-1 text-warning"></i>Notas Internas
                            </label>
                            <textarea name="notas_internas" id="notas_internas" rows="1"
                                      class="form-control <?php $__errorArgs = ['notas_internas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                      placeholder="Notas privadas del equipo..."><?php echo e(old('notas_internas')); ?></textarea>
                            <?php $__errorArgs = ['notas_internas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <hr class="my-4">
                    <div class="d-flex justify-content-between">
                        <a href="<?php echo e(route('admin.crm.tickets.index')); ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-ticket-detailed me-2"></i>Crear Ticket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
$(document).ready(function () {

    const urlPedidos = "<?php echo e(route('admin.crm.tickets.pedidos-por-cliente', ':id')); ?>";
    const urlVentas  = "<?php echo e(route('admin.crm.tickets.ventas-por-cliente', ':id')); ?>";

    // ── Select2 ──────────────────────────────────────────────────────────
    $('#cliente_id').select2({ theme:'bootstrap-5', placeholder:'Buscar cliente...', allowClear:true, width:'100%' });
    $('#categoria, #prioridad, #user_id, #canal, #pedido_id, #venta_id, #tipo_mantenimiento').select2({ theme:'bootstrap-5', allowClear:true, width:'100%' });

    // ── Mostrar/ocultar bloques según categoría ──────────────────────────
    function actualizarBloques(cat) {
        const esMant       = (cat === 'mantenimiento');
        const esTecnico    = (cat === 'soporte_tecnico' || cat === 'garantia');
        const esFacturacion = (cat === 'facturacion');

        $('#bloque-mantenimiento').toggleClass('d-none', !esMant);
        $('#bloque-tecnico').toggleClass('d-none', !esTecnico);
        $('#bloque-facturacion').toggleClass('d-none', !esFacturacion);

        // El bloque técnico también aplica a mantenimiento (pedido + dirección)
        if (esMant) $('#bloque-tecnico').removeClass('d-none');
    }

    $('#categoria').on('change', function () {
        actualizarBloques($(this).val());
    });

    // Restaurar estado si hay old() values
    <?php if(old('categoria')): ?>
        actualizarBloques('<?php echo e(old('categoria')); ?>');
    <?php endif; ?>

    // ── AJAX: cargar pedidos al cambiar cliente ──────────────────────────
    $('#cliente_id').on('change', function () {
        const id = $(this).val();
        const $ped = $('#pedido_id');
        const $ven = $('#venta_id');
        $ped.empty().append('<option value="">Sin referencia</option>');
        $ven.empty().append('<option value="">Sin referencia</option>');
        $('#direccion_sistema').val('');

        if (!id) return;

        // Cargar pedidos
        $.getJSON(urlPedidos.replace(':id', id), function (data) {
            data.forEach(function (p) {
                $ped.append($('<option>', {
                    value: p.id,
                    text: p.codigo + ' — S/ ' + p.total + ' (' + p.estado + ')',
                    'data-direccion': p.direccion || ''
                }));
            });
            $ped.trigger('change.select2');
        });

        // Cargar ventas
        $.getJSON(urlVentas.replace(':id', id), function (data) {
            data.forEach(function (v) {
                $ven.append($('<option>', {
                    value: v.id,
                    text: v.codigo + ' · ' + v.comprobante + ' — S/ ' + v.total
                }));
            });
            $ven.trigger('change.select2');
        });
    });

    // Auto-rellenar dirección al seleccionar pedido
    $('#pedido_id').on('change', function () {
        const dir = $('option:selected', this).data('direccion');
        if (dir) $('#direccion_sistema').val(dir);
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/CRM/tickets/create.blade.php ENDPATH**/ ?>