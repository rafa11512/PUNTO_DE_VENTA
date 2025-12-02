@extends('layouts.client')

@section('title', 'Mis Pedidos')

@section('content')
    <div class="container mx-auto px-6 py-12">
        <h2 class="text-3xl font-bold text-gray-800 mb-8 border-b pb-4">Historial de Pedidos</h2>

        @if ($pedidos->isEmpty())
            <div class="bg-white p-12 rounded-lg shadow text-center">
                <i class="fa-solid fa-box-open text-6xl text-gray-300 mb-4"></i>
                <p class="text-xl text-gray-500 mb-6">Aun no has realizado ninguna compra</p>
                <a href="{{ route('client.productos') }}"
                    class="bg-yellow-500 text-white px-6 py-2 rounded-full font-bold hover:bg-yellow-600">Ir a comprar</a>
            </div>
        @else
            <div class="grid gap-6">
                @foreach ($pedidos as $pedido)
                    <div class="bg-white rounded-lg shadow-md border border-gray-100 overflow-hidden">
                        <div class="bg-gray-50 p-4 border-b border-gray-100 flex flex-wrap justify-between items-center">
                            <div>
                                <span class="text-xs text-gray-500 uppercase font-bold">Pedido #{{ $pedido->id }}</span>
                                <p class="text-sm text-gray-600">{{ $pedido->fecha }}</p>
                            </div>
                            <div class="flex items-center space-x-4">
                                <span class="text-lg font-bold text-gray-800">$
                                    {{ number_format($pedido->total, 2) }}</span>

                                @php
                                    $color = 'gray';
                                    if ($pedido->estado == 'pendiente') {
                                        $color = 'yellow';
                                    }
                                    if ($pedido->estado == 'en_preparacion') {
                                        $color = 'blue';
                                    }
                                    if ($pedido->estado == 'completado') {
                                        $color = 'green';
                                    }
                                    if ($pedido->estado == 'cancelado') {
                                        $color = 'red';
                                    }

                                    $texto = ucfirst(str_replace('_', ' ', $pedido->estado));
                                @endphp
                                <span
                                    class="bg-{{ $color }}-100 text-{{ $color }}-800 text-xs font-bold px-3 py-1 rounded-full uppercase">
                                    {{ $texto }}
                                </span>
                            </div>
                        </div>

                        <div class="p-4">
                            <ul class="divide-y divide-gray-100">
                                @foreach ($pedido->detalles as $detalle)
                                    <li class="py-3 flex justify-between items-center">
                                        <div class="flex items-center">
                                            <div class="w-12 h-12 bg-gray-200 rounded mr-4 flex-shrink-0 overflow-hidden">
                                                @if ($detalle->producto && $detalle->producto->imagen)
                                                    <img src="{{ asset('storage/' . $detalle->producto->imagen) }}"
                                                        class="w-full h-full object-cover">
                                                @else
                                                    <div class="flex items-center justify-center h-full text-gray-400"><i
                                                            class="fa-solid fa-corn"></i></div>
                                                @endif
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-800">
                                                    {{ $detalle->producto ? $detalle->producto->nombre : 'Producto no disponible' }}
                                                </p>
                                                <p class="text-xs text-gray-500">{{ $detalle->cantidad }} x
                                                    ${{ number_format($detalle->precio_unitario, 2) }}</p>
                                            </div>
                                        </div>
                                        <span class="font-semibold text-gray-700">$
                                            {{ number_format($detalle->subtotal, 2) }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
