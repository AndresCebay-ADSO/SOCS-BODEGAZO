@extends('layouts.auth')

@section('title', 'Iniciar Sesión - El Bodegazo')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-secondary-100">
    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8 border border-gray-200">
        <!-- Encabezado -->
        <div class="text-center mb-6">
            <a href="{{ url('/') }}" class="text-3xl font-bold text-primary-600 tracking-wide" >El Bodegazo</a>
            <p class="text-gray-600 mt-1">Tienda de calzado online</p>
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

        <!-- Mensaje de éxito -->
        @if (session('success'))
            <div class="bg-green-100 text-green-800 text-sm p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Formulario -->
        <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
            @csrf

            <!-- Email -->
            <div>
                <label for="emaUsu" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                <div class="mt-1 relative">
                    <input type="email" id="emaUsu" name="emaUsu" required
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 pl-10 py-2"
                        placeholder="ejemplo@correo.com">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-gray-400"></i>
                    </div>
                </div>
            </div>

<!-- Contraseña -->
<div>
    <label for="passUsu" class="block text-sm font-medium text-gray-700">Contraseña</label>
    <div class="mt-1 relative">
        <input type="password" id="passUsu" name="passUsu" required
            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 pl-10 pr-10 py-2"
            placeholder="••••••••">
        
        <!-- Icono a la izquierda -->
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <i class="fas fa-lock text-gray-400"></i>
        </div>

        <!-- Botón mostrar/ocultar -->
        <button type="button" id="togglePassword"
            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-primary-600 focus:outline-none">
            👁️
        </button>
    </div>
</div>

<!-- Script funcional Para contraseña-->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggle = document.getElementById('togglePassword');
        const input = document.getElementById('passUsu');

        toggle.addEventListener('click', function () {
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            toggle.textContent = isPassword ? '🙈' : '👁️';
        });
    });
</script>



            <!-- Recordar -->
            <div class="flex items-center">
                <input id="remember" name="remember" type="checkbox"
                    class="h-4 w-4 text-primary-600 border-gray-300 rounded">
                <label for="remember" class="ml-2 block text-sm text-gray-700">
                    Recordar mi sesión
                </label>
            </div>

            <!-- Botón de enviar -->
            <button type="submit"
                class="w-full bg-primary-600 hover:bg-primary-500 text-white py-2 rounded-lg font-semibold transition duration-200">
                <i class="fas fa-sign-in-alt mr-2"></i>Ingresar
            </button>

            <!-- Enlaces -->
            <div class="text-center text-sm mt-4">
                <a href="{{ route('password.request') }}" class="text-primary-600 hover:underline">¿Olvidaste tu contraseña?</a>
                <hr class="my-3">
                <span>¿No tienes cuenta?
                    <a href="{{ route('register') }}" class="text-primary-600 font-semibold hover:underline">Regístrate</a>
                </span>
            </div>
        </form>
    </div>
</div>
@endsection
