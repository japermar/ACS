<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
