@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <p>{{$grupo_id}}</p>
        <h1 class="mb-4">Los VPS que tiene este equipo son:</h1>

        <div class="row">
            @foreach($servidores as $pc)

                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">

                            <h5 class="card-title"><a href="{{route('especifico', [$grupo_id, $pc['id']])}}">Nombre: {{ $pc['nombre_servidor'] }}</a></h5>
                            <h6 class="card-subtitle mb-2 text-muted">IP: {{ $pc['direccion_ssh'] }}</h6>
                            <p class="card-text">
                                <strong>Puerto SSH:</strong> {{ $pc['puerto_ssh'] }}<br>
                                <strong>Usuario:</strong> {{ $pc['usuario_ssh'] }}<br>
                                <strong>Contraseña:</strong> ************
                            </p>
                            <p class="card-text"><small class="text-muted">Añadido el día {{ \Carbon\Carbon::parse($pc['created_at'])->format('d/m/Y H:i') }}</small></p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
