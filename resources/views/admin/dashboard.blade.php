@extends('layouts.admin')

@section('content')
    <h3 class="text-gray-700 text-3xl font-medium">Dashboard Principal</h3>

    <div class="mt-4">
        <div class="flex flex-wrap -mx-6">

            <div class="w-full px-6 sm:w-1/2 xl:w-1/3">
                <div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white border-l-4 border-indigo-500">
                    <div class="p-3 rounded-full bg-indigo-600 bg-opacity-75">
                        <i class="fa-solid fa-users text-white text-2xl"></i>
                    </div>
                    <div class="mx-5">
                        <h4 class="text-2xl font-semibold text-gray-700">{{ $clientesCount }}</h4>
                        <div class="text-gray-500">Clientes Registrados</div>
                    </div>
                </div>
            </div>

            <div class="w-full px-6 sm:w-1/2 xl:w-1/3 mt-6 sm:mt-0">
                <div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white border-l-4 border-orange-500">
                    <div class="p-3 rounded-full bg-orange-600 bg-opacity-75">
                        <i class="fa-solid fa-box text-white text-2xl"></i>
                    </div>
                    <div class="mx-5">
                        <h4 class="text-2xl font-semibold text-gray-700">{{ $productosCount }}</h4>
                        <div class="text-gray-500">Productos Totales</div>
                    </div>
                </div>
            </div>

            <div class="w-full px-6 sm:w-1/2 xl:w-1/3 mt-6 xl:mt-0">
                <div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white border-l-4 border-emerald-500">
                    <div class="p-3 rounded-full bg-emerald-600 bg-opacity-75">
                        <i class="fa-solid fa-money-bill-wave text-white text-2xl"></i>
                    </div>
                    <div class="mx-5">
                        <h4 class="text-2xl font-semibold text-gray-700">$ {{ number_format($ventasMes, 2) }}</h4>
                        <div class="text-gray-500">Ventas este Mes</div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="mt-8">
        <div class="flex justify-between items-center mb-4">
            <h4 class="text-gray-600 text-xl font-medium">Pedidos Recientes</h4>
            <a href="{{ route('admin.pedidos.index') }}" class="text-blue-500 hover:underline text-sm">Ver todos los
                pedidos</a>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Folio
                        </th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Cliente
                        </th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Estado
                        </th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Total
                        </th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Accion
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pedidosRecientes as $pedido)
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap font-bold">#{{ $pedido->id }}</p>
                                <p class="text-gray-500 text-xs">
                                    {{ \Carbon\Carbon::parse($pedido->fecha)->diffForHumans() }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <div class="flex items-center">
                                    <div class="ml-3">
                                        <p class="text-gray-900 whitespace-no-wrap font-medium">
                                            {{ $pedido->cliente->name ?? 'Cliente Eliminado' }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                                @php
                                    $colors = [
                                        'pendiente' => 'yellow',
                                        'en_preparacion' => 'blue',
                                        'completado' => 'green',
                                        'cancelado' => 'red',
                                    ];
                                    $color = $colors[$pedido->estado] ?? 'gray';
                                    $texto = ucfirst(str_replace('_', ' ', $pedido->estado));
                                @endphp
                                <span
                                    class="relative inline-block px-3 py-1 font-semibold text-{{ $color }}-900 leading-tight">
                                    <span aria-hidden
                                        class="absolute inset-0 bg-{{ $color }}-200 opacity-50 rounded-full"></span>
                                    <span class="relative">{{ $texto }}</span>
                                </span>
                            </td>
                            <td
                                class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-right font-bold text-gray-700">
                                $ {{ number_format($pedido->total, 2) }}
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                                <a href="{{ route('admin.pedidos.show', $pedido->id) }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-xs transition">
                                    Gestionar
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-5 bg-white text-center text-gray-500">
                                No hay pedidos recientes.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
