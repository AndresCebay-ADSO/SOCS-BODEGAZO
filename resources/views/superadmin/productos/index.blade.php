@extends('layouts.app')

@section('title', 'Gestión de Productos - El Bodegazo')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Encabezado mejorado -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
        <div class="flex items-center">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-3 rounded-xl mr-4 shadow-md">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Gestión de Productos</h1>
                <p class="text-gray-600 text-sm">Administra el catálogo completo de productos</p>
            </div>
        </div>
        <a href="{{ route('admin.productos.create') }}" 
           class="mt-4 md:mt-0 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition duration-200 flex items-center shadow-md hover:shadow-lg">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Nuevo Producto
        </a>
    </div>

    <!-- Mensajes de éxito/error -->
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-lg shadow-sm flex items-center">
            <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="font-medium text-green-800">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg shadow-sm flex items-center">
            <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="font-medium text-red-800">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Tarjetas de estadísticas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        @foreach([
            'total' => ['title' => 'Total Productos', 'color' => 'gray', 'icon' => 'M4 7v10a2 2 0 002 2h12a2 2 0 002-2V7M4 7H3m1 0h1m16 0h1m-1 0h-1m-6 4v4m-3-4v4m-3-4v4m8-8v2m0-2V7M7 7v2m0-2V7'],
            'Activo' => ['title' => 'Activos', 'color' => 'green', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
            'Inactivo' => ['title' => 'Inactivos', 'color' => 'red', 'icon' => 'M18.364 5.636a9 9 0 010 12.728M5.636 5.636a9 9 0 0112.728 0M12 8v4m0 4h.01'],
            'Bajo Stock' => ['title' => 'Bajo Stock', 'color' => 'yellow', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4']
        ] as $estado => $card)
        <a href="{{ route('admin.productos.index', ['estado' => $estado === 'total' ? '' : $estado]) }}" 
           class="bg-white rounded-xl shadow-sm p-5 hover:shadow-md transition-all duration-300 transform hover:-translate-y-1 border-l-4 
           @if($card['color'] === 'gray') border-gray-500 @elseif($card['color'] === 'green') border-green-500 @elseif($card['color'] === 'red') border-red-500 @elseif($card['color'] === 'yellow') border-yellow-500 @endif
           {{ request('estado') == $estado || ($estado == 'total' && !request('estado')) ? 'ring-2 ' : '' }} 
           @if(request('estado') == $estado || ($estado == 'total' && !request('estado'))) 
               @if($card['color'] === 'gray') ring-gray-300 @elseif($card['color'] === 'green') ring-green-300 @elseif($card['color'] === 'red') ring-red-300 @elseif($card['color'] === 'yellow') ring-yellow-300 @endif 
           @endif">
            <div class="flex items-center">
                <div class="@if($card['color'] === 'gray') bg-gray-100 text-gray-600 @elseif($card['color'] === 'green') bg-green-100 text-green-600 @elseif($card['color'] === 'red') bg-red-100 text-red-600 @elseif($card['color'] === 'yellow') bg-yellow-100 text-yellow-600 @endif p-3 rounded-lg mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">{{ $card['title'] }}</p>
                    <p class="text-2xl font-semibold text-gray-800">
                        @if($estado == 'total')
                            {{ $productos->total() }}
                        @elseif($estado == 'Bajo Stock')
                            {{ $productos->where('canPro', '<', 10)->count() }}
                        @else
                            {{ $productos->where('estPro', $estado)->count() }}
                        @endif
                    </p>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    <!-- Barra de búsqueda y filtros -->
    <div class="bg-white rounded-xl shadow-sm p-5 mb-8 border border-gray-200">
        <form method="GET" action="{{ route('admin.productos.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" id="search" name="search" value="{{ request('search') }}" 
                           placeholder="Nombre, código o marca..." 
                           class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                </div>
            </div>
            <div>
                <label for="categoria" class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                <select id="categoria" name="categoria" class="block w-full pl-3 pr-10 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                    <option value="">Todas las categorías</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->idCat }}" {{ request('categoria') == $categoria->idCat ? 'selected' : '' }}>
                            {{ $categoria->nomCat }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                <select id="estado" name="estado" class="block w-full pl-3 pr-10 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                    <option value="">Todos los estados</option>
                    <option value="Activo" {{ request('estado') == 'Activo' ? 'selected' : '' }}>Activo</option>
                    <option value="Inactivo" {{ request('estado') == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>
            <div class="flex items-end gap-3">
                <button type="submit" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg transition duration-200 flex items-center justify-center shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Filtrar
                </button>
                <a href="{{ route('admin.productos.index') }}" 
                   class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2.5 rounded-lg transition duration-200 flex items-center justify-center shadow-sm hover:shadow-md">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Limpiar
                </a>
            </div>
        </form>
    </div>

    <!-- Tabla de productos -->
    <div class="bg-white shadow-sm rounded-xl overflow-hidden border border-gray-100">
        @if($productos->isEmpty()))
            <div class="p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No se encontraron productos</h3>
                <p class="mt-1 text-gray-500">No hay productos que coincidan con los filtros actuales.</p>
                <div class="mt-6">
                    <a href="{{ route('admin.productos.index') }}" 
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
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Marca</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($productos as $producto)
                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $producto->codPro }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden border mr-3">
                                        @if($producto->imagen_url)
                                            <img src="{{ $producto->imagen_url }}" 
                                                 alt="{{ $producto->nomPro }}" 
                                                 class="w-full h-full object-contain p-1"
                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                        @endif
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="{{ $producto->imagen_url ? 'display: none;' : '' }}">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $producto->nomPro }}</div>
                                        <div class="text-xs text-gray-500">{{ $producto->categoria->nomCat ?? 'Sin categoría' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $producto->marPro ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                ${{ number_format($producto->precio_venta, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-24 bg-gray-200 rounded-full h-2.5 mr-2">
                                        @php
                                            $porcentaje = min(100, max(0, ($producto->canPro / 100) * 100));
                                            $color = $producto->canPro < 10 ? 'bg-red-500' : ($producto->canPro < 30 ? 'bg-yellow-500' : 'bg-green-500');
                                        @endphp
                                        <div class="h-2.5 rounded-full {{ $color }}" style="width: {{ $porcentaje }}%"></div>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">{{ $producto->canPro ?? 0 }} {{ $producto->unidad_medida }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $producto->estPro == 'Activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    @if($producto->estPro == 'Activo')
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    @else
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    @endif
                                    {{ $producto->estPro }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-3">
                                    <a href="{{ route('admin.productos.show', $producto->idPro) }}" 
                                       class="text-blue-600 hover:text-blue-900 hover:bg-blue-50 px-3 py-1.5 rounded-lg transition duration-200 flex items-center transform hover:scale-105"
                                       title="Ver detalles">
                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <span class="hidden md:inline">Ver</span>
                                    </a>
                                    <a href="{{ route('admin.productos.edit', $producto->idPro) }}" 
                                       class="text-yellow-600 hover:text-yellow-900 hover:bg-yellow-50 px-3 py-1.5 rounded-lg transition duration-200 flex items-center transform hover:scale-105"
                                       title="Editar">
                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        <span class="hidden md:inline">Editar</span>
                                    </a>
                                    <form action="{{ route('admin.productos.destroy', $producto->idPro) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 hover:text-red-900 hover:bg-red-50 px-3 py-1.5 rounded-lg transition duration-200 flex items-center transform hover:scale-105"
                                                title="Eliminar"
                                                onclick="return confirm('¿Estás seguro de eliminar este producto?')">
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
                        Mostrando <span class="font-medium">{{ $productos->firstItem() }}</span> a <span class="font-medium">{{ $productos->lastItem() }}</span> de <span class="font-medium">{{ $productos->total() }}</span> productos
                    </div>
                    {{ $productos->appends(request()->query())->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Eliminar mensajes después de 5 segundos
    setTimeout(() => {
        const alerts = document.querySelectorAll('.bg-green-50, .bg-red-50');
        alerts.forEach(alert => {
            alert.style.transition = 'opacity 1s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 1000);
        });
    }, 5000);
});
</script>
@endsection