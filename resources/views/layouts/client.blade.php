<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elotes El Wero - @yield('title', 'Inicio')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .scroll-smooth {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans flex flex-col min-h-screen">

    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('client.home') }}"
                class="text-2xl font-bold text-gray-800 flex items-center hover:text-yellow-600 transition">
                <i class="fa-solid fa-wheat-awn text-yellow-500 mr-2"></i>
                ELOTES EL WERO
            </a>

            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('client.home') }}" class="text-gray-600 font-medium hover:text-yellow-600">Inicio</a>
                <a href="{{ route('client.home') }}#acerca"
                    class="text-gray-600 font-medium hover:text-yellow-600">Acerca de</a>
            </div>

            <div class="flex items-center space-x-6">
                <a href="{{ route('client.carrito') }}" class="relative text-gray-600 hover:text-yellow-600 transition">
                    <i class="fa-solid fa-cart-shopping text-2xl"></i>
                    @if (session('cart'))
                        <span
                            class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full">
                            {{ count(session('cart')) }}
                        </span>
                    @endif
                </a>

                @auth
                    <div class="relative group h-full flex items-center">
                        <button class="flex items-center text-gray-600 hover:text-blue-600 focus:outline-none py-4">
                            <span class="mr-2 font-semibold hidden sm:block">{{ Auth::user()->name }}</span>
                            <i class="fa-solid fa-user-circle text-3xl"></i>
                        </button>

                        <div
                            class="absolute top-full right-0 w-48 bg-white rounded-b-md shadow-lg py-2 hidden group-hover:block hover:block transition-all duration-200 border-t border-gray-100 z-50">
                            <div class="absolute -top-2 left-0 w-full h-2 bg-transparent"></div> <a
                                href="{{ route('client.pedidos') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fa-solid fa-clock-rotate-left mr-2"></i> Mis Pedidos
                            </a>
                            <form action="{{ route('logout') }}" method="POST" class="block">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    <i class="fa-solid fa-right-from-bracket mr-2"></i> Cerrar Sesion
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 font-medium hover:text-blue-600">Ingresar</a>
                    <a href="{{ route('register') }}"
                        class="bg-yellow-500 text-white px-5 py-2 rounded-full font-medium hover:bg-yellow-600 transition shadow">
                        Registrarse
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!---Contenedor principal--->
    <main class="flex-grow">
        @if (session('success'))
            <div class="container mx-auto mt-4 px-6">
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        @endif
        @if (session('error'))
            <div class="container mx-auto mt-4 px-6">
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-gray-900 text-white pb-6 mt-12">
        <div class="border-t border-gray-800 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} Elotes El Wero. Todos los derechos reservados.
        </div>
    </footer>

</body>

</html>
