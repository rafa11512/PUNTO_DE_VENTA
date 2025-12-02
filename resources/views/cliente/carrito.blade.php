<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuestra Tienda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50 font-sans">

    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">

            <!-- IZQUIERDA -->
            <a href="{{ route('client.home') }}"
                class="text-xl font-bold text-gray-800 flex items-center hover:text-yellow-600 transition">
                <i class="fa-solid fa-wheat-awn text-yellow-500 mr-2 text-2xl"></i>
                ELOTES EL WERO
            </a>

            <!-- CENTRO -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('client.home') }}"
                    class="text-gray-600 font-medium hover:text-blue-600 transition duration-300 border-b-2 border-transparent hover:border-blue-600">
                    Inicio
                </a>
                <a href="{{ route('client.productos') }}"
                    class="text-gray-600 font-medium hover:text-blue-600 transition duration-300 border-b-2 border-transparent hover:border-blue-600">
                    Productos
                </a>
                <a href="{{ route('client.carrito') }}"
                    class="text-gray-600 font-medium hover:text-blue-600 transition duration-300 border-b-2 border-transparent hover:border-blue-600">
                    Carrito
                </a>
            </div>

            <!-- DERECHA -->
            <div class="flex items-center space-x-4">

                @auth
                    <!-- Usuario Logueado -->
                    <div class="flex items-center space-x-3">
                        <div class="hidden md:block text-right">
                            <span class="block text-sm font-semibold text-gray-700">{{ Auth::user()->name }}</span>
                            <span class="block text-xs text-green-500">En linea</span>
                        </div>
                        <i class="fa-solid fa-user-circle text-3xl text-blue-500"></i>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="ml-2 text-red-500 hover:text-red-700 transition text-sm font-semibold border border-red-200 hover:border-red-400 rounded px-3 py-1">
                                <i class="fa-solid fa-right-from-bracket mr-1"></i> Cerrar Sesion
                            </button>
                        </form>
                    </div>
                @else
                    <!-- Usuario Visitante -->
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('login') }}" class="text-gray-600 font-medium hover:text-blue-600 transition">
                            Ingresar
                        </a>
                        <a href="{{ route('register') }}"
                            class="bg-blue-600 text-white px-5 py-2 rounded-full font-medium hover:bg-blue-700 transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            Registrarse
                        </a>
                    </div>
                @endguest

            </div>
        </div>
    </nav>

    <!-- CONTENIDO PRINCIPAL -->
    <div class="container mx-auto px-6 py-12">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
        @endif
        <h1 class="text-2xl font-semibold mb-6">CARRITO</h1>

        @if(isset($cartDetails) && count($cartDetails) > 0)
            <div class="bg-white shadow rounded p-6">
                <table class="w-full text-left">
                    <thead>
                        <tr>
                            <th class="pb-2">Producto</th>
                            <th class="pb-2">Precio</th>
                            <th class="pb-2">Cantidad</th>
                            <th class="pb-2">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach($cartDetails as $item)
                            @php
                                $prod = $item['producto'];
                                $quantity = $item['quantity'];
                                $subtotal = $prod->precio * $quantity;
                                $total += $subtotal;
                            @endphp
                            <tr class="border-t">
                                <td class="py-3">
                                    <div class="flex items-center gap-4">
                                        <img src="{{ $prod->imagen ? asset('storage/' . $prod->imagen) : 'https://via.placeholder.com/80' }}" alt="{{ $prod->nombre }}" class="w-20 h-20 object-cover rounded">
                                        <div>
                                            <div class="font-semibold">{{ $prod->nombre }}</div>
                                            <div class="text-sm text-gray-500">{{ $prod->categoria ? $prod->categoria->nombre : '' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3">$ {{ number_format($prod->precio, 0, ',', '.') }}</td>
                                <td class="py-3">{{ $quantity }}</td>
                                <td class="py-3">$ {{ number_format($subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-right mt-4 font-bold">Total: $ {{ number_format($total, 0, ',', '.') }}</div>
                <div class="text-right mt-3">
                    @auth
                        <form action="{{ route('client.carrito.pagar') }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">Pagar Carrito</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-500">Inicia sesión para pagar</a>
                    @endauth
                </div>
            </div>
        @else
            <div class="bg-white shadow rounded p-6 text-gray-600">No hay productos en el carrito.</div>
        @endif
    </div>

</body>

</html>
