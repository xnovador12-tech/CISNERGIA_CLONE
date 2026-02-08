<div class="modal fade" id="showrepuesto<?php echo e($al_repuesto->id_producto); ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white py-2">
                <span class="modal-title text-uppercase small" id="staticBackdropLabel">Detalles de registro</span>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php
                    $producto_tipo = \App\Models\Producto::where('id',$al_repuesto->id_producto)->first();
                ?>
                <div class="row">
                    <div class="col-12 col-md-4 col-lg-2">
                        <div class="mb-3">
                            <img for="uploadImage1" id="uploadPreview1" alt="" class="img-fluid shadow-sm" style="object-fit: cover; background-color: #bfbfbf; border-radius: 20px" src="
                            <?php if($producto_tipo): ?>
                                <?php if($producto_tipo->imagen != "image.jpg"): ?>
                                    /images/productos/<?php echo e($producto_tipo->imagen); ?>

                                <?php else: ?>
                                    /images/image.png
                                <?php endif; ?>
                            <?php else: ?>
                                /images/image.png
                            <?php endif; ?>
                            ">   
                        </div>
                    </div>
                    <div class="col-12 col-md-8 col-lg-10 d-flex">
                        <div class="align-self-center">
                            <p class="text-uppercase small mb-0"><?php echo e($al_repuesto->producto); ?> - <?php echo e($al_repuesto->umedida); ?></p>
                            <span class="border rounded px-2 fw-bold border-dark text-uppercase" style="font-size: 12px"><?php echo e($producto_tipo?$producto_tipo->tipo->name:''); ?></span>
                            <p class="small text-uppercase text-primary fw-bold mb-0" style="font-size: 12px"><?php echo e($producto_tipo?$producto_tipo->tipo_costo:''); ?></p>
                            <p class="float-start text-uppercase small">Stock: <span class="float-end badge bg-primary ms-2"><?php echo e($al_repuesto->cantidad); ?></span></p>
                        </div>
                    </div>
                </div>
                <div class="table-responsive" style=" font-size: 13.5px">
                    <table class="display_2 table table-hover w-100 mt-3">
                        <thead>
                            <tr>
                                <th class="align-middle fw-bold text-uppercase small text-center" style="width: 5%">N°</th>
                                <th class="align-middle fw-bold text-uppercase small text-center" style="width: 15%">Movimiento</th>
                                <th class="align-middle fw-bold text-uppercase small text-center" style="width: 50%">Motivo</th>
                                <th class="align-middle fw-bold text-uppercase small text-center" style="width: 50%">Codigo de Movimiento</th>
                                <th class="align-middle fw-bold text-uppercase small text-center" style="width: 50%">Lote</th>
                                <th class="align-middle fw-bold text-uppercase small text-center" style="width: 10%">Fecha</th>
                                <th class="align-middle fw-bold text-uppercase small text-center" style="width: 10%">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $contador = 1;
                                $mov_ingresos = DB::table('ingresos as ings')->join('detalleingresos as dtll','dtll.ingreso_id','=','ings.id')->select('ings.codigo_ocompra','dtll.lote','ings.motivo','ings.created_at','ings.fecha','dtll.cantidad')->where('dtll.id_producto',$al_repuesto->id_producto)->groupby('ings.codigo_ocompra','dtll.lote','ings.motivo','ings.created_at','ings.fecha','dtll.cantidad')->get();
                            ?>
                            <?php $__currentLoopData = $mov_ingresos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mov_ingreso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="align-middle text-uppercase text-center"><?php echo e($contador); ?></td>
                                    <?php if($mov_ingreso->motivo == 'Inventario'): ?>
                                        <td class="align-middle text-uppercase text-center text-success">
                                        INGRESO</td>
                                        <?php else: ?>
                                        <td class="align-middle text-uppercase text-center text-danger">
                                        SALIDA</td>
                                    <?php endif; ?>
                                <td class="align-middle text-uppercase text-center"><?php echo e($mov_ingreso->motivo); ?></td>
                                <td class="align-middle text-uppercase text-center"><?php echo e($mov_ingreso->codigo_ocompra); ?></td>
                                <td class="align-middle text-uppercase text-center"><?php echo e($mov_ingreso->lote); ?></td>
                                <td class="align-middle text-uppercase text-center"><?php echo e($mov_ingreso->fecha); ?></td>
                                <td class="align-middle text-uppercase text-center text-sucess"><?php echo e($mov_ingreso->cantidad); ?></td>
                            </tr>
                                <?php
                                    $contador++;
                                ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\Users\CESHER\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/ALMACEN/inventarios/show_dtllerepuestos.blade.php ENDPATH**/ ?>