<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Registrar Empresa - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 px-4">
        <!-- Logo -->
        <div class="mb-6">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </div>

        <!-- Card Container -->
        <div class="w-full sm:max-w-3xl bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-8 text-center">
                <h1 class="text-3xl font-bold text-white mb-2">¡Bienvenido!</h1>
                <p class="text-blue-100">Registra tu empresa para comenzar a usar el sistema</p>
                <div class="mt-4 bg-blue-700 bg-opacity-50 rounded-lg px-4 py-3 text-sm text-white">
                    <svg class="inline-block w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    No podrás acceder al sistema hasta completar este registro
                </div>
            </div>

            <!-- Formulario -->
            <div class="px-6 py-8 sm:px-10">
                <form id="empresaForm" class="space-y-6">
                    @csrf

                    <!-- Logo de la empresa -->
                    <div>
                        <x-input-label for="logoEmpresa" :value="'Logo de la empresa *'" />
                        <div class="mt-2 flex flex-col items-center">
                            <!-- Preview del logo -->
                            <div id="logoPreview" class="mb-4 hidden">
                                <img id="logoPreviewImg" src="" alt="Preview" class="w-32 h-32 object-cover rounded-lg border-4 border-gray-200 dark:border-gray-700 shadow-md">
                            </div>

                            <!-- Botón para seleccionar imagen -->
                            <label for="logoInput" class="cursor-pointer inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-150 ease-in-out shadow-md hover:shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Seleccionar Logo
                            </label>
                            <input type="file" id="logoInput" name="logo" accept="image/*" class="hidden">
                            <input type="hidden" id="logoEmpresa" name="logoEmpresa">
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Formatos: JPG, PNG. Tamaño máximo: 5MB</p>
                        </div>
                        <div id="error-logoEmpresa" class="mt-2 text-sm text-red-600 hidden"></div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Razón Social -->
                        <div>
                            <x-input-label for="razonSocialEmpresa" :value="'Razón Social *'" />
                            <x-text-input id="razonSocialEmpresa" class="block mt-1 w-full" type="text" name="razonSocialEmpresa" required />
                            <div id="error-razonSocialEmpresa" class="mt-2 text-sm text-red-600 hidden"></div>
                        </div>

                        <!-- RUC -->
                        <div>
                            <x-input-label for="rucEmpresa" :value="'RUC *'" />
                            <x-text-input id="rucEmpresa" class="block mt-1 w-full" type="text" name="rucEmpresa" maxlength="20" required />
                            <div id="error-rucEmpresa" class="mt-2 text-sm text-red-600 hidden"></div>
                        </div>

                        <!-- Teléfono -->
                        <div>
                            <x-input-label for="telefonoEmpresa" :value="'Teléfono *'" />
                            <x-text-input id="telefonoEmpresa" class="block mt-1 w-full" type="text" name="telefonoEmpresa" maxlength="20" required />
                            <div id="error-telefonoEmpresa" class="mt-2 text-sm text-red-600 hidden"></div>
                        </div>

                        <!-- Dirección -->
                        <div>
                            <x-input-label for="direccionEmpresa" :value="'Dirección *'" />
                            <x-text-input id="direccionEmpresa" class="block mt-1 w-full" type="text" name="direccionEmpresa" required />
                            <div id="error-direccionEmpresa" class="mt-2 text-sm text-red-600 hidden"></div>
                        </div>
                    </div>

                    <!-- Botón de envío -->
                    <div class="flex items-center justify-between pt-4">
                        <button type="button" onclick="handleLogout()" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 underline">
                            Cerrar sesión
                        </button>

                        <button type="submit" id="submitBtn" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-lg transition duration-150 ease-in-out shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Registrar Empresa
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center text-sm text-gray-500 dark:text-gray-400">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. Todos los derechos reservados.</p>
        </div>
    </div>

    <!-- Formulario de logout fuera del formulario principal -->
    <form method="POST" action="{{ route('logout') }}" id="logoutForm" class="hidden">
        @csrf
    </form>

    <script>
        // Configuración de Cloudinary
        const CLOUDINARY_CONFIG = {
            cloudName: '{{ config('cloudinary.cloud_name') }}',
            uploadPreset: 'ml_default',
            folder: 'empresas/logos',
            maxFileSize: 5 * 1024 * 1024, // 5MB
            allowedFormats: ['jpg', 'jpeg', 'png', 'gif', 'webp']
        };

        let selectedFile = null;
        let uploadedImageUrl = null;

        // Inicializar cuando el DOM esté listo
        document.addEventListener('DOMContentLoaded', function() {
            const logoInput = document.getElementById('logoInput');
            const form = document.getElementById('empresaForm');

            if (logoInput) {
                logoInput.addEventListener('change', handleFileSelect);
            }

            if (form) {
                form.addEventListener('submit', handleFormSubmit);
            }
        });

        // Manejar selección de archivo
        function handleFileSelect(event) {
            const file = event.target.files[0];

            if (!file) return;

            // Validar tipo de archivo
            const fileType = file.type.split('/')[1];
            if (!CLOUDINARY_CONFIG.allowedFormats.includes(fileType)) {
                AlertUtils.showError('Error', 'Formato de imagen no válido. Use JPG, PNG, GIF o WEBP');
                event.target.value = '';
                return;
            }

            // Validar tamaño
            if (file.size > CLOUDINARY_CONFIG.maxFileSize) {
                AlertUtils.showError('Error', 'El archivo es muy grande. Tamaño máximo: 5MB');
                event.target.value = '';
                return;
            }

            selectedFile = file;
            showPreview(file);
            convertToBase64(file);
        }

        // Mostrar preview local
        function showPreview(file) {
            const reader = new FileReader();
            const previewContainer = document.getElementById('logoPreview');
            const previewImg = document.getElementById('logoPreviewImg');

            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewContainer.classList.remove('hidden');
            };

            reader.readAsDataURL(file);
        }

        // Convertir imagen a base64
        function convertToBase64(file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                uploadedImageUrl = e.target.result;
                document.getElementById('logoEmpresa').value = uploadedImageUrl;
                AlertUtils.showSuccessToast('Logo seleccionado correctamente');
            };

            reader.onerror = function() {
                AlertUtils.showError('Error', 'Error al procesar la imagen');
                document.getElementById('logoInput').value = '';
                document.getElementById('logoPreview').classList.add('hidden');
                uploadedImageUrl = null;
            };

            reader.readAsDataURL(file);
        }

        // Manejar envío del formulario
        async function handleFormSubmit(event) {
            event.preventDefault();

            // Limpiar errores previos
            clearErrors();

            // Validar logo
            if (!uploadedImageUrl) {
                AlertUtils.showError('Error', 'Debes seleccionar un logo para tu empresa');
                return;
            }

            // Obtener datos del formulario
            const formData = {
                razonSocialEmpresa: document.getElementById('razonSocialEmpresa').value.trim(),
                rucEmpresa: document.getElementById('rucEmpresa').value.trim(),
                telefonoEmpresa: document.getElementById('telefonoEmpresa').value.trim(),
                direccionEmpresa: document.getElementById('direccionEmpresa').value.trim(),
                logoEmpresa: uploadedImageUrl
            };

            // Validación básica
            if (!formData.razonSocialEmpresa || !formData.rucEmpresa ||
                !formData.telefonoEmpresa || !formData.direccionEmpresa) {
                AlertUtils.showError('Error', 'Por favor completa todos los campos obligatorios');
                return;
            }

            // Deshabilitar botón
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;

            AlertUtils.showLoading('Registrando empresa...', 'Estamos subiendo el logo y registrando tu empresa');

            try {
                const response = await fetch('/empresa/registrar', {
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
                        AlertUtils.showError('Error', data.message || 'Error al registrar la empresa');
                    }
                    submitBtn.disabled = false;
                    return;
                }

                // Éxito
                await Swal.fire({
                    icon: 'success',
                    title: '¡Empresa registrada!',
                    text: data.message || 'Tu empresa ha sido registrada exitosamente',
                    confirmButtonText: 'Continuar',
                    confirmButtonColor: '#2563eb',
                    allowOutsideClick: false
                });

                window.location.href = data.redirect || '/dashboard';

            } catch (error) {
                console.error('Error:', error);
                AlertUtils.closeLoading();
                AlertUtils.showError('Error', 'Error al procesar la solicitud. Por favor intenta de nuevo.');
                submitBtn.disabled = false;
            }
        }

        // Mostrar errores de validación
        function displayValidationErrors(errors) {
            for (const [field, messages] of Object.entries(errors)) {
                const errorElement = document.getElementById(`error-${field}`);
                if (errorElement) {
                    errorElement.textContent = messages[0];
                    errorElement.classList.remove('hidden');
                }
            }
        }

        // Limpiar errores
        function clearErrors() {
            const errorElements = document.querySelectorAll('[id^="error-"]');
            errorElements.forEach(element => {
                element.textContent = '';
                element.classList.add('hidden');
            });
        }

        // Manejar logout
        function handleLogout() {
            Swal.fire({
                title: '¿Cerrar sesión?',
                text: 'Deberás completar el registro de tu empresa cuando vuelvas a iniciar sesión',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, cerrar sesión',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('logoutForm');
                    if (form) {
                        form.submit();
                    }
                }
            });
        }
    </script>
</body>
</html>
