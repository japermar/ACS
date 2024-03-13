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


        <form action="{{ route('anadir_vps', ['grupo_id' => $grupo['id']]) }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="nombre_servidor" class="form-label">Nombre del servidor</label>
                <input type="text" name="nombre_servidor" id="nombre_servidor" class="form-control @error('nombre_servidor') is-invalid @enderror" >
                @error('nombre_servidor')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="direccion_ssh" class="form-label">Dirección SSH</label>
                <input type="text" name="direccion_ssh" id="direccion_ssh" class="form-control @error('direccion_ssh') is-invalid @enderror" pattern="^([0-9]{1,3}\.){3}[0-9]{1,3}$" title="Debe ser una dirección IP válida." >
                @error('direccion_ssh')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="puerto_ssh" class="form-label">Puerto SSH</label>
                <input type="number" value="22" name="puerto_ssh" id="puerto_ssh" class="form-control @error('puerto_ssh') is-invalid @enderror" min="1" max="65535" >
                @error('puerto_ssh')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="usuario_ssh" class="form-label">Usuario SSH</label>
                <input type="text" name="usuario_ssh" id="usuario_ssh" class="form-control @error('usuario_ssh') is-invalid @enderror" >
                @error('usuario_ssh')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="contrasena_ssh" class="form-label">Contraseña SSH</label>
                <input type="password" name="contrasena_ssh" id="contrasena_ssh" class="form-control @error('contrasena_ssh') is-invalid @enderror" >
                @error('contrasena_ssh')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="llave_privada_ssh" class="form-label">Llave privada SSH</label>
                <textarea name="llave_privada_ssh" id="llave_privada_ssh" class="form-control @error('llave_privada_ssh') is-invalid @enderror" rows="10"></textarea>

                @error('llave_privada_ssh')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Añadir VPS</button>
        </form>




    </div>
@endsection
