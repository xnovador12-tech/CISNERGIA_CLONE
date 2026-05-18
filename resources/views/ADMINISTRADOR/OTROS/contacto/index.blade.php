@extends('TEMPLATES.administrador')

@section('title', 'MENSAJES DE CONTACTO')

@section('css')

@endsection
 
@section('content')
<!-- Encabezado -->
<div class="header_section">
    <div class="bg-transparent mb-3" style="height: 80px"></div>
    <div class="container-fluid">
        <div class="" data-aos="fade-right">
            <h1 class="titulo h2 text-uppercase fw-bold mb-0">MENSAJES DE CONTACTO</h1>
            <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-decoration-none link" href="">CRM</a></li>
                    <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ url('admin-contacto') }}">Contacto</a></li>
                    <li class="breadcrumb-item link" aria-current="page">Inicio</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- fin encabezado -->

{{-- Contenido --}}
    <div class="container-fluid">
        <div class="card border-4 borde-top-primary shadow-sm h-100" style="border-radius: 20px; min-height: 500px" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
            <div class="card-body">
                <div class="mb-4 d-flex justify-content-between align-items-center">
                    <span class="text-uppercase text-muted small">
                        <i class="bi bi-journal-text me-2"></i>
                        Total: <span class="fw-bold text-dark">{{ $admin_contactos->count() }}</span> mensajes de contactos
                    </span>
                </div>
                <table id="display" class="table table-hover table-sm" cellspacing="0" style="width:100%">
                    <thead class="bg-dark text-white border-0">
                        <tr>
                            <th class="h6 small text-center text-uppercase fw-bold">N°</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Nombres</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Email</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Telefono</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Tipo de proyecto</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Estado</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $contador = 1;
                        @endphp
                        @foreach ($admin_contactos as $admin_contacto)
                            <tr>
                                <td class="fw-normal text-center align-middle">{{ $contador }}</td>
                                <td class="fw-normal text-center align-middle">{{ $admin_contacto->nombre }}</td>
                                <td class="fw-normal text-center align-middle">{{ $admin_contacto->email }}</td>
                                <td class="fw-normal text-center align-middle">{{ $admin_contacto->telefono }}</td>
                                <td class="fw-normal text-center align-middle">{{ $admin_contacto->tipo_proyecto }}</td>
                                <td class="fw-normal text-center align-middle small">
                                    <span class="text-uppercase badge 
                                    @if($admin_contacto->estado == 'Atendido') bg-success @else bg-warning @endif small border-0">{{ $admin_contacto->estado }}</span>
                                </td>  
                                <td class="text-center align-middle">                                        
                                    <div class="text-start text-md-center">
                                        <div class="dropstart">
                                            <button class="btn btn-sm btn-light rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 36px; height: 36px; padding: 0;">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow">                                                
                                                <li class="dropdown-item">
                                                    <button class="bg-transparent border-0 px-0 mx-0" data-bs-toggle="modal" data-bs-target="#showprospecto{{ $admin_contacto->slug }}"><i class="bi bi-eye-fill me-2"></i>Ver detalles</button>
                                                </li>                                                  
                                            </ul>
                                        </div>
                                    </div>      
                                </td>
                            </tr>
                            @php
                                $contador++;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @foreach($admin_contactos as $admin_contacto)
            @include('ADMINISTRADOR.OTROS.contacto.show')            
        @endforeach
    </div>
{{-- Fin contenido --}}
@endsection

@section('js')
    <!--sweet alert agregar-->
    @if(session('new_registration') == 'ok')
    <script>
        Swal.fire({
        icon: 'success',
        confirmButtonColor: '#1C3146',
        title: '¡Éxito!',
        text: 'Nuevo registro guardado correctamente',
        })
    </script>
    @endif

    <!--sweet alert actualizar-->
    @if(session('update') == 'ok')
    <script>
        Swal.fire({
        icon: 'success',
        confirmButtonColor: '#FB7000',
        title: '¡Contacto atendido!',
        text: 'El contacto fue marcado como atendido correctamente.',
        confirmButtonText: 'Entendido',
        })
    </script>
    @endif

    <!--sweet alert correo enviado-->
    @if(session('email_sent') == 'ok')
    <script>
        Swal.fire({
        icon: 'success',
        confirmButtonColor: '#1C3146',
        title: '¡Respuesta Enviada!',
        text: 'El correo de respuesta ha sido enviado exitosamente al prospecto.',
        })
    </script>
    @endif

    <!--sweet alert error al enviar correo-->
    @if(session('email_error'))
    <script>
        Swal.fire({
        icon: 'error',
        confirmButtonColor: '#1C3146',
        title: 'Error al enviar',
        text: 'Hubo un error al enviar el correo: {{ session("email_error") }}',
        })
    </script>
    @endif

    <!--sweet alert ya atendido-->
    @if(session('already_attended') == 'ok')
    <script>
        Swal.fire({
        icon: 'info',
        confirmButtonColor: '#FB7000',
        title: 'Prospecto ya atendido',
        text: 'Este prospecto ya ha sido atendido previamente.',
        confirmButtonText: 'Entendido',
        })
    </script>
    @endif

    <!--sweet alert eliminar-->
    @if(session('delete') == 'ok')
    <script>
    Swal.fire({
        icon: 'success',
        confirmButtonColor: '#1C3146',
        title: '¡Eliminado!',
        text: 'Registro eliminado correctamente',
        })
    </script>
    @endif
    <script>
    $('.form-delete').submit(function(e){
        e.preventDefault();

        Swal.fire({
        title: '¿Estas seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1C3146',
        cancelButtonColor: '#FF9C00',
        confirmButtonText: '¡Sí, eliminar!',
        cancelButtonText: 'Cancelar'
        }).then((result) => {
        if (result.isConfirmed) {
            
        this.submit();
        }
        })

    });
    </script>

    <script>
        (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
            })
        })()
    </script>
@endsection