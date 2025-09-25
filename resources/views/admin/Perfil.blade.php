@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-warning text-dark">Perfil de Administrador</div>
            <div class="card-body">
                <p><strong>Nombre:</strong> {{ auth()->user()->nomUsu }}</p>
                <p><strong>Apellido:</strong> {{ auth()->user()->apeUsu }}</p>
                <p><strong>Email:</strong> {{ auth()->user()->emaUsu }}</p>
                <p><strong>Rol:</strong> {{ auth()->user()->rol->tipRol }}</p>
                <!-- Puedes agregar más campos aquí -->
            </div>
        </div>
    </div>
</div>
@endsection 