@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
        <!-- Encabezado con degradado -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-5">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-white">Mi Perfil SuperAdmin</h2>
                <span class="bg-blue-500 text-xs font-semibold px-3 py-1 rounded-full text-white">
                    <i class="fas fa-user-crown mr-1"></i> Nivel SuperAdmin
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
                            
                            <!-- Datos del usuario con mejor jerarquía -->
                            <h3 class="text-xl font-bold text-gray-800 text-center">{{ $user->nomUsu }} {{ $user->apeUsu }}</h3>
                            <p class="text-blue-600 font-medium mt-1">{{ $user->emaUsu }}</p>
                            
                            <!-- Badge de estado -->
                            <div class="mt-2 bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full">
                                <i class="fas fa-circle text-xs mr-1"></i> Activo
                            </div>
                            
                            <!-- Detalles de contacto -->
                            <div class="mt-6 w-full space-y-3">
                                <div class="flex items-start">
                                    <div class="bg-blue-100 p-2 rounded-lg text-blue-700 mr-3">
                                        <i class="fas fa-phone-alt text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Teléfono</p>
                                        <p class="font-medium">{{ $user->telUsu ?? 'No especificado' }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <div class="bg-blue-100 p-2 rounded-lg text-blue-700 mr-3">
                                        <i class="fas fa-map-marker-alt text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Dirección</p>
                                        <p class="font-medium">{{ $user->dirUsu ?? 'No especificado' }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <div class="bg-blue-100 p-2 rounded-lg text-blue-700 mr-3">
                                        <i class="fas fa-calendar-alt text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Miembro desde</p>
                                        <p class="font-medium">{{ $user->created_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Acciones -->
                            <div class="mt-8 w-full space-y-3">
                                <a href="{{ route('superadmin.profile.edit') }}" 
                                   class="block w-full text-center px-4 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                    <i class="fas fa-user-edit mr-2"></i> Editar Perfil
                                </a>
                                <a href="{{ route('superadmin.profile.password.edit') }}" 
                                   class="block w-full text-center px-4 py-2.5 bg-white border border-blue-500 text-blue-600 rounded-lg hover:bg-blue-50 transition-all shadow-sm hover:shadow-md">
                                    <i class="fas fa-key mr-2"></i> Cambiar Contraseña
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Sección de actividad -->
                <div class="lg:w-2/3">
                    <!-- Tarjeta de estadísticas -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-chart-pie text-blue-600 mr-2"></i> Estadísticas del Sistema
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-blue-50 rounded-lg p-4 border border-blue-100">
                                <p class="text-xs font-semibold text-blue-800 uppercase">Usuarios Totales</p>
                                <p class="text-2xl font-bold text-blue-600 mt-1">{{ $totalUsers ?? '0' }}</p>
                            </div>
                            
                            <div class="bg-blue-50 rounded-lg p-4 border border-blue-100">
                                <p class="text-xs font-semibold text-blue-800 uppercase">Administradores</p>
                                <p class="text-2xl font-bold text-blue-600 mt-1">{{ $totalAdmins ?? '0' }}</p>
                            </div>
                            
                            <div class="bg-blue-50 rounded-lg p-4 border border-blue-100">
                                <p class="text-xs font-semibold text-blue-800 uppercase">Acciones Hoy</p>
                                <p class="text-2xl font-bold text-blue-600 mt-1">{{ $todayActions ?? '0' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tarjeta de actividad reciente -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-history text-blue-600 mr-2"></i> Actividad Reciente del Sistema
                        </h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-start border-b border-gray-100 pb-4">
                                <div class="bg-blue-100 p-2 rounded-full text-blue-600 mr-3 mt-1">
                                    <i class="fas fa-user-plus text-sm"></i>
                                </div>
                                <div>
                                    <p class="font-medium">Nuevo administrador registrado</p>
                                    <p class="text-sm text-gray-500">Hoy a las {{ now()->subHours(2)->format('H:i') }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start border-b border-gray-100 pb-4">
                                <div class="bg-blue-100 p-2 rounded-full text-blue-600 mr-3 mt-1">
                                    <i class="fas fa-shield-alt text-sm"></i>
                                </div>
                                <div>
                                    <p class="font-medium">Actualización de permisos</p>
                                    <p class="text-sm text-gray-500">Ayer a las 16:30</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="bg-blue-100 p-2 rounded-full text-blue-600 mr-3 mt-1">
                                    <i class="fas fa-database text-sm"></i>
                                </div>
                                <div>
                                    <p class="font-medium">Respaldo de base de datos</p>
                                    <p class="text-sm text-gray-500">Lunes, 03:00</p>
                                </div>
                            </div>
                        </div>
                        
                        <a href="#" class="inline-block mt-4 text-sm font-medium text-blue-600 hover:text-blue-800">
                            Ver registro completo <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection