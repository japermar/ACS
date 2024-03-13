<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Ssh\Ssh;

class Servidor extends Model
{
    use HasFactory;

    protected $table = 'servidores';

    public function grupoColaboracion()
    {
        return $this->belongsTo(GrupoColaboracion::class, 'grupo_id');
    }

    public function aplicacionesDocker()
    {
        return $this->hasMany(AplicacionDocker::class);
    }

    public function hardwareServidor()
    {
        return $this->hasOne(HardwareServidor::class);
    }

    public function actividades()
    {
        return $this->hasMany(Actividad::class);
    }

    public function ejecutar_comando($comando)
    {
        try {
            $tempFilePath = tempnam(sys_get_temp_dir(), 'ssh_key_');
            file_put_contents($tempFilePath, $this['private_key']);
            chmod($tempFilePath, 0600);
            $conexion = Ssh::create($this['usuario_ssh'], $this['direccion_ssh'])
                ->usePrivateKey($tempFilePath)->disableStrictHostKeyChecking()->execute($comando);
            $conexion->wait();
            $resultado = $conexion->isSuccessful();
            if ($resultado) {
                $mensaje = $conexion->getOutput();
            } else {
                $mensaje = $conexion->getErrorOutput();
            }
        } finally {
            unlink($tempFilePath);
        }
        return $mensaje;
    }

    public function obtenerHardware()
    {
        $cpu = trim($this->ejecutar_comando('lscpu | grep "Model name" | cut -d ":" -f2'));
        $ram = trim($this->ejecutar_comando('free -m | grep Mem | awk \'{print $2 " MB"}\''));
        $almacenamiento = trim($this->ejecutar_comando('df -h / | awk \'NR==2{print $2 " total, " $4 " disponibles"}\''));
        $velocidad_red = trim(rand(100, 999) . ' MB');

        return [$cpu, $ram, $almacenamiento, $velocidad_red];
    }

}
