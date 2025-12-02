@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-gray-700 text-3xl font-medium">Gestion de Pedidos</h3>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white shadow-md rounded p-4 mb-6">
        <form method="GET" action="{{ route('admin.pedidos.index') }}" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-gray-700 text-sm font-bold mb-2">Buscar Cliente</label>
                <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Nombre..."
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="w-48">
                <label class="block text-gray-700 text-sm font-bold mb-2">Filtrar Estado</label>
                <select name="estado"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Todos</option>
                    <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="en_preparacion" {{ request('estado') == 'en_preparacion' ? 'selected' : '' }}>En
                        Preparacion</option>
                    <option value="completado" {{ request('estado') == 'completado' ? 'selected' : '' }}>Completado</option>
                    <option value="cancelado" {{ request('estado') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fa-solid fa-filter mr-2"></i> Filtrar
                </button>
                <a href="{{ route('admin.pedidos.index') }}"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-2 px-4 rounded">
                    Limpiar
                </a>
            </div>
        </form>
    </div>

    <div class="bg-white shadow-md rounded my-6 overflow-x-auto">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Folio</th>
                    <th class="py-3 px-6 text-left">Fecha</th>
                    <th class="py-3 px-6 text-left">Cliente</th>
                    <th class="py-3 px-6 text-center">Estado</th>
                    <th class="py-3 px-6 text-center">Metodo Pago</th>
                    <th class="py-3 px-6 text-right">Total</th>
                    <th class="py-3 px-6 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach ($ventas as $venta)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left whitespace-nowrap font-bold">#{{ $venta->id }}</td>
                        <td class="py-3 px-6 text-left">
                            {{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y') }}
                            <div class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($venta->fecha)->format('H:i') }}
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left">
                            <div class="font-medium">{{ $venta->cliente ? $venta->cliente->name : 'N/A' }}</div>
                        </td>

                        <td class="py-3 px-6 text-center">
                            @php
                                $colors = [
                                    'pendiente' => 'yellow',
                                    'en_preparacion' => 'blue',
                                    'completado' => 'green',
                                    'cancelado' => 'red',
                                ];
                                $color = $colors[$venta->estado] ?? 'gray';
                                $texto = ucfirst(str_replace('_', ' ', $venta->estado));
                            @endphp
                            <span
                                class="bg-{{ $color }}-100 text-{{ $color }}-800 py-1 px-3 rounded-full text-xs font-bold uppercase">
                                {{ $texto }}
                            </span>
                        </td>

                        <td class="py-3 px-6 text-center">{{ $venta->metodo_pago }}</td>
                        <td class="py-3 px-6 text-right font-bold text-gray-700">${{ number_format($venta->total, 2) }}
                        </td>
                        <td class="py-3 px-6 text-center">
                            <div class="flex item-center justify-center space-x-3">
                                <a href="{{ route('admin.pedidos.show', $venta->id) }}"
                                    class="bg-blue-600 text-white py-1 px-3 rounded text-xs font-bold hover:bg-blue-700 transition"
                                    title="Gestionar Pedido">
                                    Gestionar
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if ($ventas->isEmpty())
            <div class="p-6 text-center text-gray-500">
                No hay pedidos registrados con estos filtros.
            </div>
        @endif

        <div class="p-4">
            {{ $ventas->links() }}
        </div>
    </div>
@endsection
