<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAplicacionesDockerTable extends Migration
{
    public function up()
    {
        Schema::create('aplicaciones_docker', function (Blueprint $table) {
            $table->id();
            $table->foreignId('servidor_id')->constrained('servidores');
            $table->string('nombre_app');
            $table->string('version_app')->nullable();
            $table->enum('estado', ['corriendo', 'detenido', 'pausado']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('aplicaciones_docker');
    }
}
