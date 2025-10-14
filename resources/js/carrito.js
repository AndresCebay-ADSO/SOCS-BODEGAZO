// Funcionalidad global del carrito de compras
document.addEventListener('DOMContentLoaded', function() {
    // Funcionalidad del carrito
    const agregarCarritoBtns = document.querySelectorAll('.agregar-carrito-btn');
    
    agregarCarritoBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Verificar si el usuario está autenticado
            if (window.usuarioAutenticado) {
                agregarAlCarrito(this);
            } else {
                // Si no está autenticado, redirigir al login
                window.location.href = window.rutaLogin;
            }
        });
    });

    // Función para agregar al carrito
    function agregarAlCarrito(btn) {
        const productoId = btn.getAttribute('data-producto-id');
        const productoNombre = btn.getAttribute('data-producto-nombre');
        const productoPrecio = btn.getAttribute('data-producto-precio');
        const productoStock = parseInt(btn.getAttribute('data-producto-stock'));
        
        // Mostrar loading
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Agregando...';
        btn.disabled = true;
        
        // Crear formulario para enviar datos
        const formData = new FormData();
        formData.append('producto_id', productoId);
        formData.append('cantidad', 1);
        formData.append('_token', '{{ csrf_token() }}');
        
        // Enviar petición
        fetch('{{ route("clientes.carrito.agregar") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mostrar mensaje de éxito
                mostrarNotificacion('Producto agregado al carrito', 'success');
                
                // Actualizar contador del carrito directamente con la cantidad devuelta
                const carritoCounters = document.querySelectorAll('.carrito-counter');
                carritoCounters.forEach(counter => {
                    counter.textContent = data.cantidad;
                    if (data.cantidad > 0) {
                        counter.classList.remove('hidden');
                    } else {
                        counter.classList.add('hidden');
                    }
                });
                
                // Actualizar botón si el stock se agotó
                if (productoStock === 1) {
                    btn.innerHTML = '<i class="fas fa-times mr-1"></i>Agotado';
                    btn.classList.remove('bg-green-500', 'hover:bg-green-600');
                    btn.classList.add('bg-gray-400', 'cursor-not-allowed');
                }
            } else {
                mostrarNotificacion(data.message || 'Error al agregar el producto', 'error');
                // Restaurar botón
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('Error de conexión', 'error');
            // Restaurar botón
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
    }

    // Función para mostrar notificaciones
    function mostrarNotificacion(mensaje, tipo) {
        const notificacion = document.createElement('div');
        notificacion.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 transition-all duration-300 ${
            tipo === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
        }`;
        notificacion.innerHTML = `
            <div class="flex items-center">
                <i class="fas ${tipo === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} mr-2"></i>
                <span>${mensaje}</span>
            </div>
        `;
        
        document.body.appendChild(notificacion);
        
        // Remover después de 3 segundos
        setTimeout(() => {
            notificacion.style.opacity = '0';
            setTimeout(() => {
                if (document.body.contains(notificacion)) {
                    document.body.removeChild(notificacion);
                }
            }, 300);
        }, 3000);
    }

    // Ya no necesitamos esta función, la eliminamos.

    // Hacer funciones globales para uso en otras vistas
    window.agregarAlCarrito = agregarAlCarrito;
    window.mostrarNotificacion = mostrarNotificacion;
});