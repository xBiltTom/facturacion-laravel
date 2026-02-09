/**
 * Icon Picker - Manejador del modal de selección de iconos
 */
const IconPicker = {
    selectedIcon: null,
    inputElement: null,
    previewElement: null,

    /**
     * Inicializa el selector de iconos
     */
    init(inputId = 'iconoCategoria', previewId = 'iconoPreview') {
        this.inputElement = document.getElementById(inputId);
        this.previewElement = document.getElementById(previewId);

        // Obtener el icono actual si existe
        if (this.inputElement && this.inputElement.value) {
            this.selectedIcon = this.inputElement.value;
            this.updatePreview();
        }
    },

    /**
     * Abre el modal de selección
     */
    open() {
        const modal = document.getElementById('iconPickerModal');
        if (modal) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Resaltar el icono actualmente seleccionado
            this.highlightSelected();
        }
    },

    /**
     * Cierra el modal
     */
    close() {
        const modal = document.getElementById('iconPickerModal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }
    },

    /**
     * Selecciona un icono
     */
    select(iconName) {
        this.selectedIcon = iconName;

        // Actualizar el input hidden
        if (this.inputElement) {
            this.inputElement.value = iconName;
        }

        // Actualizar el preview
        this.updatePreview();

        // Actualizar el nombre del icono seleccionado en el modal
        const selectedNameEl = document.getElementById('selectedIconName');
        if (selectedNameEl) {
            const iconLabel = this.getIconLabel(iconName);
            selectedNameEl.textContent = iconLabel;
        }

        // Resaltar el icono seleccionado
        this.highlightSelected();
    },

    /**
     * Actualiza el preview del icono
     */
    updatePreview() {
        if (!this.previewElement || !this.selectedIcon) return;

        // Obtener el SVG del componente category-icon
        const iconMap = {
            'shopping-bag': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>',
            'cube': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>',
            'gift': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>',
            'cake': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z"/>',
            'coffee': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>',
            'beaker': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>',
            'sparkles': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>',
            'heart': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>',
            'star': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>',
            'home': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>',
            'phone': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>',
            'book-open': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>',
            'light-bulb': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>',
            'music-note': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>',
            'camera': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>',
            'tag': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>',
            'fire': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"/>',
            'lightning-bolt': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>',
            'puzzle': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/>',
            'truck': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>',
            'desktop': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>',
        };

        const svgPath = iconMap[this.selectedIcon] || iconMap['tag'];

        this.previewElement.innerHTML = `
            <svg class="w-12 h-12 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                ${svgPath}
            </svg>
        `;
    },

    /**
     * Resalta el icono seleccionado en el modal
     */
    highlightSelected() {
        // Quitar la clase selected de todos los iconos
        document.querySelectorAll('.icon-option > div').forEach(div => {
            div.classList.remove('border-blue-500', 'dark:border-blue-400', 'bg-blue-50', 'dark:bg-blue-900/20');
            div.classList.add('border-gray-200', 'dark:border-gray-700');
        });

        // Agregar la clase selected al icono actual
        if (this.selectedIcon) {
            const selectedButton = document.querySelector(`[data-icon="${this.selectedIcon}"]`);
            if (selectedButton) {
                const div = selectedButton.querySelector('div');
                if (div) {
                    div.classList.remove('border-gray-200', 'dark:border-gray-700');
                    div.classList.add('border-blue-500', 'dark:border-blue-400', 'bg-blue-50', 'dark:bg-blue-900/20');
                }
            }
        }
    },

    /**
     * Filtra iconos por categoría
     */
    filterByCategory(category) {
        const allIcons = document.querySelectorAll('.icon-option');

        allIcons.forEach(icon => {
            if (category === 'all' || icon.dataset.category === category) {
                icon.style.display = '';
            } else {
                icon.style.display = 'none';
            }
        });
    },

    /**
     * Obtiene el label legible de un icono
     */
    getIconLabel(iconName) {
        const labels = {
            'shopping-bag': 'Tienda',
            'cube': 'Producto',
            'gift': 'Regalo',
            'cake': 'Pastel',
            'coffee': 'Café',
            'beaker': 'Bebidas',
            'sparkles': 'Especial',
            'heart': 'Favorito',
            'star': 'Estrella',
            'home': 'Casa',
            'phone': 'Teléfono',
            'book-open': 'Libro',
            'light-bulb': 'Idea',
            'music-note': 'Música',
            'camera': 'Cámara',
            'tag': 'Etiqueta',
            'fire': 'Popular',
            'lightning-bolt': 'Rápido',
            'puzzle': 'Piezas',
            'truck': 'Envío',
            'desktop': 'PC',
        };

        return labels[iconName] || iconName;
    },

    /**
     * Limpia la selección
     */
    clear() {
        this.selectedIcon = null;
        if (this.inputElement) {
            this.inputElement.value = '';
        }
        if (this.previewElement) {
            this.previewElement.innerHTML = `
                <svg class="w-12 h-12 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
            `;
        }
    }
};

// Cerrar modal al hacer clic fuera
document.addEventListener('click', function(event) {
    const modal = document.getElementById('iconPickerModal');
    if (event.target === modal) {
        IconPicker.close();
    }
});

// Cerrar modal con tecla ESC
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        IconPicker.close();
    }
});

// Hacer disponible globalmente
window.IconPicker = IconPicker;
