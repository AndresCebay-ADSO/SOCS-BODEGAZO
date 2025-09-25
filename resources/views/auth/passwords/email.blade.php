@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-secondary-100">
    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8 border border-gray-200">
        <a href="{{ url('login') }}">
            <i class="fas fa-arrow-left text-primary-600 hover:text-primary-700"></i>
        </a>
        <div class="text-center mb-6 relative">
            <a href="{{ url('login') }}" class="text-3xl font-bold text-primary-600 tracking-wide">Recuperar contraseña</a>
        </div>
        <div>
            <div class="card-header bg-primary text-white"></div>
            <div class="card-body p-4">
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="mb-6">
                        <label class="form-label mb-2">Email:</label>
                        <input type="email" name="emaUsu" class="form-control w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary-600 focus:border-primary-600 pl-10 py-2" required placeholder="ejemplo@gmail.com">
                    </div>
                    <button type="submit" class="btn btn-primary w-full bg-primary-600 text-white py-2 px-4 rounded-lg hover:bg-primary-700">Enviar enlace</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 