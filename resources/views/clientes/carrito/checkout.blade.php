@extends('layouts.app')

@section('title', 'Finalizar Compra')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">
                <i class="fas fa-credit-card text-primary-500 mr-3"></i>
                Finalizar Compra
            </h1>
            <a href="{{ route('clientes.carrito.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                <i class="fas fa-arrow-left mr-2"></i>Volver al Carrito
            </a>
        </div>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Formulario de pago -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">
                        <i class="fas fa-user mr-2"></i>Información de Entrega
                    </h2>

                    <form action="{{ route('clientes.carrito.procesar') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Información del cliente -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nombre</label>
                                <input type="text" value="{{ auth()->user()->nomUsu }}" class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Apellido</label>
                                <input type="text" value="{{ auth()->user()->apeUsu }}" class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50" readonly>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono</label>
                            <input type="text" value="{{ auth()->user()->telUsu }}" class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50" readonly>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Dirección de Entrega *</label>
                            <textarea name="direccion_entrega" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                                      placeholder="Ingresa la dirección completa de entrega" required>{{ old('direccion_entrega', auth()->user()->dirUsu) }}</textarea>
                            @error('direccion_entrega')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Método de Pago *</label>
                                <select name="metodo_pago" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                                    <option value="">Selecciona un método de pago</option>
                                    <option value="PayU" {{ old('metodo_pago') == 'PayU' ? 'selected' : '' }}>
                                        PayU (Tarjetas, PSE, Efectivo, Billeteras)
                                    </option>
                                </select>
                            @error('metodo_pago')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Notas Adicionales</label>
                            <textarea name="notas" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                                      placeholder="Instrucciones especiales para la entrega (opcional)">{{ old('notas') }}</textarea>
                            @error('notas')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="prePed" class="block text-sm font-medium text-gray-700 mb-2">Total</label>
                            <input type="hidden" name="prePed" value="{{ $total }}">
                            <p class="text-sm text-gray-500">Total: ${{ number_format($total, 2) }}</p>
                        </div>

                        <div class="border-t pt-6">
                            <button type="submit" class="w-full bg-primary-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-primary-600 transition">
                                <i class="fas fa-lock mr-2"></i>Confirmar Pedido
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Resumen del pedido -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">
                        <i class="fas fa-shopping-cart mr-2"></i>Resumen del Pedido
                    </h2>

                    <!-- Lista de productos -->
                    <div class="space-y-4 mb-6">
                        @foreach($productos as $item)
                        <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                            <div class="w-12 h-12 bg-gray-100 rounded flex items-center justify-center overflow-hidden">
                                <img src="{{ $item['producto']->imagen_url }}" 
                                     alt="{{ $item['producto']->nomPro }}"
                                     class="w-full h-full object-contain p-1"
                                     onerror="this.src='{{ asset('images/default-product.png') }}'">
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-medium text-gray-800 truncate">{{ $item['producto']->nomPro }}</h3>
                                <p class="text-sm text-gray-500">Cantidad: {{ $item['cantidad'] }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-gray-800">${{ number_format($item['subtotal'], 2) }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Totales -->
                    <div class="border-t pt-4 space-y-3">
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

                    <!-- Información adicional -->
                    <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                        <h3 class="font-semibold text-blue-800 mb-2">
                            <i class="fas fa-info-circle mr-2"></i>Información Importante
                        </h3>
                        <ul class="text-sm text-blue-700 space-y-1">
                            <li>• El pedido será procesado en 24-48 horas</li>
                            <li>• Te contactaremos para confirmar la entrega</li>
                            <li>• Pago contra entrega disponible</li>
                            <li>• Envío gratis en toda la ciudad</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 