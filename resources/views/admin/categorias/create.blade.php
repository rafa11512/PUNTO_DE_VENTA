@extends('layouts.admin')

@section('content')

    <div class="max-w-4xl mx-auto bg-white p-8 rounded shadow">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-700">Registrar Nueva Categoria</h2>
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

        <form action="{{ route('admin.categorias.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="space-y-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nombre de la Categoria <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}" required
                        placeholder="Ej: Elotes Preparados, Bebidas, Toppings"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-emerald-500">
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Imagen de la Categoria</label>
                    <input type="file" name="imagen" accept="image/*"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-emerald-500">
                </div>

            </div>

            <div class="mt-8 flex justify-end space-x-3">
                <a href="{{ route('admin.categorias.index') }}"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline transition duration-300">
                    <i class="fa-solid fa-times mr-2"></i> Cancelar
                </a>
                <button type="submit"
                    class="bg-emerald-500 hover:bg-emerald-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline transition duration-300">
                    <i class="fa-solid fa-save mr-2"></i> Guardar Categoria
                </button>
            </div>
        </form>
    </div>

@endsection
