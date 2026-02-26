@extends('TEMPLATES.administrador')
@section('title', isset($pedido) ? 'EDITAR PEDIDO' : 'CREAR PEDIDO')

@section('css')
<style>
    .tabla-items th { font-size: 0.75rem; text-transform: uppercase; background: #f8f9fa; }
    .tabla-items td { vertical-align: top; }
    .tabla-items .form-control, .tabla-items .form-select { font-size: 0.8rem; }
    .item-subtotal { font-weight: 600; min-width: 100px; text-align: right; }
    .btn-quitar { padding: 0.15rem 0.4rem; font-size: 0.75rem; }
    .resumen-valor { font-size: 0.95rem; }
    .cascada-selects { display: flex; flex-wrap: wrap; gap: 4px; }
    .cascada-selects .sel-wrap-half { flex: 1; min-width: 100px; }
    .cascada-selects .sel-wrap-full { flex: 0 0 100%; }
    .producto-info { font-size: 0.72rem; color: #6c757d; margin-top: 2px; }
    .cascada-selects .select2-container { font-size: 0.8rem; }
    .cascada-selects .select2-container--bootstrap-5 .select2-selection { min-height: 28px; padding: 0.15rem 0.5rem; font-size: 0.8rem; }
    /* Notificaciones Toast */
    #toastClienteOk  { background: linear-gradient(135deg,#11998e,#38ef7d); border-radius: 14px; }
    #toastClienteErr { background: linear-gradient(135deg,#c0392b,#e74c3c); border-radius: 14px; }
</style>
@endsection

@section('content')
<div class="header_section">
    <div class="bg-transparent mb-3" style="height: 67px"></div>
    <div class="container-fluid">
        <div class="" data-aos="fade-right">
            <h1 class="titulo h2 text-uppercase fw-bold mb-0">{{ isset($pedido) ? 'EDITAR PEDIDO' : 'CREAR PEDIDO' }}</h1>
            <div class="" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                    <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-pedidos.index') }}">Pedidos</a></li>
                    <li class="breadcrumb-item link" aria-current="page">{{ isset($pedido) ? 'Editar' : 'Crear' }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <form action="{{ isset($pedido) ? route('admin-pedidos.update', $pedido) : route('admin-pedidos.store') }}" method="POST" id="formPedido">
        @csrf
        @if(isset($pedido)) @method('PUT') @endif
        <div class="row g-4">
            
            {{-- ===================== COLUMNA IZQUIERDA ===================== --}}
            <div class="col-lg-8">
                
                {{-- Card: Datos Requeridos --}}
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-body">
                        <p class="text-secondary mb-3 small text-uppercase fw-bold">Datos Requeridos</p>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted fw-bold small">Cliente Sugerido <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <select name="cliente_id" id="cliente_id" class="form-select select2-basic" required>
                                        <option value="">Buscar o Seleccionar un cliente...</option>
                                        @foreach($clientes as $cliente)
                                            <option value="{{ $cliente->id }}" {{ (isset($pedido) && $pedido->cliente_id == $cliente->id) || old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                                {{ $cliente->nombre_completo }} - {{ $cliente->documento }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalNuevoCliente" title="Agregar Nuevo Cliente">
                                        <i class="bi bi-person-plus"></i>
                                    </button>
                                </div>
                             </div>

                             <div class="col-md-4">
                                 <label class="form-label text-muted fw-bold small">Fecha de Registro</label>
                                 <input type="text" class="form-control form-control-sm bg-light" value="{{ isset($pedido) ? $pedido->created_at->format('d/m/Y') : date('d/m/Y') }}" readonly>
                                 <small class="text-muted">Se registra automáticamente al crear el pedido</small>
                             </div>

                             <div class="col-md-2">
                                 <label class="form-label text-muted fw-bold small">Vigencia <span class="text-danger">*</span></label>
                                 <select name="vigencia_dias" class="form-select form-select-sm" required>
                                     <option value="15" {{ (isset($pedido) && $pedido->vigencia_dias == 15) || old('vigencia_dias') == 15 || !isset($pedido) ? 'selected' : '' }}>15 días</option>
                                     <option value="30" {{ (isset($pedido) && $pedido->vigencia_dias == 30) || old('vigencia_dias') == 30 ? 'selected' : '' }}>30 días</option>
                                 </select>
                             </div>
                             
                            <input type="hidden" name="tipo" value="producto">

                             @if(isset($pedido))
                             <div class="col-md-3">
                                <label class="form-label text-muted fw-bold small">Estado del Pedido <span class="text-danger">*</span></label>
                                <select name="estado" class="form-select form-select-sm" required>
                                    <option value="pendiente" {{ $pedido->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="proceso" {{ $pedido->estado == 'proceso' ? 'selected' : '' }}>En Proceso</option>
                                    <option value="entregado" {{ $pedido->estado == 'entregado' ? 'selected' : '' }}>Entregado</option>
                                    <option value="cancelado" {{ $pedido->estado == 'cancelado' ? 'selected' : '' }}>Anular / Cancelado</option>
                                </select>
                             </div>
                             @endif

                             <div class="col-md-6">
                                 <label class="form-label text-muted fw-bold small">Dirección Instalación / Entrega</label>
                                 <input type="text" name="direccion_instalacion" class="form-control form-control-sm" value="{{ isset($pedido) ? $pedido->direccion_instalacion : old('direccion_instalacion') }}" placeholder="Calle, Av, Lote...">
                             </div>

                             <div class="col-md-3">
                                 <label class="form-label text-muted fw-bold small">Distrito Destino</label>
                                 <select name="distrito_id" class="form-select form-select-sm select2-basic">
                                     <option value="">Seleccione distrito...</option>
                                     @foreach($distritos as $distrito)
                                         <option value="{{ $distrito->id }}" {{ (isset($pedido) && $pedido->distrito_id == $distrito->id) || old('distrito_id') == $distrito->id ? 'selected' : '' }}>
                                             {{ $distrito->nombre }}
                                         </option>
                                     @endforeach
                                 </select>
                             </div>

                             <div class="col-md-3">
                                 <label class="form-label text-muted fw-bold small">Almacén Origen</label>
                                 <select name="almacen_id" class="form-select form-select-sm">
                                     <option value="">Seleccione almacén...</option>
                                     @foreach($almacenes as $almacen)
                                         <option value="{{ $almacen->id }}" {{ (isset($pedido) && $pedido->almacen_id == $almacen->id) || old('almacen_id') == $almacen->id ? 'selected' : '' }}>
                                             {{ $almacen->nombre ?? $almacen->name }}
                                         </option>
                                     @endforeach
                                 </select>
                             </div>

                             <div class="col-md-12">
                                 <label class="form-label text-muted fw-bold small">Observaciones Adicionales</label>
                                 <textarea name="observaciones" class="form-control form-control-sm" rows="2" placeholder="Ej: Entregar guías selladas, llamar a puerta, etc.">{{ isset($pedido) ? $pedido->observaciones : old('observaciones') }}</textarea>
                             </div>
                        </div>
                    </div>
                </div>

                {{-- Card: Detalle de Ítems --}}
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-body">
                        <p class="text-secondary mb-3 small text-uppercase fw-bold">Detalle de Ítems</p>
                        
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered tabla-items mb-0" id="tablaItems">
                                <thead>
                                    <tr>
                                        <th style="width: 110px;">Tipo</th>
                                        <th>Descripción / Producto</th>
                                        <th style="width: 70px;">Cant.</th>
                                        <th style="width: 80px;">Unidad</th>
                                        <th style="width: 110px;">P. Unit.</th>
                                        <th style="width: 65px;">Dto.%</th>
                                        <th style="width: 110px;">Subtotal</th>
                                        <th style="width: 35px;"></th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyItems">
                                    {{-- Filas dinámicas via JS --}}
                                </tbody>
                            </table>
                        </div>

                        <div id="sinItems" class="text-center text-muted py-4">
                            <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                            <p class="mb-0 mt-2">No hay ítems. Haga clic en <strong>"Agregar Ítem"</strong> para comenzar.</p>
                        </div>

                        <button type="button" class="btn btn-sm btn-outline-dark mt-2" id="btnAgregarItem" style="border-radius:20px;">
                            <i class="bi bi-plus-circle me-1"></i>Agregar Ítem
                        </button>
                    </div>
                </div>
            </div>

            {{-- ===================== COLUMNA DERECHA ===================== --}}
            <div class="col-lg-4">
                <div class="card border-4 borde-top-secondary shadow-sm sticky-top" style="border-radius: 20px; top: 80px;" data-aos="fade-up">
                    <div class="card-body">
                        <p class="text-secondary mb-3 small text-uppercase fw-bold text-center text-success"><i class="bi bi-calculator me-1"></i>Liquidación Final</p>

                        <!-- Control de IGV Sofisticado -->
                        <div class="form-check form-switch p-3 bg-light rounded-3 mb-4 d-flex align-items-center shadow-sm">
                            <input class="form-check-input ms-0 me-3 mt-0" type="checkbox" role="switch" name="incluye_igv" id="incluye_igv" style="transform: scale(1.3);" value="1" {{ old('incluye_igv', isset($pedido) ? $pedido->incluye_igv : true) ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold small text-muted" for="incluye_igv" style="cursor: pointer;">
                                APLICAR IGV (18%)<br>
                                <small class="text-secondary fw-normal">Active para agregar IGV al total</small>
                            </label>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted fw-bold small text-uppercase">Base Imponible:</span>
                            <span class="resumen-valor fw-bold" id="calc-subtotal">S/ 0.00</span>
                        </div>

                        <div class="d-flex justify-content-between mb-2 text-danger">
                            <span class="fw-bold small text-uppercase">Descuentos Totales:</span>
                            <span class="resumen-valor fw-bold" id="calc-descuento">- S/ 0.00</span>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted fw-bold small text-uppercase">IGV (18%):</span>
                            <span class="resumen-valor fw-bold text-primary" id="calc-igv">S/ 0.00</span>
                        </div>
                        
                        <hr class="border-secondary opacity-25">
                        
                        <div class="d-flex justify-content-between mb-4 bg-success bg-opacity-10 p-3 rounded-3 border border-success border-opacity-25">
                            <span class="h5 mb-0 fw-bold text-success">VALOR TOTAL:</span>
                            <span class="h3 mb-0 text-success fw-bold" id="calc-total">S/ 0.00</span>
                        </div>

                        <input type="hidden" name="subtotal" id="input-subtotal">
                        <input type="hidden" name="igv" id="input-igv">
                        <input type="hidden" name="total" id="input-total">
                        <input type="hidden" name="descuento_monto" id="input-descuento-monto">

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-dark btn-lg fw-bold shadow-sm" style="border-radius:12px">
                                <i class="bi bi-save me-2"></i>GUARDAR PEDIDO
                            </button>
                            <a href="{{ route('admin-pedidos.index') }}" class="btn btn-outline-secondary fw-bold border-0">
                                Volver al Listado
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- Modal Nuevo Cliente --}}
    <div class="modal fade" id="modalNuevoCliente" tabindex="-1" aria-labelledby="modalNuevoClienteLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalNuevoClienteLabel"><i class="bi bi-person-plus-fill me-2"></i>Nuevo Cliente</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formNuevoCliente">
                    @csrf
                    <div class="modal-body">
                        {{-- Alerta de errores inline --}}
                        <div id="alertaNuevoCliente" class="alert alert-danger d-none border-0 rounded-3 mb-3" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <span id="alertaNuevoClienteMsg"></span>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Tipo de Identificación <span class="text-danger">*</span></label>
                                <select name="tipo_identificacion" id="tipo_identificacion" class="form-select" required>
                                    <option value="">Seleccione...</option>
                                    <option value="DNI">DNI</option>
                                    <option value="RUC">RUC</option>
                                    <option value="CE">Carnet de Extranjería</option>
                                    <option value="Pasaporte">Pasaporte</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Número de Documento <span class="text-danger">*</span></label>
                                <input type="text" name="documento" id="ncDocumento" class="form-control" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Nombre / Razón Social <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="ncNombre" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Email</label>
                                <input type="email" name="email" id="ncEmail" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Teléfono</label>
                                <input type="text" name="telefono" id="ncTelefono" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Dirección</label>
                                <input type="text" name="direccion" id="ncDireccion" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" id="btnGuardarCliente">
                            <i class="bi bi-save me-1"></i>Guardar Cliente
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Toast de éxito (reemplaza al alert del navegador) --}}
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index:9999;">
        <div id="toastClienteOk" class="toast align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="4500">
            <div class="d-flex">
                <div class="toast-body fw-bold d-flex align-items-center gap-2">
                    <i class="bi bi-check-circle-fill fs-5"></i>
                    <span id="toastClienteOkMsg">Cliente creado exitosamente</span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    // ==================== DATOS DEL SERVIDOR ====================
    // En pedidos usamos $tipos y $productos traídos por admin_PedidosController
    const tipos = @json($tipos ?? []);
    const productosDB = @json($productos ?? []);
    
    // Variables iniciales del pedido que vamos a editar
    const edicionItems = @json(isset($pedido) ? $pedido->detalles : []);
    
    const catNombres = { 'producto': 'Productos', 'servicio': 'Servicios' };
    const catColors = { producto: 'primary', servicio: 'info' };

    // Sugerencias predefinidas para servicios (Idéntico a CRM)
    const sugerencias = {
        servicio: [
            { desc: 'Instalación completa de sistema solar', unidad: 'glb' },
            { desc: 'Mano de obra técnica especializada', unidad: 'dia' },
            { desc: 'Mantenimiento preventivo', unidad: 'glb' },
            { desc: 'Mantenimiento correctivo - Diagnóstico y reparación', unidad: 'glb' },
            { desc: 'Trámite ante distribuidora eléctrica', unidad: 'glb' },
            { desc: 'Diseño de ingeniería y dimensionamiento', unidad: 'glb' },
            { desc: 'Transporte de equipos', unidad: 'glb' },
            { desc: 'Monitoreo remoto del sistema (anual)', unidad: 'glb' },
            { desc: 'Conexión eléctrica y puesta en marcha', unidad: 'glb' },
        ],
    };

    let itemIndex = 0;

    // ==================== AGREGAR ÍTEM ====================
    $('#btnAgregarItem').on('click', function() {
        agregarFila('producto');
    });

    function agregarFila(categoria = 'producto', datos = {}) {
        const i = itemIndex++;
        $('#sinItems').hide();

        const esProducto = categoria === 'producto';

        // ---- Celda de descripción ----
        let celdaDescripcion = '';

        if (esProducto) {
            // Selects en cascada: Tipo → Categoría → Producto
            let optTipos = '<option value="">-- Tipo --</option>';
            tipos.forEach(t => {
                optTipos += `<option value="${t.id}">${t.name}</option>`;
            });

            celdaDescripcion = `
                <div class="cascada-selects">
                    <div class="sel-wrap-half"><select class="form-select form-select-sm sel-tipo" data-index="${i}">
                        ${optTipos}
                    </select></div>
                    <div class="sel-wrap-half"><select class="form-select form-select-sm sel-subcategoria" data-index="${i}" ${datos.producto_id ? '' : 'disabled'}>
                        <option value="">-- Categoría --</option>
                    </select></div>
                    <div class="sel-wrap-full"><select class="form-select form-select-sm sel-producto" data-index="${i}" ${datos.producto_id ? '' : 'disabled'}>
                        <option value="">-- Producto --</option>
                    </select></div>
                </div>
                <!-- CUIDADO: en Pedidos se envia detalles[i] en lugar de items[i] para no romper admin_PedidosController -->
                <input type="hidden" name="detalles[${i}][producto_id]" class="input-producto-id" value="${datos.producto_id || ''}">
                <input type="hidden" name="detalles[${i}][descripcion]" class="input-descripcion" value="${datos.descripcion || ''}" required>
                <input type="hidden" name="detalles[${i}][tipo]" value="${categoria}">
                <div class="producto-info" id="producto-info-${i}">${datos.descripcion ? '<i class="bi bi-check-circle text-success me-1"></i><strong>' + datos.descripcion + '</strong>' : ''}</div>`;
        } else {
            // Select de servicios predefinidos + opción personalizada
            let selectHtml = '';
            if (sugerencias[categoria]) {
                selectHtml = `<select class="form-select form-select-sm sel-sugerencia mb-1" data-index="${i}">
                    <option value="">-- Seleccione un servicio --</option>`;
                sugerencias[categoria].forEach(s => {
                    const sel = datos.descripcion === s.desc ? 'selected' : '';
                    selectHtml += `<option value="${s.desc}" data-unidad="${s.unidad}" ${sel}>${s.desc}</option>`;
                });
                selectHtml += `<option value="__custom__" ${datos.descripcion && !sugerencias[categoria].some(s => s.desc === datos.descripcion) ? 'selected' : ''}>✏️ Personalizado...</option>`;
                selectHtml += `</select>`;
            }

            const esCustom = datos.descripcion && sugerencias[categoria] && !sugerencias[categoria].some(s => s.desc === datos.descripcion);
            const mostrarInput = !sugerencias[categoria] || esCustom;

            celdaDescripcion = `
                ${selectHtml}
                <input type="text" name="detalles[${i}][descripcion]" class="form-control form-control-sm input-descripcion input-descripcion-custom"
                       value="${datos.descripcion || ''}" placeholder="Escriba la descripción del ítem" required
                       style="${mostrarInput ? '' : 'display:none'}">
                <input type="hidden" name="detalles[${i}][producto_id]" class="input-producto-id" value="">
                <input type="hidden" name="detalles[${i}][tipo]" value="${categoria}">`;
        }

        const fila = `
        <tr id="fila-${i}" class="item-fila" data-categoria="${categoria}">
            <td>
                <select class="form-select form-select-sm sel-categoria" data-index="${i}">
                    <option value="producto" ${categoria === 'producto' ? 'selected' : ''}>Producto</option>
                    <option value="servicio" ${categoria === 'servicio' ? 'selected' : ''}>Servicio</option>
                </select>
            </td>
            <td class="celda-descripcion">${celdaDescripcion}</td>
            <td>
                <input type="number" name="detalles[${i}][cantidad]" class="form-control form-control-sm input-cantidad"
                       value="${datos.cantidad || 1}" step="0.01" min="0.01" required>
            </td>
            <td>
                <select name="detalles[${i}][unidad]" class="form-select form-select-sm input-unidad">
                    <option value="und" ${(datos.unidad || 'und') === 'und' ? 'selected' : ''}>Und</option>
                    <option value="glb" ${datos.unidad === 'glb' ? 'selected' : ''}>Global</option>
                    <option value="hrs" ${datos.unidad === 'hrs' ? 'selected' : ''}>Horas</option>
                    <option value="dia" ${datos.unidad === 'dia' ? 'selected' : ''}>Día</option>
                    <option value="kg" ${datos.unidad === 'kg' ? 'selected' : ''}>Kg</option>
                    <option value="m" ${datos.unidad === 'm' ? 'selected' : ''}>Metro</option>
                    <option value="m2" ${datos.unidad === 'm2' ? 'selected' : ''}>M²</option>
                    <option value="ml" ${datos.unidad === 'ml' ? 'selected' : ''}>ML</option>
                    <option value="jgo" ${datos.unidad === 'jgo' ? 'selected' : ''}>Juego</option>
                    <option value="rollo" ${datos.unidad === 'rollo' ? 'selected' : ''}>Rollo</option>
                </select>
            </td>
            <td>
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light border-0" style="font-size:0.7rem;">S/</span>
                    <input type="number" name="detalles[${i}][precio_unitario]" class="form-control form-control-sm input-precio"
                           value="${datos.precio_unitario || 0}" step="0.01" min="0" required>
                </div>
            </td>
            <td>
                <div class="input-group input-group-sm mb-1">
                    <input type="number" name="detalles[${i}][descuento_porcentaje]" class="form-control form-control-sm input-dto p-0 text-center"
                           value="${datos.descuento_porcentaje || 0}" step="0.01" min="0" max="100">
                    <span class="input-group-text bg-light border-0" style="font-size:0.7rem;">%</span>
                </div>
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light border-0" style="font-size:0.7rem; color:red">S/</span>
                    <input type="number" name="detalles[${i}][descuento_monto]" class="form-control form-control-sm input-dto-monto text-danger p-0 text-center"
                           value="${datos.descuento_monto || 0}" step="0.01" min="0">
                </div>
            </td>
            <td>
                <input type="number" name="detalles[${i}][subtotal]" class="form-control form-control-sm text-end input-subtotal fw-bold bg-white border-0 p-0" value="0.00" readonly>
            </td>
            <td class="text-center pt-2 align-middle">
                <button type="button" class="btn btn-outline-danger btn-sm btn-quitar border-0 p-1" onclick="quitarFila(${i})">
                    <i class="bi bi-trash fs-5"></i>
                </button>
            </td>
        </tr>`;

        $('#tbodyItems').append(fila);

        if (esProducto) {
            initSelect2Cascada(i);
        }

        calcularLinea(i);
    }

    // ==================== RELLENADO DE ITEM SI ES MODO EDICIÓN ====================
    if (edicionItems && edicionItems.length > 0) {
        edicionItems.forEach(item => {
            agregarFila(item.tipo || 'producto', {
                producto_id: item.producto_id,
                descripcion: item.descripcion,
                cantidad: item.cantidad,
                unidad: item.unidad,
                precio_unitario: item.precio_unitario,
                descuento_porcentaje: item.descuento_porcentaje,
                descuento_monto: item.descuento_monto
            });
        });
    }

    // ==================== SELECT2 HELPERS ====================
    function initSelect2Cascada(idx) {
        var fila = $(`#fila-${idx}`);
        fila.find('.sel-tipo, .sel-subcategoria, .sel-producto').each(function() {
            if ($(this).hasClass('select2-hidden-accessible')) {
                $(this).select2('destroy');
            }
            $(this).select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: $(this).find('option:first').text()
            });
        });
    }

    function reinitSelect2(selector) {
        var el = $(selector);
        if (el.hasClass('select2-hidden-accessible')) {
            el.select2('destroy');
        }
        el.select2({
            theme: 'bootstrap-5',
            width: '100%',
            placeholder: el.find('option:first').text()
        });
    }

    // ==================== CAMBIO DE CATEGORÍA (SELECT) ====================
    $(document).on('change', '.sel-categoria', function() {
        const idx = $(this).data('index');
        const nuevaCat = $(this).val();
        const fila = $(`#fila-${idx}`);

        const cantActual = fila.find('.input-cantidad').val();
        const precioActual = fila.find('.input-precio').val();
        const unidadActual = fila.find('.input-unidad').val();

        fila.remove();
        itemIndex--;
        agregarFila(nuevaCat, {
            cantidad: cantActual,
            precio_unitario: precioActual,
            unidad: unidadActual
        });
    });

    // ==================== CASCADA: TIPO → CATEGORÍA ====================
    $(document).on('change', '.sel-tipo', function() {
        const idx = $(this).data('index');
        const tipoId = parseInt($(this).val());
        const selSubcat = $(`.sel-subcategoria[data-index="${idx}"]`);
        const selProducto = $(`.sel-producto[data-index="${idx}"]`);

        selProducto.html('<option value="">-- Producto --</option>').prop('disabled', true);
        reinitSelect2(`.sel-producto[data-index="${idx}"]`);
        $(`#fila-${idx}`).find('.input-producto-id').val('');
        $(`#fila-${idx}`).find('.input-descripcion').val('');
        $(`#producto-info-${idx}`).html('');

        if (!tipoId) {
            selSubcat.html('<option value="">-- Categoría --</option>').prop('disabled', true);
            reinitSelect2(`.sel-subcategoria[data-index="${idx}"]`);
            return;
        }

        const tipo = tipos.find(t => t.id === tipoId);
        if (!tipo || !tipo.categories || tipo.categories.length === 0) {
            selSubcat.html('<option value="">Sin categorías</option>').prop('disabled', true);
            reinitSelect2(`.sel-subcategoria[data-index="${idx}"]`);
            return;
        }

        let opts = '<option value="">-- Categoría --</option>';
        tipo.categories.forEach(c => {
            opts += `<option value="${c.id}">${c.name}</option>`;
        });
        selSubcat.html(opts).prop('disabled', false);
        reinitSelect2(`.sel-subcategoria[data-index="${idx}"]`);
    });

    // ==================== CASCADA: CATEGORÍA → PRODUCTO ====================
    $(document).on('change', '.sel-subcategoria', function() {
        const idx = $(this).data('index');
        const categoriaId = parseInt($(this).val());
        const selProducto = $(`.sel-producto[data-index="${idx}"]`);

        $(`#fila-${idx}`).find('.input-producto-id').val('');
        $(`#fila-${idx}`).find('.input-descripcion').val('');
        $(`#fila-${idx}`).find('.input-precio').val(0);
        $(`#producto-info-${idx}`).html('');

        if (!categoriaId) {
            selProducto.html('<option value="">-- Producto --</option>').prop('disabled', true);
            reinitSelect2(`.sel-producto[data-index="${idx}"]`);
            return;
        }

        const prods = productosDB.filter(p => p.categorie_id === categoriaId);

        if (prods.length === 0) {
            selProducto.html('<option value="">Sin productos</option>').prop('disabled', true);
            reinitSelect2(`.sel-producto[data-index="${idx}"]`);
            return;
        }

        let opts = '<option value="">-- Producto --</option>';
        prods.forEach(p => {
            const extra = `S/ ${parseFloat(p.precio || 0).toFixed(2)}`;
            opts += `<option value="${p.id}" data-precio="${p.precio || 0}" data-nombre="${p.name}" data-marca="${p.marca?.name || ''}">[${p.codigo || ''}] ${p.name} (${extra})</option>`;
        });
        selProducto.html(opts).prop('disabled', false);
        reinitSelect2(`.sel-producto[data-index="${idx}"]`);
    });

    // ==================== SELECCIÓN DE PRODUCTO ====================
    $(document).on('change', '.sel-producto', function() {
        const idx = $(this).data('index');
        const fila = $(`#fila-${idx}`);
        const selected = $(this).find(':selected');
        const productoId = $(this).val();

        if (productoId) {
            fila.find('.input-producto-id').val(productoId);
            fila.find('.input-descripcion').val(selected.data('nombre'));
            fila.find('.input-precio').val(parseFloat(selected.data('precio') || 0).toFixed(2));

            const marca = selected.data('marca');
            let infoHtml = `<i class="bi bi-check-circle text-success me-1"></i><strong>${selected.data('nombre')}</strong>`;
            if (marca) infoHtml += ` — ${marca}`;
            $(`#producto-info-${idx}`).html(infoHtml);
        } else {
            fila.find('.input-producto-id').val('');
            fila.find('.input-descripcion').val('');
            fila.find('.input-precio').val(0);
            $(`#producto-info-${idx}`).html('');
        }

        calcularLinea(idx);
    });

    // ==================== SELECT DE SERVICIOS ====================
    $(document).on('change', '.sel-sugerencia', function() {
        const idx = $(this).data('index');
        const fila = $(`#fila-${idx}`);
        const val = $(this).val();
        const inputDesc = fila.find('.input-descripcion');
        const inputCustom = fila.find('.input-descripcion-custom');

        if (val === '__custom__') {
            inputCustom.val('').show().focus();
        } else if (val) {
            const unidad = $(this).find(':selected').data('unidad');
            inputDesc.val(val);
            inputCustom.val(val).hide();
            if (unidad) fila.find('.input-unidad').val(unidad);
        } else {
            inputDesc.val('');
            inputCustom.val('').hide();
        }
    });

    // ==================== QUITAR FILA ====================
    window.quitarFila = function(i) {
        $(`#fila-${i}`).remove();
        calcularLiquidacionFinal();
        if ($('.item-fila').length === 0) {
            $('#sinItems').show();
        }
    }

    // ==================== CÁLCULOS LOGICOS ====================
    $(document).on('input', '.input-cantidad, .input-precio', function() {
        const idx = $(this).closest('tr').attr('id').replace('fila-', '');
        calcularLinea(idx);
    });

    // Bloqueo y transformación de Descuento
    $(document).on('input', '.input-dto', function() {
        let fila = $(this).closest('tr');
        fila.find('.input-dto-monto').val(0.00); 
        calcularLinea(fila.attr('id').replace('fila-', ''));
    });
    
    $(document).on('input', '.input-dto-monto', function() {
        let fila = $(this).closest('tr');
        fila.find('.input-dto').val(0.00);
        calcularLinea(fila.attr('id').replace('fila-', ''));
    });

    $('#incluye_igv').on('change', function() {
        calcularLiquidacionFinal();
    });

    function calcularLinea(idx) {
        const fila = $(`#fila-${idx}`);
        let qty = parseFloat(fila.find('.input-cantidad').val()) || 0;
        let p_unit = parseFloat(fila.find('.input-precio').val()) || 0;
        let baseFila = qty * p_unit;
        
        let desc_porc = parseFloat(fila.find('.input-dto').val()) || 0;
        let desc_monto = parseFloat(fila.find('.input-dto-monto').val()) || 0;

        let monto_descontado = 0;
        
        if (desc_porc > 0) {
            monto_descontado = baseFila * (desc_porc / 100);
            fila.find('.input-dto-monto').val(monto_descontado.toFixed(2));
        } else if (desc_monto > 0) {
            monto_descontado = desc_monto;
        }

        let subtotalFila = baseFila - monto_descontado;
        if(subtotalFila < 0) subtotalFila = 0;

        fila.find('.input-subtotal').val(subtotalFila.toFixed(2));
        calcularLiquidacionFinal();
    }

    function calcularLiquidacionFinal() {
        let sumaDetallesFinal = 0;
        let totalDescuentosMonto = 0;

        $('.item-fila').each(function() {
            let subtotalFila = parseFloat($(this).find('.input-subtotal').val()) || 0;
            let d_monto = parseFloat($(this).find('.input-dto-monto').val()) || 0;
            
            totalDescuentosMonto += d_monto;
            sumaDetallesFinal += subtotalFila;
        });

        let aplicaIgv = $('#incluye_igv').is(':checked');
        
        let baseImponible = sumaDetallesFinal;
        let calculoIgv = aplicaIgv ? (sumaDetallesFinal * 0.18) : 0;
        let valorAPagarTotal = sumaDetallesFinal + calculoIgv;

        $('#calc-subtotal').text('S/ ' + baseImponible.toFixed(2));
        $('#calc-descuento').text('- S/ ' + totalDescuentosMonto.toFixed(2));
        $('#calc-igv').text('S/ ' + calculoIgv.toFixed(2));
        $('#calc-total').text('S/ ' + valorAPagarTotal.toFixed(2));

        $('#input-subtotal').val(baseImponible.toFixed(2));
        $('#input-descuento-monto').val(totalDescuentosMonto.toFixed(2));
        $('#input-igv').val(calculoIgv.toFixed(2));
        $('#input-total').val(valorAPagarTotal.toFixed(2));
    }

    // Inicializar Select2 general
    $('.select2-basic').select2({ theme: 'bootstrap-5' });

    // ==================== MODAL NUEVO CLIENTE ====================
    // Limpiar modal al cerrarlo
    $('#modalNuevoCliente').on('hidden.bs.modal', function() {
        $('#formNuevoCliente')[0].reset();
        $('#alertaNuevoCliente').addClass('d-none');
    });

    // Función helper para mostrar toast
    function mostrarToast(tipo, mensaje) {
        const toastId = tipo === 'ok' ? '#toastClienteOk' : '#toastClienteErr';
        const msgId   = tipo === 'ok' ? '#toastClienteOkMsg' : '#toastClienteErrMsg';
        $(msgId).text(mensaje);
        const toastEl = document.querySelector(toastId);
        if (toastEl) { bootstrap.Toast.getOrCreateInstance(toastEl).show(); }
    }

    $('#formNuevoCliente').on('submit', function(e) {
        e.preventDefault();

        // Validar que se eligió tipo de documento
        const tipoSeleccionado = $('#tipo_identificacion').val();
        if (!tipoSeleccionado) {
            $('#alertaNuevoClienteMsg').text('Selecciona un tipo de identificación.');
            $('#alertaNuevoCliente').removeClass('d-none');
            return;
        }

        const btnSubmit = $('#btnGuardarCliente');
        const btnText   = btnSubmit.html();
        btnSubmit.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Guardando...');
        $('#alertaNuevoCliente').addClass('d-none');

        const formData = {
            _token: $('input[name="_token"]').val(),
            tipo_identificacion: tipoSeleccionado,
            documento: $('#ncDocumento').val(),
            name: $('#ncNombre').val(),
            email: $('#ncEmail').val(),
            telefono: $('#ncTelefono').val(),
            direccion: $('#ncDireccion').val(),
        };

        $.ajax({
            url: '{{ route("admin-clientes.store") }}',
            method: 'POST',
            data: formData,
            success: function(response) {
                if (response.success && response.cliente) {
                    // Agregar el nuevo cliente al select2 y seleccionarlo
                    const newOption = new Option(
                        response.cliente.name + ' - ' + response.cliente.documento,
                        response.cliente.id,
                        true,
                        true
                    );
                    $('#cliente_id').append(newOption).trigger('change');

                    // Cerrar modal y mostrar toast de éxito
                    $('#modalNuevoCliente').modal('hide');
                    mostrarToast('ok', '✓ Cliente "' + response.cliente.name + '" creado y seleccionado.');
                } else {
                    $('#alertaNuevoClienteMsg').text('No se pudo crear el cliente. Inténtalo de nuevo.');
                    $('#alertaNuevoCliente').removeClass('d-none');
                }
            },
            error: function(xhr) {
                let errorMsg = 'Error al guardar el cliente.';
                if (xhr.responseJSON) {
                    if (xhr.responseJSON.message) errorMsg = xhr.responseJSON.message;
                    // Mostrar errores de validación
                    if (xhr.responseJSON.errors) {
                        const errs = Object.values(xhr.responseJSON.errors).flat();
                        errorMsg = errs.join(' | ');
                    }
                }
                $('#alertaNuevoClienteMsg').text(errorMsg);
                $('#alertaNuevoCliente').removeClass('d-none');
            },
            complete: function() {
                btnSubmit.prop('disabled', false).html(btnText);
            }
        });
    });
});
</script>
@endsection
