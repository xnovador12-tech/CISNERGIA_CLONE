<form method="POST" action="{{ route('admin-productos.update', $admin_producto->slug) }}" enctype="multipart/form-data"
    autocomplete="off" class="needs-validation" novalidate>
    @csrf
    @method('put')
    <div class="modal fade" id="editproducto{{ $admin_producto->slug }}" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white py-2">
                    <span class="modal-title text-uppercase small" id="staticBackdropLabel">Actualizar Producto</span>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card border-0 rounded-0 border-start border-3 border-info bg-light mb-4"
                        style="box-shadow: rgba(17, 17, 26, 0.1) 0px 1px 0px;">
                        <div class="card-body py-2">
                            <i class="bi bi-info-circle text-info me-2"></i>Importante:
                            <ul class="list-unstyled mb-0 pb-0">
                                <li class="mb-0 pb-0">
                                    <small class="text-muted py-0 my-0 text-start"> Se consideran campos obligatorios
                                        los campos que tengan este símbolo: <span class="text-danger">*</span></small>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="codigo_id">Código<span class="text-danger">*</span></label>
                                <input type="text" name="codigo" id="codigo_id" class="form-control"
                                    value="{{ $admin_producto->codigo }}" maxLength="50" required>
                                @error('codigo')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <div class="invalid-feedback">
                                    El campo no puede estar vacío
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="nombre_id">Nombre<span class="text-danger">*</span></label>
                                <input type="text" name="nombre" id="nombre_id" class="form-control"
                                    value="{{ $admin_producto->nombre }}" maxLength="100" required>
                                @error('nombre')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <div class="invalid-feedback">
                                    El campo no puede estar vacío
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="precio_id">Precio (S/)<span class="text-danger">*</span></label>
                                <input type="number" name="precio" id="precio_id" class="form-control"
                                    value="{{ $admin_producto->precio }}" step="0.01" min="0" required>
                                @error('precio')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <div class="invalid-feedback">
                                    El campo no puede estar vacío
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="categoria_id">Categoría<span class="text-danger">*</span></label>
                                <select name="categoria_id" id="categoria_id" class="form-select" required>
                                    <option value="">Seleccionar categoría</option>
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id }}" {{ $admin_producto->categoria_id == $categoria->id ? 'selected' : '' }}>
                                            {{ $categoria->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('categoria_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <div class="invalid-feedback">
                                    Debe seleccionar una categoría
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="medida_id">Medida<span class="text-danger">*</span></label>
                                <select name="medida_id" id="medida_id" class="form-select" required>
                                    <option value="">Seleccionar medida</option>
                                    @foreach ($medidas as $medida)
                                        <option value="{{ $medida->id }}" {{ $admin_producto->medida_id == $medida->id ? 'selected' : '' }}>
                                            {{ $medida->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('medida_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <div class="invalid-feedback">
                                    Debe seleccionar una medida
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="marca_id">Marca<span class="text-danger">*</span></label>
                                <select name="marca_id" id="marca_id" class="form-select" required>
                                    <option value="">Seleccionar marca</option>
                                    @foreach ($marcas as $marca)
                                        <option value="{{ $marca->id }}" {{ $admin_producto->marca_id == $marca->id ? 'selected' : '' }}>
                                            {{ $marca->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('marca_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <div class="invalid-feedback">
                                    Debe seleccionar una marca
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="imagen_id">Imagen</label>
                                <input type="file" name="imagen" id="imagen_id" class="form-control"
                                    accept="image/*">
                                @error('imagen')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <small class="text-muted">Formatos permitidos: JPG, PNG, JPEG. Tamaño máximo: 2MB</small>
                                @if ($admin_producto->imagen)
                                    <div class="mt-2">
                                        <small class="text-success"><i class="bi bi-check-circle me-1"></i>Imagen actual: {{ $admin_producto->imagen }}</small>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="descripcion_id">Descripción</label>
                                <textarea name="descripcion" id="descripcion_id" class="form-control" rows="3"
                                    maxlength="500">{{ $admin_producto->descripcion }}</textarea>
                                @error('descripcion')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary text-uppercase small px-4" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-dark text-uppercase small px-5 text-white">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
</form>
