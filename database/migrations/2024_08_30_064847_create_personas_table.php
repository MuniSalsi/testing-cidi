<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonasTable extends Migration
{
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('nombre_formateado');
            $table->string('nombre_autopercibido')->nullable();
            $table->string('fecha_nacimiento');
            $table->string('cuil');
            $table->string('cuil_formateado');
            $table->string('estado')->nullable();
            $table->string('telefono_area')->nullable();
            $table->string('telefono_numero')->nullable();
            $table->string('telefono_formateado')->nullable();
            $table->string('celular_area')->nullable();
            $table->string('celular_numero')->nullable();
            $table->string('celular_formateado')->nullable();
            $table->unsignedBigInteger('direccion_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('personas');
    }
}
