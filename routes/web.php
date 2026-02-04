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

// CRM - Prospectos
Route::get('admin-crm-prospectos', function () {
    return view('ADMINISTRADOR.PRINCIPAL.crm.prospectos.index');
})->name('admin-crm-prospectos.index');

// CRM - Oportunidades
Route::get('admin-crm-oportunidades', function () {
    return view('ADMINISTRADOR.PRINCIPAL.crm.oportunidades.index');
})->name('admin-crm-oportunidades.index');

// CRM - Cotizaciones
Route::get('admin-crm-cotizaciones', function () {
    return view('ADMINISTRADOR.PRINCIPAL.crm.cotizaciones.index');
})->name('admin-crm-cotizaciones.index');

// CRM - Clientes
Route::get('admin-crm-clientes', function () {
    return view('ADMINISTRADOR.PRINCIPAL.crm.clientes.index');
})->name('admin-crm-clientes.index');

// CRM - Agenda
Route::get('admin-crm-agenda', function () {
    return view('ADMINISTRADOR.PRINCIPAL.crm.agenda.index');
})->name('admin-crm-agenda.index');

// CRM - Postventa
Route::get('admin-crm-postventa', function () {
    return view('ADMINISTRADOR.PRINCIPAL.crm.postventa.index');
})->name('admin-crm-postventa.index');

// CRM - Fidelización
Route::get('admin-crm-fidelizacion', function () {
    return view('ADMINISTRADOR.PRINCIPAL.crm.fidelizacion.index');
})->name('admin-crm-fidelizacion.index');

// CRM - Marketing
Route::get('admin-crm-marketing', function () {
    return view('ADMINISTRADOR.PRINCIPAL.crm.marketing.index');
})->name('admin-crm-marketing.index');

Route::get('admin-reportes', [admin_ReportesController::class, 'index'])->name('admin-reportes.index');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
