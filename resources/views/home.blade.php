@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-gradient-primary text-black">
                        <h3 class="mb-0">{{ __('Dashboard') }}</h3>
                    </div>
                    <div class="card-body bg-light">
                        <!-- Render error message -->
                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error:</strong> {{$errors->first()}}
                            </div>
                        @endif

                        @if($grupos)
                            <h5 class="card-title text-secondary">Equipos</h5>
                            <p>Perteneces a {{sizeof($grupos)}} grupos</p>
                            <div class="list-group mb-3">
                                @foreach($grupos as $grupo)
                                    <a href="{{route('ver_grupo', $grupo['id'])}}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center bg-opacity-10">
                                        Equipo <strong>{{$grupo['nombre_grupo']}}</strong>
                                        <span class="badge bg-info rounded-pill">Rol {{$grupo['pivot']['rol']}}</span>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-warning" role="alert">
                                No perteneces a ningún equipo.
                            </div>
                        @endif

                        <div class="mb-3">
                            <p>Te uniste a {{ config('app.name', 'Laravel') }} el día {{$user['created_at']->diffForHumans()}}</p>
                        </div>

                        @if($actividades)
                            <h5 class="card-title text-secondary">Actividades Recientes</h5>
                            <ul class="list-group mb-3">
                                @foreach($actividades as $actividad)
                                    <li class="list-group-item bg-opacity-10">{{$actividad['accion']}}</li>
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
