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
</body>
</html>
