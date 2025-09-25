@extends('layouts.app')

@section('title', 'Gestión de Administradores')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Gestión de Administradores</h1>
            <p class="text-gray-600 mt-1">Gestiona los administradores del sistema y sus permisos</p>
        </div>
        <a href="{{ route('superadmin.management.admins.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Crear Administrador
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif

    <!-- Lista de Administradores -->
    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        @if($administradores->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Administrador
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Estado
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Permisos
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($administradores as $admin)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $admin->nomUsu }} {{ $admin->apeUsu }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $admin->TipdocUsu }}: {{ $admin->numdocUsu ?? 'No especificado' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $admin->emaUsu }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $admin->estadoUsu === 'activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($admin->estadoUsu) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $admin->permissions->count() }} permisos asignados
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <a href="{{ route('superadmin.management.admins.edit', $admin->id) }}" 
                                       class="text-blue-600 hover:text-blue-900 transition duration-200">
                                        Editar
                                    </a>
                                    @if($administradores->count() > 1)
                                        <form action="{{ route('superadmin.management.admins.destroy', $admin->id) }}" 
                                              method="POST" class="inline"
                                              onsubmit="return confirm('¿Estás seguro de que quieres eliminar este administrador?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-900 transition duration-200">
                                                Eliminar
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Paginación -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $administradores->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.477 5.273 7.5 4 4.382 4c-1.483 0-2.93.345-4.025.957a1 1 0 00-.357 1.357C.345 7.93 1 9.477 1 11s-.655 3.07-1 4.686a1 1 0 00.357 1.357C1.452 17.655 2.9 18 4.382 18c3.118 0 6.095-1.273 7.618-2.253m0 0c1.523.98 4.5 2.253 7.618 2.253 1.483 0 2.93-.345 4.025-.957a1 1 0 00.357-1.357C23.655 14.07 23 12.523 23 11s.655-3.07 1-4.686a1 1 0 00-.357-1.357C22.548 4.345 21.1 4 19.618 4c-3.118 0-6.095 1.273-7.618 2.253z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No hay administradores</h3>
                <p class="mt-1 text-sm text-gray-500">Comienza creando un nuevo administrador.</p>
                <div class="mt-6">
                    <a href="{{ route('superadmin.management.admins.create') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Crear Administrador
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection