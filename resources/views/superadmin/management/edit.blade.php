@extends('layouts.app')

@section('title', 'Editar Administrador')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Encabezado -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <div class="flex items-center">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-3 rounded-xl mr-4 shadow-md">
                    <i class="fas fa-user-edit text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Editar Administrador</h1>
                    <p class="text-gray-600 text-sm">Modifica los datos del administrador del sistema</p>
                </div>
            </div>
            <a href="{{ route('superadmin.management.index') }}" 
               class="bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white font-medium py-2.5 px-5 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Volver
            </a>
        </div>
    </div>

    <!-- Panel principal -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
        <!-- Formulario -->
        <form method="POST" action="{{ route('superadmin.management.admins.store-step1') }}">
            @csrf

            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-medium text-gray-900">Información del Administrador</h3>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nombres -->
                <div>
                    <label for="nomUsu" class="block text-sm font-medium text-gray-700 mb-1">Nombres *</label>
                    <input id="nomUsu" type="text" name="nomUsu" value="{{ old('nomUsu', $admin->nomUsu) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('nomUsu') border-red-500 @enderror"
                           required autofocus>
                    @error('nomUsu')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Apellidos -->
                <div>
                    <label for="apeUsu" class="block text-sm font-medium text-gray-700 mb-1">Apellidos *</label>
                    <input id="apeUsu" type="text" name="apeUsu" value="{{ old('apeUsu', $admin->apeUsu) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('apeUsu') border-red-500 @enderror"
                           required>
                    @error('apeUsu')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="emaUsu" class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico *</label>
                    <input id="emaUsu" type="email" name="emaUsu" value="{{ old('emaUsu', $admin->emaUsu) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('emaUsu') border-red-500 @enderror"
                           required>
                    @error('emaUsu')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Teléfono -->
                <div>
                    <label for="telUsu" class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                    <input id="telUsu" type="text" name="telUsu" value="{{ old('telUsu', $admin->telUsu) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('telUsu') border-red-500 @enderror">
                    @error('telUsu')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Rol -->
                <div>
                    <label for="idRolUsu" class="block text-sm font-medium text-gray-700 mb-1">Rol *</label>
                    <select id="idRolUsu" name="idRolUsu"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('idRolUsu') border-red-500 @enderror"
                            required>
                        @foreach($roles as $role)
                            <option value="{{ $role->idRol }}" {{ old('idRolUsu', $admin->idRolUsu) == $role->idRol ? 'selected' : '' }}>{{ $role->tipRol }}</option>
                        @endforeach
                    </select>
                    @error('idRolUsu')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Estado -->
                <div>
                    <label for="estadoUsu" class="block text-sm font-medium text-gray-700 mb-1">Estado *</label>
                    <select id="estadoUsu" name="estadoUsu"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('estadoUsu') border-red-500 @enderror"
                            required>
                        <option value="activo" {{ old('estadoUsu', $admin->estadoUsu) == 'activo' ? 'selected' : '' }}>Activo</option>
                        <option value="inactivo" {{ old('estadoUsu', $admin->estadoUsu) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                    @error('estadoUsu')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contraseña -->
                <div class="md:col-span-2">
                    <label for="passUsu" class="block text-sm font-medium text-gray-700 mb-1">Nueva Contraseña</label>
                    <input id="passUsu" type="password" name="passUsu"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('passUsu') border-red-500 @enderror"
                           placeholder="Dejar en blanco para mantener la actual">
                    @error('passUsu')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirmar Contraseña -->
                <div class="md:col-span-2">
                    <label for="passUsu_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmar Contraseña</label>
                    <input id="passUsu_confirmation" type="password" name="passUsu_confirmation"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
            </div>

            <!-- Pie del formulario -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-4">
                <button type="submit"
                        class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium py-2.5 px-6 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl flex items-center">
                    <i class="fas fa-save mr-2"></i> Guardar Cambios
                </button>
                <a href="{{ route('superadmin.management.index') }}"
                   class="bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-medium py-2.5 px-6 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl flex items-center">
                    <i class="fas fa-times mr-2"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection