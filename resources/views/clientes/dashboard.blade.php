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
            <!-- Producto 1 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
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
                        <a href="{{ route('clientes.productos.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-shopping-cart mr-1"></i>Ver
                        </a>
                    </div>
                </div>
            </div>

            <!-- Producto 2 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
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
                        <a href="{{ route('clientes.productos.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-shopping-cart mr-1"></i>Ver
                        </a>
                    </div>
                </div>
            </div>

            <!-- Producto 3 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
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
                        <a href="{{ route('clientes.productos.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-shopping-cart mr-1"></i>Ver
                        </a>
                    </div>
                </div>
            </div>

            <!-- Producto 4 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
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
                        <a href="{{ route('clientes.productos.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-shopping-cart mr-1"></i>Ver
                        </a>
                    </div>
                </div>
            </div>
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