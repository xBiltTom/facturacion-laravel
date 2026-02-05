/**
 * Módulo de utilidades para alertas con SweetAlert2
 * Proporciona funciones reutilizables para mostrar diferentes tipos de alertas
 */

/**
 * Configuración por defecto para las alertas
 */
const defaultConfig = {
    confirmButtonColor: '#2563eb',
    cancelButtonColor: '#6b7280',
    confirmButtonText: 'Aceptar',
    cancelButtonText: 'Cancelar'
};

/**
 * Muestra un toast de éxito
 */
export function showSuccessToast(message, duration = 3000) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: duration,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });

    return Toast.fire({
        icon: 'success',
        title: message
    });
}

/**
 * Muestra un toast de error
 */
export function showErrorToast(message, duration = 3000) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: duration,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });

    return Toast.fire({
        icon: 'error',
        title: message
    });
}

/**
 * Muestra un toast de información
 */
export function showInfoToast(message, duration = 3000) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: duration,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });

    return Toast.fire({
        icon: 'info',
        title: message
    });
}

/**
 * Muestra un toast de advertencia
 */
export function showWarningToast(message, duration = 3000) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: duration,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });

    return Toast.fire({
        icon: 'warning',
        title: message
    });
}

/**
 * Muestra un diálogo de éxito
 */
export function showSuccess(title, message = '') {
    return Swal.fire({
        icon: 'success',
        title: title,
        text: message,
        ...defaultConfig
    });
}

/**
 * Muestra un diálogo de error
 */
export function showError(title, message = '') {
    return Swal.fire({
        icon: 'error',
        title: title,
        text: message,
        confirmButtonColor: '#dc2626',
        confirmButtonText: 'Entendido'
    });
}

/**
 * Muestra un diálogo de advertencia
 */
export function showWarning(title, message = '') {
    return Swal.fire({
        icon: 'warning',
        title: title,
        text: message,
        ...defaultConfig
    });
}

/**
 * Muestra un diálogo de información
 */
export function showInfo(title, message = '') {
    return Swal.fire({
        icon: 'info',
        title: title,
        text: message,
        ...defaultConfig
    });
}

/**
 * Muestra un diálogo de confirmación
 */
export function showConfirm(title, message = '', confirmText = 'Sí, confirmar', cancelText = 'Cancelar') {
    return Swal.fire({
        title: title,
        text: message,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#2563eb',
        cancelButtonColor: '#6b7280',
        confirmButtonText: confirmText,
        cancelButtonText: cancelText
    });
}

/**
 * Muestra un diálogo de confirmación para eliminar
 */
export function showDeleteConfirm(itemName = 'este elemento') {
    return Swal.fire({
        title: '¿Estás seguro?',
        text: `No podrás revertir la eliminación de ${itemName}`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    });
}

/**
 * Muestra un loading mientras se procesa algo
 */
export function showLoading(title = 'Procesando...', message = 'Por favor espera') {
    return Swal.fire({
        title: title,
        html: message,
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
}

/**
 * Cierra el loading
 */
export function closeLoading() {
    Swal.close();
}

/**
 * Muestra un diálogo con input de texto
 */
export function showInputDialog(title, placeholder = '', inputType = 'text') {
    return Swal.fire({
        title: title,
        input: inputType,
        inputPlaceholder: placeholder,
        showCancelButton: true,
        ...defaultConfig,
        inputValidator: (value) => {
            if (!value) {
                return 'Este campo es requerido';
            }
        }
    });
}

/**
 * Muestra errores de validación de Laravel
 */
export function showValidationErrors(errors) {
    let errorMessages = '<ul class="text-left">';

    for (const [field, messages] of Object.entries(errors)) {
        messages.forEach(message => {
            errorMessages += `<li>${message}</li>`;
        });
    }

    errorMessages += '</ul>';

    return Swal.fire({
        icon: 'error',
        title: 'Errores de validación',
        html: errorMessages,
        confirmButtonColor: '#dc2626',
        confirmButtonText: 'Entendido'
    });
}

// Exportar todas las funciones para uso global
window.AlertUtils = {
    showSuccessToast,
    showErrorToast,
    showInfoToast,
    showWarningToast,
    showSuccess,
    showError,
    showWarning,
    showInfo,
    showConfirm,
    showDeleteConfirm,
    showLoading,
    closeLoading,
    showInputDialog,
    showValidationErrors
};
