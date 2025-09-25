@extends('layouts.app')

@section('title', 'Crear Pedido')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-blue-800 mb-4 text-center">➕ Crear Nuevo Pedido</h2>

        <!-- Mostrar errores -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <strong>¡Ups!</strong> Hay algunos problemas con los datos:<br><br>
                <ul class="list-disc pl-6">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pedidos.store') }}" method="POST" class="space-y-4" id="pedidoForm">
            @csrf

            <!-- Campo Cliente -->
            <div>
                <label for="idUsuPed" class="block text-sm font-medium text-gray-700">👤 Cliente *</label>
                    <select name="idUsuPed" id="idUsuPed" required>
                        <option value="">-- Seleccione cliente --</option>
                            @foreach ($usuarios as $usuario)
                                @if($usuario->idRolUsu == 2 && $usuario->estadoUsu == 'activo')
                                    <option value="{{ $usuario->id }}" {{ old('idUsuPed') == $usuario->id ? 'selected' : '' }}>
                                        {{ $usuario->nomUsu }} {{ $usuario->apeUsu }}
                                    </option>
                                @endif
                            @endforeach
                    </select>
            </div>

            <!-- Campo Producto -->
            <div>
                <label for="idProPed" class="block text-sm font-medium text-gray-700">👟 Producto *</label>
                <select name="idProPed" id="idProPed" class="w-full mt-1 border border-gray-300 rounded px-3 py-2 focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="" disabled selected>-- Selecciona un producto --</option>
                    @foreach ($productos as $producto)
                        <option value="{{ $producto->idPro }}" {{ old('idProPed') == $producto->idPro ? 'selected' : '' }} data-precio="{{ $producto->prePro }}">
                            {{ $producto->nomPro }} - {{ $producto->tallPro }} - {{ $producto->colPro }} ({{ $producto->prePro }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Campo Fecha -->
            <div>
                <label for="fecPed" class="block text-sm font-medium text-gray-700">📅 Fecha del pedido *</label>
                    <input type="date" name="fecPed" id="fecPed" value="{{ old('fecPed', now()->format('Y-m-d')) }}" min="{{ now()->format('Y-m-d') }}"
                        class="w-full mt-1 border border-gray-300 rounded px-3 py-2 focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <!-- Campo Precio -->
        <div>
            <label for="prePed" class="block text-sm font-medium text-gray-700">💲 Precio *</label>
            <input type="number" 
                name="prePed" 
                id="prePed" 
                step="0.01" 
                min="1000" 
                max="1000000"
                value="{{ old('prePed', 1000) }}"
                class="w-full mt-1 border border-gray-300 rounded px-3 py-2 focus:ring-blue-500 focus:border-blue-500" 
                placeholder="Mínimo $1,000" 
                required>
        </div>

            <!-- Botones -->
            <div class="text-right">
                <a href="{{ route('pedidos.index') }}" class="inline-block bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 mr-2">
                    🔙 Cancelar
                </a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    💾 Guardar Pedido
                </button>
            </div>
        </form>
    </div>

    <!-- Script opcional para autocompletar precio -->
    <script>
        document.getElementById('idProPed').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                document.getElementById('prePed').value = selectedOption.getAttribute('data-precio');
            }
        });
    </script>
@endsection