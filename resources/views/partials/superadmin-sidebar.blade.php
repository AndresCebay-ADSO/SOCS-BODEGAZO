<aside class="fixed left-0 top-0 h-screen w-64 bg-white shadow-lg z-40 flex flex-col transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">
    <!-- Encabezado fijo con gradiente azul -->
    <div class="px-4 md:px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-700 sticky top-0 z-10">
        <div class="flex items-center justify-between">
            <h1 class="text-lg md:text-2xl font-bold text-white truncate">Panel SuperAdmin</h1>
            <!-- Botón de cerrar en móvil -->
            <button id="sidebar-close-mobile" class="md:hidden text-white hover:text-blue-200 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
    
    <!-- Menú de navegación desplazable -->
    <nav class="flex-1 px-2 py-4 space-y-1 overflow-y-auto">
        <!-- Perfil -->
        <a href="{{ route('superadmin.profile.show') }}" 
           class="flex items-center gap-2 md:gap-3 px-2 md:px-3 py-2 rounded-md transition text-xs md:text-sm font-medium 
                  {{ request()->routeIs('superadmin.profile.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
            <svg class="w-4 h-4 md:w-5 md:h-5 {{ request()->routeIs('superadmin.profile.*') ? 'text-blue-600' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span class="hidden sm:inline">Perfil</span>
        </a>

        <!-- Dashboard -->
        <a href="{{ route('superadmin.dashboard') }}" 
           class="flex items-center gap-2 md:gap-3 px-2 md:px-3 py-2 rounded-md transition text-xs md:text-sm font-medium 
                  {{ request()->routeIs('superadmin.dashboard') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
            <svg class="w-4 h-4 md:w-5 md:h-5 {{ request()->routeIs('superadmin.dashboard') ? 'text-blue-600' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M4 10v10a1 1 0 001 1h3m10-11v10a1 1 0 01-1 1h-3m-6 0h6" />
            </svg>
            <span class="hidden sm:inline">Inicio</span>
        </a>

        <!-- Gestión de Usuarios (clientes) -->
        <a href="{{ route('superadmin.usuarios.index') }}" 
           class="flex items-center gap-2 md:gap-3 px-2 md:px-3 py-2 rounded-md transition text-xs md:text-sm font-medium 
                  {{ request()->routeIs('superadmin.usuarios.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
            <svg class="w-4 h-4 md:w-5 md:h-5 {{ request()->routeIs('superadmin.usuarios.*') ? 'text-blue-600' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <span class="hidden sm:inline">Gestión de Usuarios</span>
        </a>

        <!-- Gestión de Administración (unificado: admins, roles, permisos) -->
        <a href="{{ route('superadmin.management.index') }}" 
           class="flex items-center gap-2 md:gap-3 px-2 md:px-3 py-2 rounded-md transition text-xs md:text-sm font-medium 
                  {{ request()->routeIs('superadmin.admin.management.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
            <svg class="w-4 h-4 md:w-5 md:h-5 {{ request()->routeIs('superadmin.admin.management.*') ? 'text-blue-600' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.477 5.273 7.5 4 4.382 4c-1.483 0-2.93.345-4.025.957a1 1 0 00-.357 1.357C.345 7.93 1 9.477 1 11s-.655 3.07-1 4.686a1 1 0 00.357 1.357C1.452 17.655 2.9 18 4.382 18c3.118 0 6.095-1.273 7.618-2.253m0 0c1.523.98 4.5 2.253 7.618 2.253 1.483 0 2.93-.345 4.025-.957a1 1 0 00.357-1.357C23.655 14.07 23 12.523 23 11s.655-3.07 1-4.686a1 1 0 00-.357-1.357C22.548 4.345 21.1 4 19.618 4c-3.118 0-6.095 1.273-7.618 2.253z" />
            </svg>
            <span class="hidden sm:inline">Gestión de Administración</span>
        </a>

        <!-- Productos -->
        <a href="{{ route('superadmin.productos.index') }}" 
           class="flex items-center gap-2 md:gap-3 px-2 md:px-3 py-2 rounded-md transition text-xs md:text-sm font-medium 
                  {{ request()->routeIs('superadmin.productos.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
            <svg class="w-4 h-4 md:w-5 md:h-5 {{ request()->routeIs('superadmin.productos.*') ? 'text-blue-600' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
            </svg>
            <span class="hidden sm:inline">Productos</span>
        </a>

        <!-- Pedidos -->
        <a href="{{ route('superadmin.pedidos.index') }}" 
           class="flex items-center gap-2 md:gap-3 px-2 md:px-3 py-2 rounded-md transition text-xs md:text-sm font-medium 
                  {{ request()->routeIs('superadmin.pedidos.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
            <svg class="w-4 h-4 md:w-5 md:h-5 {{ request()->routeIs('superadmin.pedidos.*') ? 'text-blue-600' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
            <span class="hidden sm:inline">Pedidos</span>
        </a>

        <!-- Inventarios -->
        <a href="{{ route('superadmin.inventarios.index') }}" 
           class="flex items-center gap-2 md:gap-3 px-2 md:px-3 py-2 rounded-md transition text-xs md:text-sm font-medium 
                  {{ request()->routeIs('superadmin.inventarios.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
            <svg class="w-4 h-4 md:w-5 md:h-5 {{ request()->routeIs('superadmin.inventarios.*') ? 'text-blue-600' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            <span class="hidden sm:inline">Inventarios</span>
        </a>

        <!-- Notificaciones -->
        <a href="{{ route('superadmin.notificaciones.index') }}" 
           class="flex items-center gap-2 md:gap-3 px-2 md:px-3 py-2 rounded-md transition text-xs md:text-sm font-medium 
                  {{ request()->routeIs('superadmin.notificaciones.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
            <svg class="w-4 h-4 md:w-5 md:h-5 {{ request()->routeIs('superadmin.notificaciones.*') ? 'text-blue-600' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1-1m-4 0V9m4 8H5m4-8v8m4-8V9m-4 0a4 4 0 00-8 0v8a4 4 0 008 0V9z" />
            </svg>
            <span class="hidden sm:inline">Notificaciones</span>
        </a>
    </nav>
    
    <!-- Botón de cierre de sesión fijo en la parte inferior -->
    <div class="px-4 md:px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-700 sticky bottom-0 z-10">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" 
                    class="w-full flex items-center gap-2 md:gap-3 px-2 md:px-3 py-2 rounded-md transition text-xs md:text-sm font-medium text-white hover:bg-blue-800">
                <svg class="w-4 h-4 md:w-5 md:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 11-6 0v-1m3-12V4a1 1 0 011-1h4a1 1 0 011 1v3" />
                </svg>
                <span class="hidden sm:inline">Cerrar sesión</span>
            </button>
        </form>
    </div>
</aside>

<!-- Mobile sidebar toggle - Color azul -->
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
    const closeButton = document.getElementById('sidebar-close-mobile');
    const menuIcon = document.getElementById('menu-icon');
    const closeIcon = document.getElementById('close-icon');
    const overlay = document.getElementById('sidebar-overlay');
    
    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        sidebar.classList.add('translate-x-0');
        menuIcon.classList.add('hidden');
        closeIcon.classList.remove('hidden');
        if(overlay) {
            overlay.classList.remove('hidden');
        }
    }
    
    function closeSidebar() {
        sidebar.classList.remove('translate-x-0');
        sidebar.classList.add('-translate-x-full');
        menuIcon.classList.remove('hidden');
        closeIcon.classList.add('hidden');
        if(overlay) {
            overlay.classList.add('hidden');
        }
    }
    
    if(toggleButton && sidebar) {
        toggleButton.addEventListener('click', function(e) {
            e.stopPropagation();
            if(sidebar.classList.contains('-translate-x-full')) {
                openSidebar();
            } else {
                closeSidebar();
            }
        });
    }
    
    if(closeButton && sidebar) {
        closeButton.addEventListener('click', function(e) {
            e.stopPropagation();
            closeSidebar();
        });
    }
    
    // Cerrar sidebar al hacer clic en el overlay
    if(overlay) {
        overlay.addEventListener('click', function() {
            closeSidebar();
        });
    }
    
    // Cerrar sidebar al hacer clic fuera
    document.addEventListener('click', function(e) {
        if(window.innerWidth < 768 && sidebar && !sidebar.contains(e.target) && e.target !== toggleButton) {
            closeSidebar();
        }
    });
    
    // Cerrar sidebar al cambiar tamaño de ventana
    window.addEventListener('resize', function() {
        if(window.innerWidth >= 768) {
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
            if(overlay) {
                overlay.classList.add('hidden');
            }
        } else {
            closeSidebar();
        }
    });
});
</script>