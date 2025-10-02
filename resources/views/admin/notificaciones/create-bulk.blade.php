@extends('layouts.app')

@section('title', 'Enviar Notificación Masiva - El Bodegazo')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <!-- Encabezado -->
    <div class="flex justify-between items-center mb-8">
        <div class="flex items-center gap-4">
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-3 rounded-xl shadow-md">
                <!-- Icono de megáfono -->
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.136A1.76 1.76 0 015.882 11H5.88a1.76 1.76 0 011.76-1.76l6.136-2.147A1.76 1.76 0 0111 5.882z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.24 11l-6.136-2.147A1.76 1.76 0 0011 5.882V19.24a1.76 1.76 0 002.592 1.548l6.136-2.147A1.76 1.76 0 0019.24 17V11z"></path></svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-800">Enviar Notificación Masiva</h1>
        </div>
        <a href="{{ route('admin.notificaciones.index') }}" 
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow-md transition duration-300 transform hover:scale-105 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            Volver
        </a>
    </div>

    <!-- Formulario de envío masivo -->
    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-8">
        <form action="{{ route('admin.notificaciones.store-bulk') }}" method="POST" novalidate>
            @csrf

            <!-- Mensaje -->
            <div class="mb-6">
                <label for="message" class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4l-6 6v-4a2 2 0 012-2z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12v4a2 2 0 01-2 2H7l-4-4V6a2 2 0 012-2h7a2 2 0 012 2v2" /></svg>
                    Mensaje <span class="text-red-500 ml-1">*</span>
                </label>
                <textarea name="message" id="message" rows="5" required placeholder="Escriba aquí el contenido de la notificación para todos los usuarios..."
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-150 @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                @error('message')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- URL (Opcional) -->
            <div class="mb-8">
                <label for="url" class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                    URL de destino (Opcional)
                </label>
                <input type="url" name="url" id="url" placeholder="Ej: {{ url('/ofertas') }}"
                       value="{{ old('url') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-150 @error('url') border-red-500 @enderror" />
                @error('url')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botones -->
            <div class="flex flex-col-reverse sm:flex-row justify-end gap-4 border-t border-gray-200 pt-6">
                <a href="{{ route('admin.notificaciones.index') }}" 
                   class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-150 flex items-center justify-center gap-2">
                    Cancelar
                </a>
                <button type="submit" 
                        class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg shadow-md transition duration-300 transform hover:scale-105 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132m0 0l3.197-2.132m-3.197 2.132v4.264m7.197-1.132a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Enviar a todos los usuarios
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Enviar Notificación Masiva - El Bodegazo')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <!-- Encabezado -->
    <div class="flex justify-between items-center mb-8">
        <div class="flex items-center gap-4">
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-3 rounded-xl shadow-md">
                <!-- Icono de megáfono -->
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.136A1.76 1.76 0 015.882 11H5.88a1.76 1.76 0 011.76-1.76l6.136-2.147A1.76 1.76 0 0111 5.882z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.24 11l-6.136-2.147A1.76 1.76 0 0011 5.882V19.24a1.76 1.76 0 002.592 1.548l6.136-2.147A1.76 1.76 0 0019.24 17V11z"></path></svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-800">Enviar Notificación Masiva</h1>
        </div>
        <a href="{{ route('admin.notificaciones.index') }}" 
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow-md transition duration-300 transform hover:scale-105 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            Volver
        </a>
    </div>

    <!-- Formulario de envío masivo -->
    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-8">
        <form action="{{ route('admin.notificaciones.store-bulk') }}" method="POST" novalidate>
            @csrf

            <!-- Mensaje -->
            <div class="mb-6">
                <label for="message" class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4l-6 6v-4a2 2 0 012-2z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12v4a2 2 0 01-2 2H7l-4-4V6a2 2 0 012-2h7a2 2 0 012 2v2" /></svg>
                    Mensaje <span class="text-red-500 ml-1">*</span>
                </label>
                <textarea name="message" id="message" rows="5" required placeholder="Escriba aquí el contenido de la notificación para todos los usuarios..."
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-150 @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                @error('message')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- URL (Opcional) -->
            <div class="mb-8">
                <label for="url" class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                    URL de destino (Opcional)
                </label>
                <input type="url" name="url" id="url" placeholder="Ej: {{ url('/ofertas') }}"
                       value="{{ old('url') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-150 @error('url') border-red-500 @enderror" />
                @error('url')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botones -->
            <div class="flex flex-col-reverse sm:flex-row justify-end gap-4 border-t border-gray-200 pt-6">
                <a href="{{ route('admin.notificaciones.index') }}" 
                   class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-150 flex items-center justify-center gap-2">
                    Cancelar
                </a>
                <button type="submit" 
                        class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg shadow-md transition duration-300 transform hover:scale-105 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132m0 0l3.197-2.132m-3.197 2.132v4.264m7.197-1.132a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Enviar a todos los usuarios
                </button>
            </div>
        </form>
    </div>
</div>
@endsection