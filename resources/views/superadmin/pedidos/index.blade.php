@extends('layouts.app')

@section('title', 'Lista de Pedidos - El Bodegazo')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Encabezado mejorado -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
        <div class="flex items-center">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-3 rounded-xl mr-4 shadow-md">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Listado de Pedidos</h1>
                <p class="text-gray-600 text-sm">Gestión completa de los pedidos del sistema</p>
            </div>
        </div>
    </div>

    <!-- Mensajes de éxito -->
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-lg shadow-sm flex items-center">
            <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="font-medium text-green-800">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Tarjetas de estadísticas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        @foreach([
            'total' => ['title' => 'Total Pedidos', 'color' => 'gray', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4'],
            'Por pagar' => ['title' => 'Por Pagar', 'color' => 'yellow', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
            'En camino' => ['title' => 'En Camino', 'color' => 'blue', 'icon' => 'M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0'],
            'Finalizado' => ['title' => 'Finalizados', 'color' => 'green', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z']
        ] as $estado => $card)
        <a href="{{ route('pedidos.index', ['estado' => $estado === 'total' ? '' : $estado]) }}" 
           class="bg-white rounded-xl shadow-sm p-5 hover:shadow-md transition-all duration-300 transform hover:-translate-y-1 border-l-4 
           @if($card['color'] === 'gray') border-gray-500 @elseif($card['color'] === 'yellow') border-yellow-500 @elseif($card['color'] === 'blue') border-blue-500 @elseif($card['color'] === 'green') border-green-500 @endif
           {{ request('estado') == $estado || ($estado == 'total' && !request('estado')) ? 'ring-2 ' : '' }} 
           @if(request('estado') == $estado || ($estado == 'total' && !request('estado'))) 
               @if($card['color'] === 'gray') ring-gray-300 @elseif($card['color'] === 'yellow') ring-yellow-300 @elseif($card['color'] === 'blue') ring-blue-300 @elseif($card['color'] === 'green') ring-green-300 @endif 
           @endif">
            <div class="flex items-center">
                <div class="@if($card['color'] === 'gray') bg-gray-100 text-gray-600 @elseif($card['color'] === 'yellow') bg-yellow-100 text-yellow-600 @elseif($card['color'] === 'blue') bg-blue-100 text-blue-600 @elseif($card['color'] === 'green') bg-green-100 text-green-600 @endif p-3 rounded-lg mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">{{ $card['title'] }}</p>
                    <p class="text-2xl font-semibold text-gray-800">
                        {{ $estado == 'total' ? $pedidos->total() : $pedidos->where('estPed', $estado)->count() }}
                    </p>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    <!-- Barra de búsqueda y filtros -->
    <div class="bg-white rounded-xl shadow-sm p-5 mb-8 border border-gray-200">
        <form method="GET" action="{{ route('pedidos.index') }}" class="flex flex-col md:flex-row gap-4 items-end">
            <div class="flex-1 w-full">
                <label for="buscar" class="block text-sm font-medium text-gray-700 mb-1">Buscar pedidos</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" id="buscar" name="buscar" value="{{ request('buscar') }}" 
                           placeholder="Buscar por cliente, producto o ID..." 
                           class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                </div>
            </div>
            <div class="flex gap-3 w-full md:w-auto">
                <button type="submit" 
                        class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg transition duration-200 flex items-center justify-center shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Buscar
                </button>
                <a href="{{ route('pedidos.index') }}" 
                   class="w-full md:w-auto bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2.5 rounded-lg transition duration-200 flex items-center justify-center shadow-sm hover:shadow-md">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Limpiar
                </a>
            </div>
        </form>
    </div>

    <!-- Tabla de pedidos -->
    <div class="bg-white shadow-sm rounded-xl overflow-hidden border border-gray-100">
        @if($pedidos->isEmpty()))
            <div class="p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No se encontraron pedidos</h3>
                <p class="mt-1 text-gray-500">No hay pedidos que coincidan con los filtros actuales.</p>
                <div class="mt-6">
                    <a href="{{ route('pedidos.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Limpiar filtros
                    </a>
                </div>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($pedidos as $pedido)
                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">#{{ $pedido->idPed }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $pedido->usuario->nomUsu ?? 'N/A' }}</div>
                                        <div class="text-xs text-gray-500">{{ $pedido->usuario->emaUsu ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-gray-100 rounded-full flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm text-gray-900">{{ $pedido->producto->nomPro ?? 'N/A' }}</div>
                                        <div class="text-xs text-gray-500">Ref: {{ $pedido->producto->idPro ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $pedido->fecPed->format('d/m/Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $pedido->fecPed->format('h:i A') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                ${{ number_format($pedido->prePed, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $pedido->estPed == 'Por pagar' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $pedido->estPed == 'En camino' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $pedido->estPed == 'Finalizado' ? 'bg-green-100 text-green-800' : '' }}">
                                    @if($pedido->estPed == 'Por pagar')
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    @elseif($pedido->estPed == 'En camino')
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                        </svg>
                                    @elseif($pedido->estPed == 'Finalizado')
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    @endif
                                    {{ $pedido->estPed }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-3">
                                    <a href="{{ route('pedidos.edit', $pedido->idPed) }}" 
                                       class="text-blue-600 hover:text-blue-900 hover:bg-blue-50 px-3 py-1.5 rounded-lg transition duration-200 flex items-center transform hover:scale-105"
                                       title="Editar pedido">
                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        <span class="hidden md:inline">Editar</span>
                                    </a>
                                    <a href="{{ route('pedidos.factura', $pedido->idPed) }}" 
                                       class="text-green-600 hover:text-green-900 hover:bg-green-50 px-3 py-1.5 rounded-lg transition duration-200 flex items-center transform hover:scale-105"
                                       title="Generar factura">
                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <span class="hidden md:inline">Factura</span>
                                    </a>
                                    <form action="{{ route('pedidos.destroy', $pedido->idPed) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-900 hover:bg-red-50 px-3 py-1.5 rounded-lg transition duration-200 flex items-center transform hover:scale-105"
                                                onclick="return confirm('¿Estás seguro de eliminar este pedido?')"
                                                title="Eliminar pedido">
                                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            <span class="hidden md:inline">Eliminar</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <div class="text-sm text-gray-500 mb-4 md:mb-0">
                        Mostrando <span class="font-medium">{{ $pedidos->firstItem() }}</span> a <span class="font-medium">{{ $pedidos->lastItem() }}</span> de <span class="font-medium">{{ $pedidos->total() }}</span> pedidos
                    </div>
                    {{ $pedidos->appends(request()->query())->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection