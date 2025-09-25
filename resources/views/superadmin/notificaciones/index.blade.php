@extends('layouts.app')

@section('title', 'Listado de Notificaciones')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Encabezado mejorado con icono y estadísticas -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <div class="flex items-center">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-3 rounded-xl mr-4 shadow-md">
                    <i class="fas fa-bell text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Gestión de Notificaciones</h1>
                    <p class="text-gray-600 text-sm">Administra todas las notificaciones del sistema</p>
                </div>
            </div>
            <a href="{{ route('notificaciones.create') }}" 
               class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium py-2.5 px-5 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl flex items-center">
                <i class="fas fa-plus mr-2"></i> Nueva Notificación
            </a>
        </div>

        <!-- Tarjetas de resumen -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-blue-500 hover:shadow-md transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="bg-blue-100 p-2 rounded-lg mr-3">
                        <i class="fas fa-bell text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $notificaciones->total() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-green-500 hover:shadow-md transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="bg-green-100 p-2 rounded-lg mr-3">
                        <i class="fas fa-check-circle text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Activas</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $notificaciones->where('estNot', 'Activo')->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-red-500 hover:shadow-md transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="bg-red-100 p-2 rounded-lg mr-3">
                        <i class="fas fa-times-circle text-red-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Inactivas</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $notificaciones->where('estNot', 'Inactivo')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Panel principal -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
        <!-- Barra de búsqueda -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <form method="GET" action="{{ route('notificaciones.index') }}">
                <div class="flex flex-col md:flex-row gap-3 items-center">
                    <!-- Campo de búsqueda -->
                    <div class="relative flex-grow w-full">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" 
                            class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                            placeholder="Buscar por mensaje o destinatario...">
                    </div>
                    
                    <!-- Filtro por estado -->
                    <div class="w-full md:w-auto">
                        <select name="estado" class="block w-full pl-3 pr-10 py-2.5 border border-gray-300 rounded-lg bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Todos los estados</option>
                            <option value="Activo" {{ request('estado') == 'Activo' ? 'selected' : '' }}>Activo</option>
                            <option value="Inactivo" {{ request('estado') == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>
                    
                    <!-- Botones de acción -->
                    <button type="submit" class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg shadow-md transition duration-200 flex items-center justify-center">
                        <i class="fas fa-search mr-2"></i> Buscar
                    </button>
                    <a href="{{ route('notificaciones.index') }}" class="w-full md:w-auto bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2.5 rounded-lg shadow-sm transition duration-200 flex items-center justify-center">
                        <i class="fas fa-undo mr-2"></i> Limpiar
                    </a>
                </div>
            </form>
        </div>

        @if($notificaciones->isEmpty())
            <!-- Estado vacío mejorado -->
            <div class="p-12 text-center">
                <div class="mx-auto h-24 w-24 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No hay notificaciones</h3>
                <p class="mt-1 text-gray-500">No se encontraron notificaciones en el sistema</p>
                <div class="mt-6">
                    <a href="{{ route('notificaciones.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                        <i class="fas fa-plus mr-2"></i> Crear primera notificación
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
                                    <i class="fas fa-comment-alt mr-2 text-gray-400"></i>
                                    Mensaje
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="fas fa-user mr-2 text-gray-400"></i>
                                    Destinatario
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-alt mr-2 text-gray-400"></i>
                                    Fecha/Hora
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="fas fa-toggle-on mr-2 text-gray-400"></i>
                                    Estado
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($notificaciones as $notificacion)
                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                            <!-- Mensaje con efecto hover -->
                            <td class="px-6 py-4 max-w-xs">
                                <div class="group relative">
                                    <div class="text-sm font-medium text-gray-900 truncate">
                                        {{ Str::limit($notificacion->menNot, 60) }}
                                    </div>
                                    @if(strlen($notificacion->menNot) > 60)
                                    <div class="absolute z-10 hidden group-hover:block w-64 p-3 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg">
                                        <p class="text-sm text-gray-700">{{ $notificacion->menNot }}</p>
                                    </div>
                                    @endif
                                </div>
                            </td>
                            
                            <!-- Destinatario -->
                            <td class="px-6 py-4">
                                @if($notificacion->usuario)
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-user text-blue-600"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $notificacion->usuario->nomUsu }} {{ $notificacion->usuario->apeUsu }}</div>
                                        <div class="text-xs text-gray-500 truncate">{{ $notificacion->usuario->emaUsu }}</div>
                                    </div>
                                </div>
                                @else
                                <span class="text-sm text-gray-500">Usuario no encontrado</span>
                                @endif
                            </td>
                            
                            <!-- Fecha/Hora -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ $notificacion->fechNot instanceof \Carbon\Carbon ? $notificacion->fechNot->format('d/m/Y') : \Carbon\Carbon::parse($notificacion->fechNot)->format('d/m/Y') }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $notificacion->fechNot instanceof \Carbon\Carbon ? $notificacion->fechNot->format('h:i A') : \Carbon\Carbon::parse($notificacion->fechNot)->format('h:i A') }}
                                </div>
                            </td>
                            
                            <!-- Estado con icono -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $notificacion->estNot == 'Activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    @if($notificacion->estNot == 'Activo')
                                        <i class="fas fa-check-circle mr-1"></i>
                                    @else
                                        <i class="fas fa-times-circle mr-1"></i>
                                    @endif
                                    {{ $notificacion->estNot }}
                                </span>
                            </td>
                            
                            <!-- Acciones con efecto hover -->
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-3">
                                    <a href="{{ route('notificaciones.edit', $notificacion->idNot) }}" 
                                       class="text-blue-600 hover:text-blue-900 hover:bg-blue-50 px-3 py-1.5 rounded-lg transition duration-200 flex items-center transform hover:scale-105"
                                       title="Editar notificación">
                                        <i class="fas fa-edit mr-1"></i>
                                        <span class="hidden md:inline">Editar</span>
                                    </a>
                                    <form action="{{ route('notificaciones.destroy', $notificacion->idNot) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-900 hover:bg-red-50 px-3 py-1.5 rounded-lg transition duration-200 flex items-center transform hover:scale-105"
                                                onclick="return confirm('¿Estás seguro de eliminar esta notificación?')"
                                                title="Eliminar notificación">
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
            
            <!-- Paginación mejorada -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <div class="text-sm text-gray-500 mb-4 md:mb-0">
                        Mostrando <span class="font-medium">{{ $notificaciones->firstItem() }}</span> a <span class="font-medium">{{ $notificaciones->lastItem() }}</span> de <span class="font-medium">{{ $notificaciones->total() }}</span> notificaciones
                    </div>
                    {{ $notificaciones->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection