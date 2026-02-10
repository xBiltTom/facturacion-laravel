<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('productos.index') }}" class="mr-4 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-black dark:text-white leading-tight">
                Nuevo Producto
            </h2>
        </div>
    </x-slot>

    <div class="p-6">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                {{-- Header del card --}}
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white">Información del Producto</h3>
                    <p class="text-sm text-blue-100 mt-1">Complete los datos para crear un nuevo producto</p>
                </div>
                {{-- FORMULARIO --}}

            </div>
        </div>
    </div>

</x-app-layout>
