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
        $tempFilePath = tempnam(sys_get_temp_dir(), 'ssh_key_');
        file_put_contents($tempFilePath, $privateKeyContent);
        chmod($tempFilePath, 0600);
        try {
            $process = Ssh::create($usuarioVPS, $ip)
                ->usePrivateKey($tempFilePath)->disableStrictHostKeyChecking()->execute('ping -c 4 8.8.8.8');

            // Wait for the process to finish
            $process->wait();

            // Check if the process was successful
            if ($process->isSuccessful()) {
                // Get the output
                $result = $process->getOutput();
            } else {
                // Get the error output
                $result = 'Error: ' . $process->getErrorOutput();
            }

            // Debug/Dump the result
//            dd($result);
        } finally {
            // Securely delete the temporary file
            unlink($tempFilePath);
        }

        return view('vps.especifico', compact('esAdmin', 'hardware', 'result'));
    }


}
