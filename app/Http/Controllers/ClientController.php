<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        return view('cliente.home'); // Retorna la vista de la tienda
    }
}