/**
 * Módulo de utilidades para subir imágenes a Cloudinary
 * Proporciona funciones reutilizables para el manejo de imágenes
 */

// Configuración de Cloudinary desde variables de entorno
const CLOUDINARY_CONFIG = {
    cloudName: 'dclwwjecz',
    uploadPreset: 'ml_default', // Preset por defecto de Cloudinary
    apiUrl: 'https://api.cloudinary.com/v1_1/'
};

/**
 * Configuración por defecto para subida de imágenes
 */
const defaultUploadConfig = {
    maxFileSize: 5 * 1024 * 1024, // 5MB
    allowedFormats: ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'],
    folder: 'uploads',
    transformation: {
        width: 1000,
        height: 1000,
        crop: 'limit'
    }
};

/**
 * Valida un archivo de imagen
 */
export function validateImageFile(file, config = {}) {
    const maxSize = config.maxFileSize || defaultUploadConfig.maxFileSize;
    const allowedFormats = config.allowedFormats || defaultUploadConfig.allowedFormats;

    // Validar que existe el archivo
    if (!file) {
        return { valid: false, error: 'No se ha seleccionado ningún archivo' };
    }

    // Validar tipo MIME
    if (!file.type.startsWith('image/')) {
        return { valid: false, error: 'El archivo debe ser una imagen' };
    }

    // Validar formato
    const fileExtension = file.type.split('/')[1].toLowerCase();
    if (!allowedFormats.includes(fileExtension)) {
        return {
            valid: false,
            error: `Formato no válido. Formatos permitidos: ${allowedFormats.join(', ').toUpperCase()}`
        };
    }

    // Validar tamaño
    if (file.size > maxSize) {
        const maxSizeMB = (maxSize / (1024 * 1024)).toFixed(2);
        return {
            valid: false,
            error: `El archivo es muy grande. Tamaño máximo: ${maxSizeMB}MB`
        };
    }

    return { valid: true, error: null };
}

/**
 * Genera un preview de la imagen antes de subirla
 */
export function generateImagePreview(file) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();

        reader.onload = (e) => {
            resolve(e.target.result);
        };

        reader.onerror = () => {
            reject(new Error('Error al leer el archivo'));
        };

        reader.readAsDataURL(file);
    });
}

/**
 * Sube una imagen a Cloudinary
 */
export async function uploadImage(file, config = {}) {
    // Validar el archivo
    const validation = validateImageFile(file, config);
    if (!validation.valid) {
        throw new Error(validation.error);
    }

    // Preparar configuración
    const folder = config.folder || defaultUploadConfig.folder;
    const transformation = config.transformation || defaultUploadConfig.transformation;

    // Crear FormData
    const formData = new FormData();
    formData.append('file', file);
    formData.append('upload_preset', CLOUDINARY_CONFIG.uploadPreset);
    formData.append('folder', folder);

    // Agregar transformaciones si existen
    if (transformation) {
        formData.append('transformation', JSON.stringify(transformation));
    }

    try {
        const response = await fetch(
            `${CLOUDINARY_CONFIG.apiUrl}${CLOUDINARY_CONFIG.cloudName}/image/upload`,
            {
                method: 'POST',
                body: formData
            }
        );

        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.error?.message || 'Error al subir la imagen');
        }

        const data = await response.json();

        return {
            success: true,
            url: data.secure_url,
            publicId: data.public_id,
            width: data.width,
            height: data.height,
            format: data.format,
            bytes: data.bytes
        };

    } catch (error) {
        console.error('Error uploading to Cloudinary:', error);
        throw new Error('Error al subir la imagen a Cloudinary: ' + error.message);
    }
}

/**
 * Sube múltiples imágenes a Cloudinary
 */
export async function uploadMultipleImages(files, config = {}) {
    const uploadPromises = Array.from(files).map(file => uploadImage(file, config));

    try {
        const results = await Promise.all(uploadPromises);
        return {
            success: true,
            images: results
        };
    } catch (error) {
        return {
            success: false,
            error: error.message
        };
    }
}

/**
 * Elimina una imagen de Cloudinary
 */
export async function deleteImage(publicId) {
    // Nota: La eliminación desde el frontend requiere configuración especial en Cloudinary
    // Por seguridad, es recomendable hacer esto desde el backend
    console.warn('La eliminación de imágenes debe hacerse desde el backend por seguridad');

    // Esta función está preparada para cuando se implemente desde el backend
    return {
        success: false,
        message: 'Función no implementada desde el frontend'
    };
}

/**
 * Obtiene la URL de una imagen con transformaciones aplicadas
 */
export function getTransformedImageUrl(imageUrl, transformations) {
    if (!imageUrl) return null;

    // Si la URL no es de Cloudinary, retornar tal cual
    if (!imageUrl.includes('cloudinary.com')) {
        return imageUrl;
    }

    // Extraer partes de la URL
    const parts = imageUrl.split('/upload/');
    if (parts.length !== 2) return imageUrl;

    // Construir transformaciones
    let transformString = '';

    if (transformations.width) transformString += `w_${transformations.width},`;
    if (transformations.height) transformString += `h_${transformations.height},`;
    if (transformations.crop) transformString += `c_${transformations.crop},`;
    if (transformations.quality) transformString += `q_${transformations.quality},`;
    if (transformations.format) transformString += `f_${transformations.format},`;

    // Remover última coma
    transformString = transformString.slice(0, -1);

    // Construir nueva URL
    return `${parts[0]}/upload/${transformString}/${parts[1]}`;
}

/**
 * Crea un input file personalizado con preview
 */
export function createImageInput(options = {}) {
    const {
        containerId,
        inputId = 'imageInput',
        previewId = 'imagePreview',
        onSelect = null,
        onUpload = null,
        uploadOnSelect = false,
        config = {}
    } = options;

    const container = document.getElementById(containerId);
    if (!container) {
        console.error(`Container with id '${containerId}' not found`);
        return null;
    }

    // Crear estructura HTML
    container.innerHTML = `
        <div class="image-input-wrapper">
            <input type="file" id="${inputId}" accept="image/*" class="hidden">
            <div id="${previewId}" class="hidden mb-4">
                <img src="" alt="Preview" class="max-w-xs max-h-64 rounded-lg shadow-md">
            </div>
            <label for="${inputId}" class="cursor-pointer inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Seleccionar Imagen
            </label>
        </div>
    `;

    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    const previewImg = preview.querySelector('img');

    // Manejar selección de archivo
    input.addEventListener('change', async (e) => {
        const file = e.target.files[0];
        if (!file) return;

        // Validar
        const validation = validateImageFile(file, config);
        if (!validation.valid) {
            if (window.AlertUtils) {
                window.AlertUtils.showError('Error', validation.error);
            } else {
                alert(validation.error);
            }
            input.value = '';
            return;
        }

        // Mostrar preview
        try {
            const previewUrl = await generateImagePreview(file);
            previewImg.src = previewUrl;
            preview.classList.remove('hidden');

            if (onSelect) onSelect(file);

            // Subir automáticamente si está configurado
            if (uploadOnSelect) {
                if (window.AlertUtils) {
                    window.AlertUtils.showLoading('Subiendo imagen...', 'Por favor espera');
                }

                try {
                    const result = await uploadImage(file, config);

                    if (window.AlertUtils) {
                        window.AlertUtils.closeLoading();
                        window.AlertUtils.showSuccessToast('Imagen subida correctamente');
                    }

                    if (onUpload) onUpload(result);
                } catch (error) {
                    if (window.AlertUtils) {
                        window.AlertUtils.closeLoading();
                        window.AlertUtils.showError('Error', error.message);
                    } else {
                        alert(error.message);
                    }
                }
            }
        } catch (error) {
            console.error('Error generating preview:', error);
        }
    });

    return {
        input,
        preview,
        getFile: () => input.files[0],
        clear: () => {
            input.value = '';
            preview.classList.add('hidden');
        }
    };
}

// Exportar utilidades para uso global
window.CloudinaryUtils = {
    validateImageFile,
    generateImagePreview,
    uploadImage,
    uploadMultipleImages,
    deleteImage,
    getTransformedImageUrl,
    createImageInput
};
