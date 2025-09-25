@extends('layouts.app')

@section('title', 'Mi Carrito de Compras')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">
                <i class="fas fa-shopping-cart text-primary-500 mr-3"></i>
                Mi Carrito de Compras
            </h1>
            <a href="{{ route('clientes.productos.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                <i class="fas fa-arrow-left mr-2"></i>Seguir Comprando
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            </div>
        @endif

        @if(empty($productos))
            <!-- Carrito vacío -->
            <div class="text-center py-12">
                <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-4"></i>
                <h2 class="text-2xl font-semibold text-gray-600 mb-4">Tu carrito está vacío</h2>
                <p class="text-gray-500 mb-6">Agrega algunos productos para comenzar a comprar</p>
                <a href="{{ route('clientes.productos.index') }}" class="bg-primary-500 text-white px-6 py-3 rounded-lg hover:bg-primary-600 transition">
                    <i class="fas fa-shopping-bag mr-2"></i>Ver Productos
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Lista de productos -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="p-6 border-b border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-800">Productos en el carrito</h2>
                        </div>
                        
                        <div class="divide-y divide-gray-200">
                            @foreach($productos as $item)
                            <div class="p-6 flex items-center space-x-4">
                                <!-- Imagen del producto -->
                                <div class="flex-shrink-0">
                                    <div class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden">
                                        <img src="{{ $item['producto']->imagen_url }}" 
                                             alt="{{ $item['producto']->nomPro }}"
                                             class="w-full h-full object-contain p-2"
                                             onerror="this.src='{{ asset('images/default-product.png') }}'">
                                    </div>
                                </div>

                                <!-- Información del producto -->
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg font-semibold text-gray-800 truncate">
                                        {{ $item['producto']->nomPro }}
                                    </h3>
                                    <p class="text-sm text-gray-500">
                                        Marca: {{ $item['producto']->marPro }} | 
                                        Color: {{ $item['producto']->colPro }} | 
                                        Talla: {{ $item['producto']->tallPro }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        Stock disponible: {{ $item['producto']->canPro }}
                                    </p>
                                </div>

                                <!-- Cantidad -->
                                <div class="flex items-center space-x-2">
                                    <button onclick="actualizarCantidad({{ $item['producto']->idPro }}, -1)" 
                                            class="w-8 h-8 bg-gray-200 text-gray-600 rounded-full flex items-center justify-center hover:bg-gray-300 transition">
                                        <i class="fas fa-minus text-xs"></i>
                                    </button>
                                    
                                    <span class="w-12 text-center font-semibold" id="cantidad-{{ $item['producto']->idPro }}">
                                        {{ $item['cantidad'] }}
                                    </span>
                                    
                                    <button onclick="actualizarCantidad({{ $item['producto']->idPro }}, 1)" 
                                            class="w-8 h-8 bg-gray-200 text-gray-600 rounded-full flex items-center justify-center hover:bg-gray-300 transition">
                                        <i class="fas fa-plus text-xs"></i>
                                    </button>
                                </div>

                                <!-- Precio -->
                                <div class="text-right">
                                    <p class="text-lg font-bold text-gray-800">
                                        ${{ number_format($item['subtotal'], 2) }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        ${{ number_format($item['producto']->precio_venta, 2) }} c/u
                                    </p>
                                </div>

                                <!-- Eliminar -->
                                <div class="flex-shrink-0">
                                    <form action="{{ route('clientes.carrito.eliminar', $item['producto']->idPro) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 transition" 
                                                onclick="return confirm('¿Estás seguro de que quieres eliminar este producto?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Acciones del carrito -->
                        <div class="p-6 border-t border-gray-200 bg-gray-50">
                            <div class="flex justify-between items-center">
                                <form action="{{ route('clientes.carrito.limpiar') }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 transition"
                                            onclick="return confirm('¿Estás seguro de que quieres limpiar el carrito?')">
                                        <i class="fas fa-trash mr-2"></i>Limpiar Carrito
                                    </button>
                                </form>
                                
                                <a href="{{ route('clientes.productos.index') }}" class="text-primary-600 hover:text-primary-800 transition">
                                    <i class="fas fa-plus mr-2"></i>Agregar Más Productos
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Resumen del pedido -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Resumen del Pedido</h2>
                        
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Productos ({{ count($productos) }})</span>
                                <span class="font-medium">{{ count($productos) }} items</span>
                            </div>
                            
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium">${{ number_format($total, 2) }}</span>
                            </div>
                            
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Envío</span>
                                <span class="font-medium text-green-600">Gratis</span>
                            </div>
                            
                            <hr class="border-gray-200">
                            
                            <div class="flex justify-between text-lg font-bold">
                                <span>Total</span>
                                <span class="text-primary-600">${{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        <a href="{{ route('clientes.carrito.checkout') }}" 
                           class="w-full bg-primary-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-primary-600 transition text-center block">
                            <i class="fas fa-credit-card mr-2"></i>Proceder al Pago
                        </a>
                        
                        <p class="text-xs text-gray-500 text-center mt-3">
                            <i class="fas fa-lock mr-1"></i>Pago seguro y encriptado
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
function actualizarCantidad(productoId, cambio) {
    const cantidadElement = document.getElementById(`cantidad-${productoId}`);
    let cantidadActual = parseInt(cantidadElement.textContent);
    let nuevaCantidad = cantidadActual + cambio;
    
    if (nuevaCantidad < 1) {
        nuevaCantidad = 1;
    }
    
    // Enviar actualización al servidor
    fetch('{{ route("clientes.carrito.actualizar") }}', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            producto_id: productoId,
            cantidad: nuevaCantidad
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            cantidadElement.textContent = nuevaCantidad;
            // Recargar la página para actualizar totales
            location.reload();
        } else {
            alert(data.message || 'Error al actualizar la cantidad');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al actualizar la cantidad');
    });
}
</script>
@endsection 