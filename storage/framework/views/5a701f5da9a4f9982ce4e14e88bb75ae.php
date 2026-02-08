<form method="POST" action="<?php echo e(route('admin-coberturas.update', $admin_cobertura->slug)); ?>" enctype="multipart/form-data" autocomplete="off" class="needs-validation" novalidate>      
    <?php echo csrf_field(); ?>  
    <?php echo method_field('put'); ?>  
    <div class="modal fade" id="editcoberturas<?php echo e($admin_cobertura->slug); ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white py-2">
                    <span class="modal-title text-uppercase small" id="staticBackdropLabel">Actualizar categoria</span>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card border-0 rounded-0 border-start border-3 border-info bg-light mb-4" style="box-shadow: rgba(17, 17, 26, 0.1) 0px 1px 0px;">
                        <div class="card-body py-2">
                            <i class="bi bi-info-circle text-info me-2"></i>Importante:
                            <ul class="list-unstyled mb-0 pb-0">
                                <li class="mb-0 pb-0">
                                    <small class="text-muted py-0 my-0 text-start"> Se consideran campos obligatorios los campos que tengan este simbolo: <span class="text-danger">*</small></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="mb-3">
                                <label for="name_id">Nombre<span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name_id" class="form-control" value="<?php echo e($admin_cobertura->name); ?>"  maxLength="100" required>
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <small class="text-danger"><?php echo e($message); ?></small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="invalid-feedback">
                                    El campo no puede estar vacío
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="precio_id">Precio<span class="text-danger">*</span></label>
                                <input type="number" name="precio" id="precio_id" class="form-control <?php $__errorArgs = ['precio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e($admin_cobertura->precio); ?>"  required>
                                <?php $__errorArgs = ['precio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <small class="text-danger"><?php echo e($message); ?></small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="invalid-feedback">
                                    El campo no puede estar vacío
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="tipos_id" class=" d-block">Departamento - Provincia - Distrito<span class="text-danger">*</span></label>
                                <select id="ubigeos__ids<?php echo e($admin_cobertura->slug); ?>" class="ubigeos__ids_edit form-select form-select-sm select2 <?php $__errorArgs = ['distrito_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" data-slug="<?php echo e($admin_cobertura->slug); ?>">
                                    <option selected="selected" hidden="hidden"></option>
                                    <?php $__currentLoopData = $ubigeos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ubigeo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                        <option value="<?php echo e($ubigeo->departamento_ids); ?>_<?php echo e($ubigeo->provincia_ids); ?>_<?php echo e($ubigeo->distrito_ids); ?>"><?php echo e($ubigeo->departamento_name.'/'.$ubigeo->provincia_name.'/'.$ubigeo->distrito_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <input type="hidden" id="departamento_ids<?php echo e($admin_cobertura->slug); ?>" name="departamento_id" value="<?php echo e($admin_cobertura->departamento_id); ?>">
                                <input type="hidden" id="provincias_ids<?php echo e($admin_cobertura->slug); ?>" name="provincia_id" value="<?php echo e($admin_cobertura->provincia_id); ?>">
                                <input type="hidden" id="distritos_ids<?php echo e($admin_cobertura->slug); ?>" name="distrito_id" value="<?php echo e($admin_cobertura->distrito_id); ?>">
                                <?php $__errorArgs = ['tipo_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <small class="text-danger"><?php echo e($message); ?></small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>    
                            </div>
                            <div class="mb-3">
                                <label for="estado_id">Estado<span class="text-danger">*</span></label>
                                <select name="estado" id="estado_id" class="form-select text-uppercase" required>
                                    <option value="<?php echo e($admin_cobertura->estado); ?>" selected="selected" hidden="hidden"><?php echo e($admin_cobertura->estado); ?></option>
                                    <option value="Activo">ACTIVO</option>
                                    <option value="Inactivo">INACTIVO</option>
                                </select>
                                <?php $__errorArgs = ['estado'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <small class="text-danger"><?php echo e($message); ?></small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="invalid-feedback">
                                    El campo no puede estar vacío
                                </div>
                            </div>
                        </div>    
                    </div>                           
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-dark text-uppercase small px-5 text-white">Actualizar</button>   
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    function previewImage(nb) {        
    var reader = new FileReader();         
    reader.readAsDataURL(document.getElementById('uploadImage'+nb).files[0]);         
    reader.onload = function (e) {             
        document.getElementById('uploadPreview'+nb).src = e.target.result;         
    };     
    }
</script><?php /**PATH C:\Users\CESHER\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/PRINCIPAL/configuraciones/coberturas/edit.blade.php ENDPATH**/ ?>