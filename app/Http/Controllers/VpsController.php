<?php

namespace App\Http\Controllers;

use App\Models\HardwareServidor;
use App\Models\Servidor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Ssh\Ssh;

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
        return view('vps.listar', compact('grupos', 'grupo', 'actividades', 'user', 'grupo_id', 'servidores', 'miembro'));
    }


    public function monitorizar($grupo_id, $vps_id)
    {
        $user = auth()->user();
        $grupos = $user->grupos()->get();
        $actividades = $user->actividades()->get()->toArray(); // Assuming 'actividades' is a correctly defined relationship

        $perteneceAlGrupo = $user->perteneceAlGrupo($grupo_id);
        $miembro = $user->esAdmin($grupo_id);

        $servidor = Servidor::where('grupo_id', $grupo_id)
            ->where('id', $vps_id)
            ->firstOrFail();


        return view('vps.administrar', compact('servidor', 'grupo_id'));
    }

    public function anadir(Request $request, $grupo_id)
    {
        $rules = [
            'nombre_servidor' => [
                'required'],
            'direccion_ssh' => [
                'required'
            ], 'direccion_ssh' => [
                'required'
            ], 'puerto_ssh' => [
                'required'
            ], 'usuario_ssh' => [
                'required'
            ], 'contrasena_ssh' => [
                'required'
            ], 'llave_privada_ssh' => [
                'required'
            ],

        ];


        // Perform validation
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // If validation fails, redirect back with errors
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $nuevo_vps = new Servidor();
        $nuevo_vps->nombre_servidor = $request->nombre_servidor;
        $nuevo_vps->direccion_ssh = $request->direccion_ssh;
        $nuevo_vps->puerto_ssh = $request->puerto_ssh;
        $nuevo_vps->usuario_ssh = $request->usuario_ssh;
        $nuevo_vps->contrasena_ssh = $request->contrasena_ssh;
        $nuevo_vps->private_key = $request->llave_privada_ssh;
        $nuevo_vps->created_at = now();
        $nuevo_vps->grupo_id = $grupo_id;
        $nuevo_vps->updated_at = now();
        //obtener info hardware y meter a db
        $nuevo_vps->save();
       $datos =  $nuevo_vps->obtenerHardware();

        $hard = new HardwareServidor();
        $hard->cpu = $datos[0];
        $hard->ram =  $datos[1];
        $hard->almacenamiento =  $datos[2];
        $hard->velocidad_red =  $datos[3];
        $hard->servidor_id = $nuevo_vps['id'];
        $hard->save();
        return redirect()->route('ver_grupo', ['group_id' => $grupo_id]);
    }

    public function instalar_docker($grupo_id, $vps_id)
    {
        $vps = \App\Models\Servidor::where('id', $vps_id)->first();
        $class = 'alert-success';
        $command = "curl -fsSL https://get.docker.com -o get-docker.sh
                sudo sh get-docker.sh";
        $executionResult = $vps->ejecutar_comando($command);
        return '<p class="alert ' . $class . '" role="alert">' . htmlspecialchars($executionResult) . '</p>';
    }

    public function revisar_docker($grupo_id, $vps_id)
    {
        $vps = \App\Models\Servidor::where('id', $vps_id)->first();
        $class = 'alert-success';
        $command = "docker --version";
        $executionResult = $vps->ejecutar_comando($command);
        return '<p class="alert ' . $class . '" role="alert">' . htmlspecialchars($executionResult) . '</p>';

    }

    public function desinstalar_docker($grupo_id, $vps_id)
    {
        $vps = \App\Models\Servidor::where('id', $vps_id)->first();
        $class = 'alert-success';
        $command = " sudo apt-get purge docker-ce docker-ce-cli containerd.io";
        $executionResult = $vps->ejecutar_comando($command);
        return '<p class="alert ' . $class . '" role="alert">' . htmlspecialchars($executionResult) . '</p>';
    }


}
