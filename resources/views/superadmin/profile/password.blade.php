@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
        <!-- Encabezado con degradado -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-5">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-white">Cambiar Contraseña SuperAdmin</h2>
                <span class="bg-blue-500 text-xs font-semibold px-3 py-1 rounded-full text-white">
                    <i class="fas fa-shield-alt mr-1"></i> Seguridad
                </span>
            </div>
        </div>
        
        <!-- Contenido principal -->
        <div class="p-6">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Tarjeta de información del usuario -->
                <div class="lg:w-1/3">
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 shadow-sm">
                        <div class="flex flex-col items-center">
                            <!-- Avatar con efecto hover -->
                            <div class="w-28 h-28 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center mb-4 shadow-inner hover:shadow-md transition duration-300">
                                <span class="text-4xl font-bold text-blue-700">
                                    {{ substr($user->nomUsu, 0, 1) }}{{ substr($user->apeUsu, 0, 1) }}
                                </span>
                            </div>
                            
                            <!-- Datos del usuario -->
                            <h3 class="text-xl font-bold text-gray-800 text-center">{{ $user->nomUsu }} {{ $user->apeUsu }}</h3>
                            <p class="text-blue-600 font-medium mt-1">{{ $user->emaUsu }}</p>
                            
                            <!-- Badge de estado -->
                            <div class="mt-2 bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full">
                                <i class="fas fa-circle text-xs mr-1"></i> Activo
                            </div>
                            
                            <!-- Acciones -->
                            <div class="mt-8 w-full space-y-3">
                                <a href="{{ route('superadmin.profile.edit') }}" 
                                   class="block w-full text-center px-4 py-2.5 bg-white border border-blue-500 text-blue-600 rounded-lg hover:bg-blue-50 transition-all shadow-sm hover:shadow-md">
                                    <i class="fas fa-user-edit mr-2"></i> Editar Perfil
                                </a>
                                <a href="{{ route('superadmin.profile.show') }}" 
                                   class="block w-full text-center px-4 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all shadow-sm hover:shadow-md">
                                    <i class="fas fa-user mr-2"></i> Ver Perfil
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Formulario de cambio de contraseña -->
                <div class="lg:w-2/3">
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                        <form action="{{ route('superadmin.profile.password.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <!-- Mensajes de estado -->
                            @if ($errors->any())
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                                    <strong class="font-bold"><i class="fas fa-exclamation-circle mr-2"></i>Ups!</strong>
                                    <span class="block sm:inline">Por favor corrige los siguientes errores:</span>
                                    <ul class="mt-2 ml-4 list-disc text-sm text-red-600">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            
                            @if(session('success'))
                                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-check-circle text-green-500"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Campo Contraseña Actual -->
                            <div class="mb-6">
                                <label class="block text-gray-700 text-sm font-medium mb-2">
                                    <i class="fas fa-lock text-blue-500 mr-2"></i> Contraseña Actual
                                </label>
                                <div class="relative">
                                    <input type="password" name="current_password" required
                                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200"
                                           placeholder="Ingresa tu contraseña actual">
                                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 toggle-password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Campo Nueva Contraseña -->
                            <div class="mb-6">
                                <label class="block text-gray-700 text-sm font-medium mb-2">
                                    <i class="fas fa-key text-blue-500 mr-2"></i> Nueva Contraseña
                                </label>
                                <div class="relative">
                                    <input type="password" name="password" required
                                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200"
                                           placeholder="Ingresa tu nueva contraseña">
                                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 toggle-password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <p class="mt-2 text-xs text-gray-500">
                                    <i class="fas fa-info-circle text-blue-500 mr-1"></i> La contraseña debe tener al menos 12 caracteres, incluyendo mayúsculas, minúsculas, números y caracteres especiales.
                                </p>
                            </div>
                            
                            <!-- Campo Confirmar Contraseña -->
                            <div class="mb-8">
                                <label class="block text-gray-700 text-sm font-medium mb-2">
                                    <i class="fas fa-check-circle text-blue-500 mr-2"></i> Confirmar Nueva Contraseña
                                </label>
                                <div class="relative">
                                    <input type="password" name="password_confirmation" required
                                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200"
                                           placeholder="Confirma tu nueva contraseña">
                                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 toggle-password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Botones de acción -->
                            <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200">
                                <a href="{{ route('superadmin.profile.show') }}" 
                                   class="px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200">
                                    <i class="fas fa-times mr-2"></i> Cancelar
                                </a>
                                <button type="submit" 
                                        class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 shadow-md">
                                    <i class="fas fa-save mr-2"></i> Guardar Cambios
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Toggle para mostrar/ocultar contraseña
document.querySelectorAll('.toggle-password').forEach(button => {
    button.addEventListener('click', function() {
        const input = this.parentElement.querySelector('input');
        const icon = this.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
});
</script>
@endsection