@extends('layouts.app')

@section('title', 'Editar Notificación')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <div class="flex items-center">
            <div class="bg-blue-100 p-3 rounded-xl mr-4">
                <i class="fas fa-bell text-blue-600 text-xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800">Editar Notificación #{{ $notificacion->idNot }}</h2>
        </div>
        <a href="{{ route('notificaciones.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Volver
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 max-w-3xl mx-auto">
        <form action="{{ route('notificaciones.update', $notificacion->idNot) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <!-- Destinatario -->
            <div class="mb-6">
                <label for="idUsuNot" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                    <i class="fas fa-user text-blue-500 mr-2"></i>
                    Destinatario <span class="text-red-500 ml-1">*</span>
                </label>
                <select name="idUsuNot" id="idUsuNot" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                    @foreach($usuarios as $usuario)
                        <option value="{{ $usuario->id }}" {{ $notificacion->idUsuNot == $usuario->id ? 'selected' : '' }}>
                            {{ $usuario->nomUsu }} {{ $usuario->apeUsu }} - {{ $usuario->emaUsu }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Mensaje -->
            <div class="mb-6">
                <label for="menNot" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                    <i class="fas fa-comment-alt text-blue-500 mr-2"></i>
                    Mensaje <span class="text-red-500 ml-1">*</span>
                </label>
                <textarea name="menNot" id="menNot" rows="4" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">{{ old('menNot', $notificacion->menNot) }}</textarea>
            </div>

            <!-- Fecha y Hora - Campo corregido -->
            <div class="mb-6">
                <label for="fechNot" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                    <i class="fas fa-calendar-alt text-blue-500 mr-2"></i>
                    Fecha y Hora <span class="text-red-500 ml-1">*</span>
                </label>
                <input type="datetime-local" name="fechNot" id="fechNot" required
                    value="{{ $notificacion->fechNot instanceof \Carbon\Carbon ? $notificacion->fechNot->format('Y-m-d\TH:i') : \Carbon\Carbon::parse($notificacion->fechNot)->format('Y-m-d\TH:i') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
            </div>

            <!-- Estado -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                    <i class="fas fa-toggle-on text-blue-500 mr-2"></i>
                    Estado <span class="text-red-500 ml-1">*</span>
                </label>
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex items-center">
                        <input type="radio" id="estNotActivo" name="estNot" value="Activo" {{ old('estNot', $notificacion->estNot) == 'Activo' ? 'checked' : '' }} required
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                        <label for="estNotActivo" class="ml-2 block text-sm text-gray-700">Activo</label>
                    </div>
                    <div class="flex items-center">
                        <input type="radio" id="estNotInactivo" name="estNot" value="Inactivo" {{ old('estNot', $notificacion->estNot) == 'Inactivo' ? 'checked' : '' }}
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                        <label for="estNotInactivo" class="ml-2 block text-sm text-gray-700">Inactivo</label>
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('notificaciones.index') }}" 
                   class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-150">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-md transition duration-300">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>
@endsection