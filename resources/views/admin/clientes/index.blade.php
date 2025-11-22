@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-gray-700 text-3xl font-medium">Gestion de Clientes</h3>

        <a href="{{ route('admin.clientes.create') }}"
            class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-2 px-4 rounded shadow">
            <i class="fa-solid fa-plus mr-2"></i> Nuevo Cliente
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white shadow-md rounded my-6 overflow-x-auto">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">ID</th>
                    <th class="py-3 px-6 text-left">Nombre</th>
                    <th class="py-3 px-6 text-left">Email</th>
                    <th class="py-3 px-6 text-left">Telefono</th>
                    <th class="py-3 px-6 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach ($clientes as $cliente)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left whitespace-nowrap font-bold">{{ $cliente->id }}</td>
                        <td class="py-3 px-6 text-left">{{ $cliente->name }}</td>
                        <td class="py-3 px-6 text-left">{{ $cliente->email }}</td>
                        <td class="py-3 px-6 text-left">{{ $cliente->telefono ?? 'N/A' }}</td>
                        <td class="py-3 px-6 text-center">
                            <div class="flex item-center justify-center space-x-3">

                                <a href="{{ route('admin.clientes.edit', $cliente->id) }}"
                                    class="w-6 transform hover:text-blue-500 hover:scale-110 transition-transform"
                                    title="Editar">
                                    <i class="fa-solid fa-pen"></i>
                                </a>

                                <form action="{{ route('admin.clientes.destroy', $cliente->id) }}" method="POST"
                                    onsubmit="return confirm('¿Estás seguro de eliminar a este cliente?');"
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

        @if ($clientes->isEmpty())
            <div class="p-6 text-center text-gray-500">
                No hay clientes registrados aun.
            </div>
        @endif
    </div>
@endsection
