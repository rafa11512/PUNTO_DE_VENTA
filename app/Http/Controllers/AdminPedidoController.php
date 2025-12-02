<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;

class AdminPedidoController extends Controller
{
    /**
     * Display a listing of the resource (ventas/pedidos).
     */
    public function index(Request $request)
    {
        // Cargar ventas con su cliente y usuario (empleado) y detalles
        $query = Venta::with(['cliente', 'usuario'])
            ->orderBy('id', 'asc');

        // Buscar por cliente
        if ($request->filled('buscar')) {
            $buscar = $request->input('buscar');
            $query->whereHas('cliente', function ($q) use ($buscar) {
                $q->where('name', 'like', '%' . $buscar . '%');
            });
        }

        // Filtrar por método de pago
        if ($request->filled('metodo')) {
            $query->where('metodo_pago', $request->input('metodo'));
        }

        // Filtrar por fechas
        if ($request->filled('fecha_inicio')) {
            $query->whereDate('fecha', '>=', $request->input('fecha_inicio'));
        }
        if ($request->filled('fecha_fin')) {
            $query->whereDate('fecha', '<=', $request->input('fecha_fin'));
        }

        // Paginación
        $ventas = $query->paginate(12)->appends($request->query());

        return view('admin.pedidos.pedidos', compact('ventas'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $venta = Venta::with(['cliente', 'usuario', 'detalles.producto'])->findOrFail($id);
        return view('admin.pedidos.show', compact('venta'));
    }

    // Otros métodos (create/edit/delete) no son necesarios por ahora
}
