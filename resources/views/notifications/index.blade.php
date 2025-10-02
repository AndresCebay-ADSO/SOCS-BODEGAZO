@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Centro de Notificaciones</div>

                <div class="card-body">
                    @if($notifications->isEmpty())
                        <p class="text-center">No tienes notificaciones.</p>
                    @else
                        <ul class="list-group">
                            @foreach ($notifications as $notification)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        {{ $notification->data['message'] }} 
                                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                    </div>
                                    @if($notification->read_at)
                                        <span class="badge bg-secondary">Leída</span>
                                    @else
                                        <span class="badge bg-primary">Nueva</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="card-footer">
                    {{ $notifications->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection