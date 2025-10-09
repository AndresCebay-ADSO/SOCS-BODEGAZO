@extends('layouts.app')

@section('title', 'Mis Notificaciones')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <!-- Encabezado -->
    <div class="flex items-center gap-4 mb-8">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-3 rounded-xl shadow-md">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14V11a6 6 0 10-12 0v3c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
        </div>
        <h1 class="text-3xl font-bold text-gray-800">Centro de Notificaciones</h1>
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
        @if($notifications->isEmpty())
            <!-- Estado vacío -->
            <div class="p-12 text-center">
                <div class="mx-auto h-24 w-24 text-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No tienes notificaciones</h3>
                <p class="mt-1 text-sm text-gray-500">Cuando recibas una nueva notificación, aparecerá aquí.</p>
            </div>
        @else
            <!-- Lista de notificaciones -->
            <ul class="divide-y divide-gray-200">
                @foreach ($notifications as $notification)
                    <li>
                        <a href="{{ route('clientes.notifications.show', $notification->id) }}"
                           class="block p-6 transition-all duration-300 ease-in-out {{ $notification->read_at ? 'hover:bg-gray-50' : 'bg-blue-50 hover:bg-blue-100' }}">
                            <div class="flex items-center justify-between gap-4">
                                @if(!$notification->read_at)
                                    <div class="flex-shrink-0">
                                        <span class="h-3 w-3 bg-blue-500 rounded-full block" title="No leído"></span>
                                    </div>
                                @else
                                    <div class="flex-shrink-0">
                                        <span class="h-3 w-3" title="Leído"></span>
                                    </div>
                                @endif

                                <div class="flex-1">    
                                    <p class="text-gray-800">{{ $notification->data['message'] }}</p>
                                    <p class="text-sm text-gray-500 mt-1">
                                        <i class="far fa-clock mr-1"></i> {{ $notification->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                <div class="flex-shrink-0 self-center">
                                    <i class="fas fa-chevron-right text-gray-400"></i>
                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>

            <!-- Paginación -->
            @if ($notifications->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    {{ $notifications->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection