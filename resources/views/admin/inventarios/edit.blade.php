@extends('layouts.app')

@section('title', 'Editar Inventario - El Bodegazo')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Encabezado mejorado con icono -->
    <div class="flex justify-between items-center mb-8">
        <div class="flex items-center">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-3 rounded-xl mr-4 shadow-md">
                <i class="fas fa-edit text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Editar Inventario</h1>
                <p class="text-gray-600 text-sm">Actualiza la información del producto en inventario</p>
            </div>
        </div>
        <a href="{{ route('admin.inventarios.index') }}" 
           class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2.5 rounded-lg shadow-sm transition duration-200 flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Volver al listado
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 max-w-3xl mx-auto">
        <form action="{{ route('inventarios.update', $inventario->idInv) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <!-- Información actual -->
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
                <h3 class="text-lg font-medium text-gray-800 mb-3 flex items-center">
                    <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                    Información Actual
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div class="flex items-center">
                        <span class="font-medium text-gray-600 mr-2">ID:</span>
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">
                            #{{ $inventario->idInv }}
                        </span>
                    </div>
                    <div class="flex items-center">
                        <span class="font-medium text-gray-600 mr-2">Actualizado:</span>
                        <span class="text-gray-700">
                            {{ $inventario->ultactInv ? $inventario->ultactInv->format('d/m/Y H:i') : 'N/A' }}
                        </span>
                    </div>
                    <div class="flex items-center">
                        <span class="font-medium text-gray-600 mr-2">Estado:</span>
                        <span class="px-2 py-1 rounded-full text-xs font-medium 
                            @if($inventario->canInv <= 0) bg-red-100 text-red-800
                            @elseif($inventario->canInv <= 10) bg-yellow-100 text-yellow-800
                            @else bg-green-100 text-green-800 @endif">
                            @if($inventario->canInv <= 0)
                                <i class="fas fa-times-circle mr-1"></i> Sin Stock
                            @elseif($inventario->canInv <= 10)
                                <i class="fas fa-exclamation-triangle mr-1"></i> Stock Bajo
                            @else
                                <i class="fas fa-check-circle mr-1"></i> Stock Normal
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Campos del formulario -->
            <div class="grid grid-cols-1 gap-6">
                <!-- Producto -->
                <div>
                    <label for="idProInv" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                        <i class="fas fa-box text-gray-500 mr-2"></i>
                        Producto <span class="text-red-500 ml-1">*</span>
                    </label>
                    <select name="idProInv" id="idProInv" required
                            class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out
                            @error('idProInv') border-red-500 @enderror">
                        <option value="">Seleccione un producto</option>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->id }}" 
                                    {{ old('idProInv', $inventario->idProInv) == $producto->id ? 'selected' : '' }}>
                                {{ $producto->nombre }} {{ $producto->codigo ? '- ' . $producto->codigo : '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('idProInv')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Cantidad -->
                <div>
                    <label for="canInv" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                        <i class="fas fa-layer-group text-gray-500 mr-2"></i>
                        Cantidad <span class="text-red-500 ml-1">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-hashtag text-gray-400"></i>
                        </div>
                        <input type="number" name="canInv" id="canInv" required
                               min="0" max="999999" step="1"
                               value="{{ old('canInv', $inventario->canInv) }}"
                               placeholder="Ingrese la cantidad"
                               class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out
                               @error('canInv') border-red-500 @enderror">
                    </div>
                    @error('canInv')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                        </p>
                    @enderror
                    <p class="mt-2 text-sm text-gray-500">
                        <span class="font-medium">Cantidad actual:</span> 
                        <span class="{{ $inventario->canInv <= 10 ? 'text-yellow-600' : 'text-gray-700' }}">
                            {{ $inventario->canInv }}
                        </span>
                    </p>
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('inventarios.index') }}" 
                   class="px-5 py-2.5 inline-flex justify-center items-center border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                    <i class="fas fa-times mr-2"></i> Cancelar
                </a>
                <button type="submit" 
                        class="px-5 py-2.5 inline-flex justify-center items-center border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                    <i class="fas fa-save mr-2"></i> Actualizar Inventario
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validación en tiempo real para cantidad
    const cantidadInput = document.getElementById('canInv');
    cantidadInput.addEventListener('input', function() {
        if (this.value < 0) {
            this.setCustomValidity('La cantidad no puede ser negativa');
        } else if (this.value > 999999) {
            this.setCustomValidity('La cantidad máxima permitida es 999,999');
        } else {
            this.setCustomValidity('');
        }
    });

    // Mostrar advertencia si la cantidad es menor a 10
    cantidadInput.addEventListener('change', function() {
        if (this.value < 10 && this.value > 0) {
            Toastify({
                text: "⚠️ Estás estableciendo un stock bajo",
                duration: 3000,
                gravity: "top",
                position: "right",
                backgroundColor: "#f59e0b",
            }).showToast();
        }
    });
});
</script>
@endsection