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
        <!-- Display Error Messages -->
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- Assuming Bootstrap CSS is included in your layout -->
        <div class="container mt-3">
            <form action="{{ route('eliminar', ['grupo_id'=>$grupo['id']]) }}" method="POST">
                @csrf <!-- CSRF token for form security -->

                <table class="table table-bordered table-hover">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Correo Electrónico</th>
                        <th scope="col">Seleccionar</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($miembros as $index => $miembro)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>{{ $miembro->name }}</td> <!-- Adjust based on your object structure -->
                            <td>{{ $miembro->email }}</td> <!-- Adjust based on your object structure -->
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="selected_users[]" value="{{ $miembro->id }}" id="defaultCheck{{ $index }}">
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="mt-3">
                    <button type="submit" class="btn btn-danger mb-4">Eliminar seleccionados</button>
                </div>
            </form>
        </div>

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
            <select name="rol" id="rol" class="form-control mb-4">
                <option value="admin">Administrador</option>
                <option value="monitor">Monitor</option>
            </select>

            <input type="hidden" name="user_id" value="{{ $user['id'] }}">
            <button type="submit" class="btn btn-primary">Invitar a usuario</button>
        </form>
    </div>
@endsection
