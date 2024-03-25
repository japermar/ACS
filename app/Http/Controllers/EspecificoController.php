<?php

namespace App\Http\Controllers;

use App\Models\HardwareServidor;
use App\Models\Servidor;
use Illuminate\Http\Request;
use Spatie\Ssh\Ssh;
use Symfony\Component\Process\Process;
class EspecificoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
public function monitorizar($grupo, $vps_id)
{
    $vps = \App\Models\Servidor::where('id', $vps_id)->first();
    $command = "echo -n '{' && " .
        "echo '\"Load Average\":['; uptime | awk '{print \"\\\"\" \$10 \"\\\",\\\"\" \$11 \"\\\",\\\"\" \$12 \"\\\"]\"}'; echo ',' && " .
        "(type mpstat > /dev/null 2>&1 || sudo apt-get install -y sysstat > /dev/null 2>&1) && " .
        "echo '\"CPU Usage\":'; mpstat 1 1 | awk '/Average/ && NR>1 {print \"{\\\"User\\\": \" \$3 \", \\\"System\\\": \" \$5 \", \\\"Idle\\\": \" \$12 \"}\"}'; echo ',' && " .
        "echo '\"Memory Usage\":'; free -m | awk 'NR==2{printf \"{\\\"Total\\\": \\\"%s MB\\\", \\\"Used\\\": \\\"%s MB\\\", \\\"Free\\\": \\\"%s MB\\\"}\", \$2,\$3,\$4}'; echo ',' && " .
        "echo '\"Processes\":'; ps -e --no-headers | wc -l | awk '{print \"{\\\"Total\\\": \" \$1 \"}\"}'; echo ',' && " .
        "echo '\"Disk Usage\":'; df -h / | awk 'NR==2{print \"{\\\"Used\\\": \\\"\" \$3 \"\\\", \\\"Available\\\": \\\"\" \$4 \"\\\", \\\"Use%\\\": \\\"\" \$5 \"\\\"}\"}'; " .
        "echo '}';";
    $systemResources = json_decode($vps->ejecutar_comando($command));

    return view('vps.monitorizar', compact('systemResources'));
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
            $hardware = HardwareServidor::where('servidor_id', $vps_id)->first();

        $servidor = Servidor::where('grupo_id', $grupo_id)
            ->where('id', $vps_id)
            ->firstOrFail();

        return view('vps.especifico', compact('esAdmin', 'hardware',  'servidor', 'grupo_id', 'vps_id'));
    }


}
