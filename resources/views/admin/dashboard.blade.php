@extends('layouts.app')

@section('content')
<!-- Main Content -->
<main class="flex-1 p-6 container mx-auto max-w-7xl">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-blue-600">Panel de Control</h2>
        <div class="text-gray-500 select-none font-medium">
            {{ now()->translatedFormat('l, d F Y') }}
        </div>
    </div>

    <!-- Estadísticas Rápidas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        {{-- Las 4 tarjetas de estadísticas van aquí como estaban --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Productos Totales</p>
                    <p class="text-xl font-semibold text-gray-900">{{ $stats['total_productos'] }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full shadow-sm">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm font-medium {{ $stats['productos_bajo_stock'] > 0 ? 'text-red-600' : 'text-green-600' }}">
                    {{ $stats['productos_bajo_stock'] }} con stock bajo
                </span>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Pedidos Pendientes</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $stats['pedidos_pendientes'] }}</h3>
                </div>
                <div class="bg-orange-100 p-3 rounded-full shadow-sm">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.pedidos.index') }}" class="text-sm text-blue-600 font-semibold hover:underline">Ver todos</a>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Notificaciones</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $stats['notificaciones_sin_leer'] }}</h3>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full shadow-sm">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.notificaciones.index') }}" class="text-sm text-blue-600 font-semibold hover:underline">Ver todas</a>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Inventario Total</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $stats['inventario_total'] }}</h3>
                </div>
                <div class="bg-green-100 p-3 rounded-full shadow-sm">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/></svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.inventarios.index') }}" class="text-sm text-blue-600 font-semibold hover:underline">Gestionar</a>
            </div>
        </div>
    </div>

    <!-- Contenedor de Gráficos Principales -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        
        <!-- Columna Izquierda: Gráfico de Pedidos -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow-sm p-6" style="position: relative; height: 400px;">
            <div class="flex justify-between items-center mb-4">
                <h3 id="salesChartTitle" class="text-xl font-semibold text-gray-800">Pedidos Recientes (Últimos 7 días)</h3>
                <div class="flex space-x-2">
                    <button id="weeklySalesBtn" class="px-3 py-1 bg-blue-600 text-white rounded-md text-sm cursor-pointer">Semanal</button>
                    <button id="monthlySalesBtn" class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm cursor-pointer">Mensual</button>
                </div>
            </div>
            <canvas id="salesChart"></canvas>
        </div>

        <!-- Columna Derecha: Gráfico de Estado de Inventario -->
        <div class="bg-white rounded-lg shadow-sm p-6" style="position: relative; height: 400px;">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Estado del Inventario</h3>
            <canvas id="stockStatusChart"></canvas>
        </div>
    </div>

    <!-- Accesos Rápidos -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <a href="{{ route('admin.inventarios.index') }}" 
           class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition duration-300 flex flex-col items-center">
            <div class="bg-blue-100 p-4 rounded-full mb-4 shadow-sm">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <h3 class="font-semibold text-lg text-gray-800 mb-3">Inventario</h3>
            <p class="text-gray-500 text-sm text-center leading-relaxed">Gestión de existencias y stock</p>
        </a>

        <a href="{{ route('admin.pedidos.index') }}" 
           class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition duration-300 flex flex-col items-center">
            <div class="bg-orange-100 p-4 rounded-full mb-4 shadow-sm">
                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <h3 class="font-semibold text-lg text-gray-800 mb-3">Pedidos</h3>
            <p class="text-gray-500 text-sm text-center leading-relaxed">Solicitudes y órdenes de compra</p>
        </a>

        <a href="{{ route('admin.productos.index') }}" 
           class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition duration-300 flex flex-col items-center">
            <div class="bg-purple-100 p-4 rounded-full mb-4 shadow-sm">
                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3 class="font-semibold text-lg text-gray-800 mb-3">Productos</h3>
            <p class="text-gray-500 text-sm text-center leading-relaxed">Catálogo y gestión de productos</p>
        </a>

        <a href="{{ route('admin.notificaciones.index') }}" 
           class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition duration-300 flex flex-col items-center">
            <div class="bg-yellow-100 p-4 rounded-full mb-4 shadow-sm">
                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            </div>
            <h3 class="font-semibold text-lg text-gray-800 mb-3">Notificaciones</h3>
            <p class="text-gray-500 text-sm text-center leading-relaxed">Alertas y mensajes del sistema</p>
        </a>
    </div>
</main>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
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

        if (!salesChartEl) {
            console.error('No se encontró el elemento canvas para el gráfico de ventas.');
            return;
        }

        let dataToUse;
        let titleText;
        let daysCount;

        if (period === 'monthly') {
            dataToUse = rawSalesDataMonthly;
            titleText = 'Pedidos Recientes (Últimos 30 días)';
            daysCount = 30;
            monthlySalesBtn.classList.remove('bg-gray-100', 'text-gray-600');
            monthlySalesBtn.classList.add('bg-blue-600', 'text-white');
            weeklySalesBtn.classList.remove('bg-blue-600', 'text-white');
            weeklySalesBtn.classList.add('bg-gray-100', 'text-gray-600');
        } else { // Default to weekly
            dataToUse = rawSalesDataWeekly;
            titleText = 'Pedidos Recientes (Últimos 7 días)';
            daysCount = 7;
            weeklySalesBtn.classList.remove('bg-gray-100', 'text-gray-600');
            weeklySalesBtn.classList.add('bg-blue-600', 'text-white');
            monthlySalesBtn.classList.remove('bg-blue-600', 'text-white');
            monthlySalesBtn.classList.add('bg-gray-100', 'text-gray-600');
        }

        salesChartTitle.textContent = titleText;
        const { labels, data } = prepareSalesData(dataToUse, daysCount);

        if (salesChartInstance) {
            salesChartInstance.destroy(); // Destruir la instancia anterior del gráfico
        }

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

    // Event Listeners para los botones
    document.getElementById('weeklySalesBtn').addEventListener('click', () => renderSalesChart('weekly'));
    document.getElementById('monthlySalesBtn').addEventListener('click', () => renderSalesChart('monthly'));

    // Renderizar el gráfico de ventas semanal por defecto al cargar la página
    renderSalesChart('weekly');

    // --- Gráfico de Estado de Inventario (Sin cambios) ---
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
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.8)',
                            'rgba(255, 206, 86, 0.8)',
                            'rgba(255, 99, 132, 0.8)'
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(255, 99, 132, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'right', labels: { boxWidth: 12, padding: 20 } },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) { label += ': '; }
                                    if (context.parsed !== null) { label += (context.parsed || 0) + ' productos'; }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        } else {
            console.error('No se pudo renderizar el gráfico de inventario. Faltan datos o el elemento canvas.');
        }
    } catch (e) {
        console.error('Error al renderizar el gráfico de inventario:', e);
    }
});
</script>
@endpush