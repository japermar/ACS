<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class GruposColaboracion extends Model
{
use HasFactory;
    protected $table = 'grupos_colaboracion';
public function servidores()
{
return $this->hasMany(Servidor::class);
}

public function miembrosGrupo()
{
return $this->hasMany(MiembroGrupo::class);
}
}
