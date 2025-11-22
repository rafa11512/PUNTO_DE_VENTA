<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    public function index()
    {
        // Retornamos la vista que crearemos en el paso 3
        return view('admin.categorias.index');
    }
}