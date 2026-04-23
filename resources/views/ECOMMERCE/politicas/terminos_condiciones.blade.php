@extends('TEMPLATES.ecommerce')

@section('title', 'Términos y Condiciones')

@section('content')
<div class="container py-5" style="margin-top: 80px;">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                <div class="text-center mb-5">
                    <h1 class="fw-bold" style="color: #1C3146;">Términos y Condiciones</h1>
                    <p class="text-muted">Última actualización: {{ date('d/m/Y') }}</p>
                </div>

                <div class="terms-content" style="color: #495057; line-height: 1.8;">
                    <h4 class="fw-bold mt-4" style="color: #1C3146;">1. Aceptación de los Términos</h4>
                    <p>Al acceder a nuestra tienda virtual y adquirir nuestros productos y soluciones de energía solar, usted acepta estar sujeto a los presentes Términos y Condiciones. Si no está de acuerdo con alguna parte de estos términos, le rogamos que no utilice nuestros servicios.</p>

                    <h4 class="fw-bold mt-4" style="color: #1C3146;">2. Productos y Precios</h4>
                    <p><strong>Cisnergia Perú</strong> se esfuerza por mostrar con la mayor precisión posible las características y precios de los equipos de energía solar y servicios disponibles en la plataforma. Sin embargo, nos reservamos el derecho de modificar los precios, descripciones o disponibilidad de los productos en cualquier momento y sin previo aviso.</p>
                    <p>Todos los precios mostrados incluyen el Impuesto General a las Ventas (IGV) vigente en el territorio peruano, salvo que se indique lo contrario en cotizaciones específicas para empresas.</p>

                    <h4 class="fw-bold mt-4" style="color: #1C3146;">3. Proceso de Compra y Pagos</h4>
                    <ul>
                        <li>Para realizar compras, es posible que se requiera la creación de una cuenta de usuario, siendo usted responsable de la confidencialidad de sus credenciales.</li>
                        <li>Los pagos realizados con tarjetas de crédito o débito son procesados por pasarelas de pago seguras. Cisnergia Perú no almacena directamente la información financiera de sus tarjetas.</li>
                        <li>Las compras están sujetas a la verificación de disponibilidad de stock y a la validación del pago.</li>
                    </ul>

                    <h4 class="fw-bold mt-4" style="color: #1C3146;">4. Envíos y Despachos</h4>
                    <p>Los tiempos y costos de envío variarán según la ubicación del cliente y el volumen/peso de los productos adquiridos. El tiempo estimado de entrega se informará durante el proceso de <em>checkout</em>. Cisnergia Perú no se responsabiliza por retrasos causados por factores externos o de fuerza mayor en las agencias de transporte.</p>

                    <h4 class="fw-bold mt-4" style="color: #1C3146;">5. Cambios y Devoluciones</h4>
                    <p>Cualquier solicitud de cambio o devolución deberá realizarse dentro de los primeros 7 días calendario posteriores a la recepción del pedido, siempre que los equipos se encuentren en su empaque original, sin indicios de uso o instalación. Todo proceso de devolución está sujeto a una evaluación técnica por parte de nuestro equipo.</p>

                    <h4 class="fw-bold mt-4" style="color: #1C3146;">6. Propiedad Intelectual</h4>
                    <p>Todo el contenido alojado en esta plataforma (textos, gráficos, logotipos, imágenes y software) es propiedad exclusiva de Cisnergia Perú o de sus proveedores y está protegido por las leyes de propiedad intelectual.</p>

                    <h4 class="fw-bold mt-4" style="color: #1C3146;">7. Contacto</h4>
                    <p>Para consultas, soporte técnico o dudas relacionadas con estos términos, puede contactarnos a través de los canales oficiales disponibles en nuestra plataforma web o enviando un correo a <strong>info@cisnergia.com</strong>.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection