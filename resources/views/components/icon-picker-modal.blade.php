@props(['selectedIcon' => null])

<!-- Modal de selección de iconos -->
<div id="iconPickerModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-white">Seleccionar Ícono</h3>
                <p class="text-sm text-blue-100 mt-1">Elige un ícono para tu categoría</p>
            </div>
            <button type="button" onclick="IconPicker.close()" class="text-white hover:text-gray-200 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Body con scroll -->
        <div class="p-6 overflow-y-auto max-h-[calc(90vh-140px)]">
            <!-- Filtro por categoría -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Filtrar por categoría
                </label>
                <select id="iconCategoryFilter" onchange="IconPicker.filterByCategory(this.value)"
                        class="w-full sm:w-64 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="all">Todos los iconos</option>
                    <option value="commerce">Comercio y Ventas</option>
                    <option value="food">Comida y Bebidas</option>
                    <option value="objects">Objetos</option>
                    <option value="tech">Tecnología</option>
                    <option value="general">General</option>
                </select>
            </div>

            <!-- Grid de iconos -->
            <div class="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 lg:grid-cols-10 gap-3" id="iconGrid">
                <!-- Iconos de Comercio y Ventas -->
                <button type="button" class="icon-option group" data-icon="shopping-bag" data-category="commerce" onclick="IconPicker.select('shopping-bag')">
                    <div class="flex flex-col items-center justify-center p-3 rounded-lg border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all duration-200 {{ $selectedIcon === 'shopping-bag' ? 'border-blue-500 dark:border-blue-400 bg-blue-50 dark:bg-blue-900/20' : '' }}">
                        <x-category-icon icon="shopping-bag" class="w-8 h-8 text-gray-600 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400" />
                        <span class="text-xs mt-1 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400">Tienda</span>
                    </div>
                </button>

                <button type="button" class="icon-option group" data-icon="tag" data-category="commerce" onclick="IconPicker.select('tag')">
                    <div class="flex flex-col items-center justify-center p-3 rounded-lg border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all duration-200 {{ $selectedIcon === 'tag' ? 'border-blue-500 dark:border-blue-400 bg-blue-50 dark:bg-blue-900/20' : '' }}">
                        <x-category-icon icon="tag" class="w-8 h-8 text-gray-600 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400" />
                        <span class="text-xs mt-1 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400">Etiqueta</span>
                    </div>
                </button>

                <button type="button" class="icon-option group" data-icon="gift" data-category="commerce" onclick="IconPicker.select('gift')">
                    <div class="flex flex-col items-center justify-center p-3 rounded-lg border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all duration-200 {{ $selectedIcon === 'gift' ? 'border-blue-500 dark:border-blue-400 bg-blue-50 dark:bg-blue-900/20' : '' }}">
                        <x-category-icon icon="gift" class="w-8 h-8 text-gray-600 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400" />
                        <span class="text-xs mt-1 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400">Regalo</span>
                    </div>
                </button>

                <button type="button" class="icon-option group" data-icon="truck" data-category="commerce" onclick="IconPicker.select('truck')">
                    <div class="flex flex-col items-center justify-center p-3 rounded-lg border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all duration-200 {{ $selectedIcon === 'truck' ? 'border-blue-500 dark:border-blue-400 bg-blue-50 dark:bg-blue-900/20' : '' }}">
                        <x-category-icon icon="truck" class="w-8 h-8 text-gray-600 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400" />
                        <span class="text-xs mt-1 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400">Envío</span>
                    </div>
                </button>

                <!-- Iconos de Comida y Bebidas -->
                <button type="button" class="icon-option group" data-icon="cake" data-category="food" onclick="IconPicker.select('cake')">
                    <div class="flex flex-col items-center justify-center p-3 rounded-lg border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all duration-200 {{ $selectedIcon === 'cake' ? 'border-blue-500 dark:border-blue-400 bg-blue-50 dark:bg-blue-900/20' : '' }}">
                        <x-category-icon icon="cake" class="w-8 h-8 text-gray-600 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400" />
                        <span class="text-xs mt-1 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400">Pastel</span>
                    </div>
                </button>

                <button type="button" class="icon-option group" data-icon="coffee" data-category="food" onclick="IconPicker.select('coffee')">
                    <div class="flex flex-col items-center justify-center p-3 rounded-lg border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all duration-200 {{ $selectedIcon === 'coffee' ? 'border-blue-500 dark:border-blue-400 bg-blue-50 dark:bg-blue-900/20' : '' }}">
                        <x-category-icon icon="coffee" class="w-8 h-8 text-gray-600 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400" />
                        <span class="text-xs mt-1 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400">Café</span>
                    </div>
                </button>

                <button type="button" class="icon-option group" data-icon="beaker" data-category="food" onclick="IconPicker.select('beaker')">
                    <div class="flex flex-col items-center justify-center p-3 rounded-lg border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all duration-200 {{ $selectedIcon === 'beaker' ? 'border-blue-500 dark:border-blue-400 bg-blue-50 dark:bg-blue-900/20' : '' }}">
                        <x-category-icon icon="beaker" class="w-8 h-8 text-gray-600 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400" />
                        <span class="text-xs mt-1 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400">Bebidas</span>
                    </div>
                </button>

                <!-- Iconos de Objetos -->
                <button type="button" class="icon-option group" data-icon="cube" data-category="objects" onclick="IconPicker.select('cube')">
                    <div class="flex flex-col items-center justify-center p-3 rounded-lg border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all duration-200 {{ $selectedIcon === 'cube' ? 'border-blue-500 dark:border-blue-400 bg-blue-50 dark:bg-blue-900/20' : '' }}">
                        <x-category-icon icon="cube" class="w-8 h-8 text-gray-600 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400" />
                        <span class="text-xs mt-1 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400">Producto</span>
                    </div>
                </button>

                <button type="button" class="icon-option group" data-icon="puzzle" data-category="objects" onclick="IconPicker.select('puzzle')">
                    <div class="flex flex-col items-center justify-center p-3 rounded-lg border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all duration-200 {{ $selectedIcon === 'puzzle' ? 'border-blue-500 dark:border-blue-400 bg-blue-50 dark:bg-blue-900/20' : '' }}">
                        <x-category-icon icon="puzzle" class="w-8 h-8 text-gray-600 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400" />
                        <span class="text-xs mt-1 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400">Piezas</span>
                    </div>
                </button>

                <button type="button" class="icon-option group" data-icon="camera" data-category="objects" onclick="IconPicker.select('camera')">
                    <div class="flex flex-col items-center justify-center p-3 rounded-lg border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all duration-200 {{ $selectedIcon === 'camera' ? 'border-blue-500 dark:border-blue-400 bg-blue-50 dark:bg-blue-900/20' : '' }}">
                        <x-category-icon icon="camera" class="w-8 h-8 text-gray-600 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400" />
                        <span class="text-xs mt-1 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400">Cámara</span>
                    </div>
                </button>

                <button type="button" class="icon-option group" data-icon="book-open" data-category="objects" onclick="IconPicker.select('book-open')">
                    <div class="flex flex-col items-center justify-center p-3 rounded-lg border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all duration-200 {{ $selectedIcon === 'book-open' ? 'border-blue-500 dark:border-blue-400 bg-blue-50 dark:bg-blue-900/20' : '' }}">
                        <x-category-icon icon="book-open" class="w-8 h-8 text-gray-600 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400" />
                        <span class="text-xs mt-1 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400">Libro</span>
                    </div>
                </button>

                <!-- Iconos de Tecnología -->
                <button type="button" class="icon-option group" data-icon="desktop" data-category="tech" onclick="IconPicker.select('desktop')">
                    <div class="flex flex-col items-center justify-center p-3 rounded-lg border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all duration-200 {{ $selectedIcon === 'desktop' ? 'border-blue-500 dark:border-blue-400 bg-blue-50 dark:bg-blue-900/20' : '' }}">
                        <x-category-icon icon="desktop" class="w-8 h-8 text-gray-600 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400" />
                        <span class="text-xs mt-1 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400">PC</span>
                    </div>
                </button>

                <button type="button" class="icon-option group" data-icon="phone" data-category="tech" onclick="IconPicker.select('phone')">
                    <div class="flex flex-col items-center justify-center p-3 rounded-lg border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all duration-200 {{ $selectedIcon === 'phone' ? 'border-blue-500 dark:border-blue-400 bg-blue-50 dark:bg-blue-900/20' : '' }}">
                        <x-category-icon icon="phone" class="w-8 h-8 text-gray-600 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400" />
                        <span class="text-xs mt-1 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400">Teléfono</span>
                    </div>
                </button>

                <button type="button" class="icon-option group" data-icon="light-bulb" data-category="tech" onclick="IconPicker.select('light-bulb')">
                    <div class="flex flex-col items-center justify-center p-3 rounded-lg border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all duration-200 {{ $selectedIcon === 'light-bulb' ? 'border-blue-500 dark:border-blue-400 bg-blue-50 dark:bg-blue-900/20' : '' }}">
                        <x-category-icon icon="light-bulb" class="w-8 h-8 text-gray-600 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400" />
                        <span class="text-xs mt-1 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400">Idea</span>
                    </div>
                </button>

                <button type="button" class="icon-option group" data-icon="lightning-bolt" data-category="tech" onclick="IconPicker.select('lightning-bolt')">
                    <div class="flex flex-col items-center justify-center p-3 rounded-lg border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all duration-200 {{ $selectedIcon === 'lightning-bolt' ? 'border-blue-500 dark:border-blue-400 bg-blue-50 dark:bg-blue-900/20' : '' }}">
                        <x-category-icon icon="lightning-bolt" class="w-8 h-8 text-gray-600 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400" />
                        <span class="text-xs mt-1 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400">Rápido</span>
                    </div>
                </button>

                <!-- Iconos Generales -->
                <button type="button" class="icon-option group" data-icon="sparkles" data-category="general" onclick="IconPicker.select('sparkles')">
                    <div class="flex flex-col items-center justify-center p-3 rounded-lg border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all duration-200 {{ $selectedIcon === 'sparkles' ? 'border-blue-500 dark:border-blue-400 bg-blue-50 dark:bg-blue-900/20' : '' }}">
                        <x-category-icon icon="sparkles" class="w-8 h-8 text-gray-600 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400" />
                        <span class="text-xs mt-1 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400">Especial</span>
                    </div>
                </button>

                <button type="button" class="icon-option group" data-icon="heart" data-category="general" onclick="IconPicker.select('heart')">
                    <div class="flex flex-col items-center justify-center p-3 rounded-lg border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all duration-200 {{ $selectedIcon === 'heart' ? 'border-blue-500 dark:border-blue-400 bg-blue-50 dark:bg-blue-900/20' : '' }}">
                        <x-category-icon icon="heart" class="w-8 h-8 text-gray-600 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400" />
                        <span class="text-xs mt-1 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400">Favorito</span>
                    </div>
                </button>

                <button type="button" class="icon-option group" data-icon="star" data-category="general" onclick="IconPicker.select('star')">
                    <div class="flex flex-col items-center justify-center p-3 rounded-lg border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all duration-200 {{ $selectedIcon === 'star' ? 'border-blue-500 dark:border-blue-400 bg-blue-50 dark:bg-blue-900/20' : '' }}">
                        <x-category-icon icon="star" class="w-8 h-8 text-gray-600 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400" />
                        <span class="text-xs mt-1 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400">Estrella</span>
                    </div>
                </button>

                <button type="button" class="icon-option group" data-icon="home" data-category="general" onclick="IconPicker.select('home')">
                    <div class="flex flex-col items-center justify-center p-3 rounded-lg border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all duration-200 {{ $selectedIcon === 'home' ? 'border-blue-500 dark:border-blue-400 bg-blue-50 dark:bg-blue-900/20' : '' }}">
                        <x-category-icon icon="home" class="w-8 h-8 text-gray-600 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400" />
                        <span class="text-xs mt-1 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400">Casa</span>
                    </div>
                </button>

                <button type="button" class="icon-option group" data-icon="fire" data-category="general" onclick="IconPicker.select('fire')">
                    <div class="flex flex-col items-center justify-center p-3 rounded-lg border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all duration-200 {{ $selectedIcon === 'fire' ? 'border-blue-500 dark:border-blue-400 bg-blue-50 dark:bg-blue-900/20' : '' }}">
                        <x-category-icon icon="fire" class="w-8 h-8 text-gray-600 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400" />
                        <span class="text-xs mt-1 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400">Popular</span>
                    </div>
                </button>

                <button type="button" class="icon-option group" data-icon="music-note" data-category="general" onclick="IconPicker.select('music-note')">
                    <div class="flex flex-col items-center justify-center p-3 rounded-lg border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all duration-200 {{ $selectedIcon === 'music-note' ? 'border-blue-500 dark:border-blue-400 bg-blue-50 dark:bg-blue-900/20' : '' }}">
                        <x-category-icon icon="music-note" class="w-8 h-8 text-gray-600 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400" />
                        <span class="text-xs mt-1 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400">Música</span>
                    </div>
                </button>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 dark:bg-gray-900 px-6 py-4 flex items-center justify-between border-t border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                <span id="selectedIconName" class="font-medium text-gray-700 dark:text-gray-300">Ninguno</span> seleccionado
            </p>
            <button type="button" onclick="IconPicker.close()"
                    class="px-6 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-lg transition duration-150 ease-in-out shadow-md hover:shadow-lg">
                Confirmar
            </button>
        </div>
    </div>
</div>
