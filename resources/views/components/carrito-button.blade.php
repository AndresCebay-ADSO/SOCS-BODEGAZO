@props(['producto', 'size' => 'sm', 'showText' => false, 'class' => '', 'cantidadInput' => null])

@php
    $sizeClasses = [
        'sm' => 'px-3 py-1 text-sm',
        'md' => 'px-4 py-2 text-base',
        'lg' => 'px-6 py-3 text-lg'
    ];
    
    $isDisabled = $producto->canPro <= 0;
    $buttonClass = $isDisabled 
        ? 'bg-gray-400 cursor-not-allowed text-gray-200' 
        : 'bg-primary-500 hover:bg-primary-600 text-white';
@endphp

<button class="agregar-carrito-btn {{ $buttonClass }} {{ $sizeClasses[$size] }} rounded transition {{ $class }}"
        data-producto-id="{{ $producto->idPro }}" 
        data-producto-nombre="{{ $producto->nomPro }}"
        data-producto-precio="{{ $producto->precio_venta }}"
        data-producto-stock="{{ $producto->canPro }}"
        @if($cantidadInput) data-cantidad-input="{{ $cantidadInput }}" @endif
        @if($isDisabled) disabled @endif>
    <i class="fas {{ $isDisabled ? 'fa-times' : 'fa-cart-plus' }} {{ $showText ? 'mr-2' : '' }}"></i>
    @if($showText)
        @if($isDisabled)
            Agotado
        @else
            Agregar al Carrito
        @endif
    @endif
</button>