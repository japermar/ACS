@extends('layouts.app')

@section('content')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/sass/app.scss', 'resources/js/graph.js','resources/js/app.js', 'resources/js/htmx.js', 'resources/js/event.js'])

    <div class="container my-4">
        <div class="card">
            <p style="margin-left: 5px">{{$servidor['nombre_servidor']}}</p>
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
        <button hx-post="{{ route('monitorizar', [$grupo_id, $vps_id]) }}" hx-target="#response" hx-indicator="#spinner" class="btn btn-primary">Monitorizar servidor</button>
        <div id="response"></div>

        <!-- Spinner -->
        <div id="spinner" style="display:none;" class="text-center">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>        @if($esAdmin)
            <div class="alert alert-success mt-4" role="alert">
                Eres admin. Como eres admin, puedes:
            </div>
            <ul class="list-group">
                <li class="list-group-item"><a href="{{route('monitorizar_vps', ['grupo_id' =>$grupo_id, 'vps_id' =>$vps_id])}}" class="stretched-link">Instalar o desinstalar apps para este VPS</a></li>
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
