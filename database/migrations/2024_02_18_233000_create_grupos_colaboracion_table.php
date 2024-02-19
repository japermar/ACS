<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGruposColaboracionTable extends Migration
{
    public function up()
    {
        Schema::create('grupos_colaboracion', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_grupo');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('grupos_colaboracion');
    }
}
