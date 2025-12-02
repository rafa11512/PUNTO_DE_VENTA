@extends('layouts.admin')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <h3 class="text-gray-700 text-2xl font-medium">Pedido #{{ $venta->id }}</h3>
        <a href="{{ route('admin.pedidos.index') }}" class="text-sm text-slate-600 hover:text-slate-900">Volver a Pedidos</a>
    </div>

    <div class="bg-white shadow rounded p-6">
        <div class="grid grid-cols-2 gap-6">
            <div>
                <p><strong>Cliente:</strong> {{ $venta->cliente ? $venta->cliente->name : 'N/A' }}</p>
                <p><strong>Usuario:</strong> {{ $venta->usuario ? $venta->usuario->name : '-' }}</p>
                <p><strong>Método de pago:</strong> {{ $venta->metodo_pago }}</p>
                <p><strong>Total:</strong> $ {{ number_format($venta->total, 0, ',', '.') }}</p>
                <p><strong>Fecha:</strong> {{ $venta->fecha }}</p>
            </div>
            <div>
                <h4 class="font-semibold mb-2">Detalles</h4>
                <ul class="space-y-2">
                    @foreach($venta->detalles as $detalle)
                        <li class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gray-100 rounded"></div>
                            <div>
                                <div class="text-sm font-medium">{{ $detalle->producto ? $detalle->producto->nombre : 'Producto Eliminado' }}</div>
                                <div class="text-xs text-gray-500">Cantidad: {{ $detalle->cantidad ?? 1 }} | Precio: $ {{ number_format($detalle->precio_unitario ?? 0, 0, ',', '.') }} | Subtotal: $ {{ number_format($detalle->subtotal ?? 0, 0, ',', '.') }}</div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
