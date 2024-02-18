<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServidoresTable extends Migration
{
    public function up()
    {
        Schema::create('servidores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grupo_id')->constrained('grupos_colaboracion');
            $table->string('nombre_servidor');
            $table->string('direccion_ssh');
            $table->integer('puerto_ssh');
            $table->string('usuario_ssh');
            $table->string('contrasena_ssh'); // Considera la seguridad de almacenar contraseñas
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('servidores');
    }
}
