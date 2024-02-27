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
public function monitorizar()
{

    $privateKeyContent = "-----BEGIN RSA PRIVATE KEY-----
MIIEowIBAAKCAQEAksfJUA8XPpH4wUq+fBzTV5GB8vZXLu866u7PiQIPnGwhKHQB
xmS/RNsdKYkAAF9ehVwzzRXSsihgqsGcyX03sLOaibr+dJ9Y/KVAhQoHwqS+v9fv
al9dCkw1qV3BTfe5UB9bDAziMOH0EV0FK1DWZAn+jj0kmfeL1AyvIPApedxxocbX
KC9k0BUgAIkGDKKvpzMsFxzlG8pKE+O+wTOFWlEHNN5KGa4c10poV4tqIWOMuVmw
5OI5rYllYRQIqNdhES6/vjcb/Fq5JtyN+6pS+XQUTlJhaK/xzw12/fhgCzAnSYXp
M7N3GapYD6g/FzgFK/rSxeUmsFnSVmx+y6ybLQIDAQABAoIBABnlGUUAhI9LXWFs
eFKZG0f1qcFdaGAlYHWWEBMRxANKqEbkwHNpzrytE2YCf3eRW7GXZKQn13YK3ZMC
eVCqwKpx5S+rR7z3Z9GardlKvbe/LM/Xnqtbi6SHcWgh3DqPG6hg/8UOeNE6674s
dP8BUfFwOfKKIuzu2UJdwn/DHu4ai4xTtNTgavlgilza0BTrD+kH6JBYdl8SG/vB
T2Yt82278kNTHq2nluUcI4iZbXrQ2gjl+LI2x8oc/9k/yefzUhX/sd6g+bVcqdgA
+RNeNb0nCtOx4ng9q0YPkPBNRxumve98bF3+MLJxIRmlyUybW06pJiQ57m7ZinB+
9n82QRkCgYEAzCsRggQh75JIHSfEArBSq+OYXxez96R2uZLEutP3Yzlz3v3+gRvh
+kDFIufca4Yv1KF53xgayM74gMXU/88JEYv3+tHIJVhN5/p4kg6gxlovppvH32u3
3vUnErM8YH+ajZX7UcSLvUPNr4k+i5UtvWJCAcCn8N5koC/qJ3F/RxMCgYEAuAsS
p83k/JMlGIO4XypKrrHDPXiLoS1GTO54tQaUQ+EFixH0r8b4GJCE/cUg43/qlsxI
eB9sN8TR8hAd+VAxBEEcjn4bFX+kJlCYkYGfYOJ4uihoGKLZniCOmcnpDA6IUxvz
5lZYJ/9b5LuTv8QB3lmLApZDqTRPl94eo2HdnL8CgYBF3fsozfc6/4kUCRangOVZ
kxICgJ8CgNJsINCXyo+e8fs39R1R21PSirWrg0LHvOzDS9rjwGDyFPmvP4PrYlMN
ISPkPkPKm9RVLT5zZPQZzKT/09FrIHaUoroTSSjBMQmXqBqP2b2kL/7EMigoJg24
AFbsOJx/7errcloj01Al5wKBgEhWWdPI0osPztHO3AXTmp0FU6bynXcRU4Nja+BD
IL15UXNy8EiynMsS6qLP+3hPy8XPr2A/gYp9+sL44L8gbNOuP+ol2MFfdQZ2QTFX
0GwFN8x7m0aro3tKcqIxwT6y65Q29WuAXpACB31k2NLT2KQrb77pjtiPrgUUEdjH
25IDAoGBAKu1g3yelQ4Wmn4pgtZdbzjvkZTVC6ZE/nnRv93eRJRBCLf6SxcqTgw1
sw63RINNgasS8Vfdq5l1xNRwLN4e5yVhn8ICF1clYlT+ysJPYJsozpmACN9E1Hud
6/U11kYz+cOciM9PHepI+Cgxide/7kD3YsB+fOk90PIOYXsuOP69
-----END RSA PRIVATE KEY-----";
    $ip = '144.24.202.33';
    $usuarioVPS= 'ubuntu';
    $tempFilePath = tempnam(sys_get_temp_dir(), 'ssh_key_');
    file_put_contents($tempFilePath, $privateKeyContent);
    chmod($tempFilePath, 0600);
    try {

        $command = "echo -n '{' && " .
            "echo '\"Load Average\":['; uptime | awk '{print \"\\\"\" \$10 \"\\\",\\\"\" \$11 \"\\\",\\\"\" \$12 \"\\\"]\"}'; echo ',' && " .
            "(type mpstat > /dev/null 2>&1 || sudo apt-get install -y sysstat > /dev/null 2>&1) && " .
            "echo '\"CPU Usage\":'; mpstat 1 1 | awk '/Average/ && NR>1 {print \"{\\\"User\\\": \" \$3 \", \\\"System\\\": \" \$5 \", \\\"Idle\\\": \" \$12 \"}\"}'; echo ',' && " .
            "echo '\"Memory Usage\":'; free -m | awk 'NR==2{printf \"{\\\"Total\\\": \\\"%s MB\\\", \\\"Used\\\": \\\"%s MB\\\", \\\"Free\\\": \\\"%s MB\\\"}\", \$2,\$3,\$4}'; echo ',' && " .
            "echo '\"Processes\":'; ps -e --no-headers | wc -l | awk '{print \"{\\\"Total\\\": \" \$1 \"}\"}'; echo ',' && " .
            "echo '\"Disk Usage\":'; df -h / | awk 'NR==2{print \"{\\\"Used\\\": \\\"\" \$3 \"\\\", \\\"Available\\\": \\\"\" \$4 \"\\\", \\\"Use%\\\": \\\"\" \$5 \"\\\"}\"}'; " .
            "echo '}';";

        $process = Ssh::create($usuarioVPS, $ip)
            ->usePrivateKey($tempFilePath)->disableStrictHostKeyChecking()->execute($command);
        $process->wait();

        if ($process->isSuccessful()) {
            $systemResources = json_decode($process->getOutput(), true);
        } else {
            $systemResources = 'Error: ' . $process->getErrorOutput();
        }
    } finally {
        unlink($tempFilePath);
    }
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
        $servidor = Servidor::where('id', $vps_id)->first();
            $hardware = HardwareServidor::where('servidor_id', $vps_id)->first();


        return view('vps.especifico', compact('esAdmin', 'hardware',  'servidor', 'grupo_id', 'vps_id'));
    }


}
