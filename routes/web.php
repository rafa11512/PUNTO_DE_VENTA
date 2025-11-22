<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; // Controlador para la autenticacion (login, registro, logout)
use App\Http\Controllers\AdminController; // Controlador para la gestion del admin
use App\Http\Controllers\ClientController; // Controlador para la gestion de la tienda por el cliente
use App\Http\Controllers\AdminClientController;// Controlador para la gestion de clientes por el admin

// Importaciones para Categorias y Productos (Admin)
use App\Http\Controllers\AdminCategoryController; 
use App\Http\Controllers\AdminProductController;

// Si entran a la raiz, los mandamos al login
Route::get('/', function () {
    return redirect()->route('client.home');
});

// Rutas PUblicas (Login, Registro y TIENDA)
// RUTA DE LA PAGINA    CONTOLLER      FUNCION DENTRO DEL CONTROLLER     NOMMBRE DE LA RUTA
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/registro', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/registro', [AuthController::class, 'register'])->name('register.submit');

Route::get('/tienda', [ClientController::class, 'index'])->name('client.home');

Route::middleware(['auth'])->group(function () {

    // --- GRUPO DE RUTAS DEL ADMINISTRADOR ---
    Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('clientes', AdminClientController::class);

    // NUEVO: Gestion de Categorias y Productos --- Esto habilita las rutas index, create, store, edit, update, destroy automaticamente
    Route::resource('categorias', AdminCategoryController::class);
    Route::resource('productos', AdminProductController::class);
    });

    // --- GRUPO DE RUTAS DEL CLIENTE ---
    Route::prefix('cliente')->name('client.')->group(function () {
    Route::get('/inicio', [ClientController::class, 'index'])->name('home');
    });
    

});