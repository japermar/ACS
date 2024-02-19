<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMiembrosGrupoTable extends Migration
{
    public function up()
    {
        Schema::create('miembros_grupo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grupo_id')->constrained('grupos_colaboracion');
            $table->foreignId('user_id')->constrained('users');
            $table->enum('rol', ['admin', 'monitor', 'editar']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('miembros_grupo');
    }
}
