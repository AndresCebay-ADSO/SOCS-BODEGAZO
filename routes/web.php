<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Controladores
use App\Http\Controllers\Auth\RegistroUsuarioController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\NotificacionesController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FacturacionController;
use App\Http\Controllers\NequiController;
use App\Http\Controllers\ClienteProductoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\BusquedaController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\SuperAdmin\UsuarioController as SuperAdminUsuarioController;
use App\Http\Controllers\SuperAdmin\AdminManagementController;

use App\Http\Controllers\PayUController;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/productos', function() {
    return redirect()->route('clientes.productos.index');
})->middleware('auth');

/*
|--------------------------------------------------------------------------
| AUTENTICACIÓN
|--------------------------------------------------------------------------
*/

Route::get('/login', [RegistroUsuarioController::class, 'showLoginForm'])->name('login');
Route::post('/login', [RegistroUsuarioController::class, 'login'])->name('login.post');
Route::get('/register', [UsuarioController::class, 'create'])->name('register');
Route::post('/register', [UsuarioController::class, 'store'])->name('register.post');

Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login')->with('status', 'Sesión cerrada correctamente.');
})->name('logout');

// Recuperación de contraseña
Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

/*
|--------------------------------------------------------------------------
| PANEL DE USUARIO (CLIENTE)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('cliente')->name('clientes.')->group(function() {
    Route::get('/dashboard', function() {
        return view('clientes.dashboard');
    })->name('dashboard');

    Route::get('/categorias', [ClienteProductoController::class, 'categorias'])->name('categorias');

    // Perfil
    Route::get('/profile', [UsuarioController::class, 'perfil'])->name('profile');
    Route::get('/profile/edit', [UsuarioController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/update', [UsuarioController::class, 'updateProfile'])->name('profile.update');

    // Rutas de pedidos actualizadas
    Route::prefix('pedidos')->name('pedidos.')->group(function() {
        Route::get('/', [PedidoController::class, 'misPedidos'])->name('index');
        Route::get('/crear', [PedidoController::class, 'create'])->name('create');
        Route::post('/', [PedidoController::class, 'store'])->name('store');
        Route::get('/{pedido}/pagar', [PedidoController::class, 'pagarPedido'])->name('pagar');
        Route::get('/{pedido}/factura', [PedidoController::class, 'factura'])->name('factura');
    });

    Route::prefix('pagos')->name('pagos.')->group(function () {
        Route::post('/crear', [PayUController::class, 'createPayment'])->name('crear');
        Route::post('/respuesta', [PayUController::class, 'paymentResponse'])->name('respuesta');
        Route::post('/notificacion', [PayUController::class, 'paymentNotification'])->name('notificacion');
    });

    
    // Carrito
    Route::prefix('carrito')->name('carrito.')->group(function () {
        Route::get('/', [CarritoController::class, 'index'])->name('index');
        Route::post('/agregar', [CarritoController::class, 'agregar'])->name('agregar');
        Route::put('/actualizar', [CarritoController::class, 'actualizar'])->name('actualizar');
        Route::delete('/eliminar/{id}', [CarritoController::class, 'eliminar'])->name('eliminar');
        Route::delete('/limpiar', [CarritoController::class, 'limpiar'])->name('limpiar');
        Route::get('/checkout', [CarritoController::class, 'checkout'])->name('checkout');
        Route::post('/procesar', [CarritoController::class, 'procesarPedido'])->name('procesar');
        Route::get('/cantidad', [CarritoController::class, 'obtenerCantidad'])->name('cantidad');
    });

    // Búsqueda
    Route::get('/buscar', [BusquedaController::class, 'buscar'])->name('buscar');
    Route::get('/autocompletar', [BusquedaController::class, 'autocompletar'])->name('autocompletar');

    // Productos
    Route::get('/productos', [ClienteProductoController::class, 'index'])->name('productos.index');
    Route::get('/productos/{producto}', [ClienteProductoController::class, 'show'])->name('productos.show');
    Route::get('/categoria/{categoriaId}/productos', [ClienteProductoController::class, 'categoria'])->name('productos.categoria');

    // Rutas de políticas y términos
    Route::prefix('politicas')->name('politicas.')->group(function() {
        Route::get('/terminos', function() {
            return view('clientes.politicas.terminos-condiciones');
        })->name('terminos');
        
        Route::get('/privacidad', function() {
            return view('clientes.politicas.privacidad');
        })->name('privacidad');
    });
});
/*
|--------------------------------------------------------------------------
| PANEL DE ADMINISTRADOR
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    // Perfil
    Route::prefix('profile')->name('profile.')->group(function() {
        Route::get('/', [AdminController::class, 'show'])->name('show');
        Route::get('/edit', [AdminController::class, 'edit'])->name('edit');
        Route::put('/', [AdminController::class, 'update'])->name('update');
        Route::get('/password', [AdminController::class, 'editPassword'])->name('password.edit');
        Route::put('/password', [AdminController::class, 'updatePassword'])->name('password.update');
    });
    
    // Productos
    Route::prefix('productos')->name('productos.')->group(function () {
        Route::get('/', [ProductoController::class, 'index'])->name('index');
        Route::get('/crear', [ProductoController::class, 'create'])->name('create');
        Route::post('/', [ProductoController::class, 'store'])->name('store');
        Route::get('/{producto}', [ProductoController::class, 'show'])->name('show');
        Route::get('/{producto}/editar', [ProductoController::class, 'edit'])->name('edit');
        Route::put('/{producto}', [ProductoController::class, 'update'])->name('update');
        Route::delete('/{producto}', [ProductoController::class, 'destroy'])->name('destroy');
    });

    // Inventarios
    Route::prefix('inventarios')->name('inventarios.')->group(function () {
        Route::get('/', [InventarioController::class, 'index'])->name('index');
        Route::get('/crear', [InventarioController::class, 'create'])->name('create');
        Route::post('/', [InventarioController::class, 'store'])->name('store');
        Route::get('/{inventario}', [InventarioController::class, 'show'])->name('show');
        Route::get('/{inventario}/editar', [InventarioController::class, 'edit'])->name('edit');
        Route::put('/{inventario}', [InventarioController::class, 'update'])->name('update');
        Route::delete('/{inventario}', [InventarioController::class, 'destroy'])->name('destroy');
        Route::get('/reporte', [InventarioController::class, 'reporte'])->name('reporte');
        Route::get('/exportar', [InventarioController::class, 'exportar'])->name('exportar');
    });

    // Pedidos
    Route::prefix('pedidos')->name('pedidos.')->group(function () {
        Route::get('/', [PedidoController::class, 'index'])->name('index');
        Route::get('/crear', [PedidoController::class, 'create'])->name('create');
        Route::post('/', [PedidoController::class, 'store'])->name('store');
        Route::get('/{pedido}', [PedidoController::class, 'show'])->name('show');
        Route::get('/{pedido}/editar', [PedidoController::class, 'edit'])->name('edit');
        Route::put('/{pedido}', [PedidoController::class, 'update'])->name('update');
        Route::delete('/{pedido}', [PedidoController::class, 'destroy'])->name('destroy');
        Route::get('/{pedido}/factura', [PedidoController::class, 'factura'])->name('factura');
        Route::post('/{pedido}/estado', [PedidoController::class, 'updateEstado'])->name('updateEstado');
    });

    // Notificaciones
    Route::prefix('notificaciones')->name('notificaciones.')->group(function () {
        Route::get('/', [NotificacionesController::class, 'index'])->name('index');
        Route::get('/crear', [NotificacionesController::class, 'create'])->name('create');
        Route::post('/', [NotificacionesController::class, 'store'])->name('store');
        Route::get('/{notificacion}/editar', [NotificacionesController::class, 'edit'])->name('edit');
        Route::put('/{notificacion}', [NotificacionesController::class, 'update'])->name('update');
        Route::delete('/{notificacion}', [NotificacionesController::class, 'destroy'])->name('destroy');
    });

    // Usuarios
    Route::prefix('usuarios')->name('usuarios.')->group(function () {
        Route::get('/', [UsuarioController::class, 'index'])->name('index');
        Route::get('/crear', [UsuarioController::class, 'createFromAdmin'])->name('create');
        Route::post('/', [UsuarioController::class, 'storeFromAdmin'])->name('store');
        Route::get('/{usuario}/editar', [UsuarioController::class, 'editFromAdmin'])->name('edit');
        Route::put('/{usuario}', [UsuarioController::class, 'update'])->name('update');
        Route::delete('/{usuario}', [UsuarioController::class, 'destroy'])->name('destroy');
        Route::get('/{usuario}/historial', [UsuarioController::class, 'historial'])->name('historial');
        Route::get('/buscar', [UsuarioController::class, 'buscar'])->name('buscar');
        Route::get('/{id}/factura', [UsuarioController::class, 'factura'])->name('factura');
    });

    // Facturación
    Route::prefix('facturacion')->name('facturacion.')->group(function () {
        Route::get('/', [FacturacionController::class, 'index'])->name('index');
        Route::get('/crear', [FacturacionController::class, 'create'])->name('create');
        Route::post('/', [FacturacionController::class, 'store'])->name('store');
        Route::get('/{factura}', [FacturacionController::class, 'show'])->name('show');
        Route::post('/{factura}/enviar-dian', [FacturacionController::class, 'enviarDIAN'])->name('enviar-dian');
        Route::get('/{factura}/descargar-pdf', [FacturacionController::class, 'descargarPDF'])->name('descargar-pdf');
        Route::get('/{factura}/descargar-xml', [FacturacionController::class, 'descargarXML'])->name('descargar-xml');
        Route::post('/{factura}/anular', [FacturacionController::class, 'anular'])->name('anular');
    });

    // Nequi
    Route::prefix('nequi')->name('nequi.')->group(function () {
        Route::get('/', [NequiController::class, 'index'])->name('index');
        Route::get('/{pago}', [NequiController::class, 'show'])->name('show');
    });
});

// API Nequi (fuera del grupo de admin)
Route::prefix('api/nequi')->name('api.nequi.')->group(function () {
    Route::post('/crear-pago', [NequiController::class, 'crearPago'])->name('crear-pago');
    Route::post('/validar-pago', [NequiController::class, 'validarPago'])->name('validar-pago');
    Route::post('/consultar-estado', [NequiController::class, 'consultarEstado'])->name('consultar-estado');
    Route::post('/webhook', [NequiController::class, 'webhook'])->name('webhook');
});

/*
|--------------------------------------------------------------------------
| PANEL DE SUPER-ADMINISTRADOR
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    // Dashboard
    Route::get('/', [SuperAdminController::class, 'dashboard'])->name('dashboard');

    // Perfil
    Route::prefix('profile')->name('profile.')->group(function() {
        Route::get('/', [SuperAdminController::class, 'show'])->name('show');
        Route::get('/edit', [SuperAdminController::class, 'edit'])->name('edit');
        Route::put('/', [SuperAdminController::class, 'update'])->name('update');
        Route::get('/password', [SuperAdminController::class, 'editPassword'])->name('password.edit');
        Route::put('/password', [SuperAdminController::class, 'updatePassword'])->name('password.update');
    });
    
    // Productos
    Route::prefix('productos')->name('productos.')->group(function () {
        Route::get('/', [ProductoController::class, 'index'])->name('index');
        Route::get('/crear', [ProductoController::class, 'create'])->name('create');
        Route::post('/', [ProductoController::class, 'store'])->name('store');
        Route::get('/{producto}', [ProductoController::class, 'show'])->name('show');
        Route::get('/{producto}/editar', [ProductoController::class, 'edit'])->name('edit');
        Route::put('/{producto}', [ProductoController::class, 'update'])->name('update');
        Route::delete('/{producto}', [ProductoController::class, 'destroy'])->name('destroy');
    });

    // Inventarios 
    Route::prefix('inventarios')->name('inventarios.')->group(function () {
        Route::get('/', [InventarioController::class, 'index'])->name('index');
        Route::get('/crear', [InventarioController::class, 'create'])->name('create');
        Route::post('/', [InventarioController::class, 'store'])->name('store');
        Route::get('/{inventario}', [InventarioController::class, 'show'])->name('show');
        Route::get('/{inventario}/editar', [InventarioController::class, 'edit'])->name('edit');
        Route::put('/{inventario}', [InventarioController::class, 'update'])->name('update');
        Route::delete('/{inventario}', [InventarioController::class, 'destroy'])->name('destroy');
        
        // Rutas adicionales recomendadas
        Route::get('/reporte', [InventarioController::class, 'reporte'])->name('reporte');
        Route::get('/exportar', [InventarioController::class, 'exportar'])->name('exportar');
    });

    // Pedidos
    Route::prefix('pedidos')->name('pedidos.')->group(function () {
        // Dashboard de pedidos
        Route::get('/dashboard', [PedidoController::class, 'index'])
            ->name('dashboard')
            ->middleware('auth');
        
        // Resto de tus rutas existentes
        Route::get('/', [PedidoController::class, 'index'])->name('index');
        Route::get('/crear', [PedidoController::class, 'create'])->name('create');
        Route::post('/', [PedidoController::class, 'store'])->name('store');
        Route::get('/{pedido}', [PedidoController::class, 'show'])->name('show');
        Route::get('/{pedido}/editar', [PedidoController::class, 'edit'])->name('edit');
        Route::put('/{pedido}', [PedidoController::class, 'update'])->name('update');
        Route::delete('/{pedido}', [PedidoController::class, 'destroy'])->name('destroy');
        Route::get('/{pedido}/factura', [PedidoController::class, 'factura'])->name('factura');
        Route::post('/{pedido}/estado', [PedidoController::class, 'updateEstado'])->name('updateEstado');
    });

    // Notificaciones (coincide con admin/notifications/ en tus vistas)
    Route::prefix('notificaciones')->name('notificaciones.')->middleware(['auth', 'admin'])->group(function () {
        // Listado
        Route::get('/', [NotificacionesController::class, 'index'])->name('index');
        
        // Creación
        Route::get('/crear', [NotificacionesController::class, 'create'])->name('create');
        Route::post('/', [NotificacionesController::class, 'store'])->name('store');
        
        // Edición
        Route::get('/{notificacion}/editar', [NotificacionesController::class, 'edit'])->name('edit');
        Route::put('/{notificacion}', [NotificacionesController::class, 'update'])->name('update');
        
        // Eliminación
        Route::delete('/{notificacion}', [NotificacionesController::class, 'destroy'])->name('destroy');
    });

    // Facturación Electrónica
    Route::prefix('facturacion')->name('facturacion.')->group(function () {
        Route::get('/', [FacturacionController::class, 'index'])->name('index');
        Route::get('/crear', [FacturacionController::class, 'create'])->name('create');
        Route::post('/', [FacturacionController::class, 'store'])->name('store');
        Route::get('/{factura}', [FacturacionController::class, 'show'])->name('show');
        Route::post('/{factura}/enviar-dian', [FacturacionController::class, 'enviarDIAN'])->name('enviar-dian');
        Route::get('/{factura}/descargar-pdf', [FacturacionController::class, 'descargarPDF'])->name('descargar-pdf');
        Route::get('/{factura}/descargar-xml', [FacturacionController::class, 'descargarXML'])->name('descargar-xml');
        Route::post('/{factura}/anular', [FacturacionController::class, 'anular'])->name('anular');
    });

    // Pagos Nequi
    Route::prefix('nequi')->name('nequi.')->group(function () {
        Route::get('/', [NequiController::class, 'index'])->name('index');
        Route::get('/{pago}', [NequiController::class, 'show'])->name('show');
    });

    // API Nequi (sin middleware de admin para webhooks)
    Route::prefix('api/nequi')->name('api.nequi.')->group(function () {
        Route::post('/crear-pago', [NequiController::class, 'crearPago'])->name('crear-pago');
        Route::post('/validar-pago', [NequiController::class, 'validarPago'])->name('validar-pago');
        Route::post('/consultar-estado', [NequiController::class, 'consultarEstado'])->name('consultar-estado');
        Route::post('/webhook', [NequiController::class, 'webhook'])->name('webhook');
    });

    //usuario 
    Route::prefix('usuarios')->name('usuarios.')->group(function () {
        Route::get('/', [SuperAdminUsuarioController::class, 'index'])->name('index');
        Route::get('/crear', [SuperAdminUsuarioController::class, 'create'])->name('create');
        Route::post('/', [SuperAdminUsuarioController::class, 'store'])->name('store');
        Route::get('/{usuario}/editar', [SuperAdminUsuarioController::class, 'edit'])->name('edit');
        Route::put('/{usuario}', [SuperAdminUsuarioController::class, 'update'])->name('update');
        Route::delete('/{usuario}', [SuperAdminUsuarioController::class, 'destroy'])->name('destroy');
        Route::get('/buscar', [SuperAdminUsuarioController::class, 'buscar'])->name('buscar');
        Route::get('/{id}/historial', [SuperAdminUsuarioController::class, 'historial'])->name('historial');
    });

    //administradores, roles y permisos
// En la sección de management dentro del grupo superadmin
    Route::prefix('management')->name('management.')->group(function () {
        Route::get('/', [AdminManagementController::class, 'index'])->name('index');
        Route::get('/admins/create', [AdminManagementController::class, 'create'])->name('admins.create');
        Route::post('/admins/store-step1', [AdminManagementController::class, 'adminsStoreStep1'])->name('admins.store-step1');
        Route::post('/admins/store-step2', [AdminManagementController::class, 'adminsStoreStep2'])->name('admins.store-step2');
        Route::post('/admins/store-step3', [AdminManagementController::class, 'adminsStoreStep3'])->name('admins.store-step3');
        Route::get('/admins/permissions', [AdminManagementController::class, 'adminsPermissions'])->name('admins.permissions');
        Route::post('/admins/store-final', [AdminManagementController::class, 'adminsStoreFinal'])->name('admins.store-final');
        Route::get('/admins/{admin}/edit', [AdminManagementController::class, 'adminsEdit'])->name('admins.edit');
        Route::put('/admins/{admin}', [AdminManagementController::class, 'adminsUpdate'])->name('admins.update');
        Route::delete('/admins/{admin}', [AdminManagementController::class, 'adminsDestroy'])->name('admins.destroy');
        
        // Rutas para roles
        Route::get('/roles', [AdminManagementController::class, 'rolesIndex'])->name('roles.index');
        Route::get('/roles/create', [AdminManagementController::class, 'rolesCreate'])->name('roles.create');
        Route::post('/roles', [AdminManagementController::class, 'rolesStore'])->name('roles.store');
        Route::get('/roles/{role}/edit', [AdminManagementController::class, 'rolesEdit'])->name('roles.edit');
        Route::put('/roles/{role}', [AdminManagementController::class, 'rolesUpdate'])->name('roles.update');
        Route::delete('/roles/{role}', [AdminManagementController::class, 'rolesDestroy'])->name('roles.destroy');

        // Rutas para vistas
Route::get('/get-module-views', [AdminManagementController::class, 'getModuleViews'])->name('get.module.views');
    });
});