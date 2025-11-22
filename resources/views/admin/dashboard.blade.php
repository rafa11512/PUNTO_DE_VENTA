@extends('layouts.admin')

@section('content')
    <h3 class="text-gray-700 text-3xl font-medium">Dashboard Principal</h3>

    <div class="mt-4">
        <div class="flex flex-wrap -mx-6">

            <div class="w-full px-6 sm:w-1/2 xl:w-1/3">
                <div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white">
                    <div class="p-3 rounded-full bg-indigo-600 bg-opacity-75">
                        <i class="fa-solid fa-users text-white text-2xl"></i>
                    </div>
                    <div class="mx-5">
                        <h4 class="text-2xl font-semibold text-gray-700">0</h4>
                        <div class="text-gray-500">Clientes Registrados</div>
                    </div>
                </div>
            </div>

            <div class="w-full px-6 sm:w-1/2 xl:w-1/3 mt-6 sm:mt-0">
                <div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white">
                    <div class="p-3 rounded-full bg-orange-600 bg-opacity-75">
                        <i class="fa-solid fa-box text-white text-2xl"></i>
                    </div>
                    <div class="mx-5">
                        <h4 class="text-2xl font-semibold text-gray-700">0</h4>
                        <div class="text-gray-500">Productos Totales</div>
                    </div>
                </div>
            </div>

            <div class="w-full px-6 sm:w-1/2 xl:w-1/3 mt-6 xl:mt-0">
                <div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white">
                    <div class="p-3 rounded-full bg-emerald-600 bg-opacity-75">
                        <i class="fa-solid fa-money-bill-wave text-white text-2xl"></i>
                    </div>
                    <div class="mx-5">
                        <h4 class="text-2xl font-semibold text-gray-700">$0.00</h4>
                        <div class="text-gray-500">Ventas del Mes</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
