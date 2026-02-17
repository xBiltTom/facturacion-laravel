<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('productos.index') }}" class="mr-4 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-black dark:text-white leading-tight">
                Editar Producto
            </h2>
        </div>
    </x-slot>

    <div class="p-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                {{-- Header del card --}}
                <div class="bg-gradient-to-r from-amber-600 to-orange-600 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white">Modificar Información del Producto</h3>
                    <p class="text-sm text-amber-100 mt-1">Actualiza los datos del producto <span class="font-bold">{{ $producto->nombreProducto }}</span></p>
                </div>

                {{-- Info adicional --}}
                <div class="px-6 py-3 bg-gray-50 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex flex-wrap gap-4 text-xs text-gray-600 dark:text-gray-400">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Creado: {{ $producto->created_at->format('d/m/Y H:i') }}
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            Categoría: {{ $producto->categoria->nombreCategoria }}
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            Stock actual: {{ $producto->stockProducto }} {{ $producto->unidad->nombreUnidad }}
                        </div>
                    </div>
                </div>

                {{-- FORMULARIO --}}
                <form id="productoEditForm" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        {{-- Columna izquierda: Imagen --}}
                        <div class="lg:col-span-1">
                            <x-input-label for="imagenProducto" value="Imagen del producto" />
                            <div class="mt-2 flex flex-col items-center">
                                <!-- Preview de la imagen actual o nueva -->
                                <div id="imagenPreview" class="mb-4">
                                    <img id="imagenPreviewImg"
                                         src="{{ $producto->imagenProducto }}"
                                         alt="{{ $producto->nombreProducto }}"
                                         class="w-full h-48 object-cover rounded-lg border-4 border-gray-200 dark:border-gray-700 shadow-md">
                                </div>

                                <!-- Botón para cambiar imagen -->
                                <label for="imagenInput" class="cursor-pointer inline-flex items-center px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white font-medium rounded-lg transition duration-150 ease-in-out shadow-md hover:shadow-lg w-full justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                    </svg>
                                    Cambiar Imagen
                                </label>
                                <input type="file" id="imagenInput" name="imagen" accept="image/*" class="hidden">
                                <input type="hidden" id="imagenProducto" name="imagenProducto">
                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400 text-center">JPG, PNG. Máximo 5MB</p>
                            </div>
                            <div id="error-imagenProducto" class="mt-2 text-sm text-red-600 hidden"></div>
                        </div>

                        {{-- Columna derecha: Datos del producto --}}
                        <div class="lg:col-span-2 space-y-6">
                            <!-- Nombre del producto -->
                            <div>
                                <x-input-label for="nombreProducto" value="Nombre del producto *" />
                                <x-text-input
                                    id="nombreProducto"
                                    name="nombreProducto"
                                    type="text"
                                    class="mt-1 block w-full"
                                    maxlength="150"
                                    value="{{ $producto->nombreProducto }}"
                                    required
                                    autofocus
                                    placeholder="Ej: Combo Familiar, Pizza Hawaiana, etc." />
                                <div id="error-nombreProducto" class="mt-2 text-sm text-red-600 hidden"></div>
                            </div>

                            <!-- Descripción -->
                            <div>
                                <x-input-label for="descripcionProducto" value="Descripción (opcional)" />
                                <textarea
                                    id="descripcionProducto"
                                    name="descripcionProducto"
                                    rows="3"
                                    maxlength="500"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                    placeholder="Describe el producto...">{{ $producto->descripcionProducto }}</textarea>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Máximo 500 caracteres</p>
                                <div id="error-descripcionProducto" class="mt-2 text-sm text-red-600 hidden"></div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Categoría -->
                                <div>
                                    <x-input-label for="idCategoria" value="Categoría *" />
                                    <select
                                        id="idCategoria"
                                        name="idCategoria"
                                        required
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                        <option value="">Seleccione una categoría</option>
                                        @foreach($categorias as $categoria)
                                            <option value="{{ $categoria->idCategoria }}"
                                                {{ $categoria->idCategoria == $producto->idCategoria ? 'selected' : '' }}>
                                                {{ $categoria->iconoCategoria }} {{ $categoria->nombreCategoria }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="error-idCategoria" class="mt-2 text-sm text-red-600 hidden"></div>
                                </div>

                                <!-- Unidad de medida -->
                                <div>
                                    <x-input-label for="idUnidad" value="Unidad de medida *" />
                                    <select
                                        id="idUnidad"
                                        name="idUnidad"
                                        required
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                        <option value="">Seleccione una unidad</option>
                                        @foreach($unidades as $unidad)
                                            <option value="{{ $unidad->idUnidad }}"
                                                {{ $unidad->idUnidad == $producto->idUnidad ? 'selected' : '' }}>
                                                {{ $unidad->nombreUnidad }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="error-idUnidad" class="mt-2 text-sm text-red-600 hidden"></div>
                                </div>

                                <!-- Precio -->
                                <div>
                                    <x-input-label for="precioVentaProducto" value="Precio de venta *" />
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 dark:text-gray-400 sm:text-sm">S/</span>
                                        </div>
                                        <input
                                            type="number"
                                            id="precioVentaProducto"
                                            name="precioVentaProducto"
                                            step="0.01"
                                            min="0"
                                            max="999999.99"
                                            value="{{ $producto->precioVentaProducto }}"
                                            required
                                            class="pl-10 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                            placeholder="0.00">
                                    </div>
                                    <div id="error-precioVentaProducto" class="mt-2 text-sm text-red-600 hidden"></div>
                                </div>

                                <!-- Stock -->
                                <div>
                                    <x-input-label for="stockProducto" value="Stock *" />
                                    <input
                                        type="number"
                                        id="stockProducto"
                                        name="stockProducto"
                                        min="0"
                                        value="{{ $producto->stockProducto }}"
                                        required
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                        placeholder="0">
                                    <div id="error-stockProducto" class="mt-2 text-sm text-red-600 hidden"></div>
                                </div>
                            </div>

                            <!-- IGV -->
                            <div>
                                <x-input-label value="¿El precio incluye IGV? *" />
                                <div class="mt-2 space-y-2">
                                    <label class="inline-flex items-center mr-6">
                                        <input type="radio" name="tieneIGV" value="1"
                                               {{ $producto->tieneIGV == 1 ? 'checked' : '' }}
                                               required class="form-radio text-indigo-600 dark:bg-gray-900 dark:border-gray-700">
                                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Sí, incluye IGV</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="tieneIGV" value="0"
                                               {{ $producto->tieneIGV == 0 ? 'checked' : '' }}
                                               required class="form-radio text-indigo-600 dark:bg-gray-900 dark:border-gray-700">
                                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">No incluye IGV</span>
                                    </label>
                                </div>
                                <div id="error-tieneIGV" class="mt-2 text-sm text-red-600 hidden"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('productos.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium rounded-lg transition duration-150 ease-in-out">
                            Cancelar
                        </a>
                        <button
                            type="submit"
                            id="submitBtn"
                            class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white font-medium rounded-lg transition duration-150 ease-in-out shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed">
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
        let selectedFile = null;
        let uploadedImageBase64 = null;
        const currentImage = "{{ $producto->imagenProducto }}";

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('productoEditForm');
            const imagenInput = document.getElementById('imagenInput');

            if (imagenInput) {
                imagenInput.addEventListener('change', handleImageSelect);
            }

            if (form) {
                form.addEventListener('submit', handleSubmit);
            }
        });

        function handleImageSelect(event) {
            const file = event.target.files[0];
            if (!file) return;

            // Validar archivo
            const validation = CloudinaryUtils.validateImageFile(file, {
                maxFileSize: 5 * 1024 * 1024,
                allowedFormats: ['jpg', 'jpeg', 'png', 'webp']
            });

            if (!validation.valid) {
                AlertUtils.showError('Error', validation.error);
                event.target.value = '';
                return;
            }

            selectedFile = file;
            showPreview(file);
            convertToBase64(file);
        }

        function showPreview(file) {
            const reader = new FileReader();
            const previewImg = document.getElementById('imagenPreviewImg');

            reader.onload = function(e) {
                previewImg.src = e.target.result;
            };

            reader.readAsDataURL(file);
        }

        function convertToBase64(file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                uploadedImageBase64 = e.target.result;
                document.getElementById('imagenProducto').value = uploadedImageBase64;
            };

            reader.onerror = function() {
                AlertUtils.showError('Error', 'Error al procesar la imagen');
                document.getElementById('imagenInput').value = '';
                document.getElementById('imagenPreviewImg').src = currentImage;
                uploadedImageBase64 = null;
            };

            reader.readAsDataURL(file);
        }

        async function handleSubmit(event) {
            event.preventDefault();
            clearErrors();

            const formData = {
                nombreProducto: document.getElementById('nombreProducto').value.trim(),
                descripcionProducto: document.getElementById('descripcionProducto').value.trim(),
                idCategoria: document.getElementById('idCategoria').value,
                idUnidad: document.getElementById('idUnidad').value,
                precioVentaProducto: document.getElementById('precioVentaProducto').value,
                tieneIGV: document.querySelector('input[name="tieneIGV"]:checked')?.value,
                stockProducto: document.getElementById('stockProducto').value,
                imagenProducto: uploadedImageBase64 || null
            };

            // Validación
            if (!formData.nombreProducto || !formData.idCategoria || !formData.idUnidad ||
                !formData.precioVentaProducto || !formData.tieneIGV || !formData.stockProducto) {
                AlertUtils.showError('Error', 'Por favor completa todos los campos obligatorios');
                return;
            }

            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;

            const loadingMessage = uploadedImageBase64
                ? 'Actualizando producto y subiendo nueva imagen...'
                : 'Actualizando producto...';

            AlertUtils.showLoading('Actualizando producto', loadingMessage);

            try {
                const response = await fetch('{{ route("productos.update", $producto->uuid) }}', {
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
                        AlertUtils.showError('Error', data.message || 'Error al actualizar el producto');
                    }
                    submitBtn.disabled = false;
                    return;
                }

                await AlertUtils.showSuccess('¡Producto actualizado!', data.message);
                window.location.href = data.redirect || '{{ route("productos.index") }}';

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
