@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <!-- Encabezado con acciones -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Detalle del Producto</h2>
        <div class="flex space-x-4">
            <a href="{{ route('admin.productos.edit', $producto->idPro) }}" 
               class="text-yellow-600 hover:text-yellow-800 flex items-center space-x-1 font-medium transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-7-7l7 7"/>
                </svg>
                <span>Editar</span>
            </a>
            <a href="{{ route('admin.productos.index') }}" 
               class="text-gray-500 hover:text-gray-700 flex items-center transition" aria-label="Volver al listado de productos">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </a>
        </div>
    </div>

    <!-- Contenedor principal -->
    <div class="bg-white shadow-md rounded-lg border border-gray-200 overflow-hidden">
        <!-- Cabecera producto -->
        <div class="px-6 py-4 border-b border-gray-200 flex items-center">
            <div class="flex-shrink-0 h-20 w-20 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden border">
                <img src="{{ $producto->imagen_url }}" 
                     alt="{{ $producto->nomPro }}" 
                     class="w-full h-full object-contain p-2"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display: none;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-900">{{ $producto->nomPro }}</h3>
                <p class="text-sm text-gray-500">{{ $producto->categoria->nomCat ?? 'Sin categoría' }}</p>
            </div>
            <div class="ml-auto">
                <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full
                    {{ $producto->estPro == 'Activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $producto->estPro }}
                </span>
            </div>
        </div>

        <!-- Contenido del detalle -->
        <div class="px-6 py-6 space-y-8">
            <!-- Imagen del producto -->
            <div class="flex justify-center">
                <div class="w-64 h-64 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden border-2 border-gray-200">
                    <img src="{{ $producto->imagen_url }}" 
                         alt="{{ $producto->nomPro }}" 
                         class="max-w-full max-h-full object-contain p-4"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Información Básica -->
                <section>
                    <h4 class="text-md font-semibold text-gray-700 mb-4 border-b border-gray-200 pb-2">Información Básica</h4>
                    <dl class="grid grid-cols-2 gap-x-6 gap-y-4 text-sm text-gray-700">
                        <div>
                            <dt class="font-medium text-gray-500">Código</dt>
                            <dd class="mt-1">{{ $producto->codPro }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-500">Marca</dt>
                            <dd class="mt-1">{{ $producto->marPro ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-500">Color</dt>
                            <dd class="mt-1">{{ $producto->colPro ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-500">Talla</dt>
                            <dd class="mt-1">{{ $producto->tallPro ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-500">Unidad de Medida</dt>
                            <dd class="mt-1">{{ $producto->unidad_medida }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-500">Stock Actual</dt>
                            <dd class="mt-1">{{ $producto->canPro }} {{ $producto->unidad_medida }}</dd>
                        </div>
                    </dl>
                </section>

                <!-- Información Financiera -->
                <section>
                    <h4 class="text-md font-semibold text-gray-700 mb-4 border-b border-gray-200 pb-2">Información Financiera</h4>
                    <dl class="grid grid-cols-2 gap-x-6 gap-y-4 text-sm text-gray-700">
                        <div>
                            <dt class="font-medium text-gray-500">Precio Compra</dt>
                            <dd class="mt-1">${{ number_format($producto->precio_compra, 2) }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-500">Precio Venta</dt>
                            <dd class="mt-1">${{ number_format($producto->precio_venta, 2) }}</dd>
                        </div>
                        <div class="col-span-2">
                            <dt class="font-medium text-gray-500">Margen de Ganancia</dt>
                            <dd class="mt-1">
                                @if($producto->precio_compra && $producto->precio_venta)
                                    {{ number_format((($producto->precio_venta - $producto->precio_compra) / $producto->precio_compra) * 100, 2) }}%
                                @else
                                    N/A
                                @endif
                            </dd>
                        </div>
                    </dl>
                </section>
            </div>

            <!-- Descripción -->
            <section>
                <h4 class="text-md font-semibold text-gray-700 mb-3 border-b border-gray-200 pb-2">Descripción</h4>
                <p class="text-sm text-gray-700 break-words">
                    {{ $producto->descripcion ?? 'No hay descripción disponible' }}
                </p>
            </section>
        </div>

        <!-- Historial de Inventario -->
        <div class="px-6 py-6 border-t border-gray-200">
            <h4 class="text-md font-semibold text-gray-700 mb-4 border-b border-gray-200 pb-2">Movimientos de Inventario</h4>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-600">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wide">Fecha</th>
                            <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wide">Tipo</th>
                            <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wide">Cantidad</th>
                            <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wide">Responsable</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($producto->inventarios as $movimiento)
                            <tr>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    {{ $movimiento->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    {{ $movimiento->tipo ?? 'Entrada' }}
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    {{ $movimiento->canInv }} {{ $producto->unidad_medida }}
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    {{ $movimiento->usuario->name ?? 'Sistema' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-3 py-4 text-center text-gray-400">
                                    No hay movimientos registrados
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
