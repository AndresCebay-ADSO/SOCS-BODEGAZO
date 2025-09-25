@extends('layouts.app')

@section('title', 'Mi Perfil')

@section('content')
<div class="container mx-auto py-10">
    <div class="max-w-3xl mx-auto">
        <!-- Tarjeta del perfil -->
        <div class="bg-white shadow-lg rounded-2xl overflow-hidden">

            <!-- Encabezado con avatar, nombre y botón salir -->
            <div class="bg-gradient-to-r from-primary-500 to-primary-600 p-8 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                
                <!-- Avatar + Datos principales -->
                <div class="flex items-center gap-4">
                    <!-- Avatar -->
                    <div class="w-20 h-20 rounded-full bg-white flex items-center justify-center text-2xl font-bold text-primary-600 shadow-md">
                        {{ strtoupper(substr($usuario->nomUsu, 0, 1)) }}
                    </div>
                    <!-- Nombre y correo -->
                    <div>
                        <h1 class="text-2xl font-bold text-white">{{ $usuario->nomUsu }} {{ $usuario->apeUsu }}</h1>
                        <p class="text-white/80 text-sm">{{ $usuario->emaUsu }}</p>
                    </div>
                </div>

                <!-- Botón salir -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 text-sm font-medium text-white bg-red-500 px-4 py-2 rounded-lg hover:bg-red-600 transition">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>cerrar sesion</span>
                    </button>
                </form>
            </div>

            <!-- Contenido -->
            <div class="p-8">
                <!-- Mensaje de éxito -->
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <!-- Información personal -->
                <h2 class="text-lg font-semibold text-gray-700 mb-6 border-b pb-2">Información Personal</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500 flex items-center gap-2">
                            <i class="fas fa-user"></i> Nombre
                        </p>
                        <p class="text-gray-900 font-medium">{{ $usuario->nomUsu }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 flex items-center gap-2">
                            <i class="fas fa-user-tag"></i> Apellido
                        </p>
                        <p class="text-gray-900 font-medium">{{ $usuario->apeUsu }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 flex items-center gap-2">
                            <i class="fas fa-phone"></i> Teléfono
                        </p>
                        <p class="text-gray-900 font-medium">{{ $usuario->telUsu ?: 'No registrado' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 flex items-center gap-2">
                            <i class="fas fa-map-marker-alt"></i> Dirección
                        </p>
                        <p class="text-gray-900 font-medium">{{ $usuario->dirUsu ?: 'No registrada' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 flex items-center gap-2">
                            <i class="fas fa-id-card"></i> Tipo de Documento
                        </p>
                        <p class="text-gray-900 font-medium">{{ $usuario->TipdocUsu }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 flex items-center gap-2">
                            <i class="fas fa-hashtag"></i> Número de Documento
                        </p>
                        <p class="text-gray-900 font-medium">{{ $usuario->numdocUsu ?: 'No registrado' }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-sm text-gray-500 flex items-center gap-2">
                            <i class="fas fa-user-check"></i> Estado
                        </p>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold 
                            {{ $usuario->estadoUsu == 'activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            <i class="fas {{ $usuario->estadoUsu == 'activo' ? 'fa-check-circle' : 'fa-times-circle' }} mr-1"></i>
                            {{ ucfirst($usuario->estadoUsu) }}
                        </span>
                    </div>
                </div>

                <!-- Botón Editar Perfil -->
                <div class="flex justify-end mt-10">
                    <a href="{{ route('clientes.profile.edit') }}" 
                       class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-lg shadow-md transition flex items-center gap-2">
                        <i class="fas fa-edit"></i>
                        Editar Perfil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
