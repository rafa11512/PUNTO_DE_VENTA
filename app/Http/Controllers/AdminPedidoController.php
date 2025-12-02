<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPedidoController extends Controller
{
    // Mostrar lista de pedidos
    public function index(Request $request)
    {
        $query = Venta::with(['cliente', 'usuario'])->orderBy('id', 'desc');

        if ($request->filled('buscar')) {
            $buscar = $request->input('buscar');
            $query->whereHas('cliente', function ($q) use ($buscar) {
                $q->where('name', 'like', '%' . $buscar . '%');
            });
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->input('estado'));
        }

        $ventas = $query->paginate(10)->appends($request->query());
        return view('admin.pedidos.pedidos', compact('ventas'));
    }

    // Mostrar detalle del pedido
    public function show(string $id)
    {
        $venta = Venta::with(['cliente', 'usuario', 'detalles.producto'])->findOrFail($id);
        return view('admin.pedidos.show', compact('venta'));
    }

    /**
     * LOGICA MAESTRA DE CAMBIO DEL ESTADO E INVENTARIO
     */
    public function cambiarEstado(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,en_preparacion,completado,cancelado'
        ]);

        $venta = Venta::with('detalles.producto')->findOrFail($id);
        $nuevoEstado = $request->estado;
        $estadoAnterior = $venta->estado;

        if ($nuevoEstado === $estadoAnterior) {
            return redirect()->back();
        }

        // Definimos grupos de estados para saber si "restan" o "no restan" inventario
        // Grupo A (No descontar stock): pendiente, cancelado
        // Grupo B (descontar stock): en_preparacion, completado
        
        $grupoA = ['pendiente', 'cancelado'];
        $grupoB = ['en_preparacion', 'completado'];

        DB::beginTransaction();

        try {
            // CASO 1: Mover de Grupo A (Sin descuento)  a Grupo B (Descontar)
            // Ej: de Pendiente a En Preparacion
            if (in_array($estadoAnterior, $grupoA) && in_array($nuevoEstado, $grupoB)) {
                
                foreach ($venta->detalles as $detalle) {
                    $producto = Producto::lockForUpdate()->find($detalle->producto_id); // Bloqueamos fila para evitar condiciones de carrera

                    if (!$producto) continue; // Si el producto fue borrado, nos lo saltamos

                    // Validamos si hay suficiente stock
                    if ($producto->stock < $detalle->cantidad) {
                        throw new \Exception("STOCK INSUFICIENTE: El producto '{$producto->nombre}' solo tiene {$producto->stock} unidades y el pedido requiere {$detalle->cantidad}. Agrega stock antes de procesar.");
                    }

                    // RESTAMOS STOCK
                    $producto->stock -= $detalle->cantidad;
                    $producto->save();
                }
            }

            // CASO 2: Mover de Grupo B (Con descuento) a Grupo A (Devolver)
            // Ej: de En Preparacion a Cancelado (El cliente se arrepintio o hubo error)
            elseif (in_array($estadoAnterior, $grupoB) && in_array($nuevoEstado, $grupoA)) {
                
                foreach ($venta->detalles as $detalle) {
                    $producto = Producto::lockForUpdate()->find($detalle->producto_id);
                    if ($producto) {
                        // DEVOLVEMOS STOCK
                        $producto->stock += $detalle->cantidad;
                        $producto->save();
                    }
                }
            }

            // CASO 3: Movimientos dentro del mismo grupo (Ej: Preparacion -> Completado)
            // No hacemos cambios en el stock, solo cambiamos el estado visual

            // Guardamos el cambio de estado
            $venta->estado = $nuevoEstado;
            
            // Si el estado es "en_preparacion", asignamos al usuario admin actual como el vendedor
            if ($nuevoEstado == 'en_preparacion' && auth()->check()) {
                $venta->usuario_id = auth()->id();
            }

            $venta->save();

            DB::commit();
            return redirect()->back()->with('success', "Estado actualizado a: " . strtoupper(str_replace('_', ' ', $nuevoEstado)));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}