<div class="modal fade" id="reporte_PDF" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white py-2">
                <span class="modal-title" id="staticBackdropLabel">Imprimir reporte en PDF</span>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {!! Form::open(['route'=>'admin-proveedores.resultadosPDF', 'method'=>'POST']) !!}
                    <div class="my-3" id="">
                        <label for="">Filtrar Sede</label>
                        <select name="sede_id" id="" class="form-select form-select-sm">
                            <option value="" selected="selected" hidden="hidden">-- Selecione --</option>
                            @foreach($sedes as $sede)
                                @if(Gate::allows('gerencia',Auth()->user()))
                                    <option value="{{ $sede->id }}">{{ $sede->name }}</option>
                                @elseif(Gate::allows('administracion',Auth()->user()) || Gate::allows('operaciones',Auth()->user()))
                                    @if($sede->id == Auth::user()->persona->sede_id)
                                        <option value="{{ $sede->id }}">{{ $sede->name }}</option>
                                    @endif
                                @endif
                            @endforeach
                        </select>
                    </div>
                            
                    <button type="submit" target=_blank  class="btn btn-dark w-100 mt-3">Generar Reporte</button>
                {!! Form::close() !!}
                <a href="{{ route('print-proveedores.pdf') }}" target=_blank class="border border-secondary text-secondary btn w-100 mt-3">Descargar Todo</a>
            </div>
        </div>
    </div>
</div>