<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuestra Tienda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .products-section {
            max-width: 1400px;
            margin: 0 auto;
        }

        .section-title {
            font-size: 24px;
            color: #333;
            margin-bottom: 30px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .products-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }

        .product-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
        }

        .product-image {
            width: 100%;
            height: 280px;
            object-fit: cover;
            background-color: #f8f8f8;
        }

        .product-info {
            padding: 20px;
        }

        .product-name {
            font-size: 15px;
            color: #333;
            margin-bottom: 12px;
            line-height: 1.4;
            font-weight: 500;
            min-height: 42px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-description {
            font-size: 13px;
            color: #6b7280; /* Tailwind gray-500 */
            margin-bottom: 12px;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 3; /* show up to 3 lines */
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-price {
            font-size: 28px;
            color: #333;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .availability {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }

        .available {
            background-color: #e8f5e9;
            color: #2e7d32;
        }

        /* Botón agregar al carrito para productos disponibles */
        .agregar-carrito {
            display: inline-block;
            background-color: #9ca3af; /* gris tono */
            color: #111827; /* gris oscuro */
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
        }
        .agregar-carrito:hover {
            background-color: #6b7280;
        }

        .unavailable {
            background-color: #ffebee;
            color: #c62828;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .products-container {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 900px) {
            .products-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .products-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
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

    <div class="products-section">
        <h2 class="section-title">Nuestros Productos</h2>
        
        @if(session('success'))
            <div class="container mx-auto px-6 py-4">
                <div class="p-4 bg-green-100 text-green-800 rounded mb-4">{{ session('success') }}</div>
            </div>
        @endif
        @if(session('error'))
            <div class="container mx-auto px-6 py-4">
                <div class="p-4 bg-red-100 text-red-800 rounded mb-4">{{ session('error') }}</div>
            </div>
        @endif

        <div class="products-container" id="productsContainer">
            @if(isset($productos) && $productos->count() > 0)
                @foreach($productos as $producto)
                    <div class="product-card">
                        <img src="{{ $producto->imagen ? asset('storage/' . $producto->imagen) : 'https://via.placeholder.com/400' }}"
                             alt="{{ $producto->nombre }}"
                             class="product-image">
                        <div class="product-info">
                            <h3 class="product-name">{{ $producto->nombre }}</h3>
                            <p class="product-description">{{ $producto->descripcion ?? '' }}</p>
                            <p class="product-price">$ {{ number_format($producto->precio, 0, ',', '.') }}</p>
                            @if($producto->stock > 0)
                                <form method="POST" action="{{ route('client.carrito.agregar') }}">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $producto->id }}">
                                    <button type="submit" class="agregar-carrito">Agregar al carrito</button>
                                </form>
                            @else
                                <span class="availability unavailable">No disponible</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-gray-500">No hay productos disponibles por el momento.</div>
            @endif
        </div>
    </div>

    

</body>

</html>
