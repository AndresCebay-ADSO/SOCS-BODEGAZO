@extends('layouts.app')

@section('title', 'Factura del Pedido')

@section('content')

@if(session('success'))
    <div class="max-w-4xl mx-auto mb-6">
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-3 text-xl"></i>
                <div>
                    <h3 class="font-bold">¡Pago Exitoso!</h3>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="max-w-4xl mx-auto bg-white shadow-xl rounded-lg p-8 text-sm">
    {{-- Cabecera con datos de la empresa y número de factura --}}
    <div class="flex justify-between items-center border-b pb-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-green-800">🧾 COMPROBANTE DE COMPRA</h2>
            <p class="text-gray-600">Comprobante N°: <strong>{{ $pedido->idPed }}</strong></p>
            <p class="text-gray-600">Fecha: {{ \Carbon\Carbon::parse($pedido->fecPed)->format('d/m/Y') }}</p>
        </div>
        <div class="text-right">
            <p class="font-bold text-lg text-gray-800">🛒 El Bodegazo</p>
            <p class="text-gray-600">Calle 123 # 45-67, La Plata - Huila</p>
            <p class="text-gray-600">Tel: (608) 555-1234</p>
            <p class="text-gray-600">NIT: 900123456-7</p>
        </div>
    </div>

    {{-- Información personal del cliente que hizo el pedido --}}
    <div class="mb-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-2">👤 Cliente</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p><span class="font-semibold">Nombre:</span> {{ $pedido->usuario->nomUsu ?? '-' }} {{ $pedido->usuario->apeUsu ?? '' }}</p>
                <p><span class="font-semibold">Teléfono:</span> {{ $pedido->usuario->telUsu ?? 'N/A' }}</p>
            </div>
            <div>
                <p><span class="font-semibold">Dirección:</span> {{ $pedido->usuario->dirUsu ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    {{-- Tabla con los productos comprados y sus precios --}}
    <div class="mb-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-2">🛒 Productos</h3>
        <table class="w-full border text-left text-gray-700">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">Producto</th>
                    <th class="p-2 border">Marca</th>
                    <th class="p-2 border">Talla</th>
                    <th class="p-2 border text-center">Cantidad</th>
                    <th class="p-2 border text-right">Precio Unitario</th>
                    <th class="p-2 border text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @if($pedido->detalles->isNotEmpty())
                    @foreach($pedido->detalles as $detalle)
                        @if($detalle->producto)
                            <tr class="border-b">
                                <td class="p-2 border">{{ $detalle->producto->nomPro }}</td>
                                <td class="p-2 border">{{ $detalle->producto->marPro ?? '-' }}</td>
                                <td class="p-2 border">{{ $detalle->producto->tallPro ?? '-' }}</td>
                                <td class="p-2 border text-center">{{ $detalle->canDet }}</td>
                                <td class="p-2 border text-right">${{ number_format($detalle->preProDet, 2) }}</td>
                                <td class="p-2 border text-right">${{ number_format($detalle->preProDet * $detalle->canDet, 2) }}</td>
                            </tr>
                        @endif
                    @endforeach
                @else
                    <tr class="border-b">
                        <td class="p-2 border" colspan="6" class="text-center text-gray-500">Sin productos disponibles</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    {{-- Cálculo del subtotal, IVA y total a pagar --}}
    @php
        $subtotal = $pedido->prePed ?? 0;
        $iva = $subtotal * 0.19;
        $total = $subtotal + $iva;
    @endphp

    <div class="flex justify-end mt-6">
        <table class="text-right w-1/2 text-sm">
            <tr>
                <td class="p-2 font-semibold">Subtotal:</td>
                <td class="p-2">${{ number_format($subtotal, 2) }}</td>
            </tr>
            <tr>
                <td class="p-2 font-semibold">IVA (19%):</td>
                <td class="p-2">${{ number_format($iva, 2) }}</td>
            </tr>
            <tr class="border-t">
                <td class="p-2 font-bold text-lg text-gray-800">Total a Pagar:</td>
                <td class="p-2 font-bold text-lg text-green-700">${{ number_format($total, 2) }}</td>
            </tr>
        </table>
    </div>

    {{-- Información de pago --}}
    @if($pedido->fecha_pago)
    <div class="mt-6 p-4 bg-green-50 rounded-lg">
        <h3 class="text-lg font-semibold text-green-800 mb-2">
            <i class="fas fa-check-circle mr-2"></i>Información de Pago
        </h3>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <p><span class="font-semibold">Fecha de Pago:</span> {{ Carbon\Carbon::parse($pedido->fecha_pago)->format('d/m/Y H:i') }}</p>
                <p><span class="font-semibold">Método:</span> {{ $pedido->payment_method ?? 'PayU' }}</p>
            </div>
            <div>
                @if($pedido->transaction_id)
                    <p><span class="font-semibold">ID Transacción:</span> {{ $pedido->transaction_id }}</p>
                @endif
                @if($pedido->referenceCode)
                    <p><span class="font-semibold">Referencia:</span> {{ $pedido->referenceCode }}</p>
                @endif
            </div>
        </div>
    </div>
    @endif

    {{-- Badge que muestra si está por pagar, en camino o finalizado --}}
    <div class="mt-8">
        <p class="text-sm"><strong>Estado del Pedido:</strong>
            <span class="inline-block px-3 py-1 rounded-full text-xs font-bold
                @if(strtolower($pedido->estPed) == 'por pagar') bg-yellow-100 text-yellow-800
                @elseif(strtolower($pedido->estPed) == 'en camino') bg-blue-100 text-blue-800
                @elseif(strtolower($pedido->estPed) == 'finalizado') bg-green-100 text-green-800
                @else bg-gray-200 text-gray-700 @endif">
                {{ ucfirst($pedido->estPed) }}
            </span>
        </p>
    </div>

    {{-- Enlace para regresar a la lista de pedidos del cliente --}}
    <div class="text-center mt-10">
        <a href="{{ route('clientes.pedidos.index') }}" class="bg-green-600 text-white px-6 py-2 rounded-full shadow hover:bg-green-700 transition">
            ⬅ Volver a Mis Pedidos
        </a>
    </div>
</div>

@endsection