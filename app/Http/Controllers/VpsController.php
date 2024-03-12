<?php

namespace App\Http\Controllers;

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
public function  anadir(Request $request, $grupo_id)
{
    $rules = [
        'nombre_servidor' => [
            'required'],
        'direccion_ssh'=>[
            'required'
        ],'direccion_ssh'=>[
            'required'
        ],'puerto_ssh'=>[
            'required'
        ],'usuario_ssh'=>[
            'required'
        ],'contrasena_ssh'=>[
            'required'
        ],'llave_privada_ssh'=>[
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
    dd('checked');

}

    public function instalar_docker()
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
        $usuarioVPS = 'ubuntu';
        $tempFilePath = tempnam(sys_get_temp_dir(), 'ssh_key_');
        file_put_contents($tempFilePath, $privateKeyContent);
        chmod($tempFilePath, 0600);
        try {
            $class = 'alert-success';
            $command = "curl -fsSL https://get.docker.com -o get-docker.sh
                        sudo sh get-docker.sh
                         ";
            $mensaje = null;
            $process = Ssh::create($usuarioVPS, $ip)
                ->usePrivateKey($tempFilePath)->disableStrictHostKeyChecking()->execute($command);
            $process->wait();
            $resultado = $process->isSuccessful();
            if ($resultado) {
                $mensaje = 'Docker instalado ' . $process->getOutput();
            } else {
                $mensaje = 'Docker no se ha podido instalar ' . $process->getErrorOutput();
                $class = 'alert-danger';
            }
        } finally {
            unlink($tempFilePath);
        }

        return '<p class="alert ' . $class . '" role="alert">' . htmlspecialchars($mensaje) . '</p>';

    }


    public function revisar_docker($grupo_id, $vps_id)
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
        $usuarioVPS = 'ubuntu';
        $tempFilePath = tempnam(sys_get_temp_dir(), 'ssh_key_');
        file_put_contents($tempFilePath, $privateKeyContent);
        chmod($tempFilePath, 0600);
        try {
            $class = 'alert-success';
            $command = "docker --version";
            $mensaje = null;
            $process = Ssh::create($usuarioVPS, $ip)
                ->usePrivateKey($tempFilePath)->disableStrictHostKeyChecking()->execute($command);
            $process->wait();
            $resultado = $process->isSuccessful();
            if ($resultado) {
                $mensaje = 'Docker esta instalado ' . $process->getOutput();
            } else {
                $mensaje = 'Docker no esta instalado';
                $class = 'alert-danger';
            }
        } finally {
            unlink($tempFilePath);
        }

        return '<p class="alert ' . $class . '" role="alert">' . htmlspecialchars($mensaje) . '</p>';

    }

    public function desinstalar_docker($grupo_id, $vps_id)
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
        $usuarioVPS = 'ubuntu';
        $tempFilePath = tempnam(sys_get_temp_dir(), 'ssh_key_');
        file_put_contents($tempFilePath, $privateKeyContent);
        chmod($tempFilePath, 0600);
        try {
            $class = 'alert-success';
            $command = "
         sudo apt-get purge docker-ce docker-ce-cli containerd.io
";
            $mensaje = null;
            $process = Ssh::create($usuarioVPS, $ip)
                ->usePrivateKey($tempFilePath)->disableStrictHostKeyChecking()->execute($command);
            $process->wait();
            $resultado = $process->isSuccessful();
            if ($resultado) {
                $mensaje = 'Docker se ha desinstalado correctamente ' . $process->getOutput();
            } else {
                $mensaje = 'Docker no se ha podido desinstalar ' . $process->getErrorOutput();
                $class = 'alert-danger';
            }
        } finally {
            unlink($tempFilePath);
        }

        return '<p class="alert ' . $class . '" role="alert">' . htmlspecialchars($mensaje) . '</p>';

    }


}
