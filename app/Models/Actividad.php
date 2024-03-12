<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    use HasFactory;
    protected $table = 'actividades';
public function servidor()
{
return $this->belongsTo(Servidor::class, 'servidor_id');
}

public function user()
{
return $this->belongsTo(User::class, 'user_id');
}
}
