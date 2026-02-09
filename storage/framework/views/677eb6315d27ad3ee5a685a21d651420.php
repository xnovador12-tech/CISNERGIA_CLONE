

<?php $__env->startSection('title', 'Proveedores'); ?>

<?php $__env->startSection('css'); ?>
<style>
    .scroll-thin {
        scrollbar-width: thin;
        scrollbar-color: #c1c1c1 transparent;
    }
    .scroll-thin::-webkit-scrollbar {
        width: 6px;
    }
    .scroll-thin::-webkit-scrollbar-thumb {
        background-color: #c1c1c1;
        border-radius: 8px;
    }
    .scroll-thin::-webkit-scrollbar-track {
        background: transparent;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Encabezado -->
<div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">PROVEEDORES</h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(url('admin-configuraciones')); ?>">Configuraciones</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(url('admin-proveedores')); ?>">Proveedores</a></li>
                        <li class="breadcrumb-item" aria-current="page"><?php echo e($admin_proveedore->name); ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
<!-- fin encabezado -->

    
        <div class="container-fluid">
            <div class="card border-4 borde-top-primary shadow-sm h-100" style="border-radius: 20px; min-height: 500px" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Datos del proveedor</p>
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="pb-3">
                                        <div class="card">
                                            <div class="card-header py-1">
                                                <span class="text-uppercase small">Nro de identificación</span>
                                            </div>
                                            <div class="card-body py-2">
                                                <span><?php echo e($admin_proveedore->nro_identificacion); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-5">
                                    <div class="pb-3">
                                        <div class="card">
                                            <div class="card-header py-1">
                                                <span class="text-uppercase small">Identificación</span>
                                            </div>
                                            <div class="card-body py-2">
                                                <?php if($admin_proveedore->tipo_documento == 'RUC'): ?>
                                                    <span>Registro unico del contribuyente - <?php echo e($admin_proveedore->tipo_documento); ?></span>
                                                <?php elseif($admin_proveedore->tipo_documento == 'DNI'): ?>
                                                    <span>Documento Nacional de identidad - <?php echo e($admin_proveedore->tipo_documento); ?></span>
                                                <?php elseif($admin_proveedore->tipo_documento == 'CE'): ?>
                                                    <span>Carnet de extranjería - <?php echo e($admin_proveedore->tipo_documento); ?></span>
                                                <?php elseif($admin_proveedore->tipo_documento == 'PP'): ?>
                                                    <span>Pasaporte - <?php echo e($admin_proveedore->tipo_documento); ?></span>
                                                <?php else: ?>
                                                    <span>Documento tributario no domiciliado sin ruc - <?php echo e($admin_proveedore->tipo_documento); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3">
                                    <div class="pb-3">
                                        <div class="card">
                                            <div class="card-header py-1">
                                                <span class="text-uppercase small">Giro</span>
                                            </div>
                                            <div class="card-body py-2">
                                                <span><?php echo e($admin_proveedore->proveedor->giro); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="pb-3">
                                        <div class="card">
                                            <div class="card-header py-1">
                                                <span class="text-uppercase small">Nombre o razón social</span>
                                            </div>
                                            <div class="card-body py-2">
                                                <span><?php echo e($admin_proveedore->proveedor->name_contacto); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="pb-3">
                                        <div class="card">
                                            <div class="card-header py-1">
                                                <span class="text-uppercase small">Correo electrónico</span>
                                            </div>
                                            <div class="card-body py-2">
                                                <span><?php echo e($admin_proveedore->proveedor->email_contacto); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="pb-3">
                                        <div class="card">
                                            <div class="card-header py-1">
                                                <span class="text-uppercase small">Nro de contacto</span>
                                            </div>
                                            <div class="card-body py-2">
                                                <span><?php echo e($admin_proveedore->celular); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-8">
                                    <div class="pb-3">
                                        <div class="card">
                                            <div class="card-header py-1">
                                                <span class="text-uppercase small">Dirección</span>
                                            </div>
                                            <div class="card-body py-2">
                                                <span><?php echo e($admin_proveedore->direccion); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="pb-3">
                                        <div class="card">
                                            <div class="card-header py-1">
                                                <span class="text-uppercase small">Referencia</span>
                                            </div>
                                            <div class="card-body py-2">
                                                <span><?php echo e($admin_proveedore->referencia); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="pb-3">
                                        <div class="card">
                                            <div class="card-header py-1">
                                                <span class="text-uppercase small">Dirección fiscal</span>
                                            </div>
                                            <div class="card-body py-2">
                                                <span><?php echo e($admin_proveedore->proveedor->direccion_fiscal); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="pb-3">
                                        <div class="card">
                                            <div class="card-header py-1">
                                                <span class="text-uppercase small">Departamento</span>
                                            </div>
                                            <div class="card-body py-2">
                                                <option><?php echo e($admin_proveedore->proveedor->departamento->name); ?></option>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="pb-3">
                                        <div class="card mb-3">
                                            <div class="card-header py-1">
                                                <p class="small text-uppercase mb-0">Tipos</p>
                                            </div>
                                            <?php $__currentLoopData = $admin_proveedore->proveedor->tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="card-body py-1 me-2">
                                                    <li class="fw-normal mb-0"><?php echo e($tipo->name); ?></li>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Datos de persona de contacto</p>

                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="pb-3">
                                        <div class="card">
                                            <div class="card-header py-1">
                                                <span class="text-uppercase small">Nombres y apellidos</span>
                                            </div>
                                            <div class="card-body py-2">
                                                <span><?php echo e($admin_proveedore->name); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="pb-3">
                                        <div class="card">
                                            <div class="card-header py-1">
                                                <span class="text-uppercase small">Correo electrónico</span>
                                            </div>
                                            <div class="card-body py-2">
                                                <span><?php echo e($admin_proveedore->email_pnatural); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="pb-3">
                                        <div class="card">
                                            <div class="card-header py-1">
                                                <span class="text-uppercase small">Nro. Contacto</span>
                                            </div>
                                            <div class="card-body py-2">
                                                <span><?php echo e($admin_proveedore->celular); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>    
                        <div class="col-12 col-md-6 col-lg-6">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Cuentas bancaria</p>
                            <div class="overflow-auto scroll-thin" style="max-height: 220px;">
                                <?php $__currentLoopData = $admin_proveedore->proveedor->proveedorcuentas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cuenta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="pb-3">
                                    <div class="card">
                                        <div class="card-header py-1">
                                            <div class="row bg-light">
                                                <div class="col-4 col-md-3 col-lg-3">
                                                    <span class="text-uppercase small">Tipo de cuenta</span>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-3">
                                                    <span class="text-uppercase small">Banco</span>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-3">
                                                    <span class="text-uppercase small">Nro. de cuenta</span>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-3">
                                                    <span class="text-uppercase small">Nro. de CCI</span>
                                                </div>
                                            </div>
                                            <div class="row bg-white">
                                                <div class="col-4 col-md-3 col-lg-3">
                                                    <span class="text-uppercase small"><?php echo e($cuenta->tipo_cuenta_normal); ?></span>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-3">
                                                    <span class="text-uppercase small"><?php echo e($cuenta->entidad_bancaria_normal); ?></span>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-3">
                                                    <span class="text-uppercase small"><?php echo e($cuenta->nro_cuenta_normal); ?></span>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-3">
                                                    <span class="text-uppercase small"><?php echo e($cuenta->nro_cci_normal); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Cuenta de detracción</p>

                            <div class="pb-3">
                                <div class="card">
                                    <div class="card-header py-1">
                                        <span class="text-uppercase small">Tipo de cuenta</span>
                                    </div>
                                    <div class="card-body py-2">
                                        <span><?php echo e($admin_proveedore->proveedor->tipo_cuenta_detraccion); ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="pb-3">
                                <div class="card">
                                    <div class="card-header py-1">
                                        <span class="text-uppercase small">Banco</span>
                                    </div>
                                    <div class="card-body py-2">
                                        <span><?php echo e($admin_proveedore->proveedor->entidad_bancaria_detraccion); ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="pb-3">
                                <div class="card">
                                    <div class="card-header py-1">
                                        <span class="text-uppercase small">Nro de cuenta de detracción</span>
                                    </div>
                                    <div class="card-body py-2">
                                        <span><?php echo e($admin_proveedore->proveedor->nro_cuenta_detraccion); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                                      
                </div>
            </div>
            <div class="pt-3 pb-3 text-end" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
                <a href="<?php echo e(url('admin-proveedores')); ?>" class="btn btn-outline-secondary px-5">Volver</a>
            </div>     
        </div> 
    

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\CESHER\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/PRINCIPAL/configuraciones/proveedores/show.blade.php ENDPATH**/ ?>