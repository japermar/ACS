@extends('layouts.app')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
@section('content')
    <div class="container my-5">
        <h1 class="mb-4 text-primary animate__animated animate__fadeInDown">Los VPS de {{$grupo['nombre_grupo']}} son:</h1>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($servidores as $pc)
                <div class="col">
                    <div class="card h-100 border-primary animate__animated animate__fadeInUp">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">
                                <a href="{{route('especifico', [$grupo_id, $pc['id']])}}" class="text-decoration-none text-primary fw-bold">
                                    <i class="fas fa-server me-2"></i>Nombre: {{ $pc['nombre_servidor'] }}
                                </a>
                            </h5>
                            <h6 class="card-subtitle mb-3 text-muted">IP: {{ $pc['direccion_ssh'] }}</h6>
                            <div class="card-text mb-3">
                                <div><strong>Puerto SSH:</strong> {{ $pc['puerto_ssh'] }}</div>
                                <div><strong>Usuario:</strong> {{ $pc['usuario_ssh'] }}</div>
                                <div><strong>Contraseña:</strong> ************</div>
                            </div>
                            <div class="card-text mt-auto">
                                <small class="text-muted">Añadido el día {{ \Carbon\Carbon::parse($pc['created_at'])->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4 animate__animated animate__fadeInUp">
            <a href="{{route('administrar_grupo', ['grupo_id'=>$grupo_id])}}" class="btn btn-primary">Administrar grupo {{$grupo['nombre_grupo']}}</a>
        </div>
    </div>
@endsection
