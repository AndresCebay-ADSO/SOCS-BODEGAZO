@extends('layouts.app')

@section('title', 'Crear Nuevo Producto - El Bodegazo')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-6">
    <div class="flex justify-between items-center mb-10">
        <h1 class="text-3xl font-extrabold text-gray-700 flex items-center gap-3 drop-shadow" style="letter-spacing:0.5px;">
            <i class="fas fa-cube text-blue-600"></i>
            Crear Nuevo Producto
        </h1>
        <a href="{{ route('admin.productos.index') }}"
           class="bg-gradient-to-r from-gray-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium px-5 py-2 rounded-lg shadow-lg transition-all flex items-center group">
            <i class="fas fa-arrow-left mr-2"></i> 
            <span class="group-hover:underline">Volver</span>
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-xl border border-blue-100 px-10 py-8">
        @if(session('error'))
            <div class="mb-6 bg-red-100 border-l-4 border-red-400 text-red-800 p-4 rounded">
                <strong>¡Error!</strong> <span>{{ session('error') }}</span>
            </div>
        @endif

        <form action="{{ route('admin.productos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <!-- Fila superior -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <!-- Columna 1: Info principal -->
                <div class="space-y-5">
                    @foreach([
                        ['nomPro', 'Nombre del Producto', 'fa-tag', true, 'Ej: Adidas Campus'],
                        ['marPro', 'Marca', 'fa-copyright', false, 'Ej: Nike, Adidas, etc.'],
                        ['codPro', 'Código', 'fa-barcode', true, 'Ej: PROD-001'],
                        ['colPro', 'Color', 'fa-palette', false, 'Ej: Rojo, Azul, etc.']
                    ] as [$id, $label, $icon, $oblig, $placeholder])
                    <div>
                        <label for="{{ $id }}" class="text-sm font-semibold text-gray-700 mb-1 flex items-center gap-1
                            @error($id) text-red-700 @enderror">
                            <i class="fas {{ $icon }} text-blue-500"></i> 
                            {{ $label }} 
                            @if($oblig)<span class="text-red-500">*</span>@endif
                        </label>
                        <input
                            type="text"
                            name="{{ $id }}"
                            id="{{ $id }}"
                            value="{{ old($id) }}"
                            placeholder="{{ $placeholder }}"
                            class="w-full px-4 py-2 border border-gray-200 rounded-xl bg-gray-50 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 text-gray-700 shadow-sm transition-all @error($id) border-red-400 @enderror"
                            @if($oblig) required @endif
                        >
                        @error($id)
                            <p class="text-xs text-red-600 mt-1 pl-2">{{ $message }}</p>
                        @enderror
                    </div>
                    @endforeach
                </div>

                <!-- Columna 2: Imagen y Talla -->
                <div class="space-y-5">
                    <!-- Imagen -->
                    <div>
                        <label class="text-sm font-semibold text-gray-700 mb-1 flex items-center gap-1">
                            <i class="fas fa-image text-blue-500"></i> Imagen del Producto
                        </label>
                        <div class="flex flex-col items-center gap-2">
                            <div class="relative group">
                                <img id="imagen-preview" src="{{ asset('images/default-product.png') }}"
                                    alt="Vista previa de la imagen"
                                    class="h-44 w-44 object-contain bg-gray-100 border-2 border-dashed border-blue-200 rounded-xl shadow group-hover:border-blue-400 transition-all" />
                                <button type="button" id="remove-image-btn"
                                        class="absolute top-0 right-0 bg-red-600 text-white rounded-full p-1 hover:bg-red-700 hidden shadow">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                            </div>
                            <label for="imagen"
                                   class="cursor-pointer flex flex-col items-center justify-center w-full h-20 border-2 border-dashed border-blue-200 rounded-lg bg-gray-50 hover:bg-blue-50 transition-all group">
                                <i class="fas fa-cloud-upload-alt text-2xl text-blue-400 mb-1"></i>
                                <span class="text-xs text-gray-700 font-medium">Haz clic para subir o arrastra aquí</span>
                                <span class="text-xs text-gray-500">JPG, PNG (Máx. 2MB)</span>
                                <input id="imagen" name="imagen" type="file" class="hidden" accept="image/*">
                            </label>
                        </div>
                        @error('imagen')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Talla -->
                    <div>
                        <label for="tallPro" class="text-sm font-semibold text-gray-700 mb-1 flex items-center gap-1">
                            <i class="fas fa-ruler-combined text-blue-500"></i> Talla
                        </label>
                        <input type="text" name="tallPro" id="tallPro"
                            value="{{ old('tallPro') }}"
                            placeholder="Ej: 38"
                            class="w-full px-4 py-2 border border-gray-200 rounded-xl bg-gray-50 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 text-gray-700 shadow-sm transition-all">
                    </div>
                </div>
            </div>
            <hr class="my-6 border-blue-100">

            <!-- Segunda fila: Categoría, Unidad, Info -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Categoría -->
                <div>
                    <label for="idcatPro"
                        class="text-sm font-semibold text-gray-700 mb-1 flex items-center gap-1 @error('idcatPro') text-red-700 @enderror">
                        <i class="fas fa-tags text-blue-500"></i>
                        Categoría <span class="text-red-500">*</span>
                    </label>
                    <select name="idcatPro" id="idcatPro"
                            class="w-full px-4 py-2 border border-gray-200 rounded-xl bg-gray-50 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 text-gray-700 shadow-sm transition-all @error('idcatPro') border-red-400 @enderror"
                            required>
                        <option value="">Seleccione categoría</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->idCat }}" {{ old('idcatPro') == $categoria->idCat ? 'selected' : '' }}>
                                {{ $categoria->nomCat }}
                            </option>
                        @endforeach
                    </select>
                    @error('idcatPro')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Unidad de Medida -->
                <div>
                    <label for="unidad_medida" class="text-sm font-semibold text-gray-700 mb-1 flex items-center gap-1">
                        <i class="fas fa-balance-scale text-blue-500"></i>
                        Unidad de Medida <span class="text-red-500">*</span>
                    </label>
                    <select name="unidad_medida" id="unidad_medida"
                            class="w-full px-4 py-2 border border-gray-200 rounded-xl bg-gray-50 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 text-gray-700 shadow-sm transition-all"
                            required>
                        <option value="UND" {{ old('unidad_medida','UND') == 'UND' ? 'selected' : '' }}>Unidades (UND)</option>
                        <option value="KG" {{ old('unidad_medida') == 'KG' ? 'selected' : '' }}>Kilogramos (KG)</option>
                        <option value="LT" {{ old('unidad_medida') == 'LT' ? 'selected' : '' }}>Litros (LT)</option>
                        <option value="MTS" {{ old('unidad_medida') == 'MTS' ? 'selected' : '' }}>Metros (MTS)</option>
                    </select>
                </div>
                <!-- Info stock -->
                <div>
                    <div class="bg-blue-50 border-l-4 border-blue-400 flex items-center gap-3 py-3 px-4 rounded-xl shadow-sm text-blue-700 mt-4 md:mt-0 border-opacity-70">
                        <i class="fas fa-info-circle text-blue-400"></i>
                        <span class="text-xs">La cantidad en stock se gestiona desde el <b>módulo de inventarios</b> luego de crear el producto.</span>
                    </div>
                </div>
            </div>
            <hr class="my-6 border-blue-100">

            <!-- Fila inferior: precios y estado -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Precio Compra -->
                <div>
                    <label for="precio_compra" class="text-sm font-semibold text-gray-700 mb-1 flex items-center gap-1">
                        <i class="fas fa-money-bill-wave text-blue-500"></i> Precio de Compra
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-blue-400 font-bold">$</span>
                        <input type="number" name="precio_compra" id="precio_compra"
                            value="{{ old('precio_compra') }}"
                            min="0" step="0.01"
                            placeholder="0.00"
                            class="pl-8 w-full px-4 py-2 border border-gray-200 rounded-xl bg-gray-50 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 text-gray-700 shadow-sm transition-all">
                    </div>
                </div>
                <!-- Precio Venta -->
                <div>
                    <label for="precio_venta" class="text-sm font-semibold text-gray-700 mb-1 flex items-center gap-1">
                        <i class="fas fa-tag text-blue-500"></i> Precio de Venta
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-blue-400 font-bold">$</span>
                        <input type="number" name="precio_venta" id="precio_venta"
                            value="{{ old('precio_venta') }}"
                            min="0" step="0.01"
                            placeholder="0.00"
                            class="pl-8 w-full px-4 py-2 border border-gray-200 rounded-xl bg-gray-50 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 text-gray-700 shadow-sm transition-all">
                    </div>
                </div>
                <!-- Estado -->
                <div>
                    <label for="estPro" class="text-sm font-semibold text-gray-700 mb-1 flex items-center gap-1">
                        <i class="fas fa-toggle-on text-blue-500"></i>
                        Estado <span class="text-red-500">*</span>
                    </label>
                    <select name="estPro" id="estPro"
                            class="w-full px-4 py-2 border border-gray-200 rounded-xl bg-gray-50 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 text-gray-700 shadow-sm transition-all"
                            required>
                        <option value="Activo" {{ old('estPro', 'Activo') == 'Activo' ? 'selected' : '' }}>Activo</option>
                        <option value="Inactivo" {{ old('estPro') == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                        <option value="Agotado" {{ old('estPro') == 'Agotado' ? 'selected' : '' }}>Agotado</option>
                    </select>
                </div>
            </div>

            <!-- Descripción -->
            <div>
                <label for="descripcion" class="text-sm font-semibold text-gray-700 mb-1 flex items-center gap-1">
                    <i class="fas fa-align-left text-blue-500"></i> Descripción
                </label>
                <textarea name="descripcion" id="descripcion" rows="4"
                    placeholder="Características adicionales del producto..."
                    class="w-full px-4 py-2 border border-gray-200 rounded-xl bg-gray-50 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 text-gray-700 shadow-sm resize-none transition-all"
                >{{ old('descripcion') }}</textarea>
            </div>

            <div class="flex items-center">
                <input type="hidden" name="activo" value="0">
                <input type="checkbox" name="activo" id="activo" value="1"
                    {{ old('activo', 1) ? 'checked' : '' }}
                    class="h-4 w-4 text-blue-600 focus:ring-blue-400 border-gray-300 rounded">
                <label for="activo" class="ml-2 text-gray-700 text-xs font-semibold cursor-pointer select-none">Producto activo y visible en el sistema</label>
            </div>

            <!-- Botones -->
            <div class="flex justify-end gap-4 pt-4">
                <a href="{{ route('admin.productos.index') }}"
                   class="inline-flex items-center px-6 py-2 border border-blue-200 bg-gray-50 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 font-medium transition-all shadow-md">
                    <i class="fas fa-times mr-2"></i> Cancelar
                </a>
                <button type="submit"
                        class="inline-flex items-center px-8 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-bold shadow-lg transition-all transform hover:scale-105">
                    <i class="fas fa-save mr-2"></i> Guardar Producto
                </button>
            </div>
        </form>
    </div>
</div>

<style>
/* Puedes ajustar aún más algunos estilos vía Tailwind o aquí si deseas: */
input:focus, select:focus, textarea:focus {
    outline: none!important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imagenInput = document.getElementById('imagen');
    const imagenPreview = document.getElementById('imagen-preview');
    const removeImageBtn = document.getElementById('remove-image-btn');
    const defaultImage = "{{ asset('images/default-product.png') }}";

    imagenInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagenPreview.src = e.target.result;
                imagenPreview.classList.remove('object-contain');
                imagenPreview.classList.add('object-cover');
                removeImageBtn.classList.remove('hidden');
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    removeImageBtn.addEventListener('click', function() {
        imagenInput.value = '';
        imagenPreview.src = defaultImage;
        imagenPreview.classList.remove('object-cover');
        imagenPreview.classList.add('object-contain');
        this.classList.add('hidden');
    });
});
</script>
@endsection
