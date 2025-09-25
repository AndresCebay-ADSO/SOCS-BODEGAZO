@extends('layouts.app')

@section('title', 'Buscar Pedidos')

@section('content')
{{-- Página donde los clientes pueden consultar sus pedidos ingresando su ID --}}
<div class="container mx-auto mt-8">
    <div class="max-w-md mx-auto bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">🔍 Consultar Pedidos</h2>

        {{-- Alerta de error cuando el cliente no se encuentra --}}
        @if (session('error'))
            <div class="alert alert-danger mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('clientes.buscarHistorial') }}" method="GET" class="space-y-4">
            <div>
                <label for="cliente_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Número de Cliente
                </label>
                <input type="number" 
                       name="idUsu" 
                       id="cliente_id" 
                       class="form-control w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       placeholder="Ej: 123"
                       required>
            </div>

            <button type="submit" 
                    class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                📋 Buscar Pedidos
            </button>
        </form>
    </div>
</div>

@endsection
