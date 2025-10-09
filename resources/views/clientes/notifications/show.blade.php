@extends('layouts.app')

@section('title', 'Detalle de la Notificación')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <!-- Botón para volver -->
    <div class="mb-6">
        <a href="{{ route('clientes.notifications.index') }}" 
           class="inline-flex items-center text-sm font-semibold text-gray-600 hover:text-gray-800 transition-colors duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Volver al Centro de Notificaciones
        </a>
    </div>

    <!-- Contenido de la notificación -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="p-8">
            <!-- Encabezado -->
            <div class="flex items-start justify-between mb-6 pb-4 border-b">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Detalle de la Notificación</h1>
                    <p class="text-sm text-gray-500 mt-1" title="{{ $notification->created_at->format('d/m/Y H:i:s') }}">
                        <i class="far fa-clock mr-1"></i> Recibido {{ $notification->created_at->diffForHumans() }}
                    </p>
                </div>
                <div class="p-3 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-md">
                     <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>

            <!-- Mensaje -->
            <div class="prose max-w-none text-gray-700">
                <p class="text-lg leading-relaxed">
                    {{ $notification->data['message'] }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection