@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-gray-700 text-3xl font-medium">Gestión de Productos</h3>

        <a href="{{ route('admin.productos.create') }}"
            class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-2 px-4 rounded shadow">
            <i class="fa-solid fa-plus mr-2"></i> Nuevo Producto
        </a>
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
        <form method="GET" action="{{ route('admin.productos.index') }}" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-gray-700 text-sm font-bold mb-2">Buscar por nombre</label>
                <input type="text" name="buscar" value="{{ request('buscar') }}"
                    placeholder="Nombre del producto..."
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="w-48">
                <label class="block text-gray-700 text-sm font-bold mb-2">Categoría</label>
                <select name="categoria"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Todas las categorías</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}" {{ request('categoria') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    <i class="fa-solid fa-search mr-2"></i> Buscar
                </button>
                <a href="{{ route('admin.productos.index') }}"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
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
                    <th class="py-3 px-6 text-left">Imagen</th>
                    <th class="py-3 px-6 text-left">Nombre</th>
                    <th class="py-3 px-6 text-left">Categoría</th>
                    <th class="py-3 px-6 text-right">Costo</th>
                    <th class="py-3 px-6 text-right">Precio</th>
                    <th class="py-3 px-6 text-center">Stock</th>
                    <th class="py-3 px-6 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach ($productos as $producto)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left whitespace-nowrap font-bold">{{ $producto->id }}</td>
                        <td class="py-3 px-6 text-left">
                            @if($producto->imagen)
                                <img src="{{ asset('storage/' . $producto->imagen) }}"
                                     alt="{{ $producto->nombre }}"
                                     class="h-12 w-12 object-cover rounded">
                            @else
                                <div class="h-12 w-12 bg-gray-200 rounded flex items-center justify-center">
                                    <i class="fa-solid fa-image text-gray-400"></i>
                                </div>
                            @endif
                        </td>
                        <td class="py-3 px-6 text-left">
                            <div class="font-medium">{{ $producto->nombre }}</div>
                            @if($producto->descripcion)
                                <div class="text-xs text-gray-500">{{ Str::limit($producto->descripcion, 50) }}</div>
                            @endif
                        </td>
                        <td class="py-3 px-6 text-left">
                            <span class="bg-purple-100 text-purple-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                {{ $producto->categoria->nombre }}
                            </span>
                        </td>
                        <td class="py-3 px-6 text-right">${{ number_format($producto->costo, 2) }}</td>
                        <td class="py-3 px-6 text-right font-semibold text-green-600">
                            ${{ number_format($producto->precio, 2) }}
                        </td>
                        <td class="py-3 px-6 text-center">
                            @if($producto->stock <= 5)
                                <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                    {{ $producto->stock }}
                                </span>
                            @elseif($producto->stock <= 20)
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                    {{ $producto->stock }}
                                </span>
                            @else
                                <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                    {{ $producto->stock }}
                                </span>
                            @endif
                        </td>
                        <td class="py-3 px-6 text-center">
                            <div class="flex item-center justify-center space-x-3">

                                <a href="{{ route('admin.productos.edit', $producto->id) }}"
                                    class="w-6 transform hover:text-blue-500 hover:scale-110 transition-transform"
                                    title="Editar">
                                    <i class="fa-solid fa-pen"></i>
                                </a>

                                <form action="{{ route('admin.productos.destroy', $producto->id) }}" method="POST"
                                    onsubmit="return confirm('¿Estás seguro de eliminar este producto?');"
                                    class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-6 transform hover:text-red-500 hover:scale-110 transition-transform text-gray-600"
                                        title="Eliminar">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if ($productos->isEmpty())
            <div class="p-6 text-center text-gray-500">
                No hay productos registrados aún. Agrega uno para comenzar a vender.
            </div>
        @endif
    </div>
@endsection
