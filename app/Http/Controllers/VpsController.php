<?php

namespace App\Http\Controllers;

use App\Models\Servidor;
use Illuminate\Http\Request;

class VpsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index($grupo_id)
    {
        $user = auth()->user();

        $grupos = $user->grupos()->get();
        $actividades = $user->actividades()->get()->toArray(); // Assuming 'actividades' is a correctly defined relationship

        $perteneceAlGrupo = $user->perteneceAlGrupo($grupo_id);

        if (!$perteneceAlGrupo) {
            // If the user does not belong to the group, redirect back with an error message
            return redirect()->back()->withErrors(['error' => "No tienes acceso al grupo " . $grupo_id]);
        }
        $miembro = $user->esAdmin($grupo_id);
        $servidores = Servidor::where('grupo_id', $grupo_id)->get();
        $grupo = $user->obtenerGrupo($grupo_id);
        return view('vps.listar', compact('grupos','grupo' ,'actividades', 'user', 'grupo_id' ,'servidores', 'miembro'));
    }


}
