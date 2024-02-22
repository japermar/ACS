@extends('layouts.app')

@section('content')
    <div class="container my-4">
        <div class="card">
            <p>{{$result}}</p>
            <div class="card-header">
                Información de Hardware
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-3">
                        <h5 class="card-title">CPU</h5>
                        <p class="card-text">{{ $hardware->cpu }}</p>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <h5 class="card-title">RAM</h5>
                        <p class="card-text">{{ $hardware->ram }}</p>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <h5 class="card-title">Almacenamiento</h5>
                        <p class="card-text">{{ $hardware->almacenamiento }}</p>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <h5 class="card-title">Velocidad de red</h5>
                        <p class="card-text">{{ $hardware->velocidad_red }}</p>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <h5 class="card-title">Creado el</h5>
                        <p class="card-text">{{ \Carbon\Carbon::parse($hardware->created_at)->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <h5 class="card-title">Última actualización</h5>
                        <p class="card-text">{{ \Carbon\Carbon::parse($hardware->updated_at)->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
        @if($esAdmin)
            <div class="alert alert-success mt-4" role="alert">
                Eres admin. Como eres admin, puedes:
            </div>
            <ul class="list-group">
                <li class="list-group-item"><a href="#" class="stretched-link">Instalar o desinstalar apps para este VPS</a></li>
                <li class="list-group-item"><a href="#" class="stretched-link">Monitorizarlo</a></li>
                <li class="list-group-item" style="display: none;"><a href="#" class="stretched-link">Conocer la info de hardware del mismo</a></li>
                <li class="list-group-item"><a href="#" class="stretched-link">Ejecutar custom scripts</a></li>
                <li class="list-group-item"><a href="#" class="stretched-link">Conectarse con SSH directamente</a></li>
                <li class="list-group-item"><a href="#" class="stretched-link">Acceder al asistente inteligente de ACS</a></li>
            </ul>
        @else
            <div class="alert alert-warning mt-4" role="alert">
                Su rol no es de administrador, así que solamente puede:
            </div>
            <ul class="list-group">
                <li class="list-group-item">Monitorizar el VPS</li>
                <li class="list-group-item" style="display: none;">Conocer la información del mismo</li>
            </ul>
        @endif
    </div>
@endsection
