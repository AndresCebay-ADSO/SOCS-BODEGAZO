@extends('layouts.app')

@section('title', 'Gestión de Usuarios')

@section('content')
<div class="container mx-auto py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-primary-600">Gestión de Usuarios</h1>
        <a href="{{ route('superadmin.usuarios.create') }}" class="bg-primary-500 text-white px-4 py-2 rounded-md hover:bg-primary-600 transition">
            <i class="fas fa-plus mr-2"></i>Nuevo Usuario
        </a>
    </div>

    <!-- Filtros y búsqueda -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form action="{{ route('superadmin.usuarios.index') }}" method="GET" id="filter-form">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <div class="flex">
                        <input type="text" 
                            name="q" 
                            placeholder="Buscar por nombre, email o documento..." 
                            value="{{ request('q') }}"
                            class="flex-1 px-3 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <button type="submit" class="bg-primary-500 text-white px-4 py-2 rounded-r-md hover:bg-primary-600 transition">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="flex gap-2">
                    <select name="rol" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500" onchange="document.getElementById('filter-form').submit()">
                        <option value="">Todos los roles</option>
                        <option value="1" {{ request('rol') == '1' ? 'selected' : '' }}>Administradores</option>
                        <option value="2" {{ request('rol') == '2' ? 'selected' : '' }}>Clientes</option>
                    </select>
                    <select name="estado" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500" onchange="document.getElementById('filter-form').submit()">
                        <option value="">Todos los estados</option>
                        <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activos</option>
                        <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivos</option>
                    </select>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabla de usuarios -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Usuario
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Contacto
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Documento
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Rol
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estado
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($usuarios as $usuario)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-primary-500 flex items-center justify-center">
                                        <span class="text-white font-semibold text-sm">
                                            {{ strtoupper(substr($usuario->nomUsu, 0, 1)) }}{{ strtoupper(substr($usuario->apeUsu, 0, 1)) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $usuario->nomUsu }} {{ $usuario->apeUsu }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        ID: {{ $usuario->id }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $usuario->emaUsu }}</div>
                            <div class="text-sm text-gray-500">{{ $usuario->telUsu ?: 'Sin teléfono' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $usuario->TipdocUsu }}</div>
                            <div class="text-sm text-gray-500">{{ $usuario->numdocUsu ?: 'Sin documento' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($usuario->idRolUsu == 1)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-user-shield mr-1"></i>Administrador
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-user mr-1"></i>Cliente
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($usuario->estadoUsu == 'activo')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>Activo
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-times-circle mr-1"></i>Inactivo
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('superadmin.usuarios.edit', $usuario->id) }}" 
                                   class="text-primary-600 hover:text-primary-900 transition">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('superadmin.usuarios.historial', $usuario->id) }}" 
                                   class="text-blue-600 hover:text-blue-900 transition">
                                    <i class="fas fa-history"></i>
                                </a>
                                <form action="{{ route('superadmin.usuarios.destroy', $usuario->id) }}" 
                                      method="POST" 
                                      class="inline"
                                      onsubmit="return confirm('¿Estás seguro de que quieres eliminar este usuario?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 transition">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            <i class="fas fa-users text-4xl mb-2"></i>
                            <p>No se encontraron usuarios</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paginación -->
    @if($usuarios->hasPages())
    <div class="mt-6">
        {{ $usuarios->links() }}
    </div>
    @endif
</div>
@endsection