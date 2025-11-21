<?php

use App\Models\Producto;
use App\Models\Cliente;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    $productos = Producto::all();
    $clientes  = Cliente::all();

    return view('welcome', compact('productos', 'clientes'));

})->name('view_home');
