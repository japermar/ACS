@extends('layouts.app')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/wc-bubble"></script>
    <style>
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
            transform: translateY(-5px);
        }

        .card-header {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #495057;
        }

        .card-title {
            color: #007bff;
        }

        .btn-primary {
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: scale(1.05);
        }

        .alert {
            border-radius: 10px;
        }

        .list-group-item {
            transition: all 0.3s ease;
        }

        .list-group-item:hover {
            background-color: #f8f9fa;
            transform: translateX(5px);
        }

        .chat-bubble {
            position: fixed;
            bottom: 20px;
            left: 20px;
            z-index: 9999;
        }
    </style>
    @vite(['resources/sass/app.scss', 'resources/js/graph.js','resources/js/app.js', 'resources/js/htmx.js', 'resources/js/event.js'])

    <div class="container my-4">
        <div class="card mb-4">
            <div class="card-header">
                <h4 class="mb-0">{{$servidor['nombre_servidor']}}</h4>
            </div>
            <div class="card-body">
                <h5 class="card-title">Información de Hardware</h5>
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-3">
                        <h6>CPU</h6>
                        <p class="card-text">{{ $hardware->cpu }}</p>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <h6>RAM</h6>
                        <p class="card-text">{{ $hardware->ram }}</p>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <h6>Almacenamiento</h6>
                        <p class="card-text">{{ $hardware->almacenamiento }}</p>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <h6>Velocidad de red</h6>
                        <p class="card-text">{{ $hardware->velocidad_red }}</p>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <h6>Creado el</h6>
                        <p class="card-text">{{ \Carbon\Carbon::parse($hardware->created_at)->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <h6>Última actualización</h6>
                        <p class="card-text">{{ \Carbon\Carbon::parse($hardware->updated_at)->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-4">
            <button hx-post="{{ route('monitorizar', [$grupo_id, $vps_id]) }}" hx-target="#response" hx-indicator="#spinner" class="btn btn-primary">Monitorizar servidor</button>
        </div>
        <div id="response"></div>

        <!-- Spinner -->
        <div id="spinner" style="display:none;" class="text-center">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        @if($esAdmin)
            <div class="alert alert-success mt-4" role="alert">
                Eres administrador. Como eres administrador, puedes:
            </div>
            <ul class="list-group">
                <li class="list-group-item"><a href="{{route('monitorizar_vps', ['grupo_id' =>$grupo_id, 'vps_id' =>$vps_id])}}" class="stretched-link text-decoration-none">Instalar o desinstalar apps para este VPS</a></li>
                <li class="list-group-item"><a href="{{route('mostar_custom_scripts_plantilla', ['grupo_id'=>$grupo_id, 'vps_id'=>$vps_id])}}" class="stretched-link text-decoration-none">Ejecutar custom scripts</a></li>
                <li class="list-group-item"><a href="{{route('ejecutar_custom_scripts', ['grupo_id'=>$grupo_id, 'vps_id'=>$vps_id])}}" class="stretched-link text-decoration-none">Conectarse con SSH directamente</a></li>
            </ul>
        @else
            <div class="alert alert-warning mt-4" role="alert">
                Su rol no es de administrador, así que solamente puede:
            </div>
            <ul class="list-group">
                <li class="list-group-item">Monitorizar el VPS</li>
            </ul>
        @endif
    </div>

    <div class="chat-bubble">
        <chat-bubble>
            <a href="{{route('asistente', ['grupo_id'=>$grupo_id, 'vps_id'=>$vps_id])}}" class="text-decoration-none">Cualquier duda puedes consultarme</a>
        </chat-bubble>
    </div>
@endsection
