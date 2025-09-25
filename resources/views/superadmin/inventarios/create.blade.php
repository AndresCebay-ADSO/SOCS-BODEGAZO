@extends('layouts.app')

@section('title', 'Nuevo Registro de Inventario')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Encabezado mejorado con icono -->
    <div class="flex justify-between items-center mb-8">
        <div class="flex items-center">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-3 rounded-xl mr-4 shadow-md">
                <i class="fas fa-boxes text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Nuevo Registro de Inventario</h1>
                <p class="text-gray-600 text-sm">Agrega un nuevo producto al inventario</p>
            </div>
        </div>
        <a href="{{ route('inventarios.index') }}" 
           class="text-gray-500 hover:text-gray-700 transition duration-150 ease-in-out"
           aria-label="Cerrar formulario">
            <i class="fas fa-times text-xl"></i>
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
        <form action="{{ route('inventarios.store') }}" method="POST" novalidate>
            @csrf
            
            <div class="p-6">
                <!-- Grid Layout -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Product Selection -->
                    <div class="space-y-2">
                        <label for="idProInv" class="block text-sm font-medium text-gray-700 flex items-center">
                            <i class="fas fa-box mr-2 text-gray-500"></i>
                            Producto <span class="text-red-500 ml-1">*</span>
                        </label>
                        <select name="idProInv" id="idProInv" required
                                class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out
                                @error('idProInv') border-red-500 @enderror">
                            <option value="" disabled selected>Seleccione un producto</option>
                            @foreach($categorias as $categoria)
                                <optgroup label="{{ $categoria->nomCat }}">
                                    @foreach($categoria->productos as $producto)
                                        <option value="{{ $producto->idPro }}" @if(old('idProInv') == $producto->idPro) selected @endif>
                                            {{ $producto->nomPro }} ({{ $producto->codPro }})
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        @error('idProInv')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Quantity Input -->
                    <div class="space-y-2">
                        <label for="canInv" class="block text-sm font-medium text-gray-700 flex items-center">
                            <i class="fas fa-layer-group mr-2 text-gray-500"></i>
                            Cantidad <span class="text-red-500 ml-1">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-hashtag text-gray-400"></i>
                            </div>
                            <input type="number" name="canInv" id="canInv" min="1" step="1" 
                                   value="{{ old('canInv') }}" required
                                   class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out
                                   @error('canInv') border-red-500 @enderror">
                            @error('canInv')
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('inventarios.index') }}" 
                       class="px-5 py-2.5 inline-flex justify-center items-center border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                        <i class="fas fa-times mr-2"></i> Cancelar
                    </a>
                    <button type="submit" 
                            class="px-5 py-2.5 inline-flex justify-center items-center border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                        <i class="fas fa-save mr-2"></i> Guardar Registro
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mejora la experiencia del select de productos
    const selectProducto = document.getElementById('idProInv');
    
    // Focus al cargar la página (si no hay errores)
    @if(!$errors->any())
    setTimeout(() => {
        selectProducto.focus();
    }, 100);
    @endif

    // Validación en tiempo real para cantidad
    const cantidadInput = document.getElementById('canInv');
    cantidadInput.addEventListener('input', function() {
        if (this.value < 1) {
            this.setCustomValidity('La cantidad debe ser al menos 1');
        } else {
            this.setCustomValidity('');
        }
    });

    // Mejorar experiencia en móviles
    if (window.innerWidth < 768) {
        document.querySelectorAll('select, input').forEach(el => {
            el.classList.add('text-base');
        });
    }
});
</script>
@endsection