@extends('layouts.app')

@section('title', 'Editar Notificación - El Bodegazo')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <!-- Encabezado -->
    <div class="flex justify-between items-center mb-8">
        <div class="flex items-center gap-4">
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-3 rounded-xl shadow-md">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L14.732 5.232z"></path></svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-800">Editar Notificación #{{ $notificacion->idNot }}</h1>
        </div>
        <a href="{{ route('admin.notificaciones.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow-md transition duration-300 transform hover:scale-105 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            Volver
        </a>
    </div>

    <!-- Formulario de edición -->
    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-8">
        <form action="{{ route('admin.notificaciones.update', $notificacion->idNot) }}" method="POST" novalidate>
            @csrf
            @method('PUT')

            <!-- Destinatario -->
            <div class="mb-6">
                <label for="idUsuNot" class="block text-sm font-medium text-gray-700 mb-2">Destinatario <span class="text-red-500">*</span></label>
                <select name="idUsuNot" id="idUsuNot" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 @error('idUsuNot') border-red-500 @enderror">
                    <option value="">Seleccione un destinatario</option>
                    @foreach($usuarios as $usuario)
                        <option value="{{ $usuario->id }}" {{ old('idUsuNot', $notificacion->idUsuNot) == $usuario->id ? 'selected' : '' }}>
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
                <textarea name="menNot" id="menNot" rows="4" required placeholder="Contenido de la notificación..." class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 @error('menNot') border-red-500 @enderror">{{ old('menNot', $notificacion->menNot) }}</textarea>
                @error('menNot')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Estado -->
            <div class="mb-8">
                <label class="block text-sm font-medium text-gray-700 mb-2">Estado <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-2 gap-6">
                    <label class="flex items-center space-x-2"><input type="radio" name="estNot" value="Activo" class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300" {{ old('estNot', $notificacion->estNot) == 'Activo' ? 'checked' : '' }} /><span class="text-gray-700">Activo</span></label>
                    <label class="flex items-center space-x-2"><input type="radio" name="estNot" value="Inactivo" class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300" {{ old('estNot', $notificacion->estNot) == 'Inactivo' ? 'checked' : '' }} /><span class="text-gray-700">Inactivo</span></label>
                </div>
                @error('estNot')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botones -->
            <div class="flex flex-col-reverse sm:flex-row justify-end gap-4 border-t border-gray-200 pt-6">
                <a href="{{ route('admin.notificaciones.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-150 text-center">Cancelar</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow-md transition duration-300 transform hover:scale-105">Actualizar Notificación</button>
            </div>
        </form>
    </div>
</div>
@endsection