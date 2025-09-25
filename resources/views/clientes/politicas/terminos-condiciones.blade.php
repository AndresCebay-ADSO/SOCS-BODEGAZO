@extends('layouts.app')

@section('title', 'Términos y Condiciones - El Bodegazo')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-lg p-6 md:p-10">
        
        <!-- Encabezado -->
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Términos y Condiciones & Política de Privacidad</h1>
        <p class="text-gray-600 text-center mb-8">Consulta fácilmente nuestras políticas y condiciones. Haz clic en cada sección para desplegar más información.</p>
        
        <!-- Índice -->
        <div class="mb-8 bg-gray-50 p-4 rounded-lg shadow-sm">
            <h2 class="text-xl font-semibold text-gray-700 mb-3">📑 Índice</h2>
            <div class="grid md:grid-cols-2 gap-4 text-gray-600">
                <ul class="list-disc pl-5 space-y-1">
                    <li><a href="#introduccion" class="hover:text-purple-600">1. Introducción</a></li>
                    <li><a href="#tienda" class="hover:text-purple-600">2. Información de la Tienda</a></li>
                    <li><a href="#pagos" class="hover:text-purple-600">3. Precios y Pagos</a></li>
                    <li><a href="#envios" class="hover:text-purple-600">4. Envío y Entrega</a></li>
                    <li><a href="#devoluciones" class="hover:text-purple-600">5. Devoluciones y Garantías</a></li>
                    <li><a href="#propiedad" class="hover:text-purple-600">6. Propiedad Intelectual</a></li>
                </ul>
                <ul class="list-disc pl-5 space-y-1">
                    <li><a href="#privacidad" class="hover:text-purple-600">7. Privacidad</a></li>
                    <li><a href="#responsabilidad" class="hover:text-purple-600">8. Limitación de Responsabilidad</a></li>
                    <li><a href="#ley" class="hover:text-purple-600">9. Ley Aplicable</a></li>
                    <li><a href="#politica" class="hover:text-purple-600">📌 Política de Privacidad</a></li>
                </ul>
            </div>
        </div>

        <!-- Secciones en acordeón -->
        <div x-data="{ open: null }" class="space-y-4">
            
            <!-- Introducción -->
            <div id="introduccion" class="border rounded-lg">
                <button @click="open === 1 ? open = null : open = 1" 
                        class="w-full flex justify-between items-center px-4 py-3 text-left text-lg font-semibold text-gray-700 hover:bg-purple-50">
                    1. Introducción
                    <span x-show="open !== 1">➕</span>
                    <span x-show="open === 1">➖</span>
                </button>
                <div x-show="open === 1" class="px-4 pb-4 text-gray-600 space-y-2">
                    <p>Bienvenido a El Bodegazo, una tienda virtual dedicada a la venta de calzado y accesorios relacionados.</p>
                    <p>Al acceder a nuestro sitio web y realizar una compra, aceptas expresamente las presentes condiciones y políticas.</p>
                    <p>El Bodegazo se reserva el derecho de actualizar o modificar estos términos en cualquier momento sin previo aviso.</p>
                </div>
            </div>

            <!-- Información de la Tienda -->
            <div id="tienda" class="border rounded-lg">
                <button @click="open === 2 ? open = null : open = 2" 
                        class="w-full flex justify-between items-center px-4 py-3 text-left text-lg font-semibold text-gray-700 hover:bg-purple-50">
                    2. Información de la Tienda
                    <span x-show="open !== 2">➕</span>
                    <span x-show="open === 2">➖</span>
                </button>
                <div x-show="open === 2" class="px-4 pb-4 text-gray-600 space-y-2">
                    <p><strong>Nombre:</strong> Comercializadora El Bodegazo</p>
                    <p><strong>Dirección:</strong> Pasaje comercial, La Plata, Colombia.</p>
                    <p><strong>Correo electrónico de contacto:</strong> soporte@elbodegazo.com.co</p>
                </div>
            </div>

            <!-- Precios y Pagos -->
            <div id="pagos" class="border rounded-lg">
                <button @click="open === 3 ? open = null : open = 3" 
                        class="w-full flex justify-between items-center px-4 py-3 text-left text-lg font-semibold text-gray-700 hover:bg-purple-50">
                    3. Precios y Pagos
                    <span x-show="open !== 3">➕</span>
                    <span x-show="open === 3">➖</span>
                </button>
                <div x-show="open === 3" class="px-4 pb-4 text-gray-600 space-y-2">
                    <p>Todos los precios están expresados en pesos colombianos (COP) e incluyen impuestos aplicables.</p>
                    <p>Aceptamos los siguientes métodos de pago:</p>
                    <ul class="list-disc pl-6">
                        <li>Tarjetas de crédito y débito</li>
                        <li>Transferencias bancarias</li>
                        <li>Pagos electrónicos a través de PayU</li>
                    </ul>
                    <p>El pago debe realizarse en su totalidad antes del envío del producto.</p>
                </div>
            </div>

            <!-- Envío y Entrega -->
            <div id="envios" class="border rounded-lg">
                <button @click="open === 4 ? open = null : open = 4" 
                        class="w-full flex justify-between items-center px-4 py-3 text-left text-lg font-semibold text-gray-700 hover:bg-purple-50">
                    4. Envío y Entrega
                    <span x-show="open !== 4">➕</span>
                    <span x-show="open === 4">➖</span>
                </button>
                <div x-show="open === 4" class="px-4 pb-4 text-gray-600 space-y-2">
                    <p>Los productos serán enviados a la dirección indicada por el cliente al momento de la compra.</p>
                    <p>Los tiempos de entrega varían según la ubicación, generalmente entre 3 y 7 días hábiles.</p>
                    <p>El Bodegazo no se hace responsable por retrasos ocasionados por terceros (transportadoras).</p>
                </div>
            </div>

            <!-- Devoluciones y Garantías -->
            <div id="devoluciones" class="border rounded-lg">
                <button @click="open === 5 ? open = null : open = 5" 
                        class="w-full flex justify-between items-center px-4 py-3 text-left text-lg font-semibold text-gray-700 hover:bg-purple-50">
                    5. Devoluciones y Garantías
                    <span x-show="open !== 5">➕</span>
                    <span x-show="open === 5">➖</span>
                </button>
                <div x-show="open === 5" class="px-4 pb-4 text-gray-600 space-y-2">
                    <p>Los clientes tienen derecho a realizar devoluciones dentro de los 5 días hábiles posteriores a la recepción del producto.</p>
                    <p>Los productos deben devolverse en su empaque original y en perfecto estado.</p>
                    <p>El Bodegazo cubrirá los gastos de devolución únicamente en caso de productos defectuosos o envíos erróneos.</p>
                </div>
            </div>

            <!-- Propiedad Intelectual -->
            <div id="propiedad" class="border rounded-lg">
                <button @click="open === 6 ? open = null : open = 6" 
                        class="w-full flex justify-between items-center px-4 py-3 text-left text-lg font-semibold text-gray-700 hover:bg-purple-50">
                    6. Propiedad Intelectual
                    <span x-show="open !== 6">➕</span>
                    <span x-show="open === 6">➖</span>
                </button>
                <div x-show="open === 6" class="px-4 pb-4 text-gray-600 space-y-2">
                    <p>Todos los contenidos del sitio web, incluyendo imágenes, logotipos, textos y diseño, son propiedad exclusiva de El Bodegazo.</p>
                    <p>Está prohibida su reproducción o uso sin autorización expresa por escrito.</p>
                </div>
            </div>

            <!-- Privacidad -->
            <div id="privacidad" class="border rounded-lg">
                <button @click="open === 7 ? open = null : open = 7" 
                        class="w-full flex justify-between items-center px-4 py-3 text-left text-lg font-semibold text-gray-700 hover:bg-purple-50">
                    7. Privacidad
                    <span x-show="open !== 7">➕</span>
                    <span x-show="open === 7">➖</span>
                </button>
                <div x-show="open === 7" class="px-4 pb-4 text-gray-600 space-y-2">
                    <p>El Bodegazo respeta la privacidad de los datos de sus usuarios.</p>
                    <p>La información recolectada se utilizará únicamente para procesar pedidos, mejorar la experiencia del usuario y, en caso de autorización, enviar promociones.</p>
                    <p>No compartimos ni vendemos información personal a terceros.</p>
                </div>
            </div>

            <!-- Limitación de Responsabilidad -->
            <div id="responsabilidad" class="border rounded-lg">
                <button @click="open === 8 ? open = null : open = 8" 
                        class="w-full flex justify-between items-center px-4 py-3 text-left text-lg font-semibold text-gray-700 hover:bg-purple-50">
                    8. Limitación de Responsabilidad
                    <span x-show="open !== 8">➕</span>
                    <span x-show="open === 8">➖</span>
                </button>
                <div x-show="open === 8" class="px-4 pb-4 text-gray-600 space-y-2">
                    <p>El Bodegazo no será responsable por:</p>
                    <ul class="list-disc pl-6">
                        <li>Retrasos ocasionados por transportadoras.</li>
                        <li>Uso indebido de los productos por parte del cliente.</li>
                        <li>Fallas técnicas temporales en el sitio web.</li>
                    </ul>
                </div>
            </div>

            <!-- Ley Aplicable -->
            <div id="ley" class="border rounded-lg">
                <button @click="open === 9 ? open = null : open = 9" 
                        class="w-full flex justify-between items-center px-4 py-3 text-left text-lg font-semibold text-gray-700 hover:bg-purple-50">
                    9. Ley Aplicable
                    <span x-show="open !== 9">➕</span>
                    <span x-show="open === 9">➖</span>
                </button>
                <div x-show="open === 9" class="px-4 pb-4 text-gray-600 space-y-2">
                    <p>Estos términos se rigen bajo las leyes de la República de Colombia.</p>
                    <p>Cualquier controversia será resuelta por los tribunales competentes en La Plata, Colombia.</p>
                </div>
            </div>

            <!-- Política de Privacidad -->
            <div id="politica" class="border rounded-lg">
                <button @click="open === 10 ? open = null : open = 10" 
                        class="w-full flex justify-between items-center px-4 py-3 text-left text-lg font-semibold text-gray-700 hover:bg-purple-50">
                    📌 Política de Privacidad
                    <span x-show="open !== 10">➕</span>
                    <span x-show="open === 10">➖</span>
                </button>
                <div x-show="open === 10" class="px-4 pb-4 text-gray-600 space-y-2">
                    <p><strong>Responsable:</strong> El Bodegazo, Pasaje comercial, La Plata, Colombia.</p>
                    <p><strong>Correo de contacto:</strong> soporte@elbodegazo.com.co</p>
                    <p><strong>Delegado de Protección de Datos:</strong> protecciondedatos@elbodegazo.com.co</p>
                    
                    <h4 class="font-semibold text-gray-700 mt-4">Finalidades del tratamiento</h4>
                    <ul class="list-disc pl-6">
                        <li>Gestión de cuentas de usuario y pedidos.</li>
                        <li>Prevención de fraudes y seguridad en transacciones.</li>
                        <li>Envío de promociones con consentimiento previo.</li>
                        <li>Cumplimiento de obligaciones legales y tributarias.</li>
                    </ul>

                    <h4 class="font-semibold text-gray-700 mt-4">Derechos del usuario</h4>
                    <ul class="list-disc pl-6">
                        <li>Acceder, rectificar, cancelar u oponerse al tratamiento de sus datos (Derechos ARCO).</li>
                        <li>Revocar en cualquier momento el consentimiento otorgado.</li>
                        <li>Presentar quejas ante la Superintendencia de Industria y Comercio (SIC).</li>
                    </ul>

                    <p class="mt-4"><em>Última actualización: 08 de agosto de 2025</em></p>
                </div>
            </div>
        </div>

        <!-- Fecha -->
        <div class="mt-10 text-gray-500 text-sm text-center">
            Fecha de última actualización: agosto de 2025
        </div>
    </div>
</div>

<!-- Script Alpine.js -->
<script src="//unpkg.com/alpinejs" defer></script>
@endsection
