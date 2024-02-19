@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">



                    <p>Eres admin del equipo Real Madrid</p>
                    <p>Tu equipo tiene 5 vps activos puedes consultarlos aqui</p>
                    <p>Te uniste a {{ config('app.name', 'Laravel') }} el dia blablabla</p>
                    <p>Perteneces a X cantidad de equipos</p>
                    <p>Las acciones que has tomado desde que te creaste la cuenta son </p>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
{{--                            {{ session('status') }}--}}
                        </div>
                    @endif

{{--                    {{ __('You are logged in!') }}--}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
