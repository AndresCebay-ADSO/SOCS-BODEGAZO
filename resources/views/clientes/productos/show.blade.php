@extends('layouts.app')

@section('title', $producto->nomPro . ' - El Bodegazo')

@section('content')
<div class="container mx-auto py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li><a href="{{ route('clientes.productos.index') }}" class="hover:text-primary-500">Productos</a></li>
                <li><i class="fas fa-chevron-right"></i></li>
                <li><a href="{{ route('clientes.productos.categoria', $producto->categoria->idCat) }}" class="hover:text-primary-500">{{ $producto->categoria->nomCat }}</a></li>
                <li><i class="fas fa-chevron-right"></i></li>
                <li class="text-gray-900">{{ $producto->nomPro }}</li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Imagen del producto -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="w-full h-96 bg-gray-100 flex items-center justify-center p-4">
                    <img src="{{ $producto->imagen_url }}" 
                         alt="{{ $producto->nomPro }}" 
                         class="max-w-full max-h-full object-contain"
                         onerror="this.src='{{ asset('images/default-product.png') }}'">
                </div>
            </div>

            <!-- Información del producto -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="mb-4">
                    <span class="inline-block bg-primary-100 text-primary-800 text-xs px-2 py-1 rounded-full mb-2">
                        {{ $producto->categoria->nomCat }}
                    </span>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $producto->nomPro }}</h1>
                    <p class="text-gray-600">{{ $producto->descripcion }}</p>
                </div>

                <!-- Precio -->
                <div class="mb-6">
                    <div class="flex items-center">
                        <span class="text-3xl font-bold text-gray-900">${{ number_format($producto->precio_venta, 2) }}</span>
                        @if($producto->precio_venta < $producto->precio_compra)
                            <span class="text-lg text-gray-500 line-through ml-3">${{ number_format($producto->precio_compra, 2) }}</span>
                            <span class="bg-red-500 text-white text-sm px-2 py-1 rounded ml-3">
                                {{ round((($producto->precio_compra - $producto->precio_venta) / $producto->precio_compra) * 100) }}% OFF
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Detalles del producto -->
                <div class="space-y-4 mb-6">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Marca:</span>
                        <span class="font-medium">{{ $producto->marPro }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Código:</span>
                        <span class="font-medium">{{ $producto->codPro }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Color:</span>
                        <span class="font-medium">{{ $producto->colPro }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Talla:</span>
                        <span class="font-medium">{{ $producto->tallPro }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Unidad de medida:</span>
                        <span class="font-medium">{{ $producto->unidad_medida }}</span>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="space-y-3">
                    <form action="{{ route('clientes.carrito.agregar') }}" method="POST" class="space-y-3">
                        @csrf
                        <input type="hidden" name="producto_id" value="{{ $producto->idPro }}">
                        <div class="flex items-center space-x-2">
                            <label class="text-sm font-medium text-gray-700">Cantidad:</label>
                            <input type="number" name="cantidad" value="1" min="1" max="{{ $producto->canPro }}" 
                                   class="w-20 px-2 py-1 border border-gray-300 rounded text-center">
                        </div>
                        <button type="submit" class="w-full bg-primary-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-primary-600 transition">
                            <i class="fas fa-cart-plus mr-2"></i>Agregar al Carrito
                        </button>
                    </form>
                    <a href="{{ route('clientes.productos.index') }}" 
                       class="w-full bg-gray-200 text-gray-800 py-3 px-6 rounded-lg font-semibold hover:bg-gray-300 transition text-center block">
                        <i class="fas fa-arrow-left mr-2"></i>Volver a Productos
                    </a>
                </div>
            </div>
        </div>

        <!-- Productos relacionados -->
        @if($productosRelacionados->count() > 0)
        <div class="mt-12">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Productos Relacionados</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($productosRelacionados as $relacionado)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition transform hover:-translate-y-1">
                    <div class="relative">
                        <div class="w-full h-48 bg-gray-100 flex items-center justify-center overflow-hidden">
                            <img src="{{ $relacionado->imagen_url }}" 
                                 alt="{{ $relacionado->nomPro }}" 
                                 class="w-full h-full object-contain p-2"
                                 onerror="this.src='{{ asset('images/default-product.png') }}'">
                        </div>
                        @if($relacionado->precio_venta < $relacionado->precio_compra)
                            <span class="absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-1 rounded">
                                {{ round((($relacionado->precio_compra - $relacionado->precio_venta) / $relacionado->precio_compra) * 100) }}% OFF
                            </span>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold mb-2 text-gray-800">{{ $relacionado->nomPro }}</h3>
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-bold text-gray-900">${{ number_format($relacionado->precio_venta, 2) }}</span>
                            <a href="{{ route('clientes.productos.show', $relacionado->idPro) }}" 
                               class="bg-primary-500 text-white px-3 py-1 rounded text-sm hover:bg-primary-600 transition">
                                Ver
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection 