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
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    @php
    $notificaciones = [];
    @endphp

    {{-- Navbar solo para clientes --}}
    @auth
        @if(auth()->user()->idRolUsu == 2)
            <nav class="bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800 py-4 px-6 shadow-lg z-50">
                <div class="container mx-auto">
                    <div class="flex flex-col lg:flex-row justify-between items-center gap-4">
                        <!-- Logo y menú móvil -->
                        <div class="w-full lg:w-auto flex justify-between items-center">
                            <a href="{{ route('clientes.dashboard') }}" class="flex items-center space-x-3 text-white hover:text-blue-200 transition">
                                <div class="w-16 h-16 rounded-full border-4 border-white shadow-lg overflow-hidden flex-shrink-0">
                                    <img src="{{ asset('images/elbodegazo.jpeg') }}" alt="Logo El Bodegazo" class="w-full h-full object-cover">
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

                            {{-- Notificaciones --}}
                            <div class="relative" id="notification-container">
                                <a href="#" id="notificaciones-link" class="text-white hover:text-orange-300 transition duration-200 flex items-center space-x-2 px-3 py-2 rounded-lg hover:bg-white hover:bg-opacity-10 relative">
                                    <i class="fas fa-bell"></i>
                                    <span id="notificaciones-count" class="absolute -top-1 -right-1 bg-yellow-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold" style="display: none;"></span>
                                </a>
                                <div id="notificaciones-dropdown" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl overflow-hidden z-50 hidden">
                                    <div class="py-2 px-4 text-gray-700 font-bold border-b">Notificaciones</div>
                                    <div id="notificaciones-list" class="divide-y">
                                        {{-- Este es el contenedor del menú desplegable de notificaciones --}}
                                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl overflow-hidden z-20">
                                            <div class="py-2">
                                                <div id="notification-items">
                                                    {{-- Las notificaciones se cargarán aquí dinámicamente --}}
                                                    <p class="py-4 px-4 text-sm text-gray-500 text-center">Cargando...</p>
                                                </div>
                                                <a href="{{ route('clientes.notifications.index') }}" class="block bg-gray-50 text-center py-2 text-sm font-medium text-blue-600 hover:bg-gray-100">Ver todas las notificaciones</a>
                                            </div>
                                        </div>
                                        
                                        <a href="{{ route('clientes.profile.show') }}"
                                           class="text-white hover:text-orange-500 transition duration-200 flex items-center p-6 rounded-full hover:bg-white hover:bg-opacity-10 relative group">
                                            <i class="fas fa-user"></i>
                                            <span class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">
                                                Mi Perfil
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('clientes.profile.show') }}"
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
                            <a href="{{ route('clientes.profile.show') }}" class="text-white hover:text-orange-300 transition block py-2">
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

    <!-- Footer solo para clientes -->
    @auth
        @if(auth()->user()->idRolUsu == 2)
            @include('partials.clienteFooter')
        @endif
    @endauth

    @stack('scripts')
    
    @php
        $flashSuccess = session('success') ?? session('status');
    @endphp
    @if ($flashSuccess)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var mensaje = @json($flashSuccess);
            if (window.mostrarNotificacion) {
                window.mostrarNotificacion(mensaje, 'success');
            } else {
                var notificacion = document.createElement('div');
                notificacion.className = 'fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 transition-all duration-300 bg-green-500 text-white';
                notificacion.innerHTML = '<div class="flex items-center"><i class="fas fa-check-circle mr-2"></i><span>' + mensaje + '</span></div>';
                document.body.appendChild(notificacion);
                setTimeout(function() {
                    notificacion.style.opacity = '0';
                    setTimeout(function() {
                        if (document.body.contains(notificacion)) {
                            document.body.removeChild(notificacion);
                        }
                    }, 300);
                }, 3000);
            }
        });
    </script>
    @endif
    
    <!-- JavaScript del carrito -->
    <script>
        // Funcionalidad global del carrito de compras
        document.addEventListener('DOMContentLoaded', function() {
            // Funcionalidad del carrito
            const agregarCarritoBtns = document.querySelectorAll('.agregar-carrito-btn');
            
            agregarCarritoBtns.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Verificar si el usuario está autenticado
                    @auth
                        agregarAlCarrito(this);
                    @else
                        // Si no está autenticado, redirigir al login
                        window.location.href = "{{ route('login') }}";
                    @endauth
                });
            });

            // Función para agregar al carrito
            function agregarAlCarrito(btn) {
                const productoId = btn.getAttribute('data-producto-id');
                const productoNombre = btn.getAttribute('data-producto-nombre');
                const productoPrecio = btn.getAttribute('data-producto-precio');
                const productoStock = parseInt(btn.getAttribute('data-producto-stock'));
                const cantidadInputId = btn.getAttribute('data-cantidad-input');
                
                // Obtener cantidad (desde input personalizado o por defecto 1)
                let cantidad = 1;
                if (cantidadInputId) {
                    const cantidadInput = document.getElementById(cantidadInputId);
                    if (cantidadInput) {
                        cantidad = parseInt(cantidadInput.value) || 1;
                    }
                }
                
                // Mostrar loading
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Agregando...';
                btn.disabled = true;
                
                // Crear formulario para enviar datos
                const formData = new FormData();
                formData.append('producto_id', productoId);
                formData.append('cantidad', cantidad);
                formData.append('_token', '{{ csrf_token() }}');
                
                // Enviar petición
                fetch('{{ route("clientes.carrito.agregar") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Mostrar mensaje de éxito
                        mostrarNotificacion('Producto agregado al carrito', 'success');
                        
                        // Actualizar contador del carrito si existe
                        actualizarContadorCarrito();
                        
                        // Actualizar botón si el stock se agotó
                        if (productoStock === 1) {
                            btn.innerHTML = '<i class="fas fa-times mr-1"></i>Agotado';
                            btn.classList.remove('bg-green-500', 'hover:bg-green-600', 'bg-blue-600', 'hover:bg-blue-700');
                            btn.classList.add('bg-gray-400', 'cursor-not-allowed');
                        }
                    } else {
                        mostrarNotificacion(data.message || 'Error al agregar el producto', 'error');
                        // Restaurar botón
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    mostrarNotificacion('Error de conexión', 'error');
                    // Restaurar botón
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                });
            }

            // Función para mostrar notificaciones
            function mostrarNotificacion(mensaje, tipo) {
                const notificacion = document.createElement('div');
                notificacion.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 transition-all duration-300 ${
                    tipo === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
                }`;
                notificacion.innerHTML = `
                    <div class="flex items-center">
                        <i class="fas ${tipo === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} mr-2"></i>
                        <span>${mensaje}</span>
                    </div>
                `;
                
                document.body.appendChild(notificacion);
                
                // Remover después de 3 segundos
                setTimeout(() => {
                    notificacion.style.opacity = '0';
                    setTimeout(() => {
                        if (document.body.contains(notificacion)) {
                            document.body.removeChild(notificacion);
                        }
                    }, 300);
                }, 3000);
            }

            // Función para actualizar contador del carrito
            function actualizarContadorCarrito() {
                fetch('{{ route("clientes.carrito.cantidad") }}')
                    .then(response => response.json())
                    .then(data => {
                        const carritoCounters = document.querySelectorAll('.carrito-counter');
                        carritoCounters.forEach(counter => {
                            counter.textContent = data.cantidad;
                            if (data.cantidad > 0) {
                                counter.classList.remove('hidden');
                            } else {
                                counter.classList.add('hidden');
                            }
                        });
                    })
                    .catch(error => console.error('Error actualizando contador:', error));
            }

            // Hacer funciones globales para uso en otras vistas
            window.agregarAlCarrito = agregarAlCarrito;
            window.mostrarNotificacion = mostrarNotificacion;
            window.actualizarContadorCarrito = actualizarContadorCarrito;
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const notificacionesLink = document.getElementById('notificaciones-link');
            const notificacionesDropdown = document.getElementById('notificaciones-dropdown');
            const notificacionesCount = document.getElementById('notificaciones-count');
            const notificacionesList = document.getElementById('notificaciones-list');

            if (notificacionesLink) { // Solo ejecutar si el usuario es cliente
                function fetchNotifications() {
                     fetch('{{ route("clientes.notifications.getUnread") }}', {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                     })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            notificacionesList.innerHTML = ''; // Limpiar lista

                            if (data.count > 0) {
                                notificacionesCount.textContent = data.count;
                                notificacionesCount.style.display = 'flex';

                                if (data.notifications.length > 0) {
                                    data.notifications.forEach(notification => {
                                        const a = document.createElement('a');
                                        a.href = notification.data.url || '#';
                                        a.className = 'block py-3 px-4 hover:bg-gray-100';

                                        const p1 = document.createElement('p');
                                        p1.className = 'text-sm text-gray-800';
                                        p1.textContent = notification.data.message;

                                        const p2 = document.createElement('p');
                                        p2.className = 'text-xs text-gray-500';
                                        p2.textContent = notification.created_at_human;

                                        a.appendChild(p1);
                                        a.appendChild(p2);
                                        notificacionesList.appendChild(a);
                                    });
                                } else {
                                    notificacionesList.innerHTML = '<p class="py-4 px-4 text-sm text-gray-500 text-center">No tienes notificaciones nuevas.</p>';
                                }
                            } else {
                                notificacionesCount.style.display = 'none';
                                notificacionesList.innerHTML = '<p class="py-4 px-4 text-sm text-gray-500 text-center">No tienes notificaciones nuevas.</p>';
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching notifications:', error);
                            // Simplificado: Mostrar un mensaje de error limpio
                            notificacionesList.innerHTML = '<p class="py-4 px-4 text-sm text-red-500 text-center">Error al cargar notificaciones.</p>';
                        });
                }

                notificacionesLink.addEventListener('click', function (e) {
                    e.preventDefault();
                    notificacionesDropdown.classList.toggle('hidden');
                });

                document.addEventListener('click', function (e) {
                    const container = document.getElementById('notification-container');
                    if (container && !container.contains(e.target)) {
                        notificacionesDropdown.classList.add('hidden');
                    }
                });

                // Cargar notificaciones al cargar la página
                fetchNotifications();

                // Opcional: Recargar notificaciones periódicamente
                // setInterval(fetchNotifications, 60000); // cada 60 segundos
            }
        });
    </script>
</body>
</html>