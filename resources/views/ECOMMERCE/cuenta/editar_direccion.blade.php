<!-- editar direcciones -->
 <div class="modal fade" id="editar_direcciones{{$direccion->id}}" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius: 16px; border: none;">
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold">Editar dirección</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('ecommerce-direccion.actualizar', $direccion->id) }}" enctype="multipart/form-data" autocomplete="off" class="needs-validation" novalidate>
              @csrf
              @method('PUT')      
            <div class="mb-3">
              <label class="form-label">Referencia</label>
              <input type="text" class="form-control" name="referencia" value="{{$direccion->referencia}}">
            </div>
            <div class="mb-3">
              <label class="form-label">Dirección</label>
              <input type="text" name="direccion" class="form-control" value="{{$direccion->direccion}}">
            </div>
            <div class="mb-3">
              <label class="form-label">Departamento - provincia - distrito</label>
              <div class="d-flex gap-2">
                <select class="form-select select2_bootstrap_2" name="departamento_id" id="departamento_id">
                    <option value="{{$direccion->departamento->id ?? ''}}">{{$direccion->departamento->nombre ?? 'Seleccionar'}}</option>

                    @foreach($departamentos as $dep)
                        <option value="{{ $dep->id }}">{{ $dep->nombre }}</option>
                    @endforeach
                </select>
                <select class="form-select select2_bootstrap_2" name="provincia_id" id="provincia_id">
                    <option value="{{$direccion->provincia->id ?? ''}}">{{$direccion->provincia->nombre ?? 'Seleccionar'}}</option>
                </select>
                <select class="form-select select2_bootstrap_2" name="distrito_id" id="distrito_id">
                    <option value="{{$direccion->distrito->id ?? ''}}">{{$direccion->distrito->nombre ?? 'Seleccionar'}}</option>
                </select>
            </div>
          </div>
          <div class="modal-footer border-0">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Actualizar cambios</button>
          </div>
        </form>
    </div>
  </div>
</div>
</div>