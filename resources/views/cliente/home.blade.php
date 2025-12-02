@extends('layouts.client')

@section('title', 'Inicio')

@section('content')


    <!--- Banner Principal --->
    <div class="bg-gray-900 py-8">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-3xl font-bold text-white">Menu Principal</h1>
            <p class="text-gray-400 text-sm mt-1">Escoge tus favoritos</p>
        </div>
    </div>





    <div class="container mx-auto px-6 py-8">
        <div class="flex flex-col md:flex-row gap-8">



            <!--- Sidebar de categorias --->
            <aside class="w-full md:w-1/4">
                <div class="bg-white rounded-lg shadow p-6 sticky top-24">
                    <h3 class="font-bold text-gray-800 text-lg mb-4 border-b pb-2">Categorias</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('client.home') }}"
                                class="block px-4 py-2 rounded transition {{ !request('categoria') ? 'bg-yellow-500 text-white font-bold' : 'text-gray-600 hover:bg-gray-100' }}">
                                Todo el Menu
                            </a>
                        </li>
                        @foreach ($categorias as $cat)
                            <li>
                                <a href="{{ route('client.home', ['categoria' => $cat->id]) }}"
                                    class="block px-4 py-2 rounded transition {{ request('categoria') == $cat->id ? 'bg-yellow-500 text-white font-bold' : 'text-gray-600 hover:bg-gray-100' }}">
                                    {{ $cat->nombre }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </aside>



            <!--- Lista de productos --->
            <main class="w-full md:w-3/4">
                @if ($productos->isEmpty())
                    <div class="bg-white p-12 rounded shadow text-center">
                        <i class="fa-solid fa-cookie-bite text-6xl text-gray-300 mb-4"></i>
                        <h3 class="text-xl font-bold text-gray-600">No encontramos productos aqui</h3>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($productos as $producto)
                            <div
                                class="bg-white rounded-lg shadow hover:shadow-lg transition duration-300 overflow-hidden flex flex-col">
                                <div class="h-48 overflow-hidden relative group">
                                    <img src="{{ $producto->imagen ? asset('storage/' . $producto->imagen) : 'https://via.placeholder.com/400x300?text=Sin+Imagen' }}"
                                        class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                                    <span
                                        class="absolute top-2 left-2 bg-black bg-opacity-70 text-white text-xs px-2 py-1 rounded">
                                        {{ $producto->categoria->nombre }}
                                    </span>
                                </div>
                                <div class="p-5 flex-grow flex flex-col justify-between">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-800 mb-1">{{ $producto->nombre }}</h3>
                                        <p class="text-sm text-gray-500 mb-3 line-clamp-2">{{ $producto->descripcion }}</p>
                                    </div>
                                    <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                                        <div class="flex flex-col">
                                            <span class="text-xs text-gray-400">Precio</span>
                                            <span class="text-xl font-bold text-gray-900">$
                                                {{ number_format($producto->precio, 0) }}</span>
                                        </div>
                                        @if ($producto->stock > 0)
                                            <form action="{{ route('client.carrito.agregar') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $producto->id }}">
                                                <button type="submit"
                                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-full font-bold text-sm shadow transition hover:-translate-y-1">
                                                    Agregar <i class="fa-solid fa-cart-plus ml-1"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span
                                                class="bg-red-100 text-red-600 px-3 py-1 rounded text-xs font-bold uppercase">Agotado</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </main>




        </div>
    </div>

    <!---Seccion Acerca de--->
    <section id="acerca" class="py-16 bg-white border-t mt-8">
        <div class="container mx-auto px-6 flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 mb-10 md:mb-0">
                <img src="https://images.unsplash.com/photo-1567121938596-3d2b271cb4a8?q=80&w=800&auto=format&fit=crop"
                    class="rounded-lg shadow-2xl transform -rotate-2 hover:rotate-0 transition duration-500">
            </div>
            <div class="md:w-1/2 md:pl-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Sobre Elotes El Wero</h2>
                <p class="text-gray-600 mb-6 leading-relaxed">
                    Fundado con la pasion por los antojitos mexicanos, Elotes El Wero ofrece los mejores elotes y esquites
                    de la region.
                </p>
            </div>
        </div>
    </section>

@endsection
