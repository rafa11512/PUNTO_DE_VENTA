<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AdminClientController;
use App\Http\Controllers\AdminCategoryController; 
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminPedidoController;

Route::get('/', function () {
    return redirect()->route('client.home');
});

// Rutas Publicas
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/registro', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/registro', [AuthController::class, 'register'])->name('register.submit');

// Rutas Cliente Publicas (Tienda)
Route::get('/tienda', [ClientController::class, 'index'])->name('client.home');
Route::get('/productos', [ClientController::class, 'productos'])->name('client.productos');
Route::get('/carrito', [ClientController::class, 'carrito'])->name('client.carrito');
Route::post('/carrito/agregar', [ClientController::class, 'agregarCarrito'])->name('client.carrito.agregar');

// En el grupo de rutas del cliente:
Route::prefix('cliente')->name('client.')->group(function () {
    Route::get('/inicio', [ClientController::class, 'index'])->name('home');
    Route::get('/productos', function() { return redirect()->route('client.home'); })->name('productos');
    Route::get('/mis-pedidos', [ClientController::class, 'misPedidos'])->name('pedidos');
});

// Rutas protegidas
Route::middleware(['auth'])->group(function () {
    // CLIENTE AUTENTICADO
    Route::post('/carrito/pagar', [ClientController::class, 'pagarCarrito'])->name('client.carrito.pagar');
    Route::prefix('cliente')->name('client.')->group(function () {
        Route::get('/inicio', [ClientController::class, 'index'])->name('home');
    });
    // ADMINISTRADOR
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::resource('clientes', AdminClientController::class);
        Route::resource('categorias', AdminCategoryController::class);
        Route::resource('productos', AdminProductController::class);
        // Rutas de Pedidos
        Route::resource('pedidos', AdminPedidoController::class)->only(['index', 'show']);
        Route::put('/pedidos/{id}/estado', [AdminPedidoController::class, 'cambiarEstado'])->name('pedidos.estado');
    });
});