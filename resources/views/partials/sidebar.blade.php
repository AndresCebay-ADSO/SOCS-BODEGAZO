<aside class="w-64 bg-white shadow-md h-screen fixed left-0 top-0 overflow-y-auto z-20 transition-all duration-300 md:translate-x-0 sidebar-mobile-hidden">
    <!-- Logo -->
    <div class="px-6 py-8 border-b border-gray-200">
        <h1 class="text-2xl font-bold text-blue-600">El Bodegazo</h1>
    </div>
    
    <!-- Menú de navegación -->
    <nav class="flex-1 px-4 py-6 space-y-4 overflow-y-auto">
        <!-- Perfil -->
        <a href="{{ route('admin.profile.show') }}" 
           class="group flex items-center px-3 py-2 rounded-md text-sm font-medium transition 
                  {{ request()->routeIs('admin.profile.show') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
            <svg class="mr-3 h-6 w-6 text-gray-500 group-hover:text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            Mi Perfil
        </a>

        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" 
           class="flex items-center gap-3 px-3 py-2 rounded-md transition text-sm font-medium 
                  {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
            <svg class="w-6 h-6 text-gray-500 {{ request()->routeIs('admin.dashboard') ? 'text-blue-700' : '' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M4 10v10a1 1 0 001 1h3m10-11v10a1 1 0 01-1 1h-3m-6 0h6" />
            </svg>
            Inicio
        </a>

        <!-- Inventarios -->
        <a href="{{ route('admin.inventarios.index') }}" 
           class="flex items-center gap-3 px-3 py-2 rounded-md transition text-sm font-medium 
                  {{ request()->routeIs('admin.inventarios.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
            <svg class="w-6 h-6 text-gray-500 {{ request()->routeIs('admin.inventarios.*') ? 'text-blue-700' : '' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
            Gestión de Inventarios
        </a>

        <!-- Pedidos -->
        <a href="{{ route('admin.pedidos.index') }}" 
           class="flex items-center gap-3 px-3 py-2 rounded-md transition text-sm font-medium 
                  {{ request()->routeIs('admin.pedidos.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
            <svg class="w-6 h-6 text-gray-500 {{ request()->routeIs('admin.pedidos.*') ? 'text-blue-700' : '' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            Gestión de Pedidos
        </a>

        <!-- Notificaciones -->
        <a href="{{ route('admin.notificaciones.index') }}" 
           class="flex items-center gap-3 px-3 py-2 rounded-md transition text-sm font-medium 
                  {{ request()->routeIs('admin.notificaciones.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
            <svg class="w-6 h-6 text-gray-500 {{ request()->routeIs('admin.notificaciones.*') ? 'text-blue-700' : '' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            Gestión de Notificaciones
        </a>

        <!-- Productos -->
        <a href="{{ route('admin.productos.index') }}" 
           class="flex items-center gap-3 px-3 py-2 rounded-md transition text-sm font-medium 
                  {{ request()->routeIs('admin.productos.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
            <svg class="w-6 h-6 text-gray-500 {{ request()->routeIs('admin.productos.*') ? 'text-blue-700' : '' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7v6M8 7v6M12 10v4" />
            </svg>
            Gestión de Productos
        </a>
    </nav>

    <!-- Cerrar sesión -->
    <form method="POST" action="{{ route('logout') }}" class="px-6 py-4 border-t border-gray-200">
        @csrf
        <button type="submit" class="w-full text-left text-blue-600 font-semibold hover:text-blue-800 transition flex items-center gap-2">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 11-6 0v-1m3-12V4a1 1 0 011-1h4a1 1 0 011 1v3" />
            </svg>
            Cerrar sesión
        </button>
    </form>
</aside>

<!-- Mobile sidebar toggle -->
<div class="md:hidden fixed bottom-4 right-4 z-30">
    <button id="sidebar-toggle" class="p-3 bg-blue-600 text-white rounded-full shadow-lg transition transform hover:scale-110">
        <svg id="menu-icon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
        <svg id="close-icon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.querySelector('aside');
    const toggleButton = document.getElementById('sidebar-toggle');
    const menuIcon = document.getElementById('menu-icon');
    const closeIcon = document.getElementById('close-icon');
    
    if(toggleButton && sidebar) {
        toggleButton.addEventListener('click', function(e) {
            e.stopPropagation();
            sidebar.classList.toggle('sidebar-mobile-hidden');
            sidebar.classList.toggle('sidebar-mobile-visible');
            menuIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');
        });
    }
    
    // Cerrar sidebar al hacer clic fuera en móviles
    document.addEventListener('click', function(e) {
        if(window.innerWidth < 768 && sidebar && !sidebar.contains(e.target) && e.target !== toggleButton) {
            sidebar.classList.add('sidebar-mobile-hidden');
            sidebar.classList.remove('sidebar-mobile-visible');
            menuIcon.classList.remove('hidden');
            closeIcon.classList.add('hidden');
        }
    });
});
</script>