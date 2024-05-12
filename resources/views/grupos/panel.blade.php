@extends('layouts.app')
@section('content')
    <div class="container my-5">
        <h1 class="mb-4 text-secondary animate__animated animate__fadeInDown">Panel de administrador de {{ $grupo['nombre_grupo'] }}</h1>
        <!-- Display Success Message -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeInUp" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Display Error Messages -->
        @if($errors->any())
            <div class="alert alert-danger animate__animated animate__fadeInUp">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Miembros del grupo -->
        <div class="card mb-4 animate__animated animate__fadeInUp">
            <div class="card-header bg-light text-dark">
                Miembros del grupo
            </div>
            <div class="card-body">
                <form action="{{ route('eliminar', ['grupo_id'=>$grupo['id']]) }}" method="POST">
                    @csrf
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Correo Electrónico</th>
                                <th scope="col">Seleccionar</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($miembros as $index => $miembro)
                                <tr class="animate__animated animate__fadeInUp animate__delay-{{ $index * 100 }}ms">
                                    <th scope="row">{{ $index + 1 }}</th>
                                    <td>{{ $miembro->name }}</td>
                                    <td>{{ $miembro->email }}</td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="selected_users[]" value="{{ $miembro->id }}" id="defaultCheck{{ $index }}">
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-outline-danger animate__animated animate__pulse">Eliminar seleccionados</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Invitar a un nuevo miembro -->
        <div class="card mb-4 animate__animated animate__fadeInUp">
            <div class="card-header bg-light text-dark">
                Invitar a un nuevo miembro
            </div>
            <div class="card-body">
                <h5 class="card-title">Invitación a Grupo</h5>
                <p class="card-text">Utiliza el siguiente formulario para invitar a nuevos usuarios al grupo. Por favor, introduce el correo electrónico del usuario que deseas invitar.</p>
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
                    <div class="mb-3">
                        <label for="rol" class="form-label">Rol para el nuevo miembro</label>
                        <select name="rol" id="rol" class="form-select">
                            <option value="admin">Administrador</option>
                            <option value="monitor">Monitor</option>
                        </select>
                    </div>
                    <input type="hidden" name="user_id" value="{{ $user['id'] }}">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-outline-primary animate__animated animate__pulse">Invitar a usuario</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Añadir VPS -->
        <div class="card mb-4 animate__animated animate__fadeInUp">
            <div class="card-header bg-light text-dark">
                Añadir VPS
            </div>
            <div class="card-body">
                <form action="{{ route('anadir_vps', ['grupo_id' => $grupo['id']]) }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="nombre_servidor" class="form-label">Nombre del servidor</label>
                        <input type="text" name="nombre_servidor" id="nombre_servidor" class="form-control @error('nombre_servidor') is-invalid @enderror">
                        @error('nombre_servidor')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="direccion_ssh" class="form-label">Dirección SSH</label>
                        <input type="text" name="direccion_ssh" id="direccion_ssh" class="form-control @error('direccion_ssh') is-invalid @enderror" pattern="^([0-9]{1,3}\.){3}[0-9]{1,3}$" title="Debe ser una dirección IP válida.">
                        @error('direccion_ssh')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="puerto_ssh" class="form-label">Puerto SSH</label>
                        <input type="number" value="22" name="puerto_ssh" id="puerto_ssh" class="form-control @error('puerto_ssh') is-invalid @enderror" min="1" max="65535">
                        @error('puerto_ssh')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="usuario_ssh" class="form-label">Usuario SSH</label>
                        <input type="text" name="usuario_ssh" id="usuario_ssh" class="form-control @error('usuario_ssh') is-invalid @enderror">
                        @error('usuario_ssh')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="contrasena_ssh" class="form-label">Contraseña SSH</label>
                        <input type="password" name="contrasena_ssh" id="contrasena_ssh" class="form-control @error('contrasena_ssh') is-invalid @enderror">
                        @error('contrasena_ssh')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="llave_privada_ssh" class="form-label">Llave privada SSH</label>
                        <textarea name="llave_privada_ssh" id="llave_privada_ssh" class="form-control @error('llave_privada_ssh') is-invalid @enderror" rows="5"></textarea>
                        @error('llave_privada_ssh')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-outline-primary animate__animated animate__pulse">Añadir VPS</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
