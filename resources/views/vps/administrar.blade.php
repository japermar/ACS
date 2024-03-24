@extends('layouts.app')

@section('content')
    @vite(['resources/sass/app.scss', 'resources/js/graph.js','resources/js/app.js', 'resources/js/htmx.js', 'resources/js/event.js'])

    <div class="container mt-5">
        <h1 class="mb-4">Ahora estas controlando el servidor {{$servidor['nombre_servidor']}}</h1>

        <button hx-post="{{ route('revisar_docker', [$grupo_id, $servidor['id']]) }}" hx-target="#response" hx-indicator="#spinner" class="btn btn-primary mb-4">Revisar si docker esta instalado</button>
        <button hx-post="{{ route('instalar_docker', [$grupo_id, $servidor['id']]) }}" hx-target="#response" hx-indicator="#spinner" class="btn btn-primary">Instalar docker</button>
        <button hx-post="{{ route('desinstalar_docker', [$grupo_id, $servidor['id']]) }}" hx-target="#response" hx-indicator="#spinner" class="btn btn-primary">Desinstalar docker</button>
        <button hx-post="{{ route('servicios_docker', [$grupo_id, $servidor['id']]) }}" hx-target="#response" hx-indicator="#spinner" class="btn btn-primary">Ver servicios docker</button>
        <div id="response"></div>

        <!-- Spinner -->
        <div id="spinner" style="display:none;" class="text-center">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
@endsection
