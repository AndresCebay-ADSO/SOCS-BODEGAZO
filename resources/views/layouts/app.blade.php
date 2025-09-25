<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'El Bodegazo')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .suggestion-item.active {
            background-color: #3B82F6;
            color: white;
        }
        .suggestion-item.active .text-gray-500 {
            color: #E5E7EB;
        }
        .suggestion-item.active .text-gray-800 {
            color: white;
        }
        .suggestion-item.active .text-green-600 {
            color: #10B981;
        }
        .suggestion-item.active .text-blue-600 {
            color: #60A5FA;
        }
        .suggestion-item.active .text-gray-400 {
            color: #D1D5DB;
        }
        
        /* Estilos adicionales para el sidebar */
        @media (max-width: 767px) {
            .sidebar-mobile-hidden {
                transform: translateX(-100%);
            }
            .sidebar-mobile-visible {
                transform: translateX(0);
            }
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            400: '#3B82F6',
                            500: '#2563EB',
                            600: '#1D4ED8',
                        },
                        secondary: {
                            100: '#F3F4F6',
                            200: '#E5E7EB',
                            800: '#1F2937',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
          integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    @stack('styles')
</head>
<body class="bg-gray-100 font-sans antialiased">
    {{-- Navbar solo para clientes --}}
    @auth
        @if(auth()->user()->idRolUsu == 2)
            <nav class="bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800 py-4 px-6 shadow-lg sticky top-0 z-50">
                <div class="container mx-auto">
                    <div class="flex flex-col lg:flex-row justify-between items-center gap-4">
                        <!-- Logo y menú móvil -->
                        <div class="w-full lg:w-auto flex justify-between items-center">
                            <a href="{{ route('clientes.dashboard') }}" class="flex items-center space-x-3 text-white hover:text-blue-200 transition">
                                <div class="bg-white bg-opacity-20 p-2 rounded-lg">
                                    <i class="fas fa-store text-2xl"></i>
                                </div>
                                <div>
                                    <h1 class="text-2xl font-bold">El Bodegazo</h1>
                                    <p class="text-xs text-blue-200">Tu tienda de confianza</p>
                                </div>
                            </a>
                            <button class="lg:hidden text-white hover:text-blue-200 transition" id="menu-toggle-client">
                                <i class="fas fa-bars text-xl"></i>
                            </button>
                        </div>

                        <!-- Barra de búsqueda -->
                        <div class="w-full lg:w-1/2 relative">
                            <form id="search-form" class="flex">
                                <div class="relative w-full">
                                    <input type="text" 
                                           id="search-input"
                                           placeholder="Buscar productos, categorías..." 
                                           class="w-full px-4 py-3 pl-12 pr-4 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-transparent border-0 text-gray-800">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-search text-gray-400"></i>
                                    </div>
                                </div>
                                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-r-lg transition duration-200 flex items-center">
                                    <i class="fas fa-search mr-2"></i>
                                    <span class="hidden sm:inline">Buscar</span>
                                </button>
                            </form>
                            
                            <!-- Autocompletado -->
                            <div id="search-suggestions" class="absolute top-full left-0 right-0 bg-white shadow-lg rounded-b-lg border border-gray-200 hidden z-50 max-h-64 overflow-y-auto">
                                <!-- Las sugerencias se cargarán aquí dinámicamente -->
                            </div>
                        </div>

                        <!-- Menú de navegación -->
                        <div class="hidden lg:flex items-center space-x-6" id="menu-items-client">
                            <a href="{{ route('clientes.productos.index') }}" class="text-white hover:text-orange-300 transition duration-200 flex items-center space-x-2 px-3 py-2 rounded-lg hover:bg-white hover:bg-opacity-10">
                                <i class="fas fa-shopping-bag"></i>
                                <span>Productos</span>
                            </a>
                            <a href="{{ route('clientes.categorias') }}" class="text-white hover:text-orange-300 transition duration-200 flex items-center space-x-2 px-3 py-2 rounded-lg hover:bg-white hover:bg-opacity-10">
                                <i class="fas fa-th-large"></i>
                                <span>Categorías</span>
                            </a>
                            <a href="{{ route('clientes.pedidos.index') }}" class="text-white hover:text-orange-300 transition duration-200 flex items-center space-x-2 px-3 py-2 rounded-lg hover:bg-white hover:bg-opacity-10">
                                <i class="fas fa-box"></i>
                                <span>pedidos</span>
                            </a>
                            <a href="{{ route('clientes.carrito.index') }}" class="text-white hover:text-orange-300 transition duration-200 flex items-center space-x-2 px-3 py-2 rounded-lg hover:bg-white hover:bg-opacity-10 relative">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Carrito</span>
                                @php
                                    $carrito = session('carrito', []);
                                    $cantidad = array_sum($carrito);
                                @endphp
                                @if($cantidad > 0)
                                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold">{{ $cantidad }}</span>
                                @endif
                            </a>
                            <a href="{{ route('clientes.profile') }}" 
                               class="text-white hover:text-orange-500 transition duration-200 flex items-center p-6 rounded-full hover:bg-white hover:bg-opacity-10 relative group">
                                <i class="fas fa-user"></i>
                                <span class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">
                                    Mi Perfil
                                </span>
                            </a>
                        </div>
                    </div>

                    <!-- Menú móvil -->
                    <div class="lg:hidden hidden mt-4" id="mobile-menu">
                        <div class="bg-white bg-opacity-10 rounded-lg p-4 space-y-3">
                            <a href="{{ route('clientes.productos.index') }}" class="text-white hover:text-orange-300 transition block py-2">
                                <i class="fas fa-shopping-bag mr-2"></i> Productos
                            </a>
                            <a href="{{ route('clientes.categorias') }}" class="text-white hover:text-orange-300 transition block py-2">
                                <i class="fas fa-th-large mr-2"></i> Categorías
                            </a>
                            <a href="{{ route('clientes.pedidos.index') }}" class="text-white hover:text-orange-300 transition block py-2">
                                <i class="fas fa-box"></i>
                                <span>pedidos</span>
                            </a>
                            <a href="{{ route('clientes.carrito.index') }}" class="text-white hover:text-orange-300 transition block py-2">
                                <i class="fas fa-shopping-cart mr-2"></i> Carrito
                                @if($cantidad > 0)
                                    <span class="bg-red-500 text-white text-xs rounded-full px-2 py-1 ml-2">{{ $cantidad }}</span>
                                @endif
                            </a>
                            <a href="{{ route('clientes.profile') }}" class="text-white hover:text-orange-300 transition block py-2">
                                <i class="fas fa-user mr-2"></i> Mi cuenta
                            </a>
                        </div>
                    </div>
                </div>
            </nav>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Menú móvil
                    const menuToggle = document.getElementById('menu-toggle-client');
                    const mobileMenu = document.getElementById('mobile-menu');
                    if(menuToggle && mobileMenu) {
                        menuToggle.addEventListener('click', function() {
                            mobileMenu.classList.toggle('hidden');
                        });
                    }

                    // Búsqueda y autocompletado
                    const searchInput = document.getElementById('search-input');
                    const searchForm = document.getElementById('search-form');
                    const searchSuggestions = document.getElementById('search-suggestions');
                    let searchTimeout;

                    if(searchInput && searchForm) {
                        // Manejar envío del formulario
                        searchForm.addEventListener('submit', function(e) {
                            e.preventDefault();
                            const query = searchInput.value.trim();
                            if(query) {
                                window.location.href = '{{ route("clientes.buscar") }}?q=' + encodeURIComponent(query);
                            }
                        });

                        // Autocompletado
                        searchInput.addEventListener('input', function() {
                            const query = this.value.trim();
                            
                            clearTimeout(searchTimeout);
                            
                            if(query.length < 2) {
                                searchSuggestions.classList.add('hidden');
                                return;
                            }

                            searchTimeout = setTimeout(() => {
                                fetch('{{ route("clientes.autocompletar") }}?q=' + encodeURIComponent(query))
                                    .then(response => response.json())
                                    .then(data => {
                                        if(data.length > 0) {
                                            showSuggestions(data);
                                        } else {
                                            searchSuggestions.classList.add('hidden');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        searchSuggestions.classList.add('hidden');
                                    });
                            }, 300);
                        });

                        // Ocultar sugerencias al hacer clic fuera
                        document.addEventListener('click', function(e) {
                            if(!searchInput.contains(e.target) && !searchSuggestions.contains(e.target)) {
                                searchSuggestions.classList.add('hidden');
                            }
                        });

                        // Navegación con teclado
                        searchInput.addEventListener('keydown', function(e) {
                            const suggestions = searchSuggestions.querySelectorAll('.suggestion-item');
                            const activeSuggestion = searchSuggestions.querySelector('.suggestion-item.active');
                            
                            if(e.key === 'ArrowDown') {
                                e.preventDefault();
                                if(activeSuggestion) {
                                    activeSuggestion.classList.remove('active');
                                    const next = activeSuggestion.nextElementSibling;
                                    if(next) {
                                        next.classList.add('active');
                                    } else {
                                        suggestions[0].classList.add('active');
                                    }
                                } else if(suggestions.length > 0) {
                                    suggestions[0].classList.add('active');
                                }
                            } else if(e.key === 'ArrowUp') {
                                e.preventDefault();
                                if(activeSuggestion) {
                                    activeSuggestion.classList.remove('active');
                                    const prev = activeSuggestion.previousElementSibling;
                                    if(prev) {
                                        prev.classList.add('active');
                                    } else {
                                        suggestions[suggestions.length - 1].classList.add('active');
                                    }
                                } else if(suggestions.length > 0) {
                                    suggestions[suggestions.length - 1].classList.add('active');
                                }
                            } else if(e.key === 'Enter' && activeSuggestion) {
                                e.preventDefault();
                                const url = activeSuggestion.getAttribute('data-url');
                                if(url) {
                                    window.location.href = url;
                                }
                            } else if(e.key === 'Escape') {
                                searchSuggestions.classList.add('hidden');
                            }
                        });
                    }

                    function showSuggestions(suggestions) {
                        searchSuggestions.innerHTML = '';
                        
                        suggestions.forEach(suggestion => {
                            const item = document.createElement('div');
                            item.className = 'suggestion-item p-3 hover:bg-gray-100 cursor-pointer border-b border-gray-100 last:border-b-0';
                            item.setAttribute('data-url', suggestion.url);
                            
                            if(suggestion.tipo === 'producto') {
                                item.innerHTML = `
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gray-100 rounded flex items-center justify-center overflow-hidden">
                                            <img src="${suggestion.imagen}" alt="${suggestion.texto}" 
                                                 class="w-full h-full object-contain p-1"
                                                 onerror="this.src='{{ asset('images/default-product.png') }}'">
                                        </div>
                                        <div class="flex-1">
                                            <div class="font-medium text-gray-800">${suggestion.texto}</div>
                                            <div class="text-sm text-gray-500">${suggestion.subtitulo}</div>
                                            <div class="text-sm font-semibold text-green-600">$${suggestion.precio}</div>
                                        </div>
                                        <div class="text-xs text-gray-400">Producto</div>
                                    </div>
                                `;
                            } else {
                                item.innerHTML = `
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-blue-100 rounded flex items-center justify-center">
                                            <i class="fas fa-th-large text-blue-600"></i>
                                        </div>
                                        <div class="flex-1">
                                            <div class="font-medium text-gray-800">${suggestion.texto}</div>
                                            <div class="text-sm text-gray-500">${suggestion.subtitulo}</div>
                                        </div>
                                        <div class="text-xs text-gray-400">Categoría</div>
                                    </div>
                                `;
                            }
                            
                            item.addEventListener('click', function() {
                                window.location.href = suggestion.url;
                            });
                            
                            searchSuggestions.appendChild(item);
                        });
                        
                        searchSuggestions.classList.remove('hidden');
                    }
                });
            </script>
        @endif
    @endauth

    <div class="flex min-h-screen">
        <!-- Overlay para móvil -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden md:hidden"></div>
        
        <!-- Sidebar izquierdo -->
        @auth
            @if(auth()->user()->idRolUsu == 1)
                @include('partials.sidebar')
            @endif
            @if(auth()->user()->idRolUsu == 3)
                @include('partials.superadmin-sidebar')
            @endif
        @endauth

        <!-- Contenido principal -->
        <main class="flex-1 p-4 md:p-8 overflow-y-auto transition-all duration-300 @if(auth()->check() && (auth()->user()->idRolUsu == 1 || auth()->user()->idRolUsu == 3)) ml-0 md:ml-64 @endif">
            @yield('content')
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <!-- Grid principal -->
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Columna 1: Información de la empresa -->
                <div>
                    <h3 class="text-lg font-bold mb-4">El Bodegazo</h3>
                    <p class="text-gray-400 mb-4">Tu tienda de confianza para todos tus productos favoritos.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>

                <!-- Columna 2: Enlaces rápidos -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Enlaces Rápidos</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('welcome') }}" class="text-gray-400 hover:text-white transition">Inicio</a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-400 hover:text-white transition">Sobre Nosotros</a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-400 hover:text-white transition">Contacto</a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-400 hover:text-white transition">Blog</a>
                        </li>
                    </ul>
                </div>

                <!-- Columna 3: Políticas -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Políticas</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('clientes.politicas.terminos') }}" class="text-gray-400 hover:text-white transition">Términos y Condiciones</a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-400 hover:text-white transition">Política de Privacidad</a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-400 hover:text-white transition">Política de Cookies</a>
                        </li>
                    </ul>
                </div>

                <!-- Columna 4: Seguridad -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Seguridad</h3>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-shield-alt text-green-500"></i>
                            <span class="text-gray-400">Compra 100% Segura</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-lock text-green-500"></i>
                            <span class="text-gray-400">Datos Protegidos</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-credit-card text-green-500"></i>
                            <span class="text-gray-400">Pagos Seguros</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Barra inferior -->
        <div class="bg-gray-950 py-4">
            <div class="container mx-auto px-4">
                <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                    <div class="text-gray-400 text-align-center ">
                        &copy; {{ date('Y') }} El Bodegazo. Todos los derechos reservados.
                    </div>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>