@extends('layouts.admin')

@section('content')

    <div class="max-w-4xl mx-auto bg-white p-8 rounded shadow">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-700">Editar Producto: {{ $producto->nombre }}</h2>
            <a href="{{ route('admin.productos.index') }}" class="text-gray-500 hover:text-gray-700">
                <i class="fa-solid fa-arrow-left"></i> Volver
            </a>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded mb-6">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nombre del Producto <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="nombre" value="{{ old('nombre', $producto->nombre) }}" required
                        placeholder="Ej: Elote con queso, Esquite grande, Refresco..."
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Categoria <span
                            class="text-red-500">*</span></label>
                    <select name="categoria_id" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500">
                        <option value="">Selecciona una categoria</option>
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id }}"
                                {{ old('categoria_id', $producto->categoria_id) == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Stock Actual <span
                            class="text-red-500">*</span></label>
                    <input type="number" name="stock" value="{{ old('stock', $producto->stock) }}" required
                        min="0"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500">
                    <p class="text-gray-500 text-xs mt-1">Cantidad disponible en inventario</p>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Costo <span
                            class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">$</span>
                        <input type="number" name="costo" value="{{ old('costo', $producto->costo) }}" required
                            min="0" step="0.01"
                            class="shadow appearance-none border rounded w-full py-2 pl-7 pr-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500">
                    </div>
                    <p class="text-gray-500 text-xs mt-1">Costo de produccion o compra</p>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Precio de Venta <span
                            class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">$</span>
                        <input type="number" name="precio" value="{{ old('precio', $producto->precio) }}" required
                            min="0" step="0.01"
                            class="shadow appearance-none border rounded w-full py-2 pl-7 pr-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500">
                    </div>
                    <p class="text-gray-500 text-xs mt-1">Precio al que se vende al cliente</p>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Descripcion</label>
                    <textarea name="descripcion" rows="3" placeholder="Descripción detallada del producto"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500">{{ old('descripcion', $producto->descripcion) }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Imagen del Producto</label>

                    @if ($producto->imagen)
                        <div class="mb-3">
                            <p class="text-sm text-gray-600 mb-2">Imagen actual:</p>
                            <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}"
                                class="h-32 w-32 object-cover rounded border">
                        </div>
                    @endif

                    <input type="file" name="imagen" accept="image/*"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500">
                    <p class="text-gray-500 text-xs mt-1">
                        @if ($producto->imagen)
                            Deja vacio para mantener la imagen actual, o sube una nueva para reemplazarla
                        @else
                            Opcional: Sube una imagen del producto (JPG, PNG, máx. 2MB)
                        @endif
                    </p>
                </div>

            </div>

            <div class="mt-8 flex justify-end space-x-3">
                <a href="{{ route('admin.productos.index') }}"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline transition duration-300">
                    <i class="fa-solid fa-times mr-2"></i> Cancelar
                </a>
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline transition duration-300">
                    <i class="fa-solid fa-save mr-2"></i> Actualizar Producto
                </button>
            </div>
        </form>
    </div>

@endsection
