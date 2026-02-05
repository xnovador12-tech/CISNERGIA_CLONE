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
use App\Http\Controllers\admin_ClientesController;
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
use App\Http\Controllers\admin_SeguimientoController;
use App\Http\Controllers\admin_SalidasController;
use App\Http\Controllers\admin_InventarioController;
use App\Http\Controllers\ecommerceController;
use App\Http\Controllers\admin_CrmProspectosController;
use App\Http\Controllers\admin_CrmOportunidadesController;
use App\Http\Controllers\admin_CrmCotizacionesController;
use App\Http\Controllers\admin_CrmActividadesController;
use App\Http\Controllers\admin_CrmTicketsController;
use App\Http\Controllers\admin_CrmGarantiasController;
use App\Http\Controllers\admin_CrmMantenimientosController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// ECOMMERCE
Route::get('/', [ecommerceController::class, 'index'])->name('ecommerce.index');
Route::get('/products', [ecommerceController::class, 'products'])->name('ecommerce.products');
Route::get('/product/{slug}', [ecommerceController::class, 'show'])->name('ecommerce.product.show');

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

// ADMINISTRADOR
Route::get('admin-dashboard', [admin_DashboardController::class, 'index'])->name('admin-dashboard.index');

Route::get('admin-configuraciones', [admin_ConfiguracionesController::class, 'index'])->name('admin-configuraciones.index');

Route::resource('admin-informacion', admin_InformacionController::class);
Route::resource('admin-roles', admin_RolesController::class);
Route::resource('admin-usuarios', admin_UsuariosController::class);
Route::put('/admin-usuarios/estado/{admin_usuario}', [admin_UsuariosController::class, 'estado']);
Route::resource('admin-perfil', admin_PerfilController::class);

Route::resource('admin-tipos', admin_TiposController::class);
Route::put('/admin-tipos/estado/{admin_tipo}', [admin_TiposController::class, 'estado']);
Route::resource('admin-categorias', admin_CategoriasController::class);
Route::put('/admin-categorias/estado/{admin_categoria}', [admin_CategoriasController::class, 'estado']);
Route::resource('admin-marcas', admin_MarcasController::class);
Route::put('/admin-marcas/estado/{admin_marca}', [admin_MarcasController::class, 'estado']);
Route::resource('admin-etiquetas', admin_EtiquetasController::class);
Route::put('/admin-etiquetas/estado/{admin_etiqueta}', [admin_EtiquetasController::class, 'estado']);

Route::resource('admin-proveedores', admin_ProveedoresController::class);
Route::put('/admin-proveedores/estado/{admin_proveedor}', [admin_ProveedoresController::class, 'estado']);

Route::resource('admin-productos', admin_ProductosController::class);
Route::put('/admin-productos/estado/{admin_producto}', [admin_ProductosController::class, 'estado']);
Route::get('busqueda_categoria_productos', [admin_ProductosController::class, 'getBusqueda_categoria_productos']);
Route::get('busqueda_proved', [admin_ProductosController::class, 'getBusquedaproved']);
Route::get('busqueda_proved_edit', [admin_ProductosController::class, 'getbusqueda_proved_edit']);

Route::resource('admin-kits', admin_KitsController::class);
Route::get('/dtlle_kits', [admin_KitsController::class, 'getdtlle_kits']);
Route::get('/images/{id}/delete', [admin_KitsController::class, 'deleteImage']);
Route::put('/admin-kits/estado/{admin_kit}', [admin_KitsController::class, 'estado']);

Route::resource('admin-clientes', admin_ClientesController::class);
Route::put('/admin-clientes/estado/{admin_cliente}', [admin_ClientesController::class, 'estado']);

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
Route::get('busqueda_dtll_oc', [admin_IngresosController::class, 'getbusqueda_det_oc']);
Route::get('busqueda_pterminado', [admin_IngresosController::class, 'getbusqueda_pterminado']);

Route::resource('admin-salidas', admin_SalidasController::class);

Route::resource('admin-inventarios', admin_InventarioController::class);

// VENTAS
Route::resource('admin-pedidos', admin_PedidosController::class);
Route::put('/admin-pedidos/estado/{admin_pedido}', [admin_PedidosController::class, 'estado']);

Route::resource('admin-ventas', admin_VentasController::class);
Route::put('/admin-ventas/estado/{admin_venta}', [admin_VentasController::class, 'estado']);

Route::get('admin-seguimiento', [admin_SeguimientoController::class, 'index'])->name('admin-seguimiento.index');

// =====================================================
// CRM ROUTES - Sistema de Gestión de Relaciones
// =====================================================

Route::prefix('admin/crm')->name('admin.crm.')->group(function () {

    // -------------------------------------------------
    // PROSPECTOS (Leads)
    // -------------------------------------------------
    Route::resource('prospectos', admin_CrmProspectosController::class);
    Route::post('prospectos/{prospecto}/convertir-cliente', [admin_CrmProspectosController::class, 'convertirACliente'])->name('prospectos.convertir');
    Route::post('prospectos/{prospecto}/crear-oportunidad', [admin_CrmProspectosController::class, 'crearOportunidad'])->name('prospectos.crear-oportunidad');
    Route::post('prospectos/{prospecto}/actividad', [admin_CrmProspectosController::class, 'registrarActividad'])->name('prospectos.actividad');
    Route::patch('prospectos/{prospecto}/estado', [admin_CrmProspectosController::class, 'actualizarEstado'])->name('prospectos.actualizar-estado');
    Route::patch('prospectos/{prospecto}/scoring', [admin_CrmProspectosController::class, 'actualizarScoring'])->name('prospectos.actualizar-scoring');
    Route::get('prospectos-exportar', [admin_CrmProspectosController::class, 'exportar'])->name('prospectos.exportar');

    // -------------------------------------------------
    // OPORTUNIDADES (Pipeline de Ventas)
    // -------------------------------------------------
    Route::resource('oportunidades', admin_CrmOportunidadesController::class)->parameters(['oportunidades' => 'oportunidad']);
    Route::post('oportunidades/{oportunidad}/avanzar', [admin_CrmOportunidadesController::class, 'avanzarEtapa'])->name('oportunidades.avanzar');
    Route::patch('oportunidades/{oportunidad}/etapa', [admin_CrmOportunidadesController::class, 'cambiarEtapa'])->name('oportunidades.cambiar-etapa');
    Route::post('oportunidades/{oportunidad}/ganada', [admin_CrmOportunidadesController::class, 'marcarGanada'])->name('oportunidades.ganada');
    Route::post('oportunidades/{oportunidad}/perdida', [admin_CrmOportunidadesController::class, 'marcarPerdida'])->name('oportunidades.perdida');
    Route::post('oportunidades/{oportunidad}/convertir-cliente', [admin_CrmOportunidadesController::class, 'convertirACliente'])->name('oportunidades.convertir-cliente');
    Route::post('oportunidades/{oportunidad}/cotizacion', [admin_CrmOportunidadesController::class, 'crearCotizacion'])->name('oportunidades.crear-cotizacion');
    Route::post('oportunidades/{oportunidad}/actividad', [admin_CrmOportunidadesController::class, 'registrarActividad'])->name('oportunidades.actividad');
    Route::get('oportunidades-exportar', [admin_CrmOportunidadesController::class, 'exportar'])->name('oportunidades.exportar');

    // -------------------------------------------------
    // COTIZACIONES
    // -------------------------------------------------
    Route::resource('cotizaciones', admin_CrmCotizacionesController::class);
    Route::post('cotizaciones/{cotizacione}/enviar', [admin_CrmCotizacionesController::class, 'enviar'])->name('cotizaciones.enviar');
    Route::post('cotizaciones/{cotizacione}/aprobar', [admin_CrmCotizacionesController::class, 'aprobar'])->name('cotizaciones.aprobar');
    Route::post('cotizaciones/{cotizacione}/rechazar', [admin_CrmCotizacionesController::class, 'rechazar'])->name('cotizaciones.rechazar');
    Route::post('cotizaciones/{cotizacione}/duplicar', [admin_CrmCotizacionesController::class, 'duplicar'])->name('cotizaciones.duplicar');
    Route::get('cotizaciones/{cotizacione}/pdf', [admin_CrmCotizacionesController::class, 'generarPdf'])->name('cotizaciones.pdf');
    Route::get('cotizaciones/{cotizacione}/preview', [admin_CrmCotizacionesController::class, 'previsualizarPdf'])->name('cotizaciones.preview');
    Route::post('cotizaciones/{cotizacione}/recalcular', [admin_CrmCotizacionesController::class, 'recalcular'])->name('cotizaciones.recalcular');
    Route::get('cotizaciones-comparar', [admin_CrmCotizacionesController::class, 'comparar'])->name('cotizaciones.comparar');

    // Ítems de cotización
    Route::post('cotizaciones/{cotizacione}/items', [admin_CrmCotizacionesController::class, 'agregarItem'])->name('cotizaciones.agregarItem');
    Route::put('cotizaciones/{cotizacione}/items/{item}', [admin_CrmCotizacionesController::class, 'actualizarItem'])->name('cotizaciones.actualizarItem');
    Route::delete('cotizaciones/{cotizacione}/items/{item}', [admin_CrmCotizacionesController::class, 'eliminarItem'])->name('cotizaciones.eliminarItem');
    Route::post('cotizaciones/{cotizacione}/items-guardar', [admin_CrmCotizacionesController::class, 'guardarItems'])->name('cotizaciones.guardarItems');

    // -------------------------------------------------
    // ACTIVIDADES (Agenda CRM)
    // -------------------------------------------------
    Route::resource('actividades', admin_CrmActividadesController::class);
    Route::get('actividades-calendario', [admin_CrmActividadesController::class, 'calendario'])->name('actividades.calendario');
    Route::get('actividades-agenda', [admin_CrmActividadesController::class, 'agenda'])->name('actividades.agenda');
    Route::post('actividades/{actividade}/completar', [admin_CrmActividadesController::class, 'completar'])->name('actividades.completar');
    Route::post('actividades/{actividade}/cancelar', [admin_CrmActividadesController::class, 'cancelar'])->name('actividades.cancelar');
    Route::post('actividades/{actividade}/reprogramar', [admin_CrmActividadesController::class, 'reprogramar'])->name('actividades.reprogramar');
    Route::post('actividades/{actividade}/seguimiento', [admin_CrmActividadesController::class, 'crearSeguimiento'])->name('actividades.seguimiento');
    Route::get('actividades-eventos', [admin_CrmActividadesController::class, 'eventosCalendario'])->name('actividades.eventos');
    Route::patch('actividades/{actividade}/fecha', [admin_CrmActividadesController::class, 'actualizarFecha'])->name('actividades.actualizar-fecha');
    Route::get('actividades-pendientes', [admin_CrmActividadesController::class, 'misPendientes'])->name('actividades.pendientes');
    Route::get('actividades-recordatorios', [admin_CrmActividadesController::class, 'recordatoriosProximos'])->name('actividades.recordatorios');

    // -------------------------------------------------
    // TICKETS (Soporte)
    // -------------------------------------------------
    Route::resource('tickets', admin_CrmTicketsController::class);
    Route::post('tickets/{ticket}/mensaje', [admin_CrmTicketsController::class, 'agregarMensaje'])->name('tickets.mensaje');
    Route::patch('tickets/{ticket}/estado', [admin_CrmTicketsController::class, 'cambiarEstado'])->name('tickets.cambiar-estado');
    Route::post('tickets/{ticket}/asignar', [admin_CrmTicketsController::class, 'asignar'])->name('tickets.asignar');
    Route::post('tickets/{ticket}/escalar', [admin_CrmTicketsController::class, 'escalar'])->name('tickets.escalar');
    Route::post('tickets/{ticket}/calificar', [admin_CrmTicketsController::class, 'calificar'])->name('tickets.calificar');
    Route::get('tickets-metricas', [admin_CrmTicketsController::class, 'metricas'])->name('tickets.metricas');

    // -------------------------------------------------
    // GARANTÍAS
    // -------------------------------------------------
    Route::resource('garantias', admin_CrmGarantiasController::class);
    Route::post('garantias/{garantia}/uso', [admin_CrmGarantiasController::class, 'registrarUso'])->name('garantias.uso');
    Route::post('garantias/{garantia}/extender', [admin_CrmGarantiasController::class, 'extender'])->name('garantias.extender');
    Route::get('garantias-verificar', [admin_CrmGarantiasController::class, 'verificar'])->name('garantias.verificar');
    Route::get('garantias-alertas', [admin_CrmGarantiasController::class, 'alertas'])->name('garantias.alertas');
    Route::get('garantias-reporte', [admin_CrmGarantiasController::class, 'reporte'])->name('garantias.reporte');
    Route::get('garantias-exportar', [admin_CrmGarantiasController::class, 'exportar'])->name('garantias.exportar');

    // -------------------------------------------------
    // MANTENIMIENTOS
    // -------------------------------------------------
    Route::resource('mantenimientos', admin_CrmMantenimientosController::class);
    Route::get('mantenimientos-calendario', [admin_CrmMantenimientosController::class, 'calendario'])->name('mantenimientos.calendario');
    Route::post('mantenimientos/{mantenimiento}/confirmar', [admin_CrmMantenimientosController::class, 'confirmar'])->name('mantenimientos.confirmar');
    Route::post('mantenimientos/{mantenimiento}/iniciar', [admin_CrmMantenimientosController::class, 'iniciar'])->name('mantenimientos.iniciar');
    Route::post('mantenimientos/{mantenimiento}/completar', [admin_CrmMantenimientosController::class, 'completar'])->name('mantenimientos.completar');
    Route::post('mantenimientos/{mantenimiento}/cancelar', [admin_CrmMantenimientosController::class, 'cancelar'])->name('mantenimientos.cancelar');
    Route::post('mantenimientos/{mantenimiento}/reprogramar', [admin_CrmMantenimientosController::class, 'reprogramar'])->name('mantenimientos.reprogramar');
    Route::post('mantenimientos/{mantenimiento}/asignar-tecnico', [admin_CrmMantenimientosController::class, 'asignarTecnico'])->name('mantenimientos.asignar-tecnico');
    Route::get('mantenimientos/{mantenimiento}/reporte', [admin_CrmMantenimientosController::class, 'generarReporte'])->name('mantenimientos.reporte');
    Route::post('mantenimientos-recurrente', [admin_CrmMantenimientosController::class, 'programarRecurrente'])->name('mantenimientos.recurrente');
    Route::get('mantenimientos-eventos', [admin_CrmMantenimientosController::class, 'eventosCalendario'])->name('mantenimientos.eventos');
    Route::get('mantenimientos-exportar', [admin_CrmMantenimientosController::class, 'exportar'])->name('mantenimientos.exportar');
}); // Fin del grupo CRM

// Verificación pública de garantías
Route::get('verificar-garantia', [admin_CrmGarantiasController::class, 'verificar'])->name('garantias.verificar-publico');


Route::get('admin-reportes', [admin_ReportesController::class, 'index'])->name('admin-reportes.index');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

