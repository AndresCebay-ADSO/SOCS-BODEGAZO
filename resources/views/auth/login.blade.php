@extends('layouts.auth')

@section('title', 'Iniciar Sesión - El Bodegazo')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-secondary-100">
    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8 border border-gray-200">
        <!-- Encabezado -->
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="text-3xl font-bold text-primary-600 tracking-wide" >El Bodegazo</a>
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
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 pl-10 pr-10 py-2 password-toggle"
                        placeholder="••••••••"
                        data-toggle-target="passwordToggleIcon">
                    
                    <!-- Icono a la izquierda -->
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>

                    <!-- Botón mostrar/ocultar - Versión técnica -->
                    <button type="button"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center password-toggle-btn"
                        data-toggle-input="passUsu"
                        aria-label="Mostrar contraseña"
                        tabindex="0">
                        <i id="passwordToggleIcon" class="fas fa-eye text-gray-500 hover:text-primary-600 transition-colors duration-200"></i>
                    </button>
                </div>
            </div>

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

<script>
    class PasswordToggle {
        constructor(buttonElement) {
            this.button = buttonElement;
            this.inputId = this.button.getAttribute('data-toggle-input');
            this.input = document.getElementById(this.inputId);
            this.icon = this.button.querySelector('i');
            
            this.init();
        }
        
        init() {
            this.button.addEventListener('click', this.toggle.bind(this));
            this.button.addEventListener('keydown', this.handleKeydown.bind(this));
            
            // Configurar atributos de accesibilidad
            this.button.setAttribute('aria-pressed', 'false');
            this.updateAriaLabel();
        }
        
        toggle() {
            const isPassword = this.input.type === 'password';
            
            // Cambiar tipo de input
            this.input.type = isPassword ? 'text' : 'password';
            
            // Cambiar ícono
            this.icon.classList.toggle('fa-eye', !isPassword);
            this.icon.classList.toggle('fa-eye-slash', isPassword);
            
            // Actualizar atributos ARIA
            this.button.setAttribute('aria-pressed', isPassword.toString());
            this.updateAriaLabel();
            
            // Opcional: mantener el foco en el input después del toggle
            this.input.focus();
        }
        
        handleKeydown(event) {
            // Permitir activación con Space y Enter
            if (event.key === ' ' || event.key === 'Enter' || event.key === 'Spacebar') {
                event.preventDefault();
                this.toggle();
            }
        }
        
        updateAriaLabel() {
            const isVisible = this.input.type === 'text';
            this.button.setAttribute('aria-label', 
                isVisible ? 'Ocultar contraseña' : 'Mostrar contraseña'
            );
        }
    }
    
    // Inicializar cuando el DOM esté listo
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButtons = document.querySelectorAll('.password-toggle-btn');
        
        toggleButtons.forEach(button => {
            new PasswordToggle(button);
        });
        
        // También se puede activar con atributos data
        const passwordInputs = document.querySelectorAll('.password-toggle');
        passwordInputs.forEach(input => {
            const targetId = input.getAttribute('data-toggle-target');
            if (targetId) {
                // Lógica adicional si es necesaria
            }
        });
    });
    
    // Manejar errores de forma elegante
    if (typeof PasswordToggle === 'undefined') {
        console.warn('PasswordToggle class not loaded - falling back to basic functionality');
        
        document.addEventListener('DOMContentLoaded', function() {
            const fallbackButtons = document.querySelectorAll('.password-toggle-btn');
            
            fallbackButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const inputId = this.getAttribute('data-toggle-input');
                    const input = document.getElementById(inputId);
                    const icon = this.querySelector('i');
                    
                    if (input && icon) {
                        const isPassword = input.type === 'password';
                        input.type = isPassword ? 'text' : 'password';
                        
                        icon.classList.toggle('fa-eye', !isPassword);
                        icon.classList.toggle('fa-eye-slash', isPassword);
                    }
                });
            });
        });
    }
</script>

<style>
    /* Estilos específicos para el toggle de contraseña */
    .password-toggle-btn {
        background: none;
        border: none;
        cursor: pointer;
        outline: none;
        transition: all 0.2s ease-in-out;
    }
    
    .password-toggle-btn:focus {
        outline: 2px solid #3b82f6;
        outline-offset: 2px;
        border-radius: 4px;
    }
    
    .password-toggle-btn:hover i {
        transform: scale(1.1);
    }
    
    /* Asegurar que el ícono sea claramente visible */
    #passwordToggleIcon {
        font-size: 1.125rem;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endsection