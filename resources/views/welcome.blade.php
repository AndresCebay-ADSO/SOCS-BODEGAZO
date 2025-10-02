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
    <nav class="bg-primary-500 py-8 px-8 shadow-md">
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
    <div class="bg-white py-4 shadow-sm">
        <div class="container mx-auto px-4">
            <div class="category-scroll flex overflow-x-auto space-x-8 pb-2">
                @foreach($categorias as $categoria)
                <a href="#" class="flex flex-col items-center min-w-fit hover:text-primary-500 transition" data-require-login>
                    <div class="bg-secondary-100 p-3 rounded-full mb-1 hover:bg-blue-100 transition">
                        <i class="fas fa-tag text-xl text-gray-800"></i>
                    </div>
                    <span class="text-sm font-medium">{{ $categoria->nomCat }}</span>
                </a>
                @endforeach
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
                @forelse($productosDestacados as $producto)
                <!-- Producto {{ $loop->iteration }} -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300 hover:scale-105">
                    <div class="relative">
                        <img src="{{ $producto->imaPro ? asset('storage/' . $producto->imaPro) : asset('images/default-product.png') }}" 
                             alt="{{ $producto->nomPro }}" class="w-full h-48 object-cover">
                        @if($producto->canPro <= 5)
                        <div class="absolute top-2 right-2 bg-orange-500 text-white px-2 py-1 rounded-full text-sm font-semibold">
                            ¡Últimas unidades!
                        </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-lg mb-2">{{ $producto->nomPro }}</h3>
                        <p class="text-gray-600 text-sm mb-3">{{ Str::limit($producto->desPro, 60) }}</p>
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-xl font-bold text-blue-600">${{ number_format($producto->precio_venta, 0, ',', '.') }}</span>
                                @if($producto->canPro > 0)
                                <div class="text-xs text-gray-500">Stock: {{ $producto->canPro }}</div>
                                @endif
                            </div>
                            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition agregar-carrito-btn" 
                                    data-producto-id="{{ $producto->idPro }}" 
                                    data-producto-nombre="{{ $producto->nomPro }}"
                                    data-producto-precio="{{ $producto->precio_venta }}"
                                    data-producto-stock="{{ $producto->canPro }}"
                                    @if($producto->canPro <= 0) disabled @endif>
                                <i class="fas fa-shopping-cart mr-1"></i>
                                @if($producto->canPro <= 0)
                                    Agotado
                                @else
                                    Agregar
                                @endif
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">No hay productos disponibles</h3>
                    <p class="text-gray-500">Pronto tendremos productos destacados para ti.</p>
                </div>
                @endforelse
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
            
            // Mostrar loading
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Agregando...';
            btn.disabled = true;
            
            // Crear formulario para enviar datos
            const formData = new FormData();
            formData.append('producto_id', productoId);
            formData.append('cantidad', 1);
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
                        btn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
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
                    document.body.removeChild(notificacion);
                }, 300);
            }, 3000);
        }

        // Función para actualizar contador del carrito
        function actualizarContadorCarrito() {
            fetch('{{ route("clientes.carrito.cantidad") }}')
                .then(response => response.json())
                .then(data => {
                    const carritoCounter = document.querySelector('.carrito-counter');
                    if (carritoCounter) {
                        carritoCounter.textContent = data.cantidad;
                        if (data.cantidad > 0) {
                            carritoCounter.classList.remove('hidden');
                        } else {
                            carritoCounter.classList.add('hidden');
                        }
                    }
                })
                .catch(error => console.error('Error actualizando contador:', error));
        }

        // Redirección forzada para elementos que requieren login
        const protectedElements = document.querySelectorAll('[data-require-login]');
        protectedElements.forEach(element => {
            element.addEventListener('click', function(e) {
                e.preventDefault();
                window.location.href = "{{ route('login') }}";
            });
        });
    });
</script>
</body>
</html>