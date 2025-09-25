@extends('layouts.app')

@section('title', 'Dashboard Superadmin')
@section('content')
<!-- Main Content -->
<main class="flex-1 p-4 md:p-6 container mx-auto max-w-7xl">
    <!-- Header responsivo -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl md:text-3xl font-bold text-blue-600">Panel Superadministrador</h2>
            <p class="mt-2 text-sm md:text-base text-gray-600">Bienvenido, {{ auth()->user()->nomUsu }} {{ auth()->user()->apeUsu }}</p>
        </div>
        <div class="text-gray-500 select-none font-medium text-sm md:text-base">
            {{ now()->translatedFormat('l, d F Y') }}
        </div>
    </div>

    <p class="mb-6 text-gray-600 text-sm md:text-base">Aquí puedes gestionar todos los aspectos del sistema.</p>

    <!-- Estadísticas Rápidas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 md:p-6">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-gray-500 text-xs md:text-sm font-medium">Usuarios Totales</p>
                    <p class="text-lg md:text-xl font-semibold text-gray-900">{{ $stats['total_usuarios'] }}</p>
                </div>
                <div class="bg-blue-100 p-2 md:p-3 rounded-full shadow-sm">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-3 md:mt-4">
                <a href="{{ route('superadmin.usuarios.index') }}" class="text-xs md:text-sm text-blue-600 font-semibold hover:underline">Ver todos</a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 md:p-6">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-gray-500 text-xs md:text-sm font-medium">Administradores</p>
                    <h3 class="text-lg md:text-xl font-bold text-gray-900">{{ $stats['total_administradores'] }}</h3>
                </div>
                <div class="bg-blue-100 p-2 md:p-3 rounded-full shadow-sm">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 6.253v13m0-13C10.477 5.273 7.5 4 4.382 4c-1.483 0-2.93.345-4.025.957a1 1 0 00-.357 1.357C.345 7.93 1 9.477 1 11s-.655 3.07-1 4.686a1 1 0 00.357 1.357C1.452 17.655 2.9 18 4.382 18c3.118 0 6.095-1.273 7.618-2.253m0 0c1.523.98 4.5 2.253 7.618 2.253 1.483 0 2.93-.345 4.025-.957a1 1 0 00.357-1.357C23.655 14.07 23 12.523 23 11s.655-3.07 1-4.686a1 1 0 00-.357-1.357C22.548 4.345 21.1 4 19.618 4c-3.118 0-6.095 1.273-7.618 2.253z" />
                    </svg>
                </div>
            </div>
            <div class="mt-3 md:mt-4">
                <a href="{{ route('superadmin.management.index') }}" class="text-xs md:text-sm text-blue-600 font-semibold hover:underline">Ver todos</a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 md:p-6">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-gray-500 text-xs md:text-sm font-medium">Pedidos Pendientes</p>
                    <p class="text-lg md:text-xl font-semibold text-gray-900">{{ $stats['pedidos_pendientes'] }}</p>
                </div>
                <div class="bg-blue-100 p-2 md:p-3 rounded-full shadow-sm">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-3 md:mt-4">
                <a href="{{ route('superadmin.pedidos.index') }}" class="text-xs md:text-sm text-blue-600 font-semibold hover:underline">Ver todos</a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 md:p-6">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-gray-500 text-xs md:text-sm font-medium">Facturación Total</p>
                    <p class="text-sm md:text-xl font-semibold text-gray-900 break-words">{{ number_format($stats['facturacion_total'], 0, ',', '.') }} COP</p>
                </div>
                <div class="bg-blue-100 p-2 md:p-3 rounded-full shadow-sm">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                </div>
            </div>
            <div class="mt-3 md:mt-4">
                <a href="{{ route('superadmin.facturacion.index') }}" class="text-xs md:text-sm text-blue-600 font-semibold hover:underline">Ver todos</a>
            </div>
        </div>
    </div>

    <!-- Sección de Accesos Rápidos -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-8">
        <a href="{{ route('superadmin.usuarios.index') }}" class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 md:p-6 text-center hover:shadow-md transition">
            <h3 class="font-semibold text-base md:text-lg text-gray-800 mb-2 md:mb-3">Usuarios</h3>
            <p class="text-gray-500 text-xs md:text-sm text-center leading-relaxed">Gestión de usuarios y clientes</p>
        </a>
        <a href="{{ route('superadmin.pedidos.index') }}" class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 md:p-6 text-center hover:shadow-md transition">
            <h3 class="font-semibold text-base md:text-lg text-gray-800 mb-2 md:mb-3">Pedidos</h3>
            <p class="text-gray-500 text-xs md:text-sm text-center leading-relaxed">Gestión de pedidos pendientes</p>
        </a>
        <a href="{{ route('superadmin.productos.index') }}" class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 md:p-6 text-center hover:shadow-md transition">
            <h3 class="font-semibold text-base md:text-lg text-gray-800 mb-2 md:mb-3">Productos</h3>
            <p class="text-gray-500 text-xs md:text-sm text-center leading-relaxed">Gestión del catálogo de productos</p>
        </a>
    </div>
</main>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const rawData = @json($activityData);

    // Preparar etiquetas para los últimos 7 días
    const last7Days = Array.from({length: 7}, (_, i) => {
        const date = new Date();
        date.setDate(date.getDate() - (6 - i));
        return date.toLocaleDateString('es-ES', { day: 'numeric', month: 'short' });
    });

    // Mapear datos faltantes como 0
    const completeData = last7Days.map(date => {
        const item = rawData.find(d => d.date === date);
        return item ? item.count : 0;
    });

    const ctx = document.getElementById('activityChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: last7Days,
            datasets: [{
                label: 'Actividad',
                data: completeData,
                backgroundColor: 'rgba(59, 130, 246, 0.7)', // Azul 500 con transparencia
                borderColor: 'rgba(59, 130, 246, 1)', // Azul 600
                borderWidth: 1,
                borderRadius: 4,
                barPercentage: 0.6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0,
                        stepSize: 1
                    },
                    min: 0
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: ctx => `${ctx.parsed.y} actividad${ctx.parsed.y !== 1 ? 'es' : ''}`
                    }
                }
            }
        }
    });
});
</script>
@endpush