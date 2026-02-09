<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('categorias.index') }}" class="mr-4 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-black dark:text-white leading-tight">
                Nueva Categoría
            </h2>
        </div>
    </x-slot>

    <div class="p-6">
        <div class="max-w-2xl mx-auto">
            <!-- Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <!-- Header del Card -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white">Información de la Categoría</h3>
                    <p class="text-sm text-blue-100 mt-1">Complete los datos para crear una nueva categoría</p>
                </div>

                <!-- Formulario -->
                <form id="categoriaForm" class="p-6 space-y-6">
                    @csrf

                    <!-- Nombre de la categoría -->
                    <div>
                        <x-input-label for="nombreCategoria" value="Nombre de la categoría *" />
                        <x-text-input
                            id="nombreCategoria"
                            name="nombreCategoria"
                            type="text"
                            class="mt-1 block w-full"
                            maxlength="100"
                            required
                            autofocus
                            placeholder="Ej: Bebidas, Comidas, Postres" />
                        <div id="error-nombreCategoria" class="mt-2 text-sm text-red-600 hidden"></div>
                    </div>

                    <!-- Descripción -->
                    <div>
                        <x-input-label for="descripcionCategoria" value="Descripción (opcional)" />
                        <textarea
                            id="descripcionCategoria"
                            name="descripcionCategoria"
                            rows="3"
                            maxlength="500"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            placeholder="Describe brevemente esta categoría..."></textarea>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Máximo 500 caracteres</p>
                        <div id="error-descripcionCategoria" class="mt-2 text-sm text-red-600 hidden"></div>
                    </div>

                    <!-- Ícono -->
                    <div>
                        <x-input-label for="iconoCategoria" value="Ícono (opcional)" />
                        <div class="mt-2 flex items-center gap-4">
                            <!-- Input oculto para el valor del icono -->
                            <input type="hidden" id="iconoCategoria" name="iconoCategoria" value="">

                            <!-- Preview del icono -->
                            <div id="iconoPreview" class="flex items-center justify-center w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-lg border-2 border-gray-300 dark:border-gray-600">
                                <svg class="w-12 h-12 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>

                            <!-- Botones -->
                            <div class="flex flex-col gap-2">
                                <button type="button" onclick="IconPicker.open()"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white font-medium rounded-md transition">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                    Seleccionar Ícono
                                </button>
                                <button type="button" onclick="IconPicker.clear()"
                                        class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-md transition text-sm">
                                    Limpiar
                                </button>
                            </div>
                        </div>
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                            Selecciona un ícono SVG de nuestra colección para identificar visualmente esta categoría
                        </p>
                        <div id="error-iconoCategoria" class="mt-2 text-sm text-red-600 hidden"></div>
                    </div>

                    <!-- Botones -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('categorias.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium rounded-lg transition duration-150 ease-in-out">
                            Cancelar
                        </a>
                        <button
                            type="submit"
                            id="submitBtn"
                            class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-lg transition duration-150 ease-in-out shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Crear Categoría
                        </button>
                    </div>
                </form>
            </div>

            <!-- Ayuda -->
            <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800 dark:text-blue-300">Consejo</h3>
                        <div class="mt-2 text-sm text-blue-700 dark:text-blue-400">
                            <p>Las categorías te ayudan a organizar tus productos. Elige nombres descriptivos y agrega un ícono para identificarlas rápidamente.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de selección de iconos -->
    <x-icon-picker-modal />

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('categoriaForm');

            // Inicializar el selector de iconos
            IconPicker.init('iconoCategoria', 'iconoPreview');

            // Manejo del formulario
            if (form) {
                form.addEventListener('submit', handleSubmit);
            }
        });

        async function handleSubmit(event) {
            event.preventDefault();

            // Limpiar errores previos
            clearErrors();

            // Obtener datos del formulario
            const formData = {
                nombreCategoria: document.getElementById('nombreCategoria').value.trim(),
                descripcionCategoria: document.getElementById('descripcionCategoria').value.trim(),
                iconoCategoria: document.getElementById('iconoCategoria').value.trim()
            };

            // Validación básica
            if (!formData.nombreCategoria) {
                AlertUtils.showError('Error', 'El nombre de la categoría es obligatorio');
                return;
            }

            // Deshabilitar botón
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;

            AlertUtils.showLoading('Creando categoría...', 'Por favor espera');

            try {
                const response = await fetch('{{ route("categorias.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(formData)
                });

                const data = await response.json();

                if (!response.ok) {
                    if (data.errors) {
                        displayValidationErrors(data.errors);
                        AlertUtils.closeLoading();
                        AlertUtils.showError('Error', 'Por favor corrige los errores en el formulario');
                    } else {
                        AlertUtils.closeLoading();
                        AlertUtils.showError('Error', data.message || 'Error al crear la categoría');
                    }
                    submitBtn.disabled = false;
                    return;
                }

                // Éxito
                await AlertUtils.showSuccess('¡Categoría creada!', data.message);
                window.location.href = data.redirect || '{{ route("categorias.index") }}';

            } catch (error) {
                console.error('Error:', error);
                AlertUtils.closeLoading();
                AlertUtils.showError('Error', 'Error al procesar la solicitud');
                submitBtn.disabled = false;
            }
        }

        function displayValidationErrors(errors) {
            for (const [field, messages] of Object.entries(errors)) {
                const errorElement = document.getElementById(`error-${field}`);
                if (errorElement) {
                    errorElement.textContent = messages[0];
                    errorElement.classList.remove('hidden');
                }
            }
        }

        function clearErrors() {
            const errorElements = document.querySelectorAll('[id^="error-"]');
            errorElements.forEach(element => {
                element.textContent = '';
                element.classList.add('hidden');
            });
        }
    </script>
    @endpush
</x-app-layout>
