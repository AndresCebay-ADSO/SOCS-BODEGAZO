@extends('layouts.app')

@section('title', 'Categorías - El Bodegazo')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6 text-primary-600">Categorías de Productos</h1>
    
    <!-- Filtro de categorías -->
    <div class="mb-8">
        <div class="flex flex-wrap gap-4">
            <button onclick="filtrarCategoria('todas')" class="categoria-btn bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-600 transition">
                <i class="fas fa-th-large mr-2"></i>Todas
            </button>
            @foreach($categorias as $categoria)
                <button onclick="filtrarCategoria('{{ $categoria->idCat }}')" class="categoria-btn bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-primary-500 hover:text-white transition">
                    <i class="fas fa-tag mr-2"></i>{{ $categoria->nomCat }}
                </button>
            @endforeach
        </div>
    </div>

    <!-- Productos por categoría -->
    <div id="productos-container">
        <!-- Categoría: Todas -->
        <div class="categoria-productos" data-categoria="todas">
            <h2 class="text-2xl font-bold mb-6 text-gray-800 flex items-center">
                <i class="fas fa-th-large text-primary-500 mr-3"></i>Todos los Productos
            </h2>
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
                            <a href="{{ route('clientes.productos.show', $producto->idPro) }}" 
                               class="bg-primary-500 text-white px-3 py-1 rounded text-sm hover:bg-primary-600 transition">
                                Ver detalles
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        @foreach($categorias as $categoria)
        <!-- Categoría: {{ $categoria->nomCat }} -->
        <div class="categoria-productos" data-categoria="{{ $categoria->idCat }}">
            <h2 class="text-2xl font-bold mb-6 text-gray-800 flex items-center">
                <i class="fas fa-tag text-primary-500 mr-3"></i>{{ $categoria->nomCat }}
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($productos->where('idcatPro', $categoria->idCat) as $producto)
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
                            <a href="{{ route('clientes.productos.show', $producto->idPro) }}" 
                               class="bg-primary-500 text-white px-3 py-1 rounded text-sm hover:bg-primary-600 transition">
                                Ver detalles
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
function filtrarCategoria(categoria) {
    // Resetear todos los botones
    document.querySelectorAll('.categoria-btn').forEach(btn => {
        btn.classList.remove('bg-primary-500', 'text-white');
        btn.classList.add('bg-gray-200', 'text-gray-700');
    });
    
    // Activar el botón seleccionado
    event.target.classList.remove('bg-gray-200', 'text-gray-700');
    event.target.classList.add('bg-primary-500', 'text-white');
    
    // Mostrar/ocultar categorías
    const categorias = document.querySelectorAll('.categoria-productos');
    
    if (categoria === 'todas') {
        categorias.forEach(cat => {
            cat.style.display = 'block';
        });
    } else {
        categorias.forEach(cat => {
            if (cat.dataset.categoria === categoria) {
                cat.style.display = 'block';
            } else {
                cat.style.display = 'none';
            }
        });
    }
}

// Mostrar todas las categorías por defecto
document.addEventListener('DOMContentLoaded', function() {
    filtrarCategoria('todas');
});
</script>
@endsection 
