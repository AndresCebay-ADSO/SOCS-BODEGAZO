@extends('layouts.app')

@section('title', 'Editar Mi Perfil')

@section('content')
<div class="container mx-auto py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-primary-600">Editar Mi Perfil</h1>
            <a href="{{ route('clientes.profile') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition">
                <i class="fas fa-arrow-left mr-2"></i>Volver
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('clientes.profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nombre -->
                    <div>
                        <label for="nomUsu" class="block text-sm font-medium text-gray-700 mb-2">
                            Nombre <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="nomUsu" 
                               name="nomUsu" 
                               value="{{ old('nomUsu', $usuario->nomUsu) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                               required>
                        @error('nomUsu')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Apellido -->
                    <div>
                        <label for="apeUsu" class="block text-sm font-medium text-gray-700 mb-2">
                            Apellido <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="apeUsu" 
                               name="apeUsu" 
                               value="{{ old('apeUsu', $usuario->apeUsu) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                               required>
                        @error('apeUsu')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="emaUsu" class="block text-sm font-medium text-gray-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                               id="emaUsu" 
                               name="emaUsu" 
                               value="{{ old('emaUsu', $usuario->emaUsu) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                               required>
                        @error('emaUsu')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Teléfono -->
                    <div>
                        <label for="telUsu" class="block text-sm font-medium text-gray-700 mb-2">
                            Teléfono
                        </label>
                        <input type="text" 
                               id="telUsu" 
                               name="telUsu" 
                               value="{{ old('telUsu', $usuario->telUsu) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                               maxlength="10">
                        @error('telUsu')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Dirección -->
                    <div class="md:col-span-2">
                        <label for="dirUsu" class="block text-sm font-medium text-gray-700 mb-2">
                            Dirección
                        </label>
                        <input type="text" 
                               id="dirUsu" 
                               name="dirUsu" 
                               value="{{ old('dirUsu', $usuario->dirUsu) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        @error('dirUsu')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tipo de Documento -->
                    <div>
                        <label for="TipdocUsu" class="block text-sm font-medium text-gray-700 mb-2">
                            Tipo de Documento <span class="text-red-500">*</span>
                        </label>
                        <select id="TipdocUsu" 
                                name="TipdocUsu"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                required>
                            <option value="">Seleccione...</option>
                            <option value="Cedula de Ciudadania" {{ old('TipdocUsu', $usuario->TipdocUsu) == 'Cedula de Ciudadania' ? 'selected' : '' }}>
                                Cédula de Ciudadanía
                            </option>
                            <option value="Tarjeta de Identidad" {{ old('TipdocUsu', $usuario->TipdocUsu) == 'Tarjeta de Identidad' ? 'selected' : '' }}>
                                Tarjeta de Identidad
                            </option>
                        </select>
                        @error('TipdocUsu')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Número de Documento -->
                    <div>
                        <label for="numdocUsu" class="block text-sm font-medium text-gray-700 mb-2">
                            Número de Documento
                        </label>
                        <input type="text" 
                               id="numdocUsu" 
                               name="numdocUsu" 
                               value="{{ old('numdocUsu', $usuario->numdocUsu) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                               maxlength="11">
                        @error('numdocUsu')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex justify-end space-x-4 mt-8">
                    <a href="{{ route('clientes.profile') }}" 
                       class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600 transition">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="bg-primary-500 text-white px-6 py-2 rounded-md hover:bg-primary-600 transition">
                        <i class="fas fa-save mr-2"></i>Actualizar Perfil
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 