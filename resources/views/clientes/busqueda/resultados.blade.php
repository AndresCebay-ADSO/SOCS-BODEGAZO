@extends('layouts.app')

@section('title', 'Resultados de Búsqueda')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-3xl font-bold text-gray-800">
                    <i class="fas fa-search text-primary-500 mr-3"></i>
                    Resultados de Búsqueda
                </h1>
                <a href="{{ route('clientes.productos.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Volver a Productos
                </a>
            </div>
            
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <p class="text-blue-800">
                    <i class="fas fa-info-circle mr-2"></i>
                    Buscaste: <strong>"{{ $query }}"</strong>
                    @if($productos->total() > 0)
                        - Se encontraron <strong>{{ $productos->total() }}</strong> resultados
                    @else
                        - No se encontraron resultados
                    @endif
                </p>
            </div>
        </div>

        @if($productos->total() > 0)
            <!-- Filtros -->
            <div class="bg-white rounded-lg shadow-md p-4 mb-6">
                <div class="flex flex-wrap items-center gap-4">
                    <span class="text-sm font-medium text-gray-700">Ordenar por:</span>
                    <select class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Más relevantes</option>
                        <option value="precio_asc">Precio: Menor a Mayor</option>
                        <option value="precio_desc">Precio: Mayor a Menor</option>
                        <option value="nombre_asc">Nombre: A-Z</option>
                        <option value="nombre_desc">Nombre: Z-A</option>
                    </select>
                </div>
            </div>

            <!-- Productos -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($productos as $producto)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                    <!-- Imagen del producto -->
                    <div class="relative">
                        <div class="w-full h-48 bg-gray-100 flex items-center justify-center overflow-hidden">
                            <img src="{{ $producto->imagen_url }}" 
                                 alt="{{ $producto->nomPro }}" 
                                 class="w-full h-full object-contain p-2"
                                 onerror="this.src='{{ asset('images/default-product.png') }}'">
                        </div>
                        @if($producto->precio_venta < $producto->precio_compra)
                            <span class="absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-1 rounded font-bold">
                                {{ round((($producto->precio_compra - $producto->precio_venta) / $producto->precio_compra) * 100) }}% OFF
                            </span>
                        @endif
                    </div>

                    <!-- Información del producto -->
                    <div class="p-4">
                        <div class="text-gray-500 text-sm mb-1">{{ $producto->categoria->nomCat ?? 'Sin categoría' }}</div>
                        <h3 class="font-semibold mb-2 text-gray-800 line-clamp-2">{{ $producto->nomPro }}</h3>
                        
                        <div class="text-sm text-gray-600 mb-2 space-y-1">
                            <div><span class="font-medium">Marca:</span> {{ $producto->marPro }}</div>
                            <div><span class="font-medium">Color:</span> {{ $producto->colPro }}</div>
                            <div><span class="font-medium">Talla:</span> {{ $producto->tallPro }}</div>
                        </div>

                        <div class="flex items-center justify-between mb-3">
                            <div>
                                <span class="text-xl font-bold text-gray-900">${{ number_format($producto->precio_venta, 2) }}</span>
                                @if($producto->precio_venta < $producto->precio_compra)
                                    <span class="text-sm text-gray-500 line-through ml-2">${{ number_format($producto->precio_compra, 2) }}</span>
                                @endif
                            </div>
                            <span class="text-sm text-gray-500">Stock: {{ $producto->canPro }}</span>
                        </div>

                        <!-- Botones de acción -->
                        <div class="flex space-x-2">
                            <a href="{{ route('clientes.productos.show', $producto->idPro) }}" 
                               class="flex-1 bg-primary-500 text-white px-3 py-2 rounded text-sm hover:bg-primary-600 transition text-center">
                                Ver detalles
                            </a>
                            <form action="{{ route('clientes.carrito.agregar') }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="producto_id" value="{{ $producto->idPro }}">
                                <input type="hidden" name="cantidad" value="1">
                                <button type="submit" class="bg-green-500 text-white px-3 py-2 rounded text-sm hover:bg-green-600 transition">
                                    <i class="fas fa-cart-plus"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Paginación -->
            @if($productos->hasPages())
                <div class="mt-8">
                    {{ $productos->appends(['q' => $query])->links() }}
                </div>
            @endif
        @else
            <!-- Sin resultados -->
            <div class="text-center py-12">
                <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
                <h2 class="text-2xl font-semibold text-gray-600 mb-4">No se encontraron resultados</h2>
                <p class="text-gray-500 mb-6">Intenta con otros términos de búsqueda o explora nuestras categorías</p>
                <div class="space-x-4">
                    <a href="{{ route('clientes.productos.index') }}" class="bg-primary-500 text-white px-6 py-3 rounded-lg hover:bg-primary-600 transition">
                        <i class="fas fa-shopping-bag mr-2"></i>Ver Todos los Productos
                    </a>
                    <a href="{{ route('clientes.categorias') }}" class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition">
                        <i class="fas fa-th-large mr-2"></i>Explorar Categorías
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection 