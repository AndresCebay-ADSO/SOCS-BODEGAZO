@extends('layouts.app')

@section('title', 'Dashboard - El Bodegazo')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-6xl font-bold mb-6">
            ¡Bienvenido, <span class="text-yellow-300">{{ auth()->user()->nomUsu }}!</span>
        </h1>
        <p class="text-xl md:text-2xl mb-8 text-blue-100">
            Descubre los mejores productos en El Bodegazo
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('clientes.productos.index') }}" class="bg-yellow-400 text-blue-900 px-8 py-3 rounded-lg font-semibold hover:bg-yellow-300 transition duration-300">
                <i class="fas fa-shopping-bag mr-2"></i>Ver Productos
            </a>
            <a href="{{ route('clientes.categorias') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-900 transition duration-300">
                <i class="fas fa-th-large mr-2"></i>Explorar Categorías
            </a>
        </div>
    </div>
</section>

<!-- Accesos Rápidos -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">
            Accesos Rápidos
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Productos -->
            <a href="{{ route('clientes.productos.index') }}" class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                <div class="bg-blue-600 text-white p-6 text-center">
                    <i class="fas fa-shopping-bag text-4xl mb-4"></i>
                    <h3 class="text-xl font-bold">Productos</h3>
                </div>
                <div class="p-6 text-center">
                    <p class="text-gray-600">Explora nuestro catálogo completo de productos</p>
                </div>
            </a>

            <!-- Categorías -->
            <a href="{{ route('clientes.categorias') }}" class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                <div class="bg-green-600 text-white p-6 text-center">
                    <i class="fas fa-th-large text-4xl mb-4"></i>
                    <h3 class="text-xl font-bold">Categorías</h3>
                </div>
                <div class="p-6 text-center">
                    <p class="text-gray-600">Navega por nuestras categorías organizadas</p>
                </div>
            </a>

            <!-- Mi Carrito -->
            <a href="{{ route('clientes.carrito.index') }}" class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                <div class="bg-orange-600 text-white p-6 text-center">
                    @php
                        $carrito = session('carrito', []);
                        $cantidad = array_sum($carrito);
                    @endphp
                    <i class="fas fa-shopping-cart text-4xl mb-4"></i>
                    <h3 class="text-xl font-bold">Mi Carrito</h3>
                    @if($cantidad > 0)
                        <span class="bg-red-500 text-white text-xs rounded-full px-2 py-1 mt-2 inline-block">{{ $cantidad }} items</span>
                    @endif
                </div>
                <div class="p-6 text-center">
                    <p class="text-gray-600">Gestiona tus productos seleccionados</p>
                </div>
            </a>

            <!-- Mis Pedidos -->
            <a href="{{ route('clientes.pedidos.index') }}" class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                <div class="bg-purple-600 text-white p-6 text-center">
                    <i class="fas fa-history text-4xl mb-4"></i>
                    <h3 class="text-xl font-bold">Mis Pedidos</h3>
                </div>
                <div class="p-6 text-center">
                    <p class="text-gray-600">Consulta tu historial de compras</p>
                </div>
            </a>

            <!-- Mi Perfil -->
            <a href="{{ route('clientes.profile') }}" class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                <div class="bg-orange-600 text-white p-6 text-center">
                    <i class="fas fa-user text-4xl mb-4"></i>
                    <h3 class="text-xl font-bold">Mi Perfil</h3>
                </div>
                <div class="p-6 text-center">
                    <p class="text-gray-600">Gestiona tus datos personales</p>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- Productos Destacados -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">
            Productos Destacados
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($productosDestacados as $producto)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                <div class="relative">
                    <img src="{{ $producto->imagen_url }}" 
                         alt="{{ $producto->nomPro }}" class="w-full h-48 object-cover">
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-lg mb-2">{{ $producto->nomPro }}</h3>
                    <p class="text-gray-600 text-sm mb-3">{{ Str::limit($producto->desPro, 60) }}</p>
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-xl font-bold text-blue-600">${{ number_format($producto->precio_venta, 0, ',', '.') }}</span>
                        </div>
                        <a href="{{ route('clientes.productos.show', $producto) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-shopping-cart mr-1"></i>Ver
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
                <p class="text-xl text-gray-500">No hay productos destacados en este momento.</p>
                <p class="text-gray-400 mt-2">Vuelve a intentarlo más tarde.</p>
            </div>
            @endforelse
        </div>

        <div class="mt-12">
            {{ $productosDestacados->links() }}
        </div>
    </div>
</section>

<!-- Características -->
<section class="py-16 bg-white">
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

<!-- Acciones Rápidas -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">
            Acciones Rápidas
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <a href="{{ route('clientes.pedidos.create') }}" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-8 rounded-lg shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                <div class="text-center">
                    <i class="fas fa-plus-circle text-5xl mb-4"></i>
                    <h3 class="text-2xl font-bold mb-2">Nuevo Pedido</h3>
                    <p class="text-blue-100">Realiza una nueva compra de productos</p>
                </div>
            </a>
            
            <a href="{{ route('clientes.pedidos.index') }}" class="bg-gradient-to-r from-green-600 to-green-700 text-white p-8 rounded-lg shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                <div class="text-center">
                    <i class="fas fa-history text-5xl mb-4"></i>
                    <h3 class="text-2xl font-bold mb-2">Historial</h3>
                    <p class="text-green-100">Revisa tus pedidos anteriores</p>
                </div>
            </a>
            
            <a href="{{ route('clientes.profile') }}" class="bg-gradient-to-r from-purple-600 to-purple-700 text-white p-8 rounded-lg shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                <div class="text-center">
                    <i class="fas fa-user-edit text-5xl mb-4"></i>
                    <h3 class="text-2xl font-bold mb-2">Editar Perfil</h3>
                    <p class="text-purple-100">Actualiza tus datos personales</p>
                </div>
            </a>
        </div>
    </div>
</section>
@endsection