<?php

namespace App\Http\Controllers;

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

        // Retrieve all groups the user belongs to
        $grupos = $user->grupos()->get();
        $actividades = $user->actividades()->get()->toArray(); // Assuming 'actividades' is a correctly defined relationship

        // Check if the user belongs to the group using the correct column name in the pivot table or related model
        $belongs = $user->grupos()->where('grupos_colaboracion.id', $grupo_id)->exists(); // Assuming 'grupos_colaboracion' is the correct table name

        if (!$belongs) {
            // If the user does not belong to the group, redirect back with an error message
            return redirect()->back()->withErrors(['error' => "No tienes acceso al grupo " . $grupo_id]);
        }

        // Proceed with your logic if the user belongs to the group
        return view('yourViewNameHere', compact('grupos', 'actividades', 'user'));
    }



}
