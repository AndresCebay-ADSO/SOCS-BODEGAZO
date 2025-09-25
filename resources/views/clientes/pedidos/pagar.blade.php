@extends('layouts.app')

@section('title', 'Pagar Pedido')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">
                <i class="fas fa-credit-card text-green-500 mr-3"></i>
                Pagar Pedido #{{ $pedido->idPed }}
            </h1>
            <a href="{{ route('clientes.pedidos.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                <i class="fas fa-arrow-left mr-2"></i>Volver a Pedidos
            </a>
        </div>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Formulario de pago -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">
                        <i class="fas fa-credit-card mr-2"></i>Información de Pago
                    </h2>

                    <form action="{{ route('clientes.pagos.crear') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="pedido_id" value="{{ $pedido->idPed }}">
                        <input type="hidden" name="valor" value="{{ $pedido->prePed }}">
                        <input type="hidden" name="descripcion" value="Pago pedido #{{ $pedido->idPed }}">

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
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" value="{{ auth()->user()->emaUsu }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono</label>
                            <input type="text" name="telefono" value="{{ auth()->user()->telUsu }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Método de Pago</label>
                            <select name="metodo_pago" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                                <option value="">Selecciona un método de pago</option>
                                <option value="PayU">
                                    PayU (Tarjetas, PSE, Efectivo, Billeteras)
                                </option>
                            </select>
                        </div>

                        <div class="border-t pt-6">
                            <button type="submit" class="w-full bg-green-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-green-700 transition">
                                <i class="fas fa-lock mr-2"></i>Proceder al Pago
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Resumen del pedido -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">
                        <i class="fas fa-receipt mr-2"></i>Resumen del Pedido
                    </h2>

                    <!-- Información del pedido -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-gray-600">Número de Pedido:</span>
                            <span class="text-sm font-bold text-gray-800">#{{ $pedido->idPed }}</span>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-gray-600">Fecha:</span>
                            <span class="text-sm text-gray-800">{{ Carbon\Carbon::parse($pedido->fecPed)->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-600">Estado:</span>
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                                {{ $pedido->estPed }}
                            </span>
                        </div>
                    </div>

                    <!-- Lista de productos -->
                    <div class="space-y-4 mb-6">
                        <h3 class="font-medium text-gray-800">Productos:</h3>
                        @if($pedido->detalles->isNotEmpty())
                            @foreach($pedido->detalles as $detalle)
                                @if($detalle->producto)
                                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                        <div class="w-12 h-12 bg-gray-100 rounded flex items-center justify-center overflow-hidden">
                                            <img src="{{ $detalle->producto->imagen_url }}" 
                                                 alt="{{ $detalle->producto->nomPro }}"
                                                 class="w-full h-full object-contain p-1"
                                                 onerror="this.src='{{ asset('images/default-product.png') }}'">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-medium text-gray-800 truncate">{{ $detalle->producto->nomPro }}</h4>
                                            <p class="text-sm text-gray-500">Cantidad: {{ $detalle->canDet }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-semibold text-gray-800">${{ number_format($detalle->preProDet * $detalle->canDet, 2) }}</p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @else
                            <p class="text-gray-500 text-sm">Sin productos disponibles</p>
                        @endif
                    </div>

                    <!-- Totales -->
                    <div class="border-t pt-4 space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium">${{ number_format($pedido->prePed, 2) }}</span>
                        </div>
                        
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Envío</span>
                            <span class="font-medium text-green-600">Gratis</span>
                        </div>
                        
                        <hr class="border-gray-200">
                        
                        <div class="flex justify-between text-lg font-bold">
                            <span>Total a Pagar</span>
                            <span class="text-green-600">${{ number_format($pedido->prePed, 2) }}</span>
                        </div>
                    </div>

                    <!-- Información adicional -->
                    <div class="mt-6 p-4 bg-green-50 rounded-lg">
                        <h3 class="font-semibold text-green-800 mb-2">
                            <i class="fas fa-shield-alt mr-2"></i>Pago Seguro
                        </h3>
                        <ul class="text-sm text-green-700 space-y-1">
                            <li>• Transacción 100% segura con PayU</li>
                            <li>• Protección de datos personales</li>
                            <li>• Confirmación inmediata del pago</li>
                            <li>• Soporte 24/7 disponible</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
