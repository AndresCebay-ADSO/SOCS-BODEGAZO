<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Bodegazo - Tu tienda de confianza</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .bg-primary-500 { background-color: #1e40af; }
        .bg-secondary-800 { background-color: #1f2937; }
        .bg-secondary-100 { background-color: #f3f4f6; }
        .text-secondary-200 { color: #e5e7eb; }
        .hover\:bg-blue-100:hover { background-color: #dbeafe; }
        .hover\:text-primary-500:hover { color: #1e40af; }
        .category-scroll::-webkit-scrollbar { height: 4px; }
        .category-scroll::-webkit-scrollbar-track { background: #f1f1f1; }
        .category-scroll::-webkit-scrollbar-thumb { background: #c1c1c1; border-radius: 2px; }
        .category-scroll::-webkit-scrollbar-thumb:hover { background: #a8a8a8; }
    </style>
</head>
@auth
    @if(auth()->user()->idRolUsu == 2)
        <script>window.location.href = "{{ route('clientes.dashboard') }}";</script>
    @elseif(auth()->user()->idRolUsu == 1)
        <script>window.location.href = "{{ route('admin.dashboard') }}";</script>
    @elseif(auth()->user()->idRolUsu == 3)
        <script>window.location.href = "{{ route('superadmin.dashboard') }}";</script>
    @endif
@endauth
<body class="bg-gray-100 font-sans">
    <!-- Barra de navegación -->
    <nav class="bg-primary-500 py-3 px-4 shadow-md sticky top-0 z-50">
        <div class="container mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
            <!-- Logo y buscador (mobile) -->
            <div class="w-full md:w-auto flex justify-between items-center">
                <a href="{{ route('login') }}" class="text-2xl font-bold text-white">El Bodegazo</a>
                <button class="md:hidden text-white" id="menu-toggle">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
            
            <!-- Buscador (desktop) -->
            <div class="w-full md:w-1/2">
                <form action="#" method="GET" class="flex" id="search-form">
                    <input type="text" placeholder="Buscar productos..." 
                        class="w-full px-4 py-2 rounded-l-md focus:outline-none border-0">
                    <button type="submit" class="bg-secondary-800 text-white px-4 py-2 rounded-r-md hover:bg-gray-900 transition">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
            
            <!-- Menú usuario/carrito -->
            <div class="flex items-center space-x-6">
                <a href="{{ route('login') }}" class="text-white hover:text-secondary-200 transition">
                    <i class="fas fa-user mr-1"></i> Mi cuenta
                </a>
                <a href="{{ route('login') }}" class="text-white hover:text-secondary-200 transition relative">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">0</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Categorías destacadas -->
    <div class="bg-white py-4 shadow-sm sticky top-16 z-40">
        <div class="container mx-auto px-4">
            <div class="category-scroll flex overflow-x-auto space-x-8 pb-2">
                <a href="#" class="flex flex-col items-center min-w-fit hover:text-primary-500 transition" data-require-login>
                    <div class="bg-secondary-100 p-3 rounded-full mb-1 hover:bg-blue-100 transition">
                        <i class="fas fa-running text-xl text-gray-800"></i>
                    </div>
                    <span class="text-sm font-medium">Deportivos</span>
                </a>
                <a href="#" class="flex flex-col items-center min-w-fit hover:text-primary-500 transition" data-require-login>
                    <div class="bg-secondary-100 p-3 rounded-full mb-1 hover:bg-blue-100 transition">
                        <i class="fas fa-briefcase text-xl text-gray-800"></i>
                    </div>
                    <span class="text-sm font-medium">Formales</span>
                </a>
                <a href="#" class="flex flex-col items-center min-w-fit hover:text-primary-500 transition" data-require-login>
                    <div class="bg-secondary-100 p-3 rounded-full mb-1 hover:bg-blue-100 transition">
                        <i class="fas fa-tshirt text-xl text-gray-800"></i>
                    </div>
                    <span class="text-sm font-medium">Casuales</span>
                </a>
                <a href="#" class="flex flex-col items-center min-w-fit hover:text-primary-500 transition" data-require-login>
                    <div class="bg-secondary-100 p-3 rounded-full mb-1 hover:bg-blue-100 transition">
                        <i class="fas fa-child text-xl text-gray-800"></i>
                    </div>
                    <span class="text-sm font-medium">Niños</span>
                </a>
                <a href="#" class="flex flex-col items-center min-w-fit hover:text-primary-500 transition" data-require-login>
                    <div class="bg-secondary-100 p-3 rounded-full mb-1 hover:bg-blue-100 transition">
                        <i class="fas fa-female text-xl text-gray-800"></i>
                    </div>
                    <span class="text-sm font-medium">Damas</span>
                </a>
                <a href="#" class="flex flex-col items-center min-w-fit hover:text-primary-500 transition" data-require-login>
                    <div class="bg-secondary-100 p-3 rounded-full mb-1 hover:bg-blue-100 transition">
                        <i class="fas fa-male text-xl text-gray-800"></i>
                    </div>
                    <span class="text-sm font-medium">Caballeros</span>
                </a>
                <a href="#" class="flex flex-col items-center min-w-fit hover:text-primary-500 transition" data-require-login>
                    <div class="bg-secondary-100 p-3 rounded-full mb-1 hover:bg-blue-100 transition">
                        <i class="fas fa-shoe-prints text-xl text-gray-800"></i>
                    </div>
                    <span class="text-sm font-medium">Calzado</span>
                </a>
                <a href="#" class="flex flex-col items-center min-w-fit hover:text-primary-500 transition" data-require-login>
                    <div class="bg-secondary-100 p-3 rounded-full mb-1 hover:bg-blue-100 transition">
                        <i class="fas fa-shopping-bag text-xl text-gray-800"></i>
                    </div>
                    <span class="text-sm font-medium">Accesorios</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                Bienvenido a <span class="text-yellow-300">El Bodegazo</span>
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-blue-100">
                Tu tienda de confianza para encontrar los mejores productos
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('login') }}" class="bg-yellow-400 text-blue-900 px-8 py-3 rounded-lg font-semibold hover:bg-yellow-300 transition duration-300">
                    <i class="fas fa-sign-in-alt mr-2"></i>Iniciar Sesión
                </a>
                <a href="{{ route('register') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-900 transition duration-300">
                    <i class="fas fa-user-plus mr-2"></i>Registrarse
                </a>
            </div>
        </div>
    </section>

    <!-- Productos Destacados -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">
                Productos Destacados
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Producto 1 -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300 hover:scale-105">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" 
                             alt="Zapatillas Deportivas" class="w-full h-48 object-cover">
                        <div class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded-full text-sm font-semibold">
                            -20%
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-lg mb-2">Zapatillas Deportivas</h3>
                        <p class="text-gray-600 text-sm mb-3">Comodidad y estilo para tus actividades deportivas</p>
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-gray-400 line-through">$89.99</span>
                                <span class="text-xl font-bold text-blue-600 ml-2">$71.99</span>
                            </div>
                            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition" data-require-login>
                                <i class="fas fa-shopping-cart mr-1"></i>Agregar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Producto 2 -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300 hover:scale-105">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1551028719-00167b16eac5?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" 
                             alt="Camisa Formal" class="w-full h-48 object-cover">
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-lg mb-2">Camisa Formal</h3>
                        <p class="text-gray-600 text-sm mb-3">Elegancia y profesionalismo para la oficina</p>
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-xl font-bold text-blue-600">$45.99</span>
                            </div>
                            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition" data-require-login>
                                <i class="fas fa-shopping-cart mr-1"></i>Agregar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Producto 3 -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300 hover:scale-105">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" 
                             alt="Jeans Casuales" class="w-full h-48 object-cover">
                        <div class="absolute top-2 right-2 bg-green-500 text-white px-2 py-1 rounded-full text-sm font-semibold">
                            Nuevo
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-lg mb-2">Jeans Casuales</h3>
                        <p class="text-gray-600 text-sm mb-3">Estilo casual y comodidad para el día a día</p>
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-xl font-bold text-blue-600">$59.99</span>
                            </div>
                            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition" data-require-login>
                                <i class="fas fa-shopping-cart mr-1"></i>Agregar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Producto 4 -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300 hover:scale-105">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" 
                             alt="Tenis Urbanos" class="w-full h-48 object-cover">
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-lg mb-2">Tenis Urbanos</h3>
                        <p class="text-gray-600 text-sm mb-3">Estilo urbano y comodidad para la ciudad</p>
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-xl font-bold text-blue-600">$79.99</span>
                            </div>
                            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition" data-require-login>
                                <i class="fas fa-shopping-cart mr-1"></i>Agregar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Características -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">
                ¿Por qué elegirnos?
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-blue-600 text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shipping-fast text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Envío Rápido</h3>
                    <p class="text-gray-600">Entregamos en 24-48 horas en toda la ciudad</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-blue-600 text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shield-alt text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Garantía</h3>
                    <p class="text-gray-600">Todos nuestros productos tienen garantía de calidad</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-blue-600 text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-headset text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Soporte 24/7</h3>
                    <p class="text-gray-600">Atención al cliente disponible todo el día</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">El Bodegazo</h3>
                    <p class="text-gray-300">Tu tienda de confianza para encontrar los mejores productos al mejor precio.</p>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">Enlaces Rápidos</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('login') }}" class="text-gray-300 hover:text-white transition">Iniciar Sesión</a></li>
                        <li><a href="{{ route('register') }}" class="text-gray-300 hover:text-white transition">Registrarse</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition" data-require-login>Productos</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition" data-require-login>Ofertas</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">Categorías</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition" data-require-login>Deportivos</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition" data-require-login>Formales</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition" data-require-login>Casuales</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition" data-require-login>Accesorios</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">Contacto</h4>
                    <ul class="space-y-2">
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-2"></i>
                            <span class="text-gray-300">+57 300 123 4567</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-2"></i>
                            <span class="text-gray-300">info@elbodegazo.com</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            <span class="text-gray-300">Calle 123 #45-67, Bogotá</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p class="text-gray-300">&copy; 2024 El Bodegazo. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Redirección forzada para cualquier acción
        const protectedElements = document.querySelectorAll(
            '[data-require-login], #search-form, [href="#"]'
        );

        protectedElements.forEach(element => {
            element.addEventListener('click', function(e) {
                e.preventDefault();
                // Redirigir inmediatamente al login
                window.location.href = "{{ route('login') }}";
            });
        });

        // Redirección por inactividad (5 segundos)
        let inactivityTimer = setTimeout(() => {
            window.location.href = "{{ route('login') }}";
        }, 5000);

        // Resetear temporizador con interacción
        const resetTimer = () => {
            clearTimeout(inactivityTimer);
            inactivityTimer = setTimeout(() => {
                window.location.href = "{{ route('login') }}";
            }, 5000);
        };

        // Eventos para resetear
        ['mousemove', 'keydown', 'click', 'scroll'].forEach(event => {
            document.addEventListener(event, resetTimer);
        });
    });
</script>
</body>
</html>