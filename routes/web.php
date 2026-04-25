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
use App\Http\Controllers\admin_NotaVentasController;
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
use App\Http\Controllers\admin_CrmReseñasController;
use App\Http\Controllers\admin_ModeloController;
use App\Http\Controllers\admin_UbigeoController;
use Illuminate\Support\Facades\Route;

// =============================================================
// ECOMMERCE — Rutas públicas (sin auth)
// =============================================================

Route::get('limpiar-sesion-cisnergia', [ecommerceController::class, 'limpiarSesioncisnergia'])->name('limpiar-sesion-cisnergia.get');

Route::get('/', [ecommerceController::class, 'index'])->name('ecommerce.index');
Route::get('/mis_compras', [ecommerceController::class, 'misCompras'])->name('ecommerce.mis_compras');
route::get('/getfiltro_miscompras', [ecommerceController::class, 'getfiltro_miscompras']);
Route::get('/getdetalle_venta', [ecommerceController::class, 'getdetalle_venta']);
Route::get('/products', [ecommerceController::class, 'products'])->name('ecommerce.products');
Route::get('/product/{slug}', [ecommerceController::class, 'show_product'])->name('ecommerce.product.show');
route::get('/busqueda_pmarca', [ecommerceController::class, 'getbusqueda_pmarca']);
route::get('/busqueda_pproducto_categoria', [ecommerceController::class, 'getbusqueda_pproducto_categoria']);
route::get('/busqueda_pproducto_marca', [ecommerceController::class, 'getbusqueda_pproducto_marca']);
Route::post('comments_producto', [ecommerceController::class, 'postcomments'])->name('ecommerce.product.store_comments');
Route::get('ver_carrito', [ecommerceController::class, 'getcargar_carrito']);
Route::get('agregar_compra_carrito', [ecommerceController::class, 'getagregar_compra_carrito']);
Route::get('carrito-compras', [ecommerceController::class, 'index'])->name('ecommerce.carrito_compras.index');
Route::get('listado_pago_carrito_compras', [ecommerceController::class, 'pago_carrito_compra'])->name('ecommerce_pago_carrito_compras.index');
Route::get('eliminar_carrito', [ecommerceController::class, 'geteliminar_carrito']);
Route::get('actualizar_cantidad_carrito', [ecommerceController::class, 'getactualizar_cantidad_carrito']);
Route::get('/confirmacion_pago_exitoso/{sale}', [ecommerceController::class, 'confirmation'])->name('ecommerce.confirmacion_pago');
route::get('/comprobante_compra/{sale}', [ecommerceController::class, 'comprobante_compra'])->name('ecommerce.comprobante_compra');
Route::get('lista_deseo_carrito', [ecommerceController::class, 'getlista_deseo_carrito']);
Route::get('eliminar_lista_deseo_carrito', [ecommerceController::class, 'geteliminarlista_deseo_carrito']);
Route::get('agregar_compra_carritofavoritos', [ecommerceController::class, 'getagregar_compra_carritofavoritos']);

Route::get('/installation', [ecommerceController::class, 'installation'])->name('ecommerce.installation');
Route::get('/contact', [ecommerceController::class, 'contact'])->name('ecommerce.contact');
route::get('/mi/perfil', [ecommerceController::class, 'getmiperfil'])->name('ecommerce.mi_perfil');
route::post('/mis/direcciones/crear', [ecommerceController::class, 'crearDireccion'])->name('ecommerce-direccion.create');
route::put('/mis/direcciones/actualizar/{id}', [ecommerceController::class, 'getMisDirecciones'])->name('ecommerce-direccion.actualizar');
route::post('/ecommerce/direccion/eliminar/{id}', [ecommerceController::class, 'eliminardireccion'])->name('ecommerce-direccion.eliminar');
route::put('/mis/contraseña/actualizar', [ecommerceController::class, 'cambiarContrasena'])->name('ecommerce.cambiar_contraseña');
route::post('/mi/perfil/otp/enviar', [ecommerceController::class, 'enviarCodigoRecuperacion'])->name('ecommerce.otp.enviar');
route::post('/mi/perfil/otp/cambiar-password', [ecommerceController::class, 'cambiarContrasenaConOtp'])->name('ecommerce.otp.cambiar_password');
route::get('/mis/favorites', [ecommerceController::class, 'getMisFavoritos'])->name('ecommerce.mis_favoritos');

// Carrito (en inglés - pendientes de coordinar con compañero ecommerce)
Route::post('/cart/add', [ecommerceController::class, 'addToCart'])->name('ecommerce.cart.add');
Route::get('/cart', [ecommerceController::class, 'cart'])->name('ecommerce.cart');
Route::post('/cart/update/{itemId}', [ecommerceController::class, 'updateCart'])->name('ecommerce.cart.update');
Route::delete('/cart/remove/{itemId}', [ecommerceController::class, 'removeFromCart'])->name('ecommerce.cart.remove');
Route::get('/cart/count', [ecommerceController::class, 'getCartCount'])->name('ecommerce.cart.count');

// Checkout
Route::get('/checkout', [ecommerceController::class, 'checkout'])->name('ecommerce.checkout');
route::get('ver_provincias', [ecommerceController::class, 'getprovincias']);
route::get('ver_distritos', [ecommerceController::class, 'getdistritos']);
Route::post('/checkout/process', [ecommerceController::class, 'processCheckout'])->name('ecommerce.checkout.process');
Route::get('/order-confirmation/{sale}', [ecommerceController::class, 'confirmation'])->name('ecommerce.confirmation');
Route::post('pago-ecommerce/processCulqi', [ecommerceController::class, 'createCulqiCharge'])->name('pago_ecommerce.createCulqiCharge');

// =============================================================
// ADMINISTRADOR — Todas las rutas protegidas con auth + permission
// =============================================================
Route::middleware(['auth'])->group(function () {

    // ---------------------------------------------------------
    // DASHBOARD Y GENERALES
    // ---------------------------------------------------------
    Route::get('admin-dashboard',       [admin_DashboardController::class, 'index'])
        ->middleware('permission:dashboard.index')
        ->name('admin-dashboard.index');

    Route::get('admin-configuraciones', [admin_ConfiguracionesController::class, 'index'])
        ->middleware('permission:configuraciones.index')
        ->name('admin-configuraciones.index');

    Route::get('admin-reportes',        [admin_ReportesController::class, 'index'])
        ->middleware('permission:reportes.index')
        ->name('admin-reportes.index');

    // Información de la empresa (todos los métodos requieren permiso de editar)
    Route::middleware('permission:informacion.edit')->group(function () {
        Route::resource('admin-informacion', admin_InformacionController::class);
    });

    // Perfil propio — cualquier autenticado puede ver/editar su propio perfil (sin permiso especial)
    Route::get('admin-perfil',            [admin_PerfilController::class, 'index'])->name('admin-perfil.index');
    Route::put('admin-perfil',            [admin_PerfilController::class, 'update'])->name('admin-perfil.update');
    Route::put('admin-perfil/password',   [admin_PerfilController::class, 'updatePassword'])->name('admin-perfil.password');

    // ---------------------------------------------------------
    // CONFIGURACIONES — ROLES
    // ---------------------------------------------------------
    Route::get('admin-roles',                   [admin_RolesController::class, 'index'])
        ->middleware('permission:configuraciones.roles.index')->name('admin-roles.index');
    Route::get('admin-roles/create',            [admin_RolesController::class, 'create'])
        ->middleware('permission:configuraciones.roles.create')->name('admin-roles.create');
    Route::post('admin-roles',                  [admin_RolesController::class, 'store'])
        ->middleware('permission:configuraciones.roles.create')->name('admin-roles.store');
    Route::get('admin-roles/{admin_role}/edit', [admin_RolesController::class, 'edit'])
        ->middleware('permission:configuraciones.roles.edit')->name('admin-roles.edit');
    Route::put('admin-roles/{admin_role}',      [admin_RolesController::class, 'update'])
        ->middleware('permission:configuraciones.roles.edit')->name('admin-roles.update');
    Route::delete('admin-roles/{admin_role}',   [admin_RolesController::class, 'destroy'])
        ->middleware('permission:configuraciones.roles.delete')->name('admin-roles.destroy');

    // ---------------------------------------------------------
    // CONFIGURACIONES — USUARIOS
    // ---------------------------------------------------------
    Route::get('admin-usuarios',                                [admin_UsuariosController::class, 'index'])
        ->middleware('permission:configuraciones.usuarios.index')->name('admin-usuarios.index');
    Route::get('admin-usuarios/create',                         [admin_UsuariosController::class, 'create'])
        ->middleware('permission:configuraciones.usuarios.create')->name('admin-usuarios.create');
    Route::post('admin-usuarios',                               [admin_UsuariosController::class, 'store'])
        ->middleware('permission:configuraciones.usuarios.create')->name('admin-usuarios.store');
    Route::put('admin-usuarios/estado/{admin_usuario}',         [admin_UsuariosController::class, 'estado'])
        ->middleware('permission:configuraciones.usuarios.edit');
    Route::get('admin-usuarios/{admin_usuario}',                [admin_UsuariosController::class, 'show'])
        ->middleware('permission:configuraciones.usuarios.index')->name('admin-usuarios.show');
    Route::get('admin-usuarios/{admin_usuario}/edit',           [admin_UsuariosController::class, 'edit'])
        ->middleware('permission:configuraciones.usuarios.edit')->name('admin-usuarios.edit');
    Route::put('admin-usuarios/{admin_usuario}',                [admin_UsuariosController::class, 'update'])
        ->middleware('permission:configuraciones.usuarios.edit')->name('admin-usuarios.update');
    Route::delete('admin-usuarios/{admin_usuario}',             [admin_UsuariosController::class, 'destroy'])
        ->middleware('permission:configuraciones.usuarios.delete')->name('admin-usuarios.destroy');

    // ---------------------------------------------------------
    // CONFIGURACIONES — CATÁLOGO
    // ---------------------------------------------------------

    // Modelos
    Route::get('admin-modelos',                         [admin_ModeloController::class, 'index'])
        ->middleware('permission:configuraciones.modelos.index')->name('admin-modelos.index');
    Route::get('admin-modelos/create',                  [admin_ModeloController::class, 'create'])
        ->middleware('permission:configuraciones.modelos.create')->name('admin-modelos.create');
    Route::post('admin-modelos',                        [admin_ModeloController::class, 'store'])
        ->middleware('permission:configuraciones.modelos.create')->name('admin-modelos.store');
    Route::put('admin-modelos/estado/{admin_modelo}',   [admin_ModeloController::class, 'estado'])
        ->middleware('permission:configuraciones.modelos.edit');
    Route::get('admin-modelos/{admin_modelo}',          [admin_ModeloController::class, 'show'])
        ->middleware('permission:configuraciones.modelos.index')->name('admin-modelos.show');
    Route::get('admin-modelos/{admin_modelo}/edit',     [admin_ModeloController::class, 'edit'])
        ->middleware('permission:configuraciones.modelos.edit')->name('admin-modelos.edit');
    Route::put('admin-modelos/{admin_modelo}',          [admin_ModeloController::class, 'update'])
        ->middleware('permission:configuraciones.modelos.edit')->name('admin-modelos.update');
    Route::delete('admin-modelos/{admin_modelo}',       [admin_ModeloController::class, 'destroy'])
        ->middleware('permission:configuraciones.modelos.delete')->name('admin-modelos.destroy');

    // Tipos
    Route::get('admin-tipos',                       [admin_TiposController::class, 'index'])
        ->middleware('permission:configuraciones.tipos.index')->name('admin-tipos.index');
    Route::get('admin-tipos/create',                [admin_TiposController::class, 'create'])
        ->middleware('permission:configuraciones.tipos.create')->name('admin-tipos.create');
    Route::post('admin-tipos',                      [admin_TiposController::class, 'store'])
        ->middleware('permission:configuraciones.tipos.create')->name('admin-tipos.store');
    Route::put('admin-tipos/estado/{admin_tipo}',   [admin_TiposController::class, 'estado'])
        ->middleware('permission:configuraciones.tipos.edit');
    Route::get('admin-tipos/{admin_tipo}',          [admin_TiposController::class, 'show'])
        ->middleware('permission:configuraciones.tipos.index')->name('admin-tipos.show');
    Route::get('admin-tipos/{admin_tipo}/edit',     [admin_TiposController::class, 'edit'])
        ->middleware('permission:configuraciones.tipos.edit')->name('admin-tipos.edit');
    Route::put('admin-tipos/{admin_tipo}',          [admin_TiposController::class, 'update'])
        ->middleware('permission:configuraciones.tipos.edit')->name('admin-tipos.update');
    Route::delete('admin-tipos/{admin_tipo}',       [admin_TiposController::class, 'destroy'])
        ->middleware('permission:configuraciones.tipos.delete')->name('admin-tipos.destroy');

    // Categorías
    Route::get('admin-categorias',                          [admin_CategoriasController::class, 'index'])
        ->middleware('permission:configuraciones.categorias.index')->name('admin-categorias.index');
    Route::get('admin-categorias/create',                   [admin_CategoriasController::class, 'create'])
        ->middleware('permission:configuraciones.categorias.create')->name('admin-categorias.create');
    Route::post('admin-categorias',                         [admin_CategoriasController::class, 'store'])
        ->middleware('permission:configuraciones.categorias.create')->name('admin-categorias.store');
    Route::put('admin-categorias/estado/{admin_categoria}', [admin_CategoriasController::class, 'estado'])
        ->middleware('permission:configuraciones.categorias.edit');
    Route::get('detalle_subcategorias',                     [admin_CategoriasController::class, 'getDetalleSubcategorias'])
        ->middleware('permission:configuraciones.categorias.index');
    Route::get('admin-categorias/{admin_categoria}',        [admin_CategoriasController::class, 'show'])
        ->middleware('permission:configuraciones.categorias.index')->name('admin-categorias.show');
    Route::get('admin-categorias/{admin_categoria}/edit',   [admin_CategoriasController::class, 'edit'])
        ->middleware('permission:configuraciones.categorias.edit')->name('admin-categorias.edit');
    Route::put('admin-categorias/{admin_categoria}',        [admin_CategoriasController::class, 'update'])
        ->middleware('permission:configuraciones.categorias.edit')->name('admin-categorias.update');
    Route::delete('admin-categorias/{admin_categoria}',     [admin_CategoriasController::class, 'destroy'])
        ->middleware('permission:configuraciones.categorias.delete')->name('admin-categorias.destroy');

    // Marcas
    Route::get('admin-marcas',                      [admin_MarcasController::class, 'index'])
        ->middleware('permission:configuraciones.marcas.index')->name('admin-marcas.index');
    Route::get('admin-marcas/create',               [admin_MarcasController::class, 'create'])
        ->middleware('permission:configuraciones.marcas.create')->name('admin-marcas.create');
    Route::post('admin-marcas',                     [admin_MarcasController::class, 'store'])
        ->middleware('permission:configuraciones.marcas.create')->name('admin-marcas.store');
    Route::put('admin-marcas/estado/{admin_marca}', [admin_MarcasController::class, 'estado'])
        ->middleware('permission:configuraciones.marcas.edit');
    Route::get('admin-marcas/{admin_marca}',        [admin_MarcasController::class, 'show'])
        ->middleware('permission:configuraciones.marcas.index')->name('admin-marcas.show');
    Route::get('admin-marcas/{admin_marca}/edit',   [admin_MarcasController::class, 'edit'])
        ->middleware('permission:configuraciones.marcas.edit')->name('admin-marcas.edit');
    Route::put('admin-marcas/{admin_marca}',        [admin_MarcasController::class, 'update'])
        ->middleware('permission:configuraciones.marcas.edit')->name('admin-marcas.update');
    Route::delete('admin-marcas/{admin_marca}',     [admin_MarcasController::class, 'destroy'])
        ->middleware('permission:configuraciones.marcas.delete')->name('admin-marcas.destroy');

    // Etiquetas
    Route::get('admin-etiquetas',                           [admin_EtiquetasController::class, 'index'])
        ->middleware('permission:configuraciones.etiquetas.index')->name('admin-etiquetas.index');
    Route::get('admin-etiquetas/create',                    [admin_EtiquetasController::class, 'create'])
        ->middleware('permission:configuraciones.etiquetas.create')->name('admin-etiquetas.create');
    Route::post('admin-etiquetas',                          [admin_EtiquetasController::class, 'store'])
        ->middleware('permission:configuraciones.etiquetas.create')->name('admin-etiquetas.store');
    Route::put('admin-etiquetas/estado/{admin_etiqueta}',   [admin_EtiquetasController::class, 'estado'])
        ->middleware('permission:configuraciones.etiquetas.edit');
    Route::get('admin-etiquetas/{admin_etiqueta}',          [admin_EtiquetasController::class, 'show'])
        ->middleware('permission:configuraciones.etiquetas.index')->name('admin-etiquetas.show');
    Route::get('admin-etiquetas/{admin_etiqueta}/edit',     [admin_EtiquetasController::class, 'edit'])
        ->middleware('permission:configuraciones.etiquetas.edit')->name('admin-etiquetas.edit');
    Route::put('admin-etiquetas/{admin_etiqueta}',          [admin_EtiquetasController::class, 'update'])
        ->middleware('permission:configuraciones.etiquetas.edit')->name('admin-etiquetas.update');
    Route::delete('admin-etiquetas/{admin_etiqueta}',       [admin_EtiquetasController::class, 'destroy'])
        ->middleware('permission:configuraciones.etiquetas.delete')->name('admin-etiquetas.destroy');

    // Proveedores
    Route::get('admin-proveedores',                             [admin_ProveedoresController::class, 'index'])
        ->middleware('permission:configuraciones.proveedores.index')->name('admin-proveedores.index');
    Route::get('admin-proveedores/create',                      [admin_ProveedoresController::class, 'create'])
        ->middleware('permission:configuraciones.proveedores.create')->name('admin-proveedores.create');
    Route::post('admin-proveedores',                            [admin_ProveedoresController::class, 'store'])
        ->middleware('permission:configuraciones.proveedores.create')->name('admin-proveedores.store');
    Route::put('admin-proveedores/estado/{admin_proveedor}',    [admin_ProveedoresController::class, 'estado'])
        ->middleware('permission:configuraciones.proveedores.edit');
    Route::get('busqueda_list_cuentas',                         [admin_ProveedoresController::class, 'getbusqueda_list_cuentas'])
        ->middleware('permission:configuraciones.proveedores.index');
    Route::get('admin-proveedores/{admin_proveedor}',           [admin_ProveedoresController::class, 'show'])
        ->middleware('permission:configuraciones.proveedores.index')->name('admin-proveedores.show');
    Route::get('admin-proveedores/{admin_proveedor}/edit',      [admin_ProveedoresController::class, 'edit'])
        ->middleware('permission:configuraciones.proveedores.edit')->name('admin-proveedores.edit');
    Route::put('admin-proveedores/{admin_proveedor}',           [admin_ProveedoresController::class, 'update'])
        ->middleware('permission:configuraciones.proveedores.edit')->name('admin-proveedores.update');
    Route::delete('admin-proveedores/{admin_proveedor}',        [admin_ProveedoresController::class, 'destroy'])
        ->middleware('permission:configuraciones.proveedores.delete')->name('admin-proveedores.destroy');

    // Productos
    Route::get('admin-productos',                           [admin_ProductosController::class, 'index'])
        ->middleware('permission:configuraciones.productos.index')->name('admin-productos.index');
    Route::get('admin-productos/create',                    [admin_ProductosController::class, 'create'])
        ->middleware('permission:configuraciones.productos.create')->name('admin-productos.create');
    Route::post('admin-productos',                          [admin_ProductosController::class, 'store'])
        ->middleware('permission:configuraciones.productos.create')->name('admin-productos.store');
    Route::put('admin-productos/estado/{admin_producto}',   [admin_ProductosController::class, 'estado'])
        ->middleware('permission:configuraciones.productos.edit');
    Route::get('busqueda_categoria_productos',              [admin_ProductosController::class, 'getBusqueda_categoria_productos'])
        ->middleware('permission:configuraciones.productos.create');
    Route::get('busqueda_proved',                           [admin_ProductosController::class, 'getBusquedaproved'])
        ->middleware('permission:configuraciones.productos.create');
    Route::get('busqueda_proved_edit',                      [admin_ProductosController::class, 'getbusqueda_proved_edit'])
        ->middleware('permission:configuraciones.productos.edit');
    Route::get('busqueda_codigo_producto',                  [admin_ProductosController::class, 'getbusqueda_codigo_producto'])
        ->middleware('permission:configuraciones.productos.create');
    Route::get('busqueda_subcategoria_productos',           [admin_ProductosController::class, 'getbusqueda_subcategoria_productos'])
        ->middleware('permission:configuraciones.productos.create');
    Route::get('admin-productos/{admin_producto}',          [admin_ProductosController::class, 'show'])
        ->middleware('permission:configuraciones.productos.index')->name('admin-productos.show');
    Route::get('admin-productos/{admin_producto}/edit',     [admin_ProductosController::class, 'edit'])
        ->middleware('permission:configuraciones.productos.edit')->name('admin-productos.edit');
    Route::put('admin-productos/{admin_producto}',          [admin_ProductosController::class, 'update'])
        ->middleware('permission:configuraciones.productos.edit')->name('admin-productos.update');
    Route::delete('admin-productos/{admin_producto}',       [admin_ProductosController::class, 'destroy'])
        ->middleware('permission:configuraciones.productos.delete')->name('admin-productos.destroy');

    // Kits
    Route::get('admin-kits',                        [admin_KitsController::class, 'index'])
        ->middleware('permission:configuraciones.kits.index')->name('admin-kits.index');
    Route::get('admin-kits/create',                 [admin_KitsController::class, 'create'])
        ->middleware('permission:configuraciones.kits.create')->name('admin-kits.create');
    Route::post('admin-kits',                       [admin_KitsController::class, 'store'])
        ->middleware('permission:configuraciones.kits.create')->name('admin-kits.store');
    Route::put('admin-kits/estado/{admin_kit}',     [admin_KitsController::class, 'estado'])
        ->middleware('permission:configuraciones.kits.edit');
    Route::get('dtlle_kits',                        [admin_KitsController::class, 'getdtlle_kits'])
        ->middleware('permission:configuraciones.kits.create');
    Route::get('images/{id}/delete',                [admin_KitsController::class, 'deleteImage'])
        ->middleware('permission:configuraciones.kits.edit');
    Route::get('admin-kits/{admin_kit}',            [admin_KitsController::class, 'show'])
        ->middleware('permission:configuraciones.kits.index')->name('admin-kits.show');
    Route::get('admin-kits/{admin_kit}/edit',       [admin_KitsController::class, 'edit'])
        ->middleware('permission:configuraciones.kits.edit')->name('admin-kits.edit');
    Route::put('admin-kits/{admin_kit}',            [admin_KitsController::class, 'update'])
        ->middleware('permission:configuraciones.kits.edit')->name('admin-kits.update');
    Route::delete('admin-kits/{admin_kit}',         [admin_KitsController::class, 'destroy'])
        ->middleware('permission:configuraciones.kits.delete')->name('admin-kits.destroy');

    // Descuentos
    Route::get('admin-descuentos',                          [admin_DescuentosController::class, 'index'])
        ->middleware('permission:configuraciones.descuentos.index')->name('admin-descuentos.index');
    Route::get('admin-descuentos/create',                   [admin_DescuentosController::class, 'create'])
        ->middleware('permission:configuraciones.descuentos.create')->name('admin-descuentos.create');
    Route::post('admin-descuentos',                         [admin_DescuentosController::class, 'store'])
        ->middleware('permission:configuraciones.descuentos.create')->name('admin-descuentos.store');
    Route::put('admin-descuentos/estado/{admin_descuento}', [admin_DescuentosController::class, 'estado'])
        ->middleware('permission:configuraciones.descuentos.edit');
    Route::get('descuentos_productos/filtro',               [admin_DescuentosController::class, 'getfiltro_producto'])
        ->middleware('permission:configuraciones.descuentos.create');
    Route::get('ver_descuento',                             [admin_DescuentosController::class, 'getver_descuento'])
        ->middleware('permission:configuraciones.descuentos.index');
    Route::get('admin-descuentos/{admin_descuento}',        [admin_DescuentosController::class, 'show'])
        ->middleware('permission:configuraciones.descuentos.index')->name('admin-descuentos.show');
    Route::get('admin-descuentos/{admin_descuento}/edit',   [admin_DescuentosController::class, 'edit'])
        ->middleware('permission:configuraciones.descuentos.edit')->name('admin-descuentos.edit');
    Route::put('admin-descuentos/{admin_descuento}',        [admin_DescuentosController::class, 'update'])
        ->middleware('permission:configuraciones.descuentos.edit')->name('admin-descuentos.update');
    Route::delete('admin-descuentos/{admin_descuento}',     [admin_DescuentosController::class, 'destroy'])
        ->middleware('permission:configuraciones.descuentos.delete')->name('admin-descuentos.destroy');

    // Cupones
    Route::get('admin-cupones',                     [admin_CuponesController::class, 'index'])
        ->middleware('permission:configuraciones.cupones.index')->name('admin-cupones.index');
    Route::get('admin-cupones/create',              [admin_CuponesController::class, 'create'])
        ->middleware('permission:configuraciones.cupones.create')->name('admin-cupones.create');
    Route::post('admin-cupones',                    [admin_CuponesController::class, 'store'])
        ->middleware('permission:configuraciones.cupones.create')->name('admin-cupones.store');
    Route::put('admin-cupones/estado/{admin_cupon}',[admin_CuponesController::class, 'estado'])
        ->middleware('permission:configuraciones.cupones.edit');
    Route::get('search_codigo/cupons',              [admin_CuponesController::class, 'getsearch_codigo'])
        ->middleware('permission:configuraciones.cupones.create');
    Route::get('ver_cuponera',                      [admin_CuponesController::class, 'getver_cuponera'])
        ->middleware('permission:configuraciones.cupones.index');
    Route::get('admin-cupones/{admin_cupon}',       [admin_CuponesController::class, 'show'])
        ->middleware('permission:configuraciones.cupones.index')->name('admin-cupones.show');
    Route::get('admin-cupones/{admin_cupon}/edit',  [admin_CuponesController::class, 'edit'])
        ->middleware('permission:configuraciones.cupones.edit')->name('admin-cupones.edit');
    Route::put('admin-cupones/{admin_cupon}',       [admin_CuponesController::class, 'update'])
        ->middleware('permission:configuraciones.cupones.edit')->name('admin-cupones.update');
    Route::delete('admin-cupones/{admin_cupon}',    [admin_CuponesController::class, 'destroy'])
        ->middleware('permission:configuraciones.cupones.delete')->name('admin-cupones.destroy');

    // Coberturas
    Route::get('admin-coberturas',                          [admin_CoberturasController::class, 'index'])
        ->middleware('permission:configuraciones.coberturas.index')->name('admin-coberturas.index');
    Route::get('admin-coberturas/create',                   [admin_CoberturasController::class, 'create'])
        ->middleware('permission:configuraciones.coberturas.create')->name('admin-coberturas.create');
    Route::post('admin-coberturas',                         [admin_CoberturasController::class, 'store'])
        ->middleware('permission:configuraciones.coberturas.create')->name('admin-coberturas.store');
    Route::put('admin-coberturas/estado/{admin_cobertura}', [admin_CoberturasController::class, 'estado'])
        ->middleware('permission:configuraciones.coberturas.edit');
    Route::get('admin-coberturas/{admin_cobertura}',        [admin_CoberturasController::class, 'show'])
        ->middleware('permission:configuraciones.coberturas.index')->name('admin-coberturas.show');
    Route::get('admin-coberturas/{admin_cobertura}/edit',   [admin_CoberturasController::class, 'edit'])
        ->middleware('permission:configuraciones.coberturas.edit')->name('admin-coberturas.edit');
    Route::put('admin-coberturas/{admin_cobertura}',        [admin_CoberturasController::class, 'update'])
        ->middleware('permission:configuraciones.coberturas.edit')->name('admin-coberturas.update');
    Route::delete('admin-coberturas/{admin_cobertura}',     [admin_CoberturasController::class, 'destroy'])
        ->middleware('permission:configuraciones.coberturas.delete')->name('admin-coberturas.destroy');

    // Servicios (catálogo)
    Route::get('admin-servicios',                           [admin_ServiciosController::class, 'index'])
        ->middleware('permission:configuraciones.servicios.index')->name('admin-servicios.index');
    Route::get('admin-servicios/create',                    [admin_ServiciosController::class, 'create'])
        ->middleware('permission:configuraciones.servicios.create')->name('admin-servicios.create');
    Route::post('admin-servicios',                          [admin_ServiciosController::class, 'store'])
        ->middleware('permission:configuraciones.servicios.create')->name('admin-servicios.store');
    Route::put('admin-servicios/estado/{admin_servicio}',   [admin_ServiciosController::class, 'estado'])
        ->middleware('permission:configuraciones.servicios.edit');
    Route::get('admin-servicios/{admin_servicio}',          [admin_ServiciosController::class, 'show'])
        ->middleware('permission:configuraciones.servicios.index')->name('admin-servicios.show');
    Route::get('admin-servicios/{admin_servicio}/edit',     [admin_ServiciosController::class, 'edit'])
        ->middleware('permission:configuraciones.servicios.edit')->name('admin-servicios.edit');
    Route::put('admin-servicios/{admin_servicio}',          [admin_ServiciosController::class, 'update'])
        ->middleware('permission:configuraciones.servicios.edit')->name('admin-servicios.update');
    Route::delete('admin-servicios/{admin_servicio}',       [admin_ServiciosController::class, 'destroy'])
        ->middleware('permission:configuraciones.servicios.delete')->name('admin-servicios.destroy');

    // ---------------------------------------------------------
    // COMPRAS — ÓRDENES DE SERVICIO Y ÓRDENES DE COMPRA
    // ---------------------------------------------------------

    // Órdenes de Servicio
    Route::get('admin-ordenservicios',                          [admin_OrdenesserviciosController::class, 'index'])
        ->middleware('permission:compras.ordenservicios.index')->name('admin-ordenservicios.index');
    Route::get('admin-ordenservicios/create',                   [admin_OrdenesserviciosController::class, 'create'])
        ->middleware('permission:compras.ordenservicios.create')->name('admin-ordenservicios.create');
    Route::post('admin-ordenservicios',                         [admin_OrdenesserviciosController::class, 'store'])
        ->middleware('permission:compras.ordenservicios.create')->name('admin-ordenservicios.store');
    Route::get('busqueda_tipos',                                [admin_OrdenesserviciosController::class, 'getver_tipos'])
        ->middleware('permission:compras.ordenservicios.create');
    Route::get('fecha_vigencia',                                [admin_OrdenesserviciosController::class, 'getver_fecha_vigencia'])
        ->middleware('permission:compras.ordenservicios.create');
    Route::get('dt_servicio',                                   [admin_OrdenesserviciosController::class, 'getver_dt_servicio'])
        ->middleware('permission:compras.ordenservicios.create');
    Route::get('admin-ordenservicios/{admin_ordenservicio}',    [admin_OrdenesserviciosController::class, 'show'])
        ->middleware('permission:compras.ordenservicios.index')->name('admin-ordenservicios.show');
    Route::get('admin-ordenservicios/{admin_ordenservicio}/edit',[admin_OrdenesserviciosController::class, 'edit'])
        ->middleware('permission:compras.ordenservicios.edit')->name('admin-ordenservicios.edit');
    Route::put('admin-ordenservicios/{admin_ordenservicio}',    [admin_OrdenesserviciosController::class, 'update'])
        ->middleware('permission:compras.ordenservicios.edit')->name('admin-ordenservicios.update');
    Route::delete('admin-ordenservicios/{admin_ordenservicio}', [admin_OrdenesserviciosController::class, 'destroy'])
        ->middleware('permission:compras.ordenservicios.delete')->name('admin-ordenservicios.destroy');

    // Órdenes de Compra
    Route::get('admin-ordencompras',                        [admin_OrdenescomprasController::class, 'index'])
        ->middleware('permission:compras.ordencompras.index')->name('admin-ordencompras.index');
    Route::get('admin-ordencompras/create',                 [admin_OrdenescomprasController::class, 'create'])
        ->middleware('permission:compras.ordencompras.create')->name('admin-ordencompras.create');
    Route::post('admin-ordencompras',                       [admin_OrdenescomprasController::class, 'store'])
        ->middleware('permission:compras.ordencompras.create')->name('admin-ordencompras.store');
    Route::get('busqueda_biene_compra',                     [admin_OrdenescomprasController::class, 'getBusqueda_compra_biene'])
        ->middleware('permission:compras.ordencompras.create');
    Route::get('busqueda_detalle_compra',                   [admin_OrdenescomprasController::class, 'getBusqueda_detalle_compra'])
        ->middleware('permission:compras.ordencompras.create');
    Route::get('fecha_cuotas',                              [admin_OrdenescomprasController::class, 'getFechacuota'])
        ->middleware('permission:compras.ordencompras.create');
    Route::get('admin-ordencompras/{admin_ordencompra}',    [admin_OrdenescomprasController::class, 'show'])
        ->middleware('permission:compras.ordencompras.index')->name('admin-ordencompras.show');
    Route::get('admin-ordencompras/{admin_ordencompra}/edit',[admin_OrdenescomprasController::class, 'edit'])
        ->middleware('permission:compras.ordencompras.edit')->name('admin-ordencompras.edit');
    Route::put('admin-ordencompras/{admin_ordencompra}',    [admin_OrdenescomprasController::class, 'update'])
        ->middleware('permission:compras.ordencompras.edit')->name('admin-ordencompras.update');
    Route::delete('admin-ordencompras/{admin_ordencompra}', [admin_OrdenescomprasController::class, 'destroy'])
        ->middleware('permission:compras.ordencompras.delete')->name('admin-ordencompras.destroy');

    // ---------------------------------------------------------
    // ALMACÉN — INGRESOS, SALIDAS, INVENTARIO
    // ---------------------------------------------------------

    // Ingresos
    Route::get('admin-ingresos',                                        [admin_IngresosController::class, 'index'])
        ->middleware('permission:almacen.ingresos.index')->name('admin-ingresos.index');
    Route::get('admin-ingresos/create',                                 [admin_IngresosController::class, 'create'])
        ->middleware('permission:almacen.ingresos.create')->name('admin-ingresos.create');
    Route::post('admin-ingresos',                                       [admin_IngresosController::class, 'store'])
        ->middleware('permission:almacen.ingresos.create')->name('admin-ingresos.store');
    Route::post('admin-ingresos_general',                               [admin_IngresosController::class, 'ingreso_general'])
        ->middleware('permission:almacen.ingresos.index')->name('ingreso_general.index');
    Route::get('busqueda_dtll_oc',                                      [admin_IngresosController::class, 'getbusqueda_det_oc'])
        ->middleware('permission:almacen.ingresos.create');
    Route::get('busqueda_pterminado',                                   [admin_IngresosController::class, 'getbusqueda_pterminado'])
        ->middleware('permission:almacen.ingresos.create');
    Route::get('admin-ingresos/detalle-ingreso-pdf/{admin_ingreso}',    [admin_IngresosController::class, 'getIngresopdf'])
        ->middleware('permission:almacen.ingresos.index')->name('detalle_ingreso.pdf');
    Route::post('admin-ingresos/resultadosPDF',                         [admin_IngresosController::class, 'reporteIngresosPrintPdfSede'])
        ->middleware('permission:almacen.ingresos.index')->name('admin-ingresos.resultadosPDF');
    Route::get('admin-ingresos/{admin_ingreso}',                        [admin_IngresosController::class, 'show'])
        ->middleware('permission:almacen.ingresos.index')->name('admin-ingresos.show');
    Route::get('admin-ingresos/{admin_ingreso}/edit',                   [admin_IngresosController::class, 'edit'])
        ->middleware('permission:almacen.ingresos.edit')->name('admin-ingresos.edit');
    Route::put('admin-ingresos/{admin_ingreso}',                        [admin_IngresosController::class, 'update'])
        ->middleware('permission:almacen.ingresos.edit')->name('admin-ingresos.update');
    Route::delete('admin-ingresos/{admin_ingreso}',                     [admin_IngresosController::class, 'destroy'])
        ->middleware('permission:almacen.ingresos.delete')->name('admin-ingresos.destroy');

    // Salidas
    Route::get('admin-salidas',                                         [admin_SalidasController::class, 'index'])
        ->middleware('permission:almacen.salidas.index')->name('admin-salidas.index');
    Route::get('admin-salidas/create',                                  [admin_SalidasController::class, 'create'])
        ->middleware('permission:almacen.salidas.create')->name('admin-salidas.create');
    Route::post('admin-salidas',                                        [admin_SalidasController::class, 'store'])
        ->middleware('permission:almacen.salidas.create')->name('admin-salidas.store');
    Route::post('admin-salidas_general',                                [admin_SalidasController::class, 'salida_general'])
        ->middleware('permission:almacen.salidas.index')->name('salida_general.index');
    Route::get('busqueda_producto_inventario',                          [admin_SalidasController::class, 'getbusqueda_producto_inventario'])
        ->middleware('permission:almacen.salidas.create');
    Route::get('busqueda_inventarios',                                  [admin_SalidasController::class, 'getbusqueda_inventarios'])
        ->middleware('permission:almacen.salidas.create');
    Route::get('admin-salidas/detalle-salida-pdf/{admin_salida}',       [admin_SalidasController::class, 'getSalidapdf'])
        ->middleware('permission:almacen.salidas.index')->name('detalle_salida.pdf');
    Route::post('admin-salidas/resultadosPDF',                          [admin_SalidasController::class, 'reporteSalidasPrintPdfSede'])
        ->middleware('permission:almacen.salidas.index')->name('admin-salidas.resultadosPDF');
    Route::get('admin-salidas/{admin_salida}',                          [admin_SalidasController::class, 'show'])
        ->middleware('permission:almacen.salidas.index')->name('admin-salidas.show');
    Route::get('admin-salidas/{admin_salida}/edit',                     [admin_SalidasController::class, 'edit'])
        ->middleware('permission:almacen.salidas.edit')->name('admin-salidas.edit');
    Route::put('admin-salidas/{admin_salida}',                          [admin_SalidasController::class, 'update'])
        ->middleware('permission:almacen.salidas.edit')->name('admin-salidas.update');
    Route::delete('admin-salidas/{admin_salida}',                       [admin_SalidasController::class, 'destroy'])
        ->middleware('permission:almacen.salidas.delete')->name('admin-salidas.destroy');

    // Inventarios
    Route::get('admin-inventarios',                             [admin_InventarioController::class, 'index'])
        ->middleware('permission:almacen.inventario.index')->name('admin-inventarios.index');
    Route::post('admin-inventarios/resultadosPDF',              [admin_InventarioController::class, 'reporteInventariosPrintPdfSede'])
        ->middleware('permission:almacen.inventario.index')->name('admin-inventarios.resultadosPDF');
    Route::post('admin-inventarios-totales/resultadosPDF',      [admin_InventarioController::class, 'getbusqueda_inventarios_general'])
        ->middleware('permission:almacen.inventario.index')->name('admin-inventarios-totales.resultadosPDF');
    Route::get('admin-inventarios/create',                      [admin_InventarioController::class, 'create'])
        ->middleware('permission:almacen.inventario.edit')->name('admin-inventarios.create');
    Route::post('admin-inventarios',                            [admin_InventarioController::class, 'store'])
        ->middleware('permission:almacen.inventario.edit')->name('admin-inventarios.store');
    Route::get('admin-inventarios/{admin_inventario}',          [admin_InventarioController::class, 'show'])
        ->middleware('permission:almacen.inventario.index')->name('admin-inventarios.show');
    Route::get('admin-inventarios/{admin_inventario}/edit',     [admin_InventarioController::class, 'edit'])
        ->middleware('permission:almacen.inventario.edit')->name('admin-inventarios.edit');
    Route::put('admin-inventarios/{admin_inventario}',          [admin_InventarioController::class, 'update'])
        ->middleware('permission:almacen.inventario.edit')->name('admin-inventarios.update');
    Route::delete('admin-inventarios/{admin_inventario}',       [admin_InventarioController::class, 'destroy'])
        ->middleware('permission:almacen.inventario.edit')->name('admin-inventarios.destroy');

    // ---------------------------------------------------------
    // FINANZAS — CUENTAS BANCARIAS
    // ---------------------------------------------------------
    Route::get('admin-cuentasbancarias',         [admin_CuentabancoController::class, 'index'])
        ->middleware('permission:finanzas.cuentasbancarias.index')->name('admin-cuentasbancarias.index');
    Route::get('admin-cuentasbancarias/create',  [admin_CuentabancoController::class, 'create'])
        ->middleware('permission:finanzas.cuentasbancarias.create')->name('admin-cuentasbancarias.create');
    Route::post('admin-cuentasbancarias',        [admin_CuentabancoController::class, 'store'])
        ->middleware('permission:finanzas.cuentasbancarias.create')->name('admin-cuentasbancarias.store');

    // ---------------------------------------------------------
    // UBIGEO — AJAX (utility, cualquier autenticado)
    // ---------------------------------------------------------
    Route::get('/ajax/provincias', [admin_UbigeoController::class, 'provincias'])->name('ajax.provincias');
    Route::get('/ajax/distritos',  [admin_UbigeoController::class, 'distritos'])->name('ajax.distritos');

    // ---------------------------------------------------------
    // VENTAS — CLIENTES (crear desde modal de pedido)
    // ---------------------------------------------------------
    Route::post('admin-clientes',               [admin_CrmClientesController::class, 'store'])
        ->middleware('permission:crm.clientes.create')->name('admin-clientes.store');
    Route::get('admin-clientes/{cliente}/datos',[admin_CrmClientesController::class, 'getDatos'])
        ->middleware('permission:crm.clientes.index')->name('admin-clientes.datos');
    Route::resource('admin-crm-reseñas', admin_CrmReseñasController::class);
    Route::put('admin-crm-reseñas/{admin_crm_reseña}/estado', [admin_CrmReseñasController::class, 'estados'])
        ->name('admin-crm-reseñas.estado');

    // ---------------------------------------------------------
    // VENTAS — PEDIDOS
    // ---------------------------------------------------------
    Route::get('admin-pedidos',                                         [admin_PedidosController::class, 'index'])
        ->middleware('permission:ventas.pedidos.index')->name('admin-pedidos.index');
    Route::get('admin-pedidos/create',                                  [admin_PedidosController::class, 'create'])
        ->middleware('permission:ventas.pedidos.create')->name('admin-pedidos.create');
    Route::post('admin-pedidos',                                        [admin_PedidosController::class, 'store'])
        ->middleware('permission:ventas.pedidos.create')->name('admin-pedidos.store');
    Route::put('admin-pedidos/estado/{admin_pedido}',                   [admin_PedidosController::class, 'estado'])
        ->middleware('permission:ventas.pedidos.edit')->name('admin-pedidos.estado');
    Route::post('admin-pedidos/aprobar-finanzas/{admin_pedido}',        [admin_PedidosController::class, 'aprobarFinanzas'])
        ->middleware('permission:ventas.pedidos.aprobar-finanzas')->name('admin-pedidos.aprobar-finanzas');
    Route::post('admin-pedidos/aprobar-stock/{admin_pedido}',           [admin_PedidosController::class, 'aprobarStock'])
        ->middleware('permission:ventas.pedidos.aprobar-stock')->name('admin-pedidos.aprobar-stock');
    Route::post('admin-pedidos/generar-comprobante/{admin_pedido}',     [admin_PedidosController::class, 'generarComprobante'])
        ->middleware('permission:ventas.pedidos.generar-comprobante')->name('admin-pedidos.generar-comprobante');
    Route::get('admin-pedidos/{pedido}/voucher',                        [admin_PedidosController::class, 'voucher'])
        ->middleware('permission:ventas.pedidos.index')->name('admin-pedidos.voucher');
    Route::get('admin-pedidos/{admin_pedido}',                          [admin_PedidosController::class, 'show'])
        ->middleware('permission:ventas.pedidos.index')->name('admin-pedidos.show');
    Route::get('admin-pedidos/{admin_pedido}/edit',                     [admin_PedidosController::class, 'edit'])
        ->middleware('permission:ventas.pedidos.edit')->name('admin-pedidos.edit');
    Route::put('admin-pedidos/{admin_pedido}',                          [admin_PedidosController::class, 'update'])
        ->middleware('permission:ventas.pedidos.edit')->name('admin-pedidos.update');
    Route::delete('admin-pedidos/{admin_pedido}',                       [admin_PedidosController::class, 'destroy'])
        ->middleware('permission:ventas.pedidos.delete')->name('admin-pedidos.destroy');

    // ---------------------------------------------------------
    // VENTAS — VENTAS
    // ---------------------------------------------------------
    Route::get('admin-ventas',                                  [admin_VentasController::class, 'index'])
        ->middleware('permission:ventas.ventas.index')->name('admin-ventas.index');
    Route::get('admin-ventas/create',                           [admin_VentasController::class, 'create'])
        ->middleware('permission:ventas.ventas.create')->name('admin-ventas.create');
    Route::post('admin-ventas',                                 [admin_VentasController::class, 'store'])
        ->middleware('permission:ventas.ventas.create')->name('admin-ventas.store');
    Route::put('admin-ventas/estado/{admin_venta}',             [admin_VentasController::class, 'estado'])
        ->middleware('permission:ventas.ventas.edit');
    Route::post('admin-ventas/{admin_venta}/enviar-email',      [admin_VentasController::class, 'enviarEmail'])
        ->middleware('permission:ventas.ventas.enviar-email')->name('admin-ventas.enviar-email');
    Route::get('admin-ventas/{admin_venta}/voucher',            [admin_VentasController::class, 'voucher'])
        ->middleware('permission:ventas.ventas.index')->name('admin-ventas.voucher');
    Route::get('admin-ventas/{admin_venta}',                    [admin_VentasController::class, 'show'])
        ->middleware('permission:ventas.ventas.index')->name('admin-ventas.show');
    Route::get('admin-ventas/{admin_venta}/edit',               [admin_VentasController::class, 'edit'])
        ->middleware('permission:ventas.ventas.edit')->name('admin-ventas.edit');
    Route::put('admin-ventas/{admin_venta}',                    [admin_VentasController::class, 'update'])
        ->middleware('permission:ventas.ventas.edit')->name('admin-ventas.update');
    Route::delete('admin-ventas/{admin_venta}',                 [admin_VentasController::class, 'destroy'])
        ->middleware('permission:ventas.ventas.delete')->name('admin-ventas.destroy');

    // ---------------------------------------------------------
    // FINANZAS — COBROS
    // ---------------------------------------------------------
    Route::get('admin-cobros',                  [admin_CobrosController::class, 'index'])
        ->middleware('permission:finanzas.cobros.index')->name('admin-cobros.index');
    Route::get('admin-cobros/{admin_cobro}',    [admin_CobrosController::class, 'show'])
        ->middleware('permission:finanzas.cobros.index')->name('admin-cobros.show');
    Route::post('admin-cobros/{admin_cobro}',   [admin_CobrosController::class, 'store'])
        ->middleware('permission:finanzas.cobros.registrar')->name('admin-cobros.store');

    // ---------------------------------------------------------
    // FINANZAS — PAGOS (Egresos - Órdenes de Compra)
    // ---------------------------------------------------------
    Route::get('admin-pagos',               [admin_PagosController::class, 'index'])
        ->middleware('permission:finanzas.pagos.index')->name('admin-pagos.index');
    Route::get('admin-pagos/{admin_pago}',  [admin_PagosController::class, 'show'])
        ->middleware('permission:finanzas.pagos.index')->name('admin-pagos.show');
    Route::post('admin-pagos/{admin_pago}', [admin_PagosController::class, 'store'])
        ->middleware('permission:finanzas.pagos.registrar')->name('admin-pagos.store');

    // ---------------------------------------------------------
    // FINANZAS — CAJA CHICA
    // ---------------------------------------------------------
    Route::get('admin-caja-chica',                                  [admin_CajaChicaController::class, 'index'])
        ->middleware('permission:finanzas.caja-chica.index')->name('admin-caja-chica.index');
    Route::get('admin-caja-chica/crear',                            [admin_CajaChicaController::class, 'create'])
        ->middleware('permission:finanzas.caja-chica.create')->name('admin-caja-chica.create');
    Route::post('admin-caja-chica',                                 [admin_CajaChicaController::class, 'store'])
        ->middleware('permission:finanzas.caja-chica.create')->name('admin-caja-chica.store');
    Route::put('admin-caja-chica/{admin_caja_chica}/cerrar',        [admin_CajaChicaController::class, 'cerrar'])
        ->middleware('permission:finanzas.caja-chica.cerrar')->name('admin-caja-chica.cerrar');
    Route::get('admin-caja-chica/{admin_caja_chica}',               [admin_CajaChicaController::class, 'show'])
        ->middleware('permission:finanzas.caja-chica.index')->name('admin-caja-chica.show');

    // ---------------------------------------------------------
    // FINANZAS — COMPROBANTES ELECTRÓNICOS
    // ---------------------------------------------------------
    Route::get('admin-comprobantes-finanzas',                       [admin_ComprobantesFinanzasController::class, 'index'])
        ->middleware('permission:finanzas.comprobantes.index')->name('admin-comprobantes-finanzas.index');
    Route::get('admin-comprobantes-finanzas/{admin_comprobante}',   [admin_ComprobantesFinanzasController::class, 'show'])
        ->middleware('permission:finanzas.comprobantes.index')->name('admin-comprobantes-finanzas.show');

    // ---------------------------------------------------------
    // FINANZAS — NOTAS DE CRÉDITO/DÉBITO
    // ---------------------------------------------------------
    Route::get('admin-nota-ventas',                                 [admin_NotaVentasController::class, 'index'])
        ->middleware('permission:finanzas.notas-ventas.index')->name('admin-nota-ventas.index');
    Route::get('admin-nota-ventas/crear',                           [admin_NotaVentasController::class, 'create'])
        ->middleware('permission:finanzas.notas-ventas.create')->name('admin-nota-ventas.create');
    Route::post('admin-nota-ventas',                                [admin_NotaVentasController::class, 'store'])
        ->middleware('permission:finanzas.notas-ventas.create')->name('admin-nota-ventas.store');
    Route::put('admin-nota-ventas/{admin_nota_venta}/anular',       [admin_NotaVentasController::class, 'anular'])
        ->middleware('permission:finanzas.notas-ventas.anular')->name('admin-nota-ventas.anular');
    Route::get('admin-nota-ventas/{admin_nota_venta}',              [admin_NotaVentasController::class, 'show'])
        ->middleware('permission:finanzas.notas-ventas.index')->name('admin-nota-ventas.show');

    // ---------------------------------------------------------
    // CRM
    // ---------------------------------------------------------
    Route::prefix('admin/crm')->name('admin.crm.')->group(function () {

        // Prospectos
        Route::get('prospectos',                            [admin_CrmProspectosController::class, 'index'])
            ->middleware('permission:crm.prospectos.index')->name('prospectos.index');
        Route::get('prospectos/create',                     [admin_CrmProspectosController::class, 'create'])
            ->middleware('permission:crm.prospectos.create')->name('prospectos.create');
        Route::post('prospectos',                           [admin_CrmProspectosController::class, 'store'])
            ->middleware('permission:crm.prospectos.create')->name('prospectos.store');
        Route::post('prospectos/{prospecto}/actividad',     [admin_CrmProspectosController::class, 'registrarActividad'])
            ->middleware('permission:crm.actividades.create')->name('prospectos.actividad');
        Route::patch('prospectos/{prospecto}/estado',       [admin_CrmProspectosController::class, 'actualizarEstado'])
            ->middleware('permission:crm.prospectos.edit')->name('prospectos.actualizar-estado');
        Route::get('prospectos/{prospecto}/wishlist',       [admin_CrmOportunidadesController::class, 'getWishlist'])
            ->middleware('permission:crm.prospectos.index')->name('prospectos.wishlist');
        Route::get('prospectos/{prospecto}',                [admin_CrmProspectosController::class, 'show'])
            ->middleware('permission:crm.prospectos.index')->name('prospectos.show');
        Route::get('prospectos/{prospecto}/edit',           [admin_CrmProspectosController::class, 'edit'])
            ->middleware('permission:crm.prospectos.edit')->name('prospectos.edit');
        Route::put('prospectos/{prospecto}',                [admin_CrmProspectosController::class, 'update'])
            ->middleware('permission:crm.prospectos.edit')->name('prospectos.update');
        Route::delete('prospectos/{prospecto}',             [admin_CrmProspectosController::class, 'destroy'])
            ->middleware('permission:crm.prospectos.delete')->name('prospectos.destroy');

        // Oportunidades
        Route::get('oportunidades',                                 [admin_CrmOportunidadesController::class, 'index'])
            ->middleware('permission:crm.oportunidades.index')->name('oportunidades.index');
        Route::get('oportunidades/create',                          [admin_CrmOportunidadesController::class, 'create'])
            ->middleware('permission:crm.oportunidades.create')->name('oportunidades.create');
        Route::post('oportunidades',                                [admin_CrmOportunidadesController::class, 'store'])
            ->middleware('permission:crm.oportunidades.create')->name('oportunidades.store');
        Route::post('oportunidades/{oportunidad}/avanzar',          [admin_CrmOportunidadesController::class, 'avanzarEtapa'])
            ->middleware('permission:crm.oportunidades.edit')->name('oportunidades.avanzar');
        Route::post('oportunidades/{oportunidad}/crear-cotizacion', [admin_CrmOportunidadesController::class, 'crearCotizacion'])
            ->middleware('permission:crm.cotizaciones.create')->name('oportunidades.crear-cotizacion');
        Route::post('oportunidades/{oportunidad}/perdida',          [admin_CrmOportunidadesController::class, 'marcarPerdida'])
            ->middleware('permission:crm.oportunidades.edit')->name('oportunidades.perdida');
        Route::post('oportunidades/{oportunidad}/actividad',        [admin_CrmOportunidadesController::class, 'registrarActividad'])
            ->middleware('permission:crm.actividades.create')->name('oportunidades.actividad');
        Route::get('oportunidades/{oportunidad}',                   [admin_CrmOportunidadesController::class, 'show'])
            ->middleware('permission:crm.oportunidades.index')->name('oportunidades.show');
        Route::get('oportunidades/{oportunidad}/edit',              [admin_CrmOportunidadesController::class, 'edit'])
            ->middleware('permission:crm.oportunidades.edit')->name('oportunidades.edit');
        Route::put('oportunidades/{oportunidad}',                   [admin_CrmOportunidadesController::class, 'update'])
            ->middleware('permission:crm.oportunidades.edit')->name('oportunidades.update');
        Route::delete('oportunidades/{oportunidad}',                [admin_CrmOportunidadesController::class, 'destroy'])
            ->middleware('permission:crm.oportunidades.delete')->name('oportunidades.destroy');

        // Cotizaciones
        Route::get('cotizaciones',                                  [admin_CrmCotizacionesController::class, 'index'])
            ->middleware('permission:crm.cotizaciones.index')->name('cotizaciones.index');
        Route::get('cotizaciones/create',                           [admin_CrmCotizacionesController::class, 'create'])
            ->middleware('permission:crm.cotizaciones.create')->name('cotizaciones.create');
        Route::post('cotizaciones',                                 [admin_CrmCotizacionesController::class, 'store'])
            ->middleware('permission:crm.cotizaciones.create')->name('cotizaciones.store');
        Route::post('cotizaciones/{cotizacion}/enviar',             [admin_CrmCotizacionesController::class, 'enviar'])
            ->middleware('permission:crm.cotizaciones.edit')->name('cotizaciones.enviar');
        Route::post('cotizaciones/{cotizacion}/aprobar',            [admin_CrmCotizacionesController::class, 'aprobar'])
            ->middleware('permission:crm.cotizaciones.aprobar')->name('cotizaciones.aprobar');
        Route::post('cotizaciones/{cotizacion}/rechazar',           [admin_CrmCotizacionesController::class, 'rechazar'])
            ->middleware('permission:crm.cotizaciones.aprobar')->name('cotizaciones.rechazar');
        Route::post('cotizaciones/{cotizacion}/duplicar',           [admin_CrmCotizacionesController::class, 'duplicar'])
            ->middleware('permission:crm.cotizaciones.create')->name('cotizaciones.duplicar');
        Route::get('cotizaciones/{cotizacion}/pdf',                 [admin_CrmCotizacionesController::class, 'generarPdf'])
            ->middleware('permission:crm.cotizaciones.index')->name('cotizaciones.pdf');
        Route::get('cotizaciones/{cotizacion}/preview',             [admin_CrmCotizacionesController::class, 'previsualizarPdf'])
            ->middleware('permission:crm.cotizaciones.index')->name('cotizaciones.preview');
        Route::post('cotizaciones/{cotizacion}/recalcular',         [admin_CrmCotizacionesController::class, 'recalcular'])
            ->middleware('permission:crm.cotizaciones.edit')->name('cotizaciones.recalcular');
        Route::post('cotizaciones/{cotizacion}/items-guardar',      [admin_CrmCotizacionesController::class, 'guardarItems'])
            ->middleware('permission:crm.cotizaciones.edit')->name('cotizaciones.guardarItems');
        Route::get('cotizaciones/{cotizacion}',                     [admin_CrmCotizacionesController::class, 'show'])
            ->middleware('permission:crm.cotizaciones.index')->name('cotizaciones.show');
        Route::get('cotizaciones/{cotizacion}/edit',                [admin_CrmCotizacionesController::class, 'edit'])
            ->middleware('permission:crm.cotizaciones.edit')->name('cotizaciones.edit');
        Route::put('cotizaciones/{cotizacion}',                     [admin_CrmCotizacionesController::class, 'update'])
            ->middleware('permission:crm.cotizaciones.edit')->name('cotizaciones.update');
        Route::delete('cotizaciones/{cotizacion}',                  [admin_CrmCotizacionesController::class, 'destroy'])
            ->middleware('permission:crm.cotizaciones.delete')->name('cotizaciones.destroy');

        // Actividades
        Route::get('actividades',                                   [admin_CrmActividadesController::class, 'index'])
            ->middleware('permission:crm.actividades.index')->name('actividades.index');
        Route::get('actividades/create',                            [admin_CrmActividadesController::class, 'create'])
            ->middleware('permission:crm.actividades.create')->name('actividades.create');
        Route::post('actividades',                                  [admin_CrmActividadesController::class, 'store'])
            ->middleware('permission:crm.actividades.create')->name('actividades.store');
        Route::post('actividades/{actividad}/completar',            [admin_CrmActividadesController::class, 'completar'])
            ->middleware('permission:crm.actividades.edit')->name('actividades.completar');
        Route::post('actividades/{actividad}/cancelar',             [admin_CrmActividadesController::class, 'cancelar'])
            ->middleware('permission:crm.actividades.edit')->name('actividades.cancelar');
        Route::post('actividades/{actividad}/reprogramar',          [admin_CrmActividadesController::class, 'reprogramar'])
            ->middleware('permission:crm.actividades.edit')->name('actividades.reprogramar');
        Route::post('actividades/{actividad}/iniciar-evaluacion',   [admin_CrmActividadesController::class, 'iniciarEvaluacion'])
            ->middleware('permission:crm.actividades.edit')->name('actividades.iniciar-evaluacion');
        Route::post('actividades/{actividad}/no-realizada',         [admin_CrmActividadesController::class, 'noRealizada'])
            ->middleware('permission:crm.actividades.edit')->name('actividades.no-realizada');
        Route::post('actividades/{actividad}/seguimiento',          [admin_CrmActividadesController::class, 'crearSeguimiento'])
            ->middleware('permission:crm.actividades.create')->name('actividades.seguimiento');
        Route::get('actividades-eventos',                           [admin_CrmActividadesController::class, 'eventosCalendario'])
            ->middleware('permission:crm.actividades.index')->name('actividades.eventos');
        Route::patch('actividades/{actividad}/fecha',               [admin_CrmActividadesController::class, 'actualizarFecha'])
            ->middleware('permission:crm.actividades.edit')->name('actividades.actualizar-fecha');
        Route::get('actividades-pendientes',                        [admin_CrmActividadesController::class, 'misPendientes'])
            ->middleware('permission:crm.actividades.index')->name('actividades.pendientes');
        Route::get('actividades-notificaciones',                    [admin_CrmActividadesController::class, 'notificacionesCampana'])
            ->middleware('permission:crm.actividades.index')->name('actividades.notificaciones');
        Route::post('actividades-notificaciones/descartar',         [admin_CrmActividadesController::class, 'descartarNotificacion'])
            ->middleware('permission:crm.actividades.index')->name('actividades.notificaciones.descartar');
        Route::get('actividades/{actividad}',                       [admin_CrmActividadesController::class, 'show'])
            ->middleware('permission:crm.actividades.index')->name('actividades.show');
        Route::get('actividades/{actividad}/edit',                  [admin_CrmActividadesController::class, 'edit'])
            ->middleware('permission:crm.actividades.edit')->name('actividades.edit');
        Route::put('actividades/{actividad}',                       [admin_CrmActividadesController::class, 'update'])
            ->middleware('permission:crm.actividades.edit')->name('actividades.update');
        Route::delete('actividades/{actividad}',                    [admin_CrmActividadesController::class, 'destroy'])
            ->middleware('permission:crm.actividades.delete')->name('actividades.destroy');

        // Clientes (sin create/store - los clientes se crean desde prospecto o ecommerce)
        Route::get('clientes',                              [admin_CrmClientesController::class, 'index'])
            ->middleware('permission:crm.clientes.index')->name('clientes.index');
        Route::post('clientes/{cliente}/cambiar-estado',    [admin_CrmClientesController::class, 'cambiarEstado'])
            ->middleware('permission:crm.clientes.edit')->name('clientes.cambiar-estado');
        Route::get('clientes/{cliente}',                    [admin_CrmClientesController::class, 'show'])
            ->middleware('permission:crm.clientes.index')->name('clientes.show');
        Route::get('clientes/{cliente}/edit',               [admin_CrmClientesController::class, 'edit'])
            ->middleware('permission:crm.clientes.edit')->name('clientes.edit');
        Route::put('clientes/{cliente}',                    [admin_CrmClientesController::class, 'update'])
            ->middleware('permission:crm.clientes.edit')->name('clientes.update');
        Route::delete('clientes/{cliente}',                 [admin_CrmClientesController::class, 'destroy'])
            ->middleware('permission:crm.clientes.delete')->name('clientes.destroy');

        // Tickets
        Route::get('tickets/pedidos-por-cliente/{clienteId}',   [admin_CrmTicketsController::class, 'pedidosPorCliente'])
            ->middleware('permission:crm.tickets.create')->name('tickets.pedidos-por-cliente');
        Route::get('tickets/ventas-por-cliente/{clienteId}',    [admin_CrmTicketsController::class, 'ventasPorCliente'])
            ->middleware('permission:crm.tickets.create')->name('tickets.ventas-por-cliente');
        Route::post('tickets/{ticket}/agendar-visita',          [admin_CrmTicketsController::class, 'agendarVisita'])
            ->middleware('permission:crm.tickets.edit')->name('tickets.agendar-visita');
        Route::get('tickets',                                   [admin_CrmTicketsController::class, 'index'])
            ->middleware('permission:crm.tickets.index')->name('tickets.index');
        Route::get('tickets/create',                            [admin_CrmTicketsController::class, 'create'])
            ->middleware('permission:crm.tickets.create')->name('tickets.create');
        Route::post('tickets',                                  [admin_CrmTicketsController::class, 'store'])
            ->middleware('permission:crm.tickets.create')->name('tickets.store');
        Route::patch('tickets/{ticket}/estado',                 [admin_CrmTicketsController::class, 'cambiarEstado'])
            ->middleware('permission:crm.tickets.edit')->name('tickets.cambiar-estado');
        Route::post('tickets/{ticket}/asignar',                 [admin_CrmTicketsController::class, 'asignar'])
            ->middleware('permission:crm.tickets.edit')->name('tickets.asignar');
        Route::get('tickets/{ticket}',                          [admin_CrmTicketsController::class, 'show'])
            ->middleware('permission:crm.tickets.index')->name('tickets.show');
        Route::get('tickets/{ticket}/edit',                     [admin_CrmTicketsController::class, 'edit'])
            ->middleware('permission:crm.tickets.edit')->name('tickets.edit');
        Route::put('tickets/{ticket}',                          [admin_CrmTicketsController::class, 'update'])
            ->middleware('permission:crm.tickets.edit')->name('tickets.update');
        Route::delete('tickets/{ticket}',                       [admin_CrmTicketsController::class, 'destroy'])
            ->middleware('permission:crm.tickets.delete')->name('tickets.destroy');

        // Mantenimientos (sin create/store - se crean desde tickets)
        Route::get('mantenimientos',                                [admin_CrmMantenimientosController::class, 'index'])
            ->middleware('permission:crm.mantenimientos.index')->name('mantenimientos.index');
        Route::post('mantenimientos/{mantenimiento}/confirmar',     [admin_CrmMantenimientosController::class, 'confirmar'])
            ->middleware('permission:crm.mantenimientos.edit')->name('mantenimientos.confirmar');
        Route::post('mantenimientos/{mantenimiento}/iniciar',       [admin_CrmMantenimientosController::class, 'iniciar'])
            ->middleware('permission:crm.mantenimientos.edit')->name('mantenimientos.iniciar');
        Route::post('mantenimientos/{mantenimiento}/completar',     [admin_CrmMantenimientosController::class, 'completar'])
            ->middleware('permission:crm.mantenimientos.edit')->name('mantenimientos.completar');
        Route::post('mantenimientos/{mantenimiento}/cancelar',      [admin_CrmMantenimientosController::class, 'cancelar'])
            ->middleware('permission:crm.mantenimientos.edit')->name('mantenimientos.cancelar');
        Route::post('mantenimientos/{mantenimiento}/reprogramar',   [admin_CrmMantenimientosController::class, 'reprogramar'])
            ->middleware('permission:crm.mantenimientos.edit')->name('mantenimientos.reprogramar');
        Route::get('mantenimientos/{mantenimiento}',                [admin_CrmMantenimientosController::class, 'show'])
            ->middleware('permission:crm.mantenimientos.index')->name('mantenimientos.show');
        Route::get('mantenimientos/{mantenimiento}/edit',           [admin_CrmMantenimientosController::class, 'edit'])
            ->middleware('permission:crm.mantenimientos.edit')->name('mantenimientos.edit');
        Route::put('mantenimientos/{mantenimiento}',                [admin_CrmMantenimientosController::class, 'update'])
            ->middleware('permission:crm.mantenimientos.edit')->name('mantenimientos.update');
        Route::delete('mantenimientos/{mantenimiento}',             [admin_CrmMantenimientosController::class, 'destroy'])
            ->middleware('permission:crm.mantenimientos.delete')->name('mantenimientos.destroy');

    }); // Fin CRM

    // ---------------------------------------------------------
    // OPERACIONES — ASIGNACIONES
    // ---------------------------------------------------------
    Route::get('admin-operaciones-asignaciones',            [admin_OperacionesController::class, 'asignacionesIndex'])
        ->middleware('permission:operaciones.asignaciones.index')->name('admin-operaciones-asignaciones.index');
    Route::get('admin-operaciones-asignaciones/data',       [admin_OperacionesController::class, 'asignacionesData'])
        ->middleware('permission:operaciones.asignaciones.index')->name('admin-operaciones-asignaciones.data');
    Route::get('admin-operaciones-asignaciones/stats',      [admin_OperacionesController::class, 'asignacionesGetStats'])
        ->middleware('permission:operaciones.asignaciones.index')->name('admin-operaciones-asignaciones.stats');
    Route::post('admin-operaciones-asignaciones/asignar',   [admin_OperacionesController::class, 'asignacionesAsignar'])
        ->middleware('permission:operaciones.asignaciones.asignar')->name('admin-operaciones-asignaciones.asignar');
    Route::get('admin-operaciones-asignaciones/filtrar',    [admin_OperacionesController::class, 'asignacionesFiltrar'])
        ->middleware('permission:operaciones.asignaciones.index')->name('admin-operaciones-asignaciones.filtrar');
    Route::get('admin-operaciones-asignaciones/{id}',       [admin_OperacionesController::class, 'asignacionesGetPedido'])
        ->middleware('permission:operaciones.asignaciones.index')->name('admin-operaciones-asignaciones.show');

    // ---------------------------------------------------------
    // OPERACIONES — CONTROL DE CALIDAD
    // ---------------------------------------------------------
    Route::get('admin-operaciones-calidad',                 [admin_OperacionesController::class, 'calidadIndex'])
        ->middleware('permission:operaciones.calidad.index')->name('admin-operaciones-calidad.index');
    Route::post('admin-operaciones-calidad/guardar-check',  [admin_OperacionesController::class, 'calidadGuardarCheck'])
        ->middleware('permission:operaciones.calidad.aprobar')->name('admin-operaciones-calidad.guardar-check');
    Route::post('admin-operaciones-calidad/aprobar',        [admin_OperacionesController::class, 'calidadAprobar'])
        ->middleware('permission:operaciones.calidad.aprobar')->name('admin-operaciones-calidad.aprobar');
    Route::post('admin-operaciones-calidad/rechazar',       [admin_OperacionesController::class, 'calidadRechazar'])
        ->middleware('permission:operaciones.calidad.rechazar')->name('admin-operaciones-calidad.rechazar');
    Route::get('admin-operaciones-calidad/{id}',            [admin_OperacionesController::class, 'calidadGetPedido'])
        ->middleware('permission:operaciones.calidad.index')->name('admin-operaciones-calidad.show');

    // ---------------------------------------------------------
    // OPERACIONES — TRAZABILIDAD
    // ---------------------------------------------------------
    Route::get('admin-operaciones-trazabilidad',            [admin_OperacionesController::class, 'trazabilidadIndex'])
        ->middleware('permission:operaciones.trazabilidad.index')->name('admin-operaciones-trazabilidad.index');
    Route::get('admin-operaciones-trazabilidad/buscar',     [admin_OperacionesController::class, 'trazabilidadBuscar'])
        ->middleware('permission:operaciones.trazabilidad.index')->name('admin-operaciones-trazabilidad.buscar');
    Route::get('admin-operaciones-trazabilidad/{id}',       [admin_OperacionesController::class, 'trazabilidadGetPedido'])
        ->middleware('permission:operaciones.trazabilidad.index')->name('admin-operaciones-trazabilidad.show');

    // ---------------------------------------------------------
    // OPERACIONES — CAMPAÑAS
    // ---------------------------------------------------------
    Route::get('admin-operaciones-campanias',                   [admin_OperacionesController::class, 'campaniasIndex'])
        ->middleware('permission:operaciones.campanias.index')->name('admin-operaciones-campanias.index');
    Route::get('admin-operaciones-campanias/crear',             [admin_OperacionesController::class, 'campaniasCreate'])
        ->middleware('permission:operaciones.campanias.create')->name('admin-operaciones-campanias.create');
    Route::post('admin-operaciones-campanias',                  [admin_OperacionesController::class, 'campaniasStore'])
        ->middleware('permission:operaciones.campanias.create')->name('admin-operaciones-campanias.store');
    Route::get('admin-operaciones-campanias/ajax/productos',    [admin_OperacionesController::class, 'campaniasGetProductos'])
        ->middleware('permission:operaciones.campanias.create')->name('admin-operaciones-campanias.ajax.productos');
    Route::get('admin-operaciones-campanias/{id}/editar',       [admin_OperacionesController::class, 'campaniasEdit'])
        ->middleware('permission:operaciones.campanias.edit')->name('admin-operaciones-campanias.edit');
    Route::put('admin-operaciones-campanias/{id}',              [admin_OperacionesController::class, 'campaniasUpdate'])
        ->middleware('permission:operaciones.campanias.edit')->name('admin-operaciones-campanias.update');
    Route::delete('admin-operaciones-campanias/{id}',           [admin_OperacionesController::class, 'campaniasDestroy'])
        ->middleware('permission:operaciones.campanias.delete')->name('admin-operaciones-campanias.destroy');
    Route::post('admin-operaciones-campanias/{id}/activar',     [admin_OperacionesController::class, 'campaniasActivar'])
        ->middleware('permission:operaciones.campanias.gestionar')->name('admin-operaciones-campanias.activar');
    Route::post('admin-operaciones-campanias/{id}/pausar',      [admin_OperacionesController::class, 'campaniasPausar'])
        ->middleware('permission:operaciones.campanias.gestionar')->name('admin-operaciones-campanias.pausar');
    Route::post('admin-operaciones-campanias/{id}/reanudar',    [admin_OperacionesController::class, 'campaniasReanudar'])
        ->middleware('permission:operaciones.campanias.gestionar')->name('admin-operaciones-campanias.reanudar');
    Route::post('admin-operaciones-campanias/{id}/finalizar',   [admin_OperacionesController::class, 'campaniasFinalizar'])
        ->middleware('permission:operaciones.campanias.gestionar')->name('admin-operaciones-campanias.finalizar');
    Route::post('admin-operaciones-campanias/{id}/duplicar',    [admin_OperacionesController::class, 'campaniasDuplicar'])
        ->middleware('permission:operaciones.campanias.create')->name('admin-operaciones-campanias.duplicar');
    Route::get('admin-operaciones-campanias/{id}/metricas',     [admin_OperacionesController::class, 'campaniasGetMetricas'])
        ->middleware('permission:operaciones.campanias.index')->name('admin-operaciones-campanias.metricas');
    Route::get('admin-operaciones-campanias/{id}',              [admin_OperacionesController::class, 'campaniasShow'])
        ->middleware('permission:operaciones.campanias.index')->name('admin-operaciones-campanias.show');

}); // Fin middleware auth

// =============================================================
// AUTH — Login, registro, password reset (públicos)
// =============================================================
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
