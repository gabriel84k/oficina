<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTikectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tikects', function (Blueprint $table) {
            $table->id();
            $table->integer('estado')->default(1);
            $table->integer('prioridad')->default(0); // [0:baja, 1:media 2:alta 3:urgente]
            $table->timestamps();
        
        /*[  Se crean las restricciones de clave externa -]*/
            $table->bigInteger('cliente_id')->unsigned()->index();
            $table->foreign('cliente_id')->references('id')->on('clientes');

            $table->bigInteger('sistema_id')->unsigned()->index();
            $table->foreign('sistema_id')->references('id')->on('sistemas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aldebaran_tikects');
    }
}
