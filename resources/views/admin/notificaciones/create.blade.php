@extends('layouts.app')

@section('title', 'Crear Notificación - El Bodegazo')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <!-- Encabezado mejorado -->
    <div class="flex justify-between items-center mb-8">
        <div class="flex items-center gap-4">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-3 rounded-xl shadow-md">
                <!-- Icono campana SVG -->
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14V11a6 6 0 10-12 0v3c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-800">Crear Notificación</h1>
        </div>
        <a href="{{ route('admin.notificaciones.index') }}" 
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow-md transition duration-300 transform hover:scale-105 flex items-center gap-2">
            <!-- Icono flecha izquierda SVG -->
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Volver
        </a>
    </div>

    <!-- Formulario de creación de notificación -->
    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-8">
        <form action="{{ route('admin.notificaciones.store') }}" method="POST" novalidate>
            @csrf

            <!-- Selección de Usuario -->
            <div class="mb-6">
                <label for="idUsuNot" class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                    <!-- Icono usuario SVG -->
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1118.879 6.196 9 9 0 015.12 17.803z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Destinatario <span class="text-red-500 ml-1">*</span>
                </label>
                <select name="idUsuNot" id="idUsuNot" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 @error('idUsuNot') border-red-500 @enderror">
                    <option value="">Seleccione un usuario</option>
                    @foreach($usuarios as $usuario)
                        <option value="{{ $usuario->id }}" {{ old('idUsuNot') == $usuario->id ? 'selected' : '' }}>
                            {{ $usuario->nomUsu }} {{ $usuario->apeUsu }} - {{ $usuario->emaUsu }}
                        </option>
                    @endforeach
                </select>
                @error('idUsuNot')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Mensaje -->
            <div class="mb-6">
                <label for="menNot" class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                    <!-- Icono mensaje SVG -->
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4l-6 6v-4a2 2 0 012-2z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12v4a2 2 0 01-2 2H7l-4-4V6a2 2 0 012-2h7a2 2 0 012 2v2" />
                    </svg>
                    Mensaje <span class="text-red-500 ml-1">*</span>
                </label>
                <textarea name="menNot" id="menNot" rows="4" required placeholder="Escriba aquí el contenido de la notificación..."
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 @error('menNot') border-red-500 @enderror">{{ old('menNot') }}</textarea>
                @error('menNot')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Fecha y Hora -->
            <div class="mb-6">
                <label for="fechNot" class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                    <!-- Icono calendario SVG -->
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Fecha y Hora <span class="text-red-500 ml-1">*</span>
                </label>
                <input type="datetime-local" name="fechNot" id="fechNot" required
                       value="{{ old('fechNot') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 @error('fechNot') border-red-500 @enderror" />
                @error('fechNot')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Estado -->
            <div class="mb-8">
                <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                    <!-- Icono toggle SVG -->
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 12h4m-2-2v4m9 1a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Estado <span class="text-red-500 ml-1">*</span>
                </label>
                <div class="grid grid-cols-2 gap-6">
                    <label class="flex items-center space-x-2">
                        <input id="estNotActivo" type="radio" name="estNot" value="Activo" required
                            class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300"
                            {{ old('estNot') == 'Activo' ? 'checked' : '' }} />
                        <span class="text-gray-700">Activo</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input id="estNotInactivo" type="radio" name="estNot" value="Inactivo"
                            class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300"
                            {{ old('estNot') == 'Inactivo' ? 'checked' : '' }} />
                        <span class="text-gray-700">Inactivo</span>
                    </label>
                </div>
                @error('estNot')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botones -->
            <div class="flex flex-col-reverse sm:flex-row justify-end gap-4 border-t border-gray-200 pt-6">
                <a href="{{ route('admin.notificaciones.index') }}" 
                   class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-150 flex items-center justify-center gap-2">
                    <!-- Icono cancelar SVG -->
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Cancelar
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow-md transition duration-300 transform hover:scale-105 flex items-center justify-center gap-2">
                    <!-- Icono enviar SVG -->
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132m0 0l3.197-2.132m-3.197 2.132v4.264m7.197-1.132a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Enviar Notificación
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Establecer fecha y hora actual como valor por defecto si no hay old()
    if(!document.getElementById('fechNot').value) {
        const now = new Date();
        const timezoneOffset = now.getTimezoneOffset() * 60000;
        const localISOTime = (new Date(now - timezoneOffset)).toISOString().slice(0, 16);
        document.getElementById('fechNot').value = localISOTime;
    }
    
    // Mejorar la experiencia del textarea, ampliar altura al enfocar
    const textarea = document.getElementById('menNot');
    textarea.addEventListener('focus', function() {
        this.style.minHeight = '150px';
    });
});
</script>
@endsection
