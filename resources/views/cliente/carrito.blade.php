@extends('layouts.client')

@section('title', 'Tu Carrito')

@section('content')

    <div class="container mx-auto px-6 py-12">

        <div class="flex flex-col md:flex-row justify-between items-center mb-8 border-b pb-4">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center">
                <i class="fa-solid fa-cart-shopping mr-3 text-yellow-500"></i> Tu Carrito
            </h1>
            <div class="mt-4 md:mt-0 flex gap-3">
                @auth
                    <a href="{{ route('client.pedidos') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg shadow transition">
                        <i class="fa-solid fa-clock-rotate-left mr-2"></i> Historial de Pedidos
                    </a>
                @endauth
            </div>
        </div>

        @if (empty($cartDetails))
            {{-- ... resto del archivo igual ... --}}
            <div class="bg-white p-12 rounded-lg shadow text-center">
                <div class="mb-6">
                    <i class="fa-solid fa-basket-shopping text-6xl text-gray-200"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-600 mb-2">Tu carrito esta vacio</h2> <br>
                <a href="{{ route('client.home') }}"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-8 rounded-full shadow transition">
                    Ir al Menu
                </a>
            </div>
        @else
            <div class="flex flex-col lg:flex-row gap-8">

                <div class="lg:w-2/3">
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <table class="w-full text-left">
                            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                                <tr>
                                    <th class="py-4 px-6">Producto</th>
                                    <th class="py-4 px-6 text-center">Cantidad</th>
                                    <th class="py-4 px-6 text-right">Precio</th>
                                    <th class="py-4 px-6 text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($cartDetails as $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-4 px-6">
                                            <div class="flex items-center">
                                                <div
                                                    class="w-12 h-12 bg-gray-200 rounded overflow-hidden mr-4 flex-shrink-0">
                                                    <img src="{{ $item['producto']->imagen ? asset('storage/' . $item['producto']->imagen) : 'https://via.placeholder.com/100' }}"
                                                        class="w-full h-full object-cover">
                                                </div>
                                                <div>
                                                    <p class="font-bold text-gray-800">{{ $item['producto']->nombre }}</p>
                                                    <p class="text-xs text-gray-500">
                                                        {{ $item['producto']->categoria->nombre }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 text-center font-medium text-gray-700">
                                            {{ $item['quantity'] }}
                                        </td>
                                        <td class="py-4 px-6 text-right text-gray-600">
                                            $ {{ number_format($item['producto']->precio, 2) }}
                                        </td>
                                        <td class="py-4 px-6 text-right font-bold text-gray-800">
                                            $ {{ number_format($item['subtotal'], 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="lg:w-1/3">
                    <div class="bg-white rounded-lg shadow p-6 sticky top-24">
                        <h3 class="text-lg font-bold text-gray-800 mb-6">Resumen del Pedido</h3>

                        <div class="flex justify-between mb-4 text-gray-600">
                            <span>Subtotal</span>
                            <span>$ {{ number_format($total, 2) }}</span>
                        </div>
                        <div class="flex justify-between mb-6 pb-6 border-b border-gray-100 text-gray-600">
                            <span>Envío / Servicio</span>
                            <span class="text-green-600 font-bold">Gratis</span>
                        </div>

                        <div class="flex justify-between mb-8 text-xl font-bold text-gray-900">
                            <span>Total a Pagar</span>
                            <span>$ {{ number_format($total, 2) }}</span>
                        </div>

                        @auth
                            <form action="{{ route('client.carrito.pagar') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-4 rounded-lg shadow-lg transition transform hover:-translate-y-1">
                                    <i class="fa-solid fa-lock mr-2"></i> Confirmar Compra
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}"
                                class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg shadow transition">
                                Inicia Sesion para Pagar
                            </a>
                            <p class="text-sm text-center text-gray-500 mt-4">
                                ¿No tienes cuenta? <a href="{{ route('register') }}"
                                    class="text-blue-600 hover:underline">Registrate gratis</a>
                            </p>
                        @endauth
                    </div>
                </div>
            </div>
        @endif
    </div>

@endsection
