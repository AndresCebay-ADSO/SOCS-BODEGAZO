@extends('layouts.app')

@section('title', 'Historial de Pedidos del Cliente')

@section('content')

    {{-- Encabezado con el nombre del cliente y título de la página --}}
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-blue-800">📜 Historial de Pedidos</h2>
        <p class="text-gray-600 mt-2">
            Cliente: <span class="font-semibold">{{ $cliente->nomUsu }} {{ $cliente->apeUsu }}</span>
        </p>
    </div>

    {{-- Enlace para regresar a la lista principal de pedidos --}}
    <div class="mb-4">
        <a href="{{ route('pedidos.index') }}" class="text-blue-600 hover:underline text-sm">
            ⬅ Volver a la lista de pedidos
        </a>
    </div>

    {{-- Mensaje cuando el cliente no tiene pedidos registrados --}}
    @if ($pedidos->isEmpty())
        <div class="bg-yellow-50 border border-yellow-300 text-yellow-700 px-6 py-4 rounded-lg text-center shadow-md">
            Este cliente aún no tiene pedidos registrados.
        </div>
    @else
        {{-- Tabla con todos los pedidos del cliente ordenados por fecha --}}
        <div class="overflow-x-auto shadow-lg rounded-xl bg-white">
            <table class="min-w-full text-sm text-gray-800">
                <thead class="bg-blue-100 text-blue-900 uppercase text-xs font-semibold">
                    <tr>
                        <th class="py-3 px-6 text-left"># Pedido</th>
                        <th class="py-3 px-6 text-left">Fecha</th>
                        <th class="py-3 px-6 text-left">Producto</th>
                        <th class="py-3 px-6 text-left">Precio</th>
                        <th class="py-3 px-6 text-left">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pedidos as $pedido)
                        <tr class="border-b hover:bg-blue-50 transition">
                            <td class="py-3 px-6">{{ $pedido->idPed }}</td>
                            <td class="py-3 px-6">
                                {{ \Carbon\Carbon::parse($pedido->fecPed)->format('d/m/Y') }}
                            </td>
                            <td class="py-3 px-6">
                                {{ $pedido->producto->nomPro ?? 'Producto no disponible' }}
                            </td>
                            <td class="py-3 px-6 font-semibold">
                                ${{ number_format($pedido->prePed, 2) }}
                            </td>
                            <td class="py-3 px-6">
                                <span class="text-xs font-bold px-2 py-1 rounded-full
                                    @switch(strtolower($pedido->estPed))
                                        @case('por pagar') bg-yellow-100 text-yellow-800 @break
                                        @case('en camino') bg-blue-100 text-blue-800 @break
                                        @case('finalizado') bg-green-100 text-green-800 @break
                                        @default bg-gray-200 text-gray-600
                                    @endswitch">
                                    {{ ucfirst($pedido->estPed) }}
                                </span>
                            </td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

@endsection
