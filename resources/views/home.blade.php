@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">{{ __('Dashboard') }}</div>
                    <div class="card-body">
                        @if($grupos)
                            <h5 class="card-title">Equipos</h5>
                            <p>Perteneces a {{sizeof($grupos)}} grupos</p>
                            <div class="list-group mb-4">
                                @foreach($grupos as $grupo)
                                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                        Equipo <strong>{{$grupo['nombre_grupo']}}</strong>
                                        <span class="badge bg-secondary rounded-pill">Rol {{$grupo['pivot']['rol']}}</span>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-warning" role="alert">
                                No perteneces a ningún equipo.
                            </div>
                        @endif

                        <div class="mb-4">
                            <p>Te uniste a {{ config('app.name', 'Laravel') }} el día {{$user['created_at']->diffForHumans()}}</p>
                        </div>

                        @if($actividades)
                            <h5 class="card-title">Actividades Recientes</h5>
                            <ul class="list-group mb-4">
                                @foreach($actividades as $actividad)
                                    <li class="list-group-item">{{$actividad['accion']}}</li>
                                @endforeach
                            </ul>
                        @endif

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
