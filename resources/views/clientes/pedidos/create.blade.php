@extends('layouts.app')

@section('title', 'Realizar Pedido')

@section('content')

<h2 class="text-2xl font-bold text-blue-800 mb-4">📝 Hacer Pedido</h2>



@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <strong>Errores:</strong>
        <ul class="mt-2 list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>🔸 {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('clientes.pedidos.store') }}" method="POST" class="space-y-4">
    @csrf

    <div>
        <label class="block font-semibold">Nombre completo</label>
        <input type="text" name="nombre" class="w-full border rounded px-3 py-2"
               value="{{ old('nombre') }}" required maxlength="100"
               placeholder="Ej: María Pérez">
    </div>

    <div>
        <label class="block font-semibold">Teléfono</label>
        <input type="tel" name="telefono" class="w-full border rounded px-3 py-2"
               value="{{ old('telefono') }}" required pattern="[0-9]{7,15}"
               placeholder="Solo números, entre 7 y 15 dígitos">
    </div>

    <div>
        <label class="block font-semibold">Dirección</label>
        <input type="text" name="direccion" class="w-full border rounded px-3 py-2"
               value="{{ old('direccion') }}" required maxlength="255"
               placeholder="Ej: Calle 5B Sur #17A-12">
    </div>

    <div>
        <label class="block font-semibold">Producto</label>
        <select name="producto" class="w-full border rounded px-3 py-2" required>
            <option value="">-- Selecciona un producto --</option>
            @foreach ($productos as $producto)
                <option value="{{ $producto->idPro }}" {{ old('producto') == $producto->idPro ? 'selected' : '' }}>
                    {{ $producto->nomPro }} ({{ $producto->canPro }} disponibles)
                </option>
            @endforeach
        </select>
    </div>

    {{-- Método de pago --}}
    <div>
        <label class="block font-semibold">Método de pago</label>
        <select name="metodo_pago" class="w-full border rounded px-3 py-2" required>
            <option value="">-- Selecciona un método --</option>
            <option value="Efectivo" {{ old('metodo_pago') == 'Efectivo' ? 'selected' : '' }}>Efectivo</option>
            <option value="Transferencia" {{ old('metodo_pago') == 'Transferencia' ? 'selected' : '' }}>Transferencia</option>
            <option value="Nequi" {{ old('metodo_pago') == 'Nequi' ? 'selected' : '' }}>Nequi</option>
            <option value="Daviplata" {{ old('metodo_pago') == 'Daviplata' ? 'selected' : '' }}>Daviplata</option>
        </select>
    </div>

    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
        🛒 Enviar Pedido
    </button>
</form>

@endsection
