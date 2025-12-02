<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Producto;

class ClientController extends Controller
{
    public function index()
    {
        return view('cliente.home'); // Retorna la vista de la tienda
    }

    public function productos()
    {
        // Obtener productos desde la base de datos y enviarlos a la vista
        $productos = Producto::with('categoria')->orderBy('nombre', 'asc')->get();
        return view('cliente.productos', compact('productos'));
    }

    public function carrito()
    {
        // Mostrar los items del carrito almacenados en la sesión
        // session structure: ['product_id' => ['quantity' => 1], ...]
        // Map product ids to product models
        $cart = request()->session()->get('cart', []);
        $cartDetails = [];
        foreach ($cart as $productId => $item) {
            $product = Producto::find($productId);
            if ($product) {
                $cartDetails[] = [
                    'producto' => $product,
                    'quantity' => $item['quantity'] ?? 1
                ];
            }
        }

        return view('cliente.carrito', compact('cartDetails'));
    }

    /**
     * Agrega un producto al carrito (simple, basado en sesión).
     */
    public function agregarCarrito(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|integer|exists:productos,id',
        ]);

        $producto = Producto::findOrFail($data['product_id']);

        if ($producto->stock <= 0) {
            return Redirect::back()->with('error', 'Producto no disponible');
        }

        $cart = $request->session()->get('cart', []);

        $currentQuantity = isset($cart[$producto->id]) ? $cart[$producto->id]['quantity'] : 0;
        $newQuantity = $currentQuantity + 1;

        // No superar el stock disponible
        if ($newQuantity > $producto->stock) {
            return Redirect::back()->with('error', 'No hay suficiente stock disponible');
        }

        $cart[$producto->id] = [
            'quantity' => $newQuantity
        ];

        $request->session()->put('cart', $cart);

        return Redirect::back()->with('success', 'Producto agregado al carrito');
    }

    /**
     * Pagar el carrito: crea una Venta y DetalleVenta por cada item del carrito,
     * descuenta stock y limpia la sesión del carrito.
     */
    public function pagarCarrito(Request $request)
    {
        // Validar que exista carrito
        $cart = $request->session()->get('cart', []);
        if (empty($cart)) {
            return Redirect::back()->with('error', 'El carrito está vacío');
        }

        // Verificar que el usuario esté autenticado
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para pagar');
        }

        $user = Auth::user();

        // Construir el pedido: comprobar stock y calcular total
        $total = 0;
        $items = [];
        foreach ($cart as $productId => $entry) {
            $cantidad = isset($entry['quantity']) ? intval($entry['quantity']) : 1;
            $producto = Producto::find($productId);
            if (!$producto) {
                return Redirect::back()->with('error', 'Un producto en el carrito no existe');
            }
            if ($cantidad > $producto->stock) {
                return Redirect::back()->with('error', "No hay suficiente stock para el producto: {$producto->nombre}");
            }
            $subtotal = $producto->precio * $cantidad;
            $total += $subtotal;
            $items[] = [
                'producto' => $producto,
                'cantidad' => $cantidad,
                'subtotal' => $subtotal,
            ];
        }

        // Crear venta y detalles dentro de una transacción
        DB::beginTransaction();
        try {
            $venta = Venta::create([
                'cliente_id' => $user->id,
                'usuario_id' => null,
                'total' => $total,
                'fecha' => now(),
                'metodo_pago' => 'Pago online',
            ]);

            foreach ($items as $it) {
                // Crear el detalle con la columna producto_id (migrations)
                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $it['producto']->id,
                    'cantidad' => $it['cantidad'],
                    'precio_unitario' => $it['producto']->precio,
                    'subtotal' => $it['subtotal'],
                ]);

                // Descontar stock
                $it['producto']->stock = $it['producto']->stock - $it['cantidad'];
                $it['producto']->save();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with('error', 'Error al crear el pedido: ' . $e->getMessage());
        }

        // Limpiar carrito
        $request->session()->forget('cart');

        return Redirect::route('client.carrito')->with('success', 'Compra realizada. Tu pedido fue registrado correctamente.');
    }
}