<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'El Bodegazo - Acceso')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            400: '#3B82F6',
                            500: '#2563EB',
                            600: '#1D4ED8',
                        },
                        secondary: {
                            100: '#F3F4F6',
                            200: '#E5E7EB',
                            800: '#1F2937',
                        }
                    }
                }
            }
        }
    </script>
    @stack('styles')
</head>
<body class="bg-secondary-100 text-gray-800">
    @yield('content')
    @stack('scripts')

    @php
        $flashSuccess = session('success') ?? session('status');
    @endphp
    @if ($flashSuccess)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var mensaje = @json($flashSuccess);
            if (window.mostrarNotificacion) {
                window.mostrarNotificacion(mensaje, 'success');
            } else {
                var notificacion = document.createElement('div');
                notificacion.className = 'fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 transition-all duration-300 bg-green-500 text-white';
                notificacion.innerHTML = '<div class="flex items-center"><i class="fas fa-check-circle mr-2"></i><span>' + mensaje + '</span></div>';
                document.body.appendChild(notificacion);
                setTimeout(function() {
                    notificacion.style.opacity = '0';
                    setTimeout(function() {
                        if (document.body.contains(notificacion)) {
                            document.body.removeChild(notificacion);
                        }
                    }, 300);
                }, 3000);
            }
        });
    </script>
    @endif
</body>
</html>
