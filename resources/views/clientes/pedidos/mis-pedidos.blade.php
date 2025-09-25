@extends('layouts.app')

@section('title', 'Mis Pedidos')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Mis Pedidos</h1>

    <!-- Panel de estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow p-4">
            <h3 class="text-gray-500 text-sm">Total Pedidos</h3>
            <p class="text-2xl font-bold">{{ $pedidos->total() }}</p>
        </div>
        <div class="bg-yellow-50 rounded-lg shadow p-4">
            <h3 class="text-yellow-600 text-sm">Por Pagar</h3>
            <p class="text-2xl font-bold text-yellow-700">
                {{ $pedidos->where('estPed', 'Por pagar')->count() }}
            </p>
        </div>
        <div class="bg-blue-50 rounded-lg shadow p-4">
            <h3 class="text-blue-600 text-sm">En Camino</h3>
            <p class="text-2xl font-bold text-blue-700">
                {{ $pedidos->where('estPed', 'En camino')->count() }}
            </p>
        </div>
        <div class="bg-green-50 rounded-lg shadow p-4">
            <h3 class="text-green-600 text-sm">Finalizados</h3>
            <p class="text-2xl font-bold text-green-700">
                {{ $pedidos->where('estPed', 'Finalizado')->count() }}
            </p>
        </div>
    </div>

    @if($pedidos->isEmpty())
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <p class="text-gray-600">No tienes pedidos realizados aún.</p>
            <a href="{{ route('clientes.productos.index') }}" 
               class="inline-block mt-4 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                Explorar productos
            </a>
        </div>
    @else
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pedido
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Fecha
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Estado
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Productos
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($pedidos as $pedido)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        #{{ $pedido->idPed }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ Carbon\Carbon::parse($pedido->fecPed)->format('d/m/Y') }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ Carbon\Carbon::parse($pedido->fecPed)->format('H:i') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full
                                        @if($pedido->estPed == 'Por pagar') bg-yellow-100 text-yellow-800
                                        @elseif($pedido->estPed == 'En camino') bg-blue-100 text-blue-800
                                        @elseif($pedido->estPed == 'Finalizado') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ $pedido->estPed }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900">
                                        ${{ number_format($pedido->prePed, 2, ',', '.') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        @if($pedido->detalles->isNotEmpty())
                                            @foreach($pedido->detalles as $detalle)
                                                @if($detalle->producto)
                                                    <div class="flex items-center space-x-2">
                                                        <span>{{ $detalle->producto->nomPro }}</span>
                                                        @if($detalle->canDet > 1)
                                                            <span class="text-gray-500">(x{{ $detalle->canDet }})</span>
                                                        @endif
                                                    </div>
                                                @endif
                                            @endforeach
                                        @else
                                            <span class="text-gray-500">Sin productos</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    @if($pedido->estPed == 'Por pagar')
                                        <a href="{{ route('clientes.pedidos.pagar', $pedido->idPed) }}" 
                                           class="inline-flex items-center px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 transition text-xs">
                                            <i class="fas fa-credit-card mr-1"></i>
                                            Pagar
                                        </a>
                                    @endif
                                    <a href="{{ route('clientes.pedidos.factura', $pedido->idPed) }}" 
                                       class="inline-flex items-center px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition text-xs">
                                        <i class="fas fa-file-invoice mr-1"></i>
                                        Comprobante
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $pedidos->links() }}
        </div>
    @endif
</div>
@endsection