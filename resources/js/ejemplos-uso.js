/**
 * EJEMPLOS DE USO DE UTILIDADES
 * ================================
 * Este archivo contiene ejemplos de cómo usar las utilidades creadas
 * para alertas (SweetAlert2) y subida de imágenes (Cloudinary)
 */

// ============================================
// EJEMPLOS DE ALERTAS (alert-utils.js)
// ============================================

// 1. Toast de éxito (pequeño y en esquina)
AlertUtils.showSuccessToast('Operación exitosa');

// 2. Toast de error
AlertUtils.showErrorToast('Algo salió mal');

// 3. Toast de información
AlertUtils.showInfoToast('Información importante');

// 4. Toast de advertencia
AlertUtils.showWarningToast('Ten cuidado con esto');

// 5. Diálogo de éxito
AlertUtils.showSuccess('¡Genial!', 'Todo se completó correctamente');

// 6. Diálogo de error
AlertUtils.showError('Error', 'No se pudo completar la operación');

// 7. Diálogo de confirmación
const result = await AlertUtils.showConfirm(
    '¿Estás seguro?',
    'Esta acción no se puede deshacer',
    'Sí, continuar',
    'Cancelar'
);

if (result.isConfirmed) {
    // Usuario confirmó
    console.log('Confirmado');
}

// 8. Diálogo de confirmación para eliminar
const deleteResult = await AlertUtils.showDeleteConfirm('este producto');

if (deleteResult.isConfirmed) {
    // Proceder con la eliminación
}

// 9. Mostrar loading
AlertUtils.showLoading('Procesando...', 'Por favor espera');

// ... realizar operación ...

// Cerrar loading
AlertUtils.closeLoading();

// 10. Input dialog
const inputResult = await AlertUtils.showInputDialog(
    'Ingresa tu nombre',
    'Nombre completo',
    'text'
);

if (inputResult.isConfirmed) {
    const nombre = inputResult.value;
    console.log('Nombre ingresado:', nombre);
}

// 11. Mostrar errores de validación de Laravel
const erroresLaravel = {
    nombre: ['El nombre es requerido', 'El nombre debe tener al menos 3 caracteres'],
    email: ['El email no es válido']
};

AlertUtils.showValidationErrors(erroresLaravel);


// ============================================
// EJEMPLOS DE CLOUDINARY (cloudinary-utils.js)
// ============================================

// 1. Validar archivo de imagen
const file = document.getElementById('miInput').files[0];

const validation = CloudinaryUtils.validateImageFile(file, {
    maxFileSize: 3 * 1024 * 1024, // 3MB
    allowedFormats: ['jpg', 'png']
});

if (!validation.valid) {
    AlertUtils.showError('Error', validation.error);
}

// 2. Generar preview de imagen
const previewUrl = await CloudinaryUtils.generateImagePreview(file);
document.getElementById('miImagen').src = previewUrl;

// 3. Subir imagen a Cloudinary
try {
    AlertUtils.showLoading('Subiendo imagen...');

    const result = await CloudinaryUtils.uploadImage(file, {
        folder: 'productos',
        maxFileSize: 5 * 1024 * 1024,
        transformation: {
            width: 800,
            height: 800,
            crop: 'limit'
        }
    });

    AlertUtils.closeLoading();

    if (result.success) {
        console.log('URL de la imagen:', result.url);
        console.log('Public ID:', result.publicId);

        // Guardar la URL en un campo del formulario
        document.getElementById('urlImagen').value = result.url;

        AlertUtils.showSuccessToast('Imagen subida correctamente');
    }
} catch (error) {
    AlertUtils.closeLoading();
    AlertUtils.showError('Error', error.message);
}

// 4. Subir múltiples imágenes
const files = document.getElementById('multipleInput').files;

const multipleResult = await CloudinaryUtils.uploadMultipleImages(files, {
    folder: 'galeria'
});

if (multipleResult.success) {
    multipleResult.images.forEach(img => {
        console.log('URL:', img.url);
    });
}

// 5. Obtener URL con transformaciones
const originalUrl = 'https://res.cloudinary.com/demo/image/upload/v1234/sample.jpg';

const thumbnailUrl = CloudinaryUtils.getTransformedImageUrl(originalUrl, {
    width: 200,
    height: 200,
    crop: 'fill',
    quality: 80
});

// 6. Crear input de imagen personalizado
const imageInput = CloudinaryUtils.createImageInput({
    containerId: 'miContenedor',
    inputId: 'miInputPersonalizado',
    previewId: 'miPreview',
    uploadOnSelect: true, // Subir automáticamente al seleccionar
    config: {
        folder: 'usuarios/avatares',
        maxFileSize: 2 * 1024 * 1024, // 2MB
        allowedFormats: ['jpg', 'png']
    },
    onSelect: (file) => {
        console.log('Archivo seleccionado:', file.name);
    },
    onUpload: (result) => {
        console.log('Imagen subida:', result.url);
        // Guardar URL en formulario o base de datos
    }
});


// ============================================
// EJEMPLO COMPLETO: FORMULARIO DE PRODUCTO
// ============================================

document.getElementById('formProducto').addEventListener('submit', async function(e) {
    e.preventDefault();

    // 1. Obtener datos del formulario
    const nombre = document.getElementById('nombre').value;
    const precio = document.getElementById('precio').value;
    const imagenFile = document.getElementById('imagen').files[0];

    // 2. Validar campos
    if (!nombre || !precio) {
        AlertUtils.showError('Error', 'Completa todos los campos');
        return;
    }

    // 3. Validar imagen
    if (imagenFile) {
        const validation = CloudinaryUtils.validateImageFile(imagenFile);
        if (!validation.valid) {
            AlertUtils.showError('Error', validation.error);
            return;
        }
    }

    // 4. Mostrar loading
    AlertUtils.showLoading('Guardando producto...', 'Por favor espera');

    try {
        // 5. Subir imagen si existe
        let urlImagen = null;
        if (imagenFile) {
            const uploadResult = await CloudinaryUtils.uploadImage(imagenFile, {
                folder: 'productos',
                transformation: {
                    width: 600,
                    height: 600,
                    crop: 'limit'
                }
            });
            urlImagen = uploadResult.url;
        }

        // 6. Enviar datos al servidor
        const response = await fetch('/productos', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                nombre: nombre,
                precio: precio,
                imagen: urlImagen
            })
        });

        const data = await response.json();

        // 7. Manejar respuesta
        AlertUtils.closeLoading();

        if (response.ok) {
            await AlertUtils.showSuccess('¡Éxito!', 'Producto creado correctamente');
            window.location.href = '/productos';
        } else {
            if (data.errors) {
                AlertUtils.showValidationErrors(data.errors);
            } else {
                AlertUtils.showError('Error', data.message || 'Error al crear el producto');
            }
        }

    } catch (error) {
        AlertUtils.closeLoading();
        AlertUtils.showError('Error', 'Ocurrió un error inesperado');
        console.error(error);
    }
});


// ============================================
// EJEMPLO: ELIMINAR CON CONFIRMACIÓN
// ============================================

async function eliminarProducto(id) {
    // Mostrar confirmación
    const result = await AlertUtils.showDeleteConfirm('este producto');

    if (!result.isConfirmed) {
        return;
    }

    // Mostrar loading
    AlertUtils.showLoading('Eliminando producto...');

    try {
        const response = await fetch(`/productos/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });

        AlertUtils.closeLoading();

        if (response.ok) {
            AlertUtils.showSuccessToast('Producto eliminado');
            // Recargar tabla o remover elemento del DOM
            document.getElementById(`producto-${id}`).remove();
        } else {
            AlertUtils.showError('Error', 'No se pudo eliminar el producto');
        }

    } catch (error) {
        AlertUtils.closeLoading();
        AlertUtils.showError('Error', 'Ocurrió un error inesperado');
    }
}
