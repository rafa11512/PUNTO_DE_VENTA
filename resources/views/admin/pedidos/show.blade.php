@extends('layouts.admin')

@section('content')
    <div class="max-w-6xl mx-auto">

        <div class="flex items-center justify-between mb-6">
            <h3 class="text-2xl font-semibold text-gray-700 flex items-center">
                <i class="fa-solid fa-file-invoice mr-3 text-blue-600"></i>
                Detalle de Pedido #{{ $venta->id }}
            </h3>
            <a href="{{ route('admin.pedidos.index') }}" class="text-gray-500 hover:text-blue-600 font-medium transition">
                <i class="fa-solid fa-arrow-left mr-1"></i> Volver a la lista
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 shadow rounded">
                <p class="font-bold">¡Éxito!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 shadow rounded">
                <p class="font-bold">Atencion!!!</p>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-6">

                <div class="bg-white shadow rounded-lg p-6 border-t-4 border-blue-500">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-bold tracking-wider">Cliente</p>
                            <p class="text-lg font-medium text-gray-800">{{ $venta->cliente->name ?? 'Cliente Eliminado' }}
                            </p>
                            <p class="text-sm text-gray-500">{{ $venta->cliente->email ?? '' }}</p>
                            <p class="text-sm text-gray-500">{{ $venta->cliente->telefono ?? 'Sin teléfono' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-400 uppercase font-bold tracking-wider">Fecha de Creacion</p>
                            <p class="text-lg font-medium text-gray-800">
                                {{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y') }}</p>
                            <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($venta->fecha)->format('h:i A') }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="bg-gray-50 px-6 py-3 border-b border-gray-200">
                        <h4 class="text-gray-700 font-bold">Productos Solicitados</h4>
                    </div>
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-gray-500 text-xs uppercase border-b bg-gray-50">
                                <th class="px-6 py-3">Producto</th>
                                <th class="px-6 py-3 text-center">Cant.</th>
                                <th class="px-6 py-3 text-right">Precio</th>
                                <th class="px-6 py-3 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($venta->detalles as $detalle)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            @if ($detalle->producto && $detalle->producto->imagen)
                                                <img src="{{ asset('storage/' . $detalle->producto->imagen) }}"
                                                    class="w-10 h-10 rounded object-cover mr-3 border">
                                            @else
                                                <div
                                                    class="w-10 h-10 bg-gray-200 rounded mr-3 flex items-center justify-center text-gray-400">
                                                    <i class="fa-solid fa-image"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="text-sm font-bold text-gray-800">
                                                    {{ $detalle->producto->nombre ?? 'Producto Eliminado' }}</p>
                                                @if ($detalle->producto)
                                                    <span
                                                        class="text-xs {{ $detalle->producto->stock < 5 ? 'text-red-500 font-bold' : 'text-green-600' }}">
                                                        (Stock actual: {{ $detalle->producto->stock }})
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center font-medium">{{ $detalle->cantidad }}</td>
                                    <td class="px-6 py-4 text-right text-gray-600">$
                                        {{ number_format($detalle->precio_unitario, 2) }}</td>
                                    <td class="px-6 py-4 text-right font-bold text-gray-800">$
                                        {{ number_format($detalle->subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-gray-50">
                                <td colspan="3" class="px-6 py-4 text-right font-bold text-gray-600 uppercase">Total a
                                    Pagar:</td>
                                <td class="px-6 py-4 text-right font-bold text-xl text-green-600">$
                                    {{ number_format($venta->total, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white shadow rounded-lg p-6 sticky top-6">
                    <h4 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Gestion del Pedido</h4>

                    <div class="mb-6 text-center">
                        <p class="text-sm text-gray-500 mb-1">Estado Actual:</p>
                        @php
                            $colors = [
                                'pendiente' => 'yellow',
                                'en_preparacion' => 'blue',
                                'completado' => 'green',
                                'cancelado' => 'red',
                            ];
                            $color = $colors[$venta->estado] ?? 'gray';
                        @endphp
                        <span
                            class="inline-block bg-{{ $color }}-100 text-{{ $color }}-800 text-lg font-bold px-4 py-2 rounded-full uppercase border border-{{ $color }}-200">
                            {{ str_replace('_', ' ', $venta->estado) }}
                        </span>
                    </div>

                    <form action="{{ route('admin.pedidos.estado', $venta->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <label class="block text-sm font-bold text-gray-700 mb-2">Cambiar estado a:</label>
                        <select name="estado"
                            class="w-full border border-gray-300 rounded-lg p-2.5 mb-4 focus:ring-2 focus:ring-blue-500 outline-none bg-gray-50">
                            <option value="pendiente" {{ $venta->estado == 'pendiente' ? 'selected' : '' }}> Pendiente
                            </option>
                            <option value="en_preparacion" {{ $venta->estado == 'en_preparacion' ? 'selected' : '' }}>
                                En Preparacion (Resta Stock)</option>
                            <option value="completado" {{ $venta->estado == 'completado' ? 'selected' : '' }}> Completado
                                / Entregado</option>
                            <option value="cancelado" {{ $venta->estado == 'cancelado' ? 'selected' : '' }}> Cancelado
                                (Devuelve Stock)</option>
                        </select>

                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg shadow transition transform active:scale-95">
                            Actualizar Estado
                        </button>
                    </form>

                    <div class="mt-6 text-xs text-gray-500 bg-gray-50 p-3 rounded border">
                        <p class="font-bold mb-1">></i> Notas:</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Al pasar a <b>En Preparacion</b> se descontara el stock.</li>
                            <li>Si <b>Cancelas</b>, el stock se devolvera automaticamente.</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
