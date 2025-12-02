@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-gray-700 text-3xl font-medium">Gestión de Pedidos</h3>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Filtros -->
    <div class="bg-white shadow-md rounded p-4 mb-6">
        <form method="GET" action="{{ route('admin.pedidos.index') }}" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-gray-700 text-sm font-bold mb-2">Buscar por cliente</label>
                <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Nombre del cliente..."
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="w-48">
                <label class="block text-gray-700 text-sm font-bold mb-2">Método de pago</label>
                <select name="metodo"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Todos</option>
                    <option value="Pago online" {{ request('metodo') == 'Pago online' ? 'selected' : '' }}>Pago online</option>
                    <option value="Efectivo" {{ request('metodo') == 'Efectivo' ? 'selected' : '' }}>Efectivo</option>
                </select>
            </div>

            <div class="w-44">
                <label class="block text-gray-700 text-sm font-bold mb-2">Fecha inicio</label>
                <input type="date" name="fecha_inicio" value="{{ request('fecha_inicio') }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="w-44">
                <label class="block text-gray-700 text-sm font-bold mb-2">Fecha fin</label>
                <input type="date" name="fecha_fin" value="{{ request('fecha_fin') }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fa-solid fa-search mr-2"></i> Buscar
                </button>
                <a href="{{ route('admin.pedidos.index') }}"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-2 px-4 rounded">
                    <i class="fa-solid fa-times mr-2"></i> Limpiar
                </a>
            </div>
        </form>
    </div>

    <div class="bg-white shadow-md rounded my-6 overflow-x-auto">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">ID</th>
                    <th class="py-3 px-6 text-left">Cliente</th>
                    <th class="py-3 px-6 text-left">Usuario</th>
                    <th class="py-3 px-6 text-left">Método</th>
                    <th class="py-3 px-6 text-right">Total</th>
                    <th class="py-3 px-6 text-left">Fecha</th>
                    <th class="py-3 px-6 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach ($ventas as $venta)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left whitespace-nowrap font-bold">#{{ $venta->id }}</td>
                        <td class="py-3 px-6 text-left">{{ $venta->cliente ? $venta->cliente->name : 'N/A' }}</td>
                        <td class="py-3 px-6 text-left">{{ $venta->usuario ? $venta->usuario->name : '-' }}</td>
                        <td class="py-3 px-6 text-left">{{ $venta->metodo_pago }}</td>
                        <td class="py-3 px-6 text-right">${{ number_format($venta->total, 2) }}</td>
                        <td class="py-3 px-6 text-left">{{ $venta->fecha }}</td>
                        <td class="py-3 px-6 text-center">
                            <div class="flex item-center justify-center space-x-3">
                                <a href="{{ route('admin.pedidos.show', $venta->id) }}" class="w-6 transform hover:text-blue-500 hover:scale-110 transition-transform" title="Ver">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if ($ventas->isEmpty())
            <div class="p-6 text-center text-gray-500">
                No hay pedidos registrados aún.
            </div>
        @endif

        <div class="p-4">
            {{ $ventas->links() }}
        </div>
    </div>
@endsection