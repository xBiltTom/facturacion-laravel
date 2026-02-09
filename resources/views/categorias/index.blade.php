<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-black dark:text-white leading-tight">
                Categorías
            </h2>
            <a href="{{ route('categorias.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white font-medium rounded-lg transition duration-150 ease-in-out shadow-md hover:shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nueva Categoría
            </a>
        </div>
    </x-slot>

    <div class="p-6">
        <!-- Filtros y búsqueda -->
        <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <form method="GET" action="{{ route('categorias.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Campo de búsqueda -->
                    <div class="lg:col-span-2">
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Buscar
                        </label>
                        <div class="relative">
                            <input
                                type="text"
                                name="search"
                                id="search"
                                value="{{ request('search') }}"
                                placeholder="Nombre o descripción..."
                                class="w-full pl-10 pr-4 py-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 dark:focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 rounded-md shadow-sm">
                            <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Filtro por ícono -->
                    <div>
                        <label for="has_icon" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Ícono
                        </label>
                        <select
                            name="has_icon"
                            id="has_icon"
                            class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 dark:focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 rounded-md shadow-sm">
                            <option value="">Todos</option>
                            <option value="with" {{ request('has_icon') === 'with' ? 'selected' : '' }}>Con ícono</option>
                            <option value="without" {{ request('has_icon') === 'without' ? 'selected' : '' }}>Sin ícono</option>
                        </select>
                    </div>

                    <!-- Elementos por página -->
                    <div>
                        <label for="per_page" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Mostrar
                        </label>
                        <select
                            name="per_page"
                            id="per_page"
                            onchange="this.form.submit()"
                            class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 dark:focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 rounded-md shadow-sm">
                            <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                            <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        </select>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="flex items-center gap-2">
                    <button
                        type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white font-medium rounded-md transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Buscar
                    </button>
                    @if(request()->hasAny(['search', 'has_icon']))
                        <a
                            href="{{ route('categorias.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-md transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Limpiar
                        </a>
                    @endif
                    <div class="ml-auto text-sm text-gray-600 dark:text-gray-400">
                        Mostrando <span class="font-medium">{{ $categorias->firstItem() ?? 0 }}</span>
                        a <span class="font-medium">{{ $categorias->lastItem() ?? 0 }}</span>
                        de <span class="font-medium">{{ $categorias->total() }}</span> resultados
                    </div>
                </div>
            </form>
        </div>

        <!-- Tabla de categorías -->
        <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            #
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Ícono
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Nombre
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Descripción
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Productos
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Opciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($categorias as $index => $categoria)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                {{ $categorias->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($categoria->iconoCategoria)
                                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-blue-50 dark:bg-blue-900/20">
                                        <x-category-icon :icon="$categoria->iconoCategoria" class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                                    </div>
                                @else
                                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-gray-100 dark:bg-gray-700">
                                        <svg class="w-6 h-6 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $categoria->nombreCategoria }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-500 dark:text-gray-400 max-w-xs truncate">
                                    {{ $categoria->descripcionCategoria ?? 'Sin descripción' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    {{ $categoria->productos_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <!-- Botón Editar -->
                                    <a href="{{ route('categorias.edit', $categoria->uuid) }}"
                                       class="inline-flex items-center px-3 py-1.5 bg-amber-500 hover:bg-amber-600 dark:bg-amber-600 dark:hover:bg-amber-700 text-white rounded-md transition duration-150 ease-in-out"
                                       title="Editar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>

                                    <!-- Botón Eliminar -->
                                    <button onclick="eliminarCategoria('{{ $categoria->uuid }}', '{{ $categoria->nombreCategoria }}')"
                                            class="inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-700 text-white rounded-md transition duration-150 ease-in-out"
                                            title="Eliminar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
                                    <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                    </svg>
                                    <p class="text-lg font-medium mb-2">No hay categorías registradas</p>
                                    <p class="text-sm mb-4">Comienza creando tu primera categoría</p>
                                    <a href="{{ route('categorias.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Crear Categoría
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if($categorias->hasPages())
            <div class="mt-6">
                {{ $categorias->links() }}
            </div>
        @endif
    </div>

    @push('scripts')
    <script>
        async function eliminarCategoria(uuid, nombre) {
            const result = await AlertUtils.showDeleteConfirm(`la categoría "${nombre}"`);

            if (!result.isConfirmed) {
                return;
            }

            AlertUtils.showLoading('Eliminando categoría...');

            try {
                const response = await fetch(`/categorias/${uuid}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                AlertUtils.closeLoading();

                if (response.ok && data.success) {
                    await AlertUtils.showSuccess('¡Eliminado!', data.message);
                    window.location.reload();
                } else {
                    AlertUtils.showError('Error', data.message || 'No se pudo eliminar la categoría');
                }
            } catch (error) {
                AlertUtils.closeLoading();
                AlertUtils.showError('Error', 'Ocurrió un error inesperado');
                console.error(error);
            }
        }
    </script>
    @endpush
</x-app-layout>
