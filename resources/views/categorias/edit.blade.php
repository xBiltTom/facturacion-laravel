<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('categorias.index') }}" class="mr-4 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-black dark:text-white leading-tight">
                Editar Categoría
            </h2>
        </div>
    </x-slot>

    <div class="p-6">
        <div class="max-w-2xl mx-auto">
            <!-- Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <!-- Header del Card -->
                <div class="bg-gradient-to-r from-amber-500 to-orange-500 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white">Modificar Información</h3>
                    <p class="text-sm text-amber-100 mt-1">Actualiza los datos de la categoría</p>
                </div>

                <!-- Formulario -->
                <form id="categoriaForm" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Nombre de la categoría -->
                    <div>
                        <x-input-label for="nombreCategoria" value="Nombre de la categoría *" />
                        <x-text-input
                            id="nombreCategoria"
                            name="nombreCategoria"
                            type="text"
                            class="mt-1 block w-full"
                            maxlength="100"
                            value="{{ old('nombreCategoria', $categoria->nombreCategoria) }}"
                            required
                            autofocus />
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
                            placeholder="Describe brevemente esta categoría...">{{ old('descripcionCategoria', $categoria->descripcionCategoria) }}</textarea>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Máximo 500 caracteres</p>
                        <div id="error-descripcionCategoria" class="mt-2 text-sm text-red-600 hidden"></div>
                    </div>

                    <!-- Ícono -->
                    <div>
                        <x-input-label for="iconoCategoria" value="Ícono (opcional)" />
                        <div class="mt-2 flex items-center gap-4">
                            <div class="flex-1">
                                <x-text-input
                                    id="iconoCategoria"
                                    name="iconoCategoria"
                                    type="text"
                                    class="block w-full"
                                    maxlength="100"
                                    value="{{ old('iconoCategoria', $categoria->iconoCategoria) }}"
                                    placeholder="Ej: 🍕 🍔 🥤 🍰" />
                            </div>
                            <div id="iconoPreview" class="flex items-center justify-center w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-lg border-2 border-gray-300 dark:border-gray-600">
                                <span id="iconoPreviewText" class="text-3xl">{{ $categoria->iconoCategoria ?? '📦' }}</span>
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Puedes usar emojis o texto corto.
                            <a href="https://emojipedia.org/" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline">Ver emojis</a>
                        </p>
                        <div id="error-iconoCategoria" class="mt-2 text-sm text-red-600 hidden"></div>
                    </div>

                    <!-- Información adicional -->
                    <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Información</h4>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Productos asociados:</span>
                                <span class="ml-2 font-medium text-gray-900 dark:text-gray-100">{{ $categoria->productos->count() }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Creada:</span>
                                <span class="ml-2 font-medium text-gray-900 dark:text-gray-100">{{ $categoria->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
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
                            class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-medium rounded-lg transition duration-150 ease-in-out shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('categoriaForm');
            const iconoInput = document.getElementById('iconoCategoria');
            const iconoPreview = document.getElementById('iconoPreviewText');

            // Preview del ícono en tiempo real
            if (iconoInput) {
                iconoInput.addEventListener('input', function() {
                    if (this.value.trim()) {
                        iconoPreview.textContent = this.value.trim();
                    } else {
                        iconoPreview.textContent = '📦';
                    }
                });
            }

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

            AlertUtils.showLoading('Actualizando categoría...', 'Por favor espera');

            try {
                const response = await fetch('{{ route("categorias.update", $categoria->uuid) }}', {
                    method: 'PUT',
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
                        AlertUtils.showError('Error', data.message || 'Error al actualizar la categoría');
                    }
                    submitBtn.disabled = false;
                    return;
                }

                // Éxito
                await AlertUtils.showSuccess('¡Categoría actualizada!', data.message);
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
