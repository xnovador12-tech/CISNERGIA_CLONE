

<?php $__env->startSection('title', 'INGRESOS'); ?>

<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Encabezado -->
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">INGRESOS</h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none" href="">Almacén</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none" href="<?php echo e(url('admin-ingresos')); ?>">Ingresos</a></li>
                        <li class="breadcrumb-item" aria-current="page"><?php echo e($admin_ingreso->codigo); ?></li>
                </div>
            </div>
        </div>
    </div>
<!-- fin encabezado -->

    
        <div class="container-fluid">
            <div class="card border-4 borde-top-secondary shadow-sm h-100" style="border-radius: 20px; min-height: 500px" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
                <div class="card-body">
                    <p class="text-primary mb-2 small text-uppercase fw-bold">Principal</p>
                    <div class="row g-1">
                        <div class="col-12 col-md-4 col-lg-2">
                            <div class="card mb-3">
                                <div class="card-header py-1">
                                    <p class="small text-uppercase mb-0">Código</p>
                                </div>
                                <div class="card-body py-1">
                                    <p class="fw-normal mb-0"><?php echo e($admin_ingreso->codigo); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-5">
                            <div class="card mb-3">
                                <div class="card-header py-1">
                                    <p class="small text-uppercase mb-0">Ingresa a</p>
                                </div>
                                <div class="card-body py-1">
                                    <p class="fw-normal mb-0"><?php echo e($admin_ingreso->almacen->name.' | '.$admin_ingreso->almacen->sede->name); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-3">
                            <div class="card mb-3">
                                <div class="card-header py-1">
                                    <p class="small text-uppercase mb-0">Motivo</p>
                                </div>
                                <div class="card-body py-1">
                                    <p class="fw-normal mb-0"><?php echo e($admin_ingreso->motivo); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-2">
                            <div class="card mb-3">
                                <div class="card-header py-1">
                                    <p class="small text-uppercase mb-0">Fecha</p>
                                </div>
                                <div class="card-body py-1">
                                    <p class="fw-normal mb-0"><?php echo e($admin_ingreso->fecha); ?></p>
                                </div>
                            </div>
                        </div>
                        <?php if($admin_ingreso->motivo == 'Inventario'): ?>
                            <div class="col-12 col-md-4 col-lg-2">
                                <div class="card mb-3">
                                    <div class="card-header py-1">
                                        <p class="small text-uppercase mb-0">Orden de compra</p>
                                    </div>
                                    <div class="card-body py-1">
                                        <p class="fw-normal mb-0"><?php echo e($admin_ingreso->codigo_ocompra?$admin_ingreso->codigo_ocompra:'No requerido'); ?></p>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-12 col-md-4 col-lg-2">
                                <div class="card mb-3">
                                    <div class="card-header py-1">
                                        <p class="small text-uppercase mb-0">Guía de remisión</p>
                                    </div>
                                    <div class="card-body py-1">
                                        <p class="fw-normal mb-0"><?php echo e($admin_ingreso->guia_remision?$admin_ingreso->guia_remision:'No registrado'); ?></p>
                                    </div>
                                </div>
                            </div> -->
                        <?php endif; ?>
                    </div>
                    
                    <p class="text-primary mb-2 small text-uppercase fw-bold">Detalles</p>
                    <table class=" display table table-sm table-hover">
                        <thead class="bg-light">
                        <tr>
                            <th class="fw-bold small text-uppercase">N°</th>
                            <th class="fw-bold small text-uppercase">Tipo</th>
                            <th class="fw-bold small text-uppercase">Descripción</th>
                            <th class="fw-bold small text-uppercase">Lote</th>
                            <th class="fw-bold small text-uppercase">U.M.</th>
                            <th class="fw-bold small text-uppercase">Cantidad</th>
                            <th class="fw-bold small text-uppercase">Precio</th>
                        </tr>
                        </thead>
                        <tbody id="dt_solicitudes">
                            <?php 
                                $contador = 1;
                            ?> 
                            <?php $__currentLoopData = $admin_dtlle; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin_dtlles): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="text-center">
                                    <td class="fw-normal align-middle"><?php echo e($contador); ?></td>
                                    <td class="fw-normal align-middle"><?php echo e($admin_dtlles->tipo_producto); ?></td>
                                    <td class="fw-normal align-middle"><?php echo e($admin_dtlles->producto); ?></td>
                                    <td class="fw-normal align-middle"><?php echo e($admin_dtlles->lote); ?></td>
                                    <td class="fw-normal align-middle"><?php echo e($admin_dtlles->umedida); ?></td>
                                    <td class="fw-normal align-middle"><?php echo e($admin_dtlles->cantidad); ?></td>
                                    <td class="fw-normal align-middle"><?php echo e($admin_dtlles->precio == 'null'?'No requerido':$admin_dtlles->precio); ?></td>
                                </tr>
                            <?php 
                                $contador++;
                            ?> 
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    
                    <div class="row justify-content-beetween mt-3">
                        <div class="col-12 col-md-5">
                            <div class="card mb-3">
                                <div class="card-header py-1">
                                    <p class="small text-uppercase mb-0">Observaciones</p>
                                </div>
                                <div class="card-body py-1">
                                    <p class="fw-normal mb-0"><?php echo e($admin_ingreso->descripcion?$admin_ingreso->descripcion:'Sin observaciones'); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-2"></div>
                        <div class="col-12 col-md-5">
                            <table class="w-100">
                                <tr>
                                    <td class="border-0 ps-2 py-1" style="width: 50%">
                                        Total Accesorios
                                    </td>
                                    <td class="border-0 pe-2 py-1" style="width: 50%">
                                        <div class="clearfix">
                                            <span class="float-start ps-2">- </span>
                                            <span class="float-end">
                                                <?php echo e($admin_ingreso->total_mat?$admin_ingreso->total_mat:'0'); ?>

                                            </span>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="border-0 ps-2 py-1 bg-light" style="width: 50%">
                                        Total Repuestos
                                    </td>
                                    <td class="border-0 pe-2 py-1 bg-light" style="width: 50%">
                                        <div class="clearfix">
                                            <span class="float-start ps-2">- </span>
                                            <span class="float-end">
                                                <?php echo e($admin_ingreso->total_act?$admin_ingreso->total_act:'0'); ?>

                                            </span>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="border-0 ps-2 py-1" style="width: 50%">
                                        Total Modulo Solar
                                    </td>
                                    <td class="border-0 pe-2 py-1" style="width: 50%">
                                        <div class="clearfix">
                                            <span class="float-start ps-2">- </span>
                                            <span class="float-end">
                                                <?php echo e($admin_ingreso->total_pte?$admin_ingreso->total_pte:'0'); ?>

                                            </span>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="border-0 fw-bold ps-2 py-1 bg-light" style="width: 50%">
                                        TOTAL
                                    </td>
                                    <td class="border-0 fw-bold pe-2 py-1 bg-light" style="width: 50%">
                                        <div class="clearfix">
                                            <span class="float-start ps-2">- </span>
                                            <span class="float-end">
                                                <?php echo e($admin_ingreso->total); ?>

                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-3 text-end" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
                <a href="<?php echo e(url('admin-ingresos')); ?>" class="btn btn-outline-secondary px-5">Volver</a>
            </div>     
        </div> 
    

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\CESHER\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/ALMACEN/ingresos/show.blade.php ENDPATH**/ ?>