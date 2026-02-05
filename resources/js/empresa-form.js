/**
 * Módulo para el manejo del formulario de registro de empresa
 * Incluye: Validación, subida de imágenes a Cloudinary, y alertas con SweetAlert2
 */

// Configuración de Cloudinary
const CLOUDINARY_CONFIG = {
    cloudName: 'dclwwjecz',
    uploadPreset: 'ml_default', // Puedes crear un preset específico en Cloudinary
    folder: 'empresas/logos',
    maxFileSize: 5 * 1024 * 1024, // 5MB
    allowedFormats: ['jpg', 'jpeg', 'png', 'gif', 'webp']
};

// Variables globales
let selectedFile = null;
let uploadedImageUrl = null;

/**
 * Inicializa el formulario de empresa
 */
export function initEmpresaForm() {
    const logoInput = document.getElementById('logoInput');
    const form = document.getElementById('empresaForm');

    if (logoInput) {
        logoInput.addEventListener('change', handleFileSelect);
    }

    if (form) {
        form.addEventListener('submit', handleFormSubmit);
    }
}

/**
 * Maneja la selección de archivo
 */
function handleFileSelect(event) {
    const file = event.target.files[0];

    if (!file) return;

    // Validar tipo de archivo
    const fileType = file.type.split('/')[1];
    if (!CLOUDINARY_CONFIG.allowedFormats.includes(fileType)) {
        showError('Formato de imagen no válido. Use JPG, PNG, GIF o WEBP');
        event.target.value = '';
        return;
    }

    // Validar tamaño
    if (file.size > CLOUDINARY_CONFIG.maxFileSize) {
        showError('El archivo es muy grande. Tamaño máximo: 5MB');
        event.target.value = '';
        return;
    }

    selectedFile = file;

    // Mostrar preview local
    showPreview(file);

    // Subir a Cloudinary
    uploadToCloudinary(file);
}

/**
 * Muestra un preview local de la imagen
 */
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

/**
 * Sube la imagen a Cloudinary
 */
async function uploadToCloudinary(file) {
    // Mostrar loading
    Swal.fire({
        title: 'Subiendo imagen...',
        html: 'Por favor espera mientras procesamos tu logo',
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    try {
        const formData = new FormData();
        formData.append('file', file);
        formData.append('upload_preset', CLOUDINARY_CONFIG.uploadPreset);
        formData.append('folder', CLOUDINARY_CONFIG.folder);

        const response = await fetch(
            `https://api.cloudinary.com/v1_1/${CLOUDINARY_CONFIG.cloudName}/image/upload`,
            {
                method: 'POST',
                body: formData
            }
        );

        if (!response.ok) {
            throw new Error('Error al subir la imagen');
        }

        const data = await response.json();
        uploadedImageUrl = data.secure_url;

        // Guardar la URL en el campo oculto
        document.getElementById('logoEmpresa').value = uploadedImageUrl;

        Swal.close();

        // Mostrar mensaje de éxito
        showSuccess('Logo cargado correctamente');

    } catch (error) {
        console.error('Error uploading to Cloudinary:', error);
        Swal.close();
        showError('Error al subir el logo. Por favor intenta de nuevo.');

        // Limpiar
        document.getElementById('logoInput').value = '';
        document.getElementById('logoPreview').classList.add('hidden');
        uploadedImageUrl = null;
    }
}

/**
 * Maneja el envío del formulario
 */
async function handleFormSubmit(event) {
    event.preventDefault();

    // Limpiar errores previos
    clearErrors();

    // Validar que se haya subido el logo
    if (!uploadedImageUrl) {
        showError('Debes seleccionar un logo para tu empresa');
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
        showError('Por favor completa todos los campos obligatorios');
        return;
    }

    // Deshabilitar botón de envío
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;

    // Mostrar loading
    Swal.fire({
        title: 'Registrando empresa...',
        html: 'Por favor espera mientras registramos tu empresa',
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

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
            // Si hay errores de validación
            if (data.errors) {
                displayValidationErrors(data.errors);
                Swal.close();
                showError('Por favor corrige los errores en el formulario');
            } else {
                Swal.close();
                showError(data.message || 'Error al registrar la empresa');
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

        // Redirigir al dashboard
        window.location.href = data.redirect || '/dashboard';

    } catch (error) {
        console.error('Error:', error);
        Swal.close();
        showError('Error al procesar la solicitud. Por favor intenta de nuevo.');
        submitBtn.disabled = false;
    }
}

/**
 * Muestra errores de validación en el formulario
 */
function displayValidationErrors(errors) {
    for (const [field, messages] of Object.entries(errors)) {
        const errorElement = document.getElementById(`error-${field}`);
        if (errorElement) {
            errorElement.textContent = messages[0];
            errorElement.classList.remove('hidden');
        }
    }
}

/**
 * Limpia todos los errores del formulario
 */
function clearErrors() {
    const errorElements = document.querySelectorAll('[id^="error-"]');
    errorElements.forEach(element => {
        element.textContent = '';
        element.classList.add('hidden');
    });
}

/**
 * Muestra un mensaje de error con SweetAlert2
 */
function showError(message) {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: message,
        confirmButtonText: 'Entendido',
        confirmButtonColor: '#dc2626'
    });
}

/**
 * Muestra un mensaje de éxito con SweetAlert2
 */
function showSuccess(message) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });

    Toast.fire({
        icon: 'success',
        title: message
    });
}

/**
 * Maneja el cierre de sesión
 */
export function handleLogout() {
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
            document.getElementById('logoutForm').submit();
        }
    });
}

// Exportar funciones para uso global
window.initEmpresaForm = initEmpresaForm;
window.handleLogout = handleLogout;
