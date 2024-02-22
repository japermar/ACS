@extends('layouts.app')

@section('content')
    <div class="container my-4">
        @if($esAdmin)
            <div class="alert alert-success" role="alert">
                Eres admin. Como eres admin, puedes:
            </div>
            <ul class="list-group">
                <li class="list-group-item"><a href="#" class="stretched-link">Instalar o desinstalar apps para este VPS</a></li>
                <li class="list-group-item"><a href="#" class="stretched-link">Monitorizarlo</a></li>
                <li class="list-group-item"><a href="#" class="stretched-link">Conocer la info de hardware del mismo</a></li>
                <li class="list-group-item"><a href="#" class="stretched-link">Ejecutar custom scripts</a></li>
                <li class="list-group-item"><a href="#" class="stretched-link">Conectarse con SSH directamente</a></li>
                <li class="list-group-item"><a href="#" class="stretched-link">Acceder al asistente inteligente de ACS</a></li>
            </ul>
        @else
            <div class="alert alert-warning" role="alert">
                Su rol no es de administrador, así que solamente puede:
            </div>
            <ul class="list-group">
                <li class="list-group-item">Monitorizar el VPS</li>
                <li class="list-group-item">Conocer la información del mismo</li>
            </ul>
        @endif
    </div>
@endsection
