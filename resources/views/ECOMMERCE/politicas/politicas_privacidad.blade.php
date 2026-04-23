@extends('TEMPLATES.ecommerce')

@section('title', 'Políticas de Privacidad | Cisnergia')

@section('css')
<style>
    :root {
        --cisnergia-dark: #1C3146;
        --cisnergia-green: #20c997;
        --cisnergia-muted: #6c757d;
    }
    
    .policy-header {
        background-color: #f8fafc;
        padding: 60px 0 40px;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .policy-sidebar {
        position: sticky;
        top: 100px;
    }
    
    .policy-list-group .list-group-item {
        border: none;
        border-left: 4px solid transparent;
        border-radius: 0 !important;
        padding: 15px 20px;
        color: var(--cisnergia-muted);
        font-weight: 500;
        background: transparent;
        transition: all 0.3s ease;
        margin-bottom: 5px;
        cursor: pointer;
    }
    
    .policy-list-group .list-group-item:hover {
        background-color: rgba(28, 49, 70, 0.03);
        color: var(--cisnergia-dark);
    }
    
    .policy-list-group .list-group-item.active {
        background-color: rgba(32, 201, 151, 0.1);
        color: var(--cisnergia-dark);
        border-left-color: var(--cisnergia-green);
        font-weight: 700;
    }
    
    .policy-content {
        padding: 20px 30px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        min-height: 500px;
    }
    
    .policy-content h2 {
        color: var(--cisnergia-dark);
        font-weight: 800;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f1f5f9;
    }
    
    .policy-content p, .policy-content li {
        color: #475569;
        line-height: 1.8;
        font-size: 1.05rem;
    }
    
    .policy-content ul {
        padding-left: 20px;
        margin-bottom: 20px;
    }
</style>
@endsection

@section('content')
<div class="policy-header mt-5">
    <div class="container text-center">
        <h1 class="fw-bold display-5" style="color: #1C3146;">Políticas de Privacidad</h1>
        <p class="text-muted fs-5 mt-2">Cómo protegemos y gestionamos su información en Cisnergia Perú.</p>
        <span class="badge bg-white text-dark border px-3 py-2 mt-2">Última actualización: {{ date('d/m/Y') }}</span>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="policy-sidebar">
                <div class="list-group policy-list-group" id="list-tab" role="tablist">
                    <a class="list-group-item list-group-item-action active" id="list-intro-list" data-bs-toggle="list" href="#list-intro" role="tab">1. Introducción y Alcance</a>
                    <a class="list-group-item list-group-item-action" id="list-datos-list" data-bs-toggle="list" href="#list-datos" role="tab">2. Información que Recopilamos</a>
                    <a class="list-group-item list-group-item-action" id="list-uso-list" data-bs-toggle="list" href="#list-uso" role="tab">3. Uso de la Información</a>
                    <a class="list-group-item list-group-item-action" id="list-terceros-list" data-bs-toggle="list" href="#list-terceros" role="tab">4. Redes Sociales y Terceros (Meta)</a>
                    <a class="list-group-item list-group-item-action" id="list-seguridad-list" data-bs-toggle="list" href="#list-seguridad" role="tab">5. Seguridad y Retención</a>
                    <a class="list-group-item list-group-item-action" id="list-derechos-list" data-bs-toggle="list" href="#list-derechos" role="tab">6. Derechos del Usuario (ARCO)</a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-8">
            <div class="policy-content tab-content" id="nav-tabContent">
                
                <div class="tab-pane fade show active" id="list-intro" role="tabpanel" aria-labelledby="list-intro-list">
                    <h2>1. Introducción y Alcance</h2>
                    <p>En <strong>Cisnergia Perú</strong>, estamos comprometidos con el desarrollo de soluciones energéticas sostenibles y la protección de la privacidad de nuestros clientes. Esta Política de Privacidad describe cómo recopilamos, utilizamos y salvaguardamos su información personal en todo nuestro ecosistema, incluyendo:</p>
                    <ul>
                        <li>Nuestra plataforma E-commerce de venta de kits y componentes solares.</li>
                        <li>Nuestros servicios de Ingeniería, Adquisición y Construcción (EPC) y Operación & Mantenimiento (O&M).</li>
                        <li>Sistemas de Monitoreo y Sistemas Contra Incendios.</li>
                        <li>Interacciones en nuestras redes sociales, gestionadas a través de nuestro CRM.</li>
                    </ul>
                    <p>Al utilizar nuestros servicios, usted acepta las prácticas descritas en este documento, en cumplimiento con la Ley de Protección de Datos Personales del Perú (Ley N° 29733).</p>
                </div>

                <div class="tab-pane fade" id="list-datos" role="tabpanel" aria-labelledby="list-datos-list">
                    <h2>2. Información que Recopilamos</h2>
                    <p>Para brindarle soluciones eficientes y personalizadas, recopilamos los siguientes tipos de datos:</p>
                    <ul>
                        <li><strong>Datos de Identificación y Facturación:</strong> Nombre, DNI/RUC, dirección, teléfono y correo electrónico proporcionados al registrarse en nuestra tienda o solicitar cotizaciones para proyectos.</li>
                        <li><strong>Datos Técnicos:</strong> Información sobre consumos eléctricos, dimensiones de proyectos u otros datos técnicos suministrados por el cliente para el dimensionamiento de sistemas fotovoltaicos.</li>
                        <li><strong>Datos de Navegación:</strong> Direcciones IP, tipo de navegador, tiempo de visita e interacciones en nuestra plataforma web.</li>
                    </ul>
                </div>

                <div class="tab-pane fade" id="list-uso" role="tabpanel" aria-labelledby="list-uso-list">
                    <h2>3. Uso de la Información</h2>
                    <p>Cisnergia utiliza los datos recopilados estrictamente para los siguientes fines operativos y comerciales:</p>
                    <ul>
                        <li>Procesar sus compras del e-commerce, gestionar pagos y coordinar la logística de envío.</li>
                        <li>Elaborar propuestas técnicas, estudios de viabilidad y cotizaciones personalizadas para proyectos solares e industriales.</li>
                        <li>Brindar soporte técnico y gestionar garantías sobre equipos adquiridos o instalados.</li>
                        <li>Mejorar nuestra plataforma web y administrar nuestra base de datos a través de nuestro CRM interno.</li>
                        <li>Enviar boletines informativos o campañas de <em>Email Marketing</em> sobre nuevos servicios o promociones (solo si el cliente lo ha autorizado).</li>
                    </ul>
                </div>

                <div class="tab-pane fade" id="list-terceros" role="tabpanel" aria-labelledby="list-terceros-list">
                    <h2>4. Redes Sociales y Terceros (API Meta)</h2>
                    <p>Para garantizar una atención al cliente omnicanal de primera calidad, utilizamos interfaces de programación de aplicaciones (APIs) provistas por terceros, específicamente Meta Platforms, Inc. (Facebook e Instagram).</p>
                    <p><strong>Recopilación de Datos de Meta:</strong> Cuando usted interactúa (comenta o envía mensajes) con las páginas oficiales de Cisnergia, nuestro sistema lee temporalmente su nombre público (Username), foto de perfil y el contenido de su comentario.</p>
                    <p><strong>Uso de Datos de Meta:</strong> Estos datos se centralizan en nuestro "Radar Meta" (CRM interno) con el único objetivo de que nuestros asesores puedan responder sus dudas técnicas o comerciales de forma rápida y eficiente. <em>Cisnergia no utiliza estos datos para crear perfiles ocultos, ni los comercializa con terceros.</em></p>
                    <p>Cisnergia también integra pasarelas de pago certificadas (como Culqi) para el E-commerce, las cuales procesan su información financiera bajo estrictos estándares PCI-DSS. Cisnergia no almacena los datos de sus tarjetas.</p>
                </div>

                <div class="tab-pane fade" id="list-seguridad" role="tabpanel" aria-labelledby="list-seguridad-list">
                    <h2>5. Seguridad y Retención de Datos</h2>
                    <p>La seguridad de sus datos es una prioridad. Mantenemos salvaguardas físicas, electrónicas y de procedimiento en nuestros servidores para proteger su información contra acceso, uso o divulgación no autorizados.</p>
                    <p>Retenemos la información personal únicamente durante el tiempo necesario para cumplir con los propósitos para los cuales fue recopilada, o según lo exijan las leyes contables, fiscales y administrativas del Perú.</p>
                </div>

                <div class="tab-pane fade" id="list-derechos" role="tabpanel" aria-labelledby="list-derechos-list">
                    <h2>6. Derechos del Usuario (ARCO) y Eliminación de Datos</h2>
                    <p>Usted posee los derechos de Acceso, Rectificación, Cancelación y Oposición (Derechos ARCO) sobre sus datos personales.</p>
                    <p>Si usted desea que <strong>eliminemos definitivamente</strong> cualquier registro suyo de nuestro sistema web, CRM, o cualquier dato recopilado a través de nuestra integración con Facebook e Instagram (Meta), puede solicitarlo formalmente enviando un correo electrónico a:</p>
                    <div class="p-3 my-4 rounded-3" style="background-color: #f8fafc; border-left: 4px solid #20c997;">
                        <strong>Correo:</strong> privacidad@cisnergia.com<br>
                        <strong>Asunto:</strong> Solicitud de Derechos ARCO / Eliminación de Datos<br>
                        <strong>Contenido:</strong> Indique su nombre completo, documento de identidad y la solicitud específica.
                    </div>
                    <p>Cisnergia Perú responderá y ejecutará la eliminación de los datos en un plazo máximo establecido por la legislación vigente, notificándole la finalización del proceso.</p>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
@endsection