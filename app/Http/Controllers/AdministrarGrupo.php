<?php

namespace App\Http\Controllers;

use App\Mail\Invitacion;
use App\Models\MiembroGrupo;
use App\Models\Servidor;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AdministrarGrupo extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index($grupo_id)
    {
        $user = auth()->user();
        $grupos = $user->grupos()->get();
        $miembro = $user->esAdmin($grupo_id);
        $grupo = $user->obtenerGrupo($grupo_id);

        $perteneceAlGrupo = $user->perteneceAlGrupo($grupo_id);
        if (!$perteneceAlGrupo) {
            return redirect()->back()->withErrors(['error' => "No tienes acceso al grupo " . $grupo_id]);
        }
        if(!$miembro){
            return redirect()->back()->withErrors(['error'=>'No eres administrador del grupo por lo tanto no puedes invitar a ningun miembro']);
        }

$miembroUserIds = MiembroGrupo::where('grupo_id', $grupo_id)
    ->where('user_id', '!=', $user->id)
    ->pluck('user_id');

$miembros = \App\Models\User::whereIn('id', $miembroUserIds)->get();

        return view('grupos.panel', compact(['user', 'grupo', 'miembros']));
    }


    public function invitar(Request $request, $grupo_id)
    {
        // Define validation rules
        $rules = [
            'email' => [
                'required',
                'email',
                'exists:users,email',
                function($attribute, $value, $fail) use ($grupo_id) {
                        $user = \App\Models\User::where('email', $value)->first();
                        if($user) {
                            $perteneceAlGrupo = $user->perteneceAlGrupo($grupo_id);
                            if ($perteneceAlGrupo) {
                                $fail('El usuario ya es miembro del grupo.');
                            }
                        }
                },
            ],
            'rol'=>[
                'required',
                'in:admin,monitor'
            ]
        ];

        // Custom error messages
        $messages = [
            'email.required' => 'Se necesita un email para poder invitar a un usuario.',
            'email.email' => 'El email introducido no es valido.',
            'email.exists' => 'El email no se encuentra registrado en nuestro sistema.',
            'rol.in' => 'El rol no es valido'
        ];

        // Perform validation
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            // If validation fails, redirect back with errors
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Your existing logic here
        $user = auth()->user();
        $miembro = $user->esAdmin($grupo_id);
        if (!$user->perteneceAlGrupo($grupo_id) || !$miembro) {
            $errorMessage = !$miembro ? "No eres administrador del grupo por lo tanto no puedes invitar a ningun miembro" : "No tienes acceso al grupo " . $grupo_id;
            return redirect()->back()->withErrors(['error' => $errorMessage]);
        }
        $grupo = $user->obtenerGrupo($grupo_id);

        $nombre = $grupo['nombre_grupo'];

        // Send invitation email
        Mail::to($request->email)->send(new Invitacion($request->email, $nombre));

        // Redirect or return success message
        $userEmail = $request->email;
        $user = \App\Models\User::where('email', $userEmail)->firstOrFail();

                $miembroGrupo = new MiembroGrupo();
    $miembroGrupo->grupo_id = $grupo_id;
    $miembroGrupo->user_id = $user->id; // Assuming you've got the user ID from the email
    $miembroGrupo->rol = $request->rol; // Assuming 'rol' is part of your request data and validated
    $miembroGrupo->created_at = now();
    $miembroGrupo->created_at = now();
    $miembroGrupo->updated_at = now();

    // Save the new MiembroGrupo instance to the database
    $miembroGrupo->save();
        return redirect()->back()->with('success', 'Notificacion de invitacion enviada con éxito.');
    }


    public function eliminar(Request $request, $grupo_id)
    {
        $user = auth()->user();
        $miembro = $user->esAdmin($grupo_id);
        if (!$user->perteneceAlGrupo($grupo_id) || !$miembro) {
            $errorMessage = !$miembro ? "No eres administrador del grupo por lo tanto no puedes invitar a ningun miembro" : "No tienes acceso al grupo " . $grupo_id;
            return redirect()->back()->withErrors(['error' => $errorMessage]);
        }

        $rules = [
            'selected_users' => [
                'required',
                'array', // Ensure it's an array
                'min:1', // Ensure there's at least one selection
            ],
            'selected_users.*' => [
                'numeric', // Check that each item in the array is numeric
            ]
        ];

// Custom error messages
        $messages = [
            'selected_users.required' => 'Debe seleccionar al menos un usuario para eliminar.',
            'selected_users.array' => 'La selección debe ser un conjunto válido de usuarios.',
            'selected_users.min' => 'Debe seleccionar al menos un usuario para eliminar.',
            'selected_users.*.numeric' => 'Los usuarios enviados para eliminar no tienen un formato correcto.', // Error message for each item in the array
        ];

// Perform validation
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            // Handle failed validation
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        MiembroGrupo::where('grupo_id', $grupo_id)
            ->whereIn('user_id', $request->selected_users)
            ->delete();
        return redirect()->back()->with('success', 'Miembros eliminados con éxito.');

    }



}

