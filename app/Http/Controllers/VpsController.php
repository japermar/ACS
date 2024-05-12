<?php

namespace App\Http\Controllers;

use App\Models\GruposColaboracion;
use App\Models\HardwareServidor;
use App\Models\Servidor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Ssh\Ssh;

class VpsController extends Controller
{


    public function mostar_custom_scripts_plantilla($grupo_id, $vps_id)
    {
        return view('vps.custom', compact( 'grupo_id', 'vps_id'));


    }

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function hablar(Request $request)
    {
       return $request->mensaje;
    }

    public function apagar_servicio($grupo_id, $vps_id)
    {
        $vps = \App\Models\Servidor::where('id', $vps_id)->first();
        $comando = "docker stop $(docker ps -q)";
        $output = $vps->ejecutar_comando($comando);
        return '<p>Se han apagado todos los servicios correctamente</p>';
    }

    public function ejecutar_bash_script(Request $request, $vps_id)
    {
        $vps = \App\Models\Servidor::where('id', $vps_id)->first();
        if ($request->hasFile('bash_file')) {
            $file = $request->file('bash_file');
            if ($file->getClientOriginalExtension() === 'sh') {
                $content = file_get_contents($file->getPathname());
                return $vps->ejecutar_comando($content);
            }
        }
    }
    public function ejecutar_comando(Request $request)
    {
        $comando = $request->input('command');
        $vps_id = $request->input('vps_id');
        $vps = \App\Models\Servidor::where('id', $vps_id)->first();

        if ($vps) {
            $output = $vps->ejecutar_comando($comando);
            $respuesta = '<p>La respuesta es: ' . $output . '</p>';
        } else {
            $respuesta = '<p>No se encontró el servidor con ID: ' . $vps_id . '</p>';
        }

        return $respuesta;
    }
    public function ia($grupo_id,$vps_id)
    {
        $grupo = GruposColaboracion::where('id', $grupo_id)->first();
        $vps = Servidor::where('id', $vps_id)->first();
        $hardware = HardwareServidor::where('servidor_id', $vps_id)->first();

        return view('vps.asistente', compact('grupo','vps','hardware'));

    }

public function custom_scripts(Request $request, $grupo_id, $vps_id)
{
    // Assuming you have a model Servidor that corresponds to your servers
    $vps = \App\Models\Servidor::where('id', $vps_id)->first();

    return view('vps.custom_scripts', compact('vps_id'));
}

    public function encender_servicio(Request $request, $grupo_id, $vps_id)
    {
        // Assuming you have a model Servidor that corresponds to your servers
        $vps = \App\Models\Servidor::where('id', $vps_id)->first();

        $estados = $request->input('estado');
$resultado = '';
$comando='';
        foreach ($estados as $servicio => $estado) {
            if ($estado == 'on') {
                $comando = "docker run -d --name ${servicio} ${servicio}";
            } else {
                $comando = "docker stop {$servicio}";
            }
            $resultado .= $vps->ejecutar_comando($comando);
        }

    return $resultado;
    }




    public function administrar_servicio($grupo_id, $vps_id)
    {
        $vps = \App\Models\Servidor::where('id', $vps_id)->first();
        $imagesCommand = "docker images";
        $output = $vps->ejecutar_comando($imagesCommand);

        // Parse the output into an array of services
        $lines = explode("\n", trim($output));
        // Remove the header row
        array_shift($lines);

        $servicios = array_map(function($line) {
            $columns = preg_split('/\s{2,}/', $line);
            return [
                'repository' => $columns[0] ?? '',
                'tag' => $columns[1] ?? '',
                'image_id' => $columns[2] ?? '',
                'created' => $columns[3] ?? '',
                'size' => $columns[4] ?? '',
            ];
        }, $lines);

        return view('vps.administrar_servicios', compact('servicios', 'grupo_id', 'vps_id'));

    }

    public function imagenes_instaladas($grupo_id, $vps_id)
    {
        $vps = \App\Models\Servidor::where('id', $vps_id)->first();
        $imagesCommand = "docker images";
        $output = $vps->ejecutar_comando($imagesCommand);

        // Parse the output into an array of services
        $lines = explode("\n", trim($output));
        // Remove the header row
        array_shift($lines);

        $servicios = array_map(function($line) {
            $columns = preg_split('/\s{2,}/', $line);
            return [
                'repository' => $columns[0] ?? '',
                'tag' => $columns[1] ?? '',
                'image_id' => $columns[2] ?? '',
                'created' => $columns[3] ?? '',
                'size' => $columns[4] ?? '',
            ];
        }, $lines);

        return view('vps.servicios_instalados', compact('servicios'));
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

    public function instalar_servicio_docker($grupo_id, $vps_id, $servicio)
    {
        $vps = \App\Models\Servidor::where('id', $vps_id)->first();
        $safeServicio = escapeshellarg($servicio);

        // Pull the specified Docker service
        $pullCommand = "docker pull {$safeServicio}";
        $executionResult = $vps->ejecutar_comando($pullCommand);

        // Fetch list of Docker images
        $imagesCommand = "docker images";
        $output = $vps->ejecutar_comando($imagesCommand);

        // Parse the output into an array of services
        $lines = explode("\n", trim($output));
        // Remove the header row
        array_shift($lines);

        $servicios = array_map(function($line) {
            $columns = preg_split('/\s{2,}/', $line);
            return [
                'repository' => $columns[0] ?? '',
                'tag' => $columns[1] ?? '',
                'image_id' => $columns[2] ?? '',
                'created' => $columns[3] ?? '',
                'size' => $columns[4] ?? '',
            ];
        }, $lines);

        return view('vps.servicios_instalados', compact('servicios'));
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
    public function servicios_docker($grupo_id, $vps_id)
    {
        $vps = \App\Models\Servidor::where('id', $vps_id)->first();
        $command = "docker ps --format 'table {{.ID}}\t{{.Image}}\t{{.Names}}\t{{.Status}}'";
        $executionResult = $vps->ejecutar_comando($command);

        // Split the output into lines
        $lines = explode("\n", trim($executionResult));

        // Start with a style tag to add padding to table headers and other styles
        $styles = '<style>
        .docker-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        .docker-table th {
            background-color: #ff5a5f;
            color: #fff;
            padding: 12px;
            text-align: left;
            font-weight: bold;
            text-transform: uppercase;
        }
        .docker-table td {
            padding: 12px;
            border-bottom: 1px solid #f0f0f0;
        }
        .docker-table tbody tr:last-child td {
            border-bottom: none;
        }
        .docker-table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .docker-table tbody tr:hover {
            background-color: #f1f3f5;
        }
    </style>';

        // Initialize an empty string to hold the HTML table, now with a class for styling
        $htmlTable = $styles . '<table class="docker-table"><thead><tr>';

        // Process the header
        $headers = explode("\t", array_shift($lines));
        foreach ($headers as $header) {
            $htmlTable .= '<th>' . htmlspecialchars($header) . '</th>';
        }
        $htmlTable .= '</tr></thead><tbody>';

        // Process each container's information
        foreach ($lines as $line) {
            $htmlTable .= '<tr>';
            $columns = explode("\t", $line);
            foreach ($columns as $column) {
                $htmlTable .= '<td>' . htmlspecialchars($column) . '</td>';
            }
            $htmlTable .= '</tr>';
        }

        $htmlTable .= '</tbody></table>';

        return $htmlTable;
    }



}
