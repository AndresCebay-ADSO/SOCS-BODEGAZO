@extends('layouts.app')

@section('title', 'Editar Pedido')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6">
    <!-- Encabezado -->
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center space-x-3">
            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            <h2 class="text-2xl font-bold text-gray-800">Editar Pedido #{{ $pedido->idPed }}</h2>
        </div>
        <a href="{{ route('pedidos.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Volver a la lista
        </a>
    </div>

    <!-- Errores de validación -->
    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg shadow-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="font-medium text-red-800">¡Corrige estos errores!</h3>
            </div>
            <ul class="mt-2 list-disc list-inside text-sm text-red-700 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulario -->
    <form action="{{ route('pedidos.update', $pedido->idPed) }}" method="POST" class="bg-white rounded-xl shadow-sm p-6 space-y-6 border border-gray-100">
        @csrf
        @method('PUT')

        <!-- Cliente -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Cliente <span class="text-red-500">*</span></label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <select name="idUsuPed" class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm appearance-none">
                    @foreach($usuarios as $usuario)
                        <option value="{{ $usuario->idUsu }}" {{ $pedido->idUsuPed == $usuario->idUsu ? 'selected' : '' }}>
                            {{ $usuario->nomUsu }} {{ $usuario->apeUsu }}
                        </option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Producto -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Producto <span class="text-red-500">*</span></label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <select name="idProPed" class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm appearance-none">
                    @foreach($productos as $producto)
                        <option value="{{ $producto->idPro }}" {{ $pedido->idProPed == $producto->idPro ? 'selected' : '' }}>
                            {{ $producto->nomPro }} ({{ $producto->canPro }} disponibles)
                        </option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Fecha y Precio en columnas -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Fecha -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <input type="date" name="fecPed" value="{{ $pedido->fecPed->format('Y-m-d') }}" 
                           class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                </div>
            </div>

            <!-- Precio -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Precio <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500">$</span>
                    </div>
                    <input type="number" step="0.01" min="0" name="prePed" value="{{ $pedido->prePed }}" 
                           class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                           placeholder="0.00">
                </div>
            </div>
        </div>

        <!-- Botones -->
        <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
            <a href="{{ route('pedidos.index') }}" class="px-5 py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition duration-200 shadow-sm">
                Cancelar
            </a>
            <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg shadow-md hover:shadow-lg transition duration-300 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Actualizar Pedido
            </button>
        </div>
    </form>
</div>
@endsection