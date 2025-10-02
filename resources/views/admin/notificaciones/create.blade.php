@extends('layouts.app')

@section('title', 'Crear Notificación - El Bodegazo')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <!-- Encabezado -->
    <div class="flex justify-between items-center mb-8">
        <div class="flex items-center gap-4">
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-3 rounded-xl shadow-md">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14V11a6 6 0 10-12 0v3c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-800">Crear Notificación</h1>
        </div>
        <a href="{{ route('admin.notificaciones.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow-md transition duration-300 transform hover:scale-105 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            Volver
        </a>
    </div>

    <!-- Formulario unificado -->
    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-8">
        <form action="{{ route('admin.notificaciones.store') }}" method="POST" novalidate>
            @csrf

            <!-- Selección de Destinatario (Unificado) -->
            <div class="mb-6">
                <label for="idUsuNot" class="block text-sm font-medium text-gray-700 mb-2">Destinatario <span class="text-red-500">*</span></label>
                <select name="idUsuNot" id="idUsuNot" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 @error('idUsuNot') border-red-500 @enderror">
                    <option value="">Seleccione un destinatario</option>
                    <option value="all" {{ old('idUsuNot') == 'all' ? 'selected' : '' }}>-- Todos los Usuarios (Masivo) --</option>
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
                <label for="menNot" class="block text-sm font-medium text-gray-700 mb-2">Mensaje <span class="text-red-500">*</span></label>
                <textarea name="menNot" id="menNot" rows="4" required placeholder="Contenido de la notificación..." class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 @error('menNot') border-red-500 @enderror">{{ old('menNot') }}</textarea>
                @error('menNot')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- URL (solo para masivo) -->
            <div class="mb-6" id="url-container" style="display: none;">
                <label for="url" class="block text-sm font-medium text-gray-700 mb-2">URL de destino (Opcional)</label>
                <input type="url" name="url" id="url" placeholder="Ej: {{ url('/ofertas') }}" value="{{ old('url') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-150 @error('url') border-red-500 @enderror" />
                @error('url')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campos para notificación individual -->
            <div id="individual-fields">
                <!-- Fecha y Hora -->
                <div class="mb-6">
                    <label for="fechNot" class="block text-sm font-medium text-gray-700 mb-2">Fecha y Hora <span class="text-red-500">*</span></label>
                    <input type="datetime-local" name="fechNot" id="fechNot" value="{{ old('fechNot') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 @error('fechNot') border-red-500 @enderror" />
                    @error('fechNot')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Estado -->
                <div class="mb-8">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Estado <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-2 gap-6">
                        <label class="flex items-center space-x-2"><input id="estNotActivo" type="radio" name="estNot" value="Activo" class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300" {{ old('estNot', 'Activo') == 'Activo' ? 'checked' : '' }} /><span class="text-gray-700">Activo</span></label>
                        <label class="flex items-center space-x-2"><input id="estNotInactivo" type="radio" name="estNot" value="Inactivo" class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300" {{ old('estNot') == 'Inactivo' ? 'checked' : '' }} /><span class="text-gray-700">Inactivo</span></label>
                    </div>
                    @error('estNot')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Botones -->
            <div class="flex flex-col-reverse sm:flex-row justify-end gap-4 border-t border-gray-200 pt-6">
                <a href="{{ route('admin.notificaciones.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-150 text-center">Cancelar</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow-md transition duration-300 transform hover:scale-105">Enviar Notificación</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const userSelect = document.getElementById('idUsuNot');
    const individualFields = document.getElementById('individual-fields');
    const urlContainer = document.getElementById('url-container');
    const fechaInput = document.getElementById('fechNot');
    const estadoActivo = document.getElementById('estNotActivo');

    function toggleFields() {
        if (userSelect.value === 'all') {
            individualFields.style.display = 'none';
            urlContainer.style.display = 'block';
            // Los campos individuales no son requeridos para envío masivo
            fechaInput.required = false;
            document.querySelectorAll('input[name="estNot"]').forEach(radio => radio.required = false);
        } else {
            individualFields.style.display = 'block';
            urlContainer.style.display = 'none';
            // Los campos individuales sí son requeridos
            fechaInput.required = true;
            document.querySelectorAll('input[name="estNot"]').forEach(radio => radio.required = true);
        }
    }

    // Establecer fecha y hora actual por defecto para notificaciones individuales
    if (!fechaInput.value) {
        const now = new Date();
        const timezoneOffset = now.getTimezoneOffset() * 60000;
        const localISOTime = (new Date(now - timezoneOffset)).toISOString().slice(0, 16);
        fechaInput.value = localISOTime;
    }

    // Ejecutar al cargar y cada vez que cambie la selección
    userSelect.addEventListener('change', toggleFields);
    toggleFields(); // Llamada inicial
});
</script>
@endsection