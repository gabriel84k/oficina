<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTurnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shion_turnos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->String('titulo',50);
            $table->String('detalle',50)->nullable();
            $table->String('apellido',50)->nullable();
            $table->String('turno',1)->nullable();
            $table->float('valorturno')->nullable();
            $table->boolean('confirmado')->nullable()->default(false);
            $table->timestamp('fingreso');
            $table->timestamp('fegreso');
            $table->boolean('estado');
            $table->timestamps();

                #[  Se crean las restricciones de clave externa para:usuario_id]
                $table->bigInteger('cliente_id')->nullable()->unsigned()->index();
                $table->foreign('cliente_id')->references('id')->on('clientes');

                $table->bigInteger('user_id')->nullable()->unsigned()->index();
                $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shion_turnos');
    }
}
