@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-xl font-bold">Detalle del Pedido #{{ $pedido->id }}</h1>
    <p><strong>Cliente:</strong> {{ $pedido->usuario->nomUsu }}</p>
    <p><strong>Producto:</strong> {{ $pedido->producto->nomPro }}</p>
    <p><strong>Fecha:</strong> {{ $pedido->fecPed }}</p>
    <p><strong>Estado:</strong> {{ $pedido->estPed }}</p>
    <p><strong>Total:</strong> ${{ number_format($pedido->prePed, 2) }}</p>
</div>
@endsection
