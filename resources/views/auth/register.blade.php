@extends('layouts.auth')

@section('title', 'Registro - El Bodegazo')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-secondary-100">
    <div class="w-full max-w-lg bg-white rounded-xl shadow-lg p-8 border border-gray-200">
        <!-- Encabezado -->
        <div class="text-center mb-6">
            <h2 class="text-3xl font-bold text-primary-600">Crea tu cuenta</h2>
            <p class="text-gray-600 text-sm mt-1">Únete a <span class="text-red-500 font-semibold">El Bodegazo</span>, tu tienda de calzado</p>
        </div>

        <!-- Mensajes de error -->
        @if ($errors->any())
            <div class="bg-red-100 text-red-800 text-sm p-3 rounded mb-4">
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Mensaje de sesión -->
        @if (session('status'))
            <div class="bg-green-100 text-green-800 text-sm p-3 rounded mb-4">
                {{ session('status') }}
            </div>
        @endif

        <!-- Formulario -->
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Nombre -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" name="nomUsu" value="{{ old('nomUsu') }}" required
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 py-2 px-3">
                </div>

                <!-- Apellido -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Apellido</label>
                    <input type="text" name="apeUsu" value="{{ old('apeUsu') }}" required
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 py-2 px-3">
                </div>
            </div>

            <!-- Dirección -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Dirección</label>
                <input type="text" name="dirUsu" value="{{ old('dirUsu') }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 py-2 px-3">
            </div>

            <!-- Teléfono -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                <input type="text" name="telUsu" value="{{ old('telUsu') }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 py-2 px-3">
            </div>

            <!-- Tipo de documento -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Tipo de Documento</label>
                <select name="TipdocUsu" required
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 py-2 px-3">
                    <option value="">Seleccione</option>
                    <option value="Cedula de Ciudadania" {{ old('TipdocUsu') == 'Cedula de Ciudadania' ? 'selected' : '' }}>Cédula de Ciudadanía</option>
                    <option value="Tarjeta de Identidad" {{ old('TipdocUsu') == 'Tarjeta de Identidad' ? 'selected' : '' }}>Tarjeta de Identidad</option>
                    <option value="Cédula de Extranjería" {{ old('TipdocUsu') == 'Cédula de Extranjería' ? 'selected' : '' }}>Cédula de Extranjería</option>
                </select>
            </div>

            <!-- Número de documento -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Número de Documento</label>
                <input type="text" name="numdocUsu" value="{{ old('numdocUsu') }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 py-2 px-3">
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                <input type="email" name="emaUsu" value="{{ old('emaUsu') }}" required
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 py-2 px-3"
                    placeholder="tucorreo@ejemplo.com">
            </div>

            <!-- Contraseña -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Contraseña</label>
                <input type="password" name="passUsu" required
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 py-2 px-3"
                    placeholder="••••••••">
            </div>

            <!-- Confirmar contraseña -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Confirmar Contraseña</label>
                <input type="password" name="passUsu_confirmation" required
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 py-2 px-3"
                    placeholder="••••••••">
            </div>

            <!-- Términos y condiciones -->
            <div class="flex items-start space-x-2">
                <input type="checkbox" name="terms" id="terms" required
                    class="mt-1 h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                <label for="terms" class="text-sm text-gray-600">
                    He leído y acepto los 
                    <a href="{{ route('clientes.politicas.terminos') }}" 
                       class="text-primary-600 hover:text-primary-500 font-semibold"
                       onclick="event.preventDefault(); mostrarResumen();">
                        Términos y Condiciones
                    </a>
                </label>
            </div>

            <!-- Modal de resumen -->
            <div id="modal-terminos" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                    <div class="mt-3 text-center">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Términos y Condiciones</h3>
                        <div class="mt-2 px-7 py-3">
                            <p class="text-sm text-gray-500">
                                Al registrarte, aceptas:
                                <ul class="list-disc text-left mt-2 ml-4">
                                    <li>Proporcionar información verdadera y actualizada</li>
                                    <li>Responsabilizarte del uso de tu cuenta</li>
                                    <li>Cumplir con los términos de pago y envío</li>
                                    <li>Respetar las políticas de devolución</li>
                                </ul>
                            </p>
                        </div>
                        <div class="items-center px-4 py-3">
                            <button id="cerrar-modal" class="px-4 py-2 bg-primary-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500">
                                Entendido
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botón de registro -->
            <button type="submit"
                class="w-full bg-primary-600 hover:bg-primary-500 text-white py-2 rounded-lg font-semibold transition duration-200">
                Registrarse
            </button>

            <!-- Enlace a login -->
            <div class="text-center text-sm mt-4">
                ¿Ya tienes cuenta?
                <a href="{{ route('login') }}" class="text-primary-600 font-semibold hover:underline">
                    Inicia sesión
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function mostrarResumen() {
    document.getElementById('modal-terminos').classList.remove('hidden');
}

document.getElementById('cerrar-modal').addEventListener('click', function() {
    document.getElementById('modal-terminos').classList.add('hidden');
});
</script>
@endpush
@endsection
