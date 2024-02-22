<?php

namespace App\Http\Controllers;

use App\Models\Servidor;
use Illuminate\Http\Request;

class EspecificoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index($grupo_id, $vps_id)
    {
        $user = auth()->user();
        $perteneceAlGrupo = $user->perteneceAlGrupo($grupo_id);
        if (!$perteneceAlGrupo) {
            // If the user does not belong to the group, redirect back with an error message
            return redirect()->back()->withErrors(['error' => "No tienes acceso al grupo " . $grupo_id]);
        }
        $esAdmin = $user->esAdmin($grupo_id);
        return view('vps.especifico', compact('esAdmin'));
    }


}
