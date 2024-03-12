<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MiembroGrupo extends Model
{
    use HasFactory;
    protected $table = 'miembros_grupo';
    public function grupoColaboracion()
    {
        return $this->belongsTo(GruposColaboracion::class, 'grupo_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
