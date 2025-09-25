@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
        <!-- Encabezado con degradado -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-5">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-white">
                    <i class="fas fa-user-edit mr-2"></i> Editar Perfil
                </h2>
                <span class="bg-blue-500 text-xs font-semibold px-3 py-1 rounded-full text-white">
                    <i class="fas fa-user-shield mr-1"></i> Administrador
                </span>
            </div>
        </div>
        
        <!-- Contenido principal -->
        <div class="p-6">
            <form action="{{ route('admin.profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Mensajes de estado -->
                @if($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-500"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Hay errores en el formulario</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                
                @if(session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Campo Nombre -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="fas fa-user text-blue-500 mr-1"></i> Nombre
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="text" name="nomUsu" value="{{ old('nomUsu', $user->nomUsu) }}" 
                                   class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Ingresa tu nombre">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Campo Apellido -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="fas fa-user-tag text-blue-500 mr-1"></i> Apellido
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="text" name="apeUsu" value="{{ old('apeUsu', $user->apeUsu) }}" 
                                   class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Ingresa tu apellido">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user-tag text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Campo Email -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="fas fa-envelope text-blue-500 mr-1"></i> Email
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="email" name="emaUsu" value="{{ old('emaUsu', $user->emaUsu) }}" 
                                   class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Ingresa tu email">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Campo Teléfono -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="fas fa-phone text-blue-500 mr-1"></i> Teléfono
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="text" name="telUsu" value="{{ old('telUsu', $user->telUsu) }}" 
                                   class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   maxlength="10" placeholder="Ingresa tu teléfono">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-phone text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Campo Dirección -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="fas fa-map-marker-alt text-blue-500 mr-1"></i> Dirección
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="text" name="dirUsu" value="{{ old('dirUsu', $user->dirUsu) }}" 
                                   class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Ingresa tu dirección">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-map-marker-alt text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Botones de acción -->
                <div class="mt-8 flex justify-between pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.profile.show') }}" 
                       class="px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200">
                        <i class="fas fa-arrow-left mr-2"></i> Volver al perfil
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
@endsection