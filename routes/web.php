<?php

use App\Http\Controllers\admin_ConfiguracionesController;
use App\Http\Controllers\admin_DashboardController;
use App\Http\Controllers\admin_InformacionController;
use App\Http\Controllers\admin_MarcasController;
use App\Http\Controllers\admin_PerfilController;
use App\Http\Controllers\admin_ReportesController;
use App\Http\Controllers\admin_RolesController;
use App\Http\Controllers\admin_UsuariosController;
use App\Http\Controllers\admin_TiposController;
use App\Http\Controllers\admin_CategoriasController;
use App\Http\Controllers\admin_EtiquetasController;
use App\Http\Controllers\admin_ProveedoresController;
use App\Http\Controllers\admin_ProductosController;
use App\Http\Controllers\admin_CoberturasController;
use App\Http\Controllers\admin_DescuentosController;
use App\Http\Controllers\admin_CuponesController;
use App\Http\Controllers\admin_IngresosController;
use App\Http\Controllers\admin_KitsController;
use App\Http\Controllers\admin_OrdenescomprasController;
use App\Http\Controllers\admin_OrdenesserviciosController;
use App\Http\Controllers\admin_ServiciosController;
use App\Http\Controllers\admin_PedidosController;
use App\Http\Controllers\admin_VentasController;
use App\Http\Controllers\admin_CobrosController;
use App\Http\Controllers\admin_PagosController;
use App\Http\Controllers\admin_CajaChicaController;
use App\Http\Controllers\admin_ComprobantesFinanzasController;
use App\Http\Controllers\admin_NotasController;
use App\Http\Controllers\admin_SalidasController;
use App\Http\Controllers\admin_InventarioController;
use App\Http\Controllers\ecommerceController;
use App\Http\Controllers\admin_CuentabancoController;
use App\Http\Controllers\admin_CrmProspectosController;
use App\Http\Controllers\admin_CrmOportunidadesController;
use App\Http\Controllers\admin_CrmCotizacionesController;
use App\Http\Controllers\admin_CrmActividadesController;
use App\Http\Controllers\admin_CrmClientesController;
use App\Http\Controllers\admin_CrmTicketsController;
use App\Http\Controllers\admin_OperacionesController;
use App\Http\Controllers\admin_CrmMantenimientosController;
use App\Http\Controllers\admin_ModeloController;
use App\Http\Controllers\admin_UbigeoController;
use Illuminate\Support\Facades\Route;

// =============================================================
// ECOMMERCE — Rutas públicas (sin auth)
// =============================================================

Route::get('limpiar-sesion-planes', [ecommerceController::class, 'limpiarSesionPlanes'])->name('limpiar-sesion-planes.get');

Route::get('/', [ecommerceController::class, 'index'])->name('ecommerce.index');
Route::get('/products', [ecommerceController::class, 'products'])->name('ecommerce.products');
Route::get('/product/{slug}', [ecommerceController::class, 'show_product'])->name('ecommerce.product.show');
route::get('/busqueda_pmarca', [ecommerceController::class, 'getbusqueda_pmarca']);
route::get('/busqueda_pproducto_categoria', [ecommerceController::class, 'getbusqueda_pproducto_categoria']);
route::get('/busqueda_pproducto_marca', [ecommerceController::class, 'getbusqueda_pproducto_marca']);
Route::post('comments_producto', [ecommerceController::class, 'postcomments'])->name('ecommerce.product.store_comments');
Route::get('ver_carrito', [ecommerceController::class, 'getcargar_carrito']);
Route::get('agregar_compra_carrito', [ecommerceController::class, 'getagregar_compra_carrito']);
Route::get('carrito-compras', [ecommerceController::class, 'index'])->name('ecommerce.carrito_compras.index');

Route::get('/installation', [ecommerceController::class, 'installation'])->name('ecommerce.installation');
Route::get('/contact', [ecommerceController::class, 'contact'])->name('ecommerce.contact');

// Carrito
Route::post('/cart/add', [ecommerceController::class, 'addToCart'])->name('ecommerce.cart.add');
Route::get('/cart', [ecommerceController::class, 'cart'])->name('ecommerce.cart');
Route::post('/cart/update/{itemId}', [ecommerceController::class, 'updateCart'])->name('ecommerce.cart.update');
Route::delete('/cart/remove/{itemId}', [ecommerceController::class, 'removeFromCart'])->name('ecommerce.cart.remove');
Route::get('/cart/count', [ecommerceController::class, 'getCartCount'])->name('ecommerce.cart.count');

// Checkout
Route::get('/checkout', [ecommerceController::class, 'checkout'])->name('ecommerce.checkout');
Route::post('/checkout/process', [ecommerceController::class, 'processCheckout'])->name('ecommerce.checkout.process');
Route::get('/order-confirmation/{slug}', [ecommerceController::class, 'confirmation'])->name('ecommerce.confirmation');

// =============================================================
// ADMINISTRADOR — Todas las rutas protegidas con auth
// =============================================================
Route::middleware(['auth'])->group(function () {

    // ---------------------------------------------------------
    // DASHBOARD & CONFIGURACIONES GENERALES
    // ---------------------------------------------------------
    Route::get('admin-dashboard', [admin_DashboardController::class, 'index'])->name('admin-dashboard.index');
    Route::get('admin-configuraciones', [admin_ConfiguracionesController::class, 'index'])->name('admin-configuraciones.index');
    Route::get('admin-reportes', [admin_ReportesController::class, 'index'])->name('admin-reportes.index');

    // ---------------------------------------------------------
    // CONFIGURACIONES — Roles y Usuarios
    // ---------------------------------------------------------
    Route::resource('admin-informacion', admin_InformacionController::class);
    Route::resource('admin-roles', admin_RolesController::class);
    Route::resource('admin-usuarios', admin_UsuariosController::class);
    Route::put('/admin-usuarios/estado/{admin_usuario}', [admin_UsuariosController::class, 'estado']);
    Route::resource('admin-perfil', admin_PerfilController::class);

    // ---------------------------------------------------------
    // CONFIGURACIONES — Catálogo
    // ---------------------------------------------------------
    Route::resource('admin-modelos', admin_ModeloController::class);
    Route::put('/admin-modelos/estado/{admin_modelo}', [admin_ModeloController::class, 'estado']);

    Route::resource('admin-tipos', admin_TiposController::class);
    Route::put('/admin-tipos/estado/{admin_tipo}', [admin_TiposController::class, 'estado']);

    Route::resource('admin-categorias', admin_CategoriasController::class);
    Route::put('/admin-categorias/estado/{admin_categoria}', [admin_CategoriasController::class, 'estado']);
    Route::get('/detalle_subcategorias', [admin_CategoriasController::class, 'getDetalleSubcategorias']);

    Route::resource('admin-marcas', admin_MarcasController::class);
    Route::put('/admin-marcas/estado/{admin_marca}', [admin_MarcasController::class, 'estado']);

    Route::resource('admin-etiquetas', admin_EtiquetasController::class);
    Route::put('/admin-etiquetas/estado/{admin_etiqueta}', [admin_EtiquetasController::class, 'estado']);

    Route::resource('admin-proveedores', admin_ProveedoresController::class);
    Route::put('/admin-proveedores/estado/{admin_proveedor}', [admin_ProveedoresController::class, 'estado']);
    Route::get('busqueda_list_cuentas', [admin_ProveedoresController::class, 'getbusqueda_list_cuentas']);

    Route::resource('admin-productos', admin_ProductosController::class);
    Route::put('/admin-productos/estado/{admin_producto}', [admin_ProductosController::class, 'estado']);
    Route::get('busqueda_categoria_productos', [admin_ProductosController::class, 'getBusqueda_categoria_productos']);
    Route::get('busqueda_proved', [admin_ProductosController::class, 'getBusquedaproved']);
    Route::get('busqueda_proved_edit', [admin_ProductosController::class, 'getbusqueda_proved_edit']);
    Route::get('busqueda_codigo_producto', [admin_ProductosController::class, 'getbusqueda_codigo_producto']);
    Route::get('busqueda_subcategoria_productos', [admin_ProductosController::class, 'getbusqueda_subcategoria_productos']);

    Route::resource('admin-kits', admin_KitsController::class);
    Route::get('/dtlle_kits', [admin_KitsController::class, 'getdtlle_kits']);
    Route::get('/images/{id}/delete', [admin_KitsController::class, 'deleteImage']);
    Route::put('/admin-kits/estado/{admin_kit}', [admin_KitsController::class, 'estado']);

    Route::resource('admin-descuentos', admin_DescuentosController::class);
    Route::put('/admin-descuentos/estado/{admin_descuento}', [admin_DescuentosController::class, 'estado']);
    Route::get('/descuentos_productos/filtro', [admin_DescuentosController::class, 'getfiltro_producto']);
    Route::get('/ver_descuento', [admin_DescuentosController::class, 'getver_descuento']);

    Route::resource('admin-cupones', admin_CuponesController::class);
    Route::put('/admin-cupones/estado/{admin_cupon}', [admin_CuponesController::class, 'estado']);
    Route::get('/search_codigo/cupons', [admin_CuponesController::class, 'getsearch_codigo']);
    Route::get('/ver_cuponera', [admin_CuponesController::class, 'getver_cuponera']);

    Route::resource('admin-coberturas', admin_CoberturasController::class);
    Route::put('/admin-coberturas/estado/{admin_cobertura}', [admin_CoberturasController::class, 'estado']);

    Route::resource('admin-servicios', admin_ServiciosController::class);
    Route::put('/admin-servicios/estado/{admin_servicio}', [admin_ServiciosController::class, 'estado']);

    Route::resource('admin-ordenservicios', admin_OrdenesserviciosController::class);
    Route::put('/admin-ordenservicios/estado/{admin_servicio}', [admin_OrdenesserviciosController::class, 'estado']);
    Route::get('/busqueda_tipos', [admin_OrdenesserviciosController::class, 'getver_tipos']);
    Route::get('/fecha_vigencia', [admin_OrdenesserviciosController::class, 'getver_fecha_vigencia']);
    Route::get('/dt_servicio', [admin_OrdenesserviciosController::class, 'getver_dt_servicio']);

    Route::resource('admin-ordencompras', admin_OrdenescomprasController::class);
    Route::put('/admin-ordencompras/estado/{admin_ordencompra}', [admin_OrdenescomprasController::class, 'estado']);
    Route::get('busqueda_biene_compra', [admin_OrdenescomprasController::class, 'getBusqueda_compra_biene']);
    Route::get('busqueda_detalle_compra', [admin_OrdenescomprasController::class, 'getBusqueda_detalle_compra']);
    Route::get('fecha_cuotas', [admin_OrdenescomprasController::class, 'getFechacuota']);

    Route::resource('admin-ingresos', admin_IngresosController::class);
    route::post('admin-ingresos_general', [admin_IngresosController::class, 'ingreso_general'])->name('ingreso_general.index');
    Route::get('busqueda_dtll_oc', [admin_IngresosController::class, 'getbusqueda_det_oc']);
    Route::get('busqueda_pterminado', [admin_IngresosController::class, 'getbusqueda_pterminado']);
    Route::get('admin-ingresos/detalle-ingreso-pdf/{admin_ingreso}', [admin_IngresosController::class, 'getIngresopdf'])->name('detalle_ingreso.pdf');
    Route::post('admin-ingresos/resultadosPDF', [admin_IngresosController::class, 'reporteIngresosPrintPdfSede'])->name('admin-ingresos.resultadosPDF');


    Route::resource('admin-salidas', admin_SalidasController::class);
    route::post('admin-salidas_general', [admin_SalidasController::class, 'salida_general'])->name('salida_general.index');
    Route::get('busqueda_producto_inventario', [admin_SalidasController::class, 'getbusqueda_producto_inventario']);
    route::get('busqueda_inventarios', [admin_SalidasController::class, 'getbusqueda_inventarios']);
    Route::get('admin-salidas/detalle-salida-pdf/{admin_salida}', [admin_SalidasController::class, 'getSalidapdf'])->name('detalle_salida.pdf');
    Route::post('admin-salidas/resultadosPDF', [admin_SalidasController::class, 'reporteSalidasPrintPdfSede'])->name('admin-salidas.resultadosPDF');

    Route::resource('admin-inventarios', admin_InventarioController::class);
    Route::post('admin-inventarios/resultadosPDF', [admin_InventarioController::class, 'reporteInventariosPrintPdfSede'])
    ->name('admin-inventarios.resultadosPDF');
    route::post('admin-inventarios-totales/resultadosPDF', [admin_InventarioController::class, 'getbusqueda_inventarios_general'])->name('admin-inventarios-totales.resultadosPDF');

    Route::resource('admin-cuentasbancarias', admin_CuentabancoController::class);
    // ---------------------------------------------------------
    // UBIGEO AJAX
    // ---------------------------------------------------------
    Route::get('/ajax/provincias', [admin_UbigeoController::class, 'provincias'])->name('ajax.provincias');
    Route::get('/ajax/distritos', [admin_UbigeoController::class, 'distritos'])->name('ajax.distritos');

    // ---------------------------------------------------------
    // VENTAS
    // ---------------------------------------------------------
    Route::post('admin-clientes', [admin_CrmClientesController::class, 'store'])->name('admin-clientes.store');
    Route::get('admin-clientes/{cliente}/datos', [admin_CrmClientesController::class, 'getDatos'])->name('admin-clientes.datos');

    Route::resource('admin-pedidos', admin_PedidosController::class);
    Route::put('/admin-pedidos/estado/{admin_pedido}', [admin_PedidosController::class, 'estado'])->name('admin-pedidos.estado');
    Route::post('/admin-pedidos/aprobar-finanzas/{admin_pedido}', [admin_PedidosController::class, 'aprobarFinanzas'])->name('admin-pedidos.aprobar-finanzas');
    Route::post('/admin-pedidos/aprobar-stock/{admin_pedido}', [admin_PedidosController::class, 'aprobarStock'])->name('admin-pedidos.aprobar-stock');
    Route::post('/admin-pedidos/generar-comprobante/{admin_pedido}', [admin_PedidosController::class, 'generarComprobante'])->name('admin-pedidos.generar-comprobante');
    Route::get('/admin-pedidos/{pedido}/voucher', [admin_PedidosController::class, 'voucher'])->name('admin-pedidos.voucher');

    Route::resource('admin-ventas', admin_VentasController::class);
    Route::put('/admin-ventas/estado/{admin_venta}', [admin_VentasController::class, 'estado']);
    Route::post('/admin-ventas/{admin_venta}/enviar-email', [admin_VentasController::class, 'enviarEmail'])->name('admin-ventas.enviar-email');
    Route::get('/admin-ventas/{admin_venta}/voucher', [admin_VentasController::class, 'voucher'])->name('admin-ventas.voucher');

    // Cobros
    Route::get('/admin-cobros', [admin_CobrosController::class, 'index'])->name('admin-cobros.index');
    Route::get('/admin-cobros/{admin_cobro}', [admin_CobrosController::class, 'show'])->name('admin-cobros.show');
    Route::post('/admin-cobros/{admin_cobro}', [admin_CobrosController::class, 'store'])->name('admin-cobros.store');

    // Pagos (Egresos - Órdenes de Compra)
    Route::get('/admin-pagos', [admin_PagosController::class, 'index'])->name('admin-pagos.index');
    Route::get('/admin-pagos/{admin_pago}', [admin_PagosController::class, 'show'])->name('admin-pagos.show');
    Route::post('/admin-pagos/{admin_pago}', [admin_PagosController::class, 'store'])->name('admin-pagos.store');

    // Caja Chica
    Route::get('/admin-caja-chica', [admin_CajaChicaController::class, 'index'])->name('admin-caja-chica.index');
    Route::get('/admin-caja-chica/crear', [admin_CajaChicaController::class, 'create'])->name('admin-caja-chica.create');
    Route::post('/admin-caja-chica', [admin_CajaChicaController::class, 'store'])->name('admin-caja-chica.store');
    Route::get('/admin-caja-chica/{admin_caja_chica}', [admin_CajaChicaController::class, 'show'])->name('admin-caja-chica.show');
    Route::put('/admin-caja-chica/{admin_caja_chica}/cerrar', [admin_CajaChicaController::class, 'cerrar'])->name('admin-caja-chica.cerrar');

    // Comprobantes (Finanzas)
    Route::get('/admin-comprobantes-finanzas', [admin_ComprobantesFinanzasController::class, 'index'])->name('admin-comprobantes-finanzas.index');
    Route::get('/admin-comprobantes-finanzas/{admin_comprobante}', [admin_ComprobantesFinanzasController::class, 'show'])->name('admin-comprobantes-finanzas.show');

    // Notas de Crédito / Débito (Finanzas)
    Route::get('/admin-notas', [admin_NotasController::class, 'index'])->name('admin-notas.index');
    Route::get('/admin-notas/crear', [admin_NotasController::class, 'create'])->name('admin-notas.create');
    Route::post('/admin-notas', [admin_NotasController::class, 'store'])->name('admin-notas.store');
    Route::get('/admin-notas/{admin_nota}', [admin_NotasController::class, 'show'])->name('admin-notas.show');
    Route::put('/admin-notas/{admin_nota}/anular', [admin_NotasController::class, 'anular'])->name('admin-notas.anular');

    // ---------------------------------------------------------
    // CRM
    // ---------------------------------------------------------
    Route::prefix('admin/crm')->name('admin.crm.')->group(function () {

        // Prospectos
        Route::resource('prospectos', admin_CrmProspectosController::class);
        Route::post('prospectos/{prospecto}/actividad', [admin_CrmProspectosController::class, 'registrarActividad'])->name('prospectos.actividad');
        Route::patch('prospectos/{prospecto}/estado', [admin_CrmProspectosController::class, 'actualizarEstado'])->name('prospectos.actualizar-estado');

        // Oportunidades
        Route::resource('oportunidades', admin_CrmOportunidadesController::class)->parameters(['oportunidades' => 'oportunidad']);
        Route::post('oportunidades/{oportunidad}/avanzar', [admin_CrmOportunidadesController::class, 'avanzarEtapa'])->name('oportunidades.avanzar');
        Route::post('oportunidades/{oportunidad}/crear-cotizacion', [admin_CrmOportunidadesController::class, 'crearCotizacion'])->name('oportunidades.crear-cotizacion');
        Route::post('oportunidades/{oportunidad}/perdida', [admin_CrmOportunidadesController::class, 'marcarPerdida'])->name('oportunidades.perdida');
        Route::post('oportunidades/{oportunidad}/actividad', [admin_CrmOportunidadesController::class, 'registrarActividad'])->name('oportunidades.actividad');
        Route::get('prospectos/{prospecto}/wishlist', [admin_CrmOportunidadesController::class, 'getWishlist'])->name('prospectos.wishlist');

        // Cotizaciones
        Route::resource('cotizaciones', admin_CrmCotizacionesController::class)->parameters(['cotizaciones' => 'cotizacion']);
        Route::post('cotizaciones/{cotizacion}/enviar', [admin_CrmCotizacionesController::class, 'enviar'])->name('cotizaciones.enviar');
        Route::post('cotizaciones/{cotizacion}/aprobar', [admin_CrmCotizacionesController::class, 'aprobar'])->name('cotizaciones.aprobar');
        Route::post('cotizaciones/{cotizacion}/rechazar', [admin_CrmCotizacionesController::class, 'rechazar'])->name('cotizaciones.rechazar');
        Route::post('cotizaciones/{cotizacion}/duplicar', [admin_CrmCotizacionesController::class, 'duplicar'])->name('cotizaciones.duplicar');
        Route::get('cotizaciones/{cotizacion}/pdf', [admin_CrmCotizacionesController::class, 'generarPdf'])->name('cotizaciones.pdf');
        Route::get('cotizaciones/{cotizacion}/preview', [admin_CrmCotizacionesController::class, 'previsualizarPdf'])->name('cotizaciones.preview');
        Route::post('cotizaciones/{cotizacion}/recalcular', [admin_CrmCotizacionesController::class, 'recalcular'])->name('cotizaciones.recalcular');
        Route::post('cotizaciones/{cotizacion}/items-guardar', [admin_CrmCotizacionesController::class, 'guardarItems'])->name('cotizaciones.guardarItems');

        // Actividades
        Route::resource('actividades', admin_CrmActividadesController::class)->parameters(['actividades' => 'actividad']);
        Route::post('actividades/{actividad}/completar', [admin_CrmActividadesController::class, 'completar'])->name('actividades.completar');
        Route::post('actividades/{actividad}/cancelar', [admin_CrmActividadesController::class, 'cancelar'])->name('actividades.cancelar');
        Route::post('actividades/{actividad}/reprogramar', [admin_CrmActividadesController::class, 'reprogramar'])->name('actividades.reprogramar');
        Route::post('actividades/{actividad}/iniciar-evaluacion', [admin_CrmActividadesController::class, 'iniciarEvaluacion'])->name('actividades.iniciar-evaluacion');
        Route::post('actividades/{actividad}/no-realizada', [admin_CrmActividadesController::class, 'noRealizada'])->name('actividades.no-realizada');
        Route::post('actividades/{actividad}/seguimiento', [admin_CrmActividadesController::class, 'crearSeguimiento'])->name('actividades.seguimiento');
        Route::get('actividades-eventos', [admin_CrmActividadesController::class, 'eventosCalendario'])->name('actividades.eventos');
        Route::patch('actividades/{actividad}/fecha', [admin_CrmActividadesController::class, 'actualizarFecha'])->name('actividades.actualizar-fecha');
        Route::get('actividades-pendientes', [admin_CrmActividadesController::class, 'misPendientes'])->name('actividades.pendientes');
        Route::get('actividades-notificaciones', [admin_CrmActividadesController::class, 'notificacionesCampana'])->name('actividades.notificaciones');
        Route::post('actividades-notificaciones/descartar', [admin_CrmActividadesController::class, 'descartarNotificacion'])->name('actividades.notificaciones.descartar');

        // Clientes
        Route::resource('clientes', admin_CrmClientesController::class)->except(['create', 'store']);
        Route::post('clientes/{cliente}/cambiar-estado', [admin_CrmClientesController::class, 'cambiarEstado'])->name('clientes.cambiar-estado');

        // Tickets
        Route::get('tickets/pedidos-por-cliente/{clienteId}', [admin_CrmTicketsController::class, 'pedidosPorCliente'])->name('tickets.pedidos-por-cliente');
        Route::get('tickets/ventas-por-cliente/{clienteId}', [admin_CrmTicketsController::class, 'ventasPorCliente'])->name('tickets.ventas-por-cliente');
        Route::post('tickets/{ticket}/agendar-visita', [admin_CrmTicketsController::class, 'agendarVisita'])->name('tickets.agendar-visita');
        Route::resource('tickets', admin_CrmTicketsController::class);
        Route::patch('tickets/{ticket}/estado', [admin_CrmTicketsController::class, 'cambiarEstado'])->name('tickets.cambiar-estado');
        Route::post('tickets/{ticket}/asignar', [admin_CrmTicketsController::class, 'asignar'])->name('tickets.asignar');

        // Mantenimientos
        Route::resource('mantenimientos', admin_CrmMantenimientosController::class)->except(['create', 'store']);
        Route::post('mantenimientos/{mantenimiento}/confirmar', [admin_CrmMantenimientosController::class, 'confirmar'])->name('mantenimientos.confirmar');
        Route::post('mantenimientos/{mantenimiento}/iniciar', [admin_CrmMantenimientosController::class, 'iniciar'])->name('mantenimientos.iniciar');
        Route::post('mantenimientos/{mantenimiento}/completar', [admin_CrmMantenimientosController::class, 'completar'])->name('mantenimientos.completar');
        Route::post('mantenimientos/{mantenimiento}/cancelar', [admin_CrmMantenimientosController::class, 'cancelar'])->name('mantenimientos.cancelar');
        Route::post('mantenimientos/{mantenimiento}/reprogramar', [admin_CrmMantenimientosController::class, 'reprogramar'])->name('mantenimientos.reprogramar');

    }); // Fin CRM

    // ---------------------------------------------------------
    // OPERACIONES
    // ---------------------------------------------------------

    // Asignaciones
    Route::get('admin-operaciones-asignaciones', [admin_OperacionesController::class, 'asignacionesIndex'])->name('admin-operaciones-asignaciones.index');
    Route::get('admin-operaciones-asignaciones/data', [admin_OperacionesController::class, 'asignacionesData'])->name('admin-operaciones-asignaciones.data');
    Route::get('admin-operaciones-asignaciones/stats', [admin_OperacionesController::class, 'asignacionesGetStats'])->name('admin-operaciones-asignaciones.stats');
    Route::post('admin-operaciones-asignaciones/asignar', [admin_OperacionesController::class, 'asignacionesAsignar'])->name('admin-operaciones-asignaciones.asignar');
    Route::get('admin-operaciones-asignaciones/filtrar', [admin_OperacionesController::class, 'asignacionesFiltrar'])->name('admin-operaciones-asignaciones.filtrar');
    Route::get('admin-operaciones-asignaciones/{id}', [admin_OperacionesController::class, 'asignacionesGetPedido'])->name('admin-operaciones-asignaciones.show');

    // Calidad
    Route::get('admin-operaciones-calidad', [admin_OperacionesController::class, 'calidadIndex'])->name('admin-operaciones-calidad.index');
    Route::post('admin-operaciones-calidad/guardar-check', [admin_OperacionesController::class, 'calidadGuardarCheck'])->name('admin-operaciones-calidad.guardar-check');
    Route::post('admin-operaciones-calidad/aprobar', [admin_OperacionesController::class, 'calidadAprobar'])->name('admin-operaciones-calidad.aprobar');
    Route::post('admin-operaciones-calidad/rechazar', [admin_OperacionesController::class, 'calidadRechazar'])->name('admin-operaciones-calidad.rechazar');
    Route::get('admin-operaciones-calidad/{id}', [admin_OperacionesController::class, 'calidadGetPedido'])->name('admin-operaciones-calidad.show');

    // Trazabilidad
    Route::get('admin-operaciones-trazabilidad', [admin_OperacionesController::class, 'trazabilidadIndex'])->name('admin-operaciones-trazabilidad.index');
    Route::get('admin-operaciones-trazabilidad/buscar', [admin_OperacionesController::class, 'trazabilidadBuscar'])->name('admin-operaciones-trazabilidad.buscar');
    Route::get('admin-operaciones-trazabilidad/{id}', [admin_OperacionesController::class, 'trazabilidadGetPedido'])->name('admin-operaciones-trazabilidad.show');

    // Campañas
    Route::get('admin-operaciones-campanias', [admin_OperacionesController::class, 'campaniasIndex'])->name('admin-operaciones-campanias.index');
    Route::get('admin-operaciones-campanias/crear', [admin_OperacionesController::class, 'campaniasCreate'])->name('admin-operaciones-campanias.create');
    Route::post('admin-operaciones-campanias', [admin_OperacionesController::class, 'campaniasStore'])->name('admin-operaciones-campanias.store');
    Route::get('admin-operaciones-campanias/ajax/productos', [admin_OperacionesController::class, 'campaniasGetProductos'])->name('admin-operaciones-campanias.ajax.productos');
    Route::get('admin-operaciones-campanias/{id}', [admin_OperacionesController::class, 'campaniasShow'])->name('admin-operaciones-campanias.show');
    Route::get('admin-operaciones-campanias/{id}/editar', [admin_OperacionesController::class, 'campaniasEdit'])->name('admin-operaciones-campanias.edit');
    Route::put('admin-operaciones-campanias/{id}', [admin_OperacionesController::class, 'campaniasUpdate'])->name('admin-operaciones-campanias.update');
    Route::delete('admin-operaciones-campanias/{id}', [admin_OperacionesController::class, 'campaniasDestroy'])->name('admin-operaciones-campanias.destroy');
    Route::post('admin-operaciones-campanias/{id}/activar', [admin_OperacionesController::class, 'campaniasActivar'])->name('admin-operaciones-campanias.activar');
    Route::post('admin-operaciones-campanias/{id}/pausar', [admin_OperacionesController::class, 'campaniasPausar'])->name('admin-operaciones-campanias.pausar');
    Route::post('admin-operaciones-campanias/{id}/reanudar', [admin_OperacionesController::class, 'campaniasReanudar'])->name('admin-operaciones-campanias.reanudar');
    Route::post('admin-operaciones-campanias/{id}/finalizar', [admin_OperacionesController::class, 'campaniasFinalizar'])->name('admin-operaciones-campanias.finalizar');
    Route::post('admin-operaciones-campanias/{id}/duplicar', [admin_OperacionesController::class, 'campaniasDuplicar'])->name('admin-operaciones-campanias.duplicar');
    Route::get('admin-operaciones-campanias/{id}/metricas', [admin_OperacionesController::class, 'campaniasGetMetricas'])->name('admin-operaciones-campanias.metricas');

}); // Fin middleware auth

// =============================================================
// AUTH — Login, registro, password reset (públicos)
// =============================================================
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
