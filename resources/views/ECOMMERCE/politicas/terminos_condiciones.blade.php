@extends('TEMPLATES.ecommerce')

@section('title', 'Términos y Condiciones | Cisnergia')

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
        <h1 class="fw-bold display-5" style="color: #1C3146;">Términos y Condiciones</h1>
        <p class="text-muted fs-5 mt-2">Condiciones de venta y servicios para E-commerce y Proyectos.</p>
        <span class="badge bg-white text-dark border px-3 py-2 mt-2">Vigente desde: {{ date('Y') }}</span>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="policy-sidebar">
                <div class="list-group policy-list-group" id="list-tab" role="tablist">
                    <a class="list-group-item list-group-item-action active" id="list-aceptacion-list" data-bs-toggle="list" href="#list-aceptacion" role="tab">1. Aceptación del Acuerdo</a>
                    <a class="list-group-item list-group-item-action" id="list-productos-list" data-bs-toggle="list" href="#list-productos" role="tab">2. Productos, Stock y Precios</a>
                    <a class="list-group-item list-group-item-action" id="list-pagos-list" data-bs-toggle="list" href="#list-pagos" role="tab">3. Pagos y Facturación</a>
                    <a class="list-group-item list-group-item-action" id="list-envios-list" data-bs-toggle="list" href="#list-envios" role="tab">4. Envíos y Logística</a>
                    <a class="list-group-item list-group-item-action" id="list-garantias-list" data-bs-toggle="list" href="#list-garantias" role="tab">5. Garantías y Devoluciones</a>
                    <a class="list-group-item list-group-item-action" id="list-proyectos-list" data-bs-toggle="list" href="#list-proyectos" role="tab">6. Proyectos e Ingeniería (EPC)</a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-8">
            <div class="policy-content tab-content" id="nav-tabContent">
                
                <div class="tab-pane fade show active" id="list-aceptacion" role="tabpanel" aria-labelledby="list-aceptacion-list">
                    <h2>1. Aceptación del Acuerdo</h2>
                    <p>El presente documento establece los Términos y Condiciones que regulan el uso de la plataforma virtual y la adquisición de productos o servicios de <strong>Cisnergia Perú</strong>, empresa líder en el desarrollo de soluciones energéticas sostenibles.</p>
                    <p>Al acceder, navegar o realizar transacciones en este sitio web, usted declara haber leído, comprendido y aceptado en su totalidad estos Términos y Condiciones. Si no está de acuerdo con alguna disposición, le solicitamos no hacer uso de nuestra plataforma ni adquirir nuestros productos.</p>
                </div>

                <div class="tab-pane fade" id="list-productos" role="tabpanel" aria-labelledby="list-productos-list">
                    <h2>2. Productos, Stock y Precios</h2>
                    <p>Cisnergia ofrece a través de su plataforma componentes para energías renovables (paneles, inversores, baterías), sistemas contra incendios y kits pre-armados.</p>
                    <ul>
                        <li><strong>Descripciones:</strong> Nos esforzamos por mantener la información técnica de los equipos precisa y actualizada. Sin embargo, las imágenes son referenciales y los fabricantes pueden actualizar las especificaciones sin previo aviso.</li>
                        <li><strong>Stock:</strong> La disponibilidad de los productos mostrada en la web es referencial. En caso de quiebre de stock posterior a la compra, Cisnergia se comunicará con el cliente para ofrecer una alternativa técnica equivalente o el reembolso íntegro.</li>
                        <li><strong>Precios:</strong> Todos los precios expresados en la tienda incluyen el Impuesto General a las Ventas (IGV - 18%), salvo que se indique expresamente lo contrario. Los precios están sujetos a cambios basados en fluctuaciones del mercado.</li>
                    </ul>
                </div>

                <div class="tab-pane fade" id="list-pagos" role="tabpanel" aria-labelledby="list-pagos-list">
                    <h2>3. Pagos y Facturación</h2>
                    <p>Para brindar mayor seguridad, las transacciones online realizadas con tarjetas de crédito/débito son procesadas a través de pasarelas de pago de terceros (como Culqi), las cuales asumen la responsabilidad de la encriptación de datos bajo los estándares internacionales.</p>
                    <p>Al finalizar la compra, el cliente podrá solicitar la emisión de una <strong>Boleta de Venta o Factura Electrónica</strong>, la cual será enviada al correo registrado en un plazo no mayor a 48 horas hábiles después de confirmada la transacción, en cumplimiento con normativas de SUNAT.</p>
                </div>

                <div class="tab-pane fade" id="list-envios" role="tabpanel" aria-labelledby="list-envios-list">
                    <h2>4. Envíos y Logística</h2>
                    <p>Cisnergia realiza despachos a nivel nacional bajo las siguientes consideraciones:</p>
                    <ul>
                        <li>Los plazos de entrega comienzan a contabilizarse desde la confirmación exitosa del pago.</li>
                        <li>Los tiempos estimados variarán dependiendo de la ubicación geográfica (Lima, Piura u otras regiones) y el volumen de la carga (ej. paneles solares sobredimensionados).</li>
                        <li>Es responsabilidad del cliente proporcionar una dirección exacta y estar presente o dejar a un representante autorizado para la recepción de equipos, firmando las guías de remisión correspondientes.</li>
                    </ul>
                </div>

                <div class="tab-pane fade" id="list-garantias" role="tabpanel" aria-labelledby="list-garantias-list">
                    <h2>5. Garantías y Devoluciones</h2>
                    <p>Respaldamos la calidad de nuestros equipos de marcas líderes (Tier 1). Cada producto cuenta con una garantía de fábrica cuyos plazos varían según el componente (ej. inversores, baterías, paneles).</p>
                    <ul>
                        <li>La garantía cubre exclusivamente defectos de fabricación y funcionamiento interno.</li>
                        <li><strong>Anulación de garantía:</strong> La garantía quedará sin efecto por mala manipulación, instalación por personal no certificado, exposición a condiciones ajenas a la ficha técnica o modificaciones no autorizadas.</li>
                        <li><strong>Devoluciones:</strong> Se aceptarán cambios o devoluciones dentro de los primeros 7 días calendario tras la recepción, siempre que los equipos estén sellados en su empaque original, sin indicios de uso.</li>
                    </ul>
                </div>

                <div class="tab-pane fade" id="list-proyectos" role="tabpanel" aria-labelledby="list-proyectos-list">
                    <h2>6. Proyectos de Ingeniería y Servicios (EPC / O&M)</h2>
                    <p>Además de la venta de equipos en nuestra plataforma E-commerce, Cisnergia desarrolla proyectos integrales "llave en mano" (EPC) para los sectores minero, agrícola e industrial.</p>
                    <p>Las contrataciones de servicios, obras civiles, mantenimientos predictivos e implementación de herramientas digitales se rigen por contratos, órdenes de servicio (OS) o cotizaciones específicas, las cuales prevalecerán sobre estos Términos E-commerce en caso de discrepancia.</p>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
@endsection