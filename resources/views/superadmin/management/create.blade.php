@extends('layouts.app')

@section('title', 'Crear Administrador')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Encabezado -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <div class="flex items-center">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-3 rounded-xl mr-4 shadow-md">
                    <i clas
                    s="fas fa-user-shield text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Crear Nuevo Administrador</h1>
                    <p class="text-gray-600 text-sm">Registra un nuevo administrador en el sistema</p>
                </div>
            </div>
            <a href="{{ route('superadmin.management.index') }}" 
               class="bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white font-medium py-2.5 px-5 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Volver
            </a>
        </div>
    </div>

    <!-- Formulario -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-medium text-gray-900">Información del Administrador</h3>
        </div>

        <div class="p-6">
            <form method="POST" action="{{ route('superadmin.management.admins.store-step1') }}">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nombres -->
                    <div>
                        <label for="nomUsu" class="block text-sm font-medium text-gray-700 mb-1">Nombres</label>
                        <input id="nomUsu" type="text" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nomUsu') border-red-500 @enderror" 
                               name="nomUsu" value="{{ old('nomUsu') }}" required autocomplete="name" autofocus>
                        @error('nomUsu')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Apellidos -->
                    <div>
                        <label for="apeUsu" class="block text-sm font-medium text-gray-700 mb-1">Apellidos</label>
                        <input id="apeUsu" type="text" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('apeUsu') border-red-500 @enderror" 
                               name="apeUsu" value="{{ old('apeUsu') }}" required autocomplete="family-name">
                        @error('apeUsu')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="emaUsu" class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                        <input id="emaUsu" type="email" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('emaUsu') border-red-500 @enderror" 
                               name="emaUsu" value="{{ old('emaUsu') }}" required autocomplete="email">
                        @error('emaUsu')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Teléfono -->
                    <div>
                        <label for="telUsu" class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                        <input id="telUsu" type="text" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('telUsu') border-red-500 @enderror" 
                               name="telUsu" value="{{ old('telUsu') }}" autocomplete="tel">
                        @error('telUsu')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Contraseña -->
                    <div>
                        <label for="passUsu" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                        <input id="passUsu" type="password" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('passUsu') border-red-500 @enderror" 
                               name="passUsu" required autocomplete="new-password">
                        @error('passUsu')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirmar Contraseña -->
                    <div>
                        <label for="passUsu_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmar Contraseña</label>
                        <input id="passUsu_confirmation" type="password" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                               name="passUsu_confirmation" required autocomplete="new-password">
                    </div>

                    <!-- Estado -->
                    <div>
                        <label for="estadoUsu" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                        <select id="estadoUsu" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('estadoUsu') border-red-500 @enderror" 
                                name="estadoUsu" required>
                            <option value="activo" {{ old('estadoUsu') == 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="inactivo" {{ old('estadoUsu') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        @error('estadoUsu')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-4">
                    <button type="submit" 
                            class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium py-2.5 px-6 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl flex items-center">
                        <i class="fas fa-save mr-2"></i> Continuar
                    </button>
                    <a href="{{ route('superadmin.management.index') }}" 
                       class="bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-medium py-2.5 px-6 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl flex items-center">
                        <i class="fas fa-times mr-2"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection