<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Producto;
use App\Models\Venta;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        // Estadisticas para las tarjetas (numero de clientes, productos y ventas del mes)
        $clientesCount = User::where('rol', 'cliente')->count();
        $productosCount = Producto::count();
        
        // Ventas del mes actual
        $ventasMes = Venta::where('estado', '!=', 'cancelado')
                          ->whereMonth('fecha', Carbon::now()->month)
                          ->whereYear('fecha', Carbon::now()->year)
                          ->sum('total');

        // Pedidos Recientes (Traemos los últimos 5)
        $pedidosRecientes = Venta::with('cliente')
                                 ->orderBy('created_at', 'desc')
                                 ->take(5)
                                 ->get();

        return view('admin.dashboard', compact('clientesCount', 'productosCount', 'ventasMes', 'pedidosRecientes'));
    }
}