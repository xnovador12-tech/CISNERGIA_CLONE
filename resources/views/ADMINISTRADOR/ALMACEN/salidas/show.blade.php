@extends('TEMPLATES.administrador')

@section('title', 'SALIDAS')

@section('css')
@endsection

@section('content')
<!-- Encabezado -->
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">SALIDAS</h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none" href="">Almacén</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none" href="{{url('admin-salidas')}}">Salidas</a></li>
                        <li class="breadcrumb-item" aria-current="page">{{ $admin_salida->codigo }}</li>
                </div>
            </div>
        </div>
    </div>
<!-- fin encabezado -->

    {{-- contenido --}}
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
                                    <p class="fw-normal mb-0">{{ $admin_salida->codigo }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-2 col-lg-2">
                            <div class="card mb-3">
                                <div class="card-header py-1">
                                    <p class="small text-uppercase mb-0">Motivo</p>
                                </div>
                                <div class="card-body py-1">
                                    <p class="fw-normal mb-0">{{ $admin_salida->motivo }}</p>
                                </div>
                            </div>
                        </div>
                        @if($admin_salida->motivo == 'Venta')
                        <div class="col-12 col-md-4 col-lg-2">
                            <div class="card mb-3">
                                <div class="card-header py-1">
                                    <p class="small text-uppercase mb-0">Código de venta</p>
                                </div>
                                <div class="card-body py-1">
                                    <p class="fw-normal mb-0">{{ $admin_salida->codigo_venta }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($admin_salida->motivo == 'Muestra')
                        @php
                            $cliente_nombre = \App\Models\Cliente::where('id', $admin_salida->cliente)->first();
                        @endphp
                        <div class="col-12 col-md-4 col-lg-2">
                            <div class="card mb-3">
                                <div class="card-header py-1">
                                    <p class="small text-uppercase mb-0">Cliente</p>
                                </div>
                                <div class="card-body py-1">
                                    <p class="fw-normal mb-0">{{ $cliente_nombre->nombre.' '.$cliente_nombre->apellidos }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="col-12 col-md-4 col-lg-2">
                            <div class="card mb-3">
                                <div class="card-header py-1">
                                    <p class="small text-uppercase mb-0">Fecha</p>
                                </div>
                                <div class="card-body py-1">
                                    <p class="fw-normal mb-0">{{ $admin_salida->fecha }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <p class="text-primary mb-2 small text-uppercase fw-bold">Detalles</p>
                    <table class=" display table table-sm table-hover">
                        <thead class="bg-light">
                        <tr>
                            <th class="fw-bold small text-uppercase">N°</th>
                            <th class="fw-bold small text-uppercase">Tipo</th>
                            <th class="fw-bold small text-uppercase">Descripción</th>
                            <th class="fw-bold small text-uppercase">U.M.</th>
                            <th class="fw-bold small text-uppercase">Cantidad</th>
                            <th class="fw-bold small text-uppercase">Precio</th>
                        </tr>
                        </thead>
                        <tbody id="dt_solicitudes">
                            @php 
                                $contador = 1;
                            @endphp 
                            @foreach($admin_dtlle as $admin_dtlles)
                                @php
                                    $valor_producto = \App\Models\Producto::where('id',$admin_dtlles->id_producto)->first();
                                @endphp
                                <tr class="text-center">
                                    <td class="fw-normal align-middle">{{ $contador }}</td>
                                    <td class="fw-normal align-middle">{{ $valor_producto->tipo->name }}</td>
                                    <td class="fw-normal align-middle">{{ $admin_dtlles->producto }}</td>
                                    <td class="fw-normal align-middle">{{ $admin_dtlles->umedida }}</td>
                                    <td class="fw-normal align-middle">{{ $admin_dtlles->cantidad }}</td>
                                    <td class="fw-normal align-middle">{{ $admin_dtlles->precio == 'null'?'No requerido':$admin_dtlles->precio }}</td>
                                </tr>
                            @php 
                                $contador++;
                            @endphp 
                            @endforeach
                        </tbody>
                    </table>
                    
                    <div class="row justify-content-beetween mt-3">
                        <div class="col-12 col-md-5">
                            <div class="card mb-3">
                                <div class="card-header py-1">
                                    <p class="small text-uppercase mb-0">Observaciones</p>
                                </div>
                                <div class="card-body py-1">
                                    <p class="fw-normal mb-0">{{ $admin_salida->descripcion?$admin_salida->descripcion:'Sin observaciones' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-2"></div>
                        <div class="col-12 col-md-5">
                            <table class="w-100">
                                <tr>
                                    <td class="border-0 fw-bold ps-2 py-1 bg-light" style="width: 50%">
                                        TOTAL
                                    </td>
                                    <td class="border-0 fw-bold pe-2 py-1 bg-light" style="width: 50%">
                                        <div class="clearfix">
                                            <span class="float-start ps-2">- </span>
                                            <span class="float-end">
                                                {{ $admin_salida->total }}
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
                <a href="{{ url('admin-salidas') }}" class="btn btn-outline-secondary px-5">Volver</a>
            </div>     
        </div> 
    {{-- fin contenido --}}

    <!-- Modal para ver imagen -->
    <div class="modal fade" id="modalImagen" tabindex="-1" aria-labelledby="modalImagenLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalImagenLabel">Imagen del Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="imagenModal" src="" alt="Producto" class="img-fluid" style="max-height: 500px;">
                    <p id="nombreProductoModal" class="mt-3 fw-bold"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
function verImagen(urlImagen, nombreProducto) {
    console.log('URL de la imagen:', urlImagen); // Verificar que la URL es correcta
    document.getElementById('imagenModal').src = urlImagen;
    document.getElementById('nombreProductoModal').textContent = nombreProducto;
    
    const modal = new bootstrap.Modal(document.getElementById('modalImagen'));
    modal.show();
}
</script>
@endsection