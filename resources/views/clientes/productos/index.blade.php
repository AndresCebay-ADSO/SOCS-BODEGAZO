@extends('layouts.app')

@section('title', 'Productos - El Bodegazo')

@section('content')
<div class="container mx-auto py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-primary-600">Nuestros Productos</h1>
        @auth
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.productos.create') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition flex items-center">
                    <i class="fas fa-plus mr-2"></i> Agregar producto
                </a>
            @endif
        @endauth
    </div>

    <!-- Productos -->
    @if($productos->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($productos as $producto)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition transform hover:-translate-y-1">
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
                <div class="p-4">
                    <div class="text-gray-500 text-sm mb-1">{{ $producto->categoria->nomCat ?? 'Sin categoría' }}</div>
                    <h3 class="font-semibold mb-2 text-gray-800">{{ $producto->nomPro }}</h3>
                    <div class="text-sm text-gray-600 mb-2">
                        <span class="font-medium">Marca:</span> {{ $producto->marPro }}
                    </div>
                    <div class="text-sm text-gray-600 mb-2">
                        <span class="font-medium">Color:</span> {{ $producto->colPro }}
                    </div>
                    <div class="text-sm text-gray-600 mb-2">
                        <span class="font-medium">Talla:</span> {{ $producto->tallPro }}
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-xl font-bold text-gray-900">${{ number_format($producto->precio_venta, 2) }}</span>
                            @if($producto->precio_venta < $producto->precio_compra)
                                <span class="text-sm text-gray-500 line-through ml-2">${{ number_format($producto->precio_compra, 2) }}</span>
                            @endif
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('clientes.productos.show', $producto->idPro) }}" 
                               class="bg-primary-500 text-white px-3 py-1 rounded text-sm hover:bg-primary-600 transition">
                                Ver detalles
                            </a>
                            <form action="{{ route('clientes.carrito.agregar') }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="producto_id" value="{{ $producto->idPro }}">
                                <input type="hidden" name="cantidad" value="1">
                                <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600 transition">
                                    <i class="fas fa-cart-plus"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Paginación -->
        <div class="mt-8">
            {{ $productos->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <i class="fas fa-search text-4xl text-gray-400 mb-4"></i>
            <h3 class="text-lg font-semibold text-gray-600 mb-2">No se encontraron productos</h3>
            <p class="text-gray-500">Intenta con otros filtros de búsqueda</p>
        </div>
    @endif
</div>
@endsection 