<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function grupos()
    {
        return $this->belongsToMany(
            \App\Models\GruposColaboracion::class, // Adjust the namespace according to your application structure
            'miembros_grupo', // Pivot table name
            'user_id', // Column name in the pivot table referencing the user ID
            'grupo_id' // Column name in the pivot table referencing the group ID
        )->withPivot('rol'); // Include 'rol' or any other columns you need from the pivot table
    }
    public function actividades()
    {
        return $this->hasMany(
            \App\Models\Actividad::class, 'user_id');



    }


}
