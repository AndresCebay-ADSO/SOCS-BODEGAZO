@extends('layouts.app')

@section('title', 'Gestión de Inventario')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Encabezado mejorado con icono -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <div class="flex items-center">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-3 rounded-xl mr-4 shadow-md">
                    <i class="fas fa-boxes text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Gestión de Inventario</h1>
                    <p class="text-gray-600 text-sm">Administra todos los productos en inventario</p>
                </div>
            </div>
            <a href="{{ route('admin.inventarios.create') }}" 
               class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium py-2.5 px-5 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl flex items-center">
                <i class="fas fa-plus mr-2"></i> Nuevo Registro
            </a>
        </div>

        <!-- Tarjetas de resumen -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-blue-500 hover:shadow-md transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="bg-blue-100 p-2 rounded-lg mr-3">
                        <i class="fas fa-boxes text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Productos</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $inventarios->total() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-green-500 hover:shadow-md transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="bg-green-100 p-2 rounded-lg mr-3">
                        <i class="fas fa-check-circle text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Stock Adecuado</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $inventarios->where('canInv', '>', 10)->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-yellow-500 hover:shadow-md transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="bg-yellow-100 p-2 rounded-lg mr-3">
                        <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Stock Bajo</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $inventarios->where('canInv', '<=', 10)->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Panel principal -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
        <!-- Barra de búsqueda -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <form method="GET" action="{{ route('admin.inventarios.index') }}">
                <div class="flex flex-col md:flex-row gap-3 items-center">
                    <div class="relative flex-grow w-full">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" 
                            class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                            placeholder="Buscar por producto o código...">
                    </div>
                    
                    <button type="submit" class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg shadow-md transition duration-200 flex items-center justify-center">
                        <i class="fas fa-search mr-2"></i> Buscar
                    </button>
                    <a href="{{ route('admin.inventarios.index') }}" class="w-full md:w-auto bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2.5 rounded-lg shadow-sm transition duration-200 flex items-center justify-center">
                        <i class="fas fa-undo mr-2"></i> Limpiar
                    </a>
                </div>
            </form>
        </div>

        @if($inventarios->isEmpty())
            <!-- Estado vacío -->
            <div class="p-12 text-center">
                <div class="mx-auto h-24 w-24 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No hay registros de inventario</h3>
                <p class="mt-1 text-gray-500">No se encontraron productos en el inventario</p>
                <div class="mt-6">
                    <a href="{{ route('inventarios.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                        <i class="fas fa-plus mr-2"></i> Crear primer registro
                    </a>
                </div>
            </div>
        @else
            <!-- Tabla mejorada -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="fas fa-hashtag mr-2 text-gray-400"></i>
                                    ID
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="fas fa-box mr-2 text-gray-400"></i>
                                    Producto
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="fas fa-barcode mr-2 text-gray-400"></i>
                                    Código
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="fas fa-layer-group mr-2 text-gray-400"></i>
                                    Cantidad
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="fas fa-clock mr-2 text-gray-400"></i>
                                    Última Actualización
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($inventarios as $inventario)
                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                            <!-- ID -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-gray-800 font-medium">#{{ $inventario->idInv }}</span>
                            </td>
                            
                            <!-- Producto -->
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-box text-blue-600"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $inventario->producto->nomPro ?? 'Producto no encontrado' }}</div>
                                        <div class="text-xs text-gray-500">{{ $inventario->producto->marPro ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Código -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $inventario->producto->codPro ?? 'N/A' }}
                                </span>
                            </td>
                            
                            <!-- Cantidad -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="text-gray-800 font-medium {{ $inventario->canInv <= 10 ? 'text-yellow-600' : 'text-gray-800' }}">
                                        {{ $inventario->canInv }}
                                    </span>
                                    <span class="text-gray-500 text-sm ml-1">{{ $inventario->producto->unidad_medida ?? 'und' }}</span>
                                    @if($inventario->canInv <= 10)
                                    <i class="fas fa-exclamation-circle ml-2 text-yellow-500" title="Stock bajo"></i>
                                    @endif
                                </div>
                            </td>
                            
                            <!-- Fecha Actualización -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ $inventario->ultactInv ? $inventario->ultactInv->format('d/m/Y') : 'Nunca' }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $inventario->ultactInv ? $inventario->ultactInv->format('h:i A') : '' }}
                                </div>
                            </td>
                            
                            <!-- Acciones -->
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-3">
                                    <a href="{{ route('admin.inventarios.edit', $inventario->idInv) }}" 
                                       class="text-blue-600 hover:text-blue-900 hover:bg-blue-50 px-3 py-1.5 rounded-lg transition duration-200 flex items-center transform hover:scale-105"
                                       title="Editar inventario">
                                        <i class="fas fa-edit mr-1"></i>
                                        <span class="hidden md:inline">Editar</span>
                                    </a>
                                    <form action="{{ route('admin.inventarios.destroy', $inventario->idInv) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-900 hover:bg-red-50 px-3 py-1.5 rounded-lg transition duration-200 flex items-center transform hover:scale-105"
                                                onclick="return confirm('¿Estás seguro de eliminar este registro?')"
                                                title="Eliminar inventario">
                                            <i class="fas fa-trash-alt mr-1"></i>
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
            
            <!-- Paginación -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <div class="text-sm text-gray-500 mb-4 md:mb-0">
                        Mostrando <span class="font-medium">{{ $inventarios->firstItem() }}</span> a <span class="font-medium">{{ $inventarios->lastItem() }}</span> de <span class="font-medium">{{ $inventarios->total() }}</span> registros
                    </div>
                    {{ $inventarios->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection