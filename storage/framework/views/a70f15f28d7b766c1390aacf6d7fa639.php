<?php $__env->startSection('title', 'PRODUCTOS'); ?>

<?php $__env->startSection('css'); ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    #container_images_multiple{
        display: flex;
        justify-content: space-evenly;
        gap: 20px;
        flex-wrap: wrap;
    }

    figure{
        width: 30%;
    }

    .img_opcional{
        width: 100%;
        height: 150px;
    }

    figcaption{
        text-align: center;
        font-size: 1.8vmin;
        margin-top: 0.5vmin;
    }

    @media only screen and (min-width:320px) and (max-width:768px){
        .img_opcional{
        width: 100%;
        height: 90px;
    }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Encabezado -->
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">PRODUCTOS</h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(url('admin-configuraciones')); ?>">Configuraciones</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(url('admin-productos')); ?>">Productos</a></li>
                        <li class="breadcrumb-item" aria-current="page">Actualizar registro</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
<!-- fin encabezado -->

    
    <form method="POST" action="/admin-productos/<?php echo e($admin_producto->slug); ?>" enctype="multipart/form-data" autocomplete="off" class="needs-validation" novalidate>      
        <?php echo csrf_field(); ?>
        <?php echo method_field('put'); ?>
        <input hidden value="<?php echo e($admin_producto->id); ?>" id="valir_prod">
        <div class="container-fluid">
            <div class="card border-4 borde-top-secondary shadow-sm h-100" style="border-radius: 20px; min-height: 500px" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
                <div class="card-body">
                    <div class="card border-0 rounded-0 border-start border-3 border-info mb-4" style="box-shadow: rgba(17, 17, 26, 0.1) 0px 1px 0px; background-color: #f6f6f6">
                        <div class="card-body py-2">
                            <i class="bi bi-info-circle text-info me-2"></i>Importante:
                            <ul class="list-unstyled mb-0 pb-0">
                                <li class="mb-0 pb-0">
                                    <small class="text-muted py-0 my-0 text-start"> Se consideran campos obligatorios los campos que tengan este simbolo: <span class="text-danger">*</small></span>
                                </li>
                                <li class="mb-0 pb-0">
                                    <small class="text-muted">Se recomienda tener en cuenta las siguientes medidas para la imágen: <span class="fw-bold">1200 x 1200 px.</span> Peso máximo de imagen:<span class="fw-bold"> 3 MB.</span></small>
                                </li>
                            </ul>
                        </div>
                    </div>      

                    <div class="row">
                        <div class="col-12 col-md-8 col-lg-9">
                            <p class="text-secondary mb-2 small text-uppercase fw-bold">Datos generales</p>
                            <div class="row">
                                <div class="col-6 col-md-3 col-lg-2">
                                    <div class="mb-3">
                                        <label for="codigo_id" class="">Código<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3 col-lg-2">
                                    <div class="mb-3">
                                        <input type="text" value="<?php echo e($admin_producto->codigo); ?>" class="form-control form-control-sm bg-white" disabled id="codigo_id">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-7">
                                    <div class="mb-3">
                                        <label for="codigo_id" class="">Nombre<span class="text-danger">*</span></label>
                                        <input type="text" name="name" value="<?php echo e($admin_producto->name); ?>" class="form-control form-control-sm <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
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
                                    </div>
                                </div>
                                <div class="col-6 col-md-3 col-lg-2">
                                    <div class="mb-3">
                                        <label for="peso_id" class="">Peso</label>
                                        <input type="decimal" name="peso" value="<?php echo e($admin_producto->peso); ?>" class="form-control form-control-sm bg-white" id="peso_id">
                                    </div>
                                </div>
                                <div class="col-12 col-md-3 col-lg-3">
                                    <div class="mb-3">
                                        <label for="tipos__bien_id" class="">Tipo de bien<span class="text-danger">*</span></label>
                                        <label type="text" class="form-control form-control-sm <?php $__errorArgs = ['tipo_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e($admin_producto->tipo->name); ?></label required>
                                        <input hidden id="tipos__bien_id" value="<?php echo e($admin_producto->tipo->id); ?>">
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
                                </div>
                                <div class="col-12 col-md-3 col-lg-3">
                                    <div class="mb-3">
                                        <label for="categories__id" class="">Categoría<span class="text-danger">*</span></label>
                                        <label type="text" class="form-control form-control-sm <?php $__errorArgs = ['categoria_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e($admin_producto->categorie->name); ?></label>
                                        <?php $__errorArgs = ['categoria_id'];
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
                                </div>

                                <div class="col-12 col-md-3 col-lg-3">
                                    <div class="mb-3">
                                        <label for="categorias__id" class="">Unidad de medida<span class="text-danger">*</span></label>
                                        <label type="text" class="form-control form-control-sm <?php $__errorArgs = ['medida_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e($admin_producto->medida->nombre); ?></label>
                                        <?php $__errorArgs = ['medida_id'];
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
                                </div>

                                <div class="col-12 col-md-3 col-lg-3">
                                    <div class="mb-3">
                                        <label for="marcas__id" class="">Marca</label>
                                        <select class="form-select form-select-sm select2 <?php $__errorArgs = ['marca'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="marca_id" id="marcas__id" >
                                            <option value="<?php echo e($admin_producto->marca->id); ?>" selected="selected" hidden="hidden"><?php echo e($admin_producto->marca->name); ?></option>
                                            <?php $__currentLoopData = $marcas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $marca): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($marca->id); ?>"><?php echo e($marca->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php $__errorArgs = ['marca'];
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
                                </div>

                            </div>
                            <br>
                            <div class="row">
                                <div class="col-12 col-md-9 py-1">
                                        <label for="descripcion_id" class="">Descripción</label>
                                        <textarea class="form-control <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="descripcion" id="editor" placeholder="Escribe una descripción" style="height: 210px"><?php echo e($admin_producto->descripcion); ?></textarea>
                                    <?php $__errorArgs = ['descripcion'];
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
                                <div class="col-9 col-md-3 py-1">
                                    <label for="" class="">Imagen Principal</label>
                                    <div class="card text-center imagecard rounded bg-light mb-0" style="height: auto">  
                                        <label for="uploadImage1" class=" my-auto text-center">
                                            <img for="uploadImage1" id="uploadPreview1" alt="" class="py-auto rounded" style="width: 100%; height: 100%;" src="
                                            <?php if($admin_producto->imagen == 'NULL'): ?>
                                            /images/icon.png
                                            <?php else: ?>
                                            /images/productos/<?php echo e($admin_producto->imagen); ?>

                                            <?php endif; ?>
                                            ">   
                                        </label>
                                    </div>
                                    <input id="uploadImage1" class="form-control-file" type="file" name="imagen" onchange="previewImagePrincipal(1);" hidden/>
                                    <?php $__errorArgs = ['imagen'];
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
                            </div>
                            <p class="text-secondary mb-2 small text-uppercase fw-bold" id="title_opcional">Datos adicionales</p>

                            <div class="row mt-2">
                                <div class="col-12 col-md-2 col-lg-2" id="act_vidautil">
                                    <div class="mb-3">
                                        <label for="vidautil__id" class="">Vida útil</label>
                                        <div class="input-group input-group-sm mb-3">
                                            <input type="text" name="vida_util" value="<?php echo e($admin_producto->vida_util); ?>" class="form-control form-control-sm <?php $__errorArgs = ['vida_util'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="vidautil__id">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">AÑOS</span>
                                        </div>
                                        <?php $__errorArgs = ['vida_util'];
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
                                </div>
                                <div class="col-12 col-md-3 col-lg-3" id="pt_costo">
                                    <div class="mb-3">
                                        <label for="costo__id" class="">Costo</label>
                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">S/</span>
                                            <input type="text" name="costo" value="<?php echo e($admin_producto->costo); ?>" class="form-control form-control-sm <?php $__errorArgs = ['costo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="costo__id">
                                        </div>
                                        <?php $__errorArgs = ['costo'];
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
                                </div>
                                <div class="col-12 col-md-3 col-lg-3" id="act_depreciacion">
                                    <div class="mb-3">
                                        <label for="depreciacion__id" class="">Depreciación</label>
                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">S/</span>
                                            <input type="text" name="depreciacion" value="<?php echo e($admin_producto->depreciacion); ?>" class="form-control form-control-sm <?php $__errorArgs = ['depreciacion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="depreciacion__id">
                                        </div>
                                        <?php $__errorArgs = ['depreciacion'];
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
                                </div>
                                <div class="col-12 col-md-3 col-lg-3" id="act_tipo_adquisicion">
                                    <div class="mb-3">
                                        <label for="tipo_adquisicion_id" class="">Tipo de adquisición</label>
                                        <div class="input-group input-group-sm mb-3">
                                            <select class="form-select form-select-sm <?php $__errorArgs = ['tipo_adquisicion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="tipo_adquisicion" id="tipo_adquisicion_id">
                                                <option selected='selected' hidden='hidden' >-- Seleccione --</option>
                                                <option value="Publico" <?php echo e($admin_producto->tipo_adquisicion == 'Publico' ? 'selected' : ''); ?>>Publico</option>
                                                <option value="Privado" <?php echo e($admin_producto->tipo_adquisicion == 'Privado' ? 'selected' : ''); ?>>Privado</option>
                                            </select>
                                        </div>
                                        <?php $__errorArgs = ['tipo_adquisicion'];
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
                                </div>
                                <div class="col-12 col-md-3 col-lg-3" id="pt_precio">
                                    <div class="mb-3">
                                        <label for="precio__id" class="">Precio</label>
                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">S/</span>
                                            <input type="text" name="precio" value="<?php echo e($admin_producto->precio); ?>" class="form-control form-control-sm <?php $__errorArgs = ['precio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="precio__id">
                                        </div>
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
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3" id="pt_imgopcional">
                                <p class="text-muted mb-2 small text-uppercase fw-bold">Cargue más imágenes (opcional)</p> 
                                <div class="card imagecardfiles" style="min-height: 200px">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <label for="multiple__imagenes" class="btn btn-sm btn-secondary"><i class="bi bi-upload me-2"></i>Subir imágenes</label>
                                                <input type="file" onchange="preview()" multiple accept="image/*" id="multiple__imagenes" name="images_opcional[]" hidden>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <p id="numero_archivos" class="text-start text-md-end small fw-bold text-muted">0 archivos seleccionados</p>
                                            </div>
                                        </div>
                                        <div id="container_images_multiple">
    
                                        </div>
                                        <div class="row my-3">
                                            <?php $__currentLoopData = $admin_producto->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="col-6 col-md-3 col-lg-4">
                                                    <div class="card text-center imagecard rounded bg-light mb-0" style="height: 160px">  
                                                        <label class=" my-auto text-center">
                                                            <img for="uploadImage1" id="uploadPreview1" alt="" class="py-auto rounded" style="width: 100%; height: 156px;" src="<?php echo e($image->url); ?>">   
                                                        </label>
                                                        <div class="card-img-overlay">
                                                            <a href="/images/<?php echo e($image->id); ?>/delete" class="btn btn-danger btn-sm float-end"><i class="bi bi-trash"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>    
                        <div class="col-12 col-md-4 col-lg-3">
                            <div class="mb-3" id="etiquetas">
                                <p class="text-secondary mb-2 small text-uppercase fw-bold">Etiquetas</p>
                                <select class="js-example-basic-multiple form-select form-select-sm select2" name="etiquetas[]" multiple="multiple" style="width:100%">
                                    <?php $__currentLoopData = $etiquetas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $etiqueta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option <?php if($admin_producto->etiquetas->contains($etiqueta->id)): ?> selected <?php endif; ?> value="<?php echo e($etiqueta->id); ?>"><?php echo e($etiqueta->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="mb-3" id="proveedores">
                                <p class="text-secondary mb-2 small text-uppercase fw-bold">Proveedores</p>
                                    <div class="col-12 mb-2">
                                        <select class="js-example-basic-multiple form-select form-select-sm select2" name="proveedores[]" id="mostrar_prov" multiple="multiple" style="width:100%">
                                        </select>
                                    </div>
                            </div>
                        </div>
                    </div>                                      
                </div>
            </div>
            <div class="pt-3 pb-3 text-end" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
                <a href="<?php echo e(url('admin-productos')); ?>" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary px-5 my-2 my-md-0 text-white">Actualizar</button>
            </div>     
        </div> 
    </form>
    

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>
<script>
    function previewImagePrincipal(nb) {        
        var reader = new FileReader();         
        reader.readAsDataURL(document.getElementById('uploadImage'+nb).files[0]);                
        reader.onload = function (e) {   
            document.getElementById('uploadPreview'+nb).src = e.target.result;                  
        };     
    }
</script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
<script>
    $(document).ready(function() {
            valor_id_prod = $("#valir_prod").val();
            var __tipo = $("#tipos__bien_id").val();
                
                if (__tipo == 1)
                {
                    $("#title_opcional").hide();
                    $("#act_vidautil").show();
                    $("#act_costo").show();
                    $("#act_depreciacion").show();
                    $("#act_tipo_adquisicion").show();
                    $("#pt_precio").show();
                    $("#pt_costo").show();
                    $("#pt_imgopcional").hide();
                    $("#proveedores").show();
                    $("#etiquetas").show();

                    $.get('/busqueda_proved_edit', {valor_tip: 2, valor_id_prod:valor_id_prod}, function(bienes) {
                        $('#mostrar_prov').empty();
                        $('#mostrar_prov').append('<option>Seleccione una opcion</option>');
                        $.each(bienes, function(index, value) {
                            if(index != '' && value[1] == ''){
                                $('#mostrar_prov').append("<option value='"+index+"'>"+value[0]+"</option>");
                            }else{
                                $('#mostrar_prov').append("<option selected value='"+index+"'>"+value[0]+"</option>");
                            }
                            
                        });
                    });
                }
                if (__tipo == 2)
                {
                    $("#title_opcional").show();
                    $("#act_vidautil").show();
                    $("#act_costo").show();
                    $("#act_depreciacion").show();
                    $("#act_tipo_adquisicion").show();
                    $("#pt_precio").show();
                    $("#pt_costo").show();
                    $("#pt_imgopcional").hide();
                    $("#proveedores").show();
                    $("#etiquetas").show();

                    $.get('/busqueda_proved_edit', {valor_tip: 3, valor_id_prod:valor_id_prod}, function(bienes) {
                        $('#mostrar_prov').empty();
                        $('#mostrar_prov').append('<option>Seleccione una opcion</option>');
                        $.each(bienes, function(index, value) {
                            if(index != '' && value[1] == ''){
                                $('#mostrar_prov').append("<option value='"+index+"'>"+value[0]+"</option>");
                            }else{
                                $('#mostrar_prov').append("<option selected value='"+index+"'>"+value[0]+"</option>");
                            }
                            
                        });
                    });
                }

                if (__tipo == 3 || __tipo == 4)
                {
                    $("#title_opcional").hide();
                    $("#act_vidautil").show();
                    $("#act_costo").show();
                    $("#act_depreciacion").show();
                    $("#act_tipo_adquisicion").show();
                    $("#pt_precio").show();
                    $("#pt_costo").show();
                    $("#pt_imgopcional").show();
                    $("#show").hide();
                    $("#proveedores").show();
                    $("#etiquetas").show();

                    $.get('/busqueda_proved_edit', {valor_tip: __tipo, valor_id_prod:valor_id_prod}, function(bienes) {
                        $('#mostrar_prov').empty();
                        $('#mostrar_prov').append('<option>Seleccione una opcion</option>');
                        $.each(bienes, function(index, value) {
                            if(index != '' && value[1] == ''){
                                $('#mostrar_prov').append("<option value='"+index+"'>"+value[0]+"</option>");
                            }else{
                                $('#mostrar_prov').append("<option selected value='"+index+"'>"+value[0]+"</option>");
                            }
                            
                        });
                    });
                }
    });

    $("#title_opcional").hide();
    $("#mp_tempconservacion").hide();
    $("#pt_precio").hide();
    $("#pt_costo").hide();
    $("#pt_imgopcional").hide();
    $("#etiquetas").hide();
    $("#proveedores").hide();
    
</script>
<script>
    let multiple__imagenes = document.getElementById("multiple__imagenes");
    let container_images_multiple = document.getElementById("container_images_multiple");
    let numero_archivos = document.getElementById("numero_archivos");

    function preview(){
        container_images_multiple.innerHTML = "";
        numero_archivos.textContent = `${multiple__imagenes.files.length} archivos seleccionados`;

        for(i of multiple__imagenes.files){
            let reader = new FileReader();
            let figure = document.createElement("figure");
            let figCap = document.createElement("figcaption");
            figCap.innerText = i.name;
            figure.appendChild(figCap);
            reader.onload=()=>{
                let img = document.createElement("img");
                img.setAttribute("src",reader.result);
                img.classList.add('img_opcional');
                figure.insertBefore(img,figCap);
            }
            container_images_multiple.appendChild(figure);
            reader.readAsDataURL(i);
        }

    }

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\CESHERPIPO\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/PRINCIPAL/configuraciones/productos/edit.blade.php ENDPATH**/ ?>