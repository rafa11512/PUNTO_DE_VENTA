<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\Categoria;

class ClientController extends Controller
{
    /**
     * PAGINA DE INICIO (HOME)
     * Muestra slider, categorias, productos destacados y acerca de.
     */
public function index(Request $request)
    {
        // logica de filtrado (antes estaba en 'productos')
        $query = Producto::with('categoria')->where('stock', '>', 0);

        if($request->filled('categoria')) {
            $query->where('categoria_id', $request->input('categoria'));
        }

        $productos = $query->orderBy('nombre', 'asc')->get();
        $categorias = Categoria::all(); 

        // Retornamos la vista home con los datos
        return view('cliente.home', compact('productos', 'categorias'));
    }

    /**
     * CATALOGO COMPLETO
     */
    public function productos(Request $request)
    {
        $query = Producto::with('categoria')->where('stock', '>', 0);

        if($request->filled('categoria')) {
            $query->where('categoria_id', $request->input('categoria'));
        }

        $productos = $query->orderBy('nombre', 'asc')->get();
        $categorias = Categoria::all(); // Para el filtro

        return view('cliente.productos', compact('productos', 'categorias'));
    }

    /**
     * VISTA DEL CARRITO
     */
    public function carrito()
    {
        $cart = request()->session()->get('cart', []);
        $cartDetails = [];
        $total = 0;

        foreach ($cart as $productId => $item) {
            $product = Producto::find($productId);
            if ($product) {
                $subtotal = $product->precio * ($item['quantity'] ?? 1);
                $total += $subtotal;
                
                $cartDetails[] = [
                    'producto' => $product,
                    'quantity' => $item['quantity'] ?? 1,
                    'subtotal' => $subtotal
                ];
            }
        }

        return view('cliente.carrito', compact('cartDetails', 'total'));
    }

    /**
     * AGREGAR AL CARRITO
     */
    public function agregarCarrito(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|integer|exists:productos,id',
        ]);

        // Si no esta logueado, lo mandamos al login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Inicia sesión para agregar productos.');
        }

        $producto = Producto::findOrFail($data['product_id']);

        if ($producto->stock <= 0) {
            return Redirect::back()->with('error', 'Producto agotado temporalmente.');
        }

        $cart = $request->session()->get('cart', []);
        $currentQuantity = isset($cart[$producto->id]) ? $cart[$producto->id]['quantity'] : 0;
        $newQuantity = $currentQuantity + 1;

        if ($newQuantity > $producto->stock) {
            return Redirect::back()->with('error', 'No hay suficiente stock disponible.');
        }

        $cart[$producto->id] = ['quantity' => $newQuantity];
        $request->session()->put('cart', $cart);

        return Redirect::back()->with('success', '¡Agregado al carrito!');
    }

    /**
     * PAGAR CARRITO (CON TRANSACCION)
     */
    public function pagarCarrito(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        if (empty($cart)) return Redirect::back()->with('error', 'El carrito está vacío');
        if (!Auth::check()) return redirect()->route('login');

        $user = Auth::user();
        $total = 0;
        $items = [];

        // 1. Validar Stock (Sin descontar aun)
        foreach ($cart as $productId => $entry) {
            $producto = Producto::find($productId);
            if (!$producto || $entry['quantity'] > $producto->stock) {
                return Redirect::back()->with('error', "Stock insuficiente para: " . ($producto->nombre ?? 'Producto'));
            }
            $subtotal = $producto->precio * $entry['quantity'];
            $total += $subtotal;
            $items[] = ['producto' => $producto, 'cantidad' => $entry['quantity'], 'subtotal' => $subtotal];
        }

        // 2. Transaccion
        DB::beginTransaction();
        try {
            $venta = Venta::create([
                'cliente_id' => $user->id,
                'total' => $total,
                'fecha' => now(),
                'metodo_pago' => 'Pago online',
                'estado' => 'pendiente' // Inicia pendiente
            ]);

            foreach ($items as $it) {
                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $it['producto']->id,
                    'cantidad' => $it['cantidad'],
                    'precio_unitario' => $it['producto']->precio,
                    'subtotal' => $it['subtotal'],
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with('error', 'Error: ' . $e->getMessage());
        }

        $request->session()->forget('cart');
        return Redirect::route('client.pedidos')->with('success', 'Pedido realizado con éxito. Estado: Pendiente.');
    }

    /**
     * HISTORIAL DE PEDIDOS DEL CLIENTE
     */
    public function misPedidos()
    {
        if (!Auth::check()) return redirect()->route('login');

        $pedidos = Venta::where('cliente_id', Auth::id())
                        ->with('detalles.producto')
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('cliente.pedidos.index', compact('pedidos'));
    }
}