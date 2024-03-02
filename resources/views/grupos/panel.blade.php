@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Bienvenido al panel de administrador {{ $grupo['nombre_grupo'] }}</h1>

        <!-- Display Success Message -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- Invitation Explanation Card -->
        <div class="card mb-4">
            <div class="card-header">
                Invitar a un nuevo miembro
            </div>
            <div class="card-body">
                <h5 class="card-title">Invitación a Grupo</h5>
                <p class="card-text">Utiliza el siguiente formulario para invitar a nuevos usuarios al grupo. Por favor, introduce el correo electrónico del usuario que deseas invitar.</p>
            </div>
        </div>

        <!-- Invitation Form -->
        <form action="{{ route('invitar', ['grupo_id' => $grupo['id']]) }}" method="post" class="needs-validation" novalidate>
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email" name="email" required>
                @if ($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
            </div>
            <p>Rol para el nuevo miembro</p>
            <select name="rol" id="rol" class="form-control">
                <option value="admin">Administrador</option>
                <option value="monitor">Monitor</option>
            </select>

            <input type="hidden" name="user_id" value="{{ $user['id'] }}">
            <button type="submit" class="btn btn-primary">Invitar a usuario</button>
        </form>
    </div>
@endsection
