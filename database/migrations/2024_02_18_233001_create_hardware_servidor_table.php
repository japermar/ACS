<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHardwareServidorTable extends Migration
{
    public function up()
    {
        Schema::create('hardware_servidor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('servidor_id')->constrained('servidores');
            $table->string('cpu');
            $table->string('ram');
            $table->string('almacenamiento');
            $table->string('velocidad_red');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hardware_servidor');
    }
}
