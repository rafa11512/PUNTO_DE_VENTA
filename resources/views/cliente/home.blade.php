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
                <a href="#"
                    class="text-gray-600 font-medium hover:text-blue-600 transition duration-300 border-b-2 border-transparent hover:border-blue-600">
                    Productos
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
        <h1>BIENVENIDO</h1>
    </div>

</body>

</html>
