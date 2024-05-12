@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-gradient-primary text-white">
                        <h3 class="mb-0">{{ __('Dashboard') }}</h3>
                    </div>
                    <div class="card-body bg-light">
                        <!-- Render error message -->
                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error:</strong> {{$errors->first()}}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if($grupos)
                            <h4 class="card-title text-primary mb-4">Equipos</h4>
                            <p class="text-muted mb-4">Perteneces a {{sizeof($grupos)}} grupos</p>
                            <div class="row">
                                @foreach($grupos as $grupo)
                                    <div class="col-md-6 mb-4">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body">
                                                <h5 class="card-title text-dark">Equipo {{$grupo['nombre_grupo']}}</h5>
                                                <p class="card-text text-muted">Rol:
                                                    @if($grupo['pivot']['rol'] == 'admin')
                                                        <span class="badge bg-danger rounded-pill">{{$grupo['pivot']['rol']}}</span>
                                                    @elseif($grupo['pivot']['rol'] == 'moderator')
                                                        <span class="badge bg-warning rounded-pill">{{$grupo['pivot']['rol']}}</span>
                                                    @else
                                                        <span class="badge bg-info rounded-pill">{{$grupo['pivot']['rol']}}</span>
                                                    @endif
                                                </p>
                                                <a href="{{route('ver_grupo', $grupo['id'])}}" class="btn btn-primary">Ver equipo</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-warning" role="alert">
                                No perteneces a ningún equipo.
                            </div>
                        @endif

                        <div class="mt-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">Tu membresía</h5>
                                    <p class="card-text text-muted">Te uniste a {{ config('app.name', 'Laravel') }} el día {{$user['created_at']->format('d/m/Y')}}.</p>
                                    <p class="card-text">
                                        @php
                                            $mesesTranscurridos = $user['created_at']->diffInMonths(now());
                                            $diasTranscurridos = $user['created_at']->diffInDays(now());
                                        @endphp
                                        @if($mesesTranscurridos == 0)
                                            @if($diasTranscurridos == 0)
                                                <span class="badge bg-success rounded-pill">¡Te uniste hoy!</span>
                                            @elseif($diasTranscurridos == 1)
                                                <span class="badge bg-success rounded-pill">Miembro desde hace 1 día</span>
                                            @else
                                                <span class="badge bg-success rounded-pill">Miembro desde hace {{$diasTranscurridos}} días</span>
                                            @endif
                                        @elseif($mesesTranscurridos < 12)
                                            <span class="badge bg-info rounded-pill">Miembro desde hace {{$mesesTranscurridos}} meses</span>
                                        @else
                                            @php
                                                $añosTranscurridos = floor($mesesTranscurridos / 12);
                                            @endphp
                                            <span class="badge bg-warning rounded-pill">Miembro desde hace {{$añosTranscurridos}} años</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

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

<style>
    body {
        background-color: #f8f9fa;
    }

    .card-header {
        background: linear-gradient(to right, #007bff, #6c757d);
    }

    .card {
        transition: transform 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .badge {
        font-size: 0.9rem;
    }
</style>
