@extends('TEMPLATES.ecommerce')

@section('title', 'Políticas de Privacidad')

@section('content')
<div class="container py-5" style="margin-top: 80px;">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                <div class="text-center mb-5">
                    <h1 class="fw-bold" style="color: #1C3146;">Políticas de Privacidad</h1>
                    <p class="text-muted">Última actualización: {{ date('d/m/Y') }}</p>
                </div>

                <div class="privacy-content" style="color: #495057; line-height: 1.8;">
                    <h4 class="fw-bold mt-4" style="color: #1C3146;">1. Introducción</h4>
                    <p>Bienvenido a <strong>Cisnergia Perú</strong>. Nos tomamos muy en serio la privacidad de sus datos. Esta política describe cómo recopilamos, usamos, protegemos y manejamos su información personal y los datos obtenidos a través de plataformas de terceros, específicamente Facebook e Instagram (Meta Platforms, Inc.).</p>

                    <h4 class="fw-bold mt-4" style="color: #1C3146;">2. Información que Recopilamos</h4>
                    <p>Al interactuar con nuestra plataforma web, ecommerce o nuestras redes sociales oficiales, podemos recopilar la siguiente información:</p>
                    <ul>
                        <li><strong>Datos proporcionados por el usuario:</strong> Nombre, correo electrónico, teléfono y dirección al registrarse o realizar una compra.</li>
                        <li><strong>Datos de Redes Sociales (Meta API):</strong> Si interactúa con nuestras páginas de Facebook o Instagram, recopilamos su nombre público (Username / First Name, Last Name), foto de perfil pública y el contenido de los comentarios o mensajes enviados a nuestras cuentas, con el único fin de brindarle atención al cliente.</li>
                    </ul>

                    <h4 class="fw-bold mt-4" style="color: #1C3146;">3. Uso de la Información</h4>
                    <p>La información recopilada se utiliza exclusivamente para los siguientes propósitos:</p>
                    <ul>
                        <li>Procesar y gestionar sus pedidos y cotizaciones.</li>
                        <li>Responder a sus consultas, comentarios y mensajes de manera oportuna a través de nuestro CRM interno.</li>
                        <li>Mejorar nuestro servicio de atención al cliente y personalizar su experiencia.</li>
                        <li>Enviar notificaciones comerciales o boletines informativos (solo si ha dado su consentimiento explícito).</li>
                    </ul>
                    <p><em>En ningún caso Cisnergia Perú venderá, alquilará ni comercializará su información personal a terceros.</em></p>

                    <h4 class="fw-bold mt-4" style="color: #1C3146;">4. Protección y Retención de Datos</h4>
                    <p>Implementamos medidas de seguridad técnicas y organizativas para proteger su información contra accesos no autorizados. Los datos obtenidos a través de la API de Meta se almacenan temporalmente en nuestros servidores seguros únicamente durante el tiempo necesario para gestionar su consulta o proceso de venta.</p>

                    <h4 class="fw-bold mt-4" style="color: #1C3146;">5. Derechos del Usuario (Solicitud de Eliminación de Datos)</h4>
                    <p>Usted tiene derecho a solicitar el acceso, modificación o eliminación completa de sus datos personales de nuestros sistemas. Si desea que eliminemos cualquier registro de sus interacciones o datos asociados a su perfil de Meta o cuenta web, puede enviar una solicitud formal a:</p>
                    <div class="p-3 my-3 rounded" style="background-color: #f8f9fa; border-left: 4px solid #20c997;">
                        <strong>Correo electrónico:</strong> privacidad@cisnergia.com<br>
                        <strong>Asunto:</strong> Solicitud de Eliminación de Datos de Usuario
                    </div>
                    <p>Procesaremos su solicitud en un plazo máximo de 7 días hábiles, eliminando permanentemente sus datos de nuestras bases de datos.</p>

                    <h4 class="fw-bold mt-4" style="color: #1C3146;">6. Cambios en esta Política</h4>
                    <p>Cisnergia Perú se reserva el derecho de modificar esta política en cualquier momento. Se notificará a los usuarios sobre cambios significativos a través de nuestra plataforma web.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection