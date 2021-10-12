<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAldebaranFotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aldebaran_fotos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion');

            # [  Se crean las restricciones de clave externa ]
                $table->bigInteger('aldebaran_ticket_detalle_id')->nullable()->unsigned()->index();
                $table->foreign('aldebaran_ticket_detalle_id')->references('id')->on('aldebaran_ticket_detalles');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aldebaran_fotos');
    }
}
