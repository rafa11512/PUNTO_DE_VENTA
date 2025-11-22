<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .nav-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
    </style>
</head>

<body class="bg-gray-100 font-sans antialiased">

    <div class="flex h-screen overflow-hidden">

        <aside class="w-64 bg-slate-900 text-white flex flex-col shadow-xl transition-all duration-300">

            <div class="h-16 flex items-center justify-center border-b border-slate-700 bg-slate-800">
                <h1 class="text-2xl font-bold text-blue-400">
                    <i class="fa-solid fa-corn mr-2"></i>🌽ELOTES EL WERO

                </h1>
            </div>

            <nav class="flex-1 overflow-y-auto py-4">
                <ul class="space-y-2 px-2">

                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                            class="nav-item flex items-center p-3 rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600' : '' }}">
                            <i class="fa-solid fa-gauge w-6 text-center"></i>
                            <span class="ml-3 font-medium">Dashboard</span>
                        </a>
                    </li>

                    <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider mt-4 mb-2 px-4">Gestión
                    </div>

                    <li>
                        <a href="{{ route('admin.clientes.index') }}"
                            class="nav-item flex items-center p-3 rounded-lg transition-colors {{ request()->routeIs('admin.clientes*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:text-white' }}">
                            <i class="fa-solid fa-users w-6 text-center"></i>
                            <span class="ml-3">Clientes</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.categorias.index') }}"
                            class="nav-item flex items-center p-3 rounded-lg transition-colors {{ request()->routeIs('admin.categorias*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:text-white' }}">
                            <i class="fa-solid fa-tags w-6 text-center"></i>
                            <span class="ml-3">Categorias</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.productos.index') }}"
                            class="nav-item flex items-center p-3 rounded-lg transition-colors {{ request()->routeIs('admin.productos*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:text-white' }}">
                            <i class="fa-solid fa-box-open w-6 text-center"></i>
                            <span class="ml-3">Productos</span>
                        </a>
                    </li>

                    <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider mt-4 mb-2 px-4">Ventas
                    </div>

                    <li>
                        <a href="#"
                            class="nav-item flex items-center p-3 rounded-lg text-slate-300 hover:text-white transition-colors">
                            <i class="fa-solid fa-cart-shopping w-6 text-center"></i>
                            <span class="ml-3">Pedidos</span>
                        </a>
                    </li>

                </ul>
            </nav>

            <div class="border-t border-slate-700 p-4 bg-slate-800">
                <div class="flex items-center">
                    <div
                        class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-400">Administrador</p>
                    </div>
                </div>

                <form action="{{ route('logout') }}" method="POST" class="mt-3">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center px-4 py-2 text-sm text-red-400 bg-slate-700 hover:bg-red-500 hover:text-white rounded transition-colors">
                        <i class="fa-solid fa-right-from-bracket mr-2"></i> Cerrar Sesion
                    </button>
                </form>
            </div>
        </aside>

        <!-------------------- Parte donde se insertara dinamicamente las secciones de admin.cliente/categorias/productos ------------------>
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
            <div class="container mx-auto px-6 py-8">
                @yield('content')
            </div>
        </main>

    </div>

</body>

</html>
