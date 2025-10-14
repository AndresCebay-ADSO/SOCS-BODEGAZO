@extends('layouts.app')

@section('title', 'Dashboard Superadmin')
@section('content')
<!-- Main Content -->
<main class="flex-1 p-4 md:p-6 container mx-auto max-w-7xl">
    <!-- Header responsivo -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl md:text-3xl font-bold text-blue-600">Panel Superadministrador</h2>
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
        <!-- Tarjeta de Notificaciones -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 md:p-6">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-gray-500 text-xs md:text-sm font-medium">Notificaciones Sin Leer</p>
                    <p class="text-lg md:text-xl font-semibold text-gray-900">{{ $stats['notificaciones_sin_leer'] }}</p>
                </div>
                <div class="bg-blue-100 p-2 md:p-3 rounded-full shadow-sm">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>
            </div>
            <div class="mt-3 md:mt-4">
                <a href="{{ route('superadmin.notificaciones.index') }}" class="text-xs md:text-sm text-blue-600 font-semibold hover:underline">Ver todas</a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Columna Izquierda: Gráfico de Pedidos -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <div class="flex justify-between items-center mb-4">
                <h3 id="salesChartTitle" class="text-xl font-semibold text-gray-800">Pedidos (Últimos 7 días)</h3>
                <div class="flex space-x-2">
                    <button id="weeklySalesBtn" class="px-3 py-1 bg-blue-600 text-white rounded-md text-sm cursor-pointer">Semanal</button>
                    <button id="monthlySalesBtn" class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm cursor-pointer">Mensual</button>
                </div>
            </div>
            <div class="relative" style="height: 350px;">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <!-- Columna Derecha: Gráfico de Estado de Inventario -->
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Estado del Inventario</h3>
            <div class="relative" style="height: 350px;">
                <canvas id="stockStatusChart"></canvas>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- INICIO: LÓGICA PARA GRÁFICOS DE VENTAS E INVENTARIO ---

    // Datos de ventas (semanales y mensuales)
    const rawSalesDataWeekly = @json($salesDataWeekly ?? []);
    const rawSalesDataMonthly = @json($salesDataMonthly ?? []);
    const stockStatusData = @json($stockStatusData ?? ['in_stock' => 0, 'low_stock' => 0, 'out_of_stock' => 0]);

    let salesChartInstance = null; // Para almacenar la instancia del gráfico de ventas

    // Función para generar etiquetas de fecha y datos completos
    function prepareSalesData(rawData, days) {
        const salesDataMap = new Map(rawData.map(item => [item.date, item.count]));
        const labels = [];
        const data = [];

        for (let i = days - 1; i >= 0; i--) {
            const date = new Date();
            date.setDate(date.getDate() - i);
            
            labels.push(date.toLocaleDateString('es-ES', { day: 'numeric', month: 'short' }));

            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            const dateKey = `${year}-${month}-${day}`;

            data.push(salesDataMap.get(dateKey) || 0);
        }
        return { labels, data };
    }

    // Función para renderizar o actualizar el gráfico de ventas
    function renderSalesChart(period = 'weekly') {
        const salesChartEl = document.getElementById('salesChart');
        const salesChartTitle = document.getElementById('salesChartTitle');
        const weeklySalesBtn = document.getElementById('weeklySalesBtn');
        const monthlySalesBtn = document.getElementById('monthlySalesBtn');

        if (!salesChartEl) return;

        let dataToUse, titleText, daysCount;

        if (period === 'monthly') {
            dataToUse = rawSalesDataMonthly;
            titleText = 'Pedidos (Últimos 30 días)';
            daysCount = 30;
            monthlySalesBtn.classList.replace('bg-gray-100', 'bg-blue-600');
            monthlySalesBtn.classList.replace('text-gray-600', 'text-white');
            weeklySalesBtn.classList.replace('bg-blue-600', 'bg-gray-100');
            weeklySalesBtn.classList.replace('text-white', 'text-gray-600');
        } else {
            dataToUse = rawSalesDataWeekly;
            titleText = 'Pedidos (Últimos 7 días)';
            daysCount = 7;
            weeklySalesBtn.classList.replace('bg-gray-100', 'bg-blue-600');
            weeklySalesBtn.classList.replace('text-gray-600', 'text-white');
            monthlySalesBtn.classList.replace('bg-blue-600', 'bg-gray-100');
            monthlySalesBtn.classList.replace('text-white', 'text-gray-600');
        }

        salesChartTitle.textContent = titleText;
        const { labels, data } = prepareSalesData(dataToUse, daysCount);

        if (salesChartInstance) salesChartInstance.destroy();

        const salesCtx = salesChartEl.getContext('2d');
        salesChartInstance = new Chart(salesCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pedidos',
                    data: data,
                    backgroundColor: 'rgba(59, 130, 246, 0.7)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 1,
                    borderRadius: 4,
                    barPercentage: 0.6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0, stepSize: 1 }, min: 0 },
                    x: { grid: { display: false } }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: { callbacks: { label: ctx => `${ctx.parsed.y} pedido${ctx.parsed.y !== 1 ? 's' : ''}` } }
                }
            }
        });
    }

    // Event Listeners para los botones de ventas
    document.getElementById('weeklySalesBtn').addEventListener('click', () => renderSalesChart('weekly'));
    document.getElementById('monthlySalesBtn').addEventListener('click', () => renderSalesChart('monthly'));

    // Renderizar el gráfico de ventas semanal por defecto
    renderSalesChart('weekly');

    // Gráfico de Estado de Inventario
    try {
        const stockChartEl = document.getElementById('stockStatusChart');
        if (stockChartEl && stockStatusData) {
            const stockCtx = stockChartEl.getContext('2d');
            new Chart(stockCtx, {
                type: 'doughnut',
                data: {
                    labels: ['En Stock', 'Stock Bajo', 'Sin Stock'],
                    datasets: [{
                        data: [
                            stockStatusData.in_stock || 0,
                            stockStatusData.low_stock || 0,
                            stockStatusData.out_of_stock || 0
                        ],
                        backgroundColor: ['rgba(75, 192, 192, 0.8)', 'rgba(255, 206, 86, 0.8)', 'rgba(255, 99, 132, 0.8)'],
                        borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 206, 86, 1)', 'rgba(255, 99, 132, 1)'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { boxWidth: 12, padding: 20 } },
                        tooltip: {
                            callbacks: {
                                label: (context) => `${context.label || ''}: ${(context.parsed || 0)} productos`
                            }
                        }
                    }
                }
            });
        }
    } catch (e) {
        console.error('Error al renderizar el gráfico de inventario:', e);
    }

    // --- FIN: LÓGICA PARA GRÁFICOS DE VENTAS E INVENTARIO ---
});
</script>
@endpush