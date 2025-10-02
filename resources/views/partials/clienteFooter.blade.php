<footer class="bg-gray-900 w-full">
    <!-- Grid principal -->
    <div class="w-full">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 px-6 py-12">
            <!-- Columna 1: Información de la empresa -->
            <div>
                <h3 class="text-lg font-bold text-white mb-4">El Bodegazo</h3>
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
                <h3 class="text-lg font-bold text-white mb-4">Enlaces Rápidos</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('welcome') }}" class="text-gray-400 hover:text-white transition">Inicio</a>
                    </li>
                    <li>
                        <a href="{{ route('clientes.productos.index') }}" class="text-gray-400 hover:text-white transition">Productos</a>
                    </li>
                    <li>
                        <a href="{{ route('clientes.carrito.index') }}" class="text-gray-400 hover:text-white transition">Carrito</a>
                    </li>
                </ul>
            </div>

            <!-- Columna 3: Políticas -->
            <div>
                <h3 class="text-lg font-bold text-white mb-4">Políticas</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('clientes.politicas.terminos') }}" class="text-gray-400 hover:text-white transition">Términos y Condiciones</a>
                    </li>
                    <li>
                        <a href="{{ route('clientes.politicas.privacidad') }}" class="text-gray-400 hover:text-white transition">Política de Privacidad</a>
                    </li>
                </ul>
            </div>

            <!-- Columna 4: Seguridad -->
            <div>
                <h3 class="text-lg font-bold text-white mb-4">Seguridad</h3>
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
    <div class="bg-gray-950 w-full">
        <div class="w-full px-6 py-4">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div class="text-gray-400 text-sm">
                    &copy; {{ date('Y') }} El Bodegazo. Todos los derechos reservados.
                </div>
                <div class="flex space-x-4">
                    <img src="{{ asset('images/payment-methods/visa.png') }}" alt="Visa" class="h-8">
                    <img src="{{ asset('images/payment-methods/mastercard.png') }}" alt="Mastercard" class="h-8">
                    <img src="{{ asset('images/payment-methods/nequi.png') }}" alt="Nequi" class="h-8">
                </div>
            </div>
        </div>
    </div>
</footer>