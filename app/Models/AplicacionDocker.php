<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AplicacionDocker extends Model
{
    use HasFactory;
    protected $table = 'aplicaciones_docker';
public function servidor()
{
return $this->belongsTo(Servidor::class, 'servidor_id');
}
}
