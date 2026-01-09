<?php

use App\Http\Controllers\admin_ConfiguracionesController;
use App\Http\Controllers\admin_DashboardController;
use App\Http\Controllers\admin_InformacionController;
use App\Http\Controllers\admin_PerfilController;
use App\Http\Controllers\admin_ReportesController;
use App\Http\Controllers\admin_RolesController;
use App\Http\Controllers\admin_UsuariosController;
use App\Http\Controllers\AdminCategoriasControllerController;
use App\Http\Controllers\AdminEtiquetasControllerController;
use App\Http\Controllers\AdminMarcasControllerController;
use App\Http\Controllers\AdminTiposControllerController;
use App\Http\Controllers\ecommerceController;
use App\Models\admin_CategoriasController;
use App\Models\admin_ClientesController;
use App\Models\admin_CoberturasController;
use App\Models\admin_CuponesController;
use App\Models\admin_DescuentosController;
use App\Models\admin_EtiquetasController;
use App\Models\admin_MarcasController;
use App\Models\admin_ProductosController;
use App\Models\admin_ProveedoresController;
use App\Models\admin_ServiciosController;
use App\Models\admin_TiposController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// ECOMMERCE
Route::get('/', [ecommerceController::class, 'index'])->name('ecommerce.index');
Route::get('/products', [ecommerceController::class, 'products'])->name('ecommerce.products');

// ADMINISTRADOR
Route::get('admin-dashboard', [admin_DashboardController::class, 'index'])->name('admin-dashboard.index');

Route::get('admin-configuraciones', [admin_ConfiguracionesController::class, 'index'])->name('admin-configuraciones.index');

Route::resource('admin-informacion', admin_InformacionController::class);
Route::resource('admin-roles', admin_RolesController::class);
Route::resource('admin-usuarios', admin_UsuariosController::class);
Route::put('/admin-usuarios/estado/{admin_usuario}', [admin_UsuariosController::class, 'estado']);
Route::resource('admin-perfil', admin_PerfilController::class);

Route::resource('admin-tipos', AdminTiposControllerController::class);
Route::put('/admin-tipos/estado/{admin_tipo}', [AdminTiposControllerController::class, 'estado']);
Route::resource('admin-categorias', AdminCategoriasControllerController::class);
Route::put('/admin-categorias/estado/{admin_categoria}', [AdminCategoriasControllerController::class, 'estado']);
Route::resource('admin-marcas', AdminMarcasControllerController::class);
Route::put('/admin-marcas/estado/{admin_marca}', [AdminMarcasControllerController::class, 'estado']);
Route::resource('admin-etiquetas', AdminEtiquetasControllerController::class);
Route::put('/admin-etiquetas/estado/{admin_etiqueta}', [AdminEtiquetasControllerController::class, 'estado']);

Route::resource('admin-proveedores', admin_ProveedoresController::class);
Route::put('/admin-proveedores/estado/{admin_proveedor}', [admin_ProveedoresController::class, 'estado']);
Route::resource('admin-productos', admin_ProductosController::class);
Route::put('/admin-productos/estado/{admin_producto}', [admin_ProductosController::class, 'estado']);

Route::resource('admin-clientes', admin_ClientesController::class);
Route::put('/admin-clientes/estado/{admin_cliente}', [admin_ClientesController::class, 'estado']);
Route::resource('admin-coberturas', admin_CoberturasController::class);
Route::put('/admin-coberturas/estado/{admin_cobertura}', [admin_CoberturasController::class, 'estado']);
Route::resource('admin-descuentos', admin_DescuentosController::class);
Route::put('/admin-descuentos/estado/{admin_descuento}', [admin_DescuentosController::class, 'estado']);
Route::resource('admin-cupones', admin_CuponesController::class);
Route::put('/admin-cupones/estado/{admin_cupon}', [admin_CuponesController::class, 'estado']);
Route::resource('admin-servicios', admin_ServiciosController::class);
Route::put('/admin-servicios/estado/{admin_servicio}', [admin_ServiciosController::class, 'estado']);

Route::get('admin-reportes', [admin_ReportesController::class, 'index'])->name('admin-reportes.index');
