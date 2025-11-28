@extends('layouts.admin')

@section('content')

    <div class="max-w-4xl mx-auto bg-white p-8 rounded shadow">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-700">Editar Categoría: {{ $categoria->nombre }}</h2>
            <a href="{{ route('admin.categorias.index') }}" class="text-gray-500 hover:text-gray-700">
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

        <form action="{{ route('admin.categorias.update', $categoria->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nombre de la Categoría <span class="text-red-500">*</span></label>
                    <input type="text" name="nombre" value="{{ old('nombre', $categoria->nombre) }}" required
                        placeholder="Ej: Elotes Preparados, Bebidas, Toppings"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500">
                    <p class="text-gray-500 text-xs mt-1">Nombre que identificará esta categoría en tu punto de venta</p>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Imagen de la Categoría</label>

                    @if($categoria->imagen)
                        <div class="mb-3">
                            <p class="text-sm text-gray-600 mb-2">Imagen actual:</p>
                            <img src="{{ asset('storage/' . $categoria->imagen) }}"
                                 alt="{{ $categoria->nombre }}"
                                 class="h-32 w-32 object-cover rounded border">
                        </div>
                    @endif

                    <input type="file" name="imagen" accept="image/*"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500">
                    <p class="text-gray-500 text-xs mt-1">
                        @if($categoria->imagen)
                            Deja vacío para mantener la imagen actual, o sube una nueva para reemplazarla
                        @else
                            Opcional: Sube una imagen representativa de esta categoría (JPG, PNG, máx. 2MB)
                        @endif
                    </p>
                </div>

                @if($categoria->productos_count > 0)
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fa-solid fa-info-circle text-blue-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    Esta categoría tiene <strong>{{ $categoria->productos_count }} producto(s)</strong> asociado(s).
                                    Los cambios en el nombre se reflejarán en todos los productos.
                                </p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-gray-50 border-l-4 border-gray-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fa-solid fa-box-open text-gray-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-gray-700">
                                    Esta categoría aún no tiene productos asociados.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="mt-8 flex justify-end space-x-3">
                <a href="{{ route('admin.categorias.index') }}"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline transition duration-300">
                    <i class="fa-solid fa-times mr-2"></i> Cancelar
                </a>
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline transition duration-300">
                    <i class="fa-solid fa-save mr-2"></i> Actualizar Categoría
                </button>
            </div>
        </form>
    </div>

@endsection
