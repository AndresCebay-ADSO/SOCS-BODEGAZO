@extends('layouts.app')

@section('title', 'Editar Producto - Administración')

@section('content')
<div class="container mx-auto py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <div class="flex items-center mb-4 md:mb-0">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-3 rounded-xl mr-4 shadow-md">
                    <i class="fas fa-edit text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Editar Producto</h1>
                    <p class="text-gray-600 text-sm">Actualiza la información del producto</p>
                </div>
            </div>
            <a href="{{ route('admin.productos.index') }}" 
               class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition duration-200 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Volver
            </a>
        </div>

        <!-- Mensajes de error -->
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.productos.update', $producto->idPro) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Información Básica -->
                <div class="bg-gray-50 p-5 rounded-xl border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center mb-4">
                        <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                        Información Básica
                    </h3>

                    <div class="space-y-5">
                        <!-- Código -->
                        <div>
                            <label for="codPro" class="block text-sm font-medium text-gray-700 mb-2">
                                Código <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-barcode text-gray-400"></i>
                                </div>
                                <input type="text" name="codPro" id="codPro" 
                                       value="{{ old('codPro', $producto->codPro) }}"
                                       class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 shadow-sm"
                                       placeholder="Código del producto" required>
                            </div>
                        </div>

                        <!-- Nombre -->
                        <div>
                            <label for="nomPro" class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-tag text-gray-400"></i>
                                </div>
                                <input type="text" name="nomPro" id="nomPro" 
                                       value="{{ old('nomPro', $producto->nomPro) }}"
                                       class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 shadow-sm"
                                       placeholder="Nombre del producto" required>
                            </div>
                        </div>

                        <!-- Categoría -->
                        <div>
                            <label for="idcatPro" class="block text-sm font-medium text-gray-700 mb-2">
                                Categoría <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-th-large text-gray-400"></i>
                                </div>
                                <select name="idcatPro" id="idcatPro" 
                                        class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 shadow-sm appearance-none"
                                        required>
                                    <option value="">Selecciona una categoría</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->idCat }}" 
                                                {{ old('idcatPro', $producto->idcatPro) == $categoria->idCat ? 'selected' : '' }}>
                                            {{ $categoria->nomCat }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detalles del Producto -->
                <div class="bg-gray-50 p-5 rounded-xl border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center mb-4">
                        <i class="fas fa-cube text-blue-500 mr-2"></i>
                        Detalles del Producto
                    </h3>

                    <div class="space-y-5">
                        <!-- Marca -->
                        <div>
                            <label for="marPro" class="block text-sm font-medium text-gray-700 mb-2">
                                Marca
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-copyright text-gray-400"></i>
                                </div>
                                <input type="text" name="marPro" id="marPro" 
                                       value="{{ old('marPro', $producto->marPro) }}"
                                       class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 shadow-sm"
                                       placeholder="Marca del producto">
                            </div>
                        </div>

                        <!-- Color -->
                        <div>
                            <label for="colPro" class="block text-sm font-medium text-gray-700 mb-2">
                                Color
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-palette text-gray-400"></i>
                                </div>
                                <input type="text" name="colPro" id="colPro" 
                                       value="{{ old('colPro', $producto->colPro) }}"
                                       class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 shadow-sm"
                                       placeholder="Color del producto">
                            </div>
                        </div>

                        <!-- Talla -->
                        <div>
                            <label for="tallPro" class="block text-sm font-medium text-gray-700 mb-2">
                                Talla
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-ruler text-gray-400"></i>
                                </div>
                                <input type="text" name="tallPro" id="tallPro" 
                                       value="{{ old('tallPro', $producto->tallPro) }}"
                                       class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 shadow-sm"
                                       placeholder="Talla del producto">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Precios -->
                <div class="bg-gray-50 p-5 rounded-xl border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center mb-4">
                        <i class="fas fa-dollar-sign text-blue-500 mr-2"></i>
                        Precios
                    </h3>

                    <div class="space-y-5">
                        <!-- Precio de Compra -->
                        <div>
                            <label for="precio_compra" class="block text-sm font-medium text-gray-700 mb-2">
                                Precio de Compra <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-shopping-cart text-gray-400"></i>
                                </div>
                                <input type="number" name="precio_compra" id="precio_compra" 
                                       value="{{ old('precio_compra', $producto->precio_compra) }}"
                                       step="0.01" min="0"
                                       class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 shadow-sm"
                                       placeholder="0.00" required>
                            </div>
                        </div>

                        <!-- Precio de Venta -->
                        <div>
                            <label for="precio_venta" class="block text-sm font-medium text-gray-700 mb-2">
                                Precio de Venta <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-tags text-gray-400"></i>
                                </div>
                                <input type="number" name="precio_venta" id="precio_venta" 
                                       value="{{ old('precio_venta', $producto->precio_venta) }}"
                                       step="0.01" min="0"
                                       class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 shadow-sm"
                                       placeholder="0.00" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stock e Imagen -->
                <div class="bg-gray-50 p-5 rounded-xl border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center mb-4">
                        <i class="fas fa-boxes text-blue-500 mr-2"></i>
                        Stock e Imagen
                    </h3>

                    <div class="space-y-5">
                        <!-- Cantidad -->
                        <div>
                            <label for="canPro" class="block text-sm font-medium text-gray-700 mb-2">
                                Cantidad en Stock <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-box text-gray-400"></i>
                                </div>
                                <input type="number" name="canPro" id="canPro" 
                                       value="{{ old('canPro', $producto->canPro) }}"
                                       min="0"
                                       class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 shadow-sm"
                                       placeholder="0" required>
                            </div>
                        </div>

                        <!-- Imagen -->
                        <div>
                            <label for="imagen" class="block text-sm font-medium text-gray-700 mb-2">
                                Imagen del Producto
                            </label>
                            <div class="space-y-3">
                                <input type="file" name="imagen" id="imagen" 
                                       accept="image/*"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 shadow-sm">
                                
                                @if($producto->imagen)
                                    <div class="mt-3">
                                        <p class="text-sm text-gray-600 mb-2">Imagen actual:</p>
                                        <img src="{{ asset('storage/productos/'.$producto->imagen) }}" 
                                             alt="{{ $producto->nomPro }}" 
                                             class="w-32 h-32 object-cover rounded-lg border border-gray-200">
                                    </div>
                                @endif
                                
                                <div class="mt-3">
                                    <p class="text-sm text-gray-600 mb-2">Vista previa:</p>
                                    <img id="imagen-preview" src="{{ asset('images/default-product.png') }}" 
                                         alt="Vista previa" 
                                         class="w-32 h-32 object-contain rounded-lg border border-gray-200 bg-gray-50">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estado y Configuración -->
            <div class="bg-gray-50 p-5 rounded-xl border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center mb-4">
                    <i class="fas fa-cog text-blue-500 mr-2"></i>
                    Configuración
                </h3>

                <div class="space-y-5">
                    <!-- Estado -->
                    <div>
                        <label for="estPro" class="block text-sm font-medium text-gray-700 mb-2">
                            Estado <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-power-off text-gray-400"></i>
                            </div>
                            <select name="estPro" id="estPro" 
                                    class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 shadow-sm appearance-none"
                                    required>
                                <option value="Activo" {{ old('estPro', $producto->estPro) == 'Activo' ? 'selected' : '' }}>Activo</option>
                                <option value="Inactivo" {{ old('estPro', $producto->estPro) == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Activo -->
                    <div class="flex items-center">
                        <div class="flex items-center h-5">
                            <input type="checkbox" name="activo" value="1" 
                                   class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 transition duration-200"
                                   {{ old('activo', $producto->activo) ? 'checked' : '' }}>
                        </div>
                        <div class="ml-3 text-sm">
                            <label class="font-medium text-gray-700">Producto visible en el sistema</label>
                            <p class="text-xs text-gray-500 mt-1">Desmarca para ocultar este producto</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Descripción -->
            <div class="bg-gray-50 p-5 rounded-xl border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center mb-4">
                    <i class="fas fa-align-left text-blue-500 mr-2"></i>
                    Descripción
                </h3>
                <textarea name="descripcion" id="descripcion" rows="4"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 shadow-sm"
                          placeholder="Ingrese una descripción detallada del producto...">{{ old('descripcion', $producto->descripcion) }}</textarea>
            </div>

            <!-- Botones de acción -->
            <div class="flex justify-end space-x-4 border-t pt-6">
                <a href="{{ route('admin.productos.index') }}" 
                   class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition duration-200 flex items-center shadow-sm hover:shadow-md transform hover:-translate-y-0.5">
                    <i class="fas fa-times mr-2"></i>
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg shadow-md transition duration-300 flex items-center transform hover:-translate-y-0.5 hover:shadow-lg">
                    <i class="fas fa-save mr-2"></i>
                    Actualizar Producto
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Script para vista previa de imagen -->
@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const imagenInput = document.getElementById('imagen');
    const imagenPreview = document.getElementById('imagen-preview');

    imagenInput.addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagenPreview.src = e.target.result;
                imagenPreview.classList.remove('object-contain');
                imagenPreview.classList.add('object-cover');
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
});
</script>
@endsection