<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HardwareServidor extends Model
{
    use HasFactory;
    protected $table = 'hardware_servidor';
    public function servidor()
    {
        return $this->belongsTo(Servidor::class, 'servidor_id');
    }
}
